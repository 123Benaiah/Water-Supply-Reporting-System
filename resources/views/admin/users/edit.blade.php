@extends('layouts.app')

@section('title', 'Edit User - ZAWASU')

@section('content')
<div style="max-width: 900px;" class="mx-auto">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('admin.users') }}" class="p-2 rounded-3 bg-light text-decoration-none">
            <svg width="20" height="20" class="text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="fs-2 fw-bold text-ocean-900">Edit User</h1>
            <p class="text-muted">Update user information and role</p>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-lg mb-3">
                <div class="card-body p-4 text-center">
                    @if($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" class="rounded-circle object-fit-cover mx-auto border" width="128" height="128">
                    @else
                        <div class="rounded-circle bg-ocean-600 d-flex align-items-center justify-content-center mx-auto text-white fs-1 fw-bold border" style="width: 128px; height: 128px; background: linear-gradient(135deg, #0ea5e9, #0369a1);">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                    <h3 class="mt-3 fs-5 fw-bold text-ocean-900">{{ $user->name }}</h3>
                    <p class="text-muted small fw-medium">{{ $user->email }}</p>
                    <div class="mt-2">
                        <span class="badge {{ $user->isAdmin() ? 'bg-ocean-700' : 'bg-secondary' }} fs-6">
                            {{ $user->isAdmin() ? 'Administrator' : 'Reporter' }}
                        </span>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <p class="small text-muted mb-1">Joined</p>
                        <p class="small fw-medium text-ocean-900">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="card shadow-lg">
                <div class="card-body p-3">
                    <a href="{{ route('admin.users') }}" class="d-flex align-items-center gap-2 text-decoration-none text-dark p-2 rounded hover-bg-light">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span class="small fw-medium">Back to Users</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card shadow-lg">
                <div class="card-body p-4 p-md-5">
                    <h2 class="fs-4 fw-bold text-ocean-900 mb-4">User Information</h2>
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="vstack gap-3">
                            <div>
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="form-control @error('name') is-invalid @enderror">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div>
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="form-control @error('email') is-invalid @enderror">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div>
                                <label class="form-label fw-semibold">
                                    New Password <span class="text-muted fw-normal">(Leave blank to keep current)</span>
                                </label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Min. 8 characters">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div>
                                <label class="form-label fw-semibold">Confirm New Password</label>
                                <input type="password" name="password_confirmation"
                                    class="form-control"
                                    placeholder="Re-enter new password">
                            </div>
                            <div class="pt-2">
                                <div class="form-check">
                                    <input type="checkbox" name="is_admin" value="1" {{ $user->is_admin ? 'checked' : '' }}
                                        class="form-check-input" id="is_admin">
                                    <label class="form-check-label fw-medium" for="is_admin">Administrator Privileges</label>
                                </div>
                                <p class="small text-muted mb-0 ms-4">Allow this user to manage reports and other users</p>
                            </div>
                        </div>
                        <div class="mt-4 d-flex justify-content-between">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary px-4">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-ocean px-4 shadow-lg">
                                <svg width="20" height="20" class="me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-bg-light:hover {
    background-color: rgba(0,0,0,0.03);
}
</style>
@endsection
