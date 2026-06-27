<div>
    <!-- Trigger Button -->
    <button x-data @click="$wire.show = true; $nextTick(() => { if (window.initIcons) window.initIcons(); })" class="fixed bottom-6 left-6 z-50 flex items-center gap-2 px-4 py-2.5 bg-white/90 backdrop-blur-sm border border-red-200/50 rounded-2xl shadow-premium text-sm font-semibold text-red-600 hover:bg-red-50 hover:border-red-300 transition-all duration-200 hover:-translate-y-0.5 active:scale-95 group">
        <i data-lucide="bug" class="w-4 h-4 group-hover:rotate-12 transition-transform"></i>
        <span class="hidden sm:inline">Signaler un bug</span>
    </button>

    <!-- Modal Overlay -->
    @if($show)
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" wire:click="resetForm"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl border border-border/50 max-w-lg w-full p-6 sm:p-8 animate-in zoom-in-95 duration-200">
                @if($sent)
                    <div class="text-center py-8">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center mx-auto mb-4 border border-emerald-200/50">
                            <i data-lucide="check-circle" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-lg font-extrabold text-text mb-1">Merci pour votre signalement</h3>
                        <p class="text-gray-500 text-sm">Notre équipe va examiner le problème rapidement.</p>
                        <button wire:click="resetForm" class="btn-primary !mt-6 !py-2 !px-6 !rounded-xl text-sm">
                            Fermer
                        </button>
                    </div>
                @else
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center border border-red-200/50">
                                <i data-lucide="bug" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-text">Signaler un bug</h3>
                                <p class="text-xs text-gray-500 font-medium">Décrivez le problème rencontré</p>
                            </div>
                        </div>
                        <button wire:click="resetForm" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <form wire:submit="submit" class="space-y-4">
                        <div>
                            <label class="label-modern">Nom complet</label>
                            <input type="text" wire:model="name" class="input-modern" placeholder="Votre nom">
                            @error('name') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label-modern">Email</label>
                            <input type="email" wire:model="email" class="input-modern" placeholder="votre@email.com">
                            @error('email') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label-modern">Message</label>
                            <textarea wire:model="message" rows="4" class="input-modern resize-none" placeholder="Décrivez le bug en détail..."></textarea>
                            @error('message') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="btn-primary w-full !py-3 !rounded-xl flex items-center justify-center gap-2">
                            <i data-lucide="send" class="w-4 h-4"></i>
                            Envoyer le signalement
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @endif
</div>
