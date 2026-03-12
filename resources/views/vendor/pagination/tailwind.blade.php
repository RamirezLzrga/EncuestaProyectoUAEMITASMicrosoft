@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" style="display:flex; align-items:center; justify-content:space-between; gap:14px;">
        <div style="font-size:12px; color:var(--text-muted); font-family:'JetBrains Mono',monospace;">
            {{ __('Showing') }}
            @if ($paginator->firstItem())
                <span style="font-weight:800; color:var(--text-dark);">{{ $paginator->firstItem() }}</span>
                {{ __('to') }}
                <span style="font-weight:800; color:var(--text-dark);">{{ $paginator->lastItem() }}</span>
            @else
                <span style="font-weight:800; color:var(--text-dark);">{{ $paginator->count() }}</span>
            @endif
            {{ __('of') }}
            <span style="font-weight:800; color:var(--text-dark);">{{ $paginator->total() }}</span>
            {{ __('results') }}
        </div>

        <div style="display:inline-flex; align-items:center; background:var(--bg-dark); border-radius:12px; overflow:hidden; box-shadow:var(--neu-in-sm);">
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}" style="width:42px; height:38px; display:grid; place-items:center; color:var(--text-light); cursor:default;">
                    <i class="fas fa-chevron-left" style="font-size:12px;"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('pagination.previous') }}" style="width:42px; height:38px; display:grid; place-items:center; color:var(--uaemex); text-decoration:none;">
                    <i class="fas fa-chevron-left" style="font-size:12px;"></i>
                </a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span aria-disabled="true" style="width:40px; height:38px; display:grid; place-items:center; color:var(--text-muted); font-weight:800; font-size:12px; font-family:'JetBrains Mono',monospace;">
                        {{ $element }}
                    </span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" style="width:40px; height:38px; display:grid; place-items:center; background:var(--verde-pale); color:var(--uaemex); font-weight:900; font-size:12px; font-family:'JetBrains Mono',monospace;">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}" style="width:40px; height:38px; display:grid; place-items:center; color:var(--uaemex); text-decoration:none; font-weight:800; font-size:12px; font-family:'JetBrains Mono',monospace;">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('pagination.next') }}" style="width:42px; height:38px; display:grid; place-items:center; color:var(--uaemex); text-decoration:none;">
                    <i class="fas fa-chevron-right" style="font-size:12px;"></i>
                </a>
            @else
                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}" style="width:42px; height:38px; display:grid; place-items:center; color:var(--text-light); cursor:default;">
                    <i class="fas fa-chevron-right" style="font-size:12px;"></i>
                </span>
            @endif
        </div>
    </nav>
@endif
