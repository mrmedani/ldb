<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Installation terminée — Chronorex Express</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-background text-text min-h-screen">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md text-center">
            <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h1 class="text-2xl font-bold mb-2">Installation terminée</h1>
            <p class="text-gray-500 mb-8">Votre plateforme CHRONOREX EXPRESS est prête.</p>

            <div class="bg-surface rounded-2xl border border-border shadow-sm p-6 mb-6 text-left">
                <h2 class="font-semibold mb-3">Informations de connexion</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between p-2 bg-gray-50 rounded-lg">
                        <span class="text-gray-500">Email</span>
                        <span class="font-medium">{{ session('email') }}</span>
                    </div>
                    <div class="flex justify-between p-2 bg-gray-50 rounded-lg">
                        <span class="text-gray-500">Mot de passe</span>
                        <span class="font-medium">{{ session('password') }}</span>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-3">Conservez ces informations. Elles ne seront plus affichées.</p>
            </div>

            <div class="flex flex-col gap-3">
                <a href="{{ route('login') }}" class="w-full py-3 px-4 bg-primary text-white rounded-xl text-sm font-semibold hover:brightness-110 transition-all">
                    Aller à la connexion
                </a>
                <a href="{{ route('home') }}" class="w-full py-3 px-4 border border-border text-text rounded-xl text-sm font-medium hover:bg-gray-50 transition-all">
                    Voir le site public
                </a>
            </div>
        </div>
    </div>
</body>
</html>
