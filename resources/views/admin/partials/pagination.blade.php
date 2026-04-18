<p class="small text-muted mb-0">Showing {{ $paginator->firstItem() ?? 0 }} to {{ $paginator->lastItem() ?? 0 }} of {{ number_format($paginator->total()) }}</p>
<nav>
    <ul class="pagination pagination-sm mb-0" style="gap: 2px;">
        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                <a class="page-link rounded-1 py-1 px-2" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach
    </ul>
</nav>