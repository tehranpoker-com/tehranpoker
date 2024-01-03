<!DOCTYPE html>
<html lang="{{$admin_lang}}" dir="{{$admin_dir}}">
<head>
    <meta charset="utf-8" />
    <title>{{ get_option('sitename') }} - {{ (isset($page_title))? $page_title : '' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ get_option_img('favicon', asset('images/favicon.png')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('dashboard/css/animate.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dashboard/css/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
    @if($admin_dir == 'rtl')<link href="{{ asset('dashboard/css/bootstrap-rtl.min.css') }}" rel="stylesheet" type="text/css" />@else<link href="{{ asset('dashboard/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />@endif
    <link href="{{ asset('libs/fonticons/fontawesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/fonticons/boxicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/fonticons/fonticons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/cupload/js/thickbox/thickbox.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/megaupload/megaupload.min.css') }}" rel="stylesheet" type="text/css" />
    @yield('style_files')
    @if($admin_dir == 'rtl')
    <link href="{{ asset('dashboard/css/app-rtl.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('dashboard/css/style-rtl.min.css') }}" rel="stylesheet" type="text/css">
    @action('admin_style_rtl')
    @else
    <link href="{{ asset('dashboard/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('dashboard/css/style.min.css') }}" rel="stylesheet" type="text/css">
    @action('admin_style')
    @endif
    @yield('head_style')
    @action('admin_head')
    <script type="text/javascript">
        var media_upload_url = '{{ get_admin_url('medialibrary') }}',
        admin_ajax_url = '{{ get_admin_url('adminajax') }}',
        tb_pathToImage = "{{ asset('libs/cupload/js/thickbox/loadingAnimation.gif') }}",
        tb_closeImage  = "{{ asset('libs/cupload/js/thickbox/tb-close.png') }}",
        actionselect = true,
        is_rtl = @if($admin_dir == 'rtl') true @else false @endif, 
        ajax_admin_request = '{{ get_admin_url('ajaxadminrequest') }}', 
        delete_confirm_text = '{{admin_lang('delete_confirm')}}';
    </script>
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/jquery-migrate-3.0.0.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('dashboard/js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('dashboard/js/bootstrap.bundle.min.js') }}"></script>
    @yield('head_script')
</head>
<body class="{{$admin_dir}}" @if(get_option('admin_mode', 'light'))data-sidebar="dark"@endif>
    <div id="layout-wrapper">
        @include('dashboard.layouts.header')
        @include('dashboard.layouts.menu')
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">@yield('content')</div>
            </div>
            @include('dashboard.layouts.footer')
        </div>
    </div>
    <div class="modal fade modal-confirm-delete" id="confirm-delete" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">{{admin_lang('confirm_delete')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{admin_lang('cancel')}}</button>
                    <a class="btn btn-danger btn-confirmdelete">{{admin_lang('confirm')}}</a>
                </div>
            </div>
        </div>
    </div> 
    <script src="{{ asset('dashboard/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/waves.min.js') }}"></script>
    <script src="{{ asset('libs/megaupload/megaupload.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/app.js') }}"></script>
    <script src="{{ asset('dashboard/js/admin.min.js') }}"></script>
    <script src="{{ asset('libs/cupload/js/thickbox/thickbox.min.js') }}"></script>
    @yield('admin_script')
    @action('admin_script')
    <script>
    (function($) {
        "use strict";
        $("table th input:checkbox").on("click", function() {
            var that = this;
            $(this).closest("table").find("tr > td:first-child input:checkbox").each(function() {
                this.checked = that.checked;
                $(this).closest("tr").toggleClass("selected");
            });
        });
        $('#confirm-delete').on('shown.bs.modal', function(e) {
            $(this).find('.modal-body').html($(e.relatedTarget).data('body'));
            $(this).find('.btn-confirmdelete').attr('href', $(e.relatedTarget).data('href'));
        });
        $('[rel="tooltip"]').tooltip({trigger: "hover"});
    })(jQuery);
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    </script>
    @action('admin_script_code')
    @yield('script_files')
    @yield('script_code')
    @yield('footer') 
    @action('admin_footer')
    <div class="tacf-overlay"></div>
    <div id="tacf-modal" class="tacf-modal">
        <div class="tacf-modal-head">
            <h3></h3>
            <a href="javascript:void(0);" data-action="tacf-modal-close" class="tacf-modal-close"><i class="bx bx-x"></i></a>
        </div>
        <div class="tacf-modal-search"><input type="text" placeholder="{{admin_lang('search')}}" class="tacf-search-input" /></div>
        <div class="tacf-modal-body"></div>
    </div>
    <div class="modal fade modal-confirm-delete" id="confirmation-delete" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">{{admin_lang('confirm_delete')}}</h5>
                    <button type="button" value="false" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" value="false">{{admin_lang('cancel')}}</button>
                    <button type="button" class="btn btn-danger btn-confirmdelete" data-bs-dismiss="modal" value="true">{{admin_lang('confirm')}}</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>