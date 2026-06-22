@extends('admin.layouts.admin')

@section('title', 'Profil')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-text tracking-tight">Mon Profil</h1>
        <p class="text-gray-500 font-medium mt-2">Gérez vos informations personnelles et la sécurité de votre compte administrateur.</p>
    </div>

    <div class="space-y-8">
        <div class="glass-panel rounded-2xl p-6 lg:p-8 border border-border/50 shadow-sm">
            <livewire:profile.update-profile-information-form />
        </div>

        <div class="glass-panel rounded-2xl p-6 lg:p-8 border border-border/50 shadow-sm">
            <livewire:profile.update-password-form />
        </div>

        <div class="glass-panel rounded-2xl p-6 lg:p-8 border border-border/50 shadow-sm">
            <livewire:profile.delete-user-form />
        </div>
    </div>
</div>
@endsection
