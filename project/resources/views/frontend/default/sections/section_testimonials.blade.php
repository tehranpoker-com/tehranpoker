<div class="testimonials mb-30">
    <div class="row">
        <div class="col-lg-12">
            <div class="head-title">
                <h3>{{has_option('aboutme', 'testimonials_title')}} <span>{{has_option('aboutme', 'testimonials_subtitle')}}</span></h3>
            </div>
        </div>
    </div>
    <div class="row">
        @if(has_option('aboutme', 'testimonials_style') == 'normal')
        @foreach ($testimonials as $item)
        <div class="{{has_option('aboutme', 'testimonials_column')}} col-md-6 col-sm-12">
            <div class="testimonial-item">
                <div class="testimonial-content">{{$item->post_content}}</div>
                <div class="testimonial-footer">
                    <div class="testimonial-avatar">
                        <img src="{{get_attachment_url($item->thumbnail)}}" alt="{{$item->post_title}}">
                    </div>
                    <div class="testimonial-owner">
                        <h6>{{$item->post_title}}</h6>
                        <span>{{get_post_meta('position', $item->post_id)}}</span>
                        <div class="testimonial-rating rating-{{get_post_meta('rating', $item->post_id)}}"></div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="col-md-12">
            <div class="owl-carousel owl-testimonial" data-direction="{{get_option('direction', 'ltr')}}" data-responsive='{"0":{"items": "1"}, "580":{"items": "{{has_option('aboutme', 'testimonials_owlresphone')}}"}, "1024":{"items": "{{has_option('aboutme', 'testimonials_owlrestablet')}}"}, "1200":{"items": "{{has_option('aboutme', 'testimonials_owlrespc')}}"}}'>
                @foreach ($testimonials as $item)
                <div class="item">
                    <div class="testimonial-item">
                        <div class="testimonial-content">{{$item->post_content}}</div>
                        <div class="testimonial-footer">
                            <div class="testimonial-avatar">
                                <img src="{{get_attachment_url($item->thumbnail)}}" alt="{{$item->post_title}}">
                            </div>
                            <div class="testimonial-owner">
                                <h6>{{$item->post_title}}</h6>
                                <span>{{get_post_meta('position', $item->post_id)}}</span>
                                <div class="testimonial-rating rating-{{get_post_meta('rating', $item->post_id)}}"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>