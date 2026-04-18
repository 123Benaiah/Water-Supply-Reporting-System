@extends('layouts.app')

@section('title', 'Forgot Password - ZAWASU')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center py-5 px-3 px-sm-4 px-lg-5 bg-light">
    <div class="w-100" style="max-width: 600px;">
        <div class="bg-white rounded-4 shadow-lg overflow-hidden border">
            <div class="p-4 p-sm-5">
                <div class="text-center mb-4">
                    <div class="rounded-circle bg-ocean-100 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 64px; height: 64px;">
                        <svg width="32" height="32" class="text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <h2 class="fs-2 fw-bold text-ocean-900">Forgot Password?</h2>
                    <p class="text-muted mt-2">Enter your email address and we'll send you a link to reset your password.</p>
                </div>

                @if(session('status'))
                    <div class="alert alert-success mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-bold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/>
                                </svg>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="name@company.com">
                        </div>
                        @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-ocean w-100 py-3 shadow-lg fw-bold mb-3">
                        Send Reset Link
                    </button>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-ocean-600 fw-bold text-decoration-none">
                            <svg width="16" height="16" class="me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
