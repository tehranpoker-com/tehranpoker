<div class="section-body">
    <div class="container">
        <div class="section-inner">
            <div class="section-title">
                <h2>{{has_option('pricings', 'page_title')}}</h2>
                <p>{{has_option('pricings', 'page_subtitle')}}</p>
                <div class="divider"></div>
            </div>
            <div class="row mt-30 mb-30">
                @if(has_option('pricings', 'template') == 'style1')
                <div class="col-lg-12">
                    <div class="pricing pricing-palden">
                    @foreach ($pricings as $item)
                    <div class="pricing-item @if(get_post_meta('recommend', $item->post_id)) pricing-featured @endif">
                        <div class="pricing-deco" style="background: {{get_post_meta('bgcolor', $item->post_id)}};color: {{get_post_meta('color', $item->post_id)}};">
                            <svg class="pricing-deco-img" fill="currentcolor" enable-background="new 0 0 300 100" height="100px" preserveAspectRatio="none" version="1.1" viewBox="0 0 300 100" width="300px" x="0px" xml:space="preserve" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" y="0px"><path class="deco-layer deco-layer--1" d="M30.913,43.944c0,0,42.911-34.464,87.51-14.191c77.31,35.14,113.304-1.952,146.638-4.729c48.654-4.056,69.94,16.218,69.94,16.218v54.396H30.913V43.944z" fill="currentcolor" opacity="0.6"></path><path class="deco-layer deco-layer--2" d="M-35.667,44.628c0,0,42.91-34.463,87.51-14.191c77.31,35.141,113.304-1.952,146.639-4.729c48.653-4.055,69.939,16.218,69.939,16.218v54.396H-35.667V44.628z" fill="currentcolor" opacity="0.6"></path><path class="deco-layer deco-layer--3" d="M43.415,98.342c0,0,48.283-68.927,109.133-68.927c65.886,0,97.983,67.914,97.983,67.914v3.716H42.401L43.415,98.342z" fill="currentcolor" opacity="0.7"></path><path class="deco-layer deco-layer--4" d="M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z" fill="currentcolor"></path></svg>
                            <div class="pricing-price"><span class="pricing-currency">{{get_post_meta('currency', $item->post_id)}}</span>{{get_post_meta('price', $item->post_id)}}
                                @if(get_post_meta('payeach', $item->post_id))<span class="pricing-period">/ {{get_post_meta('payeach', $item->post_id)}}</span>@endif
                            </div>
                            <h3 class="pricing-title">{{$item->post_title}}</h3>
                        </div>
                        <ul class="pricing-feature-list">
                            @foreach (get_pricing_featured($item->post_excerpts) as $featured)
                            <li class="pricing-feature">{!! $featured !!}</li>

                            @endforeach
                        </ul>
                        <a href="{{get_post_meta('url', $item->post_id)}}" target="_blank" class="pricing-action">{{get_post_meta('btntext', $item->post_id)}}</a>
                    </div>
                    @endforeach
                    </div>
                </div>
                @elseif(has_option('pricings', 'template') == 'style2')
                @foreach ($pricings as $item)
                <div class="{{has_option('pricings', 'column')}} col-md-6 col-sm-12">
                    <div class="pricing-plan">
                        <h3>{{$item->post_title}}</h3>
                        <h4><span class="amount"><span>{{get_post_meta('currency', $item->post_id)}}</span>{{get_post_meta('price', $item->post_id)}}</span></h4>
                        <div class="features">
                            <ul>
                                @foreach (get_pricing_featured($item->post_excerpts) as $featured)
                                <li>{!! $featured !!}</li>
                                @endforeach
                            </ul>
                            <a href="{{get_post_meta('url', $item->post_id)}}" target="_blank" style="background: {{get_post_meta('btnbgcolor', $item->post_id)}};color: {{get_post_meta('btncolor', $item->post_id)}};">{{get_post_meta('btntext', $item->post_id)}}</a>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                @foreach ($pricings as $item)
                <div class="{{has_option('pricings', 'column')}} col-md-6 col-sm-12">
                    <div class="planbox">
                        <div class="title"><h3>{{$item->post_title}}</h3></div>
                        <div class="prices" style="background: {{get_post_meta('bgcolor', $item->post_id)}};color: {{get_post_meta('color', $item->post_id)}};">
                            <strong>
                                {{get_post_meta('currency', $item->post_id)}}{{get_post_meta('price', $item->post_id)}}
                                @if(get_post_meta('payeach', $item->post_id))<i>/{{get_post_meta('payeach', $item->post_id)}}</i>@endif
                            </strong> 
                            <b>
                                @if(get_post_meta('payeach', $item->post_id)){{lang('regularly')}}@endif
                                <em>{{get_post_meta('currency', $item->post_id)}}{{get_post_meta('priceold', $item->post_id)}}</em>
                            </b>
                            <a href="{{get_post_meta('url', $item->post_id)}}" target="_blank" style="background: {{get_post_meta('btnbgcolor', $item->post_id)}};color: {{get_post_meta('btncolor', $item->post_id)}};">{{get_post_meta('btntext', $item->post_id)}}</a>
                        </div>
                        <ul>
                            @foreach (get_pricing_featured($item->post_excerpts) as $featured)
                            <li>{!! $featured !!}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>