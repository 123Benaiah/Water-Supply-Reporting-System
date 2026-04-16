@extends('layouts.app')
@section('title', 'Admin Dashboard - AquaReport')

@section('content')
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
            <p class="text-gray-600">Manage all water supply reports and system users</p>
        </div>
        <a href="{{ route('admin.users') }}" class="btn-water mt-4 md:mt-0 inline-flex items-center px-5 py-2.5 rounded-xl text-white font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Manage Users
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <a href="{{ route('admin.dashboard') }}" class="glass-card rounded-2xl shadow-lg p-6 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-ocean-100 to-ocean-200 flex items-center justify-center">
                <svg class="w-7 h-7 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <span class="text-xs text-gray-400 font-medium px-2 py-1 bg-gray-100 rounded-lg">All</span>
        </div>
        <p class="text-sm text-gray-500 mb-1">Total Reports</p>
        <p class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
    </a>

    <a href="{{ route('admin.reports.status', 'Pending') }}" class="glass-card rounded-2xl shadow-lg p-6 card-hover border-2 border-amber-200 hover:border-amber-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-100 to-amber-200 flex items-center justify-center">
                <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-xs text-amber-600 font-medium px-2 py-1 bg-amber-100 rounded-lg animate-pulse">Action Needed</span>
        </div>
        <p class="text-sm text-gray-500 mb-1">Pending</p>
        <p class="text-3xl font-bold text-amber-600">{{ $stats['pending'] }}</p>
    </a>

    <a href="{{ route('admin.reports.status', 'In Progress') }}" class="glass-card rounded-2xl shadow-lg p-6 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <span class="text-xs text-blue-600 font-medium px-2 py-1 bg-blue-100 rounded-lg">Working</span>
        </div>
        <p class="text-sm text-gray-500 mb-1">In Progress</p>
        <p class="text-3xl font-bold text-blue-600">{{ $stats['in_progress'] }}</p>
    </a>

    <a href="{{ route('admin.reports.status', 'Resolved') }}" class="glass-card rounded-2xl shadow-lg p-6 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-xs text-green-600 font-medium px-2 py-1 bg-green-100 rounded-lg">Complete</span>
        </div>
        <p class="text-sm text-gray-500 mb-1">Resolved</p>
        <p class="text-3xl font-bold text-green-600">{{ $stats['resolved'] }}</p>
    </a>
</div>

<div class="glass-card rounded-2xl shadow-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-ocean-50 to-aqua-50">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                All Reports
            </h2>
            <span class="text-sm text-gray-500">{{ $reports->total() }} total</span>
        </div>
    </div>

    @if($reports->isEmpty())
        <div class="p-12 text-center">
            <div class="w-20 h-20 rounded-full bg-ocean-50 flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-ocean-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Reports Found</h3>
            <p class="text-gray-500">There are no water supply reports to manage at this time.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($reports as $report)
                        <tr class="hover:bg-ocean-50/30 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-gray-900">#{{ $report->id }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-ocean-400 to-aqua-500 flex items-center justify-center text-white text-xs font-semibold">
                                        {{ strtoupper(substr($report->user->name, 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $report->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 max-w-xs truncate">{{ $report->title }}</div>
                                <div class="text-xs text-gray-500 truncate max-w-xs">{{ $report->location }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-ocean-100 text-ocean-800">
                                    {{ $report->issue_type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($report->status == 'Pending')
                                    <span class="status-pending inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold">
                                        <span class="w-2 h-2 rounded-full bg-amber-500 mr-2 animate-pulse"></span>
                                        Pending
                                    </span>
                                @elseif($report->status == 'In Progress')
                                    <span class="status-progress inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold">
                                        <span class="w-2 h-2 rounded-full bg-blue-500 mr-2 animate-spin"></span>
                                        In Progress
                                    </span>
                                @else
                                    <span class="status-resolved inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Resolved
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $report->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.reports.show', $report) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-gradient-to-r from-ocean-500 to-aqua-600 text-white font-medium hover:shadow-lg transition transform hover:-translate-y-0.5">
                                    Manage
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $reports->links() }}
        </div>
    @endif
</div>
@endsection
