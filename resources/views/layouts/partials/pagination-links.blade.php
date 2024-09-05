@if ($paginator->hasPages())

<ul class="pagination pagination-sm justify-content-center mb-0">

    {{-- Previous Page Links --}}
    @if ($paginator->onFirstPage())
        <li class="page-item disabled">
            <a class="page-link" tabindex="-1">
            <i class="fas fa-angle-left"></i>
            <span class="sr-only">Previous</span>
            </a>
        </li>
    @else
        <li class="page-item disabled">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" tabindex="-1">
            <i class="fas fa-angle-left"></i>
            <span class="sr-only">Previous</span>
            </a>
        </li>
    @endif

    <?php
        $start = $paginator->currentPage() - 2; // show 3 pagination links before current
        $end = $paginator->currentPage() + 2; // show 3 pagination links after current
        if($start < 1) {
            $start = 1; // reset start to 1
            $end += 1;
        } 
        if($end >= $paginator->lastPage() ) $end = $paginator->lastPage(); // reset end to last page
    ?>
    

    {{-- Pagination Elements --}}
    {{-- @foreach ($elements as $element)

        @if (is_array($element))
            @foreach ($element as $page=>$url )

                @if ($page == $paginator->currentPage())
                    <li class="page-item active">
                        <a class="page-link">{{ $page }}</a>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif
                
            @endforeach
        @endif

    @endforeach --}}

    @if($start > 1)
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->url(1) }}">{{1}}</a>
        </li>
        @if($paginator->currentPage() != 4)
            {{-- "Three Dots" Separator --}}
            <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
        @endif
    @endif
        @for ($i = $start; $i <= $end; $i++)
            <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                <a class="page-link" href="{{ $paginator->url($i) }}">{{$i}}</a>
            </li>
        @endfor
    @if($end < $paginator->lastPage())
        @if($paginator->currentPage() + 3 != $paginator->lastPage())
            {{-- "Three Dots" Separator --}}
            <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
        @endif
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{$paginator->lastPage()}}</a>
        </li>
    @endif


    {{-- Next Page Links --}}
    @if ($paginator->hasMorePages())
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                <i class="fas fa-angle-right"></i>
                <span class="sr-only">Next</span>
            </a>
        </li>        
    @else
        <li class="page-item disabled">
            <a class="page-link">
                <i class="fas fa-angle-right"></i>
                <span class="sr-only">Next</span>
            </a>
        </li>   
    @endif

</ul>
    
@endif