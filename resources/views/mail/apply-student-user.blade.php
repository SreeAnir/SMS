@extends('mail.general_layout')

@section('email_subject', 'Acknowledgment of Your Application to Join as a Student')

@section('email_content')
    @php
        use Carbon\Carbon;
        $currentTimestamp = Carbon::now()->timestamp;
    @endphp
    <h1 class="theme-color">Welcome to {{ env('APP_NAME') }}</h1>
    <p>Hello {{ $user->full_name }}!</p>
    <p>I hope this email finds you well.</p>
    <p>We wanted to inform you that we have received your application to join
        {{ env('APP_NAME') }} as a student.
        We appreciate your interest in {{ env('APP_NAME') }} and are currently in the process of reviewing applications.</p>
    <p>Please be assured that your application is important to us, and we are committed to thoroughly evaluating each
        candidate. Our team will carefully assess your qualifications and suitability for the program.
    </p>
    <p>If the details are relevant,you will recieve the user_name and password to view/edit your details</p>
    </p>
    <p>
        If we require any additional information or documentation from you, we will reach out to you promptly. Meanwhile, we
        kindly ask for your patience as we go through the selection process.

    </p>
    <p>If you have any questions or need assistance, feel free to contact our support team.</p>

    <p>Best regards,</p>
    <p>Team {{ env('APP_NAME') }} </p>
@endsection
