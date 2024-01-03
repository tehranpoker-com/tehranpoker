@extends('dashboard.layouts.master')
@section('content')
<div class="page-title-box d-flex align-items-center justify-content-between">
    <h4 class="mb-0 font-size-18">{{admin_lang('profile')}} :: {{ $user->username }}</h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ get_admin_url('/') }}">{{ admin_lang('dashboard') }}</a></li>
            <li class="breadcrumb-item active">{{ admin_lang('profile') }}</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden">
            <div class="bg-soft-primary bg-soft-usercover">
                <div class="row">
                    <div class="col-12">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">{{ $user->username }}</h5>
                            <p>{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="avatar-md profile-user-wid mb-4">
                            <img src="{{ get_user_avatar($user->id) }}" alt="" class="img-thumbnail rounded-circle">
                        </div>
                        <h5 class="font-size-15 text-truncate">{{ $user->username }}</h5>
                        <p class="text-muted mb-0 text-truncate">
                            @if($user->userlevel == 'admin')
                            <span class="badge badge-pill bg-danger">{{admin_lang('userlevel_'.$user->userlevel)}}</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="account_info">
                    <div class="account_info-group"><label>{{admin_lang('username')}}:</label> {{ $user->username }}</div>
                    <div class="account_info-group"><label>{{admin_lang('email')}}:</label> <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></div>
                    <div class="account_info-group"><label>{{admin_lang('created')}}:</label> {{ $user->created_at }}</div>
                    <div class="account_info-group"><label>{{admin_lang('updated')}}:</label> {{ $user->updated_at }}</div>
                    <div class="account_info-group"><label>{{admin_lang('last_seen')}}:</label> @if($signintime){{date('d/m/Y H:i:s', $signintime)}}@else{{admin_lang('none')}}@endif</div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>{!! session()->get('success') !!}</div>
@endif
@if($errors->any())
<div class="alert alert-danger">
    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif
@action('admin_user_profile_before_container', $user)
<div class="tacf-box-container">
    <div class="tacf-box-tabs nav-tabs-cookie" data-cookie="profile_user" data-cookie-tab="tab-details">
        <a href="#" class="active" data-tab=".tab-details"><i class="bx bx-file"></i> {{ admin_lang('details') }}</a>
        <a href="#" class="" data-tab=".tab-edit"><i class="bx bx-pencil"></i> {{admin_lang('edit')}}</a>
    </div>
    <div class="tacf-tabs-content">
        <div class="tacf-tab-content tab-details p-0 active">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>{{admin_lang('id')}}:</strong> #{{$user->id}}</li>
                <li class="list-group-item"><strong>{{admin_lang('username')}}:</strong> {{ $user->username }}</li>
                <li class="list-group-item"><strong>{{admin_lang('email')}}:</strong> <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></li>
                <li class="list-group-item"><strong>{{admin_lang('role')}}:</strong> @if($user->userlevel == 'admin')<span class="badge badge-pill bg-danger">{{admin_lang('userlevel_'.$user->userlevel)}}</span>@else<span class="badge badge-pill bg-info">{{admin_lang('userlevel_'.$user->userlevel)}}</span>@endif</li>
                @action('admin_user_profile_details', $user)
                <li class="list-group-item"><strong>{{admin_lang('created')}}:</strong> {{ $user->created_at }}</li>
                <li class="list-group-item"><strong>{{admin_lang('updated')}}:</strong> {{ $user->updated_at }}</li>
                <li class="list-group-item"><strong>{{admin_lang('last_seen')}}:</strong> @if($signintime){{date('d/m/Y H:i:s', $signintime)}}@else{{admin_lang('none')}}@endif</li>
                <li class="list-group-item"><strong>{{admin_lang('ip')}}:</strong> <a href="{{get_admin_url('users/platform/'.$details['ip'])}}">{{$details['ip']}}</a></li>
                <li class="list-group-item"><strong>{{admin_lang('useragent')}}:</strong> {{$details['useragent']}}</li>
                <li class="list-group-item"><strong>{{admin_lang('platformname')}}:</strong> <a href="{{get_admin_url('users/platform/'.$details['platformname'])}}">{{$details['platformname']}}</a></li>
                <li class="list-group-item"><strong>{{admin_lang('browserfamily')}}:</strong> <a href="{{get_admin_url('users/browser/'.$details['browserfamily'])}}">{{$details['browserfamily']}}</a></li>
            </ul>
        </div>
        <div class="tacf-tab-content tab-edit">
            <form method="POST" action="{{ get_admin_url('UsersSendForm') }}" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="card-title"><i class="bx bx-id-card"></i> {{admin_lang('personal_data')}}</h4>
                        <hr />
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label for="username">{{admin_lang('username')}}</label>
                                    <div class="frm-input">
                                        <input class="form-control" name="username" type="text" id="username" value="@if(old('username')){{old('username')}}@else{{$username}}@endif" placeholder="{{admin_lang('username')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label for="email">{{admin_lang('email')}}</label>
                                    <div class="frm-input">
                                        <input class="form-control" name="email" type="email" id="email" value="@if(old('email')){{old('email')}}@else{{$email}}@endif" placeholder="{{admin_lang('email')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="card-title"><i class="bx bx-lock-alt"></i> {{admin_lang('password')}} <small>{{admin_lang('leave_field_change')}}</small></h4>
                        <hr />
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label for="password">{{admin_lang('password')}}</label>
                                    <div class="input-group">
                                        <input class="form-control" name="password" type="password" id="password" value="{{old('password')}}" placeholder="{{admin_lang('password')}}">
                                        <span class="input-group-text"><i class="bx bx-lock"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label for="pincode">{{admin_lang('pincode')}}</label>
                                    <div class="input-group">
                                        <input class="form-control" name="pincode" type="password" id="pincode" value="{{old('pincode')}}" placeholder="{{admin_lang('pincode')}}">
                                        <span class="input-group-text"><i class="bx bx-dialpad"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary"><span></span> {{admin_lang('update')}} </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('style_files')
<link href="{{ asset('libs/tacf/tacf.min.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('script_files')
<script src="{{ asset('libs/tacf/tacf.min.js') }}"></script>
@endsection