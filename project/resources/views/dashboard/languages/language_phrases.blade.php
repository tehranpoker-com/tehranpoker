@extends('dashboard.layouts.master')
@section('content')
<div class="page-title-box d-flex align-items-center justify-content-between">
    <h4 class="mb-0 font-size-18">{{ $page_title }}</h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ get_admin_url('/') }}">{{ admin_lang('dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ get_admin_url('languages') }}">{{ admin_lang('languages') }}</a></li>
            <li class="breadcrumb-item active">{{ $page_title }}</li>
        </ol>
    </div>
</div>

@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>{!! session()->get('success') !!}</div>
@endif

<input type="hidden" name="lang_id" value="{{$lang_id}}" />
<div class="tacf-box-container">
    <div class="tacf-box-tabs nav-tabs-cookie" data-cookie="formpost_phrases" data-cookie-tab="tab-details">
        <a href="#" class="active" data-tab=".tab-details"><i class="bx bx-pencil"></i> {{ admin_lang('details') }}</a>
        <a href="#" class="" data-tab=".tab-phrases"><i class="bx bx-file"></i> {{ admin_lang('phrases') }}</a>
    </div>
    <div class="tacf-tabs-content">
        <div class=""></div>
        <div class="tacf-tab-content tab-details active">
            <div class="account_info">
                <div class="account_info-group"><label>{{admin_lang('id')}}:</label> {{$single->id}}</div>
                <div class="account_info-group"><label>{{admin_lang('name')}}:</label> {{$single->name}}</div>
                <div class="account_info-group"><label>{{admin_lang('code')}}:</label> {{$single->code}}</div>
                <div class="account_info-group"><label>{{admin_lang('direction')}}:</label> {{$single->direction}}</div>
                <div class="account_info-group"><label>{{admin_lang('phrases')}}:</label> {{count($phrases)}}</div>
            </div>
        </div>
        <div class="tacf-tab-content tab-phrases">

            <div class="mb-3">
                <button type="button" onclick="location.href='{{get_admin_url('language/refresh/'.$single->id)}}';" class="btn btn-warning waves-effect waves-light"><i class="fas fa-sync"></i> {{admin_lang('refresh_file')}}</button>
            </div>
            <div class="dataTables_wrapper dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="jq-table-phrases" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="jq-table_info">
                            <thead>
                                <tr>
                                    <th>{{ admin_lang('id') }}</th>
                                    <th>{{ admin_lang('default') }}</th>
                                    <th>{{ admin_lang('text') }}</th>
                                    <th class="width25 text-center">{{ admin_lang('edit') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($phrases as $key => $phrase)
                                <tr role="row" class="odd tr-box-phrase">
                                    <td>{{ $key }}</td>
                                    <td>{{ lang($key, [], 'global', 'default') }}</td>
                                    <td>
                                        <div class="phrase-text fadeIn">{{ $phrase }}</div>
                                        <div class="phrase-input d-none fadeIn" data-langid="{{$single->id}}">
                                            <div class="input-group">
                                                <input type="text" class="form-control input-phrase" name="pk" dir="{{$single->direction}}" value="{{ $phrase }}" />
                                                <span class="input-group-btn">
                                                    <button class="btn btn-success phrase-save" data-key="{{$key}}" data-code="{{$single->code}}">{{admin_lang('save')}}</button>
                                                    <button class="btn btn-danger phrase-cancel">{{admin_lang('cancel')}}</button>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center width25"><a class="btn btn-info edit-phrase" title="{{ admin_lang('edit') }}"><i class="bx bx-edit-alt"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('style_files')
<link href="{{ asset('libs/datatables/dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/tacf/tacf.min.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('script_files')
<script src="{{ asset('libs/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('libs/datatables/dataTables.min.js') }}"></script>
<script src="{{ asset('libs/tacf/tacf.min.js') }}"></script>
<script src="{{ asset('dashboard/js/editlang.js') }}"></script>
@endsection
@section('script_code')
<script type="text/javascript">
$(function() {
    $("#jq-table-phrases").DataTable({columns: [{"orderable": false}, null, null, null],"order": [[ 0, "asc" ]], pageLength: 20,lengthMenu: [20, 50, 100]});
});
</script>
@endsection