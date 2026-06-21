<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Installation — Chronorex Express</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-background text-text min-h-screen">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-2xl">
            <div class="text-center mb-8">
                <div class="w-14 h-14 rounded-2xl bg-primary flex items-center justify-center text-white font-bold text-xl mx-auto mb-4 shadow-lg shadow-primary/20">CR</div>
                <h1 class="text-2xl font-bold">Installation</h1>
                <p class="text-gray-500 mt-1">CHRONOREX EXPRESS — Plateforme de gestion des bureaux</p>
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
                        <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-sm font-semibold">1</div>
                        <span class="font-semibold text-sm">Prérequis</span>
                        <div class="flex-1 h-px bg-border mx-2"></div>
                        <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center text-sm font-semibold">2</div>
                        <span class="text-sm text-gray-400">Base de données</span>
                        <div class="flex-1 h-px bg-border mx-2"></div>
                        <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center text-sm font-semibold">3</div>
                        <span class="text-sm text-gray-400">Administrateur</span>
                    </div>

                    <h2 class="text-lg font-semibold mb-4">Vérification des prérequis</h2>

                    <div class="space-y-3 mb-6">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Extensions PHP</h3>
                        @foreach($checks['requirements'] as $req)
                            <div class="flex items-center justify-between p-3 rounded-lg {{ $req['passed'] ? 'bg-green-50' : 'bg-red-50' }}">
                                <div class="flex items-center gap-2">
                                    @if($req['passed'])
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    @endif
                                    <span class="text-sm {{ $req['passed'] ? 'text-green-800' : 'text-red-800' }}">{{ $req['label'] }}</span>
                                </div>
                                <span class="text-xs {{ $req['passed'] ? 'text-green-600' : 'text-red-600' }}">{{ $req['value'] ?? ($req['passed'] ? 'OK' : 'Manquant') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-3 mb-8">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Permissions</h3>
                        @foreach($checks['permissions'] as $perm)
                            <div class="flex items-center justify-between p-3 rounded-lg {{ $perm['passed'] ? 'bg-green-50' : 'bg-red-50' }}">
                                <div class="flex items-center gap-2">
                                    @if($perm['passed'])
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    @endif
                                    <span class="text-sm {{ $perm['passed'] ? 'text-green-800' : 'text-red-800' }}">{{ $perm['label'] }}</span>
                                </div>
                                <span class="text-xs {{ $perm['passed'] ? 'text-green-600' : 'text-red-600' }}">{{ $perm['passed'] ? 'OK' : 'Erreur' }}</span>
                            </div>
                        @endforeach
                    </div>

                    @php $allPassed = collect($checks['requirements'])->every('passed') && collect($checks['permissions'])->every('passed'); @endphp

                    @if($allPassed)
                        <a href="{{ route('install.database') }}" class="inline-flex items-center justify-center w-full py-3 px-4 bg-primary text-white rounded-xl text-sm font-semibold hover:brightness-110 transition-all">
                            Continuer vers la base de données
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700">
                            Veuillez corriger les erreurs ci-dessus avant de continuer.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
