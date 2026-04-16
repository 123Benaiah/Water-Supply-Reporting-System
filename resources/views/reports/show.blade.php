@extends('layouts.app')
@section('title', 'Report Details - AquaReport')

@section('content')
<style>
    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }
    .image-item {
        position: relative;
        aspect-ratio: 4/3;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .image-item:hover {
        transform: scale(1.02);
    }
    .image-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    .modal.active {
        display: flex;
    }
    .modal img {
        max-width: 90%;
        max-height: 90%;
        border-radius: 12px;
    }
    .modal-close {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        background: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        font-size: 20px;
    }
</style>

<div id="imageModal" class="modal" onclick="closeModal(event)">
    <button class="modal-close" onclick="closeModal(event)">&times;</button>
    <img id="modalImage" src="" alt="Full size">
</div>

<div class="mb-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('dashboard') }}" class="p-2 rounded-xl bg-gray-100 hover:bg-gray-200 transition">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Report #{{ $report->id }}</h1>
                <p class="text-gray-500">Submitted {{ $report->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
        </div>
        @if($report->status == 'Pending')
            <span class="status-pending inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold">
                <span class="w-2 h-2 rounded-full bg-amber-500 mr-2 animate-pulse"></span>
                Pending Review
            </span>
        @elseif($report->status == 'In Progress')
            <span class="status-progress inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold">
                <span class="w-2 h-2 rounded-full bg-blue-500 mr-2 animate-spin"></span>
                In Progress
            </span>
        @else
            <span class="status-resolved inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                Resolved
            </span>
        @endif
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        <div class="glass-card rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $report->title }}</h2>

            <div class="grid grid-cols-2 gap-6 mb-8">
                <div class="p-4 rounded-xl bg-ocean-50">
                    <p class="text-sm text-ocean-600 font-medium mb-1">Issue Type</p>
                    <p class="text-gray-900 font-semibold">{{ $report->issue_type }}</p>
                </div>
                <div class="p-4 rounded-xl bg-aqua-50">
                    <p class="text-sm text-aqua-600 font-medium mb-1">Location</p>
                    <p class="text-gray-900 font-semibold">{{ $report->location }}</p>
                </div>
                @if($report->latitude && $report->longitude)
                    <div class="p-4 rounded-xl bg-gray-50">
                        <p class="text-sm text-gray-500 font-medium mb-1">Coordinates</p>
                        <p class="text-gray-900 font-mono text-sm">{{ $report->latitude }}, {{ $report->longitude }}</p>
                    </div>
                @endif
            </div>

            <div class="mb-8">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Description</h3>
                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $report->description }}</p>
            </div>

            @if($report->images && count($report->images) > 0)
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">
                        Photos ({{ count($report->images) }})
                    </h3>
                    <div class="image-grid">
                        @foreach($report->images as $image)
                            <div class="image-item" onclick="openModal('{{ asset('storage/' . $image) }}')">
                                <img src="{{ asset('storage/' . $image) }}" alt="Report image">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        @if($report->updates->count() > 0)
            <div class="glass-card rounded-2xl shadow-xl p-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Status Updates
                </h3>
                <div class="space-y-4">
                    @foreach($report->updates->sortByDesc('created_at') as $update)
                        <div class="flex items-start space-x-4 p-4 rounded-xl bg-gradient-to-r from-ocean-50 to-transparent border border-ocean-100">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-ocean-500 to-aqua-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-2">
                                    <p class="text-sm font-semibold text-gray-900">{{ $update->admin->name }}</p>
                                    <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded-full">{{ $update->created_at->format('M d, Y h:i A') }}</span>
                                </div>
                                <div class="mb-2">
                                    @if($update->status == 'In Progress')
                                        <span class="status-progress inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium">
                                            Moved to In Progress
                                        </span>
                                    @elseif($update->status == 'Resolved')
                                        <span class="status-resolved inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium">
                                            Marked as Resolved
                                        </span>
                                    @else
                                        <span class="status-pending inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium">
                                            {{ $update->status }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600">{{ $update->comment }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="lg:col-span-1">
        <div class="glass-card rounded-2xl shadow-xl p-6 sticky top-24">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Report Timeline</h3>
            <div class="relative">
                <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                <div class="space-y-6">
                    <div class="relative flex items-start space-x-4">
                        <div class="w-8 h-8 rounded-full bg-ocean-500 flex items-center justify-center z-10">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Report Submitted</p>
                            <p class="text-xs text-gray-500">{{ $report->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    @if($report->updates->count() > 0)
                        @foreach($report->updates->sortBy('created_at') as $update)
                            <div class="relative flex items-start space-x-4">
                                <div class="w-8 h-8 rounded-full {{ $update->status == 'Resolved' ? 'bg-green-500' : 'bg-blue-500' }} flex items-center justify-center z-10">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $update->status }}</p>
                                    <p class="text-xs text-gray-500">{{ $update->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal(event) {
    if (event.target.id === 'imageModal' || event.target.classList.contains('modal-close')) {
        document.getElementById('imageModal').classList.remove('active');
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal({target: document.getElementById('imageModal')});
    }
});
</script>
@endsection
