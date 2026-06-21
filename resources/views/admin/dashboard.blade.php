@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-10">
        <h1 class="text-3xl font-extrabold text-text tracking-tight">Dashboard</h1>
        <p class="text-gray-500 font-medium mt-2">Vue d'ensemble de votre plateforme d'administration.</p>
    </div>

    @php
        $totalOffices = App\Models\Office::count();
        $visibleOffices = App\Models\Office::where('is_visible', true)->count();
        $hiddenOffices = App\Models\Office::where('is_visible', false)->count();
        $lastModified = App\Models\Office::latest('updated_at')->first();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Card 1 -->
        <div class="bg-surface/80 backdrop-blur-sm rounded-2xl border border-border/50 p-6 shadow-sm hover:shadow-xl hover:shadow-primary/5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total bureaux</span>
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary/20 to-primary/5 text-primary flex items-center justify-center shadow-inner">
                    <i data-lucide="building-2" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-4xl font-extrabold text-text relative z-10">{{ $totalOffices }}</p>
        </div>
        
        <!-- Card 2 -->
        <div class="bg-surface/80 backdrop-blur-sm rounded-2xl border border-border/50 p-6 shadow-sm hover:shadow-xl hover:shadow-green-500/5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-500/5 rounded-full blur-2xl group-hover:bg-green-500/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Bureaux visibles</span>
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500/20 to-green-500/5 text-green-600 flex items-center justify-center shadow-inner">
                    <i data-lucide="eye" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-4xl font-extrabold text-text relative z-10">{{ $visibleOffices }}</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-surface/80 backdrop-blur-sm rounded-2xl border border-border/50 p-6 shadow-sm hover:shadow-xl hover:shadow-red-500/5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-500/5 rounded-full blur-2xl group-hover:bg-red-500/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Bureaux masqués</span>
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-red-500/20 to-red-500/5 text-red-600 flex items-center justify-center shadow-inner">
                    <i data-lucide="eye-off" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-4xl font-extrabold text-text relative z-10">{{ $hiddenOffices }}</p>
        </div>

        <!-- Card 4 -->
        <div class="bg-surface/80 backdrop-blur-sm rounded-2xl border border-border/50 p-6 shadow-sm hover:shadow-xl hover:shadow-blue-500/5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/5 rounded-full blur-2xl group-hover:bg-blue-500/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Dernière modif.</span>
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-500/5 text-blue-600 flex items-center justify-center shadow-inner">
                    <i data-lucide="clock" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-xl font-bold text-text relative z-10 pt-2">{{ $lastModified ? $lastModified->updated_at->format('d/m/Y H:i') : '—' }}</p>
        </div>
    </div>

    <div class="bg-surface/90 backdrop-blur-md rounded-2xl border border-border/50 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-border/50 bg-gray-50/50">
            <h2 class="text-lg font-bold text-text">Bureaux récents</h2>
        </div>
        <div class="p-2">
            @php
                $recentOffices = App\Models\Office::with('wilaya')->latest()->take(5)->get();
            @endphp
            @if($recentOffices->count() > 0)
                <div class="flex flex-col">
                    @foreach($recentOffices as $office)
                        <div class="flex items-center justify-between p-4 hover:bg-gray-50/80 rounded-xl transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 font-bold shadow-sm border border-gray-200/50">
                                    {{ substr($office->company_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-text">{{ $office->company_name }}</p>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <i data-lucide="map-pin" class="w-3 h-3 text-gray-400"></i>
                                        <p class="text-xs font-medium text-gray-500">{{ $office->wilaya->name }}</p>
                                    </div>
                                </div>
                            </div>
                            <span class="text-xs px-3 py-1.5 rounded-full font-bold shadow-sm border {{ $office->is_visible ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-50 text-gray-500 border-gray-200' }}">
                                <span class="inline-block w-1.5 h-1.5 rounded-full mr-1.5 {{ $office->is_visible ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                {{ $office->is_visible ? 'Visible' : 'Masqué' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i data-lucide="building-2" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <p class="text-gray-500 font-medium">Aucun bureau pour le moment.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
