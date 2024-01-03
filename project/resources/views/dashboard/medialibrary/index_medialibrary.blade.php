<!DOCTYPE html>
<html lang="{{$admin_lang}}" dir="{{$admin_dir}}">
<head>
    <meta charset="utf-8" />
    <title>{{ get_option('sitename') }} - {{ (isset($page_title))? $page_title : '' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ get_option_img('favicon', get_asset('images/favicon.png')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @if($admin_dir == 'rtl')<link href="{{ asset('dashboard/css/bootstrap-rtl.min.css') }}" rel="stylesheet" type="text/css" />@else<link href="{{ asset('dashboard/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />@endif
    <link rel="stylesheet" href="{{ asset('dashboard/css/drag-drop.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/css/media-upload.min.css') }}" />
</head>
<body class="{{$admin_dir}}" id="creative-media-upload">
<div class="creative-media-upload-header">
    <h1>{{admin_lang('insert_media')}}</h1>
    <button type="button" class="creative-media-upload-close" onclick="try{top.tb_remove();}catch(e){}; return false;"></button>
    <ul class="creative-media-upload-sidemenu">
        <li><a href="#" data-type="upload" class="upload">{{admin_lang('upload_files')}}</a></li>
        <li><a href="#" data-type="library" class="library current">{{admin_lang('media_library')}}</a></li>
    </ul>
</div>
<div class="media-toolbar-search">
    <div class="row">
        <div class="col-md-5">
            <input type="search" placeholder="{{admin_lang('search')}}" class="form-control filter-input-search width200">
            <select class="form-control filter-select-date width150">
                <option value="all">{{admin_lang('all_dates')}}</option>
                @foreach ($attach_date as $date)
                <option value="{{$date->date_val}}">{{$date->date_txt}}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-primary btn-media-filter">{{admin_lang('filter')}}</button>
        </div>
    </div>
</div>
<div class="creative-media-upload-browser">
    <div class="creative-media-upload-content">
        <div class="content-tab content-library">
            <div id="media-items" class="media-items-library" data-loading="0" data-thelast="0">
                <ul class="media-attachments media-attachments-thickbox">
                    @foreach ($attachments as $item)
                    <li class="" role="checkbox" data-id="{{$item->at_id}}" title="{{$item->at_title}}" aria-checked="true" id="attachment-item-{{$item->at_id}}">
                        <div class="check"><div class="media-icon"></div></div>
                        <div class="attachment-preview">
                            <div class="thumbnail-item"><img src="{{get_media_mimes_thumbnail($item->at_files, $item->at_mimes)}}" /></div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div id="media-upload-content-toolbar">
                <div class="row">
                    <div class="col-md-5">
                        <button type="button" data-id="0" class="button button-media-select" disabled="disabled">@if($type == 'image'){{admin_lang('use_this_image')}}@else{{admin_lang('use_this_file')}}@endif</button>
                    </div>
                </div>
            </div>
        </div>    
        <div class="content-tab content-upload hidden">
            <div class="media-upload-form-wrap" id="async-upload-wrap">
                <form enctype="multipart/form-data" method="post" action="{{ get_admin_url('mediaajax') }}" id="media-upload-form">
                    <div class="upload-console-drop" id="drop-zone">
                        <h3>{{admin_lang('drop_files_here')}}</h3>
                        <span>{{admin_lang('or')}}</span>
                        <input type="file" name="files[]" id="standard-upload-files" multiple="multiple" />
                        <input type="hidden" name="action" value="async_upload" />
                        <input type="hidden" name="type" value="thickbox" id="type-upload-files" />
                        <button type="button" class="btn" id="plupload-browse-button">{{admin_lang('select_files')}}</button>                        
                        <div class="maximum_upload_file_size">{{admin_lang('maximum_uploadfile_size', ['size' => format_size(file_upload_max_size())])}}</div>
                        <div class="bar hidden" id="bar">
                            <div class="bar-fill" id="bar-fill">
                                <div class="bar-fill-text" id="bar-fill-text"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <ul id="media-items" class="media-attachments"></ul>
        </div>
    </div>
</div>
<script type="text/javascript">
    var pageload = 1;
    var media_upload_url = '{{ get_admin_url('medialibrary') }}';
    var tb_pathToImage = "{{ asset('libs/cupload/js/thickbox/loadingAnimation.gif') }}";
    var tb_closeImage  = "{{ asset('libs/cupload/js/thickbox/tb-close.png') }}";
    var ajaxRequests = [];
    var admin_media_upload_url = '{{get_admin_url('mediaaction')}}';
    var admin_ajax_url = '{{ get_admin_url('mediaajax') }}';
</script>
<script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/js/jquery-ui.js') }}"></script>
<script type="text/javascript" src="{{ asset('libs/cupload/js/thickbox/thickbox.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/media-upload.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/drag-drop.js') }}"></script>
<script>
$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
$(function() {$("table th input:checkbox").on("click" , function(){var that = this;$(this).closest("table").find("tr > td:first-child input:checkbox").each(function(){this.checked = that.checked;$(this).closest("tr").toggleClass("selected");});});})</script>
</body>
</html>
