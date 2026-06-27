@extends('admin.layouts.admin')
@section('title', 'Signalements de bugs')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-extrabold text-text">Signalements de bugs</h1>
                    @php $pendingCount = App\Models\BugReport::pending()->count(); @endphp
                    @if($pendingCount > 0)
                        <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full">{{ $pendingCount }} en attente</span>
                    @endif
                </div>
                <p class="text-gray-500 font-medium mt-1">Gérer les signalements envoyés par les visiteurs</p>
            </div>
        </div>
        @livewire('admin.bug-report-manager')
    </div>
@endsection
