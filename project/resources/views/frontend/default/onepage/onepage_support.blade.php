<div class="section-body">
    <div class="container">
        <div class="section-inner">
            <div class="section-title">
                <h2>{{has_option('support', 'page_title')}}</h2>
                <p>{{has_option('support', 'page_subtitle')}}</p>
                <div class="divider"></div>
            </div>
            <div class="row mt-30 mb-30">
                @if(has_option('faqs', 'status'))
                <div class="col-lg-6">
                    <a href="{{url('faqs')}}">
                        <div class="box-support">
                            <div class="media">
                                <div class="circle-icon"><i class="{{has_option('faqs', 'icon')}}"></i></div>
                                <div class="media-body">
                                    <h5 class="color-text mb-2">{{has_option('faqs', 'page_title')}}</h5>
                                    <p class="mb-0">{{has_option('faqs', 'page_subtitle')}}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endif
                @if(has_option('tickets', 'status'))
                <div class="col-lg-6">
                    <a href="{{has_option('tickets', 'url')}}" target="_blank">
                        <div class="box-support">
                            <div class="media">
                                <div class="circle-icon"><i class="{{has_option('tickets', 'icon')}}"></i></div>
                                <div class="media-body">
                                    <h5 class="color-text mb-2">{{has_option('tickets', 'page_title')}}</h5>
                                    <p class="mb-0">{{has_option('tickets', 'page_subtitle')}}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>   
                @endif
                @if(has_option('support', 'email_status'))
                <div class="col-lg-6">
                    <div class="box-support">
                        <div class="media">
                            <div class="circle-icon"><i class="{{has_option('support', 'emailicon')}}"></i></div>
                            <div class="media-body">
                                <h5 class="color-text mb-2">{{has_option('support', 'email_title')}}</h5>
                                <ul class="mb-0">
                                    @if(has_option('support', 'email_email'))<li><a href="mailto:{{has_option('support', 'email_email')}}">{{has_option('support', 'email_text')}}: <strong>{{has_option('support', 'email_email')}}</strong></a></li>@endif
                                    @if(has_option('support', 'email2_email'))<li><a href="mailto:{{has_option('support', 'email2_email')}}">{{has_option('support', 'email2_text')}}: <strong>{{has_option('support', 'email2_email')}}</strong></a></li>@endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(has_option('support', 'phone_status'))
                <div class="col-lg-6">
                    <div class="box-support">
                        <div class="media">
                            <div class="circle-icon"><i class="{{has_option('support', 'phoneicon')}}"></i></div>
                            <div class="media-body">
                                <h5 class="color-text mb-2">{{has_option('support', 'phone_title')}}</h5>
                                <ul class="mb-0">
                                    @if(has_option('support', 'phone_number'))<li><a href="tel:{{has_option('support', 'phone_number')}}">{{has_option('support', 'phone_text')}}: <strong>{{has_option('support', 'phone_number')}}</strong></a></li>@endif
                                    @if(has_option('support', 'phone2_number'))<li><a href="tel:{{has_option('support', 'phone2_number')}}">{{has_option('support', 'phone2_text')}}: <strong>{{has_option('support', 'phone2_number')}}</strong></a></li>@endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>