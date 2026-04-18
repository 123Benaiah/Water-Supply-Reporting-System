@extends('layouts.app')

@section('title', 'My Reports - ZAWASU')

@section('content')
<div class="mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between bg-white p-4 rounded-3 shadow border">
        <div>
            <h1 class="fs-2 fw-bold text-ocean-900">My Reports</h1>
            <p class="text-muted mt-1">Track and manage your submitted water supply reports</p>
        </div>
        <a href="{{ route('reports.create') }}" class="mt-3 mt-md-0 btn btn-ocean d-inline-flex align-items-center px-4 py-2 shadow">
            <svg class="me-2" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Submit New Report
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-md-4">
        <div class="bg-white p-4 rounded-3 shadow border position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 bg-ocean-50 rounded-circle opacity-50" style="width: 80px; height: 80px; margin-right: -40px; margin-top: -40px;"></div>
            <p class="small fw-bold text-muted text-uppercase mb-2">Total Reports</p>
            <p class="fs-1 fw-bold text-ocean-900">{{ $reports->total() }}</p>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="bg-white p-4 rounded-3 shadow border border-warning position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 bg-warning-subtle rounded-circle opacity-50" style="width: 80px; height: 80px; margin-right: -40px; margin-top: -40px;"></div>
            <p class="small fw-bold text-muted text-uppercase mb-2">Pending</p>
            <p class="fs-1 fw-bold text-warning">{{ $reports->where('status', 'Pending')->count() }}</p>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="bg-white p-4 rounded-3 shadow border border-success position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 bg-success-subtle rounded-circle opacity-50" style="width: 80px; height: 80px; margin-right: -40px; margin-top: -40px;"></div>
            <p class="small fw-bold text-muted text-uppercase mb-2">Resolved</p>
            <p class="fs-1 fw-bold text-success">{{ $reports->where('status', 'Resolved')->count() }}</p>
        </div>
    </div>
</div>

@if($reports->isEmpty())
    <div class="bg-white rounded-3 shadow border p-5 text-center">
        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
            <svg width="40" height="40" class="text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <h3 class="fs-5 fw-bold text-ocean-900 mb-2">No Reports Yet</h3>
        <p class="text-muted mb-3">You haven't submitted any water supply reports. Help us improve the system by reporting issues.</p>
        <a href="{{ route('reports.create') }}" class="btn btn-ocean">
            Start Your First Report
        </a>
    </div>
@else
    <div class="bg-white rounded-3 shadow border overflow-hidden">
        <div class="px-4 py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h2 class="fs-5 fw-bold text-ocean-900">Recent Reports</h2>
            <div class="d-flex align-items-center gap-3">
                <div class="position-relative">
                    <input type="text" id="searchInput" placeholder="Search reports..." 
                        class="form-control form-control-sm" style="width: 200px; padding-left: 2rem;">
                    <svg width="16" height="16" class="text-muted position-absolute" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="left: 0.5rem; top: 50%; transform: translateY(-50%);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <form method="GET" action="{{ route('dashboard') }}" class="d-flex align-items-center gap-2">
                    <label class="small fw-semibold text-muted">Show:</label>
                    <select name="per_page" onchange="this.form.submit()"
                        class="form-select form-select-sm" style="width: auto;">
                        @foreach([2, 3, 4, 5, 10, 15, 20, 50] as $perPage)
                            <option value="{{ $perPage }}" {{ $reports->perPage() == $perPage ? 'selected' : '' }}>{{ $perPage }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 text-start small fw-bold text-muted text-uppercase">Image</th>
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
                                <div class="fw-semibold text-ocean-900 text-truncate" style="max-width: 200px;">{{ $report->title }}</div>
                                <div class="small text-muted text-truncate" style="max-width: 200px;">{{ $report->location }}</div>
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
                                <a href="{{ route('reports.show', $report) }}" class="btn btn-ocean btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-top bg-light d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            {{ $reports->appends(['per_page' => $reports->perPage()])->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endif

<script>
document.getElementById('searchInput')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endsection
