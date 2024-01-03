<div class="clients mb-30">
    <div class="row">
        <div class="col-lg-12">
            <div class="head-title">
                <h3>{{has_option('aboutme', 'clients_title')}} <span>{{has_option('aboutme', 'clients_subtitle')}}</span></h3>
            </div>
        </div>
    </div>
    @if(has_option('aboutme', 'clients_style') == 'normal')
    <div class="row g-0 clients-wrap">
        @foreach ($clients as $item)
        <div class="{{has_option('aboutme', 'clients_column')}} col-md-4 col-xs-6">
            <a href="{{get_post_meta('url', $item->post_id)}}" target="_blank">
            <div class="client-logo">
                <img src="{{get_attachment_url($item->thumbnail, 'full')}}" class="img-fluid" alt="{{$item->post_title}}">
            </div>
            </a>
        </div>
        @endforeach
    </div>
    @else
    <div class="row">
        <div class="col-md-12">
            <div class="owl-carousel owl-client" data-direction="{{get_option('direction', 'ltr')}}" data-responsive='{"0":{"items": "1"}, "580":{"items": "{{has_option('aboutme', 'clients_owlresphone')}}"}, "1024":{"items": "{{has_option('aboutme', 'clients_owlrestablet')}}"}, "1200":{"items": "{{has_option('aboutme', 'clients_owlrespc')}}"}}'>
                @foreach ($clients as $item)
                <div class="item">
                    <div class="client">
                        <a href="{{get_post_meta('url', $item->post_id)}}" target="_blank">
                            <img src="{{get_attachment_url($item->thumbnail, 'full')}}" class="img-responsive" alt="{{$item->post_title}}">
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>