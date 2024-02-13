@extends('layouts.admin.app')
@section('title', $title ?? 'User details')
@section('content')
@section('header_buttons')
    @if( !$user->isSuperAdmin())
    <a 11target="_blank" href="{{ route('users.edit',[ $user]) }}" type="button" class="btn btn-primary btn-lg">
        <em class="fas fa-pencil-alt px-2"></em>@lang('Edit User')
    </a>
    @endif
@endsection
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-0">{{ @$user->full_name }}</h5>
        </div>
        <table class="table">
            {{-- <thead>
           
          </thead> --}}
            <tbody>
                <tr>
                    <th scope="col">{{ __('Email') }}</th>
                    <th scope="col">{{ @$user->email }}</th>
                </tr>
                <tr>
                    <th scope="col">{{ __('Phone') }}</th>
                    <th scope="col">{{ @$user->full_phone_number }}</th>

                </tr>
                <tr>
                    <th scope="col">{{ __('User Type') }}</th>
                    <th scope="col">{{ @$user->user_type_label }}</th>

                </tr>
                <tr>
                    <th scope="col">{{ __('Branch') }}</th>
                    <th scope="col">{{ @$user->location->name }}</th>

                </tr>
                <tr>
                    <th scope="col">{{ __('2 Factor Authentication') }}</th>
                    <th scope="col">
                        @if($user->loginSecurity ==null )
                        Not Set
                        @elseif($user?->loginSecurity?->google2fa_enable == 1  )
                        Enabled
                        @else 
                        Disabled
                        @endif
                    </th>

                </tr>

            </tbody>
        </table>
    </div>


    <div class="card">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab"><span
                        class="hidden-sm-up"></span>
                    <span class="hidden-xs-down">{{ __('Roles') }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#permissions" role="tab"><span
                        class="hidden-sm-up"></span>
                    <span class="hidden-xs-down">{{ __('Permissions') }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#authenticator" role="tab"><span
                        class="hidden-sm-up"></span>
                    <span class="hidden-xs-down">{{ __('Authenticator') }}</span></a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content tabcontent-border">
            <div class="tab-pane active" id="home" role="tabpanel">
                <div class="p-20">

                    <div class="col">
                        <!--begin::Label-->
                        <div class="card-body">
                            <h5 class="card-title mb-0">@lang('Roles Assigned to user')</h5>
                        </div>
                        <!--end::Label-->
                        <!--begin::Roles-->
                        <div class="row">
                            {{-- @foreach (App\Models\Role::where('name', '!=', App\Models\Role::ROLE_DEVELOPER)->get() as $role) --}}
                            @php
                                $roles = $user->roles->pluck('id')->toArray();
                            @endphp
                            @foreach (App\Models\Role::whereIn('id',  $roles)->get() as $role) 
                                @if (isset($user) && $user->hasRole($role))
                                    <div class="col-md-6 mb-3">
                                        <div class="card card-bordered">
                                            <div class="card-body">
                                                <div class="d-flex fv-row">
                                                    <!--begin::Radio-->
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <!--begin::Input-->
                                                        <a class="text-success" data-placement="top" title=""
                                                            data-bs-original-title="Update">
                                                            <i class="mdi mdi-check"></i>
                                                        </a>
                                                        {{-- <input class="form-check-input me-1" name="roles[]" 
                                                       type="checkbox" 
                                                       value="{{$role->id}}" id="role_{{$role->id}}"  
                                                       checked  > --}}
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <label class="form-check-label" for="role_{{ $role->id }}">
                                                            <div class="fw-bolder text-gray-800">{{ $role->name }}
                                                            </div>
                                                            <div class="text-gray-600">
                                                                {{ $role->description }}
                                                            </div>
                                                        </label>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Radio-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
          

            <div class="tab-pane p-20" id="permissions" role="tabpanel">
                <div class="p-20">

                    <div class="card">
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="table-responsive">
                                    <table
                                        class="table table-row-bordered table-row-dashed gy-4 align-middle dataTable no-footer">
                                        <thead class="fs-7 fw-bolder text-gray-400 text-uppercase">
                                            <th>@lang('Group')</th>
                                            <th>@lang('Previleges')</th>
                                            <th>@lang('Action')</th>
                                        </thead>
                                        <tbody>

                                            @foreach ($permissions as $key => $permission)
                                                <tr>
                                                    @if ($key == 0)
                                                        <?php $prev = $permission->group; ?>
                                                        <th rowspan="{{ $permission->rowscnt }}">
                                                            {{ $permission->group }} </th>
                                                    @else
                                                        @if ($permission->group != $prev)
                                                            <th rowspan="{{ $permission->rowscnt }}">
                                                                {{ $permission->group }}</th>
                                                            <?php $prev = $permission->group; ?>
                                                        @else
                                                            <?php $prev = $permission->group; ?>
                                                            <th rowspan="{{ $permission->rowscnt }}"></th>
                                                        @endif
                                                    @endif
                                                    <td>{{ $permission->name }}</td>
                                                    <td>
                                                        @if ($role->hasPermissionTo($permission))
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M5 12l5 5l10 -10" />
                                                            </svg>
                                                        @else
                                                            <i class="seticon mdi mdi-close text-danger"
                                                                aria-hidden="true"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane p-20" id="authenticator" role="tabpanel">
                <div class="p-20">
                    <div class="card">
                        <div class="card-body">
                            
                           
                            {{-- <div class="reset" >
                            <p>
                            No authentication set for this user.Please click below button to enable it 
                            </p>
                            <p>
                            <button  data-option="reset" type="button" class="btn btn-outline-info auth_btn">
                                Reset Authenticator
                              </button>
                            </p>
                            </div> --}}
                        
                           
                            <div class="disable options" >
                            <p>
                             Authentication is enabled for this user.Please click below button to disable it .Reset authenticator for new qr code.
                            </p> <p>
                            
                              <button  data-option="reset" type="button" class="btn btn-outline-warning auth_btn">
                                Reset Authenticator
                              </button>
                              <button data-option="disable"  type="button" class="btn btn-outline-info auth_btn">
                                Disable Authenticator
                              </button>
                              </p>
                            </div>
                           
                            <div class="enable options" >
                            <p>
                            Authentication is disabled for this user.This won't ask for any code after the login.Please click below button to enable it . Reset authenticator for new qr code.
                            </p>
                            <p>
                            
                              <button  data-option="reset" type="button" class="btn btn-outline-warning auth_btn">
                                Reset Authenticator
                              </button>
                              <button data-option="enable"  type="button" class="btn btn-outline-success auth_btn">
                                Enable Authenticator
                              </button>
                            </p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


</div>

</div>
<!-- accoridan part -->



<!-- card new -->

</div>



@endsection


    @push('scripts')
        <script>
            $('.options').hide();
             @if($user->loginSecurity ==null )
             $('.enable').show();
             @elseif($user?->loginSecurity?->google2fa_enable == 1  )
             $('.disable').show();
            @else 
            $('.enable').show();
            @endif

            $(document).on('click', '.auth_btn', function() {
               let clicked_optn =( $(this).data('option'));
               $('.options').hide();
               
               if(clicked_optn == 'enable'){
                    $('.disable').show();
               }
                 if(clicked_optn == 'disable' || clicked_optn == 'reset'){
                    $('.enable').show();
                }

             $.ajax({
                    type: 'post',
                    url: " {{ route('admin.change_authentication') }} "  ,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "status" :clicked_optn,
                        "user_id" :  {{ $user->id }}
                    },
                    success: function(response) {
                        swalSuccess(__(response.message));
                    },
                    error: function(error) {
                        location.reload();
                    }
                });
         })

            

        </script> 
     @endpush   

