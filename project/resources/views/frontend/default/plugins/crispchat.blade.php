@if(has_option('apikeys', 'crisp_chat_status'))
<script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="{{has_option('apikeys', 'crisp_chat')}}";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
@endif