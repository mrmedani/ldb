<div>
    <div class="flex items-center justify-between mb-6">
        <div class="flex flex-col sm:flex-row gap-4 flex-1">
            <div class="relative flex-1">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher dans les logs..."
                       class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-border/50 bg-white text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
            </div>
            <select wire:model.live="filterAction" class="rounded-xl border border-border/50 bg-white px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary">
                <option value="">Toutes les actions</option>
                @foreach($actionTypes as $a)
                    <option value="{{ $a }}">{{ $a }}</option>
                @endforeach
            </select>
            <select wire:model.live="filterType" class="rounded-xl border border-border/50 bg-white px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary">
                <option value="">Tous les types</option>
                @foreach($subjectTypes as $t)
                    <option value="{{ $t }}">{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <span class="text-sm font-bold text-gray-400 bg-gray-100 px-3 py-1.5 rounded-full border border-border/50 shrink-0 ml-4">
            {{ $total }} entrée(s)
        </span>
    </div>

    <div class="glass-panel rounded-2xl border border-border/50 shadow-premium overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-border/50 text-xs uppercase tracking-wider text-gray-500 font-bold">
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Utilisateur</th>
                        <th class="px-6 py-4">Action</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Description</th>
                        <th class="px-6 py-4">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/50">
                    @forelse($logs as $log)
                        <tr class="hover:bg-primary/[0.02] transition-colors" wire:key="log-{{ $log->id }}">
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs text-gray-500">
                                {{ $log->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-700">{{ $log->user?->name ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $badge = match($log->action) {
                                        'created' => 'bg-emerald-50 text-emerald-700 border-emerald-200/50',
                                        'updated' => 'bg-blue-50 text-blue-700 border-blue-200/50',
                                        'deleted', 'bulk_deleted' => 'bg-red-50 text-red-700 border-red-200/50',
                                        'reordered' => 'bg-purple-50 text-purple-700 border-purple-200/50',
                                        'visibility_toggled', 'bulk_visibility' => 'bg-amber-50 text-amber-700 border-amber-200/50',
                                        default => 'bg-gray-50 text-gray-600 border-gray-200/50',
                                    };
                                @endphp
                                <span class="inline-flex text-xs font-bold px-2.5 py-1 rounded-full border {{ $badge }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-600 capitalize">{{ $log->subject_type }}</span>
                                @if($log->subject_id)
                                    <span class="text-gray-400 font-mono text-xs">#{{ $log->subject_id }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 max-w-xs truncate" title="{{ $log->description }}">
                                {{ $log->description }}
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-gray-400">
                                {{ $log->ip_address ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-500">
                                <p class="font-bold text-gray-700">Aucun log trouvé</p>
                                <p class="text-gray-500 mt-1">Les actions administrateurs apparaîtront ici.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-border/50 px-6 py-4">
            {{ $logs->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
</div>
