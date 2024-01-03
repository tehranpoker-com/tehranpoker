@if(get_option('comments') == 'disqus')
<div id="disqus_thread"></div>
@elseif(get_option('comments') == 'graphcomment')
<div id="graphcomment"></div>
@endif

@push('scripts')
@if($errors->any() or session()->has('success')) <script>$('html').animate({scrollTop: $('#form-comment').offset().top - 80}, 500);</script> @endif
@if(has_option('apikeys', 'captcha_status')) <script src="https://www.google.com/recaptcha/api.js?hl={{get_option('language', 'en')}}"></script> @endif
@if(get_option('comments') == 'disqus')
<script>(function() {var d = document, s = d.createElement('script');s.src = '//{{has_option('apikeys', 'disqusid')}}.disqus.com/embed.js';s.setAttribute('data-timestamp', +new Date());(d.head || d.body).appendChild(s);})();</script>
@elseif(get_option('comments') == 'graphcomment')
<script>window.gc_params = {graphcomment_id: '{{has_option('apikeys', 'graphcommentid')}}',fixed_header_height: 0,};(function() {var gc = document.createElement('script'); gc.type = 'text/javascript'; gc.async = true;gc.src = '//graphcomment.com/js/integration.js?' + Math.round(Math.random() * 1e8);(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(gc);})();</script>
@endif
@endpush