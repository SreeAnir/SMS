@extends('mail.general_layout')

@section('email_subject', 'Welcome to'.env('APP_NAME'))

@section('email_content')
@php
use Carbon\Carbon;
$currentTimestamp = Carbon::now()->timestamp;

@endphp
    <h1 class="theme-color">Welcome to {{env('APP_NAME')}}</h1>
    <p>Hello {{ $user->full_name }}!</p>
    <p>Your account has been created. We're excited to have you on board.</p>
    <p>Click here to verify your email  <a href="{{ route('admin.login')}}?verify_login=1&until={{  $currentTimestamp }}" style="color:blue;">here</a> with password </a> {{ $plain_password }}</p>
    <p>You can now start using our services and explore all the features we offer.</p>
    <p>If you have any questions or need assistance, feel free to contact our support team.</p>
    <p>Best regards,</p>
    <p>Team {{ env('APP_NAME')}} </p>
@endsection
