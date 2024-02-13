@extends('layouts.admin.app')
@if(Route::currentRouteName() == 'student.attendance.index')
@section('title', 'Student\'s Attendance') 
@php
    $route = route('student.attendance.index')  ;
@endphp
@else  
@section('title', 'Staff\'s Attendance') 
@php
    $route = route('staff.attendance.index')  ;
@endphp
@endif
{{-- @section('header_buttons') --}}

{{-- @endsection --}}
@section('content')
    @include('admin.attendance.summary')
    
    {{-- <x-index-card>
        <x-slot:filter id="users_filter">
            @include('admin.attendance.partials.filter')
        </x-slot:filter>
        <x-slot:table>
            {!! $dataTable->table() !!}
        </x-slot:table>
    </x-index-card> --}}
@endsection
{{-- @include('common.datatable') --}}
 