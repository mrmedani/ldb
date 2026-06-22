@php $settings = App\Models\Setting::getSettings(); @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') — {{ config('app.name') }}</title>
    <link rel="icon" href="{{ $settings->favicon_url ?? asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <!-- SweetAlert2 for Premium Popups/Confirmations -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let confirmedElements = new WeakSet();
            let nativeConfirm = window.confirm;
            
            // Intercept click on elements with wire:confirm
            document.addEventListener('click', (event) => {
                let target = event.target.closest('[wire\\:confirm]');
                if (!target) return;
                
                if (confirmedElements.has(target)) {
                    return; // Already confirmed, proceed to trigger action
                }
                
                event.preventDefault();
                event.stopImmediatePropagation();
                
                let message = target.getAttribute('wire:confirm');
                
                Swal.fire({
                    title: 'Confirmation',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#6366F1', // Primary Indigo 500
                    cancelButtonColor: '#71717A', // Zinc 500
                    confirmButtonText: 'Confirmer',
                    cancelButtonText: 'Annuler',
                    customClass: {
                        popup: 'rounded-2xl border border-border/50 shadow-premium bg-surface/95 backdrop-blur-xl',
                        confirmButton: 'px-5 py-2.5 bg-gradient-to-r from-primary to-primary-dark text-white rounded-xl text-sm font-semibold shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 active:scale-95 active:translate-y-0 mx-1 cursor-pointer',
                        cancelButton: 'px-5 py-2.5 bg-white border border-border text-text rounded-xl text-sm font-semibold shadow-sm hover:bg-gray-50 transition-all duration-200 active:scale-95 mx-1 cursor-pointer',
                        actions: 'gap-2 pt-2'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        confirmedElements.add(target);
                        
                        // Temporarily bypass confirm function
                        window.confirm = () => true;
                        target.click();
                        window.confirm = nativeConfirm;
                        
                        setTimeout(() => {
                            confirmedElements.delete(target);
                        }, 100);
                    }
                });
            }, true); // Capture phase to intercept before Livewire

            // Override global window.alert
            window.alert = function(message) {
                Swal.fire({
                    title: 'Notification',
                    text: message,
                    icon: 'info',
                    confirmButtonColor: '#6366F1',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'rounded-2xl border border-border/50 shadow-premium bg-surface/95 backdrop-blur-xl',
                        confirmButton: 'px-5 py-2.5 bg-gradient-to-r from-primary to-primary-dark text-white rounded-xl text-sm font-semibold shadow-sm hover:shadow-md transition-all duration-200 active:scale-95 cursor-pointer'
                    },
                    buttonsStyling: false
                });
            };
        });
    </script>
</head>
<body class="font-sans antialiased bg-background text-text selection:bg-primary/20 selection:text-primary-dark">
    <!-- Ambient Background (Desktop only for performance) -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none hidden sm:block" aria-hidden="true">
        <div class="absolute -top-[20%] -right-[10%] w-[800px] h-[800px] rounded-full bg-primary/5 blur-[100px] mix-blend-multiply animate-pulse" style="animation-duration: 8s;"></div>
        <div class="absolute -bottom-[20%] -left-[10%] w-[600px] h-[600px] rounded-full bg-blue-300/10 blur-[80px] mix-blend-multiply animate-pulse" style="animation-duration: 10s;"></div>
        <div class="absolute top-[40%] left-[20%] w-[400px] h-[400px] rounded-full bg-indigo-300/5 blur-[100px] mix-blend-multiply"></div>
    </div>

    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        <!-- Overlay for mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-40 lg:hidden"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 bg-surface/95 backdrop-blur-xl border-r border-border/50 flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:w-64 xl:w-72 shadow-premium lg:shadow-none">
            <div class="flex items-center gap-3 px-6 h-20 border-b border-border/50 shrink-0">
                @if ($settings->logo)
                    <img src="{{ $settings->logo_url }}" alt="Chronorex Express" class="h-9 w-auto drop-shadow-sm">
                @else
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-primary/20">CR</div>
                    <span class="font-extrabold text-sm tracking-tight text-text">CHRONOREX EXPRESS</span>
                @endif
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Menu Principal</p>
                
                <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 group relative {{ request()->routeIs('admin.dashboard') ? 'text-primary bg-primary/10' : 'text-gray-600 hover:bg-gray-100/80 hover:text-gray-900' }}">
                    @if(request()->routeIs('admin.dashboard'))
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-primary rounded-r-full"></div>
                    @endif
                    <i data-lucide="layout-dashboard" class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-primary' : 'text-gray-400 group-hover:text-gray-600 transition-colors' }}"></i>
                    <span>Tableau de bord</span>
                </a>
                
                <a href="{{ route('admin.offices.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 group relative {{ request()->routeIs('admin.offices.*') ? 'text-primary bg-primary/10' : 'text-gray-600 hover:bg-gray-100/80 hover:text-gray-900' }}">
                    @if(request()->routeIs('admin.offices.*'))
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-primary rounded-r-full"></div>
                    @endif
                    <i data-lucide="building-2" class="w-5 h-5 {{ request()->routeIs('admin.offices.*') ? 'text-primary' : 'text-gray-400 group-hover:text-gray-600 transition-colors' }}"></i>
                    <span>Gestion des bureaux</span>
                </a>
                
                <a href="{{ route('admin.settings') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 group relative {{ request()->routeIs('admin.settings') ? 'text-primary bg-primary/10' : 'text-gray-600 hover:bg-gray-100/80 hover:text-gray-900' }}">
                    @if(request()->routeIs('admin.settings'))
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-primary rounded-r-full"></div>
                    @endif
                    <i data-lucide="settings" class="w-5 h-5 {{ request()->routeIs('admin.settings') ? 'text-primary' : 'text-gray-400 group-hover:text-gray-600 transition-colors' }}"></i>
                    <span>Paramètres système</span>
                </a>
            </nav>
            
            <div class="p-4 border-t border-border/50">
                <div class="bg-gray-50/80 rounded-2xl p-4 border border-gray-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold uppercase shrink-0">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="font-bold text-sm text-text truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs font-medium text-gray-500 truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-gray-200/50">
                        <a href="{{ route('profile') }}" wire:navigate class="p-2 text-gray-500 hover:text-primary hover:bg-primary/10 rounded-lg transition-colors tooltip-trigger" title="Profil">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors tooltip-trigger" title="Déconnexion">
                                <i data-lucide="log-out" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 min-w-0">
            <!-- Topbar -->
            <header class="h-20 bg-surface/70 backdrop-blur-xl border-b border-border/50 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-30 sticky top-0">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2.5 rounded-xl text-gray-500 hover:bg-gray-100/80 focus:outline-none transition-colors">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    
                    <!-- Breadcrumb -->
                    <nav class="hidden md:flex text-sm font-medium text-gray-500">
                        <ol class="flex items-center space-x-2">
                            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a></li>
                            @if(request()->routeIs('admin.offices.*'))
                                <li><i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i></li>
                                <li><span class="text-gray-900 font-semibold">Bureaux</span></li>
                            @endif
                            @if(request()->routeIs('admin.settings'))
                                <li><i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i></li>
                                <li><span class="text-gray-900 font-semibold">Paramètres</span></li>
                            @endif
                        </ol>
                    </nav>
                </div>
                
                <div class="flex items-center gap-4 lg:gap-6">
                    <!-- Command Menu (Mockup UI) -->
                    <button class="hidden sm:flex items-center gap-3 px-4 py-2 bg-gray-50/80 hover:bg-gray-100 border border-gray-200 rounded-xl text-sm text-gray-500 transition-colors w-64">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                        <span>Rechercher...</span>
                        <kbd class="ml-auto px-2 py-0.5 bg-white border border-gray-200 rounded text-xs font-sans font-bold text-gray-400 shadow-sm">Cmd+K</kbd>
                    </button>
                    <button class="sm:hidden p-2.5 rounded-xl text-gray-500 hover:bg-gray-100/80 transition-colors">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </button>

                    <div class="h-6 w-px bg-border/50 hidden sm:block"></div>
                    
                    <button class="relative p-2.5 rounded-xl text-gray-500 hover:bg-gray-100/80 transition-colors group">
                        <i data-lucide="bell" class="w-5 h-5 group-hover:text-primary transition-colors"></i>
                        <span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-surface"></span>
                    </button>
                </div>
            </header>
            
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 relative">
                <!-- Toast Notifications -->
                <div x-data="{ show: false, message: '', type: 'success' }" 
                     x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 4000)" 
                     x-show="show" 
                     x-transition:enter="transition ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
                     x-transition:leave="transition ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 scale-95" 
                     class="fixed bottom-6 right-6 z-[60]" style="display: none;">
                    <div :class="type === 'success' ? 'bg-gray-900 border-gray-800' : 'bg-red-600 border-red-700'" class="px-5 py-4 rounded-2xl shadow-premium border text-sm font-semibold text-white flex items-center gap-3">
                        <i :data-lucide="type === 'success' ? 'check-circle' : 'alert-circle'" class="w-5 h-5" :class="type === 'success' ? 'text-green-400' : 'text-white'"></i>
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
