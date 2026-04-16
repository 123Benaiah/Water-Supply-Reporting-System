@extends('layouts.app')
@section('title', 'Login - AquaReport')

@section('content')
<div class="min-h-screen flex">
    <div class="hidden lg:flex lg:w-1/2 water-gradient relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PGNpcmNsZSBjeD0iMzAiIGN5PSIzMCIgcj0iOCIvPjwvZz48L2c+PC9zdmc+')] opacity-50"></div>
        <div class="absolute inset-0">
            <div class="bubble w-20 h-20" style="left: 10%; animation-delay: 0s;"></div>
            <div class="bubble w-32 h-32" style="left: 25%; animation-delay: 2s;"></div>
            <div class="bubble w-16 h-16" style="left: 50%; animation-delay: 4s;"></div>
            <div class="bubble w-24 h-24" style="left: 70%; animation-delay: 6s;"></div>
            <div class="bubble w-28 h-28" style="left: 85%; animation-delay: 8s;"></div>
        </div>
        <div class="relative z-10 flex flex-col justify-center items-center w-full px-12 text-white">
            <div class="w-24 h-24 rounded-3xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-8 wave-animation">
                <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
            </div>
            <h1 class="text-5xl font-bold mb-4 text-center">AquaReport</h1>
            <p class="text-xl text-ocean-100 text-center max-w-md mb-8">Your trusted partner in water supply management and issue reporting</p>
            <div class="flex items-center space-x-8 text-sm">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Real-time Tracking</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span>Quick Response</span>
                </div>
            </div>
        </div>
    </div>

    <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-ocean-50 via-white to-aqua-50">
        <div class="w-full max-w-md">
            <div class="text-center lg:text-left mb-8">
                <div class="lg:hidden flex items-center justify-center space-x-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-ocean-500 to-aqua-600 flex items-center justify-center floating">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold water-text-gradient">AquaReport</h1>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
                <p class="mt-2 text-gray-600">Sign in to manage your water supply reports</p>
            </div>

            <div class="glass-card rounded-2xl shadow-xl p-8 card-hover">
                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" required 
                                class="input-water block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none @error('email') border-red-300 bg-red-50 @enderror"
                                placeholder="Enter your email" value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" required 
                                class="input-water block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none @error('password') border-red-300 bg-red-50 @enderror"
                                placeholder="Enter your password">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-ocean-600 border-gray-300 rounded focus:ring-ocean-500">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-water w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl text-sm font-semibold text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ocean-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Sign In
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="font-semibold text-ocean-600 hover:text-ocean-500 transition">
                            Create one now
                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
