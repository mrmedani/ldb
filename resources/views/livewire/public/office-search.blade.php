@php
    $ordered = $settings->ordered_columns;
@endphp
<style>
    /* Responsive: cards on mobile, table on desktop */
    #desktop-table { display: none !important; }
    #mobile-cards  { display: block !important; }
    @media (min-width: 640px) {
        #desktop-table { display: block !important; }
        #mobile-cards  { display: none  !important; }
    }
</style>
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

    <!-- Search Input Area & Export -->
    <div class="flex flex-col sm:flex-row gap-4 mb-10">
        <div class="relative flex-1 group">
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
        
        <!-- Action Buttons -->
        <div class="flex items-center gap-3">
            <a href="{{ route('public.offices.download-pdf', ['search' => $search, 'sort_field' => $sortField, 'sort_direction' => $sortDirection]) }}" 
               class="btn-secondary w-full sm:w-auto !py-3.5 !px-5 !rounded-2xl flex items-center justify-center gap-2 hover:!bg-primary hover:!text-white hover:!border-primary transition-all duration-300 shadow-sm"
               title="Télécharger la liste au format PDF">
                <i data-lucide="file-down" class="w-5 h-5"></i>
                <span class="font-bold">Télécharger PDF</span>
            </a>
        </div>
    </div>

    <!-- Results Table -->
    <div class="glass-panel rounded-2xl border border-border/50 shadow-premium overflow-hidden">
        <!-- Desktop Table View (hidden on mobile, shown on sm+) -->
        <div class="overflow-x-auto" id="desktop-table">
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

        <!-- Mobile Cards List View (shown on mobile, hidden on sm+) -->
        <div id="mobile-cards">
            @forelse($offices as $office)
                <div style="
                    background:#ffffff;
                    border-bottom: 1px solid rgba(0,0,0,0.07);
                    padding: 0;
                    overflow: hidden;
                    position: relative;
                ">
                    {{-- Top gradient accent bar --}}
                    <div style="height:4px;background:linear-gradient(90deg,#f97316 0%,#fb923c 100%);width:100%;"></div>

                    <div style="padding:16px 16px 14px 16px;">
                        {{-- Row 1: Wilaya name + Delivery badge --}}
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                            <div style="display:flex;align-items:center;gap:8px;flex:1;min-width:0;">
                                <div style="
                                    width:36px;height:36px;border-radius:10px;
                                    background:linear-gradient(135deg,#f97316,#fb923c);
                                    display:flex;align-items:center;justify-content:center;
                                    color:white;font-weight:800;font-size:14px;
                                    flex-shrink:0;box-shadow:0 4px 12px rgba(249,115,22,0.3);
                                ">
                                    {{ mb_substr($office->wilaya->name, 0, 1) }}
                                </div>
                                <div style="min-width:0;">
                                    <div style="font-weight:800;font-size:15px;color:#111827;line-height:1.2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                        {{ $office->wilaya->name }}
                                    </div>
                                    @if($settings->show_code)
                                        <div style="font-size:11px;font-weight:600;color:#9ca3af;margin-top:1px;">
                                            Code : <span style="color:#6b7280;font-family:monospace;">{{ $office->wilaya->code }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if($settings->show_delivery_time && $office->wilaya->delivery_time)
                                <div style="
                                    background:linear-gradient(135deg,#d1fae5,#a7f3d0);
                                    border:1px solid #6ee7b7;
                                    border-radius:20px;
                                    padding:4px 10px;
                                    font-size:11px;font-weight:700;color:#065f46;
                                    white-space:nowrap;flex-shrink:0;margin-left:8px;
                                    display:flex;align-items:center;gap:4px;
                                ">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2" stroke-linecap="round"/></svg>
                                    {{ $office->wilaya->delivery_time }}
                                </div>
                            @endif
                        </div>

                        {{-- Row 2: Commune + Company --}}
                        <div style="display:flex;flex-direction:column;gap:6px;margin-bottom:12px;">
                            @if($settings->show_company)
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                    <span style="font-size:13px;font-weight:600;color:#374151;">{{ $office->company_name }}</span>
                                </div>
                            @endif
                            <div style="display:flex;align-items:center;gap:8px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                <span style="font-size:13px;color:#6b7280;font-weight:500;">{{ $office->commune?->name ?? '—' }}</span>
                            </div>
                            @if($settings->show_address && $office->address)
                                <div style="display:flex;align-items:flex-start;gap:8px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" style="flex-shrink:0;margin-top:2px;"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                                    <span style="font-size:12px;color:#9ca3af;line-height:1.5;">{{ $office->address }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Row 3: Phone + Maps buttons --}}
                        <div style="display:flex;flex-direction:column;gap:8px;">
                            @if($settings->show_phone && $office->phone)
                                <div style="display:flex;gap:8px;">
                                    <a href="tel:{{ $office->phone }}" style="
                                        flex:1;
                                        background:linear-gradient(135deg,#f0fdf4,#dcfce7);
                                        border:1px solid #86efac;
                                        border-radius:10px;
                                        padding:10px 14px;
                                        display:flex;align-items:center;justify-content:center;gap:8px;
                                        text-decoration:none;color:#15803d;font-weight:700;font-size:13px;
                                    ">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.81 19.79 19.79 0 01.01 2.18 2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z"/></svg>
                                        {{ $office->phone }}
                                    </a>
                                    @if($office->phone_secondary)
                                        <a href="tel:{{ $office->phone_secondary }}" style="
                                            flex:1;
                                            background:#f9fafb;
                                            border:1px solid #e5e7eb;
                                            border-radius:10px;
                                            padding:10px 14px;
                                            display:flex;align-items:center;justify-content:center;gap:8px;
                                            text-decoration:none;color:#4b5563;font-weight:600;font-size:13px;
                                        ">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.81 19.79 19.79 0 01.01 2.18 2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z"/></svg>
                                            {{ $office->phone_secondary }}
                                        </a>
                                    @endif
                                </div>
                            @endif

                            @if($settings->show_maps && $office->google_maps)
                                <a href="{{ $office->google_maps }}" target="_blank" rel="noopener noreferrer" style="
                                    background:#fff;
                                    border:1px solid #e5e7eb;
                                    border-radius:10px;
                                    padding:10px 14px;
                                    display:flex;align-items:center;justify-content:center;gap:8px;
                                    text-decoration:none;color:#374151;font-weight:600;font-size:13px;
                                ">
                                    <svg width="16" height="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="#EA4335"/>
                                    </svg>
                                    Voir sur Google Maps
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div style="padding:48px 24px;text-align:center;background:#fff;">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5" style="margin:0 auto 12px;display:block;"><path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0L12 17l-8-4"/></svg>
                    <p style="font-weight:700;color:#374151;font-size:15px;margin:0 0 4px;">Aucun bureau trouvé</p>
                    <p style="color:#9ca3af;font-size:13px;margin:0;">Essayez avec d'autres termes de recherche</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
