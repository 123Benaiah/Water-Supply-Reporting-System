@extends('layouts.app')

@section('title', 'My Profile - ZAWASU')

@section('content')
<div style="max-width: 900px;" class="mx-auto">
    <h1 class="fs-2 fw-bold text-ocean-900">My Profile</h1>
    <p class="text-muted">Manage your account information and security</p>

    <div class="row g-4 mt-2">
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-lg mb-3">
                <div class="card-body p-4 text-center">
                    @if($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" class="rounded-circle object-fit-cover mx-auto border" width="128" height="128">
                    @else
                        <div class="rounded-circle bg-ocean-600 d-flex align-items-center justify-content-center mx-auto text-white fs-1 fw-bold border" style="width: 128px; height: 128px; background: linear-gradient(135deg, #0ea5e9, #0369a1);">
                            {{ $user->initials }}
                        </div>
                    @endif
                    <h3 class="mt-3 fs-5 fw-bold text-ocean-900">{{ $user->name }}</h3>
                    <p class="text-muted small fw-medium">{{ $user->email }}</p>
                    <div class="mt-2">
                        <span class="badge bg-ocean-700 fs-6">
                            {{ $user->isAdmin() ? 'Administrator' : 'Reporter' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card shadow-lg">
                <div class="card-body p-2">
                    <nav class="nav nav-pills flex-column">
                        <a href="{{ route('profile.show', ['tab' => 'profile']) }}" 
                           class="nav-link {{ ($tab ?? 'profile') === 'profile' ? 'active bg-ocean-600' : 'text-dark' }}">
                            <svg width="20" height="20" class="me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profile Info
                        </a>
                        <a href="{{ route('profile.show', ['tab' => 'picture']) }}" 
                           class="nav-link {{ ($tab ?? 'profile') === 'picture' ? 'active bg-ocean-600' : 'text-dark' }}">
                            <svg width="20" height="20" class="me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Profile Picture
                        </a>
                        <a href="{{ route('profile.show', ['tab' => 'security']) }}" 
                           class="nav-link {{ ($tab ?? 'profile') === 'security' ? 'active bg-ocean-600' : 'text-dark' }}">
                            <svg width="20" height="20" class="me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Security
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-8">
            @if(($tab ?? 'profile') === 'profile')
                <div class="card shadow-lg">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="fs-4 fw-bold text-ocean-900 mb-4">Profile Information</h2>
                        <form action="{{ route('profile.update-profile') }}" method="POST">
                            @csrf
                            @method('PATCH')
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
                                    <label class="form-label fw-semibold">Phone Number</label>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                        class="form-control">
                                </div>
                                <div>
                                    <label class="form-label fw-semibold">Address</label>
                                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-ocean px-4 py-2 shadow-lg">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif($tab === 'picture')
                <div class="card shadow-lg">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="fs-4 fw-bold text-ocean-900 mb-4">Profile Picture</h2>
                        <form action="{{ route('profile.update-picture') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="text-center mb-4">
                                <div id="imagePreviewContainer">
                                    @if($user->profile_picture)
                                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Current Profile" class="rounded-3 object-fit-cover border shadow-lg" width="192" height="192" id="imagePreview">
                                    @else
                                        <div class="rounded-3 d-inline-flex align-items-center justify-content-center text-white fs-1 fw-bold border shadow-lg" style="width: 192px; height: 192px; background: linear-gradient(135deg, #0ea5e9, #0369a1);" id="imagePreviewPlaceholder">
                                            {{ $user->initials }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div style="max-width: 300px;" class="mx-auto">
                                <h3 class="fs-5 fw-bold text-ocean-900 mb-2 text-center">Upload New Picture</h3>
                                <p class="small text-muted mb-4 text-center">JPG, PNG or WEBP. Max 2MB.</p>
                                
                                <div class="mb-3">
                                    <input type="file" name="profile_picture" id="profile_picture" class="d-none" accept="image/*" onchange="previewImage(event)">
                                    <label for="profile_picture" class="d-flex align-items-center justify-content-center px-4 py-3 border border-2 border-dashed border-secondary rounded-3 cursor-pointer">
                                        <svg width="24" height="24" class="text-muted me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="small fw-semibold text-muted">Click to browse files</span>
                                    </label>
                                </div>
                                
                                <button type="submit" class="btn btn-ocean w-100">
                                    Update Picture
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif($tab === 'security')
                <div class="card shadow-lg">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="fs-4 fw-bold text-ocean-900 mb-4">Change Password</h2>
                        <form action="{{ route('profile.update-password') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="vstack gap-3">
                                <div>
                                    <label class="form-label fw-semibold">Current Password</label>
                                    <input type="password" name="current_password" required
                                        class="form-control @error('current_password') is-invalid @enderror">
                                    @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div>
                                    <label class="form-label fw-semibold">New Password</label>
                                    <input type="password" name="password" required
                                        class="form-control @error('password') is-invalid @enderror">
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div>
                                    <label class="form-label fw-semibold">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" required
                                        class="form-control">
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-ocean px-4 py-2 shadow-lg">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const container = document.getElementById('imagePreviewContainer');

    if (file) {
        // Validate file type
        if (!file.type.match('image.*')) {
            alert('Please select an image file (JPG, PNG, or WEBP)');
            return;
        }

        // Validate file size (2MB = 2097152 bytes)
        if (file.size > 2097152) {
            alert('File size must be less than 2MB');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            container.innerHTML = '<img src="' + e.target.result + '" alt="Preview" class="rounded-3 object-fit-cover border shadow-lg" width="192" height="192" id="imagePreview" style="transition: opacity 0.3s ease;">';

            // Add a "Selected" badge below the image
            const badge = document.createElement('div');
            badge.className = 'mt-2';
            badge.innerHTML = '<span class="badge bg-success"><svg width="12" height="12" class="me-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Image selected</span>';
            container.appendChild(badge);
        };

        reader.onerror = function() {
            alert('Error reading file. Please try again.');
        };

        reader.readAsDataURL(file);
    }
}

// Update label text when file is selected
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('profile_picture');
    const fileLabel = document.querySelector('label[for="profile_picture"]');

    if (fileInput && fileLabel) {
        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                const span = fileLabel.querySelector('span');
                if (span) {
                    span.textContent = fileName;
                    span.classList.remove('text-muted');
                    span.classList.add('text-success');
                }
            }
        });
    }
});
</script>
@endsection
