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
                    @each(get_each('foreach.each_blog'), $posts, 'item')
                </div>
                {{$posts->links(get_extends('plugins.pagination'))}}
            </div>
        </div>
    </section>
</div>
@endsection