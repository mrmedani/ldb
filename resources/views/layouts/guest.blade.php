@php $settings = App\Models\Setting::getSettings(); @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light">
    <meta name="theme-color" content="#F8FAFC">
    <title>{{ config('app.name', 'Chronorex Express') }} - Auth</title>
    <link rel="icon" type="image/x-icon" href="{{ $settings->favicon_url ?? asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-surface text-text min-h-screen relative overflow-x-hidden flex selection:bg-primary/20 selection:text-primary-dark">
    
    <!-- Left Side: Visual Brand Area -->
    <div class="hidden lg:flex lg:w-5/12 relative items-center justify-center overflow-hidden">
        <!-- Vibrant Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-dark via-primary to-blue-400"></div>
        
        <!-- Abstract Glassmorphism Overlay Elements -->
        <div class="absolute -bottom-48 -left-48 w-[40rem] h-[40rem] rounded-full bg-white/10 blur-3xl mix-blend-overlay animate-pulse" style="animation-duration: 7s;"></div>
        <div class="absolute top-1/4 -right-20 w-80 h-80 rounded-full bg-blue-300/30 blur-3xl mix-blend-overlay"></div>
        <div class="absolute top-10 left-10 w-20 h-20 bg-white/5 rounded-2xl backdrop-blur-md border border-white/10 rotate-12"></div>
        <div class="absolute bottom-40 right-20 w-32 h-32 bg-white/5 rounded-3xl backdrop-blur-md border border-white/10 -rotate-12"></div>
        
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCI+CjxwYXRoIGQ9Ik00MCAwaS00MHY0MGg0MFYweiIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNMCAwaDQwdjQwaC00MFYweiIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMDUpIiBzdHJva2Utd2lkdGg9IjEiLz4KPC9zdmc+')] opacity-30"></div>

        <div class="relative z-10 w-full max-w-lg px-12 text-white">
            <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)" x-show="show" x-transition:enter="transition ease-out duration-1000 motion-reduce:transition-none" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                @if ($settings->logo)
                    <img src="{{ $settings->logo_url }}" alt="Chronorex Express" class="h-16 mb-10 brightness-0 invert filter drop-shadow-md">
                @else
                    <div class="w-20 h-20 rounded-[24px] bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl flex items-center justify-center text-white font-extrabold text-3xl mb-10 tracking-tighter">CR</div>
                @endif
                <h2 class="text-4xl lg:text-5xl font-extrabold mb-6 tracking-tight leading-tight">Administration <br><span class="text-white/80">des bureaux</span></h2>
                <p class="text-lg text-white/70 font-medium leading-relaxed max-w-md">Gérez et partagez facilement les informations des bureaux Chronorex Express avec vos clients.</p>
                
                <div class="mt-12 flex items-center gap-4 text-white/50 text-sm font-medium">
                    <div class="h-px bg-white/20 flex-1"></div>
                    <p>Réseau Chronorex</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side: Auth Form -->
    <div class="w-full lg:w-7/12 min-h-screen flex items-center justify-center p-6 sm:p-12 lg:p-20 relative bg-surface">
        <div class="w-full max-w-md">
            <!-- Mobile Logo -->
            <div class="lg:hidden flex justify-center mb-12">
                @if ($settings->logo)
                    <img src="{{ $settings->logo_url }}" alt="Chronorex Express" class="h-12 drop-shadow-sm">
                @else
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center text-white font-bold text-2xl shadow-xl shadow-primary/20 ring-4 ring-primary/10">CR</div>
                @endif
            </div>

            <!-- Main Auth Component Area -->
            <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)" x-show="show" x-transition:enter="transition ease-out duration-700 motion-reduce:transition-none" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                {{ $slot }}
            </div>
            
            <p class="text-center text-sm font-medium text-gray-400 mt-12 lg:mt-24">&copy; {{ date('Y') }} Chronorex Express. Tous droits réservés.</p>
        </div>
    </div>

    @livewireScripts
</body>
</html>
