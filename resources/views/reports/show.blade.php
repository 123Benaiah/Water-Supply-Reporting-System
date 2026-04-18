@extends('layouts.app')

@section('title', 'Report Details - ZAWASU')

@section('content')
<div style="max-width: 900px;" class="mx-auto">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="d-inline-flex align-items-center text-ocean-600 text-decoration-none fw-semibold">
            <svg width="20" height="20" class="me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Dashboard
        </a>
        <div class="d-flex align-items-center gap-2">
            @if($report->status == 'Pending')
                <span class="badge bg-warning text-dark rounded-pill fs-6 px-3 py-2">Pending Review</span>
            @elseif($report->status == 'In Progress')
                <span class="badge bg-info text-dark rounded-pill fs-6 px-3 py-2">In Progress</span>
            @else
                <span class="badge bg-success rounded-pill fs-6 px-3 py-2">Resolved</span>
            @endif
        </div>
    </div>

    <div class="card shadow-lg border overflow-hidden mb-4">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
                <h1 class="fs-3 fw-bold text-ocean-900">{{ $report->title }}</h1>
                <p class="text-muted mt-2 mt-md-0 fw-medium">Submitted on {{ $report->created_at->format('M d, Y') }}</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    @if($report->images && count($report->images) > 0)
                        <div class="mb-3">
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
                        <div class="ratio ratio-16x9 bg-light border rounded-3 d-flex align-items-center justify-content-center text-muted">
                            <div class="text-center">
                                <svg width="64" height="64" class="mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="fw-medium">No images uploaded</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <h2 class="fs-4 fw-bold text-ocean-900 mb-3">{{ $report->title }}</h2>
                    
                    <div class="vstack gap-3">
                        <div class="bg-light p-3 rounded-3 border">
                            <p class="small text-muted mb-1 text-uppercase fw-bold">Issue Type</p>
                            <p class="text-ocean-900 fw-bold mb-0">{{ $report->issue_type }}</p>
                        </div>
                        <div class="bg-light p-3 rounded-3 border">
                            <p class="small text-muted mb-1 text-uppercase fw-bold">Location</p>
                            <p class="text-ocean-900 fw-bold mb-0">{{ $report->location }}</p>
                        </div>
                        @if($report->latitude && $report->longitude)
                        <div class="bg-light p-3 rounded-3 border">
                            <p class="small text-muted mb-1 text-uppercase fw-bold">Coordinates</p>
                            <p class="text-ocean-900 font-monospace small mb-0">{{ $report->latitude }}, {{ $report->longitude }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="mt-3">
                        <p class="small text-muted mb-2 text-uppercase fw-bold">Description</p>
                        <div class="text-muted">
                            {{ $report->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($report->updates && $report->updates->count() > 0)
        <div class="mb-4">
            <h3 class="fs-5 fw-bold text-ocean-900 mb-3 d-flex align-items-center">
                <svg width="20" height="20" class="me-2 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Official Response
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
                                <div class="text-muted">
                                    {{ $update->comment }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="card shadow-lg border">
        <div class="card-body p-4 p-md-5">
            <h3 class="fs-5 fw-bold text-ocean-900 mb-3">Report Timeline</h3>
            <div class="position-relative ps-4">
                <div class="position-absolute start-0 top-0 bottom-0 bg-light" style="width: 2px; left: 15px;"></div>
                <div class="vstack gap-4">
                    <!-- Initial Submission -->
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-ocean-600 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; z-index: 10;">
                            <svg width="16" height="16" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </div>
                        <div>
                            <p class="small fw-bold text-ocean-900 mb-0">Report Submitted</p>
                            <p class="small text-muted mb-0">{{ $report->created_at->format('M d, Y \a\t H:i') }}</p>
                        </div>
                    </div>

                    <!-- Updates -->
                    @foreach($report->updates as $update)
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-circle bg-ocean-500 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; z-index: 10;">
                                <svg width="16" height="16" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </div>
                            <div>
                                <p class="small fw-bold text-ocean-900 mb-0">{{ $update->status }}</p>
                                <p class="small text-muted mb-0">{{ $update->created_at->format('M d, Y \a\t H:i') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
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
