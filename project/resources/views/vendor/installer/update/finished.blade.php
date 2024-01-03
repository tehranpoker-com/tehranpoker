@extends('vendor.installer.layouts.master-update')

@section('title', trans('installer_messages.updater.final.title'))
@section('container')
    <p class="paragraph text-center">{{ trans('installer_messages.updater.final.finished') }}</p>
    <div class="buttons">
        <a href="{{ get_admin_url('/') }}" class="button">{{ trans('installer_messages.updater.final.exit') }}</a>
    </div>
@stop
