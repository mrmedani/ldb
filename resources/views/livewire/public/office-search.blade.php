<div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-6 mb-10">
        <!-- Card 1 -->
        <div class="bg-surface/80 backdrop-blur-sm rounded-2xl border border-border/50 p-6 shadow-sm hover:shadow-xl hover:shadow-primary/5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Wilayas couvertes</span>
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary/20 to-primary/5 text-primary flex items-center justify-center shadow-inner">
                    <i data-lucide="map-pin" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-4xl font-extrabold text-text relative z-10">{{ $stats['wilayas'] }}</p>
        </div>
        
        <!-- Card 2 -->
        <div class="bg-surface/80 backdrop-blur-sm rounded-2xl border border-border/50 p-6 shadow-sm hover:shadow-xl hover:shadow-green-500/5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-500/5 rounded-full blur-2xl group-hover:bg-green-500/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Bureaux dispo.</span>
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500/20 to-green-500/5 text-green-600 flex items-center justify-center shadow-inner">
                    <i data-lucide="building-2" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-4xl font-extrabold text-text relative z-10">{{ $stats['offices'] }}</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-surface/80 backdrop-blur-sm rounded-2xl border border-border/50 p-6 shadow-sm hover:shadow-xl hover:shadow-blue-500/5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/5 rounded-full blur-2xl group-hover:bg-blue-500/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Partenaires</span>
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-500/5 text-blue-600 flex items-center justify-center shadow-inner">
                    <i data-lucide="handshake" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-4xl font-extrabold text-text relative z-10">{{ $stats['partners'] }}</p>
        </div>
    </div>

    <div class="relative mb-8 group">
        <i data-lucide="search" class="w-6 h-6 absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors"></i>
        <input type="text" placeholder="Rechercher par wilaya, entreprise, téléphone..." wire:model.live.debounce.300ms="search" class="w-full pl-14 pr-6 py-4 text-base border-2 border-transparent rounded-2xl bg-surface/80 backdrop-blur-md focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-50/80 transition-all duration-300 shadow-sm" />
    </div>

    <div class="bg-surface/80 backdrop-blur-md rounded-2xl border border-border/50 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-border/50">
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
                        <th class="px-5 py-4 text-left font-bold text-gray-500 uppercase tracking-wider text-xs">Commune</th>
                        @if($settings->show_code)
                            <th class="px-5 py-4 text-left font-bold text-gray-500 uppercase tracking-wider text-xs">Code</th>
                        @endif
                        @if($settings->show_company)
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
                        @endif
                        @if($settings->show_phone)
                            <th class="px-5 py-4 text-left font-bold text-gray-500 uppercase tracking-wider text-xs hidden sm:table-cell">Téléphone</th>
                        @endif
                        @if($settings->show_address)
                            <th class="px-5 py-4 text-left font-bold text-gray-500 uppercase tracking-wider text-xs hidden md:table-cell">Adresse</th>
                        @endif
                        @if($settings->show_maps)
                            <th class="px-5 py-4 text-center font-bold text-gray-500 uppercase tracking-wider text-xs">Localisation</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/50">
                    @forelse($offices as $office)
                        <tr wire:key="office-{{ $office->id }}" class="hover:bg-blue-50/30 transition-colors duration-200">
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1.5 font-semibold text-text">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-gray-400"></i>
                                    {{ $office->wilaya->name }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-gray-600">{{ $office->commune?->name ?? '-' }}</span>
                            </td>
                            @if($settings->show_code)
                                <td class="px-5 py-4">
                                    <span class="font-mono text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-md">{{ $office->wilaya->code }}</span>
                                </td>
                            @endif
                            @if($settings->show_company)
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary font-bold flex items-center justify-center text-xs">
                                            {{ substr($office->company_name, 0, 1) }}
                                        </div>
                                        <span class="font-bold text-text">{{ $office->company_name }}</span>
                                    </div>
                                </td>
                            @endif
                            @if($settings->show_phone)
                                <td class="px-5 py-4 hidden sm:table-cell">
                                    <a href="tel:{{ $office->phone }}" class="text-gray-600 hover:text-primary font-medium transition-colors">{{ $office->phone }}</a>
                                    @if($office->phone_secondary)
                                        <br><a href="tel:{{ $office->phone_secondary }}" class="text-gray-400 hover:text-primary font-medium transition-colors text-xs">{{ $office->phone_secondary }}</a>
                                    @endif
                                </td>
                            @endif
                            @if($settings->show_address)
                                <td class="px-5 py-4 text-gray-500 hidden md:table-cell max-w-xs truncate">{{ $office->address }}</td>
                            @endif
                            @if($settings->show_maps)
                                <td class="px-5 py-4 text-center">
                                    @if($office->google_maps)
                                        <a href="{{ $office->google_maps }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                            <i data-lucide="map" class="w-3.5 h-3.5"></i>
                                            Voir sur Maps
                                        </a>
                                    @else
                                        <span class="text-gray-300">—</span>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-16 text-center text-gray-500">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                    <i data-lucide="search-x" class="w-10 h-10 text-gray-300"></i>
                                </div>
                                <p class="text-lg font-bold text-gray-700">Aucun bureau trouvé</p>
                                <p class="text-gray-500 mt-1 max-w-sm mx-auto">Essayez de modifier votre recherche avec d'autres mots-clés.</p>
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
</div>
