@extends('dashboard.layouts.master')
@section('content')
@include('dashboard.posts.boxs.box_page_head')
<form method="POST" action="{{ get_admin_url('PostSendForm') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="post_type" value="{{$type}}">
    <input type="hidden" name="action" value="{{$action}}" />
    <input type="hidden" name="post_id" value="{{$post_id}}" />
    @include('dashboard.posts.boxs.box_publish_toolbar')
    <div class="tacf-box-container">
        <div class="tacf-box-tabs">
            <a href="#" class="active" data-tab=".tab-details"><i class="bx bx-pencil"></i> {{ admin_lang('details') }}</a>
        </div>
        <div class="tacf-tabs-content">
            <div class="tacf-tab-content tab-details active">
                <div class="row">
                    <div class="col-md-7 border-right">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>{{ admin_lang('title') }}</label>
                                    <input type="text" name="title" placeholder="{{ admin_lang('title') }}" value="{{$post_title}}" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">@include('dashboard.posts.inputs.input_orders')</div>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{admin_lang('price')}}</label>
                                    <input type="text" name="postmeta[price]" placeholder="{{admin_lang('price')}}" value="{{ get_post_meta('price', $post_id) }}" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{admin_lang('payeach')}}</label>
                                    <input type="text" name="postmeta[payeach]" placeholder="{{admin_lang('payeach')}}" value="{{ get_post_meta('payeach', $post_id) }}" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{admin_lang('priceold')}}</label>
                                    <input type="text" name="postmeta[priceold]" placeholder="{{admin_lang('priceold')}}" value="{{ get_post_meta('priceold', $post_id) }}" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{admin_lang('currency')}}</label>
                                    <input type="text" name="postmeta[currency]" placeholder="{{admin_lang('currency')}}" value="{{ get_post_meta('currency', $post_id) }}" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{admin_lang('background')}}</label>
                                    <input type="text" name="postmeta[bgcolor]" value="{{ get_post_meta('bgcolor', $post_id) }}" class="form-control colorpicker" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{admin_lang('color')}}</label>
                                    <input type="text" name="postmeta[color]" value="{{ get_post_meta('color', $post_id) }}" class="form-control colorpicker" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{admin_lang('button_background')}}</label>
                                    <input type="text" name="postmeta[btnbgcolor]" value="{{ get_post_meta('btnbgcolor', $post_id) }}" class="form-control colorpicker" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{admin_lang('button_color')}}</label>
                                    <input type="text" name="postmeta[btncolor]" value="{{ get_post_meta('btncolor', $post_id) }}" class="form-control colorpicker" />
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{admin_lang('button_text')}}</label>
                                    <input type="text" name="postmeta[btntext]" placeholder="{{admin_lang('button_text')}}" value="@if(get_post_meta('btntext', $post_id)){{get_post_meta('btntext', $post_id)}}@else{{lang('choose_plan')}}@endif" class="form-control" />
                                </div>
                            </div>

                            
                            <div class="col-md-6 pt-3">
                                <input type="checkbox" name="postmeta[recommend]" value="1" class="custom-control-input" switch="bool" id="recommend_switch" @if(get_post_meta('recommend', $post_id)) checked @endif>
                                <label for="recommend_switch" data-on-label="ON" data-off-label="OFF"><span>{{admin_lang('recommend')}}</span></label> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label>{{admin_lang('url')}}</label>
                                <input type="text" name="postmeta[url]" placeholder="{{admin_lang('url')}}" value="{{ get_post_meta('url', $post_id) }}" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label>{{admin_lang('featured')}}</label>
                        <textarea class="form-control" rows="16" autocomplete="off" name="post_excerpts" placeholder="{{ admin_lang('featured') }}">{{ $post_excerpts }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('style_files')
<link rel="stylesheet" href="{{ asset('libs/spectrum/spectrum.min.css') }}" type="text/css" />
<link href="{{ asset('libs/tacf/tacf.min.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('script_files')
<script src="{{ asset('libs/spectrum/spectrum.min.js') }}"></script>
<script src="{{ asset('libs/tacf/tacf.min.js') }}"></script>
<script>$(".colorpicker").spectrum({allowEmpty: false,showAlpha: false});</script>
@endsection