<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
            <i data-lucide="key-round" class="w-5 h-5"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold text-text">
                Sécurité du Compte
            </h2>
            <p class="text-sm text-gray-500 font-medium mt-0.5">
                Assurez-vous que votre compte utilise un mot de passe fort et sécurisé.
            </p>
        </div>
    </header>

    <form wire:submit="updatePassword" class="space-y-6">
        <div class="space-y-1.5 group">
            <label for="update_password_current_password" class="label-modern group-focus-within:text-primary">Mot de passe actuel</label>
            <input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="input-modern" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div class="space-y-1.5 group">
            <label for="update_password_password" class="label-modern group-focus-within:text-primary">Nouveau mot de passe</label>
            <input wire:model="password" id="update_password_password" name="password" type="password" class="input-modern" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="space-y-1.5 group">
            <label for="update_password_password_confirmation" class="label-modern group-focus-within:text-primary">Confirmer le mot de passe</label>
            <input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="input-modern" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="btn-primary">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
                Mettre à jour
            </button>

            <x-action-message class="text-sm font-bold text-emerald-600 flex items-center gap-1.5" on="password-updated">
                <i data-lucide="check" class="w-4 h-4"></i> Mot de passe mis à jour.
            </x-action-message>
        </div>
    </form>
</section>
