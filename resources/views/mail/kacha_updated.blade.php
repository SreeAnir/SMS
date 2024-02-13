@extends('mail.general_layout')

@section('email_subject', 'Important Update:Your kacha Details Have Been Updated!')

@section('email_content')
    @php
        use Carbon\Carbon;
    @endphp
    <h1 class="theme-color">Welcome to {{ env('APP_NAME') }}</h1>
    <p>Hello {{ $user->full_name }}!</p>
    <p>I hope this email finds you in great spirits and good health.
        We're excited to share some fantastic news with you regarding your progress in {{ env('APP_NAME') }}!
        Your dedication and hard work have not gone unnoticed,
        and it's our pleasure to inform you that your belt details have been updated in our records.
    </p>
    <p style="color:red">
        <b> New Level: {{ $user?->student?->kacha?->label }} </b>
    </p>
    <p style="color:blue">
        <b> Effective Date:{{ Carbon::now()->format('F d Y') }} </b>
    </p>

    <p>This achievement is a testament to your commitment, perseverance, and skill development in {{ env('APP_NAME') }}.
        Your dedication to the art form is truly commendable, and we're proud to have you as a member of our {{ env('APP_NAME') }}
        community.

    </p>
    <p>
        Congratulations on reaching this milestone! We look forward to witnessing your continued growth and success on your
        journey.

    </p>
    <p>Please login to your account.</p>
    <p>If you have any questions or need assistance, feel free to contact our support team.</p>
    <p>Best regards,</p>
    <p>Team {{ env('APP_NAME') }} </p>
@endsection
