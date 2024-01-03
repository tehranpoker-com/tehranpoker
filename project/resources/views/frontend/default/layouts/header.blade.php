<header class="header">
    <div class="profile-picture">
        <div class="profile-avatar">
            <img src="{{has_option('sidebar', 'avatar', get_asset('images/avatar.jpg'))}}" alt="{{get_option('sitename')}}" />
            <span class="dot"></span>
        </div>
        @if(is_user_admin() and has_option('sidebar', 'admin_status'))
        <a href="{{get_admin_url('/')}}" class="link-admin" title="{{lang('admin')}}"><i class="bx bx-slider"></i></a>
        @endif
    </div>
    @if(has_option('sidebar', 'music_status'))
    <a href="javascript:void(0)" class="bg-music">
        <div class="music-eq">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </a>
    <audio id="audio-player" src="{{has_option('sidebar', 'music')}}" preload="auto"></audio>
    @endif
    <div class="header-content">
        <div class="site-nav">
            <ul class="header-main-menu" id="header-main-menu">
                @foreach (has_option('sidebar_menu') as $key => $item)
                @if(isset($item['status']) and $item['status'])
                @if(in_array(has_option('style', 'template'), ['onepage', 'scrollpage']))
                <li><a href="{{url('/#'.get_class_section($item['widget']))}}" data-has="#{{get_class_section($item['widget'])}}" @if($item['widget'] == $page_class) class="active" @endif data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="{{$item['title']}}"><i class="{{$item['icon']}}"></i></a></li>
                @else
                <li><a href="{{url(get_class_section($item['widget'], true))}}" data-has="#{{get_class_section($item['widget'])}}" @if(get_class_section($item['widget']) == $page_class) class="active" @endif><i class="{{$item['icon']}}" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="{{$item['title']}}"></i></a></li>
                @endif
                @endif
                @endforeach
            </ul>
        </div>
    </div>
</header>



<div class="mobile-header mobile-visible">
    <div class="mobile-logo-container">
        <div class="mobile-header-image">
            <img src="{{has_option('sidebar', 'avatar', get_asset('images/avatar.jpg'))}}" alt="{{get_option('sitename')}}">
        </div>
        <div class="mobile-site-title">{{ get_option('sitename') }}</div>
    </div>
    <a class="menu-toggle mobile-visible"><i class="lnr lnr-menu"></i></a>
</div>