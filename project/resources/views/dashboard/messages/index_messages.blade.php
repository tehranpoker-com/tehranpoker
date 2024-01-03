@extends('dashboard.layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">{{$page_title}}</h4>
        </div>
    </div>
</div>
@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>{{ session()->get('success') }}</div>
@endif
<div class="row">
    <div class="col-12">
        <div class="email-leftbar card">
            <div class="mail-list">
                <a href="{{ get_admin_url('messages/appointments') }}" @if($list_class == 'appointments') class="active" @endif><i class="bx bx-calendar mr-2"></i> {{ admin_lang('appointments') }} {!! get_messages_html('appointments') !!}</a>
                <a href="{{ get_admin_url('messages/contactus') }}" @if($list_class == 'contactus') class="active" @endif><i class="bx bx-envelope mr-2"></i> {{ admin_lang('contactus') }} {!! get_messages_html('contactus') !!}</a>
            </div>
        </div>
        <div class="email-rightbar mb-3">
            <div class="card p-3">
                <form class="form-horizontal" method="POST" action="{{ get_admin_url('MessagesActions') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="type" value="{{ $post_type }}">
                    <input type="hidden" name="query" value="action">
                    <div class="btn-toolbar p-3" role="toolbar">
                        <div class="actionselect ml-3 mr-3">
                            <select name="action" class="custom-select form-select custom-select-sm form-control form-control-sm width-120">
                                <option value="-1">{{admin_lang('bulk_actions')}}</option>
                                <option value="markread">{{admin_lang('mark_read')}}</option>
                                <option value="markunread">{{admin_lang('mark_unread')}}</option>
                                <option value="delete">{{admin_lang('delete')}}</option>
                            </select>
                            <input type="submit" class="btn btn-sm btn-primary" value="{{admin_lang('apply')}}" onclick="return confirm(\'{{admin_lang('apply_confirm')}}\');">
                        </div>
                    </div>
                    <ul class="message-list">
                        @foreach($posts as $post)
                        <li @if(!$post->post_status) class="unread" @endif>
                            <div class="col-mail col-mail-1">
                                <div class="checkbox-wrapper-mail">
                                    <input type="checkbox" class="custom-control-input" name="mark[]" value="{{ $post->id }}" id="select-{{ $post->id }}" />                                        
                                    <label class="toggle" for="select-{{ $post->id }}"></label>
                                </div>
                                <a class="title" href="{{ get_admin_url('message/show-'.$post->id) }}">
                                    @if($post->post_status)
                                    {{ $post->post_title }}<br />
                                    @else
                                    <strong>{{ $post->post_title }}<br /></strong>
                                    @endif
                                </a>
                            </div>
                            <div class="col-mail col-mail-2">
                                <a href="{{ get_admin_url('message/show-'.$post->id) }}" class="subject">
                                    @if(get_post_meta('subject', $post->id))
                                    {{get_post_meta('subject', $post->id)}}<br />
                                    @endif
                                    <span class="teaser">{!!safe_input($post->post_content)!!}</span>
                                </a>
                                <div class="date">{{ time_format($post->post_modified, 'date') }}</div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </form>
                {{$posts->links('dashboard.layouts.pagination')}}
            </div>
            
        </div>
    </div>
</div>
@endsection