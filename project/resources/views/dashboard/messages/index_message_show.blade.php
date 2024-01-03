@extends('dashboard.layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">{{$page_title}}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="email-leftbar card">
            <div class="mail-list">
                <a href="{{ get_admin_url('messages/appointments') }}" @if($list_class == 'appointments') class="active" @endif><i class="bx bx-calendar mr-2"></i> {{ admin_lang('appointments') }} {!! get_messages_html('appointments') !!}</a>
                <a href="{{ get_admin_url('messages/contactus') }}" @if($list_class == 'contactus') class="active" @endif><i class="bx bx-envelope mr-2"></i> {{ admin_lang('contactus') }} {!! get_messages_html('contactus') !!}</a>
            </div>
        </div>
        <div class="email-rightbar mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 border-bottom pb-3">
                        <div class="flex-shrink-0 me-3">
                            <img class="rounded-circle avatar-sm" src="{{ asset('images/avatar.png') }}" alt="">
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="font-size-14 mt-1">{{$post_title}}</h5>
                            <span class="text-muted">@if($email){{$email}}@endif</span>
                        </div>
                        <div class="modified text-muted">{{ time_format($modified) }}</div>
                    </div>
                    <div class="media-body mb-4 border-bottom pb-3">
                        <div>
                            @if($subject)<h4 class="font-size-16">{{$subject}}</h4>@endif
                            <p>{!! $post_content !!}</p>

                        </div>
                        @if($phone or $date or $time)
                        <div class="pt-3">
                            @if($phone)<span class="text-muted"><i class="bx bx-mobile-alt"></i> {{$phone}}</span><br />@endif
                            @if($date)<span class="text-muted"><i class="bx bx-calendar"></i> {{$date}}</span><br />@endif    
                            @if($time)<span class="text-muted"><i class="bx bx-time"></i> {{$time}}</span><br />@endif    
                        </div>
                        @endif
                    </div>
                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-href="{{ get_admin_url('message/delete/'.$post_id.'/'.csrf_token()) }}" data-body="{{ admin_lang('delete_confirm') }}" class="btn btn-danger waves-effect">{{ admin_lang('delete') }}</a>
                </div>
            </div>

            <div class="d-flex flex-wrap">
                @if($ip)<span class="bg-light p-2 m-1">{{$ip}}</span>@endif
                @if($platformname)<span class="bg-light p-2 m-1">{{$platformname}}</span>@endif
                @if($platformfamily)<span class="bg-light p-2 m-1">{{$platformfamily}}</span>@endif
                @if($browserfamily)<span class="bg-light p-2 m-1">{{$browserfamily}}</span>@endif
                @if($useragent)<span class="bg-light p-2 m-1">{{$useragent}}</span>@endif
            </div>
        </div>
    </div>
</div>
@endsection