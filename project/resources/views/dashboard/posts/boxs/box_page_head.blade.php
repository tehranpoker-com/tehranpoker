<div class="page-title-box d-flex align-items-center justify-content-between">
    <h4 class="mb-0 font-size-18">{{ $page_title }}</h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ get_admin_url('/') }}">{{ admin_lang('dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ get_admin_url('posts/'.$type) }}">{{ $page_title }}</a></li>
            <li class="breadcrumb-item active">@if($action == 'update'){{admin_lang('edit')}}@else{{admin_lang('add_new')}}@endif</li>
        </ol>
    </div>
</div>