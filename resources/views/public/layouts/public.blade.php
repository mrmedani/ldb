@php $settings = App\Models\Setting::getSettings(); @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) — Chronorex Express</title>
    <meta name="description" content="Trouvez rapidement le bureau CHRONOREX EXPRESS dans votre wilaya.">
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

    <header class="bg-surface/70 backdrop-blur-xl border-b border-border/50 sticky top-0 z-50 shadow-[0_4px_30px_rgba(0,0,0,0.02)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <div class="flex items-center gap-3">
                    <a href="/" class="transition-transform hover:scale-105 duration-300 flex items-center gap-3">
                        @if ($settings->logo)
                            <img src="{{ $settings->logo_url }}" alt="Chronorex Express" class="h-9 w-auto drop-shadow-sm">
                        @else
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-primary/20">CR</div>
                            <span class="font-extrabold text-sm sm:text-base tracking-tight text-text">CHRONOREX EXPRESS</span>
                        @endif
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.dashboard') }}" wire:navigate class="text-sm font-semibold text-gray-500 hover:text-primary transition-colors hover:bg-primary/5 px-3 py-2 rounded-lg">
                        Administration
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="min-h-[calc(100vh-16rem)] relative z-10">
        @yield('content')
    </main>

    <footer class="bg-surface/80 backdrop-blur-md border-t border-border/50 mt-16 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm font-medium text-gray-500">&copy; {{ date('Y') }} CHRONOREX EXPRESS. Tous droits réservés.</p>
                <div class="flex items-center gap-6">
                    <span class="text-sm font-semibold text-primary bg-primary/10 px-3 py-1 rounded-full">Livraison express dans toute l'Algérie</span>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
