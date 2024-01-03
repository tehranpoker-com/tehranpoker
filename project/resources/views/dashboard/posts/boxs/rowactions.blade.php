<div class="row-actions">
    <a href="{{ get_admin_url('edit'.$url_prefix.'/'.$post->id) }}">{{admin_lang('edit')}}</a> |
    @if($post->post_status)
    <a href="{{ get_admin_url('disable'.$url_prefix.'/'.$post->id) }}" class="green">{{admin_lang('disable')}}</a> |
    @else
    <a href="{{ get_admin_url('enable'.$url_prefix.'/'.$post->id) }}" class="red">{{admin_lang('enable')}}</a> | 
    @endif
    @if(in_array($type, ['posts']))<a target="_blank" href="{{ url('post/'.$post->post_name) }}">{{admin_lang('view')}}</a> | @endif
    @if(in_array($type, ['pages']))<a target="_blank" href="{{ url('page/'.$post->post_name) }}">{{admin_lang('view')}}</a> | @endif
    @if(in_array($type, ['portfolio']))<a target="_blank" href="{{ url('portfolio/'.$post->post_name) }}">{{admin_lang('view')}}</a> | @endif
    <a href="{{ get_admin_url('duplicate/'.$post->id) }}" class="warning">{{admin_lang('duplicate')}}</a> | 
    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-href="{{ get_admin_url('deletepost/'.$post->id.'/'.csrf_token() ) }}" data-body="{{ admin_lang('delete_confirm') }} # {{ $post->post_title }}?" class="red">{{ admin_lang('delete') }}</a>
</div>