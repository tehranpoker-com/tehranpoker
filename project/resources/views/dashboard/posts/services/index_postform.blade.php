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
        </div>
        <div class="tacf-tabs-content">
            <div class="tacf-tab-content tab-details active">
                <div class="row">
                    <div class="col-md-9 border-right">
                        <div class="row">
                            <div class="col-md-4">@include('dashboard.posts.inputs.input_orders')</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{admin_lang('icon')}}</label>
                                    <div class="megapanel-icon-select">
                                        <span class="megapanel-icon-preview"><i class="{{get_post_meta('icon', $post_id)}}"></i></span>
                                        <button type="button" class="btn btn-primary waves-effect waves-light megapanel-icon-add">{{admin_lang('changes')}}</button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light megapanel-icon-remove">{{admin_lang('remove')}}</button>
                                        <input type="hidden" name="postmeta[icon]" value="{{get_post_meta('icon', $post_id)}}" class="megapanel-icon-value">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{admin_lang('description')}}</label>
                            <textarea class="form-control" rows="12" autocomplete="off" name="post_excerpts" placeholder="{{ admin_lang('description') }}">{{ $post_excerpts }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        @include('dashboard.posts.inputs.input_featuredimage')
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('style_files')
<link href="{{ asset('libs/megapanel/megapanel_options.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/tacf/tacf.min.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('script_files')
<script src="{{ asset('libs/megapanel/megapanel_options.min.js') }}"></script>
<script src="{{ asset('libs/tacf/tacf.min.js') }}"></script>
@endsection