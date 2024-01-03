@extends(get_extends('layouts.master'))
@section('content')
<div class="section-pages">
    <section id="blog">
        <div class="container">
            <div class="section-inner">
                <div class="section-title">
                    <h3>{{$page_title}}</h3>
                    <p>{{$page_subtitle}}</p>
                    <div class="divider"></div>
                </div>
                @include(get_extends('plugins.breadcrumbs')) 
                <div class="row">
                    @if($widgets_status == 'left')
                    <div class="{{$widgets_column}}">
                        @foreach ($widgets as $widget)
                        @include(get_extends('blog.widget_'.$widget['id']))
                        @endforeach
                    </div>
                    @endif
                    <div class="{{$posts_column}}">
                        <div class="row">
                            @each(get_each('foreach.each_blog'), $posts, 'item')
                        </div>
                        {{$posts->links(get_extends('plugins.pagination'))}}
                    </div>
                    @if($widgets_status == 'right')
                    <div class="{{$widgets_column}}">
                        @foreach ($widgets as $widget)
                        @include(get_extends('blog.widget_'.$widget['id']))
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection