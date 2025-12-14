@if ($products->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($products->onFirstPage())
            <li class="disabled"><span>&laquo; Trước</span></li>
        @else
            <li><a href="{{ $products->previousPageUrl() }}">&laquo; Trước</a></li>
        @endif

        {{-- Pagination Elements --}}
        @php
            $currentPage = $products->currentPage();
            $lastPage = $products->lastPage();
            $startPage = max(1, $currentPage - 2);
            $endPage = min($lastPage, $currentPage + 2);
        @endphp

        @if ($startPage > 1)
            <li><a href="{{ $products->url(1) }}">1</a></li>
            @if ($startPage > 2)
                <li class="disabled"><span>...</span></li>
            @endif
        @endif

        @for ($page = $startPage; $page <= $endPage; $page++)
            @if ($page == $currentPage)
                <li class="active"><span>{{ $page }}</span></li>
            @else
                <li><a href="{{ $products->url($page) }}">{{ $page }}</a></li>
            @endif
        @endfor

        @if ($endPage < $lastPage)
            @if ($endPage < $lastPage - 1)
                <li class="disabled"><span>...</span></li>
            @endif
            <li><a href="{{ $products->url($lastPage) }}">{{ $lastPage }}</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($products->hasMorePages())
            <li><a href="{{ $products->nextPageUrl() }}">Sau &raquo;</a></li>
        @else
            <li class="disabled"><span>Sau &raquo;</span></li>
        @endif
    </ul>
@endif

