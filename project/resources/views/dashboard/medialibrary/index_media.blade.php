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
        <form class="form-horizontal" method="POST" action="{{ get_admin_url('MediaActions') }}">
            {{ csrf_field() }}
            <input type="hidden" name="query" value="action">
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="actionselect">
                        <select name="action" class="custom-select form-select custom-select-sm form-control form-control-sm width-120">
                            <option value="-1">{{admin_lang('bulk_actions')}}</option>
                            <option value="delete">{{admin_lang('delete')}}</option>
                        </select>
                        <input type="submit" class="btn btn-sm btn-primary" value="{{admin_lang('apply')}}" onclick="return confirm(\'{{admin_lang('apply_confirm')}}\');">
                    </div>
                </div>
                <div class="col-md-4">

                </div>
                <div class="col-md-4 btn-addnew">
                    <a href="{{ get_admin_url('media/upload') }}" class="btn btn-sm btn-primary">{{admin_lang('upload')}}</a>
                </div>
            </div>
            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap">
                <thead>
                    <tr>
                        <th class="text-center th-checkbox width25">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="selectall" />
                                <label class="custom-control-label" for="selectall"></label>
                            </div>
                        </th>
                        <th>{{admin_lang('title')}}</th>
                        <th class="hidden-phone text-center">{{admin_lang('extension')}}</th>
                        <th class="hidden-phone text-center">{{admin_lang('author')}}</th>
                        <th class="hidden-phone text-center width-200">{{admin_lang('date')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attachments as $attachment)
                    <tr>
                        <td class="td-checkbox">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="mark[]" value="{{ $attachment->at_id }}" id="select-{{ $attachment->at_id }}" />                                        
                                <label class="custom-control-label" for="select-{{ $attachment->at_id }}"></label>
                            </div>
                        </td>
                        <td>
                            <img src="{{get_media_mimes_thumbnail($attachment->at_files, $attachment->at_mimes)}}" class="image-table" alt="">          
                            <strong><a href="{{ get_admin_url('editmedia/'.$attachment->at_id) }}">{{ $attachment->at_title }}</a></strong>
                            <div class="row-actions">
                                <a href="{{ get_admin_url('editmedia/'.$attachment->at_id) }}">{{admin_lang('edit')}}</a> | 
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-href="{{ get_admin_url('deletemedia/'.$attachment->at_id.'/'.csrf_token() ) }}" data-body="{{ admin_lang('delete_confirm') }} # {{ $attachment->at_title }}?" class="red">{{ admin_lang('delete') }}</a>
                            </div>
                        </td>
                        <td class="hidden-phone text-center">{{$attachment->at_mimes}}</td>
                        <td class="hidden-phone text-center">{{ get_username($attachment->at_uid) }}</td>
                        <td class="hidden-phone text-center" dir="ltr">{{$attachment->at_modified}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
        {{$attachments->links('dashboard.layouts.pagination')}}
    </div>
</div>
@endsection