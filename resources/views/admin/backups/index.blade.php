@extends('admin.layouts.admin')
@section('title', 'Sauvegardes')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-extrabold text-text">Sauvegardes de la base</h1>
                <p class="text-gray-500 font-medium mt-1">Générer et télécharger les sauvegardes automatiques</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.backups.run') }}"
                   class="btn-primary !py-2.5 !px-5 !rounded-xl flex items-center gap-2"
                   onclick="return confirm('Lancer une sauvegarde maintenant ?')">
                    <i data-lucide="database-backup" class="w-5 h-5"></i>
                    Lancer la sauvegarde
                </a>
                <button type="button" onclick="document.getElementById('restore-input').click()"
                   class="btn-secondary !py-2.5 !px-5 !rounded-xl flex items-center gap-2 hover:!bg-amber-500 hover:!text-white hover:!border-amber-500 !border-amber-300 !text-amber-700">
                    <i data-lucide="upload" class="w-5 h-5"></i>
                    Restaurer une sauvegarde
                </button>
                <form id="restore-form" action="{{ route('admin.backups.restore') }}" method="POST" enctype="multipart/form-data" class="hidden">
                    @csrf
                    <input id="restore-input" type="file" name="backup" accept=".sql,.sql.gz,.gz" onchange="if(this.files.length > 0 && confirm('ATTENTION : Cela va écraser TOUTE la base de données. Continuer ?')) document.getElementById('restore-form').submit()">
                </form>
            </div>
        </div>

        <div class="glass-panel rounded-2xl border border-border/50 shadow-premium overflow-hidden">
            @if(count($files) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-border/50 text-xs uppercase tracking-wider text-gray-500 font-bold">
                                <th class="px-6 py-4">Fichier</th>
                                <th class="px-6 py-4">Taille</th>
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border/50">
                            @foreach($files as $file)
                                <tr class="hover:bg-primary/[0.02] transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-200/50">
                                                <i data-lucide="archive" class="w-4 h-4"></i>
                                            </div>
                                            <span class="font-semibold text-text font-mono text-xs">{{ $file['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 font-medium">
                                        @php
                                            $size = $file['size'];
                                            if ($size > 1048576) {
                                                echo round($size / 1048576, 1) . ' MB';
                                            } elseif ($size > 1024) {
                                                echo round($size / 1024, 1) . ' KB';
                                            } else {
                                                echo $size . ' B';
                                            }
                                        @endphp
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ \Carbon\Carbon::createFromTimestamp($file['last_modified'])->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.backups.download', $file['name']) }}"
                                               class="btn-secondary !py-1.5 !px-3 text-xs flex items-center gap-1.5 inline-flex hover:!bg-primary hover:!text-white hover:!border-primary">
                                                <i data-lucide="download" class="w-3.5 h-3.5"></i>
                                                Télécharger
                                            </a>
                                            <form action="{{ route('admin.backups.destroy', $file['name']) }}" method="POST"
                                                  onsubmit="return confirm('Supprimer cette sauvegarde ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                   class="btn-secondary !py-1.5 !px-3 text-xs flex items-center gap-1.5 inline-flex hover:!bg-red-500 hover:!text-white hover:!border-red-500 !border-red-200 !text-red-600">
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-16 text-gray-500">
                    <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-border">
                        <i data-lucide="archive" class="w-10 h-10 text-gray-300"></i>
                    </div>
                    <p class="text-lg font-bold text-gray-700">Aucune sauvegarde</p>
                    <p class="text-gray-500 mt-1">Cliquez sur « Lancer la sauvegarde » pour créer la première.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
