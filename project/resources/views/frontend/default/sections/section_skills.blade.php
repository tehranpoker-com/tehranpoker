<div class="row">
    @foreach ($term_skills as $item)
    <div class="{{get_term_meta('column', $item->id)}} col-md-12">
        <div class="head-title">
            <h3>{{$item->name}}</h3>
        </div>
        <div class="skills {{get_term_meta('style', $item->id)}} mb-60">
            @foreach (get_posts_skills($item->id) as $skill)
            <div class="skill-item">
                <h6>{{$skill->post_title}} <span>{{get_post_meta('subtitle', $skill->id)}}</span></h6>
                <div class="skill skill-animate">
                    <div class="progres" data-value="{{get_post_meta('counter', $skill->id, '0')}}%"></div>
                </div>
                <span class="counter">{{get_post_meta('counter', $skill->id, '0')}}%</span>
            </div>  
            @endforeach
        </div>
    </div>
    @endforeach
</div>