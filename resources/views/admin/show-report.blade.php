@extends('layouts.app')

@section('title', 'Manage Report - ZAWASU')

@section('styles')
<style>
.tracking-timeline { position: relative; padding-left: 30px; }
.tracking-timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #ffc107, #0dcaf0, #198754);
}
.tracking-step {
    position: relative;
    padding: 15px 0;
    padding-left: 20px;
}
.tracking-step::before {
    content: '';
    position: absolute;
    left: -25px;
    top: 20px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #fff;
    border: 3px solid currentColor;
}
.tracking-step.active::before { background: currentColor; }
.tracking-pending { color: #ffc107; }
.tracking-progress { color: #0dcaf0; }
.tracking-resolved { color: #198754; }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <div>
            <h1 class="fs-2 fw-bold text-ocean-900">Report Management</h1>
            <p class="text-muted">Review and update water supply report #{{ $report->id }}</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary d-flex align-items-center">
            <svg width="20" height="20" class="me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Dashboard
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-lg mb-4">
                <div class="card-body p-4">
                    <h2 class="fs-4 fw-bold text-ocean-900 mb-2">{{ $report->title }}</h2>
                    <p class="text-muted mb-4">Submitted by <span class="text-ocean-600 fw-medium">{{ $report->user->name }}</span> on {{ $report->created_at->format('M d, Y') }}</p>

                    @if($report->images && count($report->images) > 0)
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                                @foreach($report->images as $index => $image)
                                    <button class="btn btn-outline-secondary d-flex align-items-center gap-2 p-1" onclick="openFullImage('{{ asset('storage/' . $image) }}')">
                                        <img src="{{ asset('storage/' . $image) }}" alt="Image {{ $index + 1 }}" class="rounded" style="width: 60px; height: 40px; object-fit: cover;">
                                        <span class="small">Img {{ $index + 1 }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="ratio ratio-16x9 bg-light border rounded-3 d-flex align-items-center justify-content-center text-muted mb-4">
                            <div class="text-center">
                                <svg width="64" height="64" class="mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="fw-medium">No images uploaded</p>
                            </div>
                        </div>
                    @endif

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded-3 border">
                                <p class="small text-muted mb-1 text-uppercase fw-bold">Issue Type</p>
                                <p class="text-ocean-900 fw-bold mb-0">{{ $report->issue_type }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded-3 border">
                                <p class="small text-muted mb-1 text-uppercase fw-bold">Location</p>
                                <p class="text-ocean-900 fw-bold mb-0">{{ $report->location }}</p>
                            </div>
                        </div>
                        @if($report->latitude && $report->longitude)
                        <div class="col-12">
                            <div class="bg-light p-3 rounded-3 border">
                                <p class="small text-muted mb-1 text-uppercase fw-bold">Coordinates</p>
                                <p class="text-ocean-900 font-monospace small mb-0">{{ $report->latitude }}, {{ $report->longitude }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div>
                        <p class="small text-muted mb-2 text-uppercase fw-bold">Description</p>
                        <div class="text-muted">{{ $report->description }}</div>
                    </div>
                </div>
            </div>

            <!-- Location & Directions -->
            @if($report->latitude && $report->longitude)
            <div class="card shadow-lg mb-4 border-0">
                <div class="card-header bg-ocean-600 text-white d-flex align-items-center justify-content-between">
                    <h3 class="fs-5 fw-bold mb-0 d-flex align-items-center">
                        <svg width="20" height="20" class="me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Location & Directions
                    </h3>
                    <span class="badge bg-white text-ocean-600">{{ $report->status }}</span>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="rounded-3 bg-ocean-100 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                            <svg width="24" height="24" class="text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold text-ocean-900 mb-1">{{ $report->location }}</h5>
                            <p class="small text-muted font-monospace mb-0">{{ $report->latitude }}, {{ $report->longitude }}</p>
                        </div>
                    </div>
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $report->latitude }},{{ $report->longitude }}"
                       target="_blank" class="btn btn-ocean w-100 d-flex align-items-center justify-content-center gap-2">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.806-.984A1 1 0 0020.25 6.75L15 9m0 13V9"/>
                        </svg>
                        Open in Google Maps
                    </a>
                </div>
            </div>
            @endif

            <!-- Tracking Progress Timeline -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-light">
                    <h3 class="fs-5 fw-bold text-ocean-900 mb-0 d-flex align-items-center">
                        <svg width="20" height="20" class="me-2 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        Fix Progress Tracker
                    </h3>
                </div>
                <div class="card-body">
                    <div class="tracking-timeline">
                        <div class="tracking-step {{ $report->status == 'Pending' || $report->status == 'In Progress' || $report->status == 'Resolved' ? 'active tracking-pending' : '' }}">
                            <h5 class="fw-bold mb-1">Report Submitted</h5>
                            <p class="small text-muted mb-0">{{ $report->created_at->format('M d, Y h:i A') }}</p>
                            <p class="small mb-0">Issue reported at {{ $report->location }}</p>
                        </div>
                        <div class="tracking-step {{ $report->status == 'In Progress' || $report->status == 'Resolved' ? 'active tracking-progress' : '' }}">
                            <h5 class="fw-bold mb-1">In Progress</h5>
                            @if($report->updates->where('status', 'In Progress')->first())
                                <p class="small text-muted mb-0">{{ $report->updates->where('status', 'In Progress')->first()->created_at->format('M d, Y h:i A') }}</p>
                                <p class="small mb-0">Team dispatched to location</p>
                            @else
                                <p class="small text-muted mb-0">Waiting for dispatch...</p>
                            @endif
                        </div>
                        <div class="tracking-step {{ $report->status == 'Resolved' ? 'active tracking-resolved' : '' }}">
                            <h5 class="fw-bold mb-1">Resolved</h5>
                            @if($report->updates->where('status', 'Resolved')->first())
                                <p class="small text-muted mb-0">{{ $report->updates->where('status', 'Resolved')->first()->created_at->format('M d, Y h:i A') }}</p>
                                <p class="small mb-0">Issue fixed and verified</p>
                            @else
                                <p class="small text-muted mb-0">Pending resolution...</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Response History -->
            @if($report->updates && $report->updates->count() > 0)
                <h3 class="fs-5 fw-bold text-ocean-900 mb-3 d-flex align-items-center">
                    <svg width="20" height="20" class="me-2 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Response History
                </h3>
                @foreach($report->updates as $update)
                    <div class="card shadow border-ocean-100 mb-3 position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 bg-ocean-50 rounded-circle opacity-50" style="width: 100px; height: 100px; margin-right: -50px; margin-top: -50px;"></div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start gap-3">
                                <div class="rounded-3 bg-ocean-600 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                                    <svg width="24" height="24" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.040L3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622l-.382-3.016z"/>
                                    </svg>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div>
                                            <p class="small fw-bold text-ocean-900 mb-0">{{ $update->admin->name }}</p>
                                            <p class="small text-muted mb-0">Administrator • {{ $update->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <span class="badge bg-ocean-50 text-ocean-700">{{ $update->status }}</span>
                                    </div>
                                    <div class="text-muted">{{ $update->comment }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Sidebar Actions -->
        <div class="col-lg-4">
            <div class="card shadow-lg mb-4">
                <div class="card-body p-4">
                    <h3 class="fs-5 fw-bold text-ocean-900 mb-4 d-flex align-items-center">
                        <svg width="20" height="20" class="me-2 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        Update Status
                    </h3>
                    <form action="{{ route('admin.reports.update', $report) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Current Status</label>
                            <select name="status" required class="form-select">
                                <option value="Pending" {{ $report->status == 'Pending' ? 'selected' : '' }}>Pending Review</option>
                                <option value="In Progress" {{ $report->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Resolved" {{ $report->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Admin Comment</label>
                            <textarea name="comment" rows="4" required class="form-control" placeholder="Provide details about the action taken..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-ocean w-100">Update Report</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-lg mb-4">
                <div class="card-body p-4">
                    <h3 class="fs-5 fw-bold text-ocean-900 mb-4 d-flex align-items-center">
                        <svg width="20" height="20" class="me-2 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Reporter Info
                    </h3>
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rounded-3 bg-ocean-600 d-flex align-items-center justify-content-center text-white fw-bold fs-5" style="width: 48px; height: 48px; background: linear-gradient(135deg, #0ea5e9, #0369a1);">
                            {{ strtoupper(substr($report->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="small fw-bold text-ocean-900 mb-0">{{ $report->user->name }}</p>
                            <p class="small text-muted mb-0">Joined {{ $report->user->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                    <div class="vstack gap-2 pt-3 border-top">
                        <div class="d-flex align-items-center small">
                            <svg width="16" height="16" class="me-2 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <p class="small fw-medium mb-0">{{ $report->user->email }}</p>
                        </div>
                        <div class="d-flex align-items-center small">
                            <svg width="16" height="16" class="me-2 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="small fw-medium mb-0">Joined: {{ $report->user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-3 bg-danger-subtle rounded-3 border border-danger">
                <form action="{{ route('admin.reports.destroy', $report) }}" method="POST" onsubmit="return confirm('Are you sure? This will permanently delete this report.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <svg width="20" height="20" class="me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete Report
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Full Image Modal -->
<div class="modal fade" id="fullImageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-header border-0">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 text-center">
                <img id="fullImage" src="" class="img-fluid" alt="Full size image">
            </div>
        </div>
    </div>
</div>

<style>
.view-mode-btn.active { background-color: var(--ocean-600); color: white; border-color: var(--ocean-600); }
#imageGallery.list-view .image-item { width: 100%; }
#imageGallery.list-view .card { flex-direction: row; }
#imageGallery.list-view .card-img-top { width: 200px; height: 120px; }
#imageGallery.tile-view .col-4 { width: 100%; }
#imageGallery.tile-view .card { flex-direction: row; }
#imageGallery.tile-view .card-img-top { width: 300px; height: 180px; }
</style>
<script>
function setViewMode(mode) {
    const gallery = document.getElementById('imageGallery');
    gallery.className = 'row g-3 ' + (mode === 'list' ? 'list-view' : mode === 'tile' ? 'tile-view' : '');
    document.querySelectorAll('.view-mode-btn').forEach(btn => btn.classList.remove('active'));
    event.target.closest('.view-mode-btn').classList.add('active');
}
function openFullImage(src) { document.getElementById('fullImage').src = src; new bootstrap.Modal(document.getElementById('fullImageModal')).show(); }
</script>
@endsection
