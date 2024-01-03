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
                            <div class="text-primary p-4">
                                <h5 class="text-primary">{{ get_option('sitename') }}</h5>
                                <p>{{ admin_lang('signin_continue_dashboard') }}</p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="{{ asset('dashboard/images/cover-profile.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body signin-form-wrap">
                    <a href="{{url('/')}}" class="linkhome">
                        <div class="home-icon-wid mb-4">
                            <span class="home-icon rounded-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="24"><path fill="currentColor" d="M541 229.16l-61-49.83v-77.4a6 6 0 0 0-6-6h-20a6 6 0 0 0-6 6v51.33L308.19 39.14a32.16 32.16 0 0 0-40.38 0L35 229.16a8 8 0 0 0-1.16 11.24l10.1 12.41a8 8 0 0 0 11.2 1.19L96 220.62v243a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16v-128l64 .3V464a16 16 0 0 0 16 16l128-.33a16 16 0 0 0 16-16V220.62L520.86 254a8 8 0 0 0 11.25-1.16l10.1-12.41a8 8 0 0 0-1.21-11.27zm-93.11 218.59h.1l-96 .3V319.88a16.05 16.05 0 0 0-15.95-16l-96-.27a16 16 0 0 0-16.05 16v128.14H128V194.51L288 63.94l160 130.57z" class=""></path></svg>
                            </span>
                        </div>
                    </a>
                    <br />
                    @if(session()->has('errorlogin'))<div class="alert alert-warning">{{ admin_lang('error_login') }}</div>@endif
                    @if($errors->any())
                        <div class="alert alert-warning">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ get_admin_url('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" class="form-control" name="email" id="useremail" placeholder="{{ admin_lang('enter_email') }}" value="{{ old('email_address') }}">
                            <div class="form-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M464 64H48C21.5 64 0 85.5 0 112v288c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zM48 96h416c8.8 0 16 7.2 16 16v41.4c-21.9 18.5-53.2 44-150.6 121.3-16.9 13.4-50.2 45.7-73.4 45.3-23.2.4-56.6-31.9-73.4-45.3C85.2 197.4 53.9 171.9 32 153.4V112c0-8.8 7.2-16 16-16zm416 320H48c-8.8 0-16-7.2-16-16V195c22.8 18.7 58.8 47.6 130.7 104.7 20.5 16.4 56.7 52.5 93.3 52.3 36.4.3 72.3-35.5 93.3-52.3 71.9-57.1 107.9-86 130.7-104.7v205c0 8.8-7.2 16-16 16z" class=""></path></svg></div>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" id="userpassword" placeholder="{{ admin_lang('enter_password') }}" value="{{ old('password') }}">
                            <div class="form-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M48 480a16 16 0 0 1-16-16v-41.6A102.47 102.47 0 0 1 134.4 320c19.6 0 39.1 16 89.6 16s70-16 89.6-16c2.7 0 5.3.6 7.9.8a79.45 79.45 0 0 1 13.1-30.7 132.34 132.34 0 0 0-21.1-2.1c-28.7 0-42.5 16-89.6 16s-60.8-16-89.6-16C60.2 288 0 348.2 0 422.4V464a48 48 0 0 0 48 48h288.4a78.34 78.34 0 0 1-14.8-32zm176-224A128 128 0 1 0 96 128a128 128 0 0 0 128 128zm0-224a96 96 0 1 1-96 96 96.15 96.15 0 0 1 96-96zm272 336a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm96-80h-16v-48a80 80 0 0 0-160 0v48h-16a48 48 0 0 0-48 48v128a48 48 0 0 0 48 48h192a48 48 0 0 0 48-48V336a48 48 0 0 0-48-48zm-144-48a48 48 0 0 1 96 0v48h-96zm160 224a16 16 0 0 1-16 16H400a16 16 0 0 1-16-16V336a16 16 0 0 1 16-16h192a16 16 0 0 1 16 16z" class=""></path></svg></div>
                        </div>
                        @if(get_option('confirm_pincode'))
                        <div class="form-group">
                            <input type="password" class="form-control" name="pincode" id="userpincode" placeholder="{{ admin_lang('enter_pincode') }}" value="{{ old('pincode') }}">
                            <div class="form-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M622.3 271.1l-115.2-45c-3.5-1.4-7.3-2.1-11.1-2.1s-7.5.7-11.1 2.1l-115.2 45c-10.7 4.2-17.7 14-17.7 24.9 0 111.6 68.7 188.8 132.9 213.9 3.5 1.4 7.3 2.1 11.1 2.1s7.5-.7 11.1-2.1C558.4 489.9 640 420.5 640 296c0-10.9-7-20.7-17.7-24.9zM480 472c-48.2-26.8-94.6-87.6-96-172.1l96-37.5V472zm16.6 8.1c-.1 0-.2-.1-.2-.1h.5c-.2 0-.3.1-.3.1zm15.4-7.6V262.4l96 37.5c-1.5 94.8-57.1 150.2-96 172.6zM48 480c-8.8 0-16-7.2-16-16v-41.6C32 365.9 77.9 320 134.4 320c19.6 0 39.1 16 89.6 16 50.4 0 70-16 89.6-16 2.6 0 5 .6 7.5.8-.7-8.1-1.1-16.3-1.1-24.8 0-2.5.8-4.8 1.1-7.2-2.5-.1-4.9-.8-7.5-.8-28.7 0-42.5 16-89.6 16-47.1 0-60.8-16-89.6-16C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c6.8 0 13.3-1.5 19.2-4-10.3-8.2-20.2-17.6-29.7-28H48zm176-224c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm0-224c52.9 0 96 43.1 96 96s-43.1 96-96 96-96-43.1-96-96 43.1-96 96-96z" class=""></path></svg></div>
                        </div>
                        @endif
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="remember" value="1" id="remember_me" checked>
                            <label class="form-check-label" for="remember_me">{{ admin_lang('remember_me') }}</label>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-primary btn-block" type="submit">{{ admin_lang('login') }}</button>
                        </div>
                    </form>
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