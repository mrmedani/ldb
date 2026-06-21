<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Installation — Base de données — Chronorex Express</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-background text-text min-h-screen">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-2xl">
            <div class="text-center mb-8">
                <div class="w-14 h-14 rounded-2xl bg-primary flex items-center justify-center text-white font-bold text-xl mx-auto mb-4 shadow-lg shadow-primary/20">CR</div>
                <h1 class="text-2xl font-bold">Base de données</h1>
                <p class="text-gray-500 mt-1">Installation de la base de données</p>
            </div>

            <div class="bg-surface rounded-2xl border border-border shadow-sm p-8">
                @if(session('error'))
                    <div class="mb-6 px-4 py-3 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700 flex items-center gap-2">
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-6 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-sm text-green-700 flex items-center gap-2">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-sm text-green-600">Prérequis</span>
                        <div class="flex-1 h-px bg-border mx-2"></div>
                        <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-sm font-semibold">2</div>
                        <span class="font-semibold text-sm">Base de données</span>
                        <div class="flex-1 h-px bg-border mx-2"></div>
                        <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center text-sm font-semibold">3</div>
                        <span class="text-sm text-gray-400">Administrateur</span>
                    </div>

                    <h2 class="text-lg font-semibold mb-4">Connexion à la base de données</h2>

                    <div class="space-y-3 mb-8">
                        @foreach($dbStatus as $check)
                            <div class="flex items-center justify-between p-3 rounded-lg {{ $check['passed'] ? 'bg-green-50' : 'bg-red-50' }}">
                                <div class="flex items-center gap-2">
                                    @if($check['passed'])
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    @endif
                                    <span class="text-sm {{ $check['passed'] ? 'text-green-800' : 'text-red-800' }}">{{ $check['label'] }}</span>
                                </div>
                                <span class="text-xs {{ $check['passed'] ? 'text-green-600' : 'text-red-600' }}">{{ $check['value'] ?? ($check['error'] ?? ($check['passed'] ? 'OK' : 'Erreur')) }}</span>
                            </div>
                        @endforeach
                    </div>

                    @php $dbOk = collect($dbStatus)->every('passed'); @endphp

                    @if($dbOk)
                        <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-sm text-green-700 mb-6">
                            Connexion à la base de données réussie. Cliquez ci-dessous pour installer les tables.
                        </div>
                        <form method="POST" action="{{ route('install.migration') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center justify-center w-full py-3 px-4 bg-primary text-white rounded-xl text-sm font-semibold hover:brightness-110 transition-all">
                                Installer les tables
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </form>
                    @else
                        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700">
                            <p class="font-medium mb-1">Impossible de se connecter à la base de données.</p>
                            <p>Vérifiez les informations dans le fichier <code>.env</code> :</p>
                            <ul class="list-disc list-inside mt-2 space-y-1">
                                <li><code>DB_HOST</code> — hôte MySQL</li>
                                <li><code>DB_PORT</code> — port (3306 par défaut)</li>
                                <li><code>DB_DATABASE</code> — nom de la base</li>
                                <li><code>DB_USERNAME</code> — utilisateur</li>
                                <li><code>DB_PASSWORD</code> — mot de passe</li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
