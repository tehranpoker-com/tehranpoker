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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{admin_lang('date_from')}}</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="postmeta[date_from]" value="{{get_post_meta('date_from', $post_id)}}" placeholder="yyyy-mm-dd"  data-date-format="yyyy-mm-dd" data-provide="datepicker" data-date-autoclose="true">
                                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{admin_lang('date_to')}}</label>
                                    <div class="input-group box-date-to @if(get_post_meta('icurrently', $post_id)) d-none" @endif ">
                                        <input type="text" class="form-control" name="postmeta[date_to]" value="{{get_post_meta('date_to', $post_id)}}" placeholder="yyyy-mm-dd"  data-date-format="yyyy-mm-dd" data-provide="datepicker" data-date-autoclose="true">
                                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                    </div>
                                    <div class="form-check form-switch mb-3 mt-2" dir="ltr">
                                        <input class="form-check-input" type="checkbox" name="postmeta[icurrently]" value="1" id="icurrently_work" @if(get_post_meta('icurrently', $post_id)) checked @endif>
                                        <label class="form-check-label" for="icurrently_work">{{admin_lang('icurrently_work')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">@include('dashboard.posts.inputs.input_orders')</div>
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
<link href="{{ asset('libs/datepicker/datepicker.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('libs/tacf/tacf.min.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('script_files')
<script src="{{ asset('libs/tacf/tacf.min.js') }}"></script>
<script src="{{ asset('libs/datepicker/datepicker.min.js') }}"></script>
<script>
$(function() {
    $("#icurrently_work").on("click", function() {
        if ($(this).is(':checked')) {
            $('.box-date-to').hide();
            $('.box-date-to').find('input').val('');
        }
        else{
            $('.box-date-to').show();
        }
    });
});
</script>
@endsection