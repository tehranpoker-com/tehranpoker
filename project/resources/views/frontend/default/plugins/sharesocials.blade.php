<div class="post-footer-inner">
    <div class="share-links  share-centered icons-only">
        <div class="share-title">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 448 512" fill="currentcolor"><path fill="currentColor" d="M352 320c-28.6 0-54.2 12.5-71.8 32.3l-95.5-59.7c9.6-23.4 9.7-49.8 0-73.2l95.5-59.7c17.6 19.8 43.2 32.3 71.8 32.3 53 0 96-43 96-96S405 0 352 0s-96 43-96 96c0 13 2.6 25.3 7.2 36.6l-95.5 59.7C150.2 172.5 124.6 160 96 160c-53 0-96 43-96 96s43 96 96 96c28.6 0 54.2-12.5 71.8-32.3l95.5 59.7c-4.7 11.3-7.2 23.6-7.2 36.6 0 53 43 96 96 96s96-43 96-96c-.1-53-43.1-96-96.1-96zm0-288c35.3 0 64 28.7 64 64s-28.7 64-64 64-64-28.7-64-64 28.7-64 64-64zM96 320c-35.3 0-64-28.7-64-64s28.7-64 64-64 64 28.7 64 64-28.7 64-64 64zm256 160c-35.3 0-64-28.7-64-64s28.7-64 64-64 64 28.7 64 64-28.7 64-64 64z" class=""></path></svg>
            <span> {{lang('share_it')}}</span>
        </div>
@foreach ($sharelink as $item)
    @if(isset($item['status']))
    @switch($item['id'])
        @case('facebook')
        <a href="http://www.facebook.com/sharer.php?u={{$link}}" rel="external" target="_blank" class="facebook-share-btn"><img src="{{get_asset('images/share/facebook.svg')}}" /></a>
        @break
        @case('twitter')
        <a href="https://twitter.com/intent/tweet?text={{$title}}&amp;url={{$link}}" rel="external" target="_blank" class="twitter-share-btn"><img src="{{get_asset('images/share/twitter.svg')}}" /></a>
        @break
        @case('linkedin')
        <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{$link}}" rel="external" target="_blank" class="linkedin-share-btn"><img src="{{get_asset('images/share/linkedin.svg')}}" /></a>
        @break
        @case('pinterest')
        <a href="//pinterest.com/pin/create/link/?url={{$link}}&media={{$media}}&description={{$title}}" rel="external" target="_blank" class="pinterest-share-btn"><img src="{{get_asset('images/share/pinterest.svg')}}" /></a>
        @break
        @case('tumblr')
        <a href="http://www.tumblr.com/share/link?url={{$link}}&amp;name={{$title}}" rel="external" target="_blank" class="tumblr-share-btn"><img src="{{get_asset('images/share/tumblr.svg')}}" /></a>
        @break
        @case('whatsapp')
        <a href="whatsapp://send?text={{$title}} - {{$link}}" rel="external" target="_blank" class="whatsapp-share-btn"><img src="{{get_asset('images/share/whatsapp.svg')}}" /></a>
        @break
        @case('telegram')
        <a href="tg://msg?text={{$title}} - {{$link}}" rel="external" target="_blank" class="telegram-share-btn"><img src="{{get_asset('images/share/telegram.svg')}}" /></a>
        @break
    @endswitch
    @endif
@endforeach
    </div>
</div>