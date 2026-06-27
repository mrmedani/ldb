@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-10">
        <h1 class="text-3xl font-extrabold text-text tracking-tight">Tableau de bord</h1>
        <p class="text-gray-500 font-medium mt-2">Vue d'ensemble de l'activité de Chronorex Express.</p>
    </div>

    @php
        $totalOffices = App\Models\Office::count();
        $visibleOffices = App\Models\Office::where('is_visible', true)->count();
        $hiddenOffices = App\Models\Office::where('is_visible', false)->count();
        $lastModified = App\Models\Office::latest('updated_at')->first();
        $pendingBugReports = App\Models\BugReport::pending()->count();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Card 1 -->
        <div class="glass-panel rounded-2xl p-6 group cursor-default">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-sm font-bold text-gray-400 uppercase tracking-wider">Total bureaux</span>
                <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                    <i data-lucide="building-2" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-4xl font-extrabold text-text relative z-10">{{ $totalOffices }}</p>
        </div>
        
        <!-- Card 2 -->
        <div class="glass-panel rounded-2xl p-6 group cursor-default">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-sm font-bold text-gray-400 uppercase tracking-wider">Bureaux visibles</span>
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="eye" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-4xl font-extrabold text-text relative z-10">{{ $visibleOffices }}</p>
        </div>

        <!-- Card 3 -->
        <div class="glass-panel rounded-2xl p-6 group cursor-default">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-500/5 rounded-full blur-2xl group-hover:bg-red-500/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-sm font-bold text-gray-400 uppercase tracking-wider">Bureaux masqués</span>
                <div class="w-12 h-12 rounded-2xl bg-red-500/10 text-red-600 flex items-center justify-center">
                    <i data-lucide="eye-off" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-4xl font-extrabold text-text relative z-10">{{ $hiddenOffices }}</p>
        </div>

        <!-- Card 4 -->
        <div class="glass-panel rounded-2xl p-6 group cursor-default">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/5 rounded-full blur-2xl group-hover:bg-blue-500/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-sm font-bold text-gray-400 uppercase tracking-wider">Dernière modif.</span>
                <div class="w-12 h-12 rounded-2xl bg-blue-500/10 text-blue-600 flex items-center justify-center">
                    <i data-lucide="clock" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-xl font-bold text-text relative z-10 pt-2">{{ $lastModified ? $lastModified->updated_at->format('d/m/Y H:i') : '—' }}</p>
        </div>
    </div>

    @if($pendingBugReports > 0)
    <div class="relative rounded-2xl p-6 mb-6 border-l-4 border-l-red-500 border border-red-200 bg-gradient-to-r from-red-50 to-amber-50 shadow-lg overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-red-500/[0.03] to-transparent pointer-events-none"></div>
        <div class="flex items-center gap-4 relative">
            <div class="w-14 h-14 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 shadow-sm ring-2 ring-red-200/50">
                <i data-lucide="bug" class="w-7 h-7"></i>
            </div>
            <div class="flex-1">
                <p class="text-lg font-extrabold text-red-800">{{ $pendingBugReports }} signalement{{ $pendingBugReports > 1 ? 's' : '' }} de bug en attente</p>
                <p class="text-sm font-semibold text-red-600/80">Des visiteurs ont signalé des problèmes à examiner.</p>
            </div>
            <a href="{{ route('admin.bug-reports') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl text-sm font-bold shadow-md shadow-red-200 transition-all hover:-translate-y-0.5 active:scale-95">
                Voir les signalements
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
    @endif

    <div class="glass-panel rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-border/50 flex items-center justify-between">
            <h2 class="text-lg font-extrabold text-text tracking-tight">Activité Récente</h2>
            <a href="{{ route('admin.offices.index') }}" class="text-sm font-semibold text-primary hover:text-primary-dark transition-colors">Voir tout &rarr;</a>
        </div>
        <div class="p-0">
            @php
                $recentOffices = App\Models\Office::with('wilaya')->latest()->take(5)->get();
            @endphp
            @if($recentOffices->count() > 0)
                <div class="divide-y divide-border/50">
                    @foreach($recentOffices as $office)
                        <div class="flex items-center justify-between p-4 sm:px-6 hover:bg-gray-50/50 transition-colors group">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-gray-600 font-bold shadow-sm border border-border group-hover:border-primary/20 group-hover:bg-primary/5 group-hover:text-primary transition-colors">
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
                            <div class="flex items-center gap-4">
                                <span class="text-xs px-2.5 py-1 rounded-md font-bold shadow-sm border {{ $office->is_visible ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-gray-50 text-gray-500 border-gray-200' }}">
                                    {{ $office->is_visible ? 'Visible' : 'Masqué' }}
                                </span>
                                <a href="{{ route('admin.offices.edit', $office) }}" class="p-2 text-gray-400 hover:text-primary hover:bg-primary/10 rounded-lg transition-colors opacity-0 group-hover:opacity-100">
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 border border-border">
                        <i data-lucide="inbox" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <p class="text-gray-500 font-medium">Aucun bureau pour le moment.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
