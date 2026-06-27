<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use PDO;

class DatabaseBackup extends Command
{
    protected $signature = 'ldb:backup
        {--connection= : Nom de la connexion DB (défaut: DB_CONNECTION)}
        {--keep=30 : Nombre de backups à conserver}';

    protected $description = 'Crée une sauvegarde de la base de données';

    public function handle(): int
    {
        $connection = $this->option('connection') ?? config('database.default');
        $config = config("database.connections.{$connection}");
        $driver = $config['driver'] ?? 'mysql';

        $disk = Storage::build([
            'driver' => 'local',
            'root' => storage_path('app/backups'),
        ]);

        if (!$disk->exists('')) {
            $disk->makeDirectory('');
        }

        $timestamp = now()->format('Y-m-d-Hi');
        $filename = "ldb-{$timestamp}.sql.gz";
        $path = storage_path("app/backups/{$filename}");

        if ($driver === 'mysql' || $driver === 'mariadb') {
            $success = $this->mysqlDump($config, $path);
        } elseif ($driver === 'sqlite') {
            $success = $this->sqliteCopy($config, $path);
        } else {
            $this->error("Driver «{$driver}» non supporté.");
            return self::FAILURE;
        }

        if (!$success) {
            return self::FAILURE;
        }

        $size = $disk->size($filename);
        $this->info("Backup créé : {$filename} (" . round($size / 1024, 1) . " KB)");

        $this->pruneOld($disk, (int) $this->option('keep'));

        return self::SUCCESS;
    }

    private function mysqlDump(array $config, string $path): bool
    {
        $host = $config['host'] ?? '127.0.0.1';
        $port = $config['port'] ?? '3306';
        $database = $config['database'] ?? '';
        $username = $config['username'] ?? '';
        $password = $config['password'] ?? '';

        // Try mysqldump first
        if (function_exists('exec')) {
            $cmd = sprintf(
                'mysqldump --host=%s --port=%s --user=%s --password=%s --single-transaction --routines --triggers %s 2>&1 | gzip > %s',
                escapeshellarg($host),
                escapeshellarg((string) $port),
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($database),
                escapeshellarg($path)
            );

            $output = null;
            $exitCode = null;
            exec($cmd, $output, $exitCode);

            if ($exitCode === 0) {
                return true;
            }
            $this->warn("mysqldump indisponible (code {$exitCode}), fallback PHP...");
        } else {
            $this->warn("exec() désactivé, fallback PHP...");
        }

        // Fallback : dump pure-PHP via PDO
        return $this->phpDump($config, $path);
    }

    private function phpDump(array $config, string $path): bool
    {
        try {
            $host = $config['host'] ?? '127.0.0.1';
            $port = $config['port'] ?? '3306';
            $database = $config['database'] ?? '';
            $username = $config['username'] ?? '';
            $password = $config['password'] ?? '';

            $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";
            $pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);

            $sql = "-- Backup généré le " . now() . "\n-- Base : {$database}\n\n";
            $sql .= "SET NAMES utf8mb4;\n\n";

            // Récupérer toutes les tables
            $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

            foreach ($tables as $table) {
                // CREATE TABLE
                $create = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(PDO::FETCH_ASSOC);
                $sql .= "\nDROP TABLE IF EXISTS `{$table}`;\n";
                $sql .= $create['Create Table'] . ";\n\n";

                // INSERT
                $rows = $pdo->query("SELECT * FROM `{$table}`")->fetchAll(PDO::FETCH_ASSOC);
                if (empty($rows)) continue;

                $columns = array_keys($rows[0]);
                $cols = implode('`, `', $columns);
                $sql .= "INSERT INTO `{$table}` (`{$cols}`) VALUES\n";

                $values = [];
                foreach ($rows as $row) {
                    $escaped = array_map(fn($v) => $v === null ? 'NULL' : $pdo->quote($v), $row);
                    $values[] = '(' . implode(', ', $escaped) . ')';
                }
                $sql .= implode(",\n", $values) . ";\n\n";
            }

            // Gzipper
            $gz = gzopen($path, 'w9');
            if (!$gz) {
                $this->error("Impossible d'écrire {$path}");
                return false;
            }
            gzwrite($gz, $sql);
            gzclose($gz);

            return true;
        } catch (\Throwable $e) {
            $this->error("Échec du dump PHP : " . $e->getMessage());
            return false;
        }
    }

    private function sqliteCopy(array $config, string $path): bool
    {
        $database = $config['database'] ?? database_path('database.sqlite');

        if (!file_exists($database)) {
            $this->error("Fichier SQLite introuvable : {$database}");
            return false;
        }

        $gz = gzopen($path, 'w9');
        if (!$gz) {
            $this->error("Impossible d'ouvrir {$path} en écriture");
            return false;
        }

        gzwrite($gz, file_get_contents($database));
        gzclose($gz);

        return true;
    }

    private function pruneOld($disk, int $keep): void
    {
        $files = collect($disk->files())
            ->filter(fn($f) => str_starts_with($f, 'ldb-') && str_ends_with($f, '.sql.gz'))
            ->sort()
            ->values();

        $toDelete = $files->slice(0, max(0, $files->count() - $keep));

        foreach ($toDelete as $file) {
            $disk->delete($file);
            $this->line("  Nettoyé : {$file}");
        }
    }
}
