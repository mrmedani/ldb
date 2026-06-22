@php
    $settings = App\Models\Setting::getSettings();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Chronorex Express') }} - Réseau des bureaux</title>
    <link rel="icon" href="{{ $settings->favicon_url ?? asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-text bg-background selection:bg-primary/20 selection:text-primary-dark">

    <!-- Navigation -->
    <nav class="fixed top-0 inset-x-0 z-50 bg-white/80 backdrop-blur-md border-b border-border/50 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-3">
                    @if ($settings->logo)
                        <img src="{{ $settings->logo_url }}" alt="Chronorex Express" class="h-10">
                    @else
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-blue-500 text-white font-bold flex items-center justify-center text-lg shadow-md">
                            CR
                        </div>
                        <span class="text-xl font-extrabold tracking-tight">Chronorex<span class="text-primary">Express</span></span>
                    @endif
                </div>
                
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-600 hover:text-primary transition-colors">Tableau de bord</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-primary py-2.5 px-6">
                                Espace Admin
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 sm:pt-40 sm:pb-24 lg:pb-32 overflow-hidden">
        <!-- Abstract Background -->
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-primary/5 via-background to-background"></div>
        <div class="absolute top-0 right-0 -translate-y-12 translate-x-1/3 w-[600px] h-[600px] rounded-full bg-primary/5 blur-3xl -z-10"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/3 -translate-x-1/3 w-[500px] h-[500px] rounded-full bg-blue-500/5 blur-3xl -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-sm font-bold mb-8 ring-1 ring-inset ring-primary/20">
                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                Réseau de bureaux étendu
            </div>
            
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight text-text mb-8">
                Trouvez le bureau <br class="hidden sm:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-600">le plus proche de vous</span>
            </h1>
            
            <p class="mt-6 text-xl leading-8 text-gray-500 max-w-2xl mx-auto font-medium">
                Consultez facilement les coordonnées, adresses et horaires de nos bureaux partenaires répartis sur l'ensemble du territoire national.
            </p>

            <div class="mt-12 max-w-xl mx-auto relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-primary to-blue-500 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative glass-panel rounded-2xl flex items-center p-2 shadow-xl">
                    <i data-lucide="search" class="w-6 h-6 text-gray-400 ml-4"></i>
                    <input type="text" placeholder="Rechercher une wilaya, une commune..." class="w-full bg-transparent border-0 focus:ring-0 text-text px-4 py-3 text-lg placeholder:text-gray-400 font-medium outline-none">
                    <button class="btn-primary px-8 py-3 rounded-xl whitespace-nowrap text-base">
                        Rechercher
                    </button>
                </div>
            </div>
            
            <div class="mt-16 grid grid-cols-2 gap-8 md:grid-cols-4 border-t border-border/50 pt-10">
                <div class="flex flex-col items-center justify-center gap-2">
                    <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-2">
                        <i data-lucide="map" class="w-6 h-6"></i>
                    </div>
                    <p class="text-3xl font-extrabold text-text">58</p>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Wilayas</p>
                </div>
                <div class="flex flex-col items-center justify-center gap-2">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center mb-2">
                        <i data-lucide="building-2" class="w-6 h-6"></i>
                    </div>
                    @php $officeCount = \App\Models\Office::where('is_visible', true)->count(); @endphp
                    <p class="text-3xl font-extrabold text-text">{{ $officeCount > 0 ? $officeCount : '100+' }}</p>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Bureaux actifs</p>
                </div>
                <div class="flex flex-col items-center justify-center gap-2">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center mb-2">
                        <i data-lucide="zap" class="w-6 h-6"></i>
                    </div>
                    <p class="text-3xl font-extrabold text-text">24/7</p>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Accessibilité</p>
                </div>
                <div class="flex flex-col items-center justify-center gap-2">
                    <div class="w-12 h-12 rounded-2xl bg-blue-500/10 text-blue-600 flex items-center justify-center mb-2">
                        <i data-lucide="shield-check" class="w-6 h-6"></i>
                    </div>
                    <p class="text-3xl font-extrabold text-text">100%</p>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Fiabilité</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Offices List Preview Section -->
    <div class="py-24 bg-surface border-t border-border/50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-extrabold tracking-tight text-text sm:text-4xl">Nos bureaux récemment ajoutés</h2>
                <p class="mt-4 text-lg text-gray-500 font-medium">Découvrez notre réseau grandissant de points de contact locaux.</p>
            </div>

            @php
                $recentOffices = \App\Models\Office::with(['wilaya', 'commune'])
                                    ->where('is_visible', true)
                                    ->orderBy('display_order')
                                    ->latest()
                                    ->take(6)
                                    ->get();
            @endphp

            @if($recentOffices->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($recentOffices as $office)
                        <div class="glass-panel rounded-2xl p-6 hover:-translate-y-1 hover:shadow-xl transition-all duration-300 group">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary font-bold flex items-center justify-center text-lg shadow-sm border border-primary/20">
                                        {{ substr($office->company_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-text text-lg">{{ $office->company_name }}</h3>
                                        <div class="flex items-center gap-1.5 mt-1">
                                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-gray-400"></i>
                                            <span class="text-sm font-medium text-gray-500">{{ $office->wilaya->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-3 mt-6 pt-6 border-t border-border/50">
                                <div class="flex items-center gap-3 text-sm text-gray-600">
                                    <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center shrink-0">
                                        <i data-lucide="phone" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                    <div class="font-semibold">{{ $office->phone }}</div>
                                </div>
                                @if($office->address)
                                    <div class="flex items-center gap-3 text-sm text-gray-600">
                                        <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center shrink-0">
                                            <i data-lucide="map" class="w-4 h-4 text-gray-400"></i>
                                        </div>
                                        <div class="truncate">{{ $office->address }}</div>
                                    </div>
                                @endif
                            </div>

                            @if($office->google_maps)
                                <a href="{{ $office->google_maps }}" target="_blank" class="mt-6 w-full flex items-center justify-center gap-2 py-2.5 rounded-xl bg-gray-50 hover:bg-gray-100 text-sm font-bold text-gray-700 transition-colors border border-gray-200">
                                    <i data-lucide="navigation" class="w-4 h-4"></i> Itinéraire
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-12 text-center">
                    <button class="btn-secondary px-6 py-3">Voir tous les bureaux <i data-lucide="arrow-right" class="w-4 h-4 ml-2 inline"></i></button>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="map-pin" class="w-10 h-10 text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Aucun bureau disponible</h3>
                    <p class="text-gray-500">Revenez bientôt pour découvrir notre réseau.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-3">
                    @if ($settings->logo)
                        <img src="{{ $settings->logo_url }}" alt="Chronorex Express" class="h-8 grayscale opacity-50">
                    @else
                        <span class="text-xl font-extrabold tracking-tight text-gray-400">Chronorex<span class="text-gray-300">Express</span></span>
                    @endif
                </div>
                <p class="text-gray-500 text-sm font-medium">
                    &copy; {{ date('Y') }} Chronorex Express. Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>

    <!-- Initialize Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
