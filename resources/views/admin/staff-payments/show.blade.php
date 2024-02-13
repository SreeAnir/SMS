@extends('layouts.admin.app')
@section('title', 'View Payment')
@section('content')
<div class="row">
    @section('header_buttons')
    <a 1target="_blank" href="{{ route('staff-payments.edit',[ $staff_payment->id]) }}" type="button" class="btn btn-primary btn-lg">
        <em class="fas fa-pencil-alt px-2"></em>@lang('Edit Payment')
    </a>
@endsection
    <div class="col-md-12">
       

        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-0">Payment #{{ $staff_payment->id }} to {{  $staff_payment->user->full_name}}</h5>
            </div>
            <table class="table">
                <tbody>

                    <tr>
                        <th scope="col">@lang('Email')</th>
                        <th scope="col"> {{  $staff_payment->user->email}}</th>
                    </tr>
                    <tr>
                        <th scope="col">@lang('Location')</th>
                        <th scope="col">{{ $staff_payment->location?->name }}</th>
    
                    </tr>
                    <tr>
                        <th scope="col">@lang('Phone')</th>
                        <th scope="col">{{  $staff_payment->user->full_phonenumber}}</th>
    
                    </tr>
                   
                    <tr>
                        <th scope="col">@lang('Basic Salary')</th>
                        <th scope="col">{{ $staff_payment->basic_salary }}</th>
    
                    </tr>
                    <tr>
                        <th scope="col">@lang('HRA') </th>
                        <th scope="col">{{ $staff_payment->hra }}</th>
    
                    </tr>
                    <tr>
                        <th scope="col">@lang('Other allowance')</th>
                        <th scope="col">{{ $staff_payment->other_allowance }}</th>
    
                    </tr>
                
                    <tr>
                        <th scope="col">@lang('Note')</th>
                        <th scope="col">{{ $staff_payment->note }}</th>
                    </tr>
                    <tr class="border-top text-info">
                        <th scope="col"><b>@lang('Net pay')</b></th>
                        <th scope="col"  class="text-info"><b>{{ $staff_payment->net_pay }}</b></th>
                    </tr>
                    
                </tbody>
            </table>
        </div>


    </div>

     

@endsection
