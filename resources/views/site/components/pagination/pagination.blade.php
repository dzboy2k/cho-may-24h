@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination flex-wrap pagination-sm">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled mx-1">
                    <span class="page-link shadow-none rounded text-primary border-primary btn-txt" aria-hidden="true">
                        <i class="fa-light fa-arrow-left"></i>
                    </span>
                </li>
            @else
                <li class="page-item mx-1">
                    <a class="page-link shadow-none rounded bg-transparent text-primary border-primary btn-txt"
                        href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="fa-light fa-arrow-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $numPages = $paginator->lastPage();
                $currentPage = $paginator->currentPage();
                $showPages = 3; // Maximum number of pages displayed
                $half = floor($showPages / 2);
                $start = max(1, $currentPage - $half);
                $end = min($numPages, $currentPage + $half);
            @endphp

            @if ($start > 1)
                <li class="page-item disabled mx-1">
                    <span class="page-link shadow-none rounded bg-transparent text-primary border-primary btn-txt">...</span>
                </li>
            @endif

            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $currentPage)
                    <li class="page-item active z-0 mx-1">
                        <span class="page-link shadow-none rounded bg-primary text-white border-primary btn-txt">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item mb-3 mx-1">
                        <a class="page-link shadow-none rounded bg-transparent text-primary border-primary btn-txt"
                            href="{{ $paginator->url($page) }}">{{ $page }}</a>
                    </li>
                @endif
            @endfor

            @if ($end < $numPages)
                <li class="page-item disabled mx-1">
                    <span class="page-link shadow-none rounded bg-transparent text-primary border-primary btn-txt">...</span>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item mx-1">
                    <a class="page-link shadow-none rounded bg-transparent text-primary border-primary btn-txt"
                        href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <i class="fa-light fa-arrow-right"></i></a>
                </li>
            @else
                <li class="page-item disabled mx-1">
                    <span class="page-link shadow-none rounded bg-transparent text-primary border-primary btn-txt"
                        aria-hidden="true">
                        <i class="fa-light fa-arrow-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif
