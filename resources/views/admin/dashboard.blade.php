@extends('layouts.app')
@section('title', 'Admin Dashboard - ZAWASU')

@section('content')
<div class="mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <div>
            <h1 class="fs-2 fw-bold text-ocean-900">Admin Dashboard</h1>
            <p class="text-muted">Manage all water supply reports and system users</p>
        </div>
    </div>
</div>

<div class="mb-3">
    <div class="btn-group" role="group">
        <button onclick="showTab('reports')" id="tab-reports" class="btn btn-ocean tab-btn">
            <svg width="16" height="16" class="me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Reports
        </button>
        <button onclick="showTab('users')" id="tab-users" class="btn btn-outline-secondary tab-btn">
            <svg width="16" height="16" class="me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Users
        </button>
    </div>
</div>

<div id="tab-content-reports" class="tab-content">
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-3">
            <div class="card shadow border h-100">
                <div class="card-body">
                    <div class="rounded-3 bg-light d-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                        <svg width="28" height="28" class="text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="small text-muted mb-1">Total Reports</p>
                    <p class="fs-3 fw-bold text-ocean-900 mb-0">{{ number_format($stats['total']) }}</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card shadow border border-warning h-100">
                <div class="card-body">
                    <div class="rounded-3 bg-warning-subtle d-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                        <svg width="28" height="28" class="text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="small text-muted mb-1">Pending</p>
                    <p class="fs-3 fw-bold text-warning mb-0">{{ number_format($stats['pending']) }}</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card shadow border border-info h-100">
                <div class="card-body">
                    <div class="rounded-3 bg-info-subtle d-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                        <svg width="28" height="28" class="text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <p class="small text-muted mb-1">In Progress</p>
                    <p class="fs-3 fw-bold text-info mb-0">{{ number_format($stats['in_progress']) }}</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card shadow border border-success h-100">
                <div class="card-body">
                    <div class="rounded-3 bg-success-subtle d-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                        <svg width="28" height="28" class="text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="small text-muted mb-1">Resolved</p>
                    <p class="fs-3 fw-bold text-success mb-0">{{ number_format($stats['resolved']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow border overflow-hidden">
        <div class="card-header bg-light">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <h2 class="fs-5 fw-bold text-ocean-900 d-flex align-items-center mb-0">
                    <svg width="20" height="20" class="me-2 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    All Reports
                </h2>
                <div class="d-flex align-items-center gap-3">
                    <div class="position-relative">
                        <input type="text" id="adminSearchInput" placeholder="Search reports..." 
                            class="form-control form-control-sm" style="width: 200px; padding-left: 2rem;">
                        <svg width="16" height="16" class="text-muted position-absolute" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="left: 0.5rem; top: 50%; transform: translateY(-50%);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <span class="small text-muted">{{ number_format($reports->total()) }} total</span>
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2">
                        <label class="small fw-semibold text-muted">Show:</label>
                        <select name="per_page_reports" onchange="this.form.submit()"
                            class="form-select form-select-sm" style="width: auto;">
                            @foreach([2, 3, 4, 5, 10, 15, 20, 50] as $perPage)
                                <option value="{{ $perPage }}" {{ $reportsPerPage == $perPage ? 'selected' : '' }}>{{ $perPage }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="tab" value="reports">
                    </form>
                </div>
            </div>
        </div>

        @if($reports->isEmpty())
            <div class="p-5 text-center">
                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                    <svg width="40" height="40" class="text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="fs-5 fw-bold text-ocean-900 mb-2">No Reports Found</h3>
                <p class="text-muted">There are no water supply reports to manage at this time.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
<th class="py-3 text-start small fw-bold text-muted text-uppercase">Image</th>
                            <th class="py-3 text-start small fw-bold text-muted text-uppercase">User</th>
                            <th class="py-3 text-start small fw-bold text-muted text-uppercase">Title</th>
                            <th class="py-3 text-start small fw-bold text-muted text-uppercase">Type</th>
                            <th class="py-3 text-start small fw-bold text-muted text-uppercase">Status</th>
                            <th class="py-3 text-start small fw-bold text-muted text-uppercase">Date</th>
                            <th class="py-3 text-start small fw-bold text-muted text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody id="reportsTableBody">
                        @foreach($reports as $report)
                            <tr>
                                <td class="py-3">
                                    @if($report->images && count($report->images) > 0)
                                        <img src="{{ asset('storage/' . $report->images[0]) }}" alt="Report image" class="rounded-3 object-fit-cover" style="width: 60px; height: 40px;">
                                    @else
                                        <div class="rounded-3 bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 40px;">
                                            <svg width="20" height="20" class="text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-ocean-600 d-flex align-items-center justify-content-center text-white fw-bold" style="width: 40px; height: 40px; background: linear-gradient(135deg, #0ea5e9, #0891b2);">
                                            {{ strtoupper(substr($report->user->name, 0, 1)) }}
                                        </div>
                                        <span class="small fw-semibold text-ocean-900">{{ $report->user->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="small fw-semibold text-ocean-900 text-truncate" style="max-width: 150px;">{{ $report->title }}</div>
                                    <div class="small text-muted text-truncate" style="max-width: 150px;">{{ $report->location }}</div>
                                </td>
                                <td class="py-3 text-nowrap">
                                    <span class="badge bg-secondary">{{ $report->issue_type }}</span>
                                </td>
                                <td class="py-3 text-nowrap">
                                    @if($report->status == 'Pending')
                                        <span class="badge bg-warning text-dark rounded-pill">
                                            <span class="d-inline-block rounded-circle bg-warning me-1" style="width: 6px; height: 6px;"></span>
                                            Pending
                                        </span>
                                    @elseif($report->status == 'In Progress')
                                        <span class="badge bg-info text-dark rounded-pill">
                                            <span class="d-inline-block rounded-circle bg-info me-1" style="width: 6px; height: 6px;"></span>
                                            In Progress
                                        </span>
                                    @else
                                        <span class="badge bg-success rounded-pill">
                                            <svg width="12" height="12" class="me-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Resolved
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 text-nowrap small text-muted">
                                    {{ $report->created_at->format('M d, Y') }}
                                </td>
                                <td class="py-3 text-nowrap">
                                    <a href="{{ route('admin.reports.show', $report) }}" class="btn btn-ocean btn-sm">
                                        Manage
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-light d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                {{ $reports->appends(['tab' => 'reports', 'per_page_reports' => $reportsPerPage, 'per_page_users' => $usersPerPage])->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

<div id="tab-content-users" class="tab-content d-none">
    <div class="card shadow border overflow-hidden">
        <div class="card-header bg-light">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <h2 class="fs-5 fw-bold text-ocean-900 d-flex align-items-center mb-0">
                    <svg width="20" height="20" class="me-2 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    User Management
                </h2>
                <div class="d-flex align-items-center gap-3">
                    <button onclick="toggleAddUserForm()" class="btn btn-ocean d-flex align-items-center">
                        <svg width="16" height="16" class="me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add User
                    </button>
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2">
                        <label class="small fw-semibold text-muted">Show:</label>
                        <select name="per_page_users" onchange="this.form.submit()"
                            class="form-select form-select-sm" style="width: auto;">
                            @foreach([2, 3, 4, 5, 10, 15, 20, 50] as $perPage)
                                <option value="{{ $perPage }}" {{ $usersPerPage == $perPage ? 'selected' : '' }}>{{ $perPage }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="tab" value="users">
                    </form>
                </div>
            </div>
        </div>

        <div id="addUserForm" class="d-none p-4 bg-light border-bottom">
            <form action="{{ route('admin.users.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Full Name</label>
                    <input type="text" name="name" required placeholder="John Doe"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Email Address</label>
                    <input type="email" name="email" required placeholder="john@example.com"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Role</label>
                    <select name="role" required class="form-select">
                        <option value="">Select Role</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Reporter</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Password</label>
                    <input type="password" name="password" required placeholder="Min. 8 characters"
                        class="form-control @error('password') is-invalid @enderror">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold small">Confirm Password</label>
                    <input type="password" name="password_confirmation" required placeholder="Re-enter password"
                        class="form-control">
                </div>
                <div class="col-12 d-flex justify-content-end gap-2 pt-2">
                    <button type="button" onclick="toggleAddUserForm()" class="btn btn-outline-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-ocean">
                        Create User
                    </button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 text-start small fw-bold text-muted text-uppercase">User</th>
                        <th class="py-3 text-start small fw-bold text-muted text-uppercase">Email</th>
                        <th class="py-3 text-start small fw-bold text-muted text-uppercase">Role</th>
                        <th class="py-3 text-start small fw-bold text-muted text-uppercase">Reports</th>
                        <th class="py-3 text-start small fw-bold text-muted text-uppercase">Joined</th>
                        <th class="py-3 text-start small fw-bold text-muted text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-2">
                                    @if($user->profile_picture)
                                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="rounded-circle" width="40" height="40">
                                    @else
                                        <div class="rounded-circle bg-ocean-600 d-flex align-items-center justify-content-center text-white fw-bold small" style="width: 40px; height: 40px; background: linear-gradient(135deg, #0ea5e9, #0369a1);">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="small fw-semibold text-ocean-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 text-nowrap small text-muted">{{ $user->email }}</td>
                            <td class="py-3 text-nowrap">
                                <span class="badge {{ $user->isAdmin() ? 'bg-ocean-700' : 'bg-secondary' }}">
                                    {{ $user->isAdmin() ? 'Admin' : 'Reporter' }}
                                </span>
                            </td>
                            <td class="py-3 text-nowrap small text-muted">{{ $user->reports_count }}</td>
                            <td class="py-3 text-nowrap small text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="py-3 text-nowrap">
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary btn-sm" title="Edit User">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure? This will delete all reports by {{ $user->name }}.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete User">
                                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <span class="small text-muted">(You)</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-light d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            {{ $users->appends(['tab' => 'users', 'per_page_users' => $usersPerPage, 'per_page_reports' => $reportsPerPage])->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<script>
let currentTab = 'reports';

function showTab(tab) {
    currentTab = tab;
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('d-none'));
    document.getElementById(`tab-content-${tab}`).classList.remove('d-none');
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('btn-ocean');
        btn.classList.add('btn-outline-secondary');
    });
    const activeBtn = document.getElementById(`tab-${tab}`);
    activeBtn.classList.remove('btn-outline-secondary');
    activeBtn.classList.add('btn-ocean');
}

function toggleAddUserForm() {
    const form = document.getElementById('addUserForm');
    form.classList.toggle('d-none');
}

const urlParams = new URLSearchParams(window.location.search);
const tabParam = urlParams.get('tab');
if (tabParam === 'users') {
    showTab('users');
} else {
    showTab('reports');
}

document.getElementById('adminSearchInput')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#tab-content-reports tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

document.addEventListener('DOMContentLoaded', function() {
    attachPaginationListeners();
});
</script>
@endsection
