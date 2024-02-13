@extends('layouts.admin.app')
@section('title', 'List Notifications')
 
@section('content')
     
    <x-index-card>
        
        <x-slot:toolbar>
            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                <a target="_blank" href="{{ route('notifications.create') }}" type="button" class="btn btn-primary btn-sm mx-1">
                    @lang('+ New Notification')
                </a>
            </div>
        </x-slot:toolbar>

        <x-slot:filter id="users_filter"> 
            @include('admin.notifications.partials.filter')  
         </x-slot:filter>
        <x-slot:table>
            {!! $dataTable->table() !!}
        </x-slot:table>
    </x-index-card>
@endsection
@include('common.datatable') 