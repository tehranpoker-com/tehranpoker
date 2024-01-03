<div class="section-body">
    <div class="container">
        <div class="section-inner">
            <div class="section-title">
                <h2>{{has_option('faqs', 'page_title')}}</h2>
                <p>{{has_option('faqs', 'page_subtitle')}}</p>
                <div class="divider"></div>
            </div>
            <div class="mt-30 mb-30">
                @if(has_option('faqs', 'column') == '2column')
                <div class="accordion toggle-accordion row">
                    <div class="col-md-6 col-sm-12">
                        @foreach ($faqs1 as $item)
                        <div class="section-content">
                            <h4 class="accordion-title">
                                <a href="javascript:void(0);" class="btn-title">{{$item['post_title']}}<i class="pe-7s-angle-down"></i></a>
                            </h4>
                            <div class="accordion-inner">{!!$item['post_content']!!}</div>
                        </div>
                        @endforeach
                    </div>
                    <div class="col-md-6 col-sm-12">
                        @foreach ($faqs2 as $item)
                        <div class="section-content">
                            <h4 class="accordion-title">
                                <a href="javascript:void(0);" class="btn-title">{{$item['post_title']}}<i class="pe-7s-angle-down"></i></a>
                            </h4>
                            <div class="accordion-inner">{!!$item['post_content']!!}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="accordion toggle-accordion mt-30 mb-30">
                    @foreach ($faqs as $item)
                    <div class="section-content">
                        <h4 class="accordion-title">
                            <a href="javascript:void(0);" class="btn-title">{{$item['post_title']}}<i class="pe-7s-angle-down"></i></a>
                        </h4>
                        <div class="accordion-inner">{!!$item['post_content']!!}</div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>