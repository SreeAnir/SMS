@extends('layouts.student.web')

@section('content')
@php
    $user = auth()->user();
@endphp
{{-- @include('layouts.student.includes.top-info') --}}
@include('student.includes.top-info') 

<div class="container ">
@include('student.includes.basic-tab')
@include('student.includes.tabs')
</div>

@endsection
