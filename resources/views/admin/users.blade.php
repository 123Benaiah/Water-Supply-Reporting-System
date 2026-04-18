@extends('layouts.app')
@section('title', 'User Management - ZAWASU')

@section('content')
<div class="mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <div>
            <h1 class="fs-2 fw-bold text-ocean-900">User Management</h1>
            <p class="text-muted">View and manage all registered users</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary mt-3 mt-md-0 d-inline-flex align-items-center">
            <svg width="20" height="20" class="me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Dashboard
        </a>
    </div>
</div>

<div class="card shadow-lg border overflow-hidden">
    <div class="card-header bg-light">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="fs-5 fw-bold mb-0 d-flex align-items-center">
                <svg width="20" height="20" class="me-2 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                All Users
            </h2>
            <span class="small text-muted">{{ $users->total() }} users</span>
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
            <p class="text-muted">There are no registered users in the system.</p>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-2">
                                    @if($user->isAdmin())
                                        <div class="rounded-3 d-flex align-items-center justify-content-center text-white fw-bold small" style="width: 40px; height: 40px; background: linear-gradient(135deg, #a855f7, #ec4899);">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @else
                                        <div class="rounded-3 d-flex align-items-center justify-content-center text-white fw-bold small" style="width: 40px; height: 40px; background: linear-gradient(135deg, #0ea5e9, #06b6d4);">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
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
                                    <span class="badge bg-purple-700">Administrator</span>
                                @else
                                    <span class="badge bg-ocean-600">Reporter</span>
                                @endif
                            </td>
                            <td class="py-3 text-nowrap">
                                <span class="badge bg-secondary">{{ $user->reports->count() }} reports</span>
                            </td>
                            <td class="py-3 text-nowrap small text-muted">{{ $user->created_at->format('M d, Y') }}</td>
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
@endsection
