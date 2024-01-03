@if(has_option('style', 'breadcrumbs') == 'style1')
<div id="titlebar">
    <div class="special-block-bg">
        <h2>{{$breadcrumbs_title}}</h2>
        <nav id="breadcrumbs">
            <ul>
                @foreach ($breadcrumbs as $item)
                @if($item['link'])
                <li><a href="{{$item['link']}}">@if(isset($item['icon'])) <i class="{{$item['icon']}}"></i> @endif {{$item['title']}}</a></li>
                @else
                <li>{{$item['title']}}</li>
                @endif
                @endforeach
            </ul>
        </nav>
    </div>
</div>
@else
<div class="section-title">
    <nav class="bread-crums">
        @foreach ($breadcrumbs as $item)
        @if($item['link'])
        <a href="{{$item['link']}}">@if(isset($item['icon'])) <i class="{{$item['icon']}}"></i> @endif {{$item['title']}}</a>
        <span class="bread-crums-span">»</span>
        @else
        <span class="current">{{$item['title']}}</span>
        @endif
        @endforeach
    </nav>
</div>
@endif