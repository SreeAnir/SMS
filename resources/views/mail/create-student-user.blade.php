@extends('mail.general_layout')

@section('email_subject', 'Welcome to'.env('APP_NAME'))

@section('email_content')
@php
use Carbon\Carbon;
$currentTimestamp = Carbon::now()->timestamp;

@endphp
    <h1 class="theme-color">Welcome to {{env('APP_NAME')}}</h1>
    <p>Hello {{ $user->full_name }}!</p>
    <p>Your student account has been created. We're excited to have you on board.</p>
    <p>Click <a href="{{ route('login') }}?verify_login=1&until={{ $currentTimestamp }}" style="color:blue;"> here to
        login </a> with password </a>
</p>
<p>
   Username : <b> {{  $user->user_name }}</b>
</p>
<p>
    Password : <b> {{ @$passwrod_text }}</b>
 </p>
<p>You can now start using our services and explore all the features we offer.</p>
<p>If you have any questions or need assistance, feel free to contact our support team.</p>
<p>Best regards,</p>
<p>Team {{ env('APP_NAME') }} </p>
@endsection
