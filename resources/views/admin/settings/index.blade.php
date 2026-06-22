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
                <p class="text-sm text-gray-500 mb-6 ml-13">Glissez-déposez pour réordonner les colonnes. Désactivez une colonne pour la masquer.</p>

                @php
                    $columnDefs = [
                        'wilaya' => ['icon' => 'map-pin', 'label' => 'Wilaya', 'desc' => 'Toujours affiché', 'locked' => true],
                        'commune' => ['icon' => 'building', 'label' => 'Commune', 'desc' => 'Toujours affiché', 'locked' => true],
                        'delivery_time' => ['icon' => 'clock', 'label' => 'Délai livraison', 'desc' => 'Afficher le délai de livraison', 'toggle' => 'show_delivery_time'],
                        'code' => ['icon' => 'hash', 'label' => 'Code Wilaya', 'desc' => 'Afficher le code numérique', 'toggle' => 'show_code'],
                        'company' => ['icon' => 'building-2', 'label' => 'Entreprise partenaire', 'desc' => 'Afficher le nom du bureau', 'toggle' => 'show_company'],
                        'phone' => ['icon' => 'phone', 'label' => 'Téléphone', 'desc' => 'Afficher le numéro de contact', 'toggle' => 'show_phone'],
                        'address' => ['icon' => 'map-pin', 'label' => 'Adresse', 'desc' => "Afficher l'adresse complète", 'toggle' => 'show_address'],
                        'maps' => ['icon' => 'map', 'label' => 'Lien Google Maps', 'desc' => 'Afficher le bouton vers Maps', 'toggle' => 'show_maps'],
                    ];
                    $currentOrder = $settings->column_order ?? ['wilaya', 'commune', 'delivery_time', 'code', 'company', 'phone', 'address', 'maps'];
                @endphp

                <div id="columnSortable" class="space-y-2">
                    @foreach($currentOrder as $colKey)
                        @if(!isset($columnDefs[$colKey])) @continue @endif
                        @php $col = $columnDefs[$colKey]; $isLocked = $col['locked'] ?? false; @endphp
                        <div class="column-item flex items-center gap-4 p-4 rounded-xl border border-border/50 bg-gray-50/30 hover:border-primary/20 hover:shadow-sm transition-all duration-200" draggable="true" data-key="{{ $colKey }}">
                            <div class="drag-handle cursor-grab active:cursor-grabbing text-gray-300 hover:text-gray-500 transition-colors touch-none select-none">
                                <i data-lucide="grip-vertical" class="w-5 h-5"></i>
                            </div>

                            <div class="w-9 h-9 rounded-lg bg-white border border-gray-100 shadow-sm flex items-center justify-center text-gray-400 shrink-0">
                                <i data-lucide="{{ $col['icon'] }}" class="w-4 h-4"></i>
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-700">{{ $col['label'] }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $col['desc'] }}</p>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <div class="flex flex-col items-center gap-0.5 mr-1">
                                    <button type="button" class="move-up p-1 text-gray-300 hover:text-gray-600 hover:bg-gray-100 rounded transition-colors disabled:opacity-20 disabled:cursor-not-allowed" {{ $loop->first ? 'disabled' : '' }}>
                                        <i data-lucide="chevron-up" class="w-3.5 h-3.5"></i>
                                    </button>
                                    <span class="order-badge text-[11px] font-bold text-gray-400 bg-gray-100 border border-gray-200/50 px-1.5 py-0.5 rounded-md">{{ $loop->iteration }}</span>
                                    <button type="button" class="move-down p-1 text-gray-300 hover:text-gray-600 hover:bg-gray-100 rounded transition-colors disabled:opacity-20 disabled:cursor-not-allowed" {{ $loop->last ? 'disabled' : '' }}>
                                        <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                                    </button>
                                </div>
                                @if($isLocked)
                                    <span class="text-xs text-gray-400 font-medium px-3 py-1.5 bg-gray-100/50 rounded-lg border border-gray-200/50">Obligatoire</span>
                                @else
                                    <input type="hidden" name="{{ $col['toggle'] }}" value="0">
                                    <input type="checkbox" name="{{ $col['toggle'] }}" value="1" {{ $settings->{$col['toggle']} ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary/20 transition-all duration-300">
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <input type="hidden" name="column_order" id="columnOrderInput" value="{{ json_encode($currentOrder) }}">

                <div class="mt-4 flex items-center gap-2 text-xs text-gray-400 bg-gray-50/50 rounded-xl px-4 py-3 border border-border/50">
                    <i data-lucide="info" class="w-4 h-4 text-gray-300 shrink-0"></i>
                    <span>Les colonnes Wilaya et Commune sont toujours affichées. Faites glisser les colonnes pour réorganiser l'ordre d'affichage.</span>
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
        .column-item.dragging {
            opacity: 0.5;
            border-style: dashed;
            border-color: rgb(59 130 246 / 0.3);
            background: rgb(239 246 255);
        }
        .column-item.drag-over {
            border-color: rgb(59 130 246 / 0.5);
            background: rgb(239 246 255 / 0.8);
            box-shadow: 0 0 0 2px rgb(59 130 246 / 0.1);
        }
    </style>

    <script>
        function initColumnDrag() {
            const container = document.getElementById('columnSortable');
            if (!container || container.dataset.initialized) return;
            container.dataset.initialized = '1';

            function updateOrder() {
                const items = container.querySelectorAll('.column-item');
                const order = [];
                items.forEach((item, index) => {
                    order.push(item.dataset.key);
                    const badge = item.querySelector('.order-badge');
                    const up = item.querySelector('.move-up');
                    const down = item.querySelector('.move-down');
                    if (badge) badge.textContent = index + 1;
                    if (up) up.disabled = index === 0;
                    if (down) down.disabled = index === items.length - 1;
                });
                document.getElementById('columnOrderInput').value = JSON.stringify(order);
            }

            // Drag and drop
            let draggedItem = null;

            container.addEventListener('dragstart', function(e) {
                const item = e.target.closest('.column-item');
                if (!item) return;
                const handle = item.querySelector('.drag-handle');
                if (!handle || !handle.contains(e.target)) {
                    e.preventDefault();
                    return;
                }
                draggedItem = item;
                item.classList.add('dragging');
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/plain', item.dataset.key);
            });

            container.addEventListener('dragend', function() {
                if (draggedItem) {
                    draggedItem.classList.remove('dragging');
                    draggedItem = null;
                }
                container.querySelectorAll('.column-item').forEach(el => el.classList.remove('drag-over'));
            });

            container.addEventListener('dragover', function(e) {
                e.preventDefault();
                const item = e.target.closest('.column-item');
                if (!item || item === draggedItem) return;
                e.dataTransfer.dropEffect = 'move';
                container.querySelectorAll('.column-item').forEach(el => el.classList.remove('drag-over'));
                item.classList.add('drag-over');
            });

            container.addEventListener('dragleave', function(e) {
                const item = e.target.closest('.column-item');
                if (item) item.classList.remove('drag-over');
            });

            container.addEventListener('drop', function(e) {
                e.preventDefault();
                const target = e.target.closest('.column-item');
                if (!target) return;
                target.classList.remove('drag-over');
                if (draggedItem && target !== draggedItem) {
                    const rect = target.getBoundingClientRect();
                    const midY = rect.top + rect.height / 2;
                    if (e.clientY < midY) {
                        container.insertBefore(draggedItem, target);
                    } else {
                        container.insertBefore(draggedItem, target.nextElementSibling);
                    }
                    updateOrder();
                }
                draggedItem = null;
            });

            // Up/down buttons
            container.addEventListener('click', function(e) {
                const btn = e.target.closest('.move-up, .move-down');
                if (!btn) return;
                const item = btn.closest('.column-item');
                if (!item) return;

                const isUp = btn.classList.contains('move-up');
                const sibling = isUp ? item.previousElementSibling : item.nextElementSibling;
                if (!sibling) return;

                if (isUp) {
                    container.insertBefore(item, sibling);
                } else {
                    container.insertBefore(sibling, item);
                }
                updateOrder();
            });
        }

        initColumnDrag();
        document.addEventListener('livewire:navigated', initColumnDrag);
    </script>
</div>
@endsection
