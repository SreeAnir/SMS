@extends('mail.general_layout')

@section('email_subject', 'Student Batch Update')

@section('email_content')
    <h1 class="theme-color">Welcome to {{env('APP_NAME')}}</h1>
    <p>Hello {{ $user->full_name }}!</p>
    <p>Your batch  has been updated.The batch code is {{  $user->student->batches[0]->batch_name }} - {{  $user->student->batches[0]->batch_time }}  </p>
    <p>Please login to your account.</p>
    <p>If you have any questions or need assistance, feel free to contact our support team.</p>
    <p>Best regards,</p>
    <p>Team {{ env('APP_NAME')}} </p>
@endsection
