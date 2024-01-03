@extends('dashboard.layouts.master')
@section('content')
<div class="page-title-box d-flex align-items-center justify-content-between">
    <h4 class="mb-0 font-size-18">{{ $page_title }}</h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ get_admin_url('/') }}">{{ admin_lang('dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ get_admin_url('media') }}">{{ admin_lang('media_library') }}</a></li>
            <li class="breadcrumb-item active">{{ $page_title }}</li>
        </ol>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="media-upload-form-wrap" id="async-upload-wrap">
            <form enctype="multipart/form-data" method="post" action="{{ get_admin_url('mediaajax') }}" id="media-upload-form">
                <div class="upload-console-drop" id="drop-zone">
                    <h3>{{admin_lang('drop_files_here')}}</h3>
                    <span>{{admin_lang('or')}}</span>
                    <input type="file" name="files[]" id="standard-upload-files" multiple="multiple" />
                    <input type="hidden" name="action" value="async_upload" />
                    <input type="hidden" name="type" value="normal" id="type-upload-files" />
                    <button type="button" class="btn" id="plupload-browse-button" />{{admin_lang('select_files')}}</button>
                    <div class="maximum_upload_file_size">{{admin_lang('maximum_uploadfile_size', ['size' => format_size(file_upload_max_size())])}}</div>
                    <div class="bar hidden" id="bar">
                        <div class="bar-fill" id="bar-fill">
                            <div class="bar-fill-text" id="bar-fill-text"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="media-items"><div class="media-attachments"></div></div>
@endsection
@section('style_files')
<link rel="stylesheet" href="{{ asset('dashboard/css/drag-drop.css') }}" />
@endsection
@section('script_files')
<script type="text/javascript">
    var pageload = 1;
    var media_upload_url = '{{ get_admin_url('medialibrary') }}';
    var ajaxRequests = [];
    var admin_media_upload_url = '{{get_admin_url('mediaaction')}}';
    var admin_ajax_url = '{{ get_admin_url('mediaajax') }}';
</script>
<script type="text/javascript" src="{{ asset('dashboard/js/drag-drop.js') }}"></script>
@endsection