<div class="widget widget-list">
    <div class="widget-title">
        <i class="{{$widget['icon']}}"></i> {{$widget['title']}}
    </div>
    <ul>
        @foreach ($widget['data'] as $item)
        <li class="cat-item @if($term_id == $item->id) active @endif"><a href="{{url('blog/category/'.$item->slug)}}">{{$item->name}} <span class="count">{{(get_post_count('posts', $item->id))}}</span></a></li>
        @endforeach
    </ul>
</div>