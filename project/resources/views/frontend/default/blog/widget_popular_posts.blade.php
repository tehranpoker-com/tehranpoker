<div class="widget widget-recent-post">
    <div class="widget-title">
        <i class="{{$widget['icon']}}"></i> {{$widget['title']}}
    </div>
    <ul>
        @foreach ($widget['data'] as $item)
        <li>
            <a href="{{url('post/'.$item->post_name)}}" title="{{$item->post_title}}" class="thumb">
                <img src="{{get_attachment_url($item->thumbnail, 'thumbnail')}}" alt="">
            </a>
            <div class="recent-post-widget-content">
                <h5><a href="{{url('post/'.$item->post_name)}}">{{$item->post_title}}</a></h5>
                <p class="recent-post-date">{{time_format($item->post_modified, 'date')}}</p>
            </div>
        </li>
        @endforeach
    </ul>
</div>