@extends('vendor.installer.layouts.master')
@section('template_title')
    {{ trans('installer_messages.environment.wizard.templateTitle') }}
@endsection
@section('title')
    {!! trans('installer_messages.environment.wizard.title') !!}
@endsection
@section('container')
    <div class="tabs tabs-full">
        <form method="post" action="{{ route('LaravelInstaller::environmentSaveWizard') }}" class="tabs-wrap">
            <div>
                @if($errors->has('license'))
                <div class="alert alert-danger" id="error_alert">{!!$errors->first('license')!!}</div>
                @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="app_admin_folder" value="admincp">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group {{ $errors->has('app_name') ? ' has-error ' : '' }}">
                            <label for="app_name">{{ trans('installer_messages.environment.wizard.form.app_name_label') }}</label>
                            <input type="text" name="app_name" id="app_name" class="form-control" value="{{old('app_name')}}" placeholder="{{ trans('installer_messages.environment.wizard.form.app_name_placeholder') }}" />
                            @if ($errors->has('app_name'))<span class="error-block">{{ $errors->first('app_name') }}</span>@endif
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group {{ $errors->has('app_lang') ? ' has-error ' : '' }}">
                            <label for="app_lang">{{ trans('installer_messages.environment.wizard.form.app_lang_label') }}</label>
                            <select name="app_lang" class="form-select" id="app_lang">
                                @foreach (default_language() as $item)
                                <option value="{{$item['code']}}">{{$item['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-12 option-more d-none">
                        <div class="form-group {{ $errors->has('app_url') ? ' has-error ' : '' }}">
                            <label for="app_url">{{ trans('installer_messages.environment.wizard.form.app_url_label') }}</label>
                            <input type="url" name="app_url" id="app_url" class="form-control" value="@if(old('app_url')){{old('app_url')}}@else{{url('/')}}@endif" placeholder="{{ trans('installer_messages.environment.wizard.form.app_url_placeholder') }}" />
                            @if ($errors->has('app_url'))<span class="error-block">{{ $errors->first('app_url') }}</span>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group {{ $errors->has('app_client') ? ' has-error ' : '' }} {{ $errors->has('license') ? ' has-error ' : '' }}">
                            <label for="app_client">{{ trans('installer_messages.environment.wizard.form.app_client_label') }}</label>
                            <input type="text" name="app_client" id="app_client" class="form-control" value="{{old('app_client')}}" placeholder="{{ trans('installer_messages.environment.wizard.form.app_client_placeholder') }}" />
                            @if ($errors->has('app_client'))<span class="error-block">{{ $errors->first('app_client') }}</span>@endif
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group {{ $errors->has('app_license') ? ' has-error ' : '' }} {{ $errors->has('license') ? ' has-error ' : '' }}">
                            <label for="app_license">{{ trans('installer_messages.environment.wizard.form.app_license_label') }}</label>
                            <input type="text" name="app_license" id="app_license" class="form-control" value="{{old('app_license')}}" placeholder="{{ trans('installer_messages.environment.wizard.form.app_license_placeholder') }}" />
                            @if ($errors->has('app_license'))<span class="error-block">{{ $errors->first('app_license') }}</span>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12 option-more d-none">
                        <div class="form-group {{ $errors->has('database_connection') ? ' has-error ' : '' }}">
                            <label for="database_connection">{{ trans('installer_messages.environment.wizard.form.db_connection_label') }}</label>
                            <select name="database_connection" class="form-select" id="database_connection">
                                <option value="mysql" selected>{{ trans('installer_messages.environment.wizard.form.db_connection_label_mysql') }}</option>
                                <option value="sqlite">{{ trans('installer_messages.environment.wizard.form.db_connection_label_sqlite') }}</option>
                                <option value="pgsql">{{ trans('installer_messages.environment.wizard.form.db_connection_label_pgsql') }}</option>
                                <option value="sqlsrv">{{ trans('installer_messages.environment.wizard.form.db_connection_label_sqlsrv') }}</option>
                            </select>
                            @if ($errors->has('database_connection'))<span class="error-block">{{ $errors->first('database_connection') }}</span>@endif
                        </div>
                    </div>
                    <div class="col-md-6 col-12 option-more d-none">
                        <div class="form-group {{ $errors->has('database_hostname') ? ' has-error ' : '' }}">
                            <label for="database_hostname">{{ trans('installer_messages.environment.wizard.form.db_host_label') }}</label>
                            <input type="text" name="database_hostname" id="database_hostname" class="form-control" @if(old('database_hostname'))value="{{old('database_hostname')}}"@else value="127.0.0.1" @endif placeholder="{{ trans('installer_messages.environment.wizard.form.db_host_placeholder') }}" />
                            @if ($errors->has('database_hostname'))<span class="error-block">{{ $errors->first('database_hostname') }}</span>@endif
                        </div>
                    </div>
                    <div class="col-md-6 col-12 option-more d-none">
                        <div class="form-group {{ $errors->has('database_port') ? ' has-error ' : '' }}">
                            <label for="database_port">{{ trans('installer_messages.environment.wizard.form.db_port_label') }}</label>
                            <input type="number" name="database_port" id="database_port" class="form-control" @if(old('database_port'))value="{{old('database_port')}}"@else value="3306" @endif placeholder="{{ trans('installer_messages.environment.wizard.form.db_port_placeholder') }}" />
                            @if ($errors->has('database_port'))
                                <span class="error-block">
                                    {{ $errors->first('database_port') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group {{ $errors->has('database_name') ? ' has-error ' : '' }}">
                            <label for="database_name">{{ trans('installer_messages.environment.wizard.form.db_name_label') }}</label>
                            <input type="text" name="database_name" id="database_name" class="form-control" value="{{old('database_name')}}" placeholder="{{ trans('installer_messages.environment.wizard.form.db_name_placeholder') }}" />
                            @if ($errors->has('database_name'))<span class="error-block">{{ $errors->first('database_name') }}</span>@endif
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group {{ $errors->has('database_username') ? ' has-error ' : '' }}">
                            <label for="database_username">{{ trans('installer_messages.environment.wizard.form.db_username_label') }}</label>
                            <input type="text" name="database_username" id="database_username" class="form-control" value="{{old('database_username')}}" placeholder="{{ trans('installer_messages.environment.wizard.form.db_username_placeholder') }}" />
                            @if ($errors->has('database_username'))<span class="error-block">{{ $errors->first('database_username') }}</span>@endif
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group {{ $errors->has('database_password') ? ' has-error ' : '' }}">
                            <label for="database_password">{{ trans('installer_messages.environment.wizard.form.db_password_label') }}</label>
                            <input type="text" name="database_password" id="database_password" class="form-control" value="{{old('database_password')}}" placeholder="{{ trans('installer_messages.environment.wizard.form.db_password_placeholder') }}" />
                            @if ($errors->has('database_password'))<span class="error-block">{{ $errors->first('database_password') }}</span>@endif
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group {{ $errors->has('database_table_prefix') ? ' has-error ' : '' }}">
                            <label for="table_prefix">{{ trans('installer_messages.environment.wizard.form.table_prefix_label') }}</label>
                            <input type="text" name="table_prefix" id="table_prefix" class="form-control" value="{{old('table_prefix')}}" placeholder="{{ trans('installer_messages.environment.wizard.form.table_prefix_placeholder') }}" />
                            @if ($errors->has('table_prefix'))<span class="error-block">{{ $errors->first('table_prefix') }}</span>@endif
                        </div>
                    </div>
                </div>
                <div class="mt-3 mb-3">
                    <a href="javascript:void(0)" class="show-more-options">{{ trans('installer_messages.environment.wizard.form.show_more') }}</a>
                    <a href="javascript:void(0)" class="hide-more-options d-none">{{ trans('installer_messages.environment.wizard.form.hide_more') }}</a>
                </div>
                <div class="buttons">
                    <button class="button" type="submit">{{ trans('installer_messages.environment.wizard.form.buttons.install') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
<script>
(function ($) {
    "use strict";
    $('.show-more-options').on('click', function(){
        $(this).addClass('d-none');
        $('.hide-more-options').removeClass('d-none');
        $('.option-more').removeClass('d-none');
    });
    $('.hide-more-options').on('click', function(){
        $(this).addClass('d-none');
        $('.show-more-options').removeClass('d-none');
        $('.option-more').addClass('d-none');
    });
})(jQuery);
</script>
@endsection