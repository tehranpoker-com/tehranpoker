@extends('dashboard.layouts.master')
@section('content')
@include('dashboard.posts.boxs.box_page_head')
<form method="POST" action="{{ get_admin_url('PostSendForm') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="post_type" value="{{$type}}">
    <input type="hidden" name="action" value="{{$action}}" />
    <input type="hidden" name="post_id" value="{{$post_id}}" />
    @include('dashboard.posts.boxs.box_publish_toolbar')
    @include('dashboard.posts.inputs.input_title')
    @include('dashboard.posts.inputs.input_postname')
    <div class="tacf-box-container">
        <div class="tacf-box-tabs nav-tabs-cookie" data-cookie="formpost_{{$type}}" data-cookie-tab="tab-details">
            <a href="#" class="active" data-tab=".tab-details"><i class="bx bx-pencil"></i> {{ admin_lang('details') }}</a>
            <a href="#" class="" data-tab=".tab-content"><i class="bx bx-file"></i> {{ admin_lang('content') }}</a>
        </div>
        <div class="tacf-tabs-content">
            <div class="tacf-tab-content tab-details active">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{admin_lang('sub_title')}}</label>
                            <input type="text" class="form-control" name="post_excerpts" value="{{ $post_excerpts }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{admin_lang('background')}}</label>
                            <div class="megapanel-buttons-options">
                                <button type="button" data-value="normal" class="option-on @if($style == 'normal') active @endif"><label>{{admin_lang('normal')}}</label></button>
                                <button type="button" data-value="bgimage" class="option-on @if($style == 'bgimage') active @endif"><label>{{admin_lang('image')}}</label></button>
                                <input type="hidden" name="postmeta[style]" value="{{$style}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{admin_lang('image')}}</label>
                            <input class="form-control" data-toggle="fileupload" data-field="bgimage" data-src="true" data-size="full" type="text" name="postmeta[bgimage]" value="{{ $bgimage }}" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="tacf-tab-content tab-content p-0">
                @include('dashboard.posts.inputs.input_content')
            </div>
        </div>
    </div>
</form>
@if(get_option('content_editor') == 'articleeditor')
@include('dashboard.layouts.articleeditor')
@else
@include('dashboard.layouts.tinymce')
@endif
@endsection
@section('style_files')
<link href="{{ asset('libs/megapanel/megapanel_options.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/tacf/tacf.min.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('script_files')
<script src="{{ asset('libs/megapanel/megapanel_options.min.js') }}"></script>
<script src="{{ asset('libs/tacf/tacf.min.js') }}"></script>
@endsection