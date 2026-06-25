@extends('admin.layouts.admin')
@section('title', 'Signalements de bugs')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-extrabold text-text">Signalements de bugs</h1>
                <p class="text-gray-500 font-medium mt-1">Gérer les signalements envoyés par les visiteurs</p>
            </div>
        </div>
        @livewire('admin.bug-report-manager')
    </div>
@endsection
