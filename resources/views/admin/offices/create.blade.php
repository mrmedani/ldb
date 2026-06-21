@extends('admin.layouts.admin')

@section('title', 'Ajouter un bureau')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.offices.index') }}" wire:navigate class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Retour à la liste</span>
        </a>
        <h1 class="text-2xl font-bold text-text">Ajouter un bureau</h1>
        <p class="text-gray-500 mt-1">Créez un nouveau bureau partenaire.</p>
    </div>

    @livewire('admin.office-form')
</div>
@endsection
