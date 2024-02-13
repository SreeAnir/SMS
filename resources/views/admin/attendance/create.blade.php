@extends('layouts.admin.app')
@section('title', isset($staff) ? 'Edit Payment' : 'Add Payment')
@section('content')

    @include('admin.staff-payments.partials.payment-form')

@endsection
