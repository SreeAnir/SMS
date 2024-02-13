@extends('mail.general_layout')

@section('email_subject', 'Notification ' . env('APP_NAME'))

@section('email_content')
    @php
        use Carbon\Carbon;
        use App\Models\Notification;
        $currentTimestamp = Carbon::now()->timestamp;

    @endphp
    <h1 class="theme-color">Welcome to {{ env('APP_NAME') }}</h1>
    <p>Dear {{ @$user->full_name }}!</p>
    <p>We hope this message finds you well !
    </p>



    <p><b> {{ $title }}</b></p>
    <p> {{ $notification->message }}</p>
    @if (@$notification->notification_type == Notification::EVENT)
        <div style="
    color: #05425e;
    font-family: ui-sans-serif;
    FONT-WEIGHT: 600;
">
            <p> Date: {{ @$notification->notifiable->event_date }} </p>
            <p> Time: {{ @$notification->notifiable->event_time }} </p>
            <p> Location: {{ @$notification->notifiable->address }} </p>
        </div>
        <p>Your attendance will not only contribute to the vibrancy of the event but will also allow you to connect with
            like-minded individuals who share your passion for {{ @$notification->notifiable->title }}. Whether you're a
            seasoned
            enthusiast or just
            getting started, there's something for everyone.
        </p>
        <p>
            To secure your spot, simply click on the <a href="{{ route('event-summary') }}">link</a>
        </p>
    @endif

    <p>Best regards,</p>

    <p>Team {{ env('APP_NAME') }} </p>
@endsection
