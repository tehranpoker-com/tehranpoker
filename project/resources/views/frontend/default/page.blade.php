@extends(get_extends('layouts.master'))
@section('content')
<section class="section-page animated section-page-{{$single->id}} section-{{$page_style}} active">
    <div class="section-body">
        <div class="container">
            <div class="section-pages clearfix">
                <div class="section-inner">
                    <div class="section-title">
                        <h3>{{$page_title}}</h3>
                        <p>{{$page_subtitle}}</p>
                        <div class="divider"></div>
                    </div>
                </div>
                <div class="page-content mb-30">
                    {!! $single->post_content !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection