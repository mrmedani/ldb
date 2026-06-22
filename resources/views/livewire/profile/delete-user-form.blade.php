<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <header class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
            <i data-lucide="alert-triangle" class="w-5 h-5"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold text-text">
                Supprimer le Compte
            </h2>
            <p class="text-sm text-gray-500 font-medium mt-0.5">
                Une fois votre compte supprimé, toutes ses ressources et données seront définitivement perdues.
            </p>
        </div>
    </header>

    <div>
        <button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-50 text-red-700 border border-red-200 rounded-lg text-sm font-semibold shadow-sm hover:bg-red-600 hover:text-white hover:border-red-600 hover:-translate-y-0.5 transition-all duration-200 active:scale-95 active:translate-y-0"
        >
            <i data-lucide="trash-2" class="w-4 h-4"></i>
            Supprimer le compte
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6 sm:p-8 space-y-6">

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                </div>
                <h2 class="text-lg font-bold text-text">
                    Êtes-vous sûr de vouloir supprimer votre compte ?
                </h2>
            </div>

            <p class="text-sm text-gray-500 font-medium leading-relaxed">
                Une fois votre compte supprimé, toutes ses ressources et données seront définitivement perdues. Veuillez entrer votre mot de passe pour confirmer la suppression définitive.
            </p>

            <div class="space-y-1.5 group">
                <label for="password" class="label-modern group-focus-within:text-primary">Mot de passe</label>
                <input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="input-modern max-w-md"
                    placeholder="Entrez votre mot de passe pour confirmer"
                    required
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-border/50">
                <button type="button" x-on:click="$dispatch('close')" class="btn-secondary">
                    Annuler
                </button>

                <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-600 text-white rounded-lg text-sm font-semibold shadow-sm hover:bg-red-700 hover:-translate-y-0.5 transition-all duration-200 active:scale-95 active:translate-y-0">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                    Confirmer la suppression
                </button>
            </div>
        </form>
    </x-modal>
</section>
