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
    <div class="tacf-box-container">
        <div class="tacf-box-tabs nav-tabs-cookie" data-cookie="formpost_{{$type}}" data-cookie-tab="tab-details">
            <a href="#" class="active" data-tab=".tab-details"><i class="bx bx-pencil"></i> {{ admin_lang('details') }}</a>
            <a href="#" class="" data-tab=".tab-content"><i class="bx bx-file"></i> {{ admin_lang('content') }}</a>
        </div>
        <div class="tacf-tabs-content">
            <div class="tacf-tab-content tab-details active">
                <div class="row">
                    <div class="col-md-2">@include('dashboard.posts.inputs.input_orders')</div>
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
<link href="{{ asset('libs/tacf/tacf.min.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('script_files')
<script src="{{ asset('libs/tacf/tacf.min.js') }}"></script>
@endsection