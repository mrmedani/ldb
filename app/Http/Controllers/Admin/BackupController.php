<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        $disk = Storage::build([
            'driver' => 'local',
            'root' => storage_path('app/backups'),
        ]);

        $files = collect($disk->files())
            ->filter(fn($f) => str_starts_with($f, 'ldb-') && str_ends_with($f, '.sql.gz'))
            ->map(fn($f) => [
                'name' => $f,
                'size' => $disk->size($f),
                'last_modified' => $disk->lastModified($f),
            ])
            ->sortByDesc('last_modified')
            ->values();

        return view('admin.backups.index', compact('files'));
    }

    public function restore(Request $request)
    {
        $request->validate([
            'backup' => 'required|file|mimes:sql,gz,gzip|max:204800',
        ]);

        $file = $request->file('backup');
        $content = file_get_contents($file->getRealPath());

        // Décompresser si gzippé
        if ($file->getClientOriginalExtension() === 'gz' || $file->getMimeType() === 'application/gzip') {
            $decoded = gzdecode($content);
            if ($decoded === false) {
                return redirect()->route('admin.backups')
                    ->with('error', 'Impossible de décompresser le fichier.');
            }
            $content = $decoded;
        }

        try {
            DB::beginTransaction();

            // Désactiver les contraintes
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');

            // Exécuter chaque requête SQL
            $statements = explode(";\n", $content);
            foreach ($statements as $statement) {
                $statement = trim($statement);
                if (!empty($statement)) {
                    DB::statement($statement);
                }
            }

            // Réactiver les contraintes
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');

            DB::commit();

            // Vider le cache
            try {
                \Illuminate\Support\Facades\Artisan::call('optimize:clear');
            } catch (\Throwable $e) {
                // Ignorer si la commande échoue
            }

            return redirect()->route('admin.backups')
                ->with('success', 'Base de données restaurée avec succès.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('admin.backups')
                ->with('error', 'Erreur lors de la restauration : ' . $e->getMessage());
        }
    }

    public function destroy(string $filename)
    {
        $path = storage_path('app/backups/' . basename($filename));

        if (!file_exists($path)) {
            return redirect()->route('admin.backups')
                ->with('error', 'Sauvegarde introuvable.');
        }

        unlink($path);

        return redirect()->route('admin.backups')
            ->with('success', 'Sauvegarde supprimée.');
    }

    public function download(string $filename)
    {
        $path = storage_path('app/backups/' . basename($filename));

        if (!file_exists($path)) {
            abort(404, 'Sauvegarde introuvable.');
        }

        return response()->download($path);
    }

    public function run()
    {
        try {
            $exitCode = \Illuminate\Support\Facades\Artisan::call('ldb:backup');

            $message = $exitCode === 0
                ? 'Sauvegarde créée avec succès.'
                : 'Erreur lors de la création de la sauvegarde : ' . \Illuminate\Support\Facades\Artisan::output();

            return redirect()->route('admin.backups')
                ->with($exitCode === 0 ? 'success' : 'error', $message);
        } catch (\Throwable $e) {
            return redirect()->route('admin.backups')
                ->with('error', 'Erreur serveur : ' . $e->getMessage());
        }
    }
}
