@php $settings = App\Models\Setting::getSettings(); @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') — {{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ $settings->favicon_url ?? asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-background text-text">
    <div class="flex h-screen overflow-hidden">
        <aside class="hidden lg:flex lg:flex-col w-64 bg-surface border-r border-border">
            <div class="flex items-center gap-3 px-6 h-16 border-b border-border">
                @if ($settings->logo)
                    <img src="{{ $settings->logo_url }}" alt="Chronorex Express" class="h-8 w-auto">
                @else
                    <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-sm">CR</div>
                    <span class="font-semibold text-sm">CHRONOREX EXPRESS</span>
                @endif
            </div>
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.offices.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.offices.*') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="building-2" class="w-5 h-5"></i>
                    <span>Gestion des bureaux</span>
                </a>
                <a href="{{ route('admin.settings') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.settings') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="settings" class="w-5 h-5"></i>
                    <span>Paramètres</span>
                </a>
            </nav>
            <div class="border-t border-border p-3">
                <a href="{{ route('profile') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
                    <i data-lucide="user" class="w-5 h-5"></i>
                    <span>Profil</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-red-600 transition-all duration-200 w-full">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
        </aside>
        <div class="flex flex-col flex-1 min-w-0">
            <header class="h-16 bg-surface border-b border-border flex items-center justify-between px-4 lg:px-6">
                <button x-data @click="$el.closest('body').querySelector('aside').classList.toggle('hidden')" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div class="flex-1"></div>
                <div class="flex items-center gap-4">
                    <div class="relative hidden sm:block">
                        <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="Rechercher..." class="pl-9 pr-4 py-2 text-sm border border-border rounded-lg bg-background focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary w-64" />
                    </div>
                    <a href="{{ route('profile') }}" wire:navigate class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900">
                        <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-semibold">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <span class="hidden sm:block">{{ Auth::user()->name }}</span>
                    </a>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-4 lg:p-6">
                <div x-data="{ show: false, message: '', type: 'success' }" x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 4000)" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="fixed bottom-6 right-6 z-50" style="display: none;">
                    <div :class="type === 'success' ? 'bg-success text-white' : 'bg-primary text-white'" class="px-5 py-3 rounded-xl shadow-lg text-sm font-medium flex items-center gap-2">
                        <i :data-lucide="type === 'success' ? 'check-circle' : 'info'" class="w-5 h-5"></i>
                        <span x-text="message"></span>
                    </div>
                </div>
                @yield('content')
            </main>
        </div>
    </div>
    @livewireScripts
</body>
</html>
