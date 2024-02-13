@extends('layouts.admin.app')
@section('title', 'View Event')
@section('content')
@php
    $instance = $event;
@endphp
<div class="row">
    @section('header_buttons')
    <a 1target="_blank" href="{{ route('events.edit',[ $event->id]) }}" type="button" class="btn btn-primary btn-lg">
        <em class="fas fa-pencil-alt px-2"></em>@lang('Edit Event')
    </a>
@endsection
    <div class="col-md-12">
       

        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-0">Event #{{ $event->id }} to {{  $event->title}}</h5>
            </div>
            <table class="table">
                <tbody>

                    <tr>
                        <th scope="col">@lang('Event Title')</th>
                        <th scope="col"> {{  $event->title}}</th>
                    </tr>
                    <tr class="border-top text-info">
                        <th scope="col">@lang('Address')</th>
                        <th scope="col"  >{{ $event->address }}</th>
                    </tr>
                    <tr>
                        <th scope="col">@lang('Event Date')</th>
                        <th scope="col">{{ $event->event_date }}</th>
    
                    </tr>
                    <tr>
                        <th scope="col">@lang('Event Time') </th>
                        <th scope="col">{{ $event->event_time }}</th>
    
                    </tr>
                    <tr>
                        <th scope="col">@lang('Visibility')</th>
                        <th scope="col"> @include('common.visibility', compact('instance'))</th>
    
                    </tr>
                    <tr>
                        <th scope="col">@lang('Status')</th>
                        <th scope="col">@include('common.status-badge', compact('instance'))</th>
                    </tr>
                 
                    <tr>
                        <th scope="col">@lang('Event Info')</th>
                        <th scope="col">{!!  $event->description !!}</th>
    
                    </tr>
                   
                    
                </tbody>
            </table>
        </div>


    </div>

     

@endsection
