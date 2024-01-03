@extends('vendor.installer.layouts.master-license')
@section('title'){!!$head_title!!}@endsection
@section('container')
    <div class="tabs tabs-full">
        <form method="post" action="{{ route('LaravelInstaller::activatorWizard') }}" class="tabs-wrap">
            <div>
                @if($errors->has('license'))
                <div class="alert alert-danger" id="error_alert">{!!$errors->first('license')!!}</div>
                @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group {{ $errors->has('app_client') ? ' has-error ' : '' }} {{ $errors->has('license') ? ' has-error ' : '' }}">
                    <label for="app_client">{{ trans('installer_messages.environment.wizard.form.app_client_label') }}</label>
                    <input type="text" name="app_client" id="app_client" class="form-control" value="{{old('app_client')}}" placeholder="{{ trans('installer_messages.environment.wizard.form.app_client_placeholder') }}" />
                    @if ($errors->has('app_client'))<span class="error-block">{{ $errors->first('app_client') }}</span>@endif
                </div>
                <div class="form-group {{ $errors->has('app_license') ? ' has-error ' : '' }} {{ $errors->has('license') ? ' has-error ' : '' }}">
                    <label for="app_license">{{ trans('installer_messages.environment.wizard.form.app_license_label') }}</label>
                    <input type="text" name="app_license" id="app_license" class="form-control" value="{{old('app_license')}}" placeholder="{{ trans('installer_messages.environment.wizard.form.app_license_placeholder') }}" />
                    @if ($errors->has('app_license'))<span class="error-block">{{ $errors->first('app_license') }}</span>@endif
                </div>
                <div class="buttons">
                    <button class="button" type="submit">Activate</button>
                </div>
            </div>
        </form>
    </div>
@endsection