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
                    <div class="col-md-9 border-right">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ admin_lang('name') }}</label>
                                    <input type="text" name="title" placeholder="{{ admin_lang('name') }}" value="{{$post_title}}" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{admin_lang('position')}}</label>
                                    <input type="text" name="postmeta[position]" placeholder="{{admin_lang('position')}}" value="{{get_post_meta('position', $post_id)}}" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{admin_lang('rating')}}</label>
                                    <div class="form-rating">
                                        <label>
                                            <input type="radio" name="postmeta[rating]" value="1" {{get_checked(get_post_meta('rating', $post_id), '1')}} />
                                            <i class="icon bx bxs-star"></i>
                                        </label>
                                        <label>
                                            <input type="radio" name="postmeta[rating]" value="2" {{get_checked(get_post_meta('rating', $post_id), '2')}} />
                                            <i class="icon bx bxs-star"></i><i class="icon bx bxs-star"></i>
                                        </label>
                                        <label>
                                            <input type="radio" name="postmeta[rating]" value="3" {{get_checked(get_post_meta('rating', $post_id), '3')}} />
                                            <i class="icon bx bxs-star"></i><i class="icon bx bxs-star"></i><i class="icon bx bxs-star"></i>
                                        </label>
                                        <label>
                                            <input type="radio" name="postmeta[rating]" value="4" {{get_checked(get_post_meta('rating', $post_id), '4')}} />
                                            <i class="icon bx bxs-star"></i><i class="icon bx bxs-star"></i><i class="icon bx bxs-star"></i><i class="icon bx bxs-star"></i>
                                        </label>
                                        <label>
                                            <input type="radio" name="postmeta[rating]" value="5" {{get_checked(get_post_meta('rating', $post_id), '5')}} />
                                            <i class="icon bx bxs-star"></i><i class="icon bx bxs-star"></i><i class="icon bx bxs-star"></i><i class="icon bx bxs-star"></i><i class="icon bx bxs-star"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">@include('dashboard.posts.inputs.input_orders')</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{admin_lang('message')}}</label>
                            <textarea rows="12" autocomplete="off" name="content" class="form-control">@if(isset($post)){{ $post->post_content }}@endif</textarea>
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