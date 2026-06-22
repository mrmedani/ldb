@php $settings = App\Models\Setting::getSettings(); @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $settings->site_name ?? config('app.name'))</title>
    <meta name="description" content="{{ $settings->meta_description ?? 'Trouvez rapidement le bureau CHRONOREX EXPRESS dans votre wilaya.' }}">
    <link rel="icon" href="{{ $settings->favicon_url ?? asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-background text-text selection:bg-primary/20 selection:text-primary-dark">
    <!-- Ambient Background -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none" aria-hidden="true">
        <div class="absolute -top-[20%] -right-[10%] w-[800px] h-[800px] rounded-full bg-primary/5 blur-[100px] mix-blend-multiply animate-pulse" style="animation-duration: 8s;"></div>
        <div class="absolute -bottom-[20%] -left-[10%] w-[600px] h-[600px] rounded-full bg-blue-300/10 blur-[80px] mix-blend-multiply animate-pulse" style="animation-duration: 10s;"></div>
        <div class="absolute top-[40%] left-[20%] w-[400px] h-[400px] rounded-full bg-indigo-300/5 blur-[100px] mix-blend-multiply"></div>
    </div>

    <!-- Navigation -->
    <nav class="sticky top-0 inset-x-0 z-50 bg-white/80 backdrop-blur-md border-b border-border/50 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-3">
                    <a href="/" class="flex items-center gap-3">
                        @if ($settings->logo)
                            <img src="{{ $settings->logo_url }}" alt="Chronorex Express" class="h-10">
                        @else
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-blue-500 text-white font-bold flex items-center justify-center text-lg shadow-md">
                                {{ substr($settings->site_name ?? 'CR', 0, 2) }}
                            </div>
                            <span class="text-xl font-extrabold tracking-tight">{{ $settings->site_name ?? 'Chronorex' }}<span class="text-primary">Express</span></span>
                        @endif
                    </a>
                </div>
                
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-600 hover:text-primary transition-colors flex items-center gap-1">
                                <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Tableau de bord
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="min-h-[calc(100vh-16rem)] relative z-10">
        @yield('content')
    </main>

    <footer class="bg-surface/80 backdrop-blur-md border-t border-border/50 mt-16 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm font-medium text-gray-500">{{ str_replace('{year}', date('Y'), $settings->footer_copyright ?? '&copy; {year} CHRONOREX EXPRESS. Tous droits réservés.') }}</p>
                <div class="flex items-center gap-6">
                    <span class="text-sm font-semibold text-primary bg-primary/10 px-3 py-1 rounded-full">{{ $settings->footer_tagline ?? 'Livraison express dans toute l\'Algérie' }}</span>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
