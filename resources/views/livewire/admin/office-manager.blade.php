<div>
    <div class="bg-surface/80 backdrop-blur-md rounded-2xl border border-border/50 shadow-sm overflow-hidden">
        <div class="p-5 lg:p-6 border-b border-border/50 space-y-5 bg-gray-50/30">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="relative flex-1 group">
                    <i data-lucide="search" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                    <input type="text" placeholder="Rechercher par nom, téléphone, wilaya..." wire:model.live.debounce.300ms="search" class="pl-11 pr-4 py-3 text-sm border-2 border-transparent rounded-xl w-full bg-background focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300" />
                </div>
                <select wire:model.live="filterWilaya" class="px-4 py-3 text-sm border-2 border-transparent rounded-xl bg-background focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300 cursor-pointer appearance-none font-medium text-gray-600">
                    <option value="">Toutes les wilayas</option>
                    @foreach($wilayas as $wilaya)
                        <option value="{{ $wilaya->id }}">{{ $wilaya->name }}</option>
                    @endforeach
                </select>
                <select wire:model.live="filterVisibility" class="px-4 py-3 text-sm border-2 border-transparent rounded-xl bg-background focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300 cursor-pointer appearance-none font-medium text-gray-600">
                    <option value="">Tous les statuts</option>
                    <option value="visible">Visibles</option>
                    <option value="hidden">Masqués</option>
                </select>
            </div>
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.exports.excel') }}" class="group inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold bg-green-50 text-green-700 hover:bg-green-500 hover:text-white transition-all shadow-sm hover:shadow-md hover:shadow-green-500/20 active:scale-95">
                        <i data-lucide="file-spreadsheet" class="w-4 h-4 group-hover:scale-110 transition-transform"></i>
                        Excel
                    </a>
                    <a href="{{ route('admin.exports.pdf') }}" target="_blank" class="group inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold bg-red-50 text-red-700 hover:bg-red-500 hover:text-white transition-all shadow-sm hover:shadow-md hover:shadow-red-500/20 active:scale-95">
                        <i data-lucide="file-text" class="w-4 h-4 group-hover:scale-110 transition-transform"></i>
                        PDF
                    </a>
                    <a href="{{ route('admin.exports.print') }}" target="_blank" class="group inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold bg-blue-50 text-blue-700 hover:bg-blue-500 hover:text-white transition-all shadow-sm hover:shadow-md hover:shadow-blue-500/20 active:scale-95">
                        <i data-lucide="printer" class="w-4 h-4 group-hover:scale-110 transition-transform"></i>
                        Imprimer
                    </a>
                </div>
                
                @if(count($selected) > 0)
                    <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100 animate-[fadeIn_0.3s_ease-out]">
                        <span class="text-sm font-bold text-gray-700 bg-gray-100 px-2.5 py-1 rounded-lg">{{ count($selected) }} sélectionné(s)</span>
                        <div class="w-px h-6 bg-gray-200"></div>
                        <button wire:click="toggleSelectedVisibility" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 transition-colors tooltip" title="Changer la visibilité">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                        <button wire:click="deleteSelected" class="p-2 rounded-lg text-red-500 hover:bg-red-50 transition-colors tooltip" title="Supprimer la sélection">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-border/50">
                        <th class="px-5 py-4 text-left w-12">
                            <input type="checkbox" wire:model.live="selectAll" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary/20 cursor-pointer">
                        </th>
                        <th class="px-5 py-4 text-left font-bold text-gray-500 uppercase tracking-wider text-xs cursor-pointer hover:text-gray-900 transition-colors group" wire:click="sortBy('display_order')">
                            <div class="flex items-center gap-2">
                                Ordre
                                @if($sortField === 'display_order')
                                    <i data-lucide="{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}" class="w-3.5 h-3.5 text-primary"></i>
                                @else
                                    <i data-lucide="arrow-up-down" class="w-3.5 h-3.5 opacity-0 group-hover:opacity-50 transition-opacity"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-5 py-4 text-left font-bold text-gray-500 uppercase tracking-wider text-xs cursor-pointer hover:text-gray-900 transition-colors group" wire:click="sortBy('wilaya_id')">
                            <div class="flex items-center gap-2">
                                Wilaya
                                @if($sortField === 'wilaya_id')
                                    <i data-lucide="{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}" class="w-3.5 h-3.5 text-primary"></i>
                                @else
                                    <i data-lucide="arrow-up-down" class="w-3.5 h-3.5 opacity-0 group-hover:opacity-50 transition-opacity"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-5 py-4 text-left font-bold text-gray-500 uppercase tracking-wider text-xs">Code</th>
                        <th class="px-5 py-4 text-left font-bold text-gray-500 uppercase tracking-wider text-xs cursor-pointer hover:text-gray-900 transition-colors group" wire:click="sortBy('company_name')">
                            <div class="flex items-center gap-2">
                                Entreprise
                                @if($sortField === 'company_name')
                                    <i data-lucide="{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}" class="w-3.5 h-3.5 text-primary"></i>
                                @else
                                    <i data-lucide="arrow-up-down" class="w-3.5 h-3.5 opacity-0 group-hover:opacity-50 transition-opacity"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-5 py-4 text-left font-bold text-gray-500 uppercase tracking-wider text-xs hidden lg:table-cell">Téléphone</th>
                        <th class="px-5 py-4 text-left font-bold text-gray-500 uppercase tracking-wider text-xs hidden xl:table-cell">Adresse</th>
                        <th class="px-5 py-4 text-center font-bold text-gray-500 uppercase tracking-wider text-xs hidden lg:table-cell">Maps</th>
                        <th class="px-5 py-4 text-center font-bold text-gray-500 uppercase tracking-wider text-xs">Statut</th>
                        <th class="px-5 py-4 text-right font-bold text-gray-500 uppercase tracking-wider text-xs">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/50">
                    @forelse($offices as $office)
                        <tr wire:key="office-{{ $office->id }}" class="hover:bg-blue-50/30 transition-colors duration-200" x-data x-sort-item="{{ $office->id }}">
                            <td class="px-5 py-4">
                                <input type="checkbox" value="{{ $office->id }}" wire:model.live="selected" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary/20 cursor-pointer">
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-bold text-gray-700 bg-gray-100 w-8 h-8 rounded-lg flex items-center justify-center">{{ $office->display_order }}</span>
                                    <div class="flex flex-col gap-1">
                                        <button wire:click="moveUp({{ $office->id }})" class="p-0.5 rounded-md text-gray-400 hover:text-primary hover:bg-primary/10 transition-colors">
                                            <i data-lucide="chevron-up" class="w-3.5 h-3.5"></i>
                                        </button>
                                        <button wire:click="moveDown({{ $office->id }})" class="p-0.5 rounded-md text-gray-400 hover:text-primary hover:bg-primary/10 transition-colors">
                                            <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1.5 font-semibold text-text">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-gray-400"></i>
                                    {{ $office->wilaya->name }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="font-mono text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-md">{{ $office->wilaya->code }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary font-bold flex items-center justify-center text-xs">
                                        {{ substr($office->company_name, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-text">{{ $office->company_name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 hidden lg:table-cell">
                                <a href="tel:{{ $office->phone }}" class="text-gray-600 hover:text-primary font-medium transition-colors">{{ $office->phone }}</a>
                            </td>
                            <td class="px-5 py-4 text-gray-500 hidden xl:table-cell max-w-xs truncate">{{ $office->address }}</td>
                            <td class="px-5 py-4 hidden lg:table-cell text-center">
                                @if($office->google_maps)
                                    <a href="{{ $office->google_maps }}" target="_blank" class="inline-flex p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                        <i data-lucide="map" class="w-4 h-4"></i>
                                    </a>
                                @else
                                    <span class="text-gray-300">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center">
                                <button wire:click="toggleVisibility({{ $office->id }})" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-primary/20 {{ $office->is_visible ? 'bg-green-500' : 'bg-gray-300' }}">
                                    <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-300 {{ $office->is_visible ? 'translate-x-[22px]' : 'translate-x-1' }}"></span>
                                </button>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.offices.edit', $office) }}" wire:navigate class="p-2 rounded-lg text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                        <i data-lucide="edit-2" class="w-4 h-4"></i>
                                    </a>
                                    <button wire:click="deleteOffice({{ $office->id }})" wire:confirm="Êtes-vous sûr de vouloir supprimer ce bureau ?" class="p-2 rounded-lg text-red-600 bg-red-50 hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-5 py-16 text-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                    <i data-lucide="building-2" class="w-10 h-10 text-gray-300"></i>
                                </div>
                                <p class="text-lg font-bold text-gray-700">Aucun bureau trouvé</p>
                                <p class="text-gray-500 mt-1 max-w-sm mx-auto">Aucun résultat ne correspond à votre recherche, ou vous n'avez pas encore ajouté de bureaux.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-border/50 bg-gray-50/30">
            {{ $offices->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</div>
