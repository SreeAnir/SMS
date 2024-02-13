@extends('layouts.admin.app')
@section('title','Roles list')


@section('content')

 
      <!--begin::Row-->
      <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9 m-1">
      @foreach($roles as $role)
          <!--begin::Col-->
              <div class="col-md-4">
                  <!--begin::Card-->
                  <div class="card  border border-warning h-md-100">
                      <!--begin::Card header-->
                      <div class="card-header">
                          <!--begin::Card title-->
                          <div class="card-title">
                              <h4>{{$role->name}}</h4>
                          </div>
                          <!--end::Card title-->
                      </div>
                      <!--end::Card header-->
                      <!--begin::Card body-->
                      <div class="card-body pt-1">
                          <!--begin::Users-->
                          <div class="fw-bolder text-gray-600 mb-5">Total users with this
                              role: {{$role->users()->count()}}</div>
                          <!--end::Users-->
                          <!--begin::Permissions-->
                          <div class="d-flex flex-column text-gray-600">
                              <div class="d-flex align-items-center py-2">
                                  <span class="bullet bg-primary me-3"></span>
                                  {{$role->description}}
                              </div>
                          </div>
                          <!--end::Permissions-->
                      </div>
                      <!--end::Card body-->
                      <!--begin::Card footer-->
                      <div class="card-footer flex-wrap pt-0">
                          <a href="{{ route('roles.show',[ $role->id ])}}"
                             class="btn btn-dark btn-active-primary my-1 me-2">
                              @lang('View Role')
                          </a>
                          <a  href="{{ route('roles.show',[  $role->id  ])}}"
                             class="btn btn-success text-white my-1">
                              @lang('Edit Role')
                          </a>
                      </div>
                      <!--end::Card footer-->
                  </div>
                  <!--end::Card-->
              </div>
              <!--end::Col-->
      @endforeach
      <!--begin::Add new card-->
          <!--begin::Add new card-->
      </div>
      <!--end::Row-->
  <!--end::Container-->
  @endsection
