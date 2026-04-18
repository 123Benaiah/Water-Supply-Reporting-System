<tbody>
    @forelse($reports as $report)
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
    @empty
        <tr>
            <td colspan="5" class="text-center py-4 text-muted">No reports found</td>
        </tr>
    @endforelse
</tbody>