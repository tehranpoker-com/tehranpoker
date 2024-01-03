<div class="section-body">
    @if(has_option('homepage', 'style') == 'bgvideo')<div id="bgndVideo" data-property="{videoURL:'{{has_option('homepage', 'bgvideo')}}',containment:'.section-home',autoPlay:true, mute:true, startAt:0, opacity:1, loop:true, showControls:false}"></div>@endif
    @if(has_option('homepage', 'particles'))<div id="particles-js"></div>@endif
    <div class="container">
        <div class="intro display-table">
            <div class="display-table-cell">
                @if(has_option('homepage', 'title'))<h3>{{has_option('homepage', 'title')}}</h3>@endif
                @if(has_option('homepage', 'subtitle'))<h1>{{has_option('homepage', 'subtitle')}}</h1>@endif
                @if(has_option('homepage', 'description'))<p>{{has_option('homepage', 'description')}}</p>@endif
                <div class="type-wrap">
                    @if(has_option('homepage', 'typedtitle'))<span class="type-title">{{has_option('homepage', 'typedtitle')}}</span>@endif
                    @if(has_option('homepage', 'typed') and count(has_option('homepage', 'typed')))
                    <div class="typed-strings">
                        @foreach (has_option('homepage', 'typed') as $item)
                        <span>{{$item['title']}}</span>
                        @endforeach
                    </div>
                    <span class="typed"></span>
                    @endif
                </div>
                @if(has_option('homepage', 'buttonsstatus'))
                <div class="buttons">
                @foreach (has_option('homepage', 'buttons') as $key => $item)
                    @if(isset($item['status']) and $item['status'])
                    @if(has_option('style', 'template') == 'onepage')
                    <a href="{{url('/#'.get_class_section($item['widget']))}}" data-has="#{{get_class_section($item['widget'])}}" class="@if($item['widget'] == $page_class) active @endif button"><span><i class="{{$item['icon']}}"></i> {{$item['title']}}</span></a>
                    @else
                    <a href="{{url(get_class_section($item['widget'], true))}}" data-has="#{{get_class_section($item['widget'])}}" class="@if(get_class_section($item['widget']) == $page_class) active @endif button"><span><i class="{{$item['icon']}}"></i> {{$item['title']}}</span></a>
                    @endif
                    @endif
                @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>