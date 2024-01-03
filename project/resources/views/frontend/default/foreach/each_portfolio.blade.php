<div class="portfolio-item fadeIn filter-cat{{$item->term_id}}">
    <div class="portfolio-wrap">
        <img src="{{get_attachment_url($item->thumbnail, has_option('portfolio', 'imagesize', 'full'))}}" class="img-fluid" alt="{{$item->post_title}}">
        <span class="portfolio-icon">
            @if($item->portfolio_type == 'iframe')
            <i class="bx bx-link"></i>
            @elseif($item->portfolio_type == 'video')
            <i class="bx bxs-videos"></i>
            @elseif($item->portfolio_type == 'gallery')
            <i class="bx bx-photo-album"></i>
            @else
            <i class="bx bx-image"></i>
            @endif
        </span>
        <span class="portfolio-cate">{{get_term_name($item->term_id)}}</span>
        <div class="portfolio-info">
            <h6><a href="{{url('portfolio/'.$item->post_name)}}">{{$item->post_title}}</a></h6>
            <div>
                @if($item->portfolio_type == 'iframe')
                <a href="javascript:void(0)" data-type="{{$item->portfolio_type}}" data-src="{{$item->iframe_url}}" data-fancybox="portfolio-gallery" class="link-preview"><i class="pe-7s-global"></i></a>
                @elseif($item->portfolio_type == 'video')
                <a href="javascript:void(0)" data-src="{{$item->video_url}}" data-fancybox="portfolio-gallery" data-caption="<h5 class='text-white'>{{$item->post_title}}</h5>{{$item->post_excerpts}}" class="link-preview"><i class="pe-7s-play"></i></a>
                @else
                <a href="javascript:void(0)" data-src="{{get_attachment_url($item->thumbnail, 'full')}}" data-fancybox="portfolio-gallery" data-caption="<h5 class='text-white'>{{$item->post_title}}</h5>{{$item->post_excerpts}}" class="link-preview"><i class="pe-7s-expand1"></i></a>
                @endif
                <a href="{{url('portfolio/'.$item->post_name)}}" class="link-details" title="{{lang('more_details')}}"><i class="pe-7s-link"></i></a>
            </div>
        </div>
    </div>
</div>