@extends('layouts.app')
@section('title', 'Admin Dashboard - AquaReport')

@section('content')
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
            <p class="text-gray-600">Manage all water supply reports and system users</p>
        </div>
    </div>
</div>

<div class="mb-6">
    <div class="flex space-x-1 bg-gray-100 p-1 rounded-xl w-fit">
        <button onclick="showTab('reports')" id="tab-reports" class="tab-btn px-6 py-2.5 rounded-lg font-medium text-sm transition-all bg-white shadow text-gray-900">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Reports
        </button>
        <button onclick="showTab('users')" id="tab-users" class="tab-btn px-6 py-2.5 rounded-lg font-medium text-sm transition-all text-gray-600 hover:text-gray-900">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Users
        </button>
    </div>
</div>

<div id="tab-content-reports" class="tab-content">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <a href="{{ route('admin.dashboard') }}?tab=reports" class="glass-card rounded-2xl shadow-lg p-6 card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-ocean-100 to-ocean-200 flex items-center justify-center">
                    <svg class="w-7 h-7 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <span class="text-xs text-gray-400 font-medium px-2 py-1 bg-gray-100 rounded-lg">All</span>
            </div>
            <p class="text-sm text-gray-500 mb-1">Total Reports</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
        </a>

        <a href="{{ route('admin.reports.status', 'Pending') }}?tab=reports" class="glass-card rounded-2xl shadow-lg p-6 card-hover border-2 border-amber-200 hover:border-amber-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-100 to-amber-200 flex items-center justify-center">
                    <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs text-amber-600 font-medium px-2 py-1 bg-amber-100 rounded-lg animate-pulse">Action Needed</span>
            </div>
            <p class="text-sm text-gray-500 mb-1">Pending</p>
            <p class="text-3xl font-bold text-amber-600">{{ number_format($stats['pending']) }}</p>
        </a>

        <a href="{{ route('admin.reports.status', 'In Progress') }}?tab=reports" class="glass-card rounded-2xl shadow-lg p-6 card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="text-xs text-blue-600 font-medium px-2 py-1 bg-blue-100 rounded-lg">Working</span>
            </div>
            <p class="text-sm text-gray-500 mb-1">In Progress</p>
            <p class="text-3xl font-bold text-blue-600">{{ number_format($stats['in_progress']) }}</p>
        </a>

        <a href="{{ route('admin.reports.status', 'Resolved') }}?tab=reports" class="glass-card rounded-2xl shadow-lg p-6 card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs text-green-600 font-medium px-2 py-1 bg-green-100 rounded-lg">Complete</span>
            </div>
            <p class="text-sm text-gray-500 mb-1">Resolved</p>
            <p class="text-3xl font-bold text-green-600">{{ number_format($stats['resolved']) }}</p>
        </a>
    </div>

    <div class="glass-card rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-ocean-50 to-aqua-50">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    All Reports
                </h2>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">{{ number_format($reports->total()) }} total</span>
                    <form id="reportsPerPageForm" class="flex items-center space-x-2">
                        <label class="text-sm text-gray-500">Show:</label>
                        <select name="per_page_reports" onchange="document.getElementById('reportsPerPageForm').submit()" class="px-2 py-1 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-ocean-500 bg-white">
                            @foreach([5, 10, 20, 50, 100, 1000] as $perPage)
                                <option value="{{ $perPage }}" {{ $reportsPerPage == $perPage ? 'selected' : '' }}>{{ $perPage == 1000 ? 'All' : $perPage }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="tab" value="reports">
                        @if(request()->has('per_page_users'))
                            <input type="hidden" name="per_page_users" value="{{ request('per_page_users') }}">
                        @endif
                    </form>
                </div>
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
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                        Showing {{ $reports->firstItem() ?? 0 }} to {{ $reports->lastItem() ?? 0 }} of {{ number_format($reports->total()) }}
                    </p>
                    {{ $reports->appends(['tab' => 'reports', 'per_page_reports' => $reportsPerPage, 'per_page_users' => $usersPerPage])->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<div id="tab-content-users" class="tab-content hidden">
    <div class="glass-card rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-indigo-50">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    User Management
                </h2>
                <div class="flex items-center space-x-4">
                    <form id="usersPerPageForm" class="flex items-center space-x-2">
                        <label class="text-sm text-gray-500">Show:</label>
                        <select name="per_page_users" onchange="document.getElementById('usersPerPageForm').submit()" class="px-2 py-1 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 bg-white">
                            @foreach([5, 10, 20, 50, 100, 1000] as $perPage)
                                <option value="{{ $perPage }}" {{ $usersPerPage == $perPage ? 'selected' : '' }}>{{ $perPage == 1000 ? 'All' : $perPage }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="tab" value="users">
                        @if(request()->has('per_page_reports'))
                            <input type="hidden" name="per_page_reports" value="{{ request('per_page_reports') }}">
                        @endif
                    </form>
                    <button onclick="toggleAddUserForm()" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-lg font-medium text-sm hover:shadow-lg transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add User
                    </button>
                </div>
            </div>
        </div>

        <div id="addUserForm" class="hidden p-6 border-b border-gray-100 bg-gradient-to-r from-purple-50/50 to-indigo-50/50">
            <form action="{{ route('admin.users.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" required placeholder="John Doe"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-300 bg-red-50 @enderror"
                        value="{{ old('name') }}">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" required placeholder="john@example.com"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-300 bg-red-50 @enderror"
                        value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white @error('role') border-red-300 @enderror">
                        <option value="">Select Role</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Reporter</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required placeholder="Min. 8 characters"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('password') border-red-300 bg-red-50 @enderror">
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required placeholder="Re-enter password"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                <div class="md:col-span-2 flex justify-end space-x-3 pt-2">
                    <button type="button" onclick="toggleAddUserForm()" class="px-6 py-2.5 border border-gray-200 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-lg font-medium hover:shadow-lg transition">
                        Create User
                    </button>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Reports</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    @if($user->profile_picture)
                                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="text-sm font-medium text-gray-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 text-xs font-medium rounded-lg {{ $user->isAdmin() ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $user->isAdmin() ? 'Admin' : 'Reporter' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->reports_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center space-x-2">
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure? This will delete all reports by {{ $user->name }}. This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-red-50 text-red-600 font-medium hover:bg-red-100 transition">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    @else
                                        <span class="px-3 py-1.5 text-xs text-gray-400 bg-gray-50 rounded-lg">(You)</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-500">
                            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ number_format($users->total()) }} users
                        </p>
                        {{ $users->appends(['tab' => 'users', 'per_page_reports' => $reportsPerPage, 'per_page_users' => $usersPerPage])->links() }}
                    </div>
                </div>
            @else
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    <p class="text-sm text-gray-500">
                        Showing all {{ number_format($users->total()) }} users
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.tab-btn {
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}
</style>

<script>
let currentTab = 'reports';

function showTab(tab) {
    currentTab = tab;
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(el => {
        el.classList.remove('bg-white', 'shadow', 'text-gray-900');
        el.classList.add('text-gray-600');
    });
    
    document.getElementById('tab-content-' + tab).classList.remove('hidden');
    const activeBtn = document.getElementById('tab-' + tab);
    activeBtn.classList.add('bg-white', 'shadow', 'text-gray-900');
    activeBtn.classList.remove('text-gray-600');
    
    history.replaceState(null, '', '?tab=' + tab);
}

function toggleAddUserForm() {
    const form = document.getElementById('addUserForm');
    form.classList.toggle('hidden');
}

document.querySelectorAll('.pagination a').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const url = new URL(this.href);
        url.searchParams.set('tab', currentTab);
        window.location.href = url.toString();
    });
});

const urlParams = new URLSearchParams(window.location.search);
const tabParam = urlParams.get('tab');
if (tabParam === 'users') {
    showTab('users');
} else {
    showTab('reports');
}
</script>
@endsection
