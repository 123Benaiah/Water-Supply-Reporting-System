@extends('layouts.app')
@section('title', 'User Management - ZAWASU')

@section('content')
<div class="mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <div>
            <h1 class="fs-2 fw-bold text-ocean-900">User Management</h1>
            <p class="text-muted">Manage all registered users</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-ocean mt-3 mt-md-0 d-inline-flex align-items-center">
            <svg width="20" height="20" class="me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add New User
        </a>
    </div>
</div>

<div class="card shadow-lg border overflow-hidden">
    <div class="card-header bg-light">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h2 class="fs-5 fw-bold mb-0 d-flex align-items-center">
                <svg width="20" height="20" class="me-2 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                All Users
            </h2>
            <div class="d-flex align-items-center gap-3">
                <div class="position-relative">
                    <input type="text" id="userSearchInput" placeholder="Search users..." 
                        class="form-control form-control-sm" style="width: 200px; padding-left: 2rem;">
                    <svg width="16" height="16" class="text-muted position-absolute" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="left: 0.5rem; top: 50%; transform: translateY(-50%);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <span class="small text-muted">{{ $users->total() }} users</span>
            </div>
        </div>
    </div>

    @if($users->isEmpty())
        <div class="p-5 text-center">
            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                <svg width="40" height="40" class="text-ocean-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <h3 class="fs-5 fw-bold text-ocean-900 mb-2">No Users Found</h3>
            <p class="text-muted">There are no users in the system.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 text-start small fw-bold text-muted text-uppercase">User</th>
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
                                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="" class="rounded-circle" width="40" height="40">
                                    @elseif($user->isAdmin())
                                        <div class="rounded-3 d-flex align-items-center justify-content-center text-white fw-bold small" style="width: 40px; height: 40px; background: linear-gradient(135deg, #a855f7, #ec4899);">
                                            {{ $user->initials }}
                                        </div>
                                    @else
                                        <div class="rounded-3 d-flex align-items-center justify-content-center text-white fw-bold small" style="width: 40px; height: 40px; background: linear-gradient(135deg, #0ea5e9, #06b6d4);">
                                            {{ $user->initials }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="small fw-semibold text-ocean-900 mb-0">{{ $user->name }}</p>
                                        <p class="small text-muted mb-0">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-nowrap">
                                @if($user->isAdmin())
                                    <span class="badge bg-purple-700">
                                        Administrator
                                    </span>
                                @else
                                    <span class="badge bg-ocean-600">
                                        Reporter
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 text-nowrap">
                                <span class="badge bg-secondary">{{ $user->reports->count() }} reports</span>
                            </td>
                            <td class="py-3 text-nowrap small text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="py-3 text-nowrap">
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure? All reports by this user will also be deleted.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-light">
            {{ $users->links() }}
        </div>
    @endif
</div>

<script>
document.getElementById('userSearchInput')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endsection
