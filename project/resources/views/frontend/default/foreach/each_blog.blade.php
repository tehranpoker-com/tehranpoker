<div class="{{has_option('blog', 'post_column')}} col-md-6 col-sm-12">
    <div class="post-grid">
        <div class="post-grid-image">
            <span class="post-date"><i class="pe-7s-date"></i> {{time_format($item->post_modified, 'date')}}</span>
            @if($item->post_pin)<span class="post-format-icon"><i class="pe-7s-pin"></i></span>@else<span class="post-views"><i class="pe-7s-look"></i> {{$item->post_views}}</span>@endif
            <img src="{{get_attachment_url($item->thumbnail, 'medium')}}" alt="">
            <div class="post-meta clearfix">
                <ul class="float-left">
                    <li><i class="pe-7s-user"></i> {{get_username($item->post_author)}}</li>
                </ul>
                <ul class="float-right">
                    @if($item->post_pin)<li><i class="pe-7s-look"></i> {{$item->post_views}}</li>@endif
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