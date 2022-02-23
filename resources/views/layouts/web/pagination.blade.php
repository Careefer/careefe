@if ($paginator->hasPages())
    <nav>
        <ul class="pagination-wrapper inner-pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="prev-btn page-btn" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <a href="javascript:void(0);" aria-hidden="true">&lsaquo;</a>
                </li>
            @else
                <li class="prev-btn page-btn">
                    <a  href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li aria-disabled="true"><a>{{ $element }}</a></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li  aria-current="page" class="active">
                                <a href="javascript:void(0);">{{ $page }}</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="next-btn page-btn">
                    <a  href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="next-btn page-btn" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <a href="javascript:void(0);" aria-hidden="true">&lsaquo;</a>
                </li>
            @endif
        </ul>
    </nav>
@endif
