@extends('layouts.app')
@section('title', 'Manage Report - AquaReport')

@section('content')
<div class="mb-8">
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.dashboard') }}" class="p-2 rounded-xl bg-gray-100 hover:bg-gray-200 transition">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manage Report #{{ $report->id }}</h1>
            <p class="text-gray-500">Review and update report status</p>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        <div class="glass-card rounded-2xl shadow-xl p-8">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $report->title }}</h2>
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ $report->user->name }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $report->created_at->format('F d, Y \a\t h:i A') }}
                        </span>
                    </div>
                </div>
                @if($report->status == 'Pending')
                    <span class="status-pending inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold">
                        <span class="w-2 h-2 rounded-full bg-amber-500 mr-2 animate-pulse"></span>
                        Pending
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

            <div class="grid grid-cols-2 gap-4 mb-6">
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

            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Description</h3>
                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $report->description }}</p>
            </div>

            @if($report->image)
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Attached Image</h3>
                    <div class="rounded-2xl overflow-hidden shadow-lg">
                        <img src="{{ asset('storage/' . $report->image) }}" alt="Report image" class="w-full max-w-md h-auto">
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
                    Update History
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
                                            Status changed to In Progress
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
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Update Status
            </h3>

            <form action="{{ route('admin.reports.update', $report) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <div class="relative">
                        <select name="status" id="status" required
                            class="input-water w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 focus:outline-none appearance-none bg-white @error('status') border-red-300 bg-red-50 @enderror">
                            <option value="Pending" {{ $report->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="In Progress" {{ $report->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Resolved" {{ $report->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="comment" class="block text-sm font-semibold text-gray-700 mb-2">Comment</label>
                    <textarea name="comment" id="comment" rows="4"
                        class="input-water w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none resize-none @error('comment') border-red-300 bg-red-50 @enderror"
                        placeholder="Add a comment about this status update...">{{ old('comment') }}</textarea>
                    @error('comment')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-water w-full flex justify-center items-center py-3 px-4 rounded-xl text-white font-semibold shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Update Report
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-100">
                <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Reporter Information
                </h4>
                <div class="bg-gray-50 rounded-xl p-4 space-y-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-ocean-400 to-aqua-500 flex items-center justify-center text-white font-semibold text-sm">
                            {{ strtoupper(substr($report->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $report->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $report->user->reports->count() }} total reports</p>
                        </div>
                    </div>
                    <div class="pt-2 border-t border-gray-200">
                        <p class="text-xs text-gray-500 mb-1">Email</p>
                        <p class="text-sm text-gray-900">{{ $report->user->email }}</p>
                    </div>
                    <div class="pt-2 border-t border-gray-200">
                        <p class="text-xs text-gray-500 mb-1">Member Since</p>
                        <p class="text-sm text-gray-900">{{ $report->user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
