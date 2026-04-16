@extends('layouts.app')
@section('title', 'User Management - AquaReport')

@section('content')
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">User Management</h1>
            <p class="text-gray-600">View and manage all registered users</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="mt-4 md:mt-0 inline-flex items-center px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Dashboard
        </a>
    </div>
</div>

<div class="glass-card rounded-2xl shadow-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-ocean-50 to-aqua-50">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                All Users
            </h2>
            <span class="text-sm text-gray-500">{{ $users->total() }} users</span>
        </div>
    </div>

    @if($users->isEmpty())
        <div class="p-12 text-center">
            <div class="w-20 h-20 rounded-full bg-ocean-50 flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-ocean-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Users Found</h3>
            <p class="text-gray-500">There are no registered users in the system.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Reports</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Joined</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($users as $user)
                        <tr class="hover:bg-ocean-50/30 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    @if($user->isAdmin())
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @else
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-ocean-400 to-aqua-500 flex items-center justify-center text-white font-bold text-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">ID: #{{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-700">{{ $user->email }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->isAdmin())
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-gradient-to-r from-purple-100 to-pink-100 text-purple-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Administrator
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-ocean-100 text-ocean-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                        Reporter
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                    {{ $user->reports->count() }} reports
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
