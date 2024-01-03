@extends('vendor.installer.layouts.master')
@section('template_title')
    {{ trans('installer_messages.final.templateTitle') }}
@endsection
@section('title')
    {{ trans('installer_messages.final.title') }}
@endsection
@section('container')
	<div class="alert alert-success">{{ trans('installer_messages.administrator.success_message') }}</div>
	<br />
    <div class="buttons">
        <a href="{{ url('/') }}" class="button">{{ trans('installer_messages.final.website') }}</a>
        <a href="{{ get_admin_url('/') }}" class="button">{{ trans('installer_messages.final.dashboard') }}</a>
    </div>
@endsection
