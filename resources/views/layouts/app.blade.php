<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ZAWASU - Zambia Water Supply Reporting System')</title>
    <link rel="icon" type="image/png" href="{{ asset('ZAWASU-logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ocean-50: #f0f9ff;
            --ocean-100: #e0f2fe;
            --ocean-200: #bae6fd;
            --ocean-300: #7dd3fc;
            --ocean-400: #38bdf8;
            --ocean-500: #0ea5e9;
            --ocean-600: #0284c7;
            --ocean-700: #0369a1;
            --ocean-800: #075985;
            --ocean-900: #0c4a6e;
            --aqua-500: #06b6d4;
            --aqua-600: #0891b2;
            --nature-500: #22c55e;
        }
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #f0f9ff 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(14, 165, 233, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(6, 182, 212, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(2, 132, 199, 0.05) 0%, transparent 30%);
            pointer-events: none;
            z-index: -1;
        }
        .bg-ocean-50 { background-color: var(--ocean-50); }
        .bg-ocean-100 { background-color: var(--ocean-100); }
        .bg-ocean-200 { background-color: var(--ocean-200); }
        .bg-ocean-500 { background-color: var(--ocean-500); }
        .bg-ocean-600 { background-color: var(--ocean-600); }
        .bg-ocean-700 { background-color: var(--ocean-700); }
        .bg-ocean-800 { background-color: var(--ocean-800); }
        .bg-ocean-900 { background-color: var(--ocean-900); }
        .bg-aqua-500 { background-color: var(--aqua-500); }
        .bg-aqua-600 { background-color: var(--aqua-600); }
        .bg-nature-500 { background-color: var(--nature-500); }
        .text-ocean-50 { color: var(--ocean-50); }
        .text-ocean-100 { color: var(--ocean-100); }
        .text-ocean-200 { color: var(--ocean-200); }
        .text-ocean-300 { color: var(--ocean-300); }
        .text-ocean-600 { color: var(--ocean-600); }
        .text-ocean-700 { color: var(--ocean-700); }
        .text-ocean-800 { color: var(--ocean-800); }
        .text-ocean-900 { color: var(--ocean-900); }
        .text-aqua-600 { color: var(--aqua-600); }
        .text-nature-600 { color: var(--nature-500); }
        .btn-ocean { background-color: var(--ocean-600); border-color: var(--ocean-600); color: white; }
        .btn-ocean:hover { background-color: var(--ocean-700); border-color: var(--ocean-700); color: white; }
        .border-ocean-600 { border-color: var(--ocean-600); }
        .border-ocean-100 { border-color: var(--ocean-100); }
        .rounded-xl { border-radius: 0.75rem; }
        .rounded-2xl { border-radius: 1rem; }
        .rounded-3xl { border-radius: 1.5rem; }
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        .shadow-xl { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="min-vh-100">
    @guest
        @yield('content')
    @else
        <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-lg sticky-top" style="z-index: 1030;">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
                    <img src="{{ asset('ZAWASU-logo.png') }}" alt="ZAWASU Logo" class="rounded-3 me-2" width="40" height="40">
                    <span class="fw-bold fs-4 text-ocean-900">ZAWASU</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-4">
                        @if(Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link fw-semibold {{ request()->routeIs('admin.*') ? 'btn btn-ocean text-white px-3 py-2' : '' }}">
                                    <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Admin Panel
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link fw-semibold {{ request()->routeIs('dashboard') ? 'active bg-light' : '' }}">
                                    <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('reports.create') }}" class="nav-link fw-semibold">
                                    <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    New Report
                                </a>
                            </li>
                        @endif
                    </ul>
                    <div class="dropdown">
                        <button class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                            @if(Auth::user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="rounded-circle border me-2" width="40" height="40">
                            @else
                                <div class="rounded-circle bg-ocean-600 d-flex align-items-center justify-content-center text-white fw-bold me-2 border" style="width: 40px; height: 40px;">
                                    {{ Auth::user()->initials }}
                                </div>
                            @endif
                            <div class="d-none d-md-block text-start">
                                <p class="mb-0 fw-bold text-ocean-900 small">{{ Auth::user()->name }}</p>
                                <p class="mb-0 text-muted" style="font-size: 0.75rem;">{{ Auth::user()->isAdmin() ? 'Administrator' : 'Reporter' }}</p>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li>
                                <a href="{{ route('profile.show') }}" class="dropdown-item d-flex align-items-center py-2">
                                    <svg class="me-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    My Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item d-flex align-items-center text-danger py-2">
                                        <svg class="me-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <main class="container py-4">
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center mb-4">
                    <svg class="me-2 flex-shrink-0" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="fw-semibold">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center mb-4">
                    <svg class="me-2 flex-shrink-0" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="fw-semibold">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="mt-5 bg-ocean-600 text-white py-4">
            <div class="container text-center">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <div class="bg-ocean-700 rounded-3 d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <span class="fw-bold">ZAWASU</span>
                </div>
                <p class="text-ocean-200 small mb-0">&copy; {{ date('Y') }} ZAWASU - Zambia Water Supply Reporting System.</p>
            </div>
        </footer>
    @endguest
    <div id="globalLoader" class="position-fixed top-0 start-0 w-100 h-100 bg-white bg-opacity-75 d-none justify-content-center align-items-center" style="z-index: 9999;">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Please wait...</p>
        </div>
    </div>
    <script>
    // Hide loader on page load (in case it was stuck from previous navigation)
    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.getElementById('globalLoader');
        if (loader) {
            loader.classList.add('d-none');
            loader.classList.remove('d-flex');
        }
    });

    // Also hide loader when page becomes visible (handles back/forward navigation)
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            const loader = document.getElementById('globalLoader');
            if (loader) {
                loader.classList.add('d-none');
                loader.classList.remove('d-flex');
            }
        }
    });

    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (form.checkValidity()) {
                const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn && !submitBtn.classList.contains('no-loader')) {
                    setTimeout(function() {
                        const loader = document.getElementById('globalLoader');
                        loader.classList.remove('d-none');
                        loader.classList.add('d-flex');
                    }, 100);
                }
            } else {
                form.classList.add('was-validated');
            }
        });
    });
    document.querySelectorAll('a.btn').forEach(function(link) {
        link.addEventListener('click', function(e) {
            const loader = document.getElementById('globalLoader');
            loader.classList.remove('d-none');
            loader.classList.add('d-flex');
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
