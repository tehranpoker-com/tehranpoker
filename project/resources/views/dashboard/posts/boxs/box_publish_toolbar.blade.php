<div class="post-fixed-toolbar">
    <ul>
        <li>
            <div class="d-inline" title="{{admin_lang('status')}}">
                <input type="checkbox" name="post_status" value="1" class="custom-control-input" switch="bool" id="post_status_switch" @if($post_status) checked @endif>
                <label for="post_status_switch" data-on-label="ON" data-off-label="OFF"></label>
            </div>
        </li>
        <li class="right-toolbar">
            @if($action == 'update')
            <button type="button" onclick="location.href='{{get_admin_url('duplicate/'.$post_id)}}';" class="btn btn-warning waves-effect waves-light">{{admin_lang('duplicate')}}</button>
            <button type="button" onclick="location.href='{{get_admin_url('postnew/'.$type)}}';" class="btn btn-dark waves-effect waves-light">{{admin_lang('add_new')}}</button>
            @endif
            <button type="submit" class="btn btn-primary waves-effect waves-light">@if($action == 'update') {{admin_lang('update')}} @else {{admin_lang('publish')}} @endif</button>
        </li>
    </ul>
</div>
@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>{!! session()->get('success') !!}</div>
@endif