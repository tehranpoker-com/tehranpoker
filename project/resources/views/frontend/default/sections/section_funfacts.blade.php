<div class="counters mb-30">
    <div class="row">
        <div class="col-lg-12">
            <div class="head-title">
                <h3>{{has_option('aboutme', 'funfacts_title')}} <span>{{has_option('aboutme', 'funfacts_subtitle')}}</span></h3>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($funfacts as $item)
        <div class="{{has_option('aboutme', 'funfacts_column')}} col-md-6 col-xs-12">
            <div class="counter-block">
                <div class="icon"><i class="{{get_post_meta('icon', $item->post_id)}}"></i></div>
                <div class="details-info">
                    <h5>{{$item->post_title}}</h5>
                    <span class="counter-value" data-count="{{get_post_meta('counter', $item->post_id)}}">0</span>
                </div>
                <span class="counter-block-mask"></span>
            </div>
        </div>
        @endforeach
    </div>
</div>