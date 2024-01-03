<div class="widget">
    <div class="widget-title">
        <i class="{{$widget['icon']}}"></i> {{$widget['title']}}
    </div>
    <ul class="tags mb-0">
        @foreach ($widget['data'] as $key => $count)
        <li><a href="{{url('blog?tag='.$key)}}">{{$key}} ({{$count}})</a></li>
        @endforeach
    </ul>
</div>