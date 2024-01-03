@if(has_option('footer', 'clients_status'))
<div class="footer-clients d-home-none">
    <div class="container">
        <ul class="row">
            @foreach (has_option('footer', 'clients', []) as $key => $item)
            @if(isset($item['status']))
            <li class="col"><a href="{{$item['url']}}" target="_blank" title="{{$item['title']}}"><img src="{{$item['image']}}" alt="{{$item['title']}}"></a></li>
            @endif
            @endforeach
        </ul>
    </div>
</div>
@endif
@if(has_option('footer', 'status'))
<footer class="footer d-home-none">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p class="copyright">{{has_option('footer', 'copyright')}}</p>
            </div>
            <div class="col-md-6">
                @if(has_option('footer', 'socials_status'))
                <ul class="social pull-right">
                    @foreach (has_option('footer', 'socials') as $key => $item)
                    @if(isset($item['status']))
                    <li><a href="{{$item['url']}}" target="_blank" title="{{$item['title']}}" class="footer-social{{$key}}"><i class="{{$item['icon']}}"></i></a></li>
                    @endif
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
</footer>
@endif