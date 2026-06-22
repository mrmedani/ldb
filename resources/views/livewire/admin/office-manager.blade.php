<div>
    <div class="glass-panel rounded-2xl overflow-hidden">
        <!-- Toolbar -->
        <div class="p-5 lg:p-6 border-b border-border/50 space-y-5 bg-gray-50/30">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="relative flex-1 group">
                    <i data-lucide="search" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                    <input type="text" placeholder="Rechercher par nom, téléphone, wilaya, commune..."
                           wire:model.live.debounce.300ms="search"
                           class="input-modern pl-11" />
                </div>
                <select wire:model.live="filterWilaya" class="input-modern w-full sm:w-auto cursor-pointer appearance-none">
                    <option value="">Toutes les wilayas</option>
                    @foreach($wilayas as $wilaya)
                        <option value="{{ $wilaya->id }}">{{ $wilaya->name }}</option>
                    @endforeach
                </select>
                <select wire:model.live="filterVisibility" class="input-modern w-full sm:w-auto cursor-pointer appearance-none">
                    <option value="">Tous les statuts</option>
                    <option value="visible">Visibles</option>
                    <option value="hidden">Masqués</option>
                </select>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.exports.excel') }}" class="btn-secondary !bg-emerald-50 !text-emerald-700 !border-emerald-200 hover:!bg-emerald-500 hover:!text-white hover:!border-emerald-500">
                        <i data-lucide="file-spreadsheet" class="w-4 h-4"></i> Excel
                    </a>
                    <a href="{{ route('admin.exports.pdf') }}" target="_blank" class="btn-secondary !bg-rose-50 !text-rose-700 !border-rose-200 hover:!bg-rose-500 hover:!text-white hover:!border-rose-500">
                        <i data-lucide="file-text" class="w-4 h-4"></i> PDF
                    </a>
                    <a href="{{ route('admin.exports.print') }}" target="_blank" class="btn-secondary !bg-sky-50 !text-sky-700 !border-sky-200 hover:!bg-sky-500 hover:!text-white hover:!border-sky-500">
                        <i data-lucide="printer" class="w-4 h-4"></i> Imprimer
                    </a>
                </div>

                @if(count($selected) > 0)
                    <div class="flex items-center gap-3 bg-gray-900 text-white px-4 py-2.5 rounded-xl shadow-lg animate-[slideDown_0.3s_ease-out]">
                        <span class="text-sm font-bold bg-white/20 px-2.5 py-1 rounded-lg">{{ count($selected) }} sélectionné(s)</span>
                        <div class="w-px h-6 bg-white/20"></div>
                        <button wire:click="toggleSelectedVisibility" class="p-1.5 rounded-lg text-gray-300 hover:text-white hover:bg-white/10 transition-colors" title="Changer la visibilité">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                        <button wire:click="deleteSelected" class="p-1.5 rounded-lg text-red-400 hover:text-red-300 hover:bg-red-500/20 transition-colors" title="Supprimer la sélection">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        @php
            $grouped = $offices->groupBy(fn($o) => $o->wilaya->name . '|' . $o->wilaya->code);
        @endphp

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-text">
                <thead class="text-xs uppercase bg-gray-50 border-y border-border/50 text-gray-500">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold w-12">
                            <i data-lucide="check-square" class="w-4 h-4 text-gray-400"></i>
                        </th>
                        <th scope="col" class="px-6 py-4 font-bold">Entreprise</th>
                        <th scope="col" class="px-6 py-4 font-bold">Contact</th>
                        <th scope="col" class="px-6 py-4 font-bold">Localisation</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Statut</th>
                        <th scope="col" class="px-6 py-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/50">
                    @forelse($grouped as $key => $group)
                        @php
                            [$wilayaName, $wilayaCode] = explode('|', $key);
                        @endphp
                        
                        <!-- Header de groupe -->
                        <tr class="bg-gray-50/80">
                            <td colspan="6" class="px-6 py-3 font-semibold text-gray-700">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center text-xs font-bold">{{ $wilayaCode }}</div>
                                    <span class="text-base">{{ $wilayaName }}</span>
                                    <span class="ml-2 text-xs font-medium bg-white border border-border px-2 py-0.5 rounded-md text-gray-500">{{ $group->count() }} bureau(x)</span>
                                </div>
                            </td>
                        </tr>

                        @foreach($group as $office)
                            <tr wire:key="office-{{ $office->id }}" class="hover:bg-gray-50/50 transition-colors group {{ in_array((string)$office->id, $selected) ? 'bg-primary/5' : '' }}">
                                <td class="px-6 py-4">
                                    <input type="checkbox" value="{{ $office->id }}" wire:model.live="selected" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary/20 cursor-pointer">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-gray-600 font-bold border border-border group-hover:border-primary/20 group-hover:bg-primary/5 group-hover:text-primary transition-colors shrink-0">
                                            {{ substr($office->company_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-text">{{ $office->company_name }}</div>
                                            <div class="text-xs text-gray-500 font-mono mt-0.5">Ordre: #{{ $office->display_order }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <a href="tel:{{ $office->phone }}" class="text-sm font-semibold text-gray-700 hover:text-primary transition-colors flex items-center gap-2">
                                            <i data-lucide="phone" class="w-3.5 h-3.5 text-gray-400"></i> {{ $office->phone }}
                                        </a>
                                        @if($office->phone_secondary)
                                            <a href="tel:{{ $office->phone_secondary }}" class="text-xs text-gray-500 hover:text-primary transition-colors flex items-center gap-2">
                                                <i data-lucide="phone" class="w-3 h-3 text-gray-400"></i> {{ $office->phone_secondary }}
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-2">
                                        <i data-lucide="map-pin" class="w-4 h-4 text-gray-400 mt-0.5 shrink-0"></i>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-700">{{ $office->commune ? $office->commune->name : 'N/A' }}</span>
                                            <span class="text-xs text-gray-500 max-w-[200px] truncate" title="{{ $office->address }}">{{ $office->address }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button wire:click="toggleVisibility({{ $office->id }})" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-primary/20 {{ $office->is_visible ? 'bg-emerald-500' : 'bg-gray-300' }}">
                                        <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-300 {{ $office->is_visible ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button wire:click="moveUp({{ $office->id }})" class="p-1.5 rounded-lg text-gray-400 hover:text-primary hover:bg-primary/10 transition-colors" title="Monter">
                                            <i data-lucide="chevron-up" class="w-4 h-4"></i>
                                        </button>
                                        <button wire:click="moveDown({{ $office->id }})" class="p-1.5 rounded-lg text-gray-400 hover:text-primary hover:bg-primary/10 transition-colors" title="Descendre">
                                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                        </button>
                                        <div class="w-px h-4 bg-border/50 mx-1"></div>
                                        <a href="{{ route('admin.offices.edit', $office) }}" wire:navigate class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50 transition-colors" title="Modifier">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <button wire:click="deleteOffice({{ $office->id }})" wire:confirm="Êtes-vous sûr de vouloir supprimer ce bureau ?" class="p-1.5 rounded-lg text-red-600 hover:bg-red-50 transition-colors" title="Supprimer">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="px-5 py-20 text-center">
                                    <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-5 border border-border">
                                        <i data-lucide="inbox" class="w-10 h-10 text-gray-400"></i>
                                    </div>
                                    <p class="text-lg font-bold text-gray-700 mb-1">Aucun bureau trouvé</p>
                                    <p class="text-sm text-gray-500 max-w-sm mx-auto leading-relaxed">
                                        Aucun résultat ne correspond à votre recherche, ou vous n'avez pas encore ajouté de bureaux.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($offices->hasPages())
            <div class="px-6 py-4 border-t border-border/50 bg-gray-50/30">
                {{ $offices->links(data: ['scrollTo' => false]) }}
            </div>
        @endif
    </div>
    <style>
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</div>
