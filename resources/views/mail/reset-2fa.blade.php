@extends('mail.general_layout')

@section('email_subject', 'Reset Authenticaton '.env('APP_NAME'))

@section('email_content')
@php
use Carbon\Carbon;
$currentTimestamp = Carbon::now()->timestamp;

@endphp
    <h1 class="theme-color">Welcome to {{ env('APP_NAME')}}</h1>
    <p>Hello {{ $user->full_name }}!</p>
    <p>You can reset your 2 factor authentication from here.</p>
    <p>Click <a style="color:red;" href="{{ route('new-2fa-confrm',[  encrypt(auth()->user()->id) ])}}">here </a> to confirm</p>
    <p>Best regards,</p>
    <p>Team {{ env('APP_NAME')}} </p>
@endsection
