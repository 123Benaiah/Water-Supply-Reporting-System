@extends('layouts.app')
@section('title', 'My Profile - AquaReport')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
    <p class="text-gray-600">Manage your account settings</p>
</div>

<div class="grid lg:grid-cols-4 gap-8">
    <div class="lg:col-span-1">
        <div class="glass-card rounded-2xl shadow-xl p-6">
            <div class="text-center mb-6">
                @if($user->profile_picture)
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-ocean-200">
                @else
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-ocean-400 to-aqua-500 flex items-center justify-center mx-auto text-white text-4xl font-bold border-4 border-ocean-200">
                        {{ $user->initials }}
                    </div>
                @endif
                <h3 class="mt-4 text-xl font-bold text-gray-900">{{ $user->name }}</h3>
                <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                @if($user->isAdmin())
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-purple-100 to-pink-100 text-purple-800 mt-2">
                        Administrator
                    </span>
                @endif
            </div>

            <nav class="space-y-2">
                <a href="{{ route('profile.show', ['tab' => 'profile']) }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition {{ ($tab ?? 'profile') === 'profile' ? 'bg-ocean-50 text-ocean-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profile Info
                </a>
                <a href="{{ route('profile.show', ['tab' => 'picture']) }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition {{ ($tab ?? 'profile') === 'picture' ? 'bg-ocean-50 text-ocean-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Profile Picture
                </a>
                <a href="{{ route('profile.show', ['tab' => 'security']) }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition {{ ($tab ?? 'profile') === 'security' ? 'bg-ocean-50 text-ocean-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Security
                </a>
            </nav>
        </div>
    </div>

    <div class="lg:col-span-3">
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-gradient-to-r from-nature-100 to-nature-50 border border-nature-200 text-nature-800 flex items-center space-x-3">
                <svg class="w-6 h-6 text-nature-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(($tab ?? 'profile') === 'profile')
            <div class="glass-card rounded-2xl shadow-xl p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Profile Information</h2>
                <form action="{{ route('profile.update-profile') }}" method="POST">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="input-water w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none @error('name') border-red-300 bg-red-50 @enderror">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="input-water w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none @error('email') border-red-300 bg-red-50 @enderror">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phone <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                class="input-water w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Address <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                class="input-water w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none">
                        </div>
                    </div>
                    <div class="mt-8">
                        <button type="submit" class="btn-water px-8 py-3 rounded-xl text-white font-semibold shadow-lg">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        @endif

        @if($tab === 'picture')
            <div class="glass-card rounded-2xl shadow-xl p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Profile Picture</h2>
                
                <div class="flex items-start space-x-8">
                    <div class="flex-shrink-0">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" class="w-48 h-48 rounded-2xl object-cover border-4 border-ocean-200">
                        @else
                            <div class="w-48 h-48 rounded-2xl bg-gradient-to-br from-ocean-400 to-aqua-500 flex items-center justify-center text-white text-6xl font-bold border-4 border-ocean-200">
                                {{ $user->initials }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Upload New Picture</h3>
                        <p class="text-gray-500 text-sm mb-6"> JPG, PNG or GIF. Max size 2MB.</p>
                        
                        <form action="{{ route('profile.update-picture') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <input type="file" name="profile_picture" id="profile_picture" accept="image/*" required
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none @error('profile_picture') border-red-300 bg-red-50 @enderror">
                                @error('profile_picture')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="btn-water px-6 py-3 rounded-xl text-white font-semibold shadow-lg">
                                Upload Picture
                            </button>
                        </form>

                        @if($user->profile_picture)
                            <form action="{{ route('profile.delete-picture') }}" method="POST" class="mt-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 border border-red-300 rounded-lg text-red-600 hover:bg-red-50 font-medium transition">
                                    Remove Picture
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if($tab === 'security')
            <div class="glass-card rounded-2xl shadow-xl p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Change Password</h2>
                
                @if(session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-red-100 border border-red-200 text-red-800">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('profile.update-password') }}" method="POST">
                    @csrf
                    <div class="space-y-6 max-w-md">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Current Password</label>
                            <input type="password" name="current_password" required
                                class="input-water w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none @error('current_password') border-red-300 bg-red-50 @enderror">
                            @error('current_password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                            <input type="password" name="password" required
                                class="input-water w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none @error('password') border-red-300 bg-red-50 @enderror">
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password</label>
                            <input type="password" name="password_confirmation" required
                                class="input-water w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none">
                        </div>
                    </div>
                    <div class="mt-8">
                        <button type="submit" class="btn-water px-8 py-3 rounded-xl text-white font-semibold shadow-lg">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
