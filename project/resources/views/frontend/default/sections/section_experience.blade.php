<div class="head-title">
    <h3>{{has_option('resume', 'experience_title')}} <span>{{has_option('resume', 'experience_subtitle')}}</span></h3>
</div>
<ul class="timeline-list mb-60">
    @foreach ($experience as $item)
    <li>
        <span>{{get_date_from_to($item->post_id)}}</span>
        <div class="image">
            <img src="{{get_attachment_url($item->thumbnail, 'full')}}" />
        </div>
        <h5><strong>{{get_post_meta('position', $item->post_id)}}</strong> - {{$item->post_title}}</h5>
        <p>{{$item->post_excerpts}}</p>
    </li>
    @endforeach
</ul>