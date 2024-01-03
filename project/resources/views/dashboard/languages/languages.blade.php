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
@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>{!! session()->get('success') !!}</div>
@endif
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">@if($action == 'update') {{ admin_lang('update') }} @else {{ admin_lang('add_new') }} @endif</h4>
                <form method="POST" action="{{ get_admin_url('LanguageSendForm') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box">
                        <div class="box-body">
                            <input type="hidden" name="action" value="{{ $action }}" />
                            <input type="hidden" name="lang_id" value="@if(isset($lang)){{ $lang->id }}@endif" />
                            <div class="form-group">
                                <label>{{ admin_lang('name') }}</label>
                                <input type="text" name="name" placeholder="{{ admin_lang('name') }}" value="@if(isset($lang)){{ $lang->name }}@endif" class="form-control" required="">
                            </div>
                            <div class="form-group">
                                <label>{{ admin_lang('code') }} (ISO 639-1) <span class="help-block"><a href="https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes" target="_blank">?</a></span></label>
                                <input type="text" name="code" placeholder="{{ admin_lang('code') }}" value="@if(isset($lang)){{ $lang->code }}@endif" class="form-control" required="">
                            </div>
                            <div class="form-group">
                                <label>{{ admin_lang('direction') }}</label>
                                <div class="megapanel-field">
                                    {!! setting_input_radio_multiple(['ltr' => 'LTR', 'rtl'  => 'RTL'], 'direction', $direction) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Json <span class="help-block"><a href="https://docs.themearabia.net/basma-resume/#addlang" target="_blank">?</a></span></label>
                                <div class="megapanel-field">
                                    <input type="file" name="json" class="form-file" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ admin_lang('status') }}</label>
                                <div>
                                    <input type="checkbox" name="status" value="1" class="custom-control-input" switch="bool" id="status_switch" @if($lang_status) checked @endif>
                                    <label for="status_switch" data-on-label="ON" data-off-label="OFF"></label>
                                </div>
                            </div>                
                        </div>
                        <div class="box-footer">
                            <button class="btn btn-small btn-success">@if($action == 'update') {{ admin_lang('update') }} @else {{ admin_lang('add_new') }} @endif</button>&nbsp;
                            @if($action == 'update')
                            <a class="btn btn-small btn-danger" href="{{ get_admin_url('languages') }}">{{ admin_lang('cancel') }}</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">{{ admin_lang('languages') }}</h4>
                <form class="form-horizontal" method="POST" action="{{ get_admin_url('LanguagesActions') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="query" value="action">
                    <div id="jq-table_wrapper" class="dataTables_wrapper dt-bootstrap no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="jq-table" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="jq-table_info">
                                    <thead>
                                        <tr>
                                            <th class="text-center th-checkbox width25">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="selectall" />
                                                    <label class="custom-control-label" for="selectall"></label>
                                                </div>
                                            </th>
                                            <th>{{ admin_lang('name') }}</th>
                                            <th class="hidden-phone text-center">{{ admin_lang('code') }}</th>
                                            <th class="hidden-phone text-center">{{ admin_lang('direction') }}</th>
                                            <th class="hidden-phone text-center">{{ admin_lang('phrases') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($languages as $lang)
                                        <tr role="row" class="odd">
                                            <td class="td-checkbox">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="mark[]" value="{{ $lang->id }}" id="select-{{ $lang->id }}" />                                        
                                                    <label class="custom-control-label" for="select-{{ $lang->id }}"></label>
                                                </div>
                                                @if($lang->status)
                                                <span class="sq-post-status disable"></span>
                                                @else
                                                <span class="sq-post-status enable"></span>
                                                @endif
                                            </td>
                                            <td>
                                                <strong><a href="{{ get_admin_url('editlanguage/'.$lang->id) }}">{{ $lang->name }}</a></strong>
                                                <div class="row-actions">
                                                    <a href="{{ get_admin_url('editlanguage/'.$lang->id) }}">{{ admin_lang('edit') }}</a> | 
                                                    @if($lang->status) <a href="{{ get_admin_url('disablelanguage/'.$lang->id) }}" class="green">{{ admin_lang('disable') }}</a> | 
                                                    @else <a href="{{ get_admin_url('enablelanguage/'.$lang->id) }}" class="red">{{ admin_lang('enable') }}</a> | @endif
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-href="{{ get_admin_url('deletelanguage/'.$lang->id.'/'.csrf_token() ) }}" data-body="{{ admin_lang('delete_confirm') }} #{{ $lang->name }}?" class="red">{{ admin_lang('delete') }}</a>
                                                </div>
                                            </td>
                                            <td class="hidden-phone text-center">{{ $lang->code }}</td>
                                            <td class="hidden-phone text-center">{{ $lang->direction }}</td>
                                            <td class="hidden-phone text-center"><a href="{{ get_admin_url('language/phrases/'.$lang->id) }}" class="btn btn-sm btn-info">{{ admin_lang('phrases') }}</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('style_files')
<link href="{{ asset('libs/megapanel/megapanel_options.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/datatables/dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('script_files')
<script src="{{ asset('libs/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('libs/datatables/dataTables.min.js') }}"></script>
<script src="{{ asset('libs/megapanel/megapanel_options.min.js') }}"></script>
@endsection
@section('script_code')
<script type="text/javascript">
$(function() {
    $("#jq-table").DataTable({columns: [{"orderable": false}, null, null, null, null],"order": [[ 1, "asc" ]]});
    $(".dataTables_length").prepend('{!! get_select_actions_options() !!}');
});
</script>
@endsection