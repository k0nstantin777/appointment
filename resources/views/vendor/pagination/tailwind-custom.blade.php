<nav aria-label="Table navigation">
    <ul class="inline-flex items-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li aria-disabled="true" aria-label="@lang('pagination.previous')">
                <div class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple" aria-hidden="true">
                    <svg
                        class="w-4 h-4 fill-current"
                        aria-hidden="true"
                        viewBox="0 0 20 20"
                    >
                    <path
                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                        clip-rule="evenodd"
                        fill-rule="evenodd"
                    ></path>
                  </svg>
                </div>
            </li>
        @else
            <li>
                <a class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple" href="{{ $paginator->previousPageUrl() }}"
                   rel="prev" aria-label="@lang('pagination.previous')">
                    <svg
                        class="w-4 h-4 fill-current"
                        aria-hidden="true"
                        viewBox="0 0 20 20"
                    >
                        <path
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd"
                            fill-rule="evenodd"
                        ></path>
                    </svg>
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li aria-disabled="true">
                    <span class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">{{ $element }}</span>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li aria-current="page">
                            <span class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">
                                {{ $page }}
                            </span>
                        </li>
                    @else
                        <li>
                            <a class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple" href="{{ $url }}">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple" href="{{ $paginator->nextPageUrl() }}"
                   rel="next" aria-label="@lang('pagination.next')">
                    <svg
                        class="w-4 h-4 fill-current"
                        aria-hidden="true"
                        viewBox="0 0 20 20"
                    >
                        <path
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"
                            fill-rule="evenodd"
                        ></path>
                    </svg>
                </a>
            </li>
        @else
            <li aria-disabled="true" aria-label="@lang('pagination.next')">
                <div class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple" aria-hidden="true">
                    <svg
                        class="w-4 h-4 fill-current"
                        aria-hidden="true"
                        viewBox="0 0 20 20"
                    >
                        <path
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"
                            fill-rule="evenodd"
                        ></path>
                    </svg>
                </div>
            </li>
        @endif
    </ul>
</nav>
