<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Artisan;
use Config;
use DB;
use Exception;
use File;
use Hash;
use Illuminate\Http\Request;
use Log;
use Str;

class InstallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('install.index');
    }

    public function requirement()
    {
        $requirements = $this->checkRequirements();
        return view('install.requirements', compact('requirements'));
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
            ],
            'gd' => [
                'name' => 'GD',
                'check' => extension_loaded('gd'),
                'current' => extension_loaded('gd') ? 'Enabled' : 'Disabled'
            ],
            'curl' => [
                'name' => 'cURL',
                'check' => extension_loaded('curl'),
                'current' => extension_loaded('curl') ? 'Enabled' : 'Disabled'
            ],
            'database' => [
                'name' => 'database',
                'check' => is_writable(base_path('database.sql')),
                'current' => is_writable(base_path('database.sql')) ? 'Writable' : 'Not Writable'
            ],
            'files' => [
                'name' => 'Files',
                'check' => is_writable(base_path('app/Providers/RouteServiceProvider.php')),
                'current' => is_writable(base_path('app/Providers/RouteServiceProvider.php')) ? 'Writable' : 'Not Writable'
            ],
        ];
    }

    public function database()
    {
        return view('install.database');
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
            'db_password' => 'nullable',
            'site_url' => 'required|url',
        ]);

        $this->updateEnvironmentFile($request->all());

        // Reload configuration to use new database settings
        $this->setDatabaseConfig($request->all());

        // drop database
        $this->dropTables();

        // Upload database
        $this->importSql();

        return to_route('install.settings.show');
    }

    public function setting()
    {
        return view('install.environment');
    }

    public function complete(Request $request)
    {
        $request->validate([
            'admin_email' => 'required|email',
            'admin_password' => 'required|min:8',
        ]);

        try {
            // Create admin user if provided
            $adminCreated = false;
            if ($request->admin_email && $request->admin_password) {
                try {
                    $this->createAdminUser($request->admin_email, $request->admin_password);
                    $adminCreated = true;
                    Log::info('Admin user created successfully');
                } catch (Exception $e) {
                    \Log::error('Failed to create admin user: ' . $e->getMessage());

                    return redirect()->route('install.settings.show')->withErrors(['error' => 'Failed to create admin user: ' . $e->getMessage()])->withInput();
                }
            }

            Log::info('Installation almost complete');
            try {
                // Clear and cache configurations
                Artisan::call('config:clear');
                Artisan::call('cache:clear');
                Artisan::call('route:clear');
                Artisan::call('view:clear');
                Artisan::call('config:cache');
            } catch (Exception $e) {
                // Config cache might fail in some environments
                \Log::warning('Config cache failed: ' . $e->getMessage());
            }

            // Mark installation as complete
            $this->markInstallationComplete();

            // Store success information in session for completion page
            session(['installer_complete' => true, 'admin_created' => $adminCreated]);

            return view('install.compete');
        } catch (Exception $e) {
            \Log::error('Installation failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Installation failed: ' . $e->getMessage()]);
        }
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
            '/^APP_URL=.*$/m' => 'APP_URL="' . $config['site_url'] . '"',
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

    private function generateAppKey()
    {
        return 'base64:' . base64_encode(Str::random(32));
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

    /**
     * Import the Database
     *
     * @return bool|string
     */
    private function importSql()
    {
        $sql_path = base_path('database.sql');
        try {
            DB::unprepared(file_get_contents($sql_path));
        } catch (\Exception $e) {
            \Log::error('Database import failed: ' . $e->getMessage());
            // throw new Exception($e->getMessage());
        }
    }

    private function dropTables()
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');

            $tables = DB::select('SHOW TABLES');
            $dbNameKey = 'Tables_in_' . DB::getDatabaseName();

            foreach ($tables as $table) {
                $tableName = $table->$dbNameKey;
                DB::statement("DROP TABLE IF EXISTS `$tableName`");
            }

            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        } catch (\Exception $e) {
            \Log::error('Failed to drop tables: ' . $e->getMessage());
        }
    }


    private function createAdminUser($email, $password)
    {
        try {
            // Check if user exists
            $user = User::where('email', $email)->first();

            if ($user) {
                // Update password only
                $user->password = bcrypt($password);
                $user->save();
            } else {
                // Create new admin user
                User::create([
                    'name' => 'Admin User',
                    'fname' => 'Admin',
                    'lname' => 'User',
                    'username' => 'admin' . Str::random(4),
                    'user_role' => 'admin',
                    'email_verify' => 1,
                    'email' => $email,
                    'password' => bcrypt($password),
                    'email_verified_at' => now(),
                ]);
            }
        } catch (Exception $e) {
            Log::error('Failed to create admin user: ' . $e->getMessage());
            throw new Exception('Failed to create admin user: ' . $e->getMessage());
        }
    }

    private function markInstallationComplete()
    {
        $url = request()->getSchemeAndHttpHost();
        File::put(storage_path('telementry'), $url);
        $this->writeUrlToServicesConfig($url);
        $oldsp = base_path('app/Providers/RouteServiceProvider.php');
        copy($this->install_files('RouteServiceProvider.php'), $oldsp);
    }

    protected function writeUrlToServicesConfig($url)
    {
        $configPath = config_path('services.php');

        if (!file_exists($configPath)) {
            throw new \Exception("Config file not found.");
        }

        $configContent = file_get_contents($configPath);

        if (str_contains($configContent, "'something' =>")) {
            $configContent = preg_replace(
                "/('something'\s*=>\s*)['\"][^'\"]*['\"]/",
                "'something' => '" . addslashes($url) . "'",
                $configContent
            );
        } else {
            $configContent = preg_replace(
                '/\];\s*$/',
                "    'something' => '" . addslashes($url) . "',\n];",
                $configContent
            );
        }

        file_put_contents($configPath, $configContent);
    }


    public function install_files($name)
    {
        $file = base_path('storage/install/' . $name);

        return $file;
    }
}
