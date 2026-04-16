@extends('layouts.app')
@section('title', 'Create User - AquaReport')

@section('content')
<div class="mb-8">
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.users') }}" class="p-2 rounded-xl bg-gray-100 hover:bg-gray-200 transition">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Create New User</h1>
            <p class="text-gray-500">Add a new user to the system</p>
        </div>
    </div>
</div>

<div class="max-w-2xl">
    <div class="glass-card rounded-2xl shadow-xl p-8">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="input-water w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none @error('name') border-red-300 bg-red-50 @enderror"
                    placeholder="Enter full name">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="input-water w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none @error('email') border-red-300 bg-red-50 @enderror"
                    placeholder="Enter email address">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <input type="password" name="password" required
                    class="input-water w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none @error('password') border-red-300 bg-red-50 @enderror"
                    placeholder="Enter password (min 8 characters)">
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                    class="input-water w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none"
                    placeholder="Confirm password">
            </div>

            <div>
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}
                        class="w-5 h-5 text-ocean-600 border-gray-300 rounded focus:ring-ocean-500">
                    <span class="ml-3 text-sm font-medium text-gray-700">Make this user an Administrator</span>
                </label>
                <p class="mt-1 text-xs text-gray-500 ml-8">Administrators can manage reports and other users</p>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('admin.users') }}" class="px-6 py-3 border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 font-medium transition">
                    Cancel
                </a>
                <button type="submit" class="btn-water px-8 py-3 rounded-xl text-white font-semibold shadow-lg">
                    Create User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
