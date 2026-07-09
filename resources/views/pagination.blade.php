@if ($paginator->hasPages())
<div class="d-flex justify-content-between">
    <div>
        <small>Ver del {{$paginator->firstItem()}} al {{ $paginator->lastItem() }}, <b>Total {{ $paginator->total()}}</b></small>
        {{-- count: {{ $paginator->count() }} <br> --}}
    </div>
    <div>
        <nav role="navigation" class="pagination-wrapper d-flex align-items-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="disabled pagination-prev">
                    <i class="bx bx-chevron-left"></i>
                </span>
            @else
                <a href="{{ $paginator->url(1) }}"> <i class="bx bx-chevrons-left"></i></a>
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-prev">
                    <i class="bx bx-chevron-left"></i>
                </a>
            @endif

            {{-- Pagination Elements --}}
            <ul class="pagination-pages d-flex align-items-center">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="dots"><span>{{ $element }}</span></li>
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="active"><span>{{ $page }}</span></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </ul>
            
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-next">
                    <i class="bx bx-chevron-right"></i>
                </a>
                <a href="{{ $paginator->url($paginator->lastPage()) }}"> <i class="bx bx-chevrons-right"></i></a>
            @else
                <span class="disabled pagination-next">
                    <i class="bx bx-chevron-right"></i>
                </span>
            @endif
        </nav>
    </div>
@endif