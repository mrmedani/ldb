@php $settings = App\Models\Setting::getSettings(); @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Chronorex Express') }} - Admin</title>
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

    <div class="min-h-screen flex flex-col">
        <livewire:layout.navigation />

        @if (isset($header))
            <header class="bg-surface/70 backdrop-blur-xl border-b border-border/50 shadow-[0_4px_30px_rgba(0,0,0,0.02)] sticky top-0 z-40">
                <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main class="flex-grow py-8 relative z-10 px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>
    </div>
    @livewireScripts
</body>
</html>
