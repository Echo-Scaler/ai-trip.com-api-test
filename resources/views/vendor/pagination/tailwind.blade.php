@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between w-full">

    <div class="flex gap-2 items-center justify-between sm:hidden w-full">
        @if ($paginator->onFirstPage())
        <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white/5 border border-white/10 cursor-not-allowed rounded-xl hover:bg-white/5 transition-colors">
            <i data-lucide="chevron-left" class="w-4 h-4 mr-2"></i> {!! __('pagination.previous') !!}
        </span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-white/10 border border-white/20 rounded-xl hover:bg-primary-600/20 hover:text-primary-400 hover:border-primary-500/30 transition-colors">
            <i data-lucide="chevron-left" class="w-4 h-4 mr-2"></i> {!! __('pagination.previous') !!}
        </a>
        @endif

        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-white/10 border border-white/20 rounded-xl hover:bg-primary-600/20 hover:text-primary-400 hover:border-primary-500/30 transition-colors">
            {!! __('pagination.next') !!} <i data-lucide="chevron-right" class="w-4 h-4 ml-2"></i>
        </a>
        @else
        <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white/5 border border-white/10 cursor-not-allowed rounded-xl">
            {!! __('pagination.next') !!} <i data-lucide="chevron-right" class="w-4 h-4 ml-2"></i>
        </span>
        @endif
    </div>

    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-400">
                {!! __('Showing') !!}
                @if ($paginator->firstItem())
                <span class="font-medium text-white">{{ $paginator->firstItem() }}</span>
                {!! __('to') !!}
                <span class="font-medium text-white">{{ $paginator->lastItem() }}</span>
                @else
                {{ $paginator->count() }}
                @endif
                {!! __('of') !!}
                <span class="font-medium text-white">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>

        <div>
            <span class="inline-flex gap-2 rounded-md shadow-sm">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <span class="flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-600 bg-white/5 border border-white/10 cursor-not-allowed rounded-xl" aria-hidden="true">
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    </span>
                </span>
                @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-300 bg-white/5 border border-white/10 rounded-xl hover:bg-primary-600/20 hover:text-primary-400 hover:border-primary-500/30 transition-all" aria-label="{{ __('pagination.previous') }}">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                <span aria-disabled="true">
                    <span class="flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-500 bg-transparent cursor-default">{{ $element }}</span>
                </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <span aria-current="page">
                    <span class="flex items-center justify-center w-10 h-10 text-sm font-bold text-primary-400 bg-primary-600/20 border border-primary-500/30 rounded-xl cursor-default">{{ $page }}</span>
                </span>
                @else
                <a href="{{ $url }}" class="flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-300 bg-white/5 border border-white/10 rounded-xl hover:bg-primary-600/20 hover:text-primary-400 hover:border-primary-500/30 transition-all" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                    {{ $page }}
                </a>
                @endif
                @endforeach
                @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-300 bg-white/5 border border-white/10 rounded-xl hover:bg-primary-600/20 hover:text-primary-400 hover:border-primary-500/30 transition-all" aria-label="{{ __('pagination.next') }}">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
                @else
                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    <span class="flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-600 bg-white/5 border border-white/10 cursor-not-allowed rounded-xl" aria-hidden="true">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </span>
                </span>
                @endif
            </span>
        </div>
    </div>
</nav>
@endif