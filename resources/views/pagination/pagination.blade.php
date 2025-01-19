<div class="d-flex justify-content-center">
    @if ($dataToPaginate['current_page'] > 1)
        <a href="{{ $dataToPaginate['path'] . '?page=1' . '&' . http_build_query(request()->except('page')) }}" class="btn btn-primary me-2">
            <i class="bi bi-chevron-double-left"></i> First
        </a>
    @else
        <button class="btn btn-secondary me-2" disabled>
            <i class="bi bi-chevron-double-left"></i> First
        </button>
    @endif

    @if ($dataToPaginate['prev_page_url'])
        <a href="{{ $dataToPaginate['prev_page_url'] . '&' . http_build_query(request()->except('page')) }}" class="btn btn-primary me-2">
            <i class="bi bi-chevron-left"></i> Previous
        </a>
    @else
        <button class="btn btn-secondary me-2" disabled>
            <i class="bi bi-chevron-left"></i> Previous
        </button>
    @endif

    @if ($dataToPaginate['has_more_pages'])
        <a href="{{ $dataToPaginate['next_page_url'] . '&' . http_build_query(request()->except('page')) }}" class="btn btn-primary me-2">
            Next <i class="bi bi-chevron-right"></i>
        </a>
    @else
        <button class="btn btn-secondary me-2" disabled>
            Next <i class="bi bi-chevron-right"></i>
        </button>
    @endif

    @if ($dataToPaginate['has_more_pages'])
        <a href="{{ $dataToPaginate['path'] . '?page=' . ceil($dataToPaginate['total'] / $dataToPaginate['per_page']) . '&' . http_build_query(request()->except('page')) }}"
           class="btn btn-primary">
            Last <i class="bi bi-chevron-double-right"></i>
        </a>
    @else
        <button class="btn btn-secondary" disabled>
            Last <i class="bi bi-chevron-double-right"></i>
        </button>
    @endif
</div>
