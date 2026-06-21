@extends('public.layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-text leading-tight">
            Nos Bureaux de Livraison
        </h1>
        <p class="text-gray-500 mt-4 text-lg max-w-2xl mx-auto">
            Trouvez rapidement le bureau CHRONOREX EXPRESS dans votre wilaya.
        </p>
    </div>

    @livewire('public.office-search')
</div>
@endsection
