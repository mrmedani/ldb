<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
            <i data-lucide="user" class="w-5 h-5"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold text-text">
                Informations du Profil
            </h2>
            <p class="text-sm text-gray-500 font-medium mt-0.5">
                Mettez à jour le nom et l'adresse e-mail de votre compte.
            </p>
        </div>
    </header>

    <form wire:submit="updateProfileInformation" class="space-y-6">
        <div class="space-y-1.5 group">
            <label for="name" class="label-modern group-focus-within:text-primary">Nom complet</label>
            <input wire:model="name" id="name" name="name" type="text" class="input-modern" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="space-y-1.5 group">
            <label for="email" class="label-modern group-focus-within:text-primary">Adresse e-mail</label>
            <input wire:model="email" id="email" name="email" type="email" class="input-modern" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mt-3">
                    <p class="text-sm font-semibold text-amber-800 flex items-center gap-2">
                        <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                        Votre adresse e-mail n'est pas vérifiée.
                    </p>
                    <button wire:click.prevent="sendVerification" class="mt-2 text-sm font-bold text-primary hover:underline transition-all">
                        Cliquez ici pour renvoyer l'e-mail de vérification.
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-semibold text-green-600 flex items-center gap-1.5">
                            <i data-lucide="check" class="w-4 h-4"></i>
                            Un nouveau lien de vérification a été envoyé.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i>
                Enregistrer
            </button>

            <x-action-message class="text-sm font-bold text-emerald-600 flex items-center gap-1.5" on="profile-updated">
                <i data-lucide="check" class="w-4 h-4"></i> Enregistré.
            </x-action-message>
        </div>
    </form>
</section>
