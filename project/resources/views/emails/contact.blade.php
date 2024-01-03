@extends('emails.email_template')
@section('content')
<h2 class="mail_title">{{ lang('email_hello') }}</h2>
<h3 class="mail_subtitle">{{ lang('email_contact_title') }}</h3>
<div class="msg-box">
<strong>{{ lang('name') }}: </strong> {{ $msg_name }}
<br />
<strong>{{ lang('email') }}: </strong> {{ $msg_email }}
<p>
<strong>{{ lang('message') }}: </strong>
<br />
{!! nl2br(e($msg_content)) !!}
</p>
</div>
@endsection