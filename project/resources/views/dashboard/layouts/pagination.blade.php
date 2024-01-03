
<div class="row-pagination" dir="ltr">
    <div class="row">
        <div class="col-md-8">
            @if ($paginator->hasPages())
            <ul class="pagination2">
                @if (!$paginator->onFirstPage()) 
                    <li class="boxpaged frist-page"><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="bx bx-first-page"></i></a></li>
                @endif
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="disabled"><span><i class="bx bx-dots-horizontal-rounded"></i></span></li>
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
                @if ($paginator->hasMorePages())
                    <li class="boxpaged last-page"><a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="bx bx-last-page"></i></a></li>
                @endif
            </ul>
            @endif
        </div>
        <div class="col-md-4 currentpage align-right">
            <div>{{admin_lang('total_items', ['total' => $paginator->total()])}}</div>
        </div>
    </div>
</div>