@extends('dashboard.layouts.master')
@section('content')
<div class="page-title-box d-flex align-items-center justify-content-between">
    <h4 class="mb-0 font-size-18">{{ $page_title }}</h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ get_admin_url('/') }}">{{ admin_lang('dashboard') }}</a></li>
            <li class="breadcrumb-item active">{{ $page_title }}</li>
        </ol>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-3 data-tables-filter">
        <form method="GET" action="" class="form-filter">
            <input type="search" name="s" class="form-control form-control-sm" value="{{request()->get('s')}}" placeholder="{{admin_lang('search')}}">
            <button type="submit" class="btn btn-sm btn-primary button-form-filter">{{admin_lang('search')}}</button>
        </form>
    </div>
    <div class="col-md-6"></div>
</div>
@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>{!! session()->get('success') !!}</div>
@endif
<div class="card">
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ get_admin_url('PostsActions') }}">
            {{ csrf_field() }}
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="hidden" name="query" value="action">
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="actionselect">
                        <select name="action" class="custom-select form-select custom-select-sm form-control form-control-sm width-120">
                            <option value="-1">{{admin_lang('bulk_actions')}}</option>
                            <option value="enable">{{admin_lang('enable')}}</option>
                            <option value="disable">{{admin_lang('disable')}}</option>
                            <option value="reorders">{{admin_lang('reorders')}}</option>
                            <option value="delete">{{admin_lang('delete')}}</option>
                        </select>
                        <input type="submit" class="btn btn-sm btn-primary" value="{{admin_lang('apply')}}" onclick="return confirm(\'{{admin_lang('apply_confirm')}}\');">
                    </div>
                </div>
                <div class="col-md-4">

                </div>
                <div class="col-md-4 btn-addnew">
                    <a href="{{ get_admin_url('postnew/'.$type) }}" class="btn btn-sm btn-primary">{{admin_lang('add_new')}}</a>
                </div>
            </div>
            <table id="jq-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="text-center th-checkbox width25">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="selectall" />
                                <label class="custom-control-label" for="selectall"></label>
                            </div>
                        </th>
                        <th>{{admin_lang('title')}}</th>
                        <th class="hidden-phone text-center">{{admin_lang('author')}}</th>
                        <th class="hidden-phone text-center width-100">{{admin_lang('orders')}}</th>
                        <th class="hidden-phone text-center width-200">{{admin_lang('date')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td class="td-checkbox">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="mark[]" value="{{ $post->id }}" id="select-{{ $post->id }}" />                                        
                                <label class="custom-control-label" for="select-{{ $post->id }}"></label>
                            </div>
                            @if($post->post_status)
                            <span class="sq-post-status disable"></span>
                            @else
                            <span class="sq-post-status enable"></span>
                            @endif
                        </td>
                        <td>
                            @if(get_post_meta('thumbnails', $post->id))<img src="{{ get_attachment_url(get_post_meta('thumbnails', $post->id), 'thumbnail') }}" class="image-table" alt="">@endif            
                            <strong>@if($post->post_pin)<span class="bx bx-pin font-size-16"></span>@endif <a href="{{ get_admin_url('editpost/'.$post->id) }}">{{ $post->post_title }}</a></strong>
                            @include('dashboard.posts.boxs.rowactions')
                        </td>
                        <td class="hidden-phone text-center">{{ get_username($post->post_author) }}</td>
                        <td class="hidden-phone text-center">
                            <span class="d-none">{{ $post->post_orders }}</span>
                            <input type="hidden" name="idx[]" value="{{ $post->id }}">
                            <input type="text" name="order[]" class="form-control input-sm width80 text-center" value="{{ $post->post_orders }}" >
                        </td>
                        <td class="hidden-phone text-center" dir="ltr">{{$post->post_modified}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
        {{$posts->links('dashboard.layouts.pagination')}}
    </div>
</div>
@endsection