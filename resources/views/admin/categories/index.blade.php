@extends('layouts.admin.app')
@section('title', 'List Categories')
 
@section('content')
     
    <x-index-card>
        
        <x-slot:toolbar>
            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                <a target="_blank" href="{{ route('accounting-categories.create') }}" type="button" class="btn btn-primary btn-lg mx-1">
                    @lang('+ New Category')
                </a>
            </div>
        </x-slot:toolbar>

       
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
