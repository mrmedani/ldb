<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

@php $settings = App\Models\Setting::getSettings(); @endphp
<nav x-data="{ open: false }" class="bg-surface/70 backdrop-blur-xl border-b border-border/50 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 lg:h-20">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" wire:navigate class="transition-transform hover:scale-105 duration-300">
                        @if ($settings->logo)
                            <img src="{{ $settings->logo_url }}" alt="Chronorex Express" class="h-9 w-auto drop-shadow-sm">
                        @else
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-primary/20">CR</div>
                        @endif
                    </a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('admin.dashboard') }}" wire:navigate class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.offices.index') }}" wire:navigate class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all duration-300 {{ request()->routeIs('admin.offices.*') ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300' }}">
                        Bureaux
                    </a>
                    <a href="{{ route('admin.settings') }}" wire:navigate class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all duration-300 {{ request()->routeIs('admin.settings') ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300' }}">
                        Paramètres
                    </a>
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-xl text-gray-500 bg-surface/50 hover:bg-gray-100/50 hover:text-gray-700 focus:outline-none transition ease-in-out duration-300">
                            <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center mr-2 font-bold uppercase text-xs">
                                <span x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name.charAt(0)" x-on:profile-updated.window="name = $event.detail.name"></span>
                            </div>
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name" class="font-semibold text-text"></div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-border/50">
                            <p class="text-sm text-gray-500">Connecté en tant que</p>
                            <p class="text-sm font-medium text-text truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="py-1">
                            <x-dropdown-link :href="route('profile')" wire:navigate class="hover:bg-primary/5 hover:text-primary transition-colors flex items-center gap-2">
                                <i data-lucide="user" class="w-4 h-4"></i> Profil
                            </x-dropdown-link>
                            <button wire:click="logout" class="w-full text-start">
                                <x-dropdown-link class="hover:bg-red-50 hover:text-red-600 transition-colors flex items-center gap-2">
                                    <i data-lucide="log-out" class="w-4 h-4"></i> Déconnexion
                                </x-dropdown-link>
                            </button>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-300">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex transition-all" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden transition-all" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="sm:hidden absolute w-full bg-surface border-b border-border shadow-xl">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" wire:navigate>
                Dashboard
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.offices.index')" :active="request()->routeIs('admin.offices.*')" wire:navigate>
                Bureaux
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.settings')" :active="request()->routeIs('admin.settings')" wire:navigate>
                Paramètres
            </x-responsive-nav-link>
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200/50">
            <div class="px-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold uppercase">
                    <span x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name.charAt(0)"></span>
                </div>
                <div>
                    <div class="font-medium text-base text-text" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                    <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    Profil
                </x-responsive-nav-link>
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link class="text-red-600 hover:text-red-700 hover:bg-red-50">
                        Déconnexion
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
