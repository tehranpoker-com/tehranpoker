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
            <a href="#" class="" data-tab=".tab-gallery"><i class="bx bx-photo-album"></i> {{ admin_lang('gallery') }}</a>
            <a href="#" class="" data-tab=".tab-seo"><i class="bx bx-search-alt"></i> {{admin_lang('seo')}}</a>
        </div>
        <div class="tacf-tabs-content">
            <div class="tacf-tab-content tab-details active">
                <div class="row">
                    <div class="col-md-9 border-right">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{admin_lang('type')}}</label>
                                    <select class="form-select select-portfolio-type" name="postmeta[portfolio_type]">
                                        <option value="normal" @if($portfolio_type == 'normal') selected @endif>{{admin_lang('normal')}}</option>
                                        <option value="video" @if($portfolio_type == 'video') selected @endif>{{admin_lang('video')}}</option>
                                        <option value="gallery" @if($portfolio_type == 'gallery') selected @endif>{{admin_lang('gallery')}}</option>
                                        <option value="iframe" @if($portfolio_type == 'iframe') selected @endif>{{admin_lang('iframe')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">@include('dashboard.posts.inputs.input_categories')</div>
                            <div class="col-md-4">@include('dashboard.posts.inputs.input_orders')</div>
                        </div>
                        <div class="form-group">
                            <label>{{admin_lang('caption')}}</label>
                            <input type="text" class="form-control" name="post_excerpts" value="{{$post_excerpts}}" />
                        </div>
                        <div class="form-group box-portfolio-type box-portfolio-video fadeIn @if($portfolio_type != 'video') d-none @endif">
                            <label>{{admin_lang('video_url')}} <small>{{admin_lang('video_url_desc')}}</small></label>
                            <input class="form-control" data-toggle="fileupload" data-field="video_url" data-type="video" data-src="true" data-size="full" type="text" name="postmeta[video_url]" value="{{$video_url}}">
                        </div>
                        <div class="form-group box-portfolio-type box-portfolio-iframe fadeIn @if($portfolio_type != 'iframe') d-none @endif">
                            <label>{{admin_lang('iframe_url')}}</label>
                            <input type="text" class="form-control" name="postmeta[iframe_url]" value="{{$iframe_url}}" />
                        </div>
                        <div class="form-group border p-3">
                            <label>{{admin_lang('details')}}</label>
                            <div class="tacf-input mt-3">
                                <div class="tacf-repeater">
                                    <table class="tacf-table">
                                        <tbody class="tacf-ui-sortable">
                                            @if(is_array($details) and count($details))
                                                @php $key = 0; @endphp
                                                @foreach($details as $item)
                                                <tr class="tacf-row">
                                                    <td class="tacf-field tacf-col-item">
                                                        <h3 class="tacf-head-item">
                                                            <span class="tacf-title-item">{{admin_lang('title')}}: <span>{{$item['title']}}</span></span> 
                                                            <span class="tacf-row-handle tacf-action-handle order ui-sortable-handle" title="{{admin_lang('move')}}"><i class="bx bx-move"></i></span>
                                                            <span class="tacf-remove" data-event="remove-row" title="{{admin_lang('remove')}}"><i class="bx bxs-trash-alt"></i></span>
                                                            @if($item['toggle']) <span class="tacf-collapse-button"><i class="fas fa-minus"></i></span> @else <span class="tacf-collapse-button"><i class="fas fa-plus"></i></span> @endif
                                                            <span class="tacf-status status-button status-button-switch" title="{{admin_lang('status')}}">
                                                                <div class="form-check form-switch form-switch-sm form-switch-success" dir="ltr">
                                                                    <input class="form-check-input" type="checkbox" name="postmeta[details][{{$key}}][status]" value="1" @if(isset($item['status']) and $item['status']) checked="" @endif>
                                                                </div>
                                                            </span>
                                                            <input type="hidden" class="tacf-toggle-input" name="postmeta[details][{{$key}}][toggle]" value="{{$item['toggle']}}">
                                                        </h3>
                                                        <div class="tacf-input tacf-toggle-content fadeIn @if(!$item['toggle']) d-none @endif">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>{{admin_lang('title')}}</label>
                                                                        <input type="text" name="postmeta[details][{{$key}}][title]" class="form-control tacf_toggle_title" value="{{$item['title']}}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>{{admin_lang('icon')}}</label>
                                                                        <div class="megapanel-icon-select">
                                                                            <span class="megapanel-icon-preview"><i class="{{$item['icon']}}"></i></span>
                                                                            <button type="button" class="btn btn-primary waves-effect waves-light megapanel-icon-add" data-modal-title="{{admin_lang('icons')}}">{{admin_lang('changes')}}</button>
                                                                            <button type="button" class="btn  btn-danger waves-effect waves-light megapanel-icon-remove">{{admin_lang('remove')}}</button>
                                                                            <input type="hidden" name="postmeta[details][{{$key}}][icon]" value="{{$item['icon']}}" class="megapanel-icon-value tacf-input-key">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>{{admin_lang('text')}}</label>
                                                                        <input type="text" name="postmeta[details][{{$key}}][text]" class="form-control" value="{{$item['text']}}" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @php $key++; @endphp
                                                @endforeach
                                            @endif
                                            <tr class="tacf-row tacf-clone">
                                                <td class="tacf-field tacf-col-item">
                                                    <h3 class="tacf-head-item">
                                                        <span class="tacf-title-item">{{admin_lang('title')}}: <span></span></span> 
                                                        <span class="tacf-row-handle tacf-action-handle order ui-sortable-handle" title="{{admin_lang('move')}}"><i class="bx bx-move"></i></span>
                                                        <span class="tacf-remove" data-event="remove-row" title="{{admin_lang('remove')}}"><i class="bx bxs-trash-alt"></i></span>
                                                        <span class="tacf-collapse-button"><i class="fas fa-minus"></i></span> 
                                                        <span class="tacf-status status-button status-button-switch" title="{{admin_lang('status')}}">
                                                            <div class="form-check form-switch form-switch-sm form-switch-success" dir="ltr">
                                                                <input class="form-check-input tacf-input-key" type="checkbox" data-name="postmeta[details][{key}][status]" value="1" checked="">
                                                            </div>
                                                        </span>
                                                        <input type="hidden" class="tacf-input-key tacf-toggle-input" data-name="postmeta[details][{key}][toggle]" value="1">
                                                    </h3>
                                                    <div class="tacf-input tacf-toggle-content fadeIn">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>{{admin_lang('title')}}</label>
                                                                    <input type="text" data-name="postmeta[details][{key}][title]" class="form-control tacf-input-key tacf_toggle_title" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>{{admin_lang('icon')}}</label>
                                                                    <div class="megapanel-icon-select">
                                                                        <span class="megapanel-icon-preview"><i class=""></i></span>
                                                                        <button type="button" class="btn btn-primary waves-effect waves-light megapanel-icon-add">{{admin_lang('changes')}}</button>
                                                                        <button type="button" class="btn btn-danger waves-effect waves-light megapanel-icon-remove">{{admin_lang('remove')}}</button>
                                                                        <input type="hidden" data-name="postmeta[details][{key}][icon]" class="megapanel-icon-value tacf-input-key">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>{{admin_lang('text')}}</label>
                                                                    <input type="text" data-name="postmeta[details][{key}][text]" class="form-control tacf-input-key" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="tacf-actions mt-3">
                                        <button type="button" class="tacf-button button button-primary mb-2" data-event="add-row">{{admin_lang('add_new')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        @include('dashboard.posts.inputs.input_post_pin')
                        @include('dashboard.posts.inputs.input_featuredimage')
                    </div>
                </div>
            </div>
            <div class="tacf-tab-content tab-content p-0">
                @include('dashboard.posts.inputs.input_content')
            </div>
            <div class="tacf-tab-content tab-gallery">
                <div class="tacf-input mt-3">
                    <div class="tacf-repeater">
                        <table class="tacf-table">
                            <tbody class="tacf-ui-sortable">
                                @if(is_array($gallery) and count($gallery))
                                    @php $key = 0; @endphp
                                    @foreach($gallery as $item)
                                    <tr class="tacf-row">
                                        <td class="tacf-field tacf-col-item">
                                            <h3 class="tacf-head-item">
                                                <span class="tacf-title-item">{{admin_lang('title')}}: <span>{{$item['title']}}</span></span> 
                                                <span class="tacf-row-handle tacf-action-handle order ui-sortable-handle" title="{{admin_lang('move')}}"><i class="bx bx-move"></i></span>
                                                <span class="tacf-remove" data-event="remove-row" title="{{admin_lang('remove')}}"><i class="bx bxs-trash-alt"></i></span>
                                                @if($item['toggle']) <span class="tacf-collapse-button"><i class="fas fa-minus"></i></span> @else <span class="tacf-collapse-button"><i class="fas fa-plus"></i></span> @endif
                                                <span class="tacf-status status-button status-button-switch" title="{{admin_lang('status')}}">
                                                    <div class="form-check form-switch form-switch-sm form-switch-success" dir="ltr">
                                                        <input class="form-check-input" type="checkbox" name="postmeta[gallery][{{$key}}][status]" value="1" @if(isset($item['status']) and $item['status']) checked="" @endif>
                                                    </div>
                                                </span>
                                                <input type="hidden" class="tacf-toggle-input" name="postmeta[gallery][{{$key}}][toggle]" value="{{$item['toggle']}}">
                                            </h3>
                                            <div class="tacf-input tacf-toggle-content fadeIn @if(!$item['toggle']) d-none @endif">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <div class="form-group">
                                                            <label>{{admin_lang('title')}}</label>
                                                            <input type="text" name="postmeta[gallery][{{$key}}][title]" class="form-control tacf_toggle_title" value="{{$item['title']}}" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>{{admin_lang('caption')}}</label>
                                                            <input type="text" name="postmeta[gallery][{{$key}}][caption]" class="form-control" value="{{$item['caption']}}" />    
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>{{admin_lang('image')}}</label>
                                                            <input class="form-control" data-toggle="fileupload" data-field="boxshomepage-{{$key}}" data-src="true" data-size="full" type="text" name="postmeta[gallery][{{$key}}][image]" value="{{$item['image']}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @php $key++; @endphp
                                    @endforeach
                                @endif
                                <tr class="tacf-row tacf-clone">
                                    <td class="tacf-field tacf-col-item">
                                        <h3 class="tacf-head-item">
                                            <span class="tacf-title-item">{{admin_lang('title')}}: <span></span></span> 
                                            <span class="tacf-row-handle tacf-action-handle order ui-sortable-handle" title="{{admin_lang('move')}}"><i class="bx bx-move"></i></span>
                                            <span class="tacf-remove" data-event="remove-row" title="{{admin_lang('remove')}}"><i class="bx bxs-trash-alt"></i></span>
                                            <span class="tacf-collapse-button"><i class="fas fa-minus"></i></span> 
                                            <span class="tacf-status status-button status-button-switch" title="{{admin_lang('status')}}">
                                                <div class="form-check form-switch form-switch-sm form-switch-success" dir="ltr">
                                                    <input class="form-check-input tacf-input-key" type="checkbox" data-name="postmeta[gallery][{key}][status]" value="1" checked="">
                                                </div>
                                            </span>
                                            <input type="hidden" class="tacf-input-key tacf-toggle-input" data-name="postmeta[gallery][{key}][toggle]" value="1">
                                        </h3>
                                        <div class="tacf-input tacf-toggle-content fadeIn">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <label>{{admin_lang('title')}}</label>
                                                        <input type="text" data-name="postmeta[gallery][{key}][title]" class="form-control tacf-input-key tacf_toggle_title" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{admin_lang('caption')}}</label>
                                                        <input type="text" data-name="postmeta[gallery][{key}][caption]" class="form-control tacf-input-key" />
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>{{admin_lang('image')}}</label>
                                                        <input class="form-control tacf-input-key tacf-input-fileupload" data-field="boxshomepage-{key}" data-src="true" data-size="full" type="text" data-name="postmeta[gallery][{key}][image]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="tacf-actions mt-3">
                            <button type="button" class="tacf-button button button-primary mb-2" data-event="add-row">{{admin_lang('add_new')}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tacf-tab-content tab-seo">
                @include('dashboard.posts.boxs.box_seo')
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
<script>
(function($) {
    "use strict";
    $('.select-portfolio-type').on('change', function(){
        $('.box-portfolio-type').addClass('d-none');
        $('.box-portfolio-'+$(this).val()).removeClass('d-none');
    });
})(jQuery);
</script>
@endsection

