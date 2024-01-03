<div class="working-way mb-30">
    <div class="row">
        <div class="col-lg-12">
            <div class="head-title">
                <h3>{{has_option('aboutme', 'workingway_title')}} <span>{{has_option('aboutme', 'workingway_subtitle')}}</span></h3>
            </div>
            <p class="text-center"></p>
        </div>
    </div>
    <div class="row mt-30">
        @foreach ($workingway as $item)
        <div class="{{has_option('aboutme', 'workingway_column')}} col-md-6">
            <div class="item">
                <div class="icon">
                    <img src="{{get_attachment_url($item->thumbnail)}}" alt="{{$item->post_title}}" />
                </div>
                <div class="cont-step">
                    <h4>{{get_post_meta('step', $item->post_id)}}</h4>
                    <h5>{{$item->post_title}}</h5>
                    <p>{{$item->post_excerpts}}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>