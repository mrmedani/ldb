<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
