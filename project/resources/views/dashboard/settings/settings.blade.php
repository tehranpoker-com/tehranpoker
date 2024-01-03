@extends('dashboard.layouts.master')
@section('content')
<div class="page-title-box d-flex align-items-center justify-content-between">
    <h4 class="mb-0 font-size-18">{{ $page_title }}</h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ get_admin_url('/') }}">{{ admin_lang('dashboard') }}</a></li>
            <li class="breadcrumb-item active">{{ $page_title }}</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>{!! session()->get('success') !!}</div>
        @endif
        @if(session()->has('warning'))
        <div class="alert alert-warning alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>{!! session()->get('warning') !!}</div>
        @endif
    </div>
</div>
<div class="megapanel-panel">
    <div class="panel-wrapper">
        <form method="POST" action="{{ get_admin_url('SettingsSendForm') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="megapanel-main">
                <div id="megapanel-editor" class="megapanel-jqcheckbox">
                    <div class="megapanel-wrapper">
                        <header class="megapanel-page-header">
                            <h1>{{ admin_lang('settings') }}</h1>
                            <div class="megapanel-submit"><button class="btn btn-primary"><i class="fa fa-save"></i> {{admin_lang('save_changes')}}</button></div>
                        </header>
                        <div class="megapanel-tabs-container megapanel-container">
                            <div class="megapanel-tabs nav-tabs-cookie" data-cookie="megapanel">
                                @foreach ($menus as $key => $item)
                                <a href="#" data-tab=".option-{{$key}}"><i class="{{$item['icon']}}"></i> {{$item['title']}}</a>
                                @endforeach
                                @action('admin_options_menu')
                            </div>
                            <div class="megapanel-tabs-content">
                                @foreach($settings as $key => $value)                
                                <div class="megapanel-tab-content option-{{$key}}">
                                    @foreach($value as $k => $v)
                                        {!!fields_start_options($v['title'])!!}
                                        @foreach($v['options'] as $option)
                                            @if(is_array($option))
                                                {!!field_options_item($option)!!}
                                            @endif
                                        @endforeach
                                        {!!fields_end_options()!!}
                                    @endforeach
                                </div>
                                @endforeach
                                @action('admin_options_content')                                
                                <footer class="megapanel-page-footer megapanel-submit"><button class="btn btn-primary"><i class="fa fa-save"></i> {{admin_lang('save_changes')}}</button></footer>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('style_files')
<link rel="stylesheet" href="{{ asset('libs/datepicker/datepicker.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('libs/timepicker/timepicker.min.css') }}" type="text/css" />
<link href="{{ asset('libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" href="{{ asset('libs/spectrum/spectrum.min.css') }}" type="text/css" />
<link href="{{ asset('libs/megapanel/megapanel_options.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/tacf/tacf.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('libs/jplayer/jplayer.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('head_script')
<script src="{{ asset('libs/jplayer/jquery.jplayer.min.js') }}"></script>
<script src="{{ asset('libs/jplayer/jplayer.js') }}"></script>
@endsection
@section('script_files')
<script src="{{ asset('libs/datepicker/datepicker.min.js') }}"></script>
<script src="{{ asset('libs/timepicker/timepicker.min.js') }}"></script>
<script src="{{ asset('dashboard/js/jquery.cookie.js') }}"></script>
<script src="{{ asset('dashboard/js/jquery-ui.js') }}"></script>
<script src="{{ asset('libs/spectrum/spectrum.min.js') }}"></script>
<script src="{{ asset('libs/megapanel/megapanel_options.min.js') }}"></script>
<script src="{{ asset('libs/tacf/tacf.min.js') }}"></script>
<script src="{{ asset('libs/select2/select2.min.js') }}"></script>
<script type="text/javascript">
(function($) {
    "use strict";
    $(".select2").select2();
    $(".timepicker").each(function(){
        $(this).timepicker({icons:{up:"bx bx-chevron-up",down:"bx bx-chevron-down"},appendWidgetTo:"#timepicker-input-group-"+$(this).data('key')});
    });
    $(".colorpicker").spectrum({allowEmpty: false,showAlpha: false});
})(jQuery);
</script>
@endsection