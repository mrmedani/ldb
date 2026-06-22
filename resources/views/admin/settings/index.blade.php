@extends('admin.layouts.admin')

@section('title', 'Paramètres')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-text tracking-tight">Paramètres</h1>
        <p class="text-gray-500 font-medium mt-2">Configurez l'identité visuelle et les colonnes affichées sur le site public.</p>
    </div>

    @php $settings = App\Models\Setting::getSettings(); @endphp

    @if(session('success'))
        <div class="mb-8 px-5 py-4 rounded-xl bg-green-50 border border-green-200 text-sm text-green-700 flex items-center gap-3 shadow-sm animate-[fadeIn_0.3s_ease-out]">
            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
            </div>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-8 px-5 py-4 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700 flex items-center gap-3 shadow-sm animate-[fadeIn_0.3s_ease-out]">
            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-600"></i>
            </div>
            <span class="font-medium">{{ $errors->first() }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="bg-surface/80 backdrop-blur-md rounded-2xl border border-border/50 shadow-sm overflow-hidden">
        @csrf

        <div class="p-6 lg:p-8 space-y-10">
            <!-- Identité visuelle -->
            <section>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                        <i data-lucide="palette" class="w-5 h-5"></i>
                    </div>
                    <h2 class="text-lg font-bold text-text">Identité visuelle</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-1 group-focus-within:text-primary transition-colors">Favicon</label>
                        <p class="text-xs text-gray-500 mb-4">ICO, PNG ou SVG. 512 Ko max.</p>
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl border-2 border-gray-100 bg-gray-50 flex items-center justify-center overflow-hidden shrink-0 shadow-sm group-hover:border-primary/20 transition-colors">
                                @if ($settings->favicon)
                                    <img src="{{ $settings->favicon_url }}" class="w-8 h-8 object-contain">
                                @else
                                    <i data-lucide="image" class="w-6 h-6 text-gray-300"></i>
                                @endif
                            </div>
                            <input type="file" name="favicon" accept=".ico,.png,.svg" class="block w-full text-sm text-gray-500 file:cursor-pointer file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all">
                        </div>
                        @error('favicon') <p class="text-xs text-red-500 mt-2 font-medium flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}</p> @enderror
                    </div>

                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-1 group-focus-within:text-primary transition-colors">Logo de l'entreprise</label>
                        <p class="text-xs text-gray-500 mb-4">PNG, SVG, JPG ou WebP. 2 Mo max.</p>
                        <div class="flex items-center gap-4">
                            <div class="w-20 h-20 rounded-xl border-2 border-gray-100 bg-gray-50 flex items-center justify-center overflow-hidden shrink-0 shadow-sm group-hover:border-primary/20 transition-colors">
                                @if ($settings->logo)
                                    <img src="{{ $settings->logo_url }}" class="w-16 h-16 object-contain">
                                @else
                                    <i data-lucide="image" class="w-8 h-8 text-gray-300"></i>
                                @endif
                            </div>
                            <input type="file" name="logo" accept=".png,.svg,.jpg,.jpeg,.webp" class="block w-full text-sm text-gray-500 file:cursor-pointer file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all">
                        </div>
                        @error('logo') <p class="text-xs text-red-500 mt-2 font-medium flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}</p> @enderror
                    </div>
                </div>
            </section>

            <hr class="border-border/50">

            <!-- Contenu du site -->
            <section>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-600">
                        <i data-lucide="type" class="w-5 h-5"></i>
                    </div>
                    <h2 class="text-lg font-bold text-text">Contenu du site</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nom du site</label>
                        <input type="text" name="site_name" value="{{ old('site_name', $settings->site_name) }}" class="w-full px-4 py-2.5 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Meta description (SEO)</label>
                        <textarea name="meta_description" rows="2" class="w-full px-4 py-2.5 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300">{{ old('meta_description', $settings->meta_description) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Badge héro</label>
                        <input type="text" name="hero_badge" value="{{ old('hero_badge', $settings->hero_badge) }}" class="w-full px-4 py-2.5 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300">
                        <p class="text-xs text-gray-400 mt-1.5">Texte du badge au-dessus du titre principal</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Texte de recherche (placeholder)</label>
                        <input type="text" name="search_placeholder" value="{{ old('search_placeholder', $settings->search_placeholder) }}" class="w-full px-4 py-2.5 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Titre principal (utilisez un saut de ligne pour la partie en dégradé)</label>
                        <textarea name="hero_title" rows="2" class="w-full px-4 py-2.5 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300 font-mono">{{ old('hero_title', $settings->hero_title) }}</textarea>
                        <p class="text-xs text-gray-400 mt-1.5">La première ligne sera en texte normal, la seconde en dégradé bleu</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Sous-titre</label>
                        <textarea name="hero_subtitle" rows="3" class="w-full px-4 py-2.5 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300">{{ old('hero_subtitle', $settings->hero_subtitle) }}</textarea>
                    </div>
                </div>
            </section>

            <hr class="border-border/50">

            <!-- Pied de page -->
            <section>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-600">
                        <i data-lucide="chevron-down" class="w-5 h-5"></i>
                    </div>
                    <h2 class="text-lg font-bold text-text">Pied de page</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Texte de copyright</label>
                        <input type="text" name="footer_copyright" value="{{ old('footer_copyright', $settings->footer_copyright) }}" class="w-full px-4 py-2.5 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300">
                        <p class="text-xs text-gray-400 mt-1.5">Utilisez <code class="bg-gray-200 px-1 rounded">{year}</code> pour l'année courante</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tagline</label>
                        <input type="text" name="footer_tagline" value="{{ old('footer_tagline', $settings->footer_tagline) }}" class="w-full px-4 py-2.5 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300">
                    </div>
                </div>
            </section>

            <hr class="border-border/50">

            <!-- Statistiques -->
            <section>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-cyan-500/10 flex items-center justify-center text-cyan-600">
                        <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                    </div>
                    <h2 class="text-lg font-bold text-text">Étiquettes des statistiques</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Carte 1</label>
                        <input type="text" name="stats_wilayas_label" value="{{ old('stats_wilayas_label', $settings->stats_wilayas_label) }}" class="w-full px-4 py-2.5 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Carte 2</label>
                        <input type="text" name="stats_offices_label" value="{{ old('stats_offices_label', $settings->stats_offices_label) }}" class="w-full px-4 py-2.5 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Carte 3</label>
                        <input type="text" name="stats_partners_label" value="{{ old('stats_partners_label', $settings->stats_partners_label) }}" class="w-full px-4 py-2.5 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300">
                    </div>
                </div>
            </section>

            <hr class="border-border/50">

            <!-- Colonnes -->
            <section>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-600">
                        <i data-lucide="layout-columns" class="w-5 h-5"></i>
                    </div>
                    <h2 class="text-lg font-bold text-text">Colonnes du tableau public</h2>
                </div>
                <p class="text-sm text-gray-500 mb-6 ml-13">Désactivez une colonne pour la masquer visuellement du tableau accessible à vos clients.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="flex items-center justify-between p-5 rounded-2xl border-2 border-transparent bg-gray-50/50 hover:bg-white hover:border-primary/10 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 cursor-pointer group">
                        <div class="flex items-start gap-4">
                            <div class="mt-0.5 w-8 h-8 rounded-lg bg-white border border-gray-100 shadow-sm flex items-center justify-center text-gray-400 group-hover:text-primary transition-colors">
                                <i data-lucide="hash" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-700">Code Wilaya</p>
                                <p class="text-xs text-gray-500 mt-0.5">Afficher le code numérique</p>
                            </div>
                        </div>
                        <div class="relative flex items-center">
                            <input type="hidden" name="show_code" value="0">
                            <input type="checkbox" name="show_code" value="1" {{ $settings->show_code ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary/20 transition-all duration-300">
                        </div>
                    </label>

                    <label class="flex items-center justify-between p-5 rounded-2xl border-2 border-transparent bg-gray-50/50 hover:bg-white hover:border-primary/10 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 cursor-pointer group">
                        <div class="flex items-start gap-4">
                            <div class="mt-0.5 w-8 h-8 rounded-lg bg-white border border-gray-100 shadow-sm flex items-center justify-center text-gray-400 group-hover:text-primary transition-colors">
                                <i data-lucide="building" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-700">Entreprise partenaire</p>
                                <p class="text-xs text-gray-500 mt-0.5">Afficher le nom du bureau</p>
                            </div>
                        </div>
                        <div class="relative flex items-center">
                            <input type="hidden" name="show_company" value="0">
                            <input type="checkbox" name="show_company" value="1" {{ $settings->show_company ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary/20 transition-all duration-300">
                        </div>
                    </label>

                    <label class="flex items-center justify-between p-5 rounded-2xl border-2 border-transparent bg-gray-50/50 hover:bg-white hover:border-primary/10 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 cursor-pointer group">
                        <div class="flex items-start gap-4">
                            <div class="mt-0.5 w-8 h-8 rounded-lg bg-white border border-gray-100 shadow-sm flex items-center justify-center text-gray-400 group-hover:text-primary transition-colors">
                                <i data-lucide="phone" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-700">Téléphone</p>
                                <p class="text-xs text-gray-500 mt-0.5">Afficher le numéro de contact</p>
                            </div>
                        </div>
                        <div class="relative flex items-center">
                            <input type="hidden" name="show_phone" value="0">
                            <input type="checkbox" name="show_phone" value="1" {{ $settings->show_phone ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary/20 transition-all duration-300">
                        </div>
                    </label>

                    <label class="flex items-center justify-between p-5 rounded-2xl border-2 border-transparent bg-gray-50/50 hover:bg-white hover:border-primary/10 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 cursor-pointer group">
                        <div class="flex items-start gap-4">
                            <div class="mt-0.5 w-8 h-8 rounded-lg bg-white border border-gray-100 shadow-sm flex items-center justify-center text-gray-400 group-hover:text-primary transition-colors">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-700">Adresse</p>
                                <p class="text-xs text-gray-500 mt-0.5">Afficher l'adresse complète</p>
                            </div>
                        </div>
                        <div class="relative flex items-center">
                            <input type="hidden" name="show_address" value="0">
                            <input type="checkbox" name="show_address" value="1" {{ $settings->show_address ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary/20 transition-all duration-300">
                        </div>
                    </label>

                    <label class="flex items-center justify-between p-5 rounded-2xl border-2 border-transparent bg-gray-50/50 hover:bg-white hover:border-primary/10 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 cursor-pointer group md:col-span-2 lg:col-span-1">
                        <div class="flex items-start gap-4">
                            <div class="mt-0.5 w-8 h-8 rounded-lg bg-white border border-gray-100 shadow-sm flex items-center justify-center text-gray-400 group-hover:text-primary transition-colors">
                                <i data-lucide="map" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-700">Lien Google Maps</p>
                                <p class="text-xs text-gray-500 mt-0.5">Afficher le bouton vers Maps</p>
                            </div>
                        </div>
                        <div class="relative flex items-center">
                            <input type="hidden" name="show_maps" value="0">
                            <input type="checkbox" name="show_maps" value="1" {{ $settings->show_maps ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary/20 transition-all duration-300">
                        </div>
                    </label>
                </div>
            </section>
        </div>
        
        <div class="px-6 lg:px-8 py-5 bg-gray-50/50 border-t border-border/50 flex justify-end">
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-primary to-primary-dark text-white rounded-xl text-sm font-bold shadow-lg shadow-primary/30 hover:shadow-primary/50 hover:-translate-y-0.5 transition-all duration-300 active:scale-95 active:translate-y-0 relative overflow-hidden group">
                <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-black"></span>
                <span class="relative flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Enregistrer les paramètres
                </span>
            </button>
        </div>
    </form>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</div>
@endsection
