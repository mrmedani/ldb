@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        
        {{-- Mobile & Desktop unified view using Flex-wrap --}}
        <div class="flex flex-col sm:flex-row gap-4 items-center justify-between w-full">
            
            {{-- Mobile Text Info --}}
            <div class="block sm:hidden text-sm text-gray-500 font-medium w-full text-center">
                Page {{ $paginator->currentPage() }} sur {{ $paginator->lastPage() }}
            </div>

            {{-- Desktop Text Info --}}
            <div class="hidden sm:block text-sm text-gray-500 font-medium">
                {!! __('Affichage de') !!}
                @if ($paginator->firstItem())
                    <span class="font-bold text-gray-800">{{ $paginator->firstItem() }}</span>
                    {!! __('à') !!}
                    <span class="font-bold text-gray-800">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                {!! __('sur') !!}
                <span class="font-bold text-gray-800">{{ $paginator->total() }}</span>
                {!! __('résultats') !!}
            </div>

            {{-- Pagination Buttons --}}
            <div class="flex flex-wrap items-center justify-center gap-1.5 w-full sm:w-auto">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-gray-400 bg-gray-50 border border-border cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-gray-700 bg-white border border-border hover:bg-orange-50 hover:text-primary hover:border-orange-200 transition-all duration-200 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </a>
                @endif

                {{-- Pagination Elements (Desktop only) --}}
                <div class="hidden sm:flex items-center gap-1.5">
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span class="inline-flex items-center justify-center w-10 h-10 text-gray-400 font-bold">
                                {{ $element }}
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-orange-500 to-orange-400 text-white font-bold shadow-md shadow-orange-500/30 cursor-default">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-gray-600 bg-white border border-border font-semibold hover:bg-orange-50 hover:text-primary hover:border-orange-200 transition-all duration-200 shadow-sm">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-gray-700 bg-white border border-border hover:bg-orange-50 hover:text-primary hover:border-orange-200 transition-all duration-200 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                @else
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-gray-400 bg-gray-50 border border-border cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </span>
                @endif
            </div>
            
        </div>
    </nav>
@endif
