@extends('admin.layouts.admin')
@section('title', 'Journal d\'activité')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-extrabold text-text">Journal d'activité</h1>
                <p class="text-gray-500 font-medium mt-1">Traçabilité des actions des administrateurs</p>
            </div>
        </div>
        @livewire('admin.log-viewer')
    </div>
@endsection
