@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center">
        <ul class="pagination flex space-x-2 list-none">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item " aria-disabled="true" aria-label="@lang('pagination.previous')">
                   <span class="page-link px-4 py-2 bg-gray-300 text-gray-500 rounded" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-link px-4 py-2 bg-primary text-white rounded hover:bg-primaryDark" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link px-4 py-2  bg-primary text-white rounded">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a href="{{ $url }}" class="page-link px-4 py-2  bg-primary text-white rounded hover:bg-primaryDark">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-link px-4 py-2  bg-primary text-white rounded hover:bg-primaryDark" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link px-4 py-2 bg-gray-300 text-gray-500 rounded" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
