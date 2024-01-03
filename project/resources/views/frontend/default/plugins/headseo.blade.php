<link rel="canonical" href="{{ url()->current() }}" />
<meta name="description" content="@if(isset($description)){{$description}}@else{{has_option('seo', 'description')}}@endif" />
<meta name="keywords" content="@if(isset($keywords)){{$keywords}}@else{{has_option('seo', 'keywords')}}@endif" />
@if(has_option('seo', 'status'))
<meta name="robots" content="{{has_option('seo', 'robots')}}"/>
<meta property="og:title" content="{{ (isset($page_title))? $page_title. ' - ' : '' }}{{get_option('sitename')}}" />
<meta property="og:description" content="@if(isset($description)){{$description}}@else{{has_option('seo', 'description')}}@endif" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="{{get_option('sitename')}}" />
<meta property="og:image" content="@if(isset($seo_image)){{$seo_image}}@else{{has_option('sidebar', 'avatar', get_asset('images/avatar.jpg'))}}@endif" />
<meta name="twitter:title" content="{{ (isset($page_title))? $page_title. ' - ' : '' }}{{get_option('sitename')}}" />
<meta name="twitter:description" content="@if(isset($description)){{$description}}@else{{has_option('seo', 'description')}}@endif" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:image" content="@if(isset($seo_image)){{$seo_image}}@else{{has_option('sidebar', 'avatar', get_asset('images/avatar.jpg'))}}@endif" />
<meta name="twitter:site" content="{{has_option('seo', 'twitter')}}" />
@endif