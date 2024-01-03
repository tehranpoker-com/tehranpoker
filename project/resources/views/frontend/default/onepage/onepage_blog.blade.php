<div class="section-body">
    <div class="container">
        <div class="section-inner">
            <div class="section-title">
                <h2>{{has_option('blog', 'page_title')}}</h2>
                <p>{{has_option('blog', 'page_subtitle')}}</p>
                <div class="divider"></div>
            </div>
            <div class="row merged mb-50">
                <div class="col-lg-5 col-md-12 col-xs-12">
                    @if($blog['posts_pin'])
                    <div class="featured-post">
                        <div class="featured-image">
                            <span class="post-date"><i class="pe-7s-date"></i> {{time_format($blog['posts_pin']->post_modified, 'date')}}</span>
                            @if($blog['posts_pin']->post_pin)<span class="post-format-icon"><i class="pe-7s-pin"></i></span>@else<span class="post-views"><i class="pe-7s-look"></i> {{$blog['posts_pin']->post_views}}</span>@endif
                            <img src="{{get_attachment_url($blog['posts_pin']->thumbnail, 'medium_large')}}" alt="">
                        </div>
                        <div class="featured-meta">
                            <h5><a href="{{url('post/'.$blog['posts_pin']->post_name)}}">{{$blog['posts_pin']->post_title}}</a></h5>
                            <ul class="post-meta clearfix">
                                <li><i class="pe-7s-user"></i> {{get_username($blog['posts_pin']->post_author)}}</li>
                                @if($blog['posts_pin']->post_pin)<li><i class="pe-7s-look"></i> {{$blog['posts_pin']->post_views}}</li>@endif
                                <li><a href="{{url('blog/category/'.get_term_slug($blog['posts_pin']->term_id))}}"><i class="pe-7s-ticket"></i> {{get_term_name($blog['posts_pin']->term_id)}}</a></li>
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-lg-7 col-md-12 col-xs-12">
                    <div class="row">
                        @foreach ($blog['posts_featured'] as $item)
                        <div class="col-lg-6 col-md-6">
                            <div class="featured-post">
                                <div class="featured-image">
                                    <span class="post-date"><i class="pe-7s-date"></i> {{time_format($item->post_modified, 'date')}}</span>
                                    <span class="post-views"><i class="pe-7s-look"></i> {{$item->post_views}}</span>
                                    <img src="{{get_attachment_url($item->thumbnail, 'medium')}}" alt="">
                                </div>
                                <div class="featured-meta small">
                                    <h5><a href="{{url('post/'.$item->post_name)}}">{{$item->post_title}}</a></h5>
                                    <ul class="post-meta clearfix">
                                        <li><i class="pe-7s-user"></i> {{get_username($item->post_author)}}</li>
                                        <li><a href="{{url('blog/category/'.get_term_slug($item->term_id))}}"><i class="pe-7s-ticket"></i> {{get_term_name($item->term_id)}}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- blog featured -->
            <!-- blog grid -->
            <div class="row">
                @each(get_each('foreach.each_blog'), $blog['posts'], 'item')
            </div>
            <div class="row mb-20 text-center">
                <div class="col-md-12">
                    <a href="{{url('blog')}}" class="button"><span>{{lang('browse_all_articles')}}</span></a>
                </div>
            </div>
        </div>
    </div>
</div>