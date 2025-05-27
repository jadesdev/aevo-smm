<?php

namespace App\Http\Controllers;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('install.index');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function requirement()
    {
        $requirements = $this->checkRequirements();
        return view('install.requirements', compact('requirements'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function database()
    {
        return view('install.database');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function testDatabase(Request $request)
    {
        $request->validate([
            'db_host' => 'required|string',
            'db_port' => 'required|numeric',
            'db_name' => 'required|string',
            'db_username' => 'required|string',
        ]);

        Config::set('database.connections.mysql_test', [
            'driver' => 'mysql',
            'host' => $request->db_host,
            'port' => $request->db_port,
            'database' => $request->db_name,
            'username' => $request->db_username,
            'password' => $request->db_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([\PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA')]) : [],
        ]);

        try {
            DB::connection('mysql_test')->getPdo();
            return response()->json(['success' => true, 'message' => 'Database connection successful!']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
        } finally {
            DB::purge('mysql_test');
            Config::offsetUnset('database.connections.mysql_test');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function environment(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'db_host' => 'required|string',
            'db_port' => 'required|numeric',
            'db_name' => 'required|string',
            'db_username' => 'required|string',
        ]);
        Log::info('Received request at ' . now()->toDateTimeString());

        try {
            $this->updateEnvironmentFile($request->all());
            Log::info('Received request2 at ' . now()->toDateTimeString());
            $this->setDatabaseConfig($request->all());
            Log::info('Received request3 at ' . now()->toDateTimeString());
            $this->importSql();
            return 'Environment updated successfully!';
            return redirect()->route('install.settings.show');
        } catch (Exception $e) {
            Log::error('Installation - Database/Environment setup failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Database or Environment setup failed: ' . $e->getMessage()]);
        }
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function setting()
    {
        return view('install.environment');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function complete(Request $request)
    {
        $request->validate([
            'admin_email' => 'required|email|max:255',
            'admin_password' => 'required|min:8',
        ]);

        try {
            if (!Config::get('database.connections.mysql.host')) {
                $this->setDatabaseConfig([
                    'db_host' => env('DB_HOST'),
                    'db_port' => env('DB_PORT'),
                    'db_name' => env('DB_DATABASE'),
                    'db_username' => env('DB_USERNAME'),
                    'db_password' => env('DB_PASSWORD'),
                ]);
            }

            $this->createAdminUser($request->admin_email, $request->admin_password);
            Log::info('Admin user created/updated successfully.');

            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            try {
                Artisan::call('config:cache');
            } catch (Exception $e) {
                Log::warning('Config cache failed during installation: ' . $e->getMessage());
            }

            $this->markInstallationComplete();
            Log::info('Installation marked as complete.');

            return view('install.complete');
        } catch (Exception $e) {
            Log::error('Installation - Final step failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput($request->except('admin_password'))
                ->withErrors(['error' => 'Installation failed: ' . $e->getMessage()]);
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
                'name' => 'Storage Directory Writable (storage/)',
                'check' => is_writable(storage_path()),
                'current' => is_writable(storage_path()) ? 'Writable' : 'Not Writable'
            ],
            'bootstrap_cache_writable' => [
                'name' => 'Bootstrap Cache Writable (bootstrap/cache)',
                'check' => is_writable(base_path('bootstrap/cache')),
                'current' => is_writable(base_path('bootstrap/cache')) ? 'Writable' : 'Not Writable'
            ],
            'gd' => [
                'name' => 'GD Extension',
                'check' => extension_loaded('gd'),
                'current' => extension_loaded('gd') ? 'Enabled' : 'Disabled'
            ],
            'curl' => [
                'name' => 'cURL Extension',
                'check' => extension_loaded('curl'),
                'current' => extension_loaded('curl') ? 'Enabled' : 'Disabled'
            ],
            'database_sql_readable' => [
                'name' => 'Database File (database.sql)',
                'check' => is_readable(base_path('database.sql')),
                'current' => is_readable(base_path('database.sql')) ? 'Readable' : 'Not Readable/Not Found'
            ],
            'route_service_provider_writable' => [
                'name' => 'RouteServiceProvider Writable ',
                'check' => is_writable(base_path('app/Providers/RouteServiceProvider.php')),
                'current' => is_writable(base_path('app/Providers/RouteServiceProvider.php')) ? 'Writable' : 'Not Writable'
            ],
            'install_files_dir_readable' => [
                'name' => 'Install Files Source Readable ',
                'check' => is_readable(base_path('storage/install/RouteServiceProvider.php')),
                'current' => is_readable(base_path('storage/install/RouteServiceProvider.php')) ? 'Readable' : 'Not Readable/Not Found'
            ],
        ];
    }

    private function updateEnvironmentFile($config)
    {
        $envPath = base_path('.env');
        if (!File::exists($envPath)) {
            if (File::exists(base_path('.env.example'))) {
                File::copy(base_path('.env.example'), $envPath);
            } else {
                $basicEnvContent = "APP_NAME=\"Laravel\"\nAPP_ENV=local\nAPP_KEY=\nAPP_DEBUG=true\nAPP_URL=http://localhost\n\nLOG_CHANNEL=stack\nDB_CONNECTION=mysql\nDB_HOST=127.0.0.1\nDB_PORT=3306\nDB_DATABASE=laravel\nDB_USERNAME=root\nDB_PASSWORD=\n";
                File::put($envPath, $basicEnvContent);
            }
        }

        $envContent = File::get($envPath);
        $appKey = preg_match('/^APP_KEY=(.*)$/m', $envContent, $matches) && $matches[1] !== '' ? $matches[1] : $this->generateAppKey();

        $replacements = [
            '/^APP_NAME=.*$/m' => 'APP_NAME="' . $config['app_name'] . '"',
            '/^APP_KEY=.*$/m' => 'APP_KEY=' . $appKey,
            // '/^APP_ENV=.*$/m' => 'APP_ENV=production',
            // '/^APP_DEBUG=.*$/m' => 'APP_DEBUG=false',
            '/^DB_HOST=.*$/m' => 'DB_HOST=' . $config['db_host'],
            '/^DB_PORT=.*$/m' => 'DB_PORT=' . $config['db_port'],
            '/^DB_DATABASE=.*$/m' => 'DB_DATABASE=' . $config['db_name'],
            '/^DB_USERNAME=.*$/m' => 'DB_USERNAME=' . $config['db_username'],
            '/^DB_PASSWORD=.*$/m' => 'DB_PASSWORD="' . ($config['db_password'] ?? '') . '"',
        ];

        foreach ($replacements as $pattern => $replacement) {
            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                $key = explode('=', $replacement)[0];
                if ($key !== 'APP_KEY' && !preg_match('/^' . preg_quote($key) . '=/m', $envContent)) {
                    $envContent .= "\n" . $replacement;
                }
            }
        }

        if (!preg_match('/^APP_KEY=/m', $envContent)) {
            $envContent .= "\nAPP_KEY=" . $this->generateAppKey();
        } elseif (preg_match('/^APP_KEY=\s*$/m', $envContent)) {
            $envContent = preg_replace('/^APP_KEY=\s*$/m', 'APP_KEY=' . $this->generateAppKey(), $envContent);
        }

        if (!preg_match('/^APP_INSTALLED=/m', $envContent)) {
            $envContent .= "\nAPP_INSTALLED=true\n";
        } else {
            $envContent = preg_replace('/^APP_INSTALLED=.*$/m', 'APP_INSTALLED=true', $envContent);
        }

        if (!File::put($envPath, $envContent)) {
            throw new Exception("Failed to write to .env file. Check permissions for: " . $envPath);
        }
    }

    private function generateAppKey()
    {
        return 'base64:' . base64_encode(Str::random(32));
    }

    private function setDatabaseConfig($config)
    {
        $dbHost = $config['db_host'] ?? env('DB_HOST', '127.0.0.1');
        $dbPort = $config['db_port'] ?? env('DB_PORT', '3306');
        $dbName = $config['db_name'] ?? env('DB_DATABASE');
        $dbUser = $config['db_username'] ?? env('DB_USERNAME');
        $dbPass = $config['db_password'] ?? env('DB_PASSWORD');

        if (empty($dbName) || empty($dbUser)) {
            Log::warning('Attempted to set database config with incomplete credentials.');
            return;
        }

        Config::set('database.connections.mysql.host', $dbHost);
        Config::set('database.connections.mysql.port', $dbPort);
        Config::set('database.connections.mysql.database', $dbName);
        Config::set('database.connections.mysql.username', $dbUser);
        Config::set('database.connections.mysql.password', $dbPass);
        Config::set('database.default', 'mysql');

        DB::purge('mysql');
        DB::reconnect('mysql');
    }

    private function importSql()
    {
        Log::info('Importing database.sql... at ' . now()->toDateTimeString());
       
        $sql_path = base_path('database.sql');
        if (!File::exists($sql_path) || !File::isReadable($sql_path)) {
            throw new Exception('Database SQL file (database.sql) not found or not readable.');
        }
        try {
            // $this->dropTables();
            DB::unprepared(File::get($sql_path));
        } catch (Exception $e) {
            Log::error('Database import failed: ' . $e->getMessage());
            throw new Exception('Database import failed: ' . $e->getMessage() . '. Check database.sql syntax and database permissions.');
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
            Log::info('All tables dropped successfully.');
        } catch (Exception $e) {
            Log::error('Failed to drop tables: ' . $e->getMessage());
        }
    }

    private function createAdminUser($email, $password)
    {
        try {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->password = Hash::make($password);
                $user->role = 'admin';
                $user->email_verified_at = now();
                $user->save();
            } else {
                $user = new User();
                $user->fname = 'Admin';
                $user->lname = 'User';
                $user->username = 'admin_' . Str::random(5);
                $user->role = 'admin';
                $user->email_verify = 1;
                $user->email = $email;
                $user->password = Hash::make($password);
                $user->email_verified_at = now();
                $user->save();
            }
        } catch (Exception $e) {
            Log::error('Failed to create/update admin user: ' . $e->getMessage());
            throw new Exception('Failed to create or update admin user: ' . $e->getMessage());
        }
    }

    private function markInstallationComplete()
    {
        $installedPath = storage_path('installed');
        if (!File::put($installedPath, date('Y-m-d H:i:s'))) {
            throw new Exception("Failed to create installation marker file at {$installedPath}. Check permissions for storage/ directory.");
        }

        $sourceRsp = $this->install_files('RouteServiceProvider.php');
        $destinationRsp = base_path('app/Providers/RouteServiceProvider.php');

        if (!File::exists($sourceRsp)) {
            throw new Exception("Source RouteServiceProvider.php not found at {$sourceRsp}.");
        }
        if (!is_writable(dirname($destinationRsp)) || (File::exists($destinationRsp) && !is_writable($destinationRsp))) {
            throw new Exception("Destination RouteServiceProvider.php or its directory is not writable: {$destinationRsp}.");
        }
        if (!File::copy($sourceRsp, $destinationRsp)) {
            throw new Exception("Failed to copy RouteServiceProvider.php from {$sourceRsp} to {$destinationRsp}.");
        }
    }

    public function install_files($name)
    {
        return base_path('storage/install/' . $name);
    }
}
