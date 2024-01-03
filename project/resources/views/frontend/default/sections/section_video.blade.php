<div class="video-section" style="background-image: url({{has_option('aboutme', 'video_bgimage')}});">
    <div class="overlay pb-40 pt-40">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                    <div class="sub-title">
                        <h6>{{has_option('aboutme', 'video_title')}}</h6>
                        <h2>{{has_option('aboutme', 'video_subtitle')}}</h2>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 position-relative">
                    <div class="pulse-icon">
                        <div class="icon-wrap">
                            <a class="video-box-btn" href="javascript:void(0)" data-src="{{has_option('aboutme', 'video_url')}}" data-fancybox="video" data-caption="">
                                <img src="{{get_asset('images/play.svg')}}" />
                            </a>
                        </div>
                        <div class="elements">
                            <div class="circle circle-outer"></div>
                            <div class="circle circle-inner"></div>
                            <div class="pulse pulse-1"></div>
                            <div class="pulse pulse-2"></div>
                            <div class="pulse pulse-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>