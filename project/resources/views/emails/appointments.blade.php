@extends('emails.email_template')
@section('content')
<h2 class="mail_title">{{ lang('email_hello') }}</h2>
<h3 class="mail_subtitle">{{ lang('email_appointments_title') }}</h3>
<div class="msg-box">
<strong>{{ lang('subject') }}: </strong> {{ $msg_subject }}
<br />
<strong>{{ lang('name') }}: </strong> {{ $msg_name }}
<br />
<strong>{{ lang('email') }}: </strong> {{ $msg_email }}
<br />
<strong>{{ lang('phone') }}: </strong> {{ $msg_phone }}
<br />
<strong>{{ lang('date') }}: </strong> {{ $msg_date }}
<br />
<strong>{{ lang('time') }}: </strong> {{ $msg_time }}
<p>
<strong>{{ lang('message') }}: </strong>
<br />
{!! nl2br(e($msg_content)) !!}
</p>
</div>
@endsection