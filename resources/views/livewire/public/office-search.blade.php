<div>
    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-6 mb-10">
        <!-- Card 1: Wilayas -->
        <div class="glass-panel rounded-2xl p-6 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 relative overflow-hidden group cursor-default">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">{{ $settings->stats_wilayas_label ?? 'Wilayas couvertes' }}</span>
                <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center border border-primary/20">
                    <i data-lucide="map-pin" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-4xl font-extrabold text-text relative z-10">{{ $stats['wilayas'] }}</p>
        </div>
        
        <!-- Card 2: Active Offices -->
        <div class="glass-panel rounded-2xl p-6 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 relative overflow-hidden group cursor-default">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">{{ $settings->stats_offices_label ?? 'Bureaux actifs' }}</span>
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center border border-emerald-500/20">
                    <i data-lucide="building-2" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-4xl font-extrabold text-text relative z-10">{{ $stats['offices'] }}</p>
        </div>

        <!-- Card 3: Partners -->
        <div class="glass-panel rounded-2xl p-6 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 relative overflow-hidden group cursor-default">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/5 rounded-full blur-2xl group-hover:bg-blue-500/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">{{ $settings->stats_partners_label ?? 'Partenaires agréés' }}</span>
                <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-600 flex items-center justify-center border border-blue-500/20">
                    <i data-lucide="handshake" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-4xl font-extrabold text-text relative z-10">{{ $stats['partners'] }}</p>
        </div>
    </div>

    <!-- Search Input Area -->
    <div class="relative mb-10 group">
        <div class="absolute -inset-1 bg-gradient-to-r from-primary to-blue-500 rounded-2xl blur opacity-10 group-hover:opacity-20 transition duration-1000 group-hover:duration-200"></div>
        <div class="relative glass-panel rounded-2xl flex items-center p-2 shadow-sm border border-border/50">
            <i data-lucide="search" class="w-6 h-6 text-gray-400 ml-4 group-focus-within:text-primary transition-colors"></i>
            <input type="text" placeholder="{{ $settings->search_placeholder ?? 'Rechercher par wilaya, commune, entreprise...' }}" 
                   wire:model.live.debounce.300ms="search" 
                   class="w-full bg-transparent border-0 focus:ring-0 text-text px-4 py-3 text-lg placeholder:text-gray-400 font-medium outline-none">
            @if($search)
                <button wire:click="$set('search', '')" class="p-2 text-gray-400 hover:text-gray-600 transition-colors mr-2">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            @endif
        </div>
    </div>

    <!-- Results Table & Mobile Cards -->
    <div class="glass-panel rounded-2xl border border-border/50 shadow-premium overflow-hidden">
        <!-- Desktop Table View -->
        <div class="overflow-x-auto hidden sm:block">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-border/50 text-xs uppercase tracking-wider text-gray-500 font-bold">
                        <th class="px-6 py-4 cursor-pointer hover:text-gray-900 transition-colors group" wire:click="sortBy('wilaya_id')">
                            <div class="flex items-center gap-2">
                                Wilaya
                                @if($sortField === 'wilaya_id')
                                    <i data-lucide="{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}" class="w-3.5 h-3.5 text-primary"></i>
                                @else
                                    <i data-lucide="arrow-up-down" class="w-3.5 h-3.5 opacity-0 group-hover:opacity-50 transition-opacity"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4">Commune</th>
                        @if($settings->show_code)
                            <th class="px-6 py-4">Code</th>
                        @endif
                        @if($settings->show_company)
                            <th class="px-6 py-4 cursor-pointer hover:text-gray-900 transition-colors group" wire:click="sortBy('company_name')">
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
                            <th class="px-6 py-4 hidden sm:table-cell">Téléphone</th>
                        @endif
                        @if($settings->show_address)
                            <th class="px-6 py-4 hidden md:table-cell">Adresse</th>
                        @endif
                        @if($settings->show_maps)
                            <th class="px-6 py-4 text-center">Localisation</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/50">
                    @forelse($offices as $office)
                        <tr wire:key="office-{{ $office->id }}" class="hover:bg-primary/[0.02] transition-colors duration-200 group">
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 font-bold text-text">
                                    <i data-lucide="map-pin" class="w-4 h-4 text-primary opacity-60"></i>
                                    {{ $office->wilaya->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-700">{{ $office->commune?->name ?? '-' }}</span>
                            </td>
                            @if($settings->show_code)
                                <td class="px-6 py-4">
                                    <span class="font-mono text-xs font-bold text-gray-500 bg-gray-100/80 border border-gray-200/50 px-2 py-0.5 rounded-md">{{ $office->wilaya->code }}</span>
                                </td>
                            @endif
                            @if($settings->show_company)
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-gray-100 flex items-center justify-center text-gray-600 font-bold border border-border group-hover:border-primary/20 group-hover:bg-primary/5 group-hover:text-primary transition-colors">
                                            {{ substr($office->company_name, 0, 1) }}
                                        </div>
                                        <span class="font-bold text-text">{{ $office->company_name }}</span>
                                    </div>
                                </td>
                            @endif
                            @if($settings->show_phone)
                                <td class="px-6 py-4 hidden sm:table-cell">
                                    <div class="flex flex-col gap-0.5">
                                        <a href="tel:{{ $office->phone }}" class="text-sm font-semibold text-gray-700 hover:text-primary transition-colors flex items-center gap-1.5">
                                            <i data-lucide="phone" class="w-3.5 h-3.5 text-gray-400"></i>
                                            {{ $office->phone }}
                                        </a>
                                        @if($office->phone_secondary)
                                            <a href="tel:{{ $office->phone_secondary }}" class="text-xs text-gray-400 hover:text-primary transition-colors flex items-center gap-1.5">
                                                <i data-lucide="phone" class="w-3 h-3 text-gray-400"></i>
                                                {{ $office->phone_secondary }}
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            @endif
                            @if($settings->show_address)
                                <td class="px-6 py-4 text-gray-500 hidden md:table-cell max-w-xs truncate" title="{{ $office->address }}">
                                    {{ $office->address }}
                                </td>
                            @endif
                            @if($settings->show_maps)
                                <td class="px-6 py-4 text-center">
                                    @if($office->google_maps)
                                        <a href="{{ $office->google_maps }}" target="_blank" rel="noopener noreferrer" class="btn-secondary !py-1.5 !px-3 text-xs flex items-center justify-center gap-1.5 hover:!bg-primary hover:!text-white hover:!border-primary">
                                            <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="#EA4335"/>
                                            </svg>
                                            Itinéraire
                                        </a>
                                    @else
                                        <span class="text-gray-300 font-medium">—</span>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-16 text-center text-gray-500">
                                <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-border">
                                    <i data-lucide="inbox" class="w-10 h-10 text-gray-300"></i>
                                </div>
                                <p class="text-lg font-bold text-gray-700">Aucun bureau trouvé</p>
                                <p class="text-gray-500 mt-1 max-w-sm mx-auto leading-relaxed">Aucun résultat ne correspond à votre recherche. Veuillez réessayer avec d'autres termes.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards List View -->
        <div class="block sm:hidden divide-y divide-border/50">
            @forelse($offices as $office)
                <div class="p-5 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-2 font-bold text-text">
                            <i data-lucide="map-pin" class="w-4 h-4 text-primary opacity-60"></i>
                            {{ $office->wilaya->name }}
                        </span>
                        @if($settings->show_code)
                            <span class="font-mono text-xs font-bold text-gray-500 bg-gray-100/80 border border-gray-200/50 px-2 py-0.5 rounded-md">{{ $office->wilaya->code }}</span>
                        @endif
                    </div>
                    
                    <div class="flex items-center justify-between text-sm">
                        <span class="font-semibold text-gray-500">Commune</span>
                        <span class="font-bold text-gray-800">{{ $office->commune?->name ?? '-' }}</span>
                    </div>

                    @if($settings->show_company)
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-semibold text-gray-500">Entreprise</span>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-primary/10 text-primary font-bold flex items-center justify-center text-[10px]">
                                    {{ substr($office->company_name, 0, 1) }}
                                </div>
                                <span class="font-bold text-text">{{ $office->company_name }}</span>
                            </div>
                        </div>
                    @endif

                    @if($settings->show_phone)
                        <div class="flex flex-col gap-2 pt-2 border-t border-border/20">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Téléphone</span>
                            <div class="flex flex-col gap-1">
                                <a href="tel:{{ $office->phone }}" class="text-sm font-semibold text-gray-700 hover:text-primary transition-colors flex items-center gap-2">
                                    <i data-lucide="phone" class="w-4 h-4 text-gray-400"></i>
                                    {{ $office->phone }}
                                </a>
                                @if($office->phone_secondary)
                                    <a href="tel:{{ $office->phone_secondary }}" class="text-xs text-gray-400 hover:text-primary transition-colors flex items-center gap-2 pl-6">
                                        {{ $office->phone_secondary }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($settings->show_address)
                        <div class="flex flex-col gap-1 pt-2 border-t border-border/20">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Adresse</span>
                            <p class="text-sm text-gray-500 leading-relaxed">{{ $office->address }}</p>
                        </div>
                    @endif

                    @if($settings->show_maps && $office->google_maps)
                        <div class="pt-2">
                            <a href="{{ $office->google_maps }}" target="_blank" rel="noopener noreferrer" class="btn-secondary !py-2.5 w-full text-xs flex items-center justify-center gap-2 hover:!bg-primary hover:!text-white hover:!border-primary">
                                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="#EA4335"/>
                                </svg>
                                Itinéraire Maps
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="px-6 py-16 text-center text-gray-500">
                    <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-border">
                        <i data-lucide="inbox" class="w-10 h-10 text-gray-300"></i>
                    </div>
                    <p class="text-lg font-bold text-gray-700">Aucun bureau trouvé</p>
                    <p class="text-gray-500 mt-1 max-w-sm mx-auto leading-relaxed">Aucun résultat ne correspond à votre recherche. Veuillez réessayer avec d'autres termes.</p>
                </div>
            @endforelse
        </div>
        
        @if($offices->hasPages())
            <div class="px-6 py-4 border-t border-border/50 bg-gray-50/30">
                {{ $offices->links(data: ['scrollTo' => false]) }}
            </div>
        @endif
    </div>
</div>
