<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <div class="mb-6 text-center lg:text-left">
        <h1 class="text-3xl lg:text-4xl font-extrabold text-text tracking-tight mb-3">Mot de passe oublié ? 🔒</h1>
        <p class="text-gray-500 font-medium text-sm lg:text-base leading-relaxed">
            Pas de problème. Indiquez-nous votre adresse e-mail et nous vous enverrons un lien de réinitialisation.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="space-y-6">
        <div class="space-y-2 group">
            <label for="email" class="label-modern group-focus-within:text-primary">Adresse email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors duration-300 group-focus-within:text-primary text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <input wire:model="email" id="email" type="email" name="email" required autofocus placeholder="admin@chronorex.dz"
                    class="input-modern pl-11 py-3.5 @error('email') !border-red-500 !ring-red-500/20 @enderror">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('login') }}" wire:navigate class="text-sm font-semibold text-gray-500 hover:text-primary transition-colors flex items-center gap-1">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Retour à la connexion
            </a>
            <button type="submit" class="btn-primary">
                Envoyer le lien
            </button>
        </div>
    </form>
</div>
