@if ($paginator->hasPages() || $paginator->total() > 0)

    <div class="custom-pagination-wrapper">

        {{-- Left: "Showing X to Y of Z results" --}}
        <div class="pagination-info">
            Showing
            <span class="pagination-info-highlight">{{ $paginator->firstItem() ?? 0 }}</span>
            to
            <span class="pagination-info-highlight">{{ $paginator->lastItem() ?? 0 }}</span>
            of
            <span class="pagination-info-highlight">{{ $paginator->total() }}</span>
            results
        </div>

        {{-- Right: Page links --}}
        @if ($paginator->hasPages())

            <ul class="pagination-links">

                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())

                    <li class="page-item disabled">
                        <span class="page-link" aria-label="Previous">
                            <span class="pagination-arrow">&lsaquo;</span>
                        </span>
                    </li>

                @else

                    <li class="page-item">
                        <a class="page-link"
                           href="{{ $paginator->previousPageUrl() }}"
                           rel="prev"
                           aria-label="Previous">
                            <span class="pagination-arrow">&lsaquo;</span>
                        </a>
                    </li>

                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)

                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))

                        <li class="page-item disabled">
                            <span class="page-link">{{ $element }}</span>
                        </li>

                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))

                        @foreach ($element as $page => $url)

                            @if ($page == $paginator->currentPage())

                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>

                            @else

                                <li class="page-item">
                                    <a class="page-link"
                                       href="{{ $url }}">
                                        {{ $page }}
                                    </a>
                                </li>

                            @endif

                        @endforeach

                    @endif

                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())

                    <li class="page-item">
                        <a class="page-link"
                           href="{{ $paginator->nextPageUrl() }}"
                           rel="next"
                           aria-label="Next">
                            <span class="pagination-arrow">&rsaquo;</span>
                        </a>
                    </li>

                @else

                    <li class="page-item disabled">
                        <span class="page-link" aria-label="Next">
                            <span class="pagination-arrow">&rsaquo;</span>
                        </span>
                    </li>

                @endif

            </ul>

        @endif

    </div>

@endif
