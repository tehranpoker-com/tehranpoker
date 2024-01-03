@extends(get_extends('layouts.master'))
@section('content')
<div class="container">
    <div class="section-pages clearfix">
        <div class="section-inner">
            <div class="section-title">
                <h3>{{$page_title}}</h3>
                <p>{{$page_subtitle}}</p>
                <div class="divider"></div>
            </div>
            @include(get_extends('plugins.breadcrumbs'))
            <div class="single-post clearfix">
                <div class="single-content">
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <div class="project-thumbnail portfolio-item">
                                <div class="portfolio-wrap">
                                    <img src="{{get_attachment_url($post_meta['thumbnails'], 'full')}}" class="img-fluid" alt="{{$single->post_title}}">
                                    <div class="portfolio-info">
                                        <div>
                                            @if($post_meta['portfolio_type'] == 'iframe')
                                            <a href="javascript:void(0)" data-type="{{$post_meta['portfolio_type']}}" data-src="{{$post_meta['iframe_url']}}" data-fancybox="single-gallery" class="link-preview"><i class="pe-7s-global"></i></a>
                                            @elseif($post_meta['portfolio_type'] == 'video')
                                            <a href="javascript:void(0)" data-src="{{$post_meta['video_url']}}" data-fancybox="single-gallery" data-caption="<h5 class='text-white'>{{$single->post_title}}</h5>{{$single->post_excerpts}}" class="link-preview"><i class="pe-7s-play"></i></a>
                                            @else
                                            <a href="javascript:void(0)" data-src="{{get_attachment_url($post_meta['thumbnails'], 'full')}}" data-fancybox="single-gallery" data-caption="<h5 class='text-white'>{{$single->post_title}}</h5>{{$single->post_excerpts}}" class="link-preview"><i class="pe-7s-expand1"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-details">
                                <ul>
                                    @foreach ($details as $item)
                                    <li><label><i class="{{$item['icon']}}"></i> {{$item['title']}}:</label> {{$item['text']}}</li>
                                    @endforeach
                                </ul>
                                @if(has_option('portfolio', 'sharelink_status'))
                                @include(get_extends('plugins.sharesocials'), ['sharelink' => $sharelink, 'title' => $single->post_title, 'link' => url()->current(), 'media' => get_attachment_url($post_meta['thumbnails'], 'full')])
                                @endif
                            </div>
                        </div>
                    </div>
                    @if(count($gallery))
                    <div class="portfolio-container portfolio-masonry portfolio-fix2 size-4 mb-30" data-layoutmode="masonry">
                        @each(get_each('foreach.each_portfolio_gallery'), $gallery, 'item')
                    </div>
                    @endif
                    @if($single->post_content)<div class="post-content">{!! $single->post_content !!}</div>@endif
                    @if($is_related)
                    <div class="related-post mt-20">
                        <div class="head-title">
                            <h5>{{has_option('portfolio', 'related_posts_title')}}</h5>
                        </div>
                        <div class="portfolio-container portfolio-fitRows portfolio-fix size-4 mb-30" data-layoutmode="fitRows">
                            @each(get_each('foreach.each_portfolio_related'), $related, 'item')
                        </div>
                    </div>
                    @endif
                </div>
                @include(get_extends('plugins.comments'), ['single' => $single])
            </div>
        </div>        
    </div>
</div>
@endsection