@extends('layouts.admin.app')
@section('title', 'New User')
@push('style')
@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form class="form-horizontal" method="POST" action="{{ route('users.store')}}" id="create-user">
                    <div class="card-body">
                        <div class="col-md-6">
                            <h4 class="card-title">Personal Info</h4>
                            @csrf()
                            <input name="user_type" type="text" class="form-control"  
                           value="2" />
                            <div class="form-group row">
                                <label for="fname" class="col-sm-3 text-end control-label col-form-label">First
                                    Name</label>
                                <div class="col-sm-9">
                                    <input name="first_name" type="text" class="form-control" id="fname"
                                        placeholder="First Name" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lname" class="col-sm-3 text-end control-label col-form-label">Last
                                    Name</label>
                                <div class="col-sm-9">
                                    <input name="last_name" type="text" class="form-control" 
                                        placeholder="Last Name" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lname"
                                    class="col-sm-3 text-end control-label col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input  name="password"  type="password" class="form-control" id="lname"
                                        placeholder="Password Here" />
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                <label for="lname" class="col-sm-3 text-end control-label col-form-label">{{ __('Last  Name')}} </label>
                                <div class="col-sm-9">
                                    <input name="email" type="email" class="form-control" 
                                        placeholder="{{ __('E-Mail')}}" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="cono1" class="col-sm-3 text-end control-label col-form-label">{{ __('Contact No')}}
                                    </label>
                                    <div class="col-lg-9 col-md-12">
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <select name="phone_code"
                                            class="select2 form-select shadow-none"
                                            style="width: 100%; height: 36px"
                                        >
                                            <option value="">+</option>
                                            <option>91</option>
                                            <option>656</option>
                                            </select>
                                          </div>
                                          <input name="phone_number"
                                            type="text"
                                            class="form-control"
                                            placeholder="Phone Number"
                                            aria-label="Phone Number"
                                            aria-describedby="Phone Number"
                                          />
                                        </div>
                                      </div>
                            </div>
                        </div>
                        {{-- @can('assignRole',\App\Models\User::class) --}}
                        <div class="row mb-7">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="required fw-bold fs-6 mb-5">@lang('Roles')</label>
                                <!--end::Label-->
                                <!--begin::Roles-->
                                <div class="row">
                                    @foreach(App\Models\Role::where('name', '!=',App\Models\Role::ROLE_DEVELOPER)->get() as $role)
                                        <div class="col-md-6 mb-7">
                                            <div class="card card-bordered">
                                                <div class="card-body">
                                                    <div class="d-flex fv-row">
                                                        <!--begin::Radio-->
                                                        <div class="form-check form-check-custom form-check-solid">
                                                            <!--begin::Input-->
                                                            <input class="form-check-input me-3" name="roles[]"
                                                                   type="checkbox"
                                                                   value="{{$role->id}}" id="role_{{$role->id}}"
                                                                   @if(isset($user) && $user->hasRole($role)) checked @endif>
                                                            <!--end::Input-->
                                                            <!--begin::Label-->
                                                            <label class="form-check-label"
                                                                   for="role_{{$role->id}}">
                                                                <div class="fw-bolder text-gray-800">{{$role->name}}</div>
                                                                <div class="text-gray-600">
                                                                    {{$role->description}}
                                                                </div>
                                                            </label>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Radio-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!--end::Roles-->
                            </div>
                        </div>
                    {{-- @endcan --}}


                        <div class="border-top">
                            <div class="card-body">
                                <input type="submit" value="Submit" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card">
            </div>
        </div>

    @endsection

    @push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.6.7/js/min/perfect-scrollbar.jquery.min.js"></script> --}}

<script>
window.addEventListener('load', function() {  
    $("#create-user").validate({
        rules: {
            first_name: {
                required: true,
                maxlength: 30,
            },
            last_name: {
                maxlength: 30,
            },
            email: {
                required: true,
                email: true,
                maxlength: 100
            },
            password: {
                required: true,
                minlength: 3
            },
            // confirm_password: {
            //     required: true,
            //     equalTo: "#password"
            // },
        },
        messages: {
            first_name: {
                required: "First Name is required",
                maxlength: "Name cannot be more than 20 characters"
            },
            first_name: {
                maxlength: "Name cannot be more than 30 characters"
            },
            email: {
                required: "Email is required",
                email: "Email must be a valid email address",
                maxlength: "Email cannot be more than 30 characters",
            },
            password: {
                required: "Password is required",
                minlength: "Password must be at least 5 characters"
            },
            // confirm_password: {
            //     required:  "Confirm password is required",
            //     equalTo: "Password and confirm password should same"
            // }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script>
@endpush
