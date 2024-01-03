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
        <div class="tacf-box-tabs">
            <a href="#" class="active" data-tab=".tab-details"><i class="bx bx-pencil"></i> {{ admin_lang('details') }}</a>
        </div>
        <div class="tacf-tabs-content">
            <div class="tacf-tab-content tab-details active">
                <div class="row">
                    <div class="col-md-9 border-right">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>{{admin_lang('url')}}</label>
                                    <input type="text" name="postmeta[url]" placeholder="{{admin_lang('url')}}" value="{{get_post_meta('url', $post_id)}}" class="form-control" />
                                </div>    
                            </div>
                            <div class="col-md-3">@include('dashboard.posts.inputs.input_orders')</div>
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
<link href="{{ asset('libs/tacf/tacf.min.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('script_files')
<script src="{{ asset('libs/tacf/tacf.min.js') }}"></script>
@endsection