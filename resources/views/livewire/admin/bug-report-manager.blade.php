<div>
    <div class="flex flex-col sm:flex-row gap-4 mb-6">
        <div class="relative flex-1">
            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher par nom, email, message..."
                   class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-border/50 bg-white text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
        </div>
        <select wire:model.live="filterStatus" class="rounded-xl border border-border/50 bg-white px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary">
            <option value="">Tous les statuts</option>
            <option value="pending">En attente</option>
            <option value="resolved">Résolu</option>
            <option value="spam">Spam</option>
        </select>
    </div>

    <div class="glass-panel rounded-2xl border border-border/50 shadow-premium overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-border/50 text-xs uppercase tracking-wider text-gray-500 font-bold">
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Nom</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Message</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/50">
                    @forelse($reports as $report)
                        <tr class="hover:bg-primary/[0.02] transition-colors" wire:key="report-{{ $report->id }}">
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs text-gray-500">
                                {{ $report->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-700">{{ $report->name }}</td>
                            <td class="px-6 py-4">
                                <a href="mailto:{{ $report->email }}" class="text-primary hover:underline font-medium">{{ $report->email }}</a>
                            </td>
                            <td class="px-6 py-4 text-gray-500 max-w-xs">
                                <div class="line-clamp-2" title="{{ $report->message }}">{{ $report->message }}</div>
                                @if($report->url)
                                    <a href="{{ $report->url }}" target="_blank" class="text-xs text-gray-400 hover:text-primary mt-1 block truncate">{{ $report->url }}</a>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $badge = match($report->status) {
                                        'pending' => 'bg-amber-50 text-amber-700 border-amber-200/50',
                                        'resolved' => 'bg-emerald-50 text-emerald-700 border-emerald-200/50',
                                        'spam' => 'bg-gray-100 text-gray-500 border-gray-200/50',
                                        default => 'bg-gray-50 text-gray-600 border-gray-200/50',
                                    };
                                    $label = match($report->status) {
                                        'pending' => 'En attente',
                                        'resolved' => 'Résolu',
                                        'spam' => 'Spam',
                                        default => $report->status,
                                    };
                                @endphp
                                <span class="inline-flex text-xs font-bold px-2.5 py-1 rounded-full border {{ $badge }}">{{ $label }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    @if($report->status !== 'resolved')
                                        <button wire:click="markResolved({{ $report->id }})" class="p-2 text-emerald-500 hover:bg-emerald-50 rounded-lg transition-colors" title="Marquer résolu">
                                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        </button>
                                    @endif
                                    @if($report->status !== 'spam')
                                        <button wire:click="markSpam({{ $report->id }})" class="p-2 text-gray-400 hover:bg-gray-100 rounded-lg transition-colors" title="Marquer spam">
                                            <i data-lucide="ban" class="w-4 h-4"></i>
                                        </button>
                                    @endif
                                    @if($report->status !== 'pending')
                                        <button wire:click="markPending({{ $report->id }})" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors" title="Remettre en attente">
                                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                                        </button>
                                    @endif
                                    <button wire:click="delete({{ $report->id }})" wire:confirm="Supprimer ce signalement ?" class="p-2 text-red-400 hover:bg-red-50 rounded-lg transition-colors" title="Supprimer">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-500">
                                <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-border">
                                    <i data-lucide="bug-off" class="w-10 h-10 text-gray-300"></i>
                                </div>
                                <p class="text-lg font-bold text-gray-700">Aucun signalement</p>
                                <p class="text-gray-500 mt-1">Les signalements de bugs des visiteurs apparaîtront ici.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-border/50 px-6 py-4">
            {{ $reports->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
</div>
