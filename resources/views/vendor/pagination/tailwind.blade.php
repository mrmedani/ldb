@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        
        <div class="flex flex-col sm:flex-row gap-4 items-center justify-between w-full">

            {{-- Info Text (Desktop only) --}}
            <div class="hidden sm:block text-sm text-gray-500 font-medium">
                @if ($paginator->firstItem())
                    <span class="font-bold text-gray-800">{{ $paginator->firstItem() }}</span>
                    &ndash;
                    <span class="font-bold text-gray-800">{{ $paginator->lastItem() }}</span>
                    sur
                    <span class="font-bold text-gray-800">{{ $paginator->total() }}</span>
                    résultats
                @endif
            </div>

            {{-- Pagination Buttons --}}
            <div class="flex flex-wrap items-center justify-center gap-1">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="inline-flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl text-gray-400 bg-gray-50 border border-border cursor-not-allowed">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl text-gray-600 bg-white border border-border hover:bg-orange-50 hover:text-primary hover:border-orange-200 transition-all duration-200 shadow-sm active:scale-95">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </a>
                @endif

                {{-- Pagination Elements (responsive: fewer on mobile) --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="inline-flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 text-gray-400 font-bold text-sm">...</span>
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @php
                                $showOnMobile = $page == $paginator->currentPage()
                                    || abs($page - $paginator->currentPage()) <= 1
                                    || $page == 1
                                    || $page == $paginator->lastPage();
                            @endphp
                            @if ($page == $paginator->currentPage())
                                <span class="inline-flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-gradient-to-br from-orange-500 to-orange-400 text-white font-bold text-sm shadow-md shadow-orange-500/30 cursor-default">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="inline-flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl text-gray-600 bg-white border border-border font-semibold text-sm hover:bg-orange-50 hover:text-primary hover:border-orange-200 transition-all duration-200 shadow-sm active:scale-95 {{ $showOnMobile ? '' : 'hidden sm:inline-flex' }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl text-gray-600 bg-white border border-border hover:bg-orange-50 hover:text-primary hover:border-orange-200 transition-all duration-200 shadow-sm active:scale-95">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                @else
                    <span class="inline-flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl text-gray-400 bg-gray-50 border border-border cursor-not-allowed">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </span>
                @endif
            </div>
            
        </div>
    </nav>
@endif
