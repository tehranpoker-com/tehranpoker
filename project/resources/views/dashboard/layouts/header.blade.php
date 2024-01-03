
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <div class="navbar-brand-box">
                <a href="{{ get_admin_url('/') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('dashboard/images/logo-xs.png') }}" alt="{{ get_option('sitename') }}" />
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('dashboard/images/logo.png') }}" alt="{{ get_option('sitename') }}" />
                    </span>
                </a>
            </div>
            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect ml-2" id="vertical-menu-btn"><i class="fa fa-fw fa-bars"></i></button>
            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" onclick="window.open('{{url('/')}}','_blank')" title="{{admin_lang('visit_site')}}"><i class="fa fa-fw fa-home"></i></button>
            @if(get_option('maintenance_status'))
            <button type="button" class="btn btn-sm px-3 font-size-12 header-item ml-2 red"><i class="bx bx-power-off"></i> {{admin_lang('maintenance')}}</button>
            @endif
        </div>
        <div class="d-flex">
            @yield('navbar_header')
            @action('admin_navbar_header')
        </div>
        <div class="d-flex">
            @action('admin_navbar_header_end')
            @if(version_compare(SCRIPT_VERSION, get_option('script_version', '1.0')) >= 1)
            <button type="button" onclick="window.open('{{url('/update')}}')" class="btn header-item noti-icon btn-info text-white waves-effect">
                <i class="fas fa-cog bx-spin text-white"></i> {{ admin_lang('update') }} ({{SCRIPT_VERSION}})
            </button>
            @endif
            @php $messages = get_messages_count('contactus');@endphp
            @if($messages)
            <div class="d-none d-lg-inline-block">
                <a class="btn header-item noti-icon waves-effect show pt-3" href="{{get_admin_url('messages/contactus')}}">
                    <i class="bx bx-envelope bx-tada"></i>
                    <span class="badge bg-danger rounded-pill mt-3">{{$messages}}</span>
                </a>
            </div>
            @endif

            @php $appointments = get_messages_count('appointments');@endphp
            @if($appointments)
            <div class="d-none d-lg-inline-block">
                <a class="btn header-item noti-icon waves-effect show pt-3" href="{{get_admin_url('messages/appointments')}}">
                    <i class="bx bx-calendar bx-tada"></i>
                    <span class="badge bg-danger rounded-pill mt-3">{{$appointments}}</span>
                </a>
            </div>
            @endif

            
            
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{get_user_avatar(Auth::user()->id)}}" alt="{{ Auth::user()->username }}">
                    <span class="d-none d-xl-inline-block ml-1">{{ Auth::user()->username }}</span>
                    <i class="bx bx-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ get_admin_url('profile') }}"><i class="bx bx-user font-size-16 align-middle mr-1"></i> {{ admin_lang('profile') }}</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> {{ admin_lang('logout') }}
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">{{ csrf_field() }}</form>
                    </a>
                </div>
            </div>
            <div class="dropdown d-none d-lg-inline-block ml-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen"><i class="bx bx-fullscreen"></i></button>
            </div>
        </div>
    </div>
</header>