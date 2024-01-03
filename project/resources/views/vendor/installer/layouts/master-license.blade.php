<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@if (trim($__env->yieldContent('template_title')))@yield('template_title') | @endif {{ trans('installer_messages.title') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
        <link href="{{ asset('installer/style.css') }}" rel="stylesheet"/>
    </head>
    <body>
        <div class="master">
            <div class="box">
                <div class="header">
                    <img src="{{ asset('images/logo.png') }}" class="width200" />
                </div>
                <h1 class="header__title2">@yield('title')</h1>
                <div class="main main-license">
                    @yield('container')
                </div>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
