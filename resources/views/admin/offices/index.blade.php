@extends('admin.layouts.admin')

@section('title', 'Gestion des bureaux')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-text">Gestion des bureaux</h1>
            <p class="text-gray-500 mt-1">Gérez tous les bureaux partenaires CHRONOREX EXPRESS.</p>
        </div>
        <a href="{{ route('admin.offices.create') }}" wire:navigate class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark transition-colors">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Ajouter un bureau</span>
        </a>
    </div>

    @livewire('admin.office-manager')
</div>
@endsection
