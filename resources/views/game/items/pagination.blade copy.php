@php
    $current = $paginator->currentPage();
    $last = $paginator->lastPage();

    // hiển thị 5 trang
    $start = max(1, $current - 2);
    $end = min($last, $start + 4);
@endphp

@if ($paginator->hasPages())
    <div class="pagination dark">

        {{-- Previous --}}
        @if ($current > 1)
            <a class="live-link" href="{{ url('/c/'.$slug.'/'.($current - 1)) }}">
                <span class="arr l1"></span>
            </a>
        @else
            <span class="dead-link"><span><span class="arr l1"></span></span></span>
        @endif

        {{-- Page numbers --}}
        @for ($i = $start; $i <= $end; $i++)
            @if ($i == $current)
                <span class="live-link current-link"><span>{{ $i }}</span></span>
            @else
                <a class="live-link" href="{{ url('/c/'.$slug.'/'.($i)) }}">{{ $i }}</a>
            @endif
        @endfor

        {{-- Next --}}
        @if ($current < $last)
            <a class="live-link" href="{{ url('/c/'.$slug.'/'.($current + 1)) }}">
                <span class="arr r1"></span>
            </a>
        @else
            <span class="dead-link"><span><span class="arr r1"></span></span></span>
        @endif

    </div>
@endif
