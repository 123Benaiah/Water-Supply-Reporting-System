@extends('layouts.app')
@section('title', 'Create User - ZAWASU')

@section('content')
<div class="mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.users') }}" class="p-2 rounded-3 bg-light text-decoration-none">
            <svg width="20" height="20" class="text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="fs-2 fw-bold text-ocean-900">Create New User</h1>
            <p class="text-muted">Add a new user to the system</p>
        </div>
    </div>
</div>

<div style="max-width: 600px;">
    <div class="card shadow-lg">
        <div class="card-body p-4">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Enter full name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Enter email address">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" required
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Enter password (min 8 characters)">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                        class="form-control"
                        placeholder="Confirm password">
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}
                            class="form-check-input" id="is_admin">
                        <label class="form-check-label fw-medium" for="is_admin">Make this user an Administrator</label>
                    </div>
                    <p class="small text-muted mb-0 ms-4">Administrators can manage reports and other users</p>
                </div>

                <div class="d-flex align-items-center justify-content-end gap-3 pt-3">
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-ocean">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
