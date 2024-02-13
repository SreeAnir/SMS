@extends('layouts.admin.app')
@section('title', 'View Category')
@section('content')
@php
    $instance = $accountingCategory;
@endphp
<div class="row">
    @section('header_buttons')
    <a href="{{ route('accounting-categories.edit',[ $accountingCategory->id]) }}" type="button" class="btn btn-primary btn-lg">
        <em class="fas fa-pencil-alt px-2"></em>@lang('Edit Category')
    </a>
@endsection
    <div class="col-md-12">
       

        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-0">Category #
                  @include('common.account-badge')
                  @include('common.status-badge')
                </h5>
            </div>

            <table class="table">
                <tbody>
                  <tr>
                    <th scope="row">Category Title</th>
                    <td>{{  $accountingCategory->category_label}}</td>
                  </tr>
                  <tr>
                    <th scope="row">Category Description</th>
                    <td>{{  $accountingCategory->category_description}}</td>
                  </tr>
                  <tr>
                    <th scope="row">Category Status</th>
                    <td>{{  $accountingCategory->status->status}}</td>
                  </tr>
                   
                </tbody>
              </table>

            
        </div>


    </div>

     

@endsection
