@if ($paginator->hasPages())
    <nav class="custom-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="btn-paginate disabled">&laquo; Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn-paginate">&laquo; Prev</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="btn-paginate disabled">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="btn-paginate active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="btn-paginate">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn-paginate">Next &raquo;</a>
        @else
            <span class="btn-paginate disabled">Next &raquo;</span>
        @endif
    </nav>
@endif
