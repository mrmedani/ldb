@extends('public.layouts.public')

@section('content')
@php $settings = App\Models\Setting::getSettings(); @endphp
<div class="relative pt-12 pb-10 sm:pt-20 sm:pb-16 overflow-hidden">
    <!-- Hero Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-12 sm:mb-16">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-sm font-bold mb-6 ring-1 ring-inset ring-primary/20 animate-fade-in">
            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
            {{ $settings->hero_badge ?? 'Réseau de Bureaux Partenaires' }}
        </div>
        
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-text mb-6">
            {!! $settings->formatted_hero_title !!}
        </h1>
        
        <p class="text-lg sm:text-xl text-gray-500 max-w-2xl mx-auto font-medium leading-relaxed">
            {{ $settings->hero_subtitle ?? "Consultez facilement les coordonnées, adresses et horaires de tous les bureaux partenaires de Chronorex Express répartis à travers le pays." }}
        </p>
    </div>

    <!-- Search & Results Dynamic Area -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @livewire('public.office-search')
    </div>
</div>
@endsection
