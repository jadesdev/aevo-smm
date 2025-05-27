<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Exception;

class InstallerController extends Controller
{
    public function welcome()
    {
        return view('installer.welcome');
    }

    public function requirements()
    {
        $requirements = $this->checkRequirements();
        return view('installer.requirements', compact('requirements'));
    }

    public function database()
    {
        return view('installer.database');
    }

    public function testDatabase(Request $request)
    {
        $request->validate([
            'db_host' => 'required',
            'db_port' => 'required|numeric',
            'db_name' => 'required',
            'db_username' => 'required',
            'db_password' => 'nullable'
        ]);

        try {
            $connection = new \PDO(
                "mysql:host={$request->db_host};port={$request->db_port};dbname={$request->db_name}",
                $request->db_username,
                $request->db_password
            );
            
            return response()->json(['success' => true, 'message' => 'Database connection successful!']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
        }
    }

    public function environment(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string',
            'db_host' => 'required',
            'db_port' => 'required|numeric',
            'db_name' => 'required',
            'db_username' => 'required',
            'db_password' => 'nullable'
        ]);

        session([
            'installer' => [
                'app_name' => $request->app_name,
                'db_host' => $request->db_host,
                'db_port' => $request->db_port,
                'db_name' => $request->db_name,
                'db_username' => $request->db_username,
                'db_password' => $request->db_password,
            ]
        ]);

        return view('installer.environment');
    }

    public function install(Request $request)
    {
        $request->validate([
            'admin_email' => 'nullable|email',
            'admin_password' => 'nullable|min:8',
        ]);

        try {
            $config = session('installer');
            
            if (!$config) {
                return redirect()->route('installer.database')->withErrors(['error' => 'Session expired. Please start over.']);
            }
            
            // Update environment file
            $this->updateEnvironmentFile($config);
            
            // Reload configuration to use new database settings
            $this->setDatabaseConfig($config);
            
            // Test database connection before proceeding
            DB::connection()->getPdo();
            
            // Run migrations
            Artisan::call('migrate', ['--force' => true]);
            
            // Seed database if requested
            if ($request->seed_database) {
                try {
                    Artisan::call('db:seed', ['--force' => true]);
                } catch (Exception $e) {
                    // Continue even if seeding fails
                    \Log::warning('Database seeding failed: ' . $e->getMessage());
                }
            }
            
            // Create admin user if provided
            $adminCreated = false;
            if ($request->admin_email && $request->admin_password) {
                try {
                    $this->createAdminUser($request->admin_email, $request->admin_password);
                    $adminCreated = true;
                } catch (Exception $e) {
                    return back()->withErrors(['error' => 'Failed to create admin user: ' . $e->getMessage()]);
                }
            }
            
            // Clear and cache configurations
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            
            try {
                Artisan::call('config:cache');
            } catch (Exception $e) {
                // Config cache might fail in some environments
                \Log::warning('Config cache failed: ' . $e->getMessage());
            }
            
            // Create storage link
            try {
                if (!file_exists(public_path('storage'))) {
                    Artisan::call('storage:link');
                }
            } catch (Exception $e) {
                \Log::warning('Storage link creation failed: ' . $e->getMessage());
            }
            
            // Mark installation as complete
            $this->markInstallationComplete();
            
            // Store success information in session for completion page
            session(['installer_complete' => true, 'admin_created' => $adminCreated]);
            
            // Clear installer session data
            session()->forget('installer');
            
            return view('installer.complete');
            
        } catch (Exception $e) {
            \Log::error('Installation failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Installation failed: ' . $e->getMessage()]);
        }
    }

    private function checkRequirements()
    {
        return [
            'php_version' => [
                'name' => 'PHP Version (>= 8.1)',
                'check' => version_compare(PHP_VERSION, '8.1.0', '>='),
                'current' => PHP_VERSION
            ],
            'openssl' => [
                'name' => 'OpenSSL Extension',
                'check' => extension_loaded('openssl'),
                'current' => extension_loaded('openssl') ? 'Enabled' : 'Disabled'
            ],
            'pdo' => [
                'name' => 'PDO Extension',
                'check' => extension_loaded('pdo'),
                'current' => extension_loaded('pdo') ? 'Enabled' : 'Disabled'
            ],
            'mbstring' => [
                'name' => 'Mbstring Extension',
                'check' => extension_loaded('mbstring'),
                'current' => extension_loaded('mbstring') ? 'Enabled' : 'Disabled'
            ],
            'tokenizer' => [
                'name' => 'Tokenizer Extension',
                'check' => extension_loaded('tokenizer'),
                'current' => extension_loaded('tokenizer') ? 'Enabled' : 'Disabled'
            ],
            'xml' => [
                'name' => 'XML Extension',
                'check' => extension_loaded('xml'),
                'current' => extension_loaded('xml') ? 'Enabled' : 'Disabled'
            ],
            'storage_writable' => [
                'name' => 'Storage Directory Writable',
                'check' => is_writable(storage_path()),
                'current' => is_writable(storage_path()) ? 'Writable' : 'Not Writable'
            ],
            'bootstrap_cache_writable' => [
                'name' => 'Bootstrap Cache Writable',
                'check' => is_writable(base_path('bootstrap/cache')),
                'current' => is_writable(base_path('bootstrap/cache')) ? 'Writable' : 'Not Writable'
            ]
        ];
    }

    private function setDatabaseConfig($config)
    {
        Config::set('database.connections.mysql.host', $config['db_host']);
        Config::set('database.connections.mysql.port', $config['db_port']);
        Config::set('database.connections.mysql.database', $config['db_name']);
        Config::set('database.connections.mysql.username', $config['db_username']);
        Config::set('database.connections.mysql.password', $config['db_password']);
        
        // Clear the connection to force reconnection with new settings
        DB::purge('mysql');
    }

    private function updateEnvironmentFile($config)
    {
        $envPath = base_path('.env');
        
        if (!File::exists($envPath)) {
            if (File::exists(base_path('.env.example'))) {
                File::copy(base_path('.env.example'), $envPath);
            } else {
                // Create a basic .env file if .env.example doesn't exist
                $this->createBasicEnvFile($envPath);
            }
        }
        
        $envContent = File::get($envPath);
        
        // Define all the replacements we need to make
        $replacements = [
            '/^APP_NAME=.*$/m' => 'APP_NAME="' . $config['app_name'] . '"',
            '/^APP_KEY=.*$/m' => 'APP_KEY=' . $this->generateAppKey(),
            '/^DB_HOST=.*$/m' => 'DB_HOST=' . $config['db_host'],
            '/^DB_PORT=.*$/m' => 'DB_PORT=' . $config['db_port'],
            '/^DB_DATABASE=.*$/m' => 'DB_DATABASE=' . $config['db_name'],
            '/^DB_USERNAME=.*$/m' => 'DB_USERNAME=' . $config['db_username'],
            '/^DB_PASSWORD=.*$/m' => 'DB_PASSWORD="' . $config['db_password'] . '"',
        ];
        
        foreach ($replacements as $pattern => $replacement) {
            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                // If the line doesn't exist, add it
                $key = explode('=', $replacement)[0];
                if (!preg_match('/^' . preg_quote($key) . '=/m', $envContent)) {
                    $envContent .= "\n" . $replacement;
                }
            }
        }
        
        // Add installation flag if it doesn't exist
        if (!preg_match('/^APP_INSTALLED=/m', $envContent)) {
            $envContent .= "\nAPP_INSTALLED=true\n";
        } else {
            $envContent = preg_replace('/^APP_INSTALLED=.*$/m', 'APP_INSTALLED=true', $envContent);
        }
        
        File::put($envPath, $envContent);
    }

    private function createBasicEnvFile($envPath)
    {
        $basicEnv = "APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=\"hello@example.com\"
MAIL_FROM_NAME=\"\${APP_NAME}\"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY=\"\${PUSHER_APP_KEY}\"
VITE_PUSHER_HOST=\"\${PUSHER_HOST}\"
VITE_PUSHER_PORT=\"\${PUSHER_PORT}\"
VITE_PUSHER_SCHEME=\"\${PUSHER_SCHEME}\"
VITE_PUSHER_APP_CLUSTER=\"\${PUSHER_APP_CLUSTER}\"
";
        File::put($envPath, $basicEnv);
    }

    private function generateAppKey()
    {
        return 'base64:' . base64_encode(Str::random(32));
    }

    private function createAdminUser($email, $password)
    {
        // This assumes you have a User model with standard fields
        // Adjust according to your User model structure
        try {
            \App\Models\User::create([
                'name' => 'Administrator',
                'email' => $email,
                'password' => bcrypt($password),
                'email_verified_at' => now(),
            ]);
        } catch (Exception $e) {
            // Handle user creation error if needed
            throw new Exception('Failed to create admin user: ' . $e->getMessage());
        }
    }

    private function markInstallationComplete()
    {
        // Create installation marker file
        File::put(storage_path('installed'), date('Y-m-d H:i:s'));
        
        // Update .env with installation flag (already done in updateEnvironmentFile)
        // You could also create a database record or other marker
    }
}
