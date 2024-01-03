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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{admin_lang('sub_title')}}</label>
                            <input type="text" class="form-control" name="postmeta[subtitle]" value="{{get_post_meta('subtitle', $post_id)}}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{admin_lang('counter')}}</label>
                            <input type="text" class="form-control" name="postmeta[counter]" value="{{get_post_meta('counter', $post_id)}}" />
                        </div>
                    </div>
                    <div class="col-md-4">@include('dashboard.posts.inputs.input_categories')</div>
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