@extends('layouts.admin.app')
@section('title', 'Students List')
{{-- @section('header_buttons') --}}

{{-- @endsection --}}
@section('content')
@include('admin.students.partials.notice')
    <x-index-card>
        {{-- {{-- <x-slot:title>
              
        </x-slot:title> --}}
        
        <x-slot:toolbar>
            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                <a 1target="_blank" href="{{ route('students.create') }}" type="button" class="btn btn-primary  btn-lg  mx-1">
                    @lang('+ Add Student')
                </a>
                <a id="export_btn" href="{{ route('export.student') }}" type="button" class="btn btn-secondary btn-lg ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6"/>
                      </svg>  @lang('Export')
                </a>
                
                {{-- <x-add-button label="Add user" href="{{route('admin.users.create')}}"/> --}}
            </div>
        </x-slot:toolbar>

        <x-slot:filter id="users_filter"> 
            @include('admin.students.partials.filter')
        </x-slot:filter>  
        <x-slot:table>
            {!! $dataTable->table() !!}
        </x-slot:table>
    </x-index-card>
@endsection
@include('common.datatable')
@push('scripts')
<script>
    // Serialize the form data excluding the CSRF token


      window.addEventListener('load', function() {
        
        $.ajax({
                            type: 'get',
                            url: " {{ route('attendance.update') }} ",
                            success: function(response) {
                                console.log("Updated Attendnce")
                            },
                            error: function(error) {
                                swalError(__(error.responseJSON.message));
                            }
                        });
     });
</script>
@endpush 
{{-- @push('scripts')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    {!! $dataTable->scripts() !!}
@endpush --}}
