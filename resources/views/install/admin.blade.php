<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Installation — Administrateur — Chronorex Express</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-background text-text min-h-screen">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <div class="w-14 h-14 rounded-2xl bg-primary flex items-center justify-center text-white font-bold text-xl mx-auto mb-4 shadow-lg shadow-primary/20">CR</div>
                <h1 class="text-2xl font-bold">Compte administrateur</h1>
                <p class="text-gray-500 mt-1">Créez le compte administrateur principal</p>
            </div>

            <div class="bg-surface rounded-2xl border border-border shadow-sm p-8">
                @if(session('error'))
                    <div class="mb-6 px-4 py-3 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700 flex items-center gap-2">
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center text-sm font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-sm text-green-600">Prérequis</span>
                    <div class="flex-1 h-px bg-border mx-2"></div>
                    <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center text-sm font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-sm text-green-600">Base de données</span>
                    <div class="flex-1 h-px bg-border mx-2"></div>
                    <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-sm font-semibold">3</div>
                    <span class="font-semibold text-sm">Administrateur</span>
                </div>

                <form method="POST" action="{{ route('install.save-admin') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-text mb-1.5">Nom complet</label>
                            <input type="text" name="name" id="name" value="{{ old('name', 'Admin') }}" required
                                class="block w-full rounded-xl border border-border bg-background px-4 py-3 text-sm text-text placeholder-gray-400 focus-visible:border-primary focus-visible:ring-2 focus-visible:ring-primary/20 outline-none transition-colors">
                            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-text mb-1.5">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', 'admin@chronorex.dz') }}" required
                                class="block w-full rounded-xl border border-border bg-background px-4 py-3 text-sm text-text placeholder-gray-400 focus-visible:border-primary focus-visible:ring-2 focus-visible:ring-primary/20 outline-none transition-colors">
                            @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-text mb-1.5">Mot de passe</label>
                            <input type="password" name="password" id="password" required minlength="8"
                                class="block w-full rounded-xl border border-border bg-background px-4 py-3 text-sm text-text placeholder-gray-400 focus-visible:border-primary focus-visible:ring-2 focus-visible:ring-primary/20 outline-none transition-colors">
                            @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-text mb-1.5">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="block w-full rounded-xl border border-border bg-background px-4 py-3 text-sm text-text placeholder-gray-400 focus-visible:border-primary focus-visible:ring-2 focus-visible:ring-primary/20 outline-none transition-colors">
                        </div>
                    </div>
                    <button type="submit" class="mt-6 w-full py-3 px-4 bg-primary text-white rounded-xl text-sm font-semibold hover:brightness-110 transition-all">
                        Terminer l'installation
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
