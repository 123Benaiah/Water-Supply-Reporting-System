@extends('layouts.app')

@section('title', 'Reset Password - ZAWASU')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center py-5 px-3 px-sm-4 px-lg-5 bg-light">
    <div class="w-100" style="max-width: 600px;">
        <div class="bg-white rounded-4 shadow-lg overflow-hidden border">
            <div class="p-4 p-sm-5">
                <div class="text-center mb-4">
                    <div class="rounded-circle bg-ocean-100 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 64px; height: 64px;">
                        <svg width="32" height="32" class="text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h2 class="fs-2 fw-bold text-ocean-900">Reset Password</h2>
                    <p class="text-muted mt-2">Create a new password for your account.</p>
                </div>

                @if(session('status'))
                    <div class="alert alert-success mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email Address</label>
                        <input type="email" value="{{ $email }}" disabled
                            class="form-control bg-light">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">New Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input type="password" name="password" required
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="••••••••">
                        </div>
                        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </span>
                            <input type="password" name="password_confirmation" required
                                class="form-control"
                                placeholder="••••••••">
                        </div>
                    </div>

                    @error('email')
                        <div class="alert alert-danger mb-3">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-ocean w-100 py-3 shadow-lg fw-bold">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
