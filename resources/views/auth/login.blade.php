@extends('layouts.app')

@section('title', 'Login - ZAWASU')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center py-5 px-3 px-sm-4 px-lg-5 bg-light">
    <div class="w-100" style="max-width: 1200px;">
        <div class="row g-0 bg-white rounded-4 shadow-lg overflow-hidden border">
            <!-- Brand Section -->
            <div class="d-none d-lg-flex col-lg-6 bg-ocean-900 position-relative overflow-hidden" style="background: linear-gradient(135deg, #0c4a6e, #0369a1);">
                <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25">
                    <div class="position-absolute rounded-circle bg-white" style="width: 300px; height: 300px; top: -50px; left: -50px; filter: blur(60px);"></div>
                    <div class="position-absolute rounded-circle" style="width: 250px; height: 250px; top: 40%; right: -50px; background: #7dd3fc; filter: blur(60px);"></div>
                </div>
                
                <div class="position-relative w-100 p-5 d-flex flex-column justify-content-between text-white" style="z-index: 10;">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ asset('ZAWASU-logo.png') }}" alt="ZAWASU Logo" class="rounded-3 object-fit-cover bg-white p-1" width="48" height="48">
                        <span class="fs-3 fw-black">ZAWASU</span>
                    </div>
                    
                    <div class="my-5">
                        <h1 class="display-4 fw-bold mb-4">
                            Welcome<br/>
                            <span class="text-info">Back.</span>
                        </h1>
                        <p class="text-white-50 fs-5">
                            Continue your journey in helping us monitor and improve the water supply system in Zambia.
                        </p>
                    </div>

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="d-flex">
                            <div class="rounded-circle border border-2 border-ocean-900 bg-ocean-100 d-flex align-items-center justify-content-center text-ocean-900 fw-bold small" style="width: 40px; height: 40px; margin-right: -8px;">JD</div>
                            <div class="rounded-circle border border-2 border-ocean-900 bg-info-subtle d-flex align-items-center justify-content-center text-info fw-bold small" style="width: 40px; height: 40px; margin-right: -8px;">AM</div>
                            <div class="rounded-circle border border-2 border-ocean-900 bg-success-subtle d-flex align-items-center justify-content-center text-success fw-bold small" style="width: 40px; height: 40px;">RK</div>
                        </div>
                        <p class="small fw-semibold text-white-50">Joined by 10,000+ citizens</p>
                    </div>

                    <div class="pt-4 border-top border-white-10 d-flex align-items-center justify-content-between small text-white-50">
                        <p class="mb-0">&copy; {{ date('Y') }} ZAWASU Reporting System</p>
                        <div class="d-flex gap-3">
                            <a href="#" class="text-white-50 text-decoration-none">Privacy</a>
                            <a href="#" class="text-white-50 text-decoration-none">Terms</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="col-12 col-lg-6 p-4 p-sm-5 p-md-5 p-lg-5 d-flex flex-column justify-content-center bg-white">
                <div class="mb-4 text-center text-lg-start">
                    <h2 class="fs-2 fw-bold text-ocean-900">Welcome Back</h2>
                    <p class="text-muted mt-2">Don't have an account yet? 
                        <a href="{{ route('register') }}" class="text-ocean-600 fw-bold text-decoration-underline">Create one for free</a>
                    </p>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
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

                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <label class="form-label fw-bold">Password</label>
                            <a href="{{ route('password.request') }}" class="small fw-bold text-ocean-600 text-decoration-none">Forgot password?</a>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input type="password" name="password" required
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="••••••••">
                        </div>
                        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
                        <label for="remember_me" class="form-check-label fw-bold">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-ocean w-100 py-3 shadow-lg fs-5 fw-bold">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.border-white-10 { border-color: rgba(255,255,255,0.1) !important; }
</style>
@endsection
