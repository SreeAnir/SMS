@extends('layouts.admin.app')
@section('title', 'List Events')
 
@section('content')
     
    <x-index-card>
        
        <x-slot:toolbar>
            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                <a target="_blank" href="{{ route('events.create') }}" type="button" class="btn btn-primary btn-sm mx-1">
                    @lang('+ New Event')
                </a>
                <a target="_blank" href="{{ route('events.calendar') }}" type="button" class="btn btn-info btn-sm mx-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week-fill" viewBox="0 0 16 16">
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5m9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5M8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5m3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                      </svg>  @lang('Calendar')
                </a>
                {{-- <x-add-button label="Add user" href="{{route('admin.users.create')}}"/> --}}
            </div>
        </x-slot:toolbar>

        <x-slot:filter id="users_filter"> 
            @include('admin.events.partials.filter')  
         </x-slot:filter>
        <x-slot:table>
            {!! $dataTable->table() !!}
        </x-slot:table>
    </x-index-card>
@endsection
@include('common.datatable')
{{-- @push('scripts')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    {!! $dataTable->scripts() !!}
@endpush --}}
