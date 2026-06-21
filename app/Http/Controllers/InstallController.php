<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class InstallController extends Controller
{
    public function index()
    {
        if ($this->alreadyInstalled()) {
            return redirect()->route('login');
        }

        $checks = $this->runChecks();

        return view('install.index', compact('checks'));
    }

    public function database()
    {
        if ($this->alreadyInstalled()) {
            return redirect()->route('login');
        }

        $checks = $this->runChecks();
        $dbStatus = $this->checkDatabase();

        return view('install.database', compact('checks', 'dbStatus'));
    }

    public function runMigration()
    {
        if ($this->alreadyInstalled()) {
            return redirect()->route('login');
        }

        try {
            Artisan::call('migrate', ['--force' => true]);
            $migrationOutput = Artisan::output();

            Artisan::call('db:seed', ['--force' => true]);
            $seedOutput = Artisan::output();

            return redirect()->route('install.admin')
                ->with('success', 'Base de données installée avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('install.database')
                ->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    public function admin()
    {
        if ($this->alreadyInstalled()) {
            return redirect()->route('login');
        }

        return view('install.admin');
    }

    public function saveAdmin(Request $request)
    {
        if ($this->alreadyInstalled()) {
            return redirect()->route('login');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            DB::table('users')->truncate();
            DB::table('users')->insert([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->createLockFile();

            return redirect()->route('install.complete')
                ->with('email', $data['email'])
                ->with('password', $data['password']);
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    public function complete()
    {
        return view('install.complete');
    }

    private function alreadyInstalled(): bool
    {
        return file_exists(storage_path('installed')) || 
               (file_exists(base_path('.env')) && 
                DB::connection()->getDatabaseName() &&
                !empty(config('app.key')));
    }

    private function createLockFile(): void
    {
        file_put_contents(storage_path('installed'), date('Y-m-d H:i:s'));
    }

    private function runChecks(): array
    {
        $requirements = [
            'php_version' => [
                'label' => 'PHP >= 8.3',
                'passed' => version_compare(PHP_VERSION, '8.3.0', '>='),
                'value' => PHP_VERSION,
            ],
            'pdo' => [
                'label' => 'Extension PDO',
                'passed' => extension_loaded('pdo'),
            ],
            'pdo_mysql' => [
                'label' => 'Extension PDO MySQL',
                'passed' => extension_loaded('pdo_mysql'),
            ],
            'mbstring' => [
                'label' => 'Extension mbstring',
                'passed' => extension_loaded('mbstring'),
            ],
            'bcmath' => [
                'label' => 'Extension BCMath',
                'passed' => extension_loaded('bcmath'),
            ],
            'openssl' => [
                'label' => 'Extension OpenSSL',
                'passed' => extension_loaded('openssl'),
            ],
            'tokenizer' => [
                'label' => 'Extension Tokenizer',
                'passed' => extension_loaded('tokenizer'),
            ],
            'xml' => [
                'label' => 'Extension XML',
                'passed' => extension_loaded('xml'),
            ],
            'ctype' => [
                'label' => 'Extension Ctype',
                'passed' => extension_loaded('ctype'),
            ],
            'json' => [
                'label' => 'Extension JSON',
                'passed' => extension_loaded('json'),
            ],
            'fileinfo' => [
                'label' => 'Extension Fileinfo',
                'passed' => extension_loaded('fileinfo'),
            ],
            'gd' => [
                'label' => 'Extension GD',
                'passed' => extension_loaded('gd'),
            ],
            'zip' => [
                'label' => 'Extension Zip',
                'passed' => extension_loaded('zip'),
            ],
        ];

        $permissions = [
            'storage' => [
                'label' => 'storage/ (écriture)',
                'passed' => is_writable(storage_path()),
            ],
            'bootstrap_cache' => [
                'label' => 'bootstrap/cache/ (écriture)',
                'passed' => is_writable(base_path('bootstrap/cache')),
            ],
            'env' => [
                'label' => '.env (présent)',
                'passed' => file_exists(base_path('.env')),
            ],
        ];

        return compact('requirements', 'permissions');
    }

    private function checkDatabase(): array
    {
        $db = config('database.default');
        $connection = config("database.connections.$db");

        $checks = [
            'driver' => [
                'label' => 'Connexion DB',
                'passed' => false,
                'value' => $db,
            ],
            'host' => [
                'label' => 'Hôte',
                'passed' => !empty($connection['host'] ?? ''),
                'value' => $connection['host'] ?? '',
            ],
            'database' => [
                'label' => 'Base de données',
                'passed' => !empty($connection['database'] ?? ''),
                'value' => $connection['database'] ?? '',
            ],
        ];

        try {
            DB::connection()->getPdo();
            $checks['driver']['passed'] = true;
        } catch (\Exception $e) {
            $checks['driver']['error'] = $e->getMessage();
        }

        return $checks;
    }
}
