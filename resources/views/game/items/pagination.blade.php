@php
    $current = $paginator->currentPage();
    $last = $paginator->lastPage();

    // hiển thị 5 trang
    $start = max(1, $current - 2);
    $end = min($last, $start + 4);
@endphp

@if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
    

        {{-- Page numbers --}}
        @for ($i = $start; $i <= $end; $i++)
            @if ($i == $current)
            <li class="page-item disabled" style="margin-left: 5px;">
                <span class="page-link"><span>{{ $i }}</span>
            </li>
            @else
            <li class="page-item" style="margin-left: 5px;">
                <a class="page-link" href="{{ url('/c/'.$slug.'/'.($i)) }}">{{ $i }}</a>
            </li>
            @endif
        @endfor


    </ul>
    </nav>
@endif
