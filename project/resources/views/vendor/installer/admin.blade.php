@extends('vendor.installer.layouts.master')
@section('template_title')
    {{ trans('installer_messages.admin.wizard.templateTitle') }}
@endsection
@section('title')
    {!! trans('installer_messages.admin.wizard.title') !!}
@endsection
@section('container')
    <div class="tabs tabs-admin">
        @if (session('message'))
            <div class="alert alert-success text-center">
                @if(is_array(session('message')))
                    {{ session('message')['message'] }}
                @else
                    {{ session('message') }}
                @endif
            </div>
        @endif
        <form method="post" action="{{ route('LaravelInstaller::adminSaveWizard') }}" class="tabs-wrap">
            <div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group {{ $errors->has('admin_username') ? ' has-error ' : '' }}">
                            <label for="admin_username">{{ trans('installer_messages.admin.wizard.form.admin_username_label') }}</label>
                            <input type="text" name="admin_username" id="admin_username" class="form-control" value="{{old('admin_username')}}" placeholder="{{ trans('installer_messages.admin.wizard.form.admin_username_placeholder') }}" />
                            @if ($errors->has('admin_username'))<span class="error-block">{{ $errors->first('admin_username') }}</span>@endif
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group {{ $errors->has('admin_email') ? ' has-error ' : '' }}">
                            <label for="admin_email">{{ trans('installer_messages.admin.wizard.form.admin_email_label') }}</label>
                            <input type="email" name="admin_email" id="admin_email" class="form-control" value="{{old('admin_email')}}" placeholder="{{ trans('installer_messages.admin.wizard.form.admin_email_placeholder') }}" />
                            @if ($errors->has('admin_email'))<span class="error-block">{{ $errors->first('admin_email') }}</span>@endif
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group {{ $errors->has('admin_password') ? ' has-error ' : '' }}">
                            <label for="admin_password">{{ trans('installer_messages.admin.wizard.form.admin_password_label') }}</label>
                            <input type="password" name="admin_password" id="admin_password" class="form-control" value="{{old('admin_password')}}" placeholder="{{ trans('installer_messages.admin.wizard.form.admin_password_placeholder') }}" />
                            @if ($errors->has('admin_password'))<span class="error-block">{{ $errors->first('admin_password') }}</span>@endif
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group {{ $errors->has('admin_pincode') ? ' has-error ' : '' }}">
                            <label for="admin_pincode">{{ trans('installer_messages.admin.wizard.form.admin_pincode_label') }}</label>
                            <input type="password" name="admin_pincode" id="admin_pincode" class="form-control" value="{{old('admin_pincode')}}" placeholder="{{ trans('installer_messages.admin.wizard.form.admin_pincode_placeholder') }}" />
                            @if ($errors->has('admin_pincode'))<span class="error-block">{{ $errors->first('admin_pincode') }}</span>@endif
                        </div>
                    </div>
                </div>
                <div class="buttons">
                    <button class="button" type="submit">{{ trans('installer_messages.admin.wizard.form.buttons.submit') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
