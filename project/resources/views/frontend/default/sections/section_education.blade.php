<div class="head-title">
    <h3>{{has_option('resume', 'education_title')}} <span>{{has_option('resume', 'education_subtitle')}}</span></h3>
</div>
<ul class="timeline-list mb-60">
    @foreach ($education as $item)
    <li>
        <span>{{get_date_from_to($item->post_id)}}</span>
        <div class="image">
            <img src="{{get_attachment_url($item->thumbnail, 'full')}}" />
        </div>
        <h5>{{$item->post_title}}</h5>
        <p>{{$item->post_excerpts}}</p>
    </li>
    @endforeach
</ul>