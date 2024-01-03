@extends('dashboard.layouts.master')
@section('content')
<div class="page-title-box d-flex align-items-center justify-content-between">
    <h4 class="mb-0 font-size-18">{{ $page_title }} :: {{admin_lang('skills')}}</h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ get_admin_url('/') }}">{{ admin_lang('dashboard') }}</a></li>
            <li class="breadcrumb-item active">{{ $page_title }} :: {{admin_lang('skills')}}</li>
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
                <h4 class="card-title mb-3">@if($action == 'update') {{ admin_lang('update') }} @else {{ admin_lang('addnewcategories') }} @endif</h4>
                <form method="POST" action="{{ get_admin_url('CategorySendForm') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box">
                        <div class="box-body">
                            <input type="hidden" name="type" value="{{ $type }}">
                            <input type="hidden" name="action" value="{{ $action }}" />
                            <input type="hidden" name="term_id" value="@if(isset($cate)){{ $cate->id }}@endif" />
                            <div class="form-group">
                                <label>{{ admin_lang('name') }}</label>
                                <input type="text" name="name" placeholder="{{ admin_lang('name') }}" value="@if(isset($cate)){{ $cate->name }}@endif" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>{{ admin_lang('style') }}</label>

                                <div class="megapanel-field">
                                    {!! setting_input_radio_multiple(
                                        [
                                            'style-progress'        => '<i class="fas fa-percent"></i>', 
                                            'style-points'          => '<i class="far fa-circle"></i>', 
                                            'style-points solid'    => '<i class="fas fa-circle"></i>', 
                                            'style-stars'           => '<i class="far fa-star"></i>', 
                                            'style-stars solid'     => '<i class="fas fa-star"></i>',  
                                            'style-heart'           => '<i class="far fa-heart"></i>', 
                                            'style-heart solid'     => '<i class="fas fa-heart"></i>', 
                                            'style-heartbeat'       => '<i class="fas fa-heartbeat"></i>', 
                                        ], 
                                        'termmeta[style]', $term_style) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ admin_lang('column') }}</label>
                                <div class="megapanel-field">
                                    {!! setting_input_radio_multiple_img(
                                        [
                                            'col-lg-12' => asset('images/options/1col.png'), 
                                            'col-lg-6'  => asset('images/options/2col.png'), 
                                            'col-lg-4'  => asset('images/options/3col.png'), 
                                        ], 
                                        'termmeta[column]', $term_column) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ admin_lang('orders') }}</label>
                                <input type="text" name="orders" value="@if(isset($cate)){{ $cate->orders }}@else{{ get_term_count($type, 1) }}@endif" class="form-control text-center">
                            </div>
                            <div class="form-group">
                                <label>{{ admin_lang('status') }}</label>
                                <div>
                                    <input type="checkbox" name="status" value="1" class="custom-control-input" switch="bool" id="status_switch" @if($cate_status) checked @endif>
                                    <label for="status_switch" data-on-label="ON" data-off-label="OFF"></label>
                                </div>
                            </div>                
                        </div>
                        <div class="box-footer">
                            <button class="btn btn-small btn-success">@if($action == 'update') {{ admin_lang('update') }} @else {{ admin_lang('addnewcategories') }} @endif</button>&nbsp;
                            @if($action == 'update')
                            <a class="btn btn-small btn-danger" href="{{ get_admin_url('categories/'.$type) }}">{{ admin_lang('cancel') }}</a>
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
                <h4 class="card-title mb-3">{{ admin_lang('categories') }}</h4>
                <form class="form-horizontal" method="POST" action="{{ get_admin_url('CategorysActions') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="type" value="{{ $type }}">
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
                                            <th class="hidden-phone text-center">{{ admin_lang('style') }}</th>
                                            <th class="hidden-phone text-center">{{ admin_lang('column') }}</th>
                                            <th class="hidden-phone text-center">{{ admin_lang('count') }}</th>
                                            <th class="hidden-phone text-center width-100">{{ admin_lang('orders') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categories as $cate)
                                        <tr role="row" class="odd">
                                            <td class="td-checkbox">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="mark[]" value="{{ $cate->id }}" id="select-{{ $cate->id }}" />                                        
                                                    <label class="custom-control-label" for="select-{{ $cate->id }}"></label>
                                                </div>
                                                @if($cate->status)
                                                <span class="sq-post-status disable"></span>
                                                @else
                                                <span class="sq-post-status enable"></span>
                                                @endif
                                            </td>
                                            <td>
                                                <strong><a href="{{ get_admin_url('editcategory/'.$cate->id) }}">{{ $cate->name }}</a></strong>
                                                <div class="row-actions">
                                                    <a href="{{ get_admin_url('editcategory/'.$cate->id) }}">{{ admin_lang('edit') }}</a> | 
                                                    @if($cate->status) <a href="{{ get_admin_url('disablecategory/'.$cate->id) }}" class="green">{{ admin_lang('disable') }}</a> | 
                                                    @else <a href="{{ get_admin_url('enablecategory/'.$cate->id) }}" class="red">{{ admin_lang('enable') }}</a> | @endif
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-href="{{ get_admin_url('deletecategory/'.$cate->id.'/'.csrf_token() ) }}" data-body="{{ admin_lang('delete_confirm') }} #{{ $cate->name }}?" class="red">{{ admin_lang('delete') }}</a>
                                                </div>
                                            </td>
                                            <td class="hidden-phone text-center">
                                                @if(get_term_meta('style', $cate->id) == 'style-progress')
                                                <i class="fas fa-percent"></i>
                                                @elseif(get_term_meta('style', $cate->id) == 'style-points')
                                                <i class="far fa-circle"></i>
                                                @elseif(get_term_meta('style', $cate->id) == 'style-points solid')
                                                <i class="fas fa-circle"></i> 
                                                @elseif(get_term_meta('style', $cate->id) == 'style-stars')
                                                <i class="far fa-star"></i>
                                                @elseif(get_term_meta('style', $cate->id) == 'style-stars solid')
                                                <i class="fas fa-star"></i> 
                                                @elseif(get_term_meta('style', $cate->id) == 'style-heart')
                                                <i class="far fa-heart"></i>
                                                @elseif(get_term_meta('style', $cate->id) == 'style-heart solid')
                                                <i class="fas fa-heart"></i>
                                                @elseif(get_term_meta('style', $cate->id) == 'style-heartbeat')
                                                <i class="fas fa-heartbeat"></i>
                                                @endif
                                            </td>
                                            <td class="hidden-phone text-center">
                                                @if(get_term_meta('column', $cate->id) == 'col-lg-12')
                                                <img src="{{asset('images/options/1col.png')}}" />
                                                @elseif(get_term_meta('column', $cate->id) == 'col-lg-6')
                                                <img src="{{asset('images/options/2col.png')}}" />
                                                @elseif(get_term_meta('column', $cate->id) == 'col-lg-4')
                                                <img src="{{asset('images/options/3col.png')}}" />
                                                @endif
                                            </td>
                                            <td class="hidden-phone text-center">{{ get_post_count($cate->type, $cate->id) }}</td>
                                            <td class="hidden-phone text-center">
                                                <span class="d-none">{{ $cate->orders }}</span>
                                                <input type="hidden" name="idx[]" value="{{ $cate->id }}">
                                                <input type="text" name="order[]" class="form-control input-sm width80 text-center" value="{{ $cate->orders }}">
                                            </td>
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
    $("#jq-table").DataTable({columns: [{"orderable": false}, null, null, null, null],"order": [[ 4, "asc" ]]});
    $(".dataTables_length").prepend('{!! get_select_actions_options('categories') !!}');
});
</script>
@endsection