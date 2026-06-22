@extends('admin.layouts.admin')

@section('title', 'Délais de livraison')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-text tracking-tight">Délais de livraison</h1>
        <p class="text-gray-500 font-medium mt-2">Définissez les délais de livraison pour chaque wilaya. Ces informations seront visibles par vos clients sur le site public.</p>
    </div>

    @if(session('success'))
        <div class="mb-8 px-5 py-4 rounded-xl bg-green-50 border border-green-200 text-sm text-green-700 flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
            </div>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.wilayas.delivery.update') }}" class="bg-surface/80 backdrop-blur-md rounded-2xl border border-border/50 shadow-sm overflow-hidden">
        @csrf

        <div class="p-6 lg:p-8">
            <!-- Search -->
            <div class="relative mb-6">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                <input type="text" id="wilayaSearch" placeholder="Rechercher une wilaya..." class="w-full pl-12 pr-4 py-3 text-sm border-2 border-transparent rounded-xl bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-gray-100/80 transition-all duration-300">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="wilayaList">
                @foreach($wilayas as $wilaya)
                    <div class="wilaya-item flex items-center justify-between p-4 rounded-xl border border-border/50 hover:border-primary/20 hover:shadow-sm hover:-translate-y-0.5 transition-all duration-200 bg-gray-50/30" data-name="{{ strtolower($wilaya->name) }}" data-code="{{ $wilaya->code }}">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="font-mono text-xs font-bold text-gray-400 bg-gray-100 border border-gray-200/50 px-2 py-0.5 rounded-md shrink-0">{{ $wilaya->code }}</span>
                            <span class="font-bold text-text truncate">{{ $wilaya->name }}</span>
                        </div>
                        <div class="ml-3 shrink-0 w-40">
                            <input type="hidden" name="wilayas[{{ $wilaya->id }}][id]" value="{{ $wilaya->id }}">
                            <input type="text" name="wilayas[{{ $wilaya->id }}][delivery_time]" value="{{ old('wilayas.' . $wilaya->id . '.delivery_time', $wilaya->delivery_time) }}" placeholder="ex: 24h, 2-3 jours..." class="w-full px-3 py-2 text-sm border-2 border-transparent rounded-lg bg-white focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:border-gray-300 transition-all duration-300 text-center">
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="noResults" class="hidden text-center py-16 text-gray-500">
                <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-border">
                    <i data-lucide="inbox" class="w-10 h-10 text-gray-300"></i>
                </div>
                <p class="text-lg font-bold text-gray-700">Aucune wilaya trouvée</p>
                <p class="text-gray-500 mt-1">Essayez d'autres termes de recherche.</p>
            </div>
        </div>

        <div class="px-6 lg:px-8 py-5 bg-gray-50/50 border-t border-border/50 flex justify-end">
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-primary to-primary-dark text-white rounded-xl text-sm font-bold shadow-lg shadow-primary/30 hover:shadow-primary/50 hover:-translate-y-0.5 transition-all duration-300 active:scale-95 active:translate-y-0 relative overflow-hidden">
                <span class="relative flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Enregistrer les délais
                </span>
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('wilayaSearch')?.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        const items = document.querySelectorAll('.wilaya-item');
        let visibleCount = 0;

        items.forEach(item => {
            const name = item.dataset.name;
            const code = item.dataset.code;
            const match = name.includes(query) || code.includes(query);
            item.style.display = match ? '' : 'none';
            if (match) visibleCount++;
        });

        document.getElementById('noResults').classList.toggle('hidden', visibleCount > 0);
    });
</script>
@endsection
