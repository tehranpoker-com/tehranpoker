<!DOCTYPE html>
<html lang="{{$admin_lang}}" dir="{{$admin_dir}}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ get_option('sitename') }} - {{ (isset($page_title))? $page_title : '' }}</title>
    <link rel="icon" href="{{ get_asset('images/favicon.png') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    @if($admin_dir == 'rtl')<link href="{{ asset('dashboard/css/bootstrap-rtl.min.css') }}" rel="stylesheet" type="text/css" />@else<link href="{{ asset('dashboard/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />@endif
    <link rel="stylesheet" href="{{ asset('dashboard/css/login.min.css') }}" type="text/css" />
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="signin {{$admin_dir}}">
<div class="container padding_60">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card overflow-hidden">
                <div class="bg-cover">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary head-login p-4">
                                <h5 class="text-primary">{{ get_option('sitename') }}</h5>
                                <p>{{admin_lang('please_confirm_your_pin')}}</p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="{{ asset('dashboard/images/cover-profile.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body signin-form-wrap pt-0"> 
                    <div class="p-2">
                        <form method="POST" action="{{ route('pincode.confirm') }}">
                            @csrf
                            <div class="user-thumb text-center mb-4">
                                <img src="{{get_user_avatar(auth()->user()->id)}}" class="rounded-circle img-thumbnail avatar-md" alt="thumbnail">
                                <h5 class="font-size-12 mt-3">{{auth()->user()->username}}</h5>
                            </div>
                            @if($errors->any())
                                <div class="alert alert-warning">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="form-group">
                                <input type="password" class="form-control @if($errors->has('pincode')) input-error @endif" name="pincode" id="userpincode" placeholder="{{ admin_lang('enter_pincode') }}" value="{{ old('pincode') }}">
                                <div class="form-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M622.3 271.1l-115.2-45c-3.5-1.4-7.3-2.1-11.1-2.1s-7.5.7-11.1 2.1l-115.2 45c-10.7 4.2-17.7 14-17.7 24.9 0 111.6 68.7 188.8 132.9 213.9 3.5 1.4 7.3 2.1 11.1 2.1s7.5-.7 11.1-2.1C558.4 489.9 640 420.5 640 296c0-10.9-7-20.7-17.7-24.9zM480 472c-48.2-26.8-94.6-87.6-96-172.1l96-37.5V472zm16.6 8.1c-.1 0-.2-.1-.2-.1h.5c-.2 0-.3.1-.3.1zm15.4-7.6V262.4l96 37.5c-1.5 94.8-57.1 150.2-96 172.6zM48 480c-8.8 0-16-7.2-16-16v-41.6C32 365.9 77.9 320 134.4 320c19.6 0 39.1 16 89.6 16 50.4 0 70-16 89.6-16 2.6 0 5 .6 7.5.8-.7-8.1-1.1-16.3-1.1-24.8 0-2.5.8-4.8 1.1-7.2-2.5-.1-4.9-.8-7.5-.8-28.7 0-42.5 16-89.6 16-47.1 0-60.8-16-89.6-16C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c6.8 0 13.3-1.5 19.2-4-10.3-8.2-20.2-17.6-29.7-28H48zm176-224c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm0-224c52.9 0 96 43.1 96 96s-43.1 96-96 96-96-43.1-96-96 43.1-96 96-96z" class=""></path></svg></div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-12 text-right">
                                    <button class="btn btn-primary btn-block" type="submit">{{admin_lang('confirm')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mt-3 text-center">
                <p>Copyright © 2021. Development of <a href="https://themearabia.net">themearabia.net</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>