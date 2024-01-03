<div class="services mb-30">
    <div class="row">
        <div class="col-lg-12">
            <div class="head-title">
                <h3>{{has_option('aboutme', 'services_title')}} <span>{{has_option('aboutme', 'services_subtitle')}}</span></h3>                
            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($services as $item)
        <div class="{{has_option('aboutme', 'services_column')}} col-md-6 col-sm-12">
            <div class="services-item">
                <div class="icon"><img src="{{get_attachment_url($item->thumbnail)}}" alt="{{$item->post_title}}" /></div>
                <h5>{{$item->post_title}}</h5>
                <p>{{$item->post_excerpts}}</p>
            </div>
        </div>
        @endforeach
        
    </div>
</div>