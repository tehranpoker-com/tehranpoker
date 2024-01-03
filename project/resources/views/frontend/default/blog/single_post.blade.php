@extends(get_extends('layouts.master'))
@section('content')
<div class="container">
    <div class="section-pages clearfix">
        <div class="section-inner">
            <div class="section-title">
                <h3>{{$page_title}}</h3>
                <ul class="post-meta">
                    @if(has_option('blog', 'post_meta_author'))<li><i class="pe-7s-user"></i> {{get_username($single->post_author)}}</li>@endif
                    @if(has_option('blog', 'post_meta_date'))<li><i class="pe-7s-date"></i> {{time_format($single->post_modified, 'date')}}</li>@endif
                    @if(has_option('blog', 'post_meta_cate'))<li><a href="{{url('blog/category/'.$term_slug)}}"><i class="pe-7s-notebook"></i> {{get_term_name($single->term_id)}}</a></li>@endif
                    @if(has_option('blog', 'post_meta_views'))<li><i class="pe-7s-look"></i> {{$single->post_views}}</li>@endif
                </ul>
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
                    <div class="single-post clearfix">
                        <div class="single-content">
                            <div class="post-thumbnail">
                                <img src="{{get_attachment_url($post_meta['thumbnails'], 'full')}}" alt="">
                            </div>
                            <div class="post-content">
                                {!! $single->post_content !!}
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    @if(has_option('blog', 'post_meta_tags'))
                                    <ul class="tags">
                                        @foreach ($post_tags as $item)
                                        <li><a href="{{url('blog?tag='.$item)}}">{{$item}}</a></li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    @if(has_option('portfolio', 'sharelink_status'))
                                    @include(get_extends('plugins.sharesocials'), ['sharelink' => $sharelink, 'title' => $single->post_title, 'link' => url()->current(), 'media' => get_attachment_url($post_meta['thumbnails'], 'full')])
                                    @endif
                                </div>
                            </div>
                            @if($is_related)
                            <div class="related-post mt-20">
                                <div class="head-title">
                                    <h5>{{has_option('blog', 'related_posts_title')}}</h5>
                                </div>
                                <div class="row">
                                    @foreach ($related as $item)
                                    <div class="{{has_option('blog', 'post_column')}} col-md-6 col-sm-12">
                                        <div class="post-grid">
                                            <div class="post-grid-image">
                                                <span class="post-date"><i class="pe-7s-date"></i> {{time_format($item->post_modified, 'date')}}</span>
                                                <span class="post-views"><i class="pe-7s-look"></i> {{$item->post_views}}</span>
                                                <img src="{{get_attachment_url($item->thumbnail, 'medium')}}" alt="">
                                                <div class="post-meta clearfix">
                                                    <ul class="float-left">
                                                        <li><i class="pe-7s-user"></i> {{get_username($item->post_author)}}</li>
                                                    </ul>
                                                    <ul class="float-right">
                                                        <li><a href="{{url('blog/category/'.get_term_slug($item->term_id))}}"><i class="pe-7s-ticket"></i> {{get_term_name($item->term_id)}}</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="post-detail">
                                                <h5><a href="{{url('post/'.$item->post_name)}}">{{$item->post_title}}</a></h5>
                                                <p>{{$item->post_excerpts}}</p>
                                                <a href="{{url('post/'.$item->post_name)}}" class="post-more">{{lang('read_more')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        @include(get_extends('plugins.comments'))
                    </div>
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
</div>
@endsection