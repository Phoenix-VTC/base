@if ($paginator->hasPages())
    <nav class="border-t border-orange-600 px-4 flex items-center justify-between sm:px-0">
        <div class="-mt-px w-0 flex-1 flex">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="border-t-2 border-transparent pt-4 pl-1 inline-flex items-center text-sm font-medium text-gray-400 cursor-default"
                    aria-label="@lang('pagination.previous')">
                    <!-- Heroicon name: solid/arrow-narrow-left -->
                    <svg class="mr-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                         fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                              clip-rule="evenodd"/>
                    </svg>
                    Previous
                </li>
            @else
                <a class="border-t-2 border-transparent pt-4 pl-1 inline-flex items-center text-sm font-medium text-orange-600 hover:text-orange-500 hover:border-orange-500"
                   href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                    <!-- Heroicon name: solid/arrow-narrow-left -->
                    <svg class="mr-3 h-5 w-5 text-orange-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                         fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                              clip-rule="evenodd"/>
                    </svg>
                    Previous
                </a>
            @endif
        </div>
        <div class="hidden md:-mt-px md:flex">
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array of Links --}}
                @foreach ($element as $page => $url)
                    {{-- Use three dots when current page is greater than 4. --}}
                    @if ($page === 2 && $paginator->currentPage() > 4)
                        <span
                            class="border-transparent text-gray-300 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium">
                            ...
                        </span>
                    @endif

                    {{-- Show active page, else show the first and last two pages from current page. --}}
                    @if ($page === $paginator->currentPage())
                        <li class="border-red-500 text-orange-600 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium cursor-default"
                            aria-current="page">
                            {{ $page }}
                        </li>
                    @elseif ($page === $paginator->currentPage() + 1 || $page === $paginator->currentPage() + 2 || $page === $paginator->currentPage() - 1 || $page === $paginator->currentPage() - 2 || $page === $paginator->lastPage() || $page === 1)
                        <a href="{{ $url }}"
                           class="border-transparent text-gray-300 hover:text-orange-600 hover:border-red-500 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium">
                            {{ $page }}
                        </a>
                    @endif

                    {{-- Use three dots when current page is away from the end. --}}
                    @if ($page === $paginator->lastPage() - 1 && $paginator->currentPage() < $paginator->lastPage() - 3)
                        <span
                            class="border-transparent text-gray-300 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium">
                            ...
                        </span>
                    @endif
                @endforeach
            @endforeach
        </div>
        <div class="-mt-px w-0 flex-1 flex justify-end">
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="border-t-2 border-transparent pt-4 pl-1 inline-flex items-center text-sm font-medium text-orange-600 hover:text-orange-500 hover:border-orange-500"
                   href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('pagination.next') }}">
                    Next
                    <!-- Heroicon name: solid/arrow-narrow-right -->
                    <svg class="ml-3 h-5 w-5 text-orange-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                         fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                              clip-rule="evenodd"/>
                    </svg>
                </a>
            @else
                <li class="border-t-2 border-transparent pt-4 pl-1 inline-flex items-center text-sm font-medium text-gray-400 cursor-default"
                    aria-label="{{ __('pagination.next') }}">
                    Next
                    <!-- Heroicon name: solid/arrow-narrow-right -->
                    <svg class="ml-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                         fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                              clip-rule="evenodd"/>
                    </svg>
                </li>
            @endif
        </div>
    </nav>
@endif
