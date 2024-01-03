<div class="section-body">
    <div class="@if(in_array(has_option('portfolio', 'template'), ['fix', 'fix2'])) container @else p-2 @endif ">
        <div class="section-inner">
            @if(has_option('portfolio', 'sectiontitle'))
            <div class="section-title">
                <h2>{{has_option('portfolio', 'page_title')}}</h2>
                <p>{{has_option('portfolio', 'page_subtitle')}}</p>
                <div class="divider"></div>
            </div>
            @endif
            <ul id="portfolio-flters">
                <li data-filter="*" class="filter-active filter-click">All</li>
                @foreach ($portfolio['terms'] as $item)
                <li data-filter=".filter-cat{{$item->id}}">{{$item->name}}</li>
                @endforeach
            </ul>
            <div class="portfolio-container portfolio-{{has_option('portfolio', 'layoutmode')}} portfolio-{{has_option('portfolio', 'template')}} {{has_option('portfolio', 'column', 'size-4')}} mb-30" data-layoutmode="{{has_option('portfolio', 'layoutmode', 'masonry')}}">
                @each(get_each('foreach.each_portfolio'), $portfolio['posts'], 'item')
            </div>

            @if(has_option('portfolio', 'loadmore'))
            <div class="row mb-20 text-center">
                <div class="col-md-12">
                    <a href="javascript:void(0)" class="button portfolio-loadmore" data-loading="{{lang('loading')}}" data-paged="1"><span>{{lang('load_more')}}</span></a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>