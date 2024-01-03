@if(has_option("style", "pageloaded"))
<div class="loader-overlay">
    @if(has_option("style", "pageloadedstyle") == 'style1')
    <div class="loader1">
        <div class="loader-container">
            <div class="lt"></div>
            <div class="rt"></div>
            <div class="lb"></div>
            <div class="rb"></div>
        </div>
    </div>
    @elseif(has_option("style", "pageloadedstyle") == 'style2')
    <div class="loader2">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
    @elseif(has_option("style", "pageloadedstyle") == 'style3')
    <div class="loader3"><span></span></div>
    @endif
</div>
@endif