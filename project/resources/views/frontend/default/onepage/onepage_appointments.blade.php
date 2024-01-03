<div class="section-body">
    <div class="container">
        <div class="section-inner">
            <div class="section-title">
                <h2>{{has_option('appointments', 'page_title')}}</h2>
                <p>{{has_option('appointments', 'page_subtitle')}}</p>
                <div class="divider"></div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mt-30 mb-30">
                    <div class="head-title">
                        <h3>{{has_option('appointments', 'matitle')}}<small>{{has_option('appointments', 'masubtitle')}}</small></h3>
                    </div>
                    <div class="list-appointments">
                        <ul>
                        @foreach (has_option('appointments', 'works') as $key => $item)
                        <li class="@if($item['status']) available @else not-available @endif">
                            @if($item['status']) <i class="lnr lnr-checkmark-circle"></i> @else <i class="lnr lnr-cross-circle"></i> @endif
                            <span class="day">{{lang($key)}}:</span>  <span class="time">{{$item['start']}} - {{$item['end']}}</span>
                        </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mt-30 mb-30">
                    <div class="contact-form">
                        @if(session()->has('apm_success'))
                        <div class="alert alert-success alert-dismissible"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>{{ session()->get('apm_success') }}</div>
                        @endif
                        <form action="{{url('sendappointments')}}" method="post" class="contactForm appointments-form">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="form-input">
                                    <i class="lnr lnr-pencil"></i>
                                    <input type="text" class="form-control" name="apm_subject" placeholder="{{lang('subject')}}" value="{{old('apm_subject')}}">
                                </div>
                                @if($errors->has('apm_subject'))<div class="validation">{{ $errors->first('apm_subject') }}</div>@endif
                            </div>
                            <div class="form-group">
                                <div class="form-input">
                                    <i class="lnr lnr-user"></i>
                                    <input type="text" name="apm_name" class="form-control" placeholder="{{lang('name')}}" value="{{old('apm_name')}}">
                                </div>
                                @if($errors->has('apm_name'))<div class="validation">{{ $errors->first('apm_name') }}</div>@endif
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <div class="form-input">
                                        <i class="lnr lnr-envelope"></i>
                                        <input type="email" class="form-control" name="apm_email" placeholder="{{lang('email')}}" value="{{old('apm_email')}}">
                                    </div>
                                    @if($errors->has('apm_email'))<div class="validation">{{ $errors->first('apm_email') }}</div>@endif
                                </div>
                                <div class="form-group col-lg-6">
                                    <div class="form-input">
                                        <i class="lnr lnr-phone-handset"></i>
                                        <input type="tel" class="form-control" name="apm_phone" placeholder="{{lang('phone')}}" value="{{old('apm_phone')}}">
                                    </div>
                                    @if($errors->has('apm_phone'))<div class="validation">{{ $errors->first('apm_phone') }}</div>@endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <div class="form-input">
                                        <i class="lnr lnr-calendar-full"></i>
                                        <input type="text" name="apm_date" id="app_date" class="form-control" value="{{old('apm_date')}}" data-lock="from" data-init-set="false" data-lang="en" data-large-mode="true" data-large-default="true" data-min-year="{{date('Y')}}" data-max-year="{{date('Y')}}" placeholder="{{lang('date')}}" required="" autocomplete="off" data-id="datedropper-0" readonly="">
                                    </div>
                                    @if($errors->has('apm_date'))<div class="validation">{{ $errors->first('apm_date') }}</div>@endif
                                </div>
                                <div class="form-group col-lg-6">
                                    <div class="form-input">
                                        <i class="lnr lnr-clock"></i>
                                        <input type="text" name="apm_time" id="app_time" class="form-control" value="{{old('apm_time')}}" placeholder="{{lang('time')}}" required="" autocomplete="off" readonly="">
                                    </div>
                                    @if($errors->has('apm_time'))<div class="validation">{{ $errors->first('apm_time') }}</div>@endif
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="apm_message" placeholder="{{lang('message')}}">{{old('apm_message')}}</textarea>
                                @if($errors->has('apm_message'))<div class="validation">{{ $errors->first('apm_message') }}</div>@endif
                            </div>
                            @if(has_option('apikeys', 'captcha_status'))
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="{{has_option('apikeys', 'recaptcha_key')}}"></div>
                                @if($errors->has('g-recaptcha-response'))<div class="validation">{{ $errors->first('g-recaptcha-response') }}</div>@endif
                            </div>
                            @endif
                            <button type="submit" class="button btn-block"><span>{{lang('booking_appointment')}}</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
@if(
$errors->has('apm_subject') or 
$errors->has('apm_name') or 
$errors->has('apm_email') or 
$errors->has('apm_phone') or 
$errors->has('apm_date') or 
$errors->has('apm_time') or 
$errors->has('apm_message') or 
session()->has('apm_success')
) <script>$('html').animate({scrollTop: $('.appointments-form').offset().top - 80}, 500);</script> @endif
@endpush