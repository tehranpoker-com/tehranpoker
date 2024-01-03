@if(has_option('cookie', 'status'))
@if(has_option('cookie', 'style') == 'style2')
<div class="cookieinfo cookiebox">
    <div class="cookieinfo-close cookie-consent loading">{{has_option('cookie', 'consent')}}</div>
    <span>{!! has_option('cookie', 'desc') !!}</span>
</div>
@elseif(has_option('cookie', 'style') == 'style3')
<div class="cookies-banner cookiebox">
    <div class="cookies-banner-container container">
        <p class="cookies-banner-text" style="background-image: url({{ get_default_image(has_option('cookie', 'image'), get_asset('images/cookie2.svg')) }})">{!!has_option('cookie', 'desc')!!}</p>
        <span class="cookies-banner-action">
            <button class="cookies-banner-button cookie-consent loading">{{has_option('cookie', 'consent')}}</button>
        </span>
    </div>
</div>
@else
<div class="cookie-box cookiebox {{ has_option('cookie', 'position') }}">
    <div class="cookie-box-inner">
        <img src="{{ get_default_image(has_option('cookie', 'image'), get_asset('images/cookie.svg')) }}" alt="cookie">
        <div class="cookie-content">
            <h3>{{has_option('cookie', 'title')}}</h3>
            <p>{!! has_option('cookie', 'desc') !!}</p>
            <div class="buttons">
                <button class="button cookie-decline">{{has_option('cookie', 'decline')}}</button>
                <button class="button cookie-consent loading">{{has_option('cookie', 'consent')}}</button>
            </div>
        </div>
    </div>
</div>
@endif
<script src="{{ get_asset('js/jquery.cookie.js') }}"></script>
<script src="{{ get_asset('js/cookie.min.js') }}"></script>
@endif