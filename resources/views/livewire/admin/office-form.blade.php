<div>
    <form wire:submit="save" class="bg-surface/80 backdrop-blur-md rounded-2xl border border-border/50 shadow-sm overflow-hidden">
        <div class="p-6 lg:p-8 space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-1.5 group">
                    <label class="text-sm font-semibold text-gray-700 group-focus-within:text-primary transition-colors">Wilaya</label>
                    <select wire:model.live="wilaya_id" class="w-full px-4 py-3 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300 @error('wilaya_id') !border-red-500 !ring-red-500/20 @enderror">
                        <option value="">Sélectionnez une wilaya</option>
                        @foreach($wilayas as $wilaya)
                            <option value="{{ $wilaya->id }}">{{ $wilaya->name }}</option>
                        @endforeach
                    </select>
                    @error('wilaya_id') <p class="text-xs text-red-500 mt-1.5 font-medium flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-gray-700">Code Wilaya</label>
                    <input type="text" readonly value="{{ $wilaya_code }}" class="w-full px-4 py-3 text-sm border-2 border-transparent rounded-xl bg-gray-100/80 text-gray-500 cursor-not-allowed font-medium" />
                </div>
            </div>

            <div class="space-y-1.5 group">
                <label class="text-sm font-semibold text-gray-700 group-focus-within:text-primary transition-colors">Commune</label>
                <div class="relative">
                    <i data-lucide="location" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                    <select wire:model.live="commune_id" class="w-full pl-11 pr-4 py-3 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300 appearance-none cursor-pointer @error('commune_id') !border-red-500 !ring-red-500/20 @enderror">
                        <option value="">Sélectionnez une commune</option>
                        @foreach($communes as $commune)
                            <option value="{{ $commune->id }}">{{ $commune->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('commune_id') <p class="text-xs text-red-500 mt-1.5 font-medium flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1.5 group">
                <label class="text-sm font-semibold text-gray-700 group-focus-within:text-primary transition-colors">Entreprise partenaire</label>
                <div class="relative">
                    <i data-lucide="building-2" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                    <input type="text" wire:model="company_name" placeholder="Nom de l'entreprise" class="w-full pl-11 pr-4 py-3 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300 @error('company_name') !border-red-500 !ring-red-500/20 @enderror" />
                </div>
                @error('company_name') <p class="text-xs text-red-500 mt-1.5 font-medium flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1.5 group">
                <label class="text-sm font-semibold text-gray-700 group-focus-within:text-primary transition-colors">Téléphone principal</label>
                <div class="relative">
                    <i data-lucide="phone" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                    <input type="text" wire:model="phone" placeholder="Numéro de téléphone" class="w-full pl-11 pr-4 py-3 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300 @error('phone') !border-red-500 !ring-red-500/20 @enderror" />
                </div>
                @error('phone') <p class="text-xs text-red-500 mt-1.5 font-medium flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1.5 group">
                <label class="text-sm font-semibold text-gray-700 group-focus-within:text-primary transition-colors">Téléphone secondaire</label>
                <div class="relative">
                    <i data-lucide="phone" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                    <input type="text" wire:model="phone_secondary" placeholder="Numéro secondaire (optionnel)" class="w-full pl-11 pr-4 py-3 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300 @error('phone_secondary') !border-red-500 !ring-red-500/20 @enderror" />
                </div>
                @error('phone_secondary') <p class="text-xs text-red-500 mt-1.5 font-medium flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1.5 group">
                <label class="text-sm font-semibold text-gray-700 group-focus-within:text-primary transition-colors">Adresse</label>
                <div class="relative">
                    <i data-lucide="map-pin" class="w-5 h-5 absolute left-4 top-4 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                    <textarea wire:model="address" rows="3" placeholder="Adresse complète" class="w-full pl-11 pr-4 py-3 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300 @error('address') !border-red-500 !ring-red-500/20 @enderror"></textarea>
                </div>
                @error('address') <p class="text-xs text-red-500 mt-1.5 font-medium flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1.5 group">
                <label class="text-sm font-semibold text-gray-700 group-focus-within:text-primary transition-colors">Lien Google Maps</label>
                <div class="relative">
                    <i data-lucide="map" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                    <input type="url" wire:model="google_maps" placeholder="https://maps.google.com/..." class="w-full pl-11 pr-4 py-3 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300 @error('google_maps') !border-red-500 !ring-red-500/20 @enderror" />
                </div>
                @error('google_maps') <p class="text-xs text-red-500 mt-1.5 font-medium flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-gray-700">Ordre d'affichage</label>
                    <input type="number" readonly value="{{ $display_order }}" class="w-full px-4 py-3 text-sm border-2 border-transparent rounded-xl bg-gray-100/80 text-gray-500 cursor-not-allowed font-medium" />
                </div>

                <div class="space-y-1.5 flex flex-col justify-end">
                    <label class="flex items-center gap-3 cursor-pointer p-3 rounded-xl border-2 border-transparent hover:bg-gray-50 transition-colors">
                        <div class="relative flex items-center">
                            <input type="checkbox" wire:model="is_visible" class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary/20 transition-all duration-300" />
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Visible sur le site public</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50/50 border-t border-border/50 flex items-center justify-end gap-3">
            <a href="{{ route('admin.offices.index') }}" wire:navigate class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm active:scale-95">
                Annuler
            </a>
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-primary to-primary-dark text-white rounded-xl text-sm font-bold shadow-lg shadow-primary/30 hover:shadow-primary/50 hover:-translate-y-0.5 transition-all duration-300 active:scale-95 active:translate-y-0 relative overflow-hidden group">
                <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-black"></span>
                <span class="relative flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    {{ $editing ? 'Mettre à jour' : 'Enregistrer' }}
                </span>
            </button>
        </div>
    </form>
</div>
