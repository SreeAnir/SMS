@extends('mail.general_layout')

@section('email_subject', 'Important - Student Batch Update')

@section('email_content')
    <h1 class="theme-color">Welcome to {{env('APP_NAME')}}</h1>
    <p>Hello!</p>
    <p>New Student has been added to the batch <b style="color:rgb(4, 104, 104)"> {{  $user->student->batches[0]->batch_name }} - {{  $user->student->batches[0]->batch_time }} </b> in branch <b> {{  $user->student->batches[0]->location->name }} </b> </p>
    <p>Student Name - <b> {{ $user->full_name  }} </b></p>
    <p>Student ID - <b> {{ $user->ID_Number  }} </b></p>
    <p>Student Email  - <b> {{ $user->email  }} </b></p>
    <p>Please login to view the details</p>
    <p>Best regards,</p>
    <p>Team {{ env('APP_NAME')}} </p>
@endsection
