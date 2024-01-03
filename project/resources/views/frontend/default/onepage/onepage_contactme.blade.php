<div class="section-body">
    <div class="container">
        <div class="section-inner">
            <div class="section-title">
                <h2>{{has_option('contactme', 'page_title')}}</h2>
                <p>{{has_option('contactme', 'page_subtitle')}}</p>
                <div class="divider"></div>
            </div>
            @if(has_option('contactme', 'mapstatus', '0'))
            <div class="google-map mb-30">
                <div id="google-map" data-latitude="{{has_option('contactme', 'maplatitude')}}" data-longitude="{{has_option('contactme', 'maplongitude')}}" data-zoom="{{has_option('contactme', 'mapzoom')}}" data-marker="{{has_option('contactme', 'mapmarker')}}"></div>
            </div>
            @endif
            <div class="row">
                <div class="col-lg-5 col-md-6 col-sm-12 mt-30 mb-30">
                    <div class="head-title">
                        <h3>{{has_option('contactme', 'information_title')}} <span>{{has_option('contactme', 'information_subtitle')}}</span></h3>
                    </div>
                    <div class="contact-information">
                        <ul>
                            <li><i class="pe-7s-map-marker"></i><span>{{has_option('contactme', 'address')}}</span></li>
                            <li><i class="pe-7s-call"></i><span>{{has_option('contactme', 'phone')}}</span></li>
                            <li><i class="pe-7s-phone"></i><span>{{has_option('contactme', 'phone2')}}</span></li>
                            <li><i class="pe-7s-mail"></i><span>{{has_option('contactme', 'email')}}</span></li>
                            <li><i class="pe-7s-mail"></i><span>{{has_option('contactme', 'email2')}}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6 col-sm-12 mt-30 mb-30">
                    <div class="head-title">
                        <h3>{{has_option('contactme', 'form_title')}} <span>{{has_option('contactme', 'form_subtitle')}}</span></h3>
                    </div>
                    <div class="contact-form">
                        @if(session()->has('contact_success'))
                        <div class="alert alert-success alert-dismissible"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>{{ session()->get('contact_success') }}</div>
                        @endif
                        <form action="{{url('sendcontact')}}" method="post" class="contactForm">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <div class="form-input">
                                        <i class="lnr lnr-user"></i>
                                        <input type="text" name="contact_name" class="form-control" placeholder="{{lang('name')}}" value="{{old('contact_name')}}" required-d="" autocomplete="off">
                                    </div>
                                    @if($errors->has('contact_name'))<div class="validation">{{ $errors->first('contact_name') }}</div>@endif
                                </div>
                                <div class="form-group col-lg-6">
                                    <div class="form-input">
                                        <i class="lnr lnr-envelope"></i>
                                        <input type="email" class="form-control" name="contact_email" placeholder="{{lang('email')}}" value="{{old('contact_email')}}" required-d="" autocomplete="off">
                                    </div>
                                    @if($errors->has('contact_email'))<div class="validation">{{ $errors->first('contact_email') }}</div>@endif
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="contact_message" placeholder="{{lang('message')}}" required-d="">{{old('contact_message')}}</textarea>
                                @if($errors->has('contact_message'))<div class="validation">{{ $errors->first('contact_message') }}</div>@endif
                            </div>
                            @if(has_option('apikeys', 'captcha_status'))
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="{{has_option('apikeys', 'recaptcha_key')}}"></div>
                                @if($errors->has('g-recaptcha-response'))<div class="validation">{{ $errors->first('g-recaptcha-response') }}</div>@endif
                            </div>
                            @endif
                            <button type="submit" class="button btn-block"><span>{{lang('send_message')}}</span></button>
                        </form>
                    </div>
                </div>
            </div>
            @if(has_option('contactme', 'socials_status') != 'off')
            <div class="head-title mt-30">
                <h3>{{has_option('contactme', 'socials_title')}} <span>{{has_option('contactme', 'socials_subtitle')}}</span></h3>
            </div>
            <div class="contact-social {{has_option('contactme', 'socials_status')}} mt-30">
                @foreach (has_option('contactme', 'socials') as $key => $item)
                @if(isset($item['status']))
                <a href="{{$item['url']}}" target="_blank" title="{{$item['title']}}" class="social{{$key}}"><i class="{{$item['icon']}}"></i></a>
                @endif
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@push('scripts')
@if($errors->has('contact_name') or $errors->has('contact_email') or $errors->has('contact_message') or session()->has('contact_success'))
<script>$('html').animate({scrollTop: $('.contact-form').offset().top - 80}, 500);</script>
@endif
@endpush