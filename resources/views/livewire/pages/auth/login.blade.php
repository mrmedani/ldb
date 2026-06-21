<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-10 text-center lg:text-left">
        <h1 class="text-3xl lg:text-4xl font-extrabold text-text tracking-tight mb-3">Bienvenue 👋</h1>
        <p class="text-gray-500 font-medium text-sm lg:text-base">Connectez-vous à votre espace d'administration pour continuer.</p>
    </div>

    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <div class="space-y-2 relative">
            <label for="email" class="block text-sm font-semibold text-text">Adresse email</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors duration-300 group-focus-within:text-primary text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username" placeholder="admin@chronorex.dz"
                    class="block w-full rounded-2xl border-2 border-transparent bg-background pl-11 pr-4 py-3.5 text-sm text-text placeholder-gray-400 transition-all duration-300 focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:bg-gray-100/80 outline-none">
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <div class="space-y-2 relative">
            <label for="password" class="block text-sm font-semibold text-text">Mot de passe</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors duration-300 group-focus-within:text-primary text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                    class="block w-full rounded-2xl border-2 border-transparent bg-background pl-11 pr-4 py-3.5 text-sm text-text placeholder-gray-400 transition-all duration-300 focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:bg-gray-100/80 outline-none">
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <label for="remember" class="flex items-center gap-3 cursor-pointer group">
                <div class="relative flex items-center">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border-2 border-border bg-background transition-all checked:border-primary checked:bg-primary hover:border-primary focus:outline-none focus:ring-4 focus:ring-primary/20">
                    <div class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-white opacity-0 transition-opacity peer-checked:opacity-100">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" stroke="currentColor" stroke-width="1">
                          <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <span class="text-sm font-medium text-gray-500 group-hover:text-text transition-colors">Se souvenir de moi</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate class="text-sm font-semibold text-primary hover:text-primary-dark hover:underline underline-offset-4 transition-all">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <button type="submit" class="group relative w-full overflow-hidden rounded-2xl bg-primary py-4 px-4 text-sm font-bold text-white shadow-[0_8px_25px_rgb(0,102,255,0.25)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_12px_35px_rgb(0,102,255,0.35)] active:translate-y-0 active:shadow-[0_4px_15px_rgb(0,102,255,0.2)] mt-4">
            <div class="absolute inset-0 bg-white/20 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] skew-x-12"></div>
            <span class="relative flex items-center justify-center gap-2">
                Se connecter
                <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </span>
        </button>
    </form>
    
    <style>
        @keyframes shimmer {
            100% {
                transform: translateX(200%);
            }
        }
    </style>
</div>
