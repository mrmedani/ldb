<div>
    <form wire:submit="save" class="glass-panel rounded-2xl overflow-hidden">
        <div class="p-6 lg:p-8 space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-1.5 group">
                    <label class="label-modern group-focus-within:text-primary">Wilaya</label>
                    <select wire:model.live="wilaya_id" class="input-modern @error('wilaya_id') !border-red-500 !ring-red-500/20 @enderror">
                        <option value="">Sélectionnez une wilaya</option>
                        @foreach($wilayas as $wilaya)
                            <option value="{{ $wilaya->id }}">{{ $wilaya->name }}</option>
                        @endforeach
                    </select>
                    @error('wilaya_id') <p class="text-xs text-red-500 mt-1.5 font-medium flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="label-modern">Code Wilaya</label>
                    <input type="text" readonly value="{{ $wilaya_code }}" class="input-modern !bg-gray-100/80 text-gray-500 cursor-not-allowed font-medium" />
                </div>
            </div>

            <div class="space-y-1.5 group">
                <label class="label-modern group-focus-within:text-primary">Commune</label>
                <div class="relative">
                    <i data-lucide="map-pin" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                    <select wire:model.live="commune_id" class="input-modern pl-11 appearance-none cursor-pointer @error('commune_id') !border-red-500 !ring-red-500/20 @enderror">
                        <option value="">Sélectionnez une commune</option>
                        @foreach($communes as $commune)
                            <option value="{{ $commune->id }}">{{ $commune->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('commune_id') <p class="text-xs text-red-500 mt-1.5 font-medium flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1.5 group">
                <label class="label-modern group-focus-within:text-primary">Entreprise partenaire</label>
                <div class="relative">
                    <i data-lucide="building-2" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                    <input type="text" wire:model="company_name" placeholder="Nom de l'entreprise" class="input-modern pl-11 @error('company_name') !border-red-500 !ring-red-500/20 @enderror" />
                </div>
                @error('company_name') <p class="text-xs text-red-500 mt-1.5 font-medium flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1.5 group">
                <label class="label-modern group-focus-within:text-primary">Téléphone principal</label>
                <div class="relative">
                    <i data-lucide="phone" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                    <input type="text" wire:model="phone" placeholder="Numéro de téléphone" class="input-modern pl-11 @error('phone') !border-red-500 !ring-red-500/20 @enderror" />
                </div>
                @error('phone') <p class="text-xs text-red-500 mt-1.5 font-medium flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1.5 group">
                <label class="label-modern group-focus-within:text-primary">Téléphone secondaire</label>
                <div class="relative">
                    <i data-lucide="phone" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                    <input type="text" wire:model="phone_secondary" placeholder="Numéro secondaire (optionnel)" class="input-modern pl-11 @error('phone_secondary') !border-red-500 !ring-red-500/20 @enderror" />
                </div>
                @error('phone_secondary') <p class="text-xs text-red-500 mt-1.5 font-medium flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1.5 group">
                <label class="label-modern group-focus-within:text-primary">Adresse</label>
                <div class="relative">
                    <i data-lucide="map-pin" class="w-5 h-5 absolute left-4 top-4 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                    <textarea wire:model="address" rows="3" placeholder="Adresse complète" class="input-modern pl-11 py-3 @error('address') !border-red-500 !ring-red-500/20 @enderror"></textarea>
                </div>
                @error('address') <p class="text-xs text-red-500 mt-1.5 font-medium flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1.5 group">
                <label class="label-modern group-focus-within:text-primary">Lien Google Maps</label>
                <div class="relative">
                    <i data-lucide="map" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                    <input type="url" wire:model="google_maps" placeholder="https://maps.google.com/..." class="input-modern pl-11 @error('google_maps') !border-red-500 !ring-red-500/20 @enderror" />
                </div>
                @error('google_maps') <p class="text-xs text-red-500 mt-1.5 font-medium flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-1.5">
                    <label class="label-modern">Ordre d'affichage</label>
                    <input type="number" readonly value="{{ $display_order }}" class="input-modern !bg-gray-100/80 text-gray-500 cursor-not-allowed font-medium" />
                </div>

                <div class="space-y-1.5 flex flex-col justify-end">
                    <label class="flex items-center gap-3 cursor-pointer p-3 rounded-xl border border-transparent hover:bg-gray-50 hover:border-gray-200 transition-colors">
                        <div class="relative flex items-center">
                            <input type="checkbox" wire:model="is_visible" class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary/20 transition-all duration-300" />
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Visible sur le site public</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50/50 border-t border-border/50 flex items-center justify-end gap-3">
            <a href="{{ route('admin.offices.index') }}" wire:navigate class="btn-secondary">
                Annuler
            </a>
            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i>
                {{ $editing ? 'Mettre à jour' : 'Enregistrer' }}
            </button>
        </div>
    </form>
</div>
