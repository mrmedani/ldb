@php
    $ordered = $settings->ordered_columns;
@endphp
<div>
    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-6 mb-10">
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
                        @foreach($ordered as $col)
                            <th class="px-6 py-4 {{ $col['th_class'] ?? '' }} {{ isset($col['sort_field']) ? 'cursor-pointer hover:text-gray-900 transition-colors group' : '' }}" {{ isset($col['sort_field']) ? 'wire:click=sortBy(\''.$col['sort_field'].'\')' : '' }}>
                                <div class="flex items-center gap-2">
                                    {{ $col['label'] }}
                                    @if(isset($col['sort_field']))
                                        @if($sortField === $col['sort_field'])
                                            <i data-lucide="{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}" class="w-3.5 h-3.5 text-primary"></i>
                                        @else
                                            <i data-lucide="arrow-up-down" class="w-3.5 h-3.5 opacity-0 group-hover:opacity-50 transition-opacity"></i>
                                        @endif
                                    @endif
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/50">
                    @forelse($offices as $office)
                        <tr wire:key="office-{{ $office->id }}" class="hover:bg-primary/[0.02] transition-colors duration-200 group">
                            @foreach($ordered as $col)
                                @switch($col['key'])
                                    @case('wilaya')
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center gap-2 font-bold text-text">
                                                <i data-lucide="map-pin" class="w-4 h-4 text-primary opacity-60"></i>
                                                {{ $office->wilaya->name }}
                                            </span>
                                        </td>
                                        @break
                                    @case('commune')
                                        <td class="px-6 py-4">
                                            <span class="font-semibold text-gray-700">{{ $office->commune?->name ?? '-' }}</span>
                                        </td>
                                        @break
                                    @case('delivery_time')
                                        <td class="px-6 py-4">
                                            @if($office->wilaya->delivery_time)
                                                <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200/50 px-3 py-1 rounded-full">
                                                    <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                                    {{ $office->wilaya->delivery_time }}
                                                </span>
                                            @else
                                                <span class="text-gray-300 font-medium">—</span>
                                            @endif
                                        </td>
                                        @break
                                    @case('code')
                                        <td class="px-6 py-4">
                                            <span class="font-mono text-xs font-bold text-gray-500 bg-gray-100/80 border border-gray-200/50 px-2 py-0.5 rounded-md">{{ $office->wilaya->code }}</span>
                                        </td>
                                        @break
                                    @case('company')
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-gray-100 flex items-center justify-center text-gray-600 font-bold border border-border group-hover:border-primary/20 group-hover:bg-primary/5 group-hover:text-primary transition-colors">
                                                    {{ substr($office->company_name, 0, 1) }}
                                                </div>
                                                <span class="font-bold text-text">{{ $office->company_name }}</span>
                                            </div>
                                        </td>
                                        @break
                                    @case('phone')
                                        <td class="px-6 py-4 {{ $col['td_class'] ?? '' }}">
                                            <div class="flex flex-col gap-0.5">
                                                <a href="tel:{{ $office->phone }}" class="text-sm font-semibold text-gray-700 hover:text-primary transition-colors flex items-center gap-1.5">
                                                    <i data-lucide="phone" class="w-3.5 h-3.5 text-gray-400"></i>
                                                    {{ $office->phone }}
                                                </a>
                                                @if($office->phone_secondary)
                                                    <a href="tel:{{ $office->phone_secondary }}" class="text-sm font-semibold text-gray-700 hover:text-primary transition-colors flex items-center gap-1.5">
                                                        <i data-lucide="phone" class="w-3.5 h-3.5 text-gray-400"></i>
                                                        {{ $office->phone_secondary }}
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                        @break
                                    @case('address')
                                        <td class="px-6 py-4 text-gray-500 {{ $col['td_class'] ?? '' }}" title="{{ $office->address }}">
                                            {{ $office->address }}
                                        </td>
                                        @break
                                    @case('maps')
                                        <td class="px-6 py-4 {{ $col['th_class'] ?? '' }}">
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
                                        @break
                                @endswitch
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($ordered) }}" class="px-6 py-16 text-center text-gray-500">
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
                    @foreach($ordered as $col)
                        @switch($col['key'])
                            @case('wilaya')
                                <div class="flex items-center justify-between">
                                    <span class="inline-flex items-center gap-2 font-bold text-text">
                                        <i data-lucide="map-pin" class="w-4 h-4 text-primary opacity-60"></i>
                                        {{ $office->wilaya->name }}
                                    </span>
                                </div>
                                @break
                            @case('code')
                                <div class="flex items-center justify-between text-sm">
                                    <span class="font-semibold text-gray-500">Code</span>
                                    <span class="font-mono text-xs font-bold text-gray-500 bg-gray-100/80 border border-gray-200/50 px-2 py-0.5 rounded-md">{{ $office->wilaya->code }}</span>
                                </div>
                                @break
                            @case('commune')
                                <div class="flex items-center justify-between text-sm">
                                    <span class="font-semibold text-gray-500">Commune</span>
                                    <span class="font-bold text-gray-800">{{ $office->commune?->name ?? '-' }}</span>
                                </div>
                                @break
                            @case('delivery_time')
                                <div class="flex items-center justify-between text-sm">
                                    <span class="font-semibold text-gray-500">Délai livraison</span>
                                    @if($office->wilaya->delivery_time)
                                        <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200/50 px-3 py-1 rounded-full">
                                            <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                            {{ $office->wilaya->delivery_time }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 font-medium">—</span>
                                    @endif
                                </div>
                                @break
                            @case('company')
                                <div class="flex items-center justify-between text-sm">
                                    <span class="font-semibold text-gray-500">Entreprise</span>
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-lg bg-primary/10 text-primary font-bold flex items-center justify-center text-[10px]">
                                            {{ substr($office->company_name, 0, 1) }}
                                        </div>
                                        <span class="font-bold text-text">{{ $office->company_name }}</span>
                                    </div>
                                </div>
                                @break
                            @case('phone')
                                <div class="flex flex-col gap-2 pt-2 border-t border-border/20">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Téléphone</span>
                                    <div class="flex flex-col gap-1">
                                        <a href="tel:{{ $office->phone }}" class="text-sm font-semibold text-gray-700 hover:text-primary transition-colors flex items-center gap-2">
                                            <i data-lucide="phone" class="w-4 h-4 text-gray-400"></i>
                                            {{ $office->phone }}
                                        </a>
                                        @if($office->phone_secondary)
                                            <a href="tel:{{ $office->phone_secondary }}" class="text-sm font-semibold text-gray-700 hover:text-primary transition-colors flex items-center gap-2">
                                                <i data-lucide="phone" class="w-4 h-4 text-gray-400"></i>
                                                {{ $office->phone_secondary }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                @break
                            @case('address')
                                <div class="flex flex-col gap-1 pt-2 border-t border-border/20">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Adresse</span>
                                    <p class="text-sm text-gray-500 leading-relaxed">{{ $office->address }}</p>
                                </div>
                                @break
                            @case('maps')
                                @if($office->google_maps)
                                    <div class="pt-2">
                                        <a href="{{ $office->google_maps }}" target="_blank" rel="noopener noreferrer" class="btn-secondary !py-2.5 w-full text-xs flex items-center justify-center gap-2 hover:!bg-primary hover:!text-white hover:!border-primary">
                                            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="#EA4335"/>
                                            </svg>
                                            Itinéraire Maps
                                        </a>
                                    </div>
                                @endif
                                @break
                        @endswitch
                    @endforeach
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
