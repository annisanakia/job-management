@if ($paginator->hasPages())
    <ul class="pagination justify-content-center animated now slideUp d-3 mt-3" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <button type="button" class="page-link" aria-hidden="true">Prev</button>
            </li>
        @else
            <li class="page-item">
                <button type="button" class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">Prev</button>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><button type="button" class="page-link">{{ $element }}</button></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><button type="button" class="page-link" href="{{ $url }}">{{ $page }}</button></li>
                    @else
                        <li class="page-item"><button type="button" class="page-link" href="{{ $url }}">{{ $page }}</button></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <button type="button" class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Next</button>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <button type="button" class="page-link" aria-hidden="true">Next</button>
            </li>
        @endif
    </ul>
@endif