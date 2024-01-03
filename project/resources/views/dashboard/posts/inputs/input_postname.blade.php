@if($type_slug)
<div class="form-group" dir="ltr">
    <div class="input-group mr-4">
        @if($action == 'update')
        <span class="input-group-text" id="postname-addon">
            <a href="{{ url($type_slug.'/'.$post->post_name) }}" target="_blank"><i class="bx bx-link-alt mt-1 font-size-18"></i></a>
        </span>
        @endif
        <span class="input-group-text" id="postname-addon">{{ url($type_slug) }}/</span>
        <input type="text" name="post_name" value="@if(isset($post)){{ $post->post_name }}@endif" class="form-control"  aria-describedby="postname-addon" />
    </div>
</div>
@endif