@extends('layouts.admin.app')
@section('title', 'List Users')
{{-- @section('header_buttons') --}}

{{-- @endsection --}}
@section('content')
    {{-- <x-toolbar-button> 
      <x-slot:buttonlist>
        <a 1target="_blank" href="{{ route('users.create') }}" type="button" class="btn btn-primary btn-lg">
            @lang('+ Add User')
        </a>
    </x-slot:buttonlist>
</x-toolbar-button> --}}
    <x-index-card>
        {{-- {{-- <x-slot:title>
              
        </x-slot:title> --}}

        <x-slot:toolbar>
            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                <a 1target="_blank" href="{{ route('users.create') }}" type="button" class="btn btn-primary btn-lg">
                    @lang('+ Add User')
                </a>
                {{-- <x-add-button label="Add user" href="{{route('admin.users.create')}}"/> --}}
            </div>
        </x-slot:toolbar>

        <x-slot:filter id="users_filter">
            @include('admin.users.partials.filter')
        </x-slot:filter>
        <x-slot:table>
            {!! $dataTable->table() !!}
        </x-slot:table>
    </x-index-card>
@endsection
{{-- @push('scripts') --}}
    {{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script> --}}
    {{-- {!! $dataTable->scripts() !!} --}}
{{-- @endpush --}}
@include('common.datatable')
