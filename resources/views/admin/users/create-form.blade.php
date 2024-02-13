@extends('layouts.admin.app')
@section('title', isset($user) ? 'Edit User' : 'New User')
@push('style')
    @section('content')
        @php
            if (isset($user) && @$user->isSuperAdmin()) {
                $roles = App\Models\Role::getRoles(App\Models\Role::ROLE_SUPER_ADMIN);
            } else {
                $roles = App\Models\Role::getRoles();
            }
            $filter = [];
            if( auth()->user()->location_id !=null ){
                $filter['location_id'] =  auth()->user()->location_id ;
            }
            $location_list = locationList($filter);

        @endphp

        <div class="card">
            <form action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}" class="form-horizontal"
                method="POST" action="{{ route('users.store') }}" id="create-user">
                <div class="card-body">
                    
                    <input type="hidden"  id="user_id_enc" value="{{ isset($user) ? $user->id : '' }}" />
                    @if (isset($user))
                        {{ method_field('PUT') }}
                       
                    @endif
                    @csrf()
                    <h5 class="card-title">@lang('User Basic Information & Branch')</h5>
                    <input name="user_type" value="{{ isset($user) ? $user->user_type : 2 }}" type="hidden"
                        class="form-control" />
                    <div class="row mb-3">
                        <div class="col-lg-6">

                            <div class="form-group row">
                                <label for="fname" class="col-sm-3 text-end-kalari control-label col-form-label">
                                    First Name</label>
                                <div class="col-sm-9">
                                    <input value="{{ isset($user) ? $user->first_name : '' }}" name="first_name" type="text"
                                        class="form-control" id="fname" placeholder="First Name" />
                                </div>
                            </div>


                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label for="lname"
                                    class="col-sm-3 text-end-kalari control-label col-form-label">{{ __('Last Name') }}</label>
                                <div class="col-sm-9">
                                    <input name="last_name" value="{{ isset($user) ? $user->last_name : '' }}" type="text"
                                        class="form-control" placeholder="Last Name" />
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            @if (!isset($user) || $user->isSuperAdmin())
                                <div class="form-group row">
                                    <label for="lname"
                                        class="col-sm-3 text-end-kalari control-label col-form-label">Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" placeholder="*******" name="password"
                                            value="{{ isset($user) ? '' : 'Test@123' }}" id="password" value="">
                                        <a class="btn btn-sm btn-info" id="showPasswordButton">{{ __('Show') }}</a>
                                        {{-- 
                                        <input name="password" value="{{ isset($user) ? '' : 'Test@123' }}" type="password"
                                            class="form-control" id="lname" placeholder="*******" /> --}}
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label for="lname" class="col-sm-3 text-end-kalari control-label col-form-label">{{ __('E-Mail') }}
                                </label>
                                <div class="col-sm-9">
                                    <input value="{{ isset($user) ? $user->email : '' }}" name="email" type="email"
                                        class="form-control" placeholder="{{ __('E-Mail') }}" />
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">

                            <div class="form-group row">
                                <label for="cono1"
                                    class="col-sm-3 text-end-kalari control-label col-form-label">{{ __('Contact No') }}
                                </label>
                                <div class="col-lg-9 col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">

                                            <input name="phone_number" value="{{ isset($user) ? $user->phone_number : '' }}" maxlength="10"
                                                type="tel" id="phone_number" class="form-control"
                                                placeholder="Phone Number">
                                                <input type="hidden" name="phone_code" id="phone_code" value="{{ isset($user) ? $user->phone_code :  ( old('phone_code') !="" ?  old('phone_code') : defaultCode() ) }}" placeholder="Dialing Code" readonly>
                                        </div>

                                    </div>
                                    <span class="error err-phone"></span>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-6">

                            <div class="form-group row">
                                <label for="fname" class="col-sm-3 text-end-kalari control-label col-form-label"> {{ __('Branch Location') }}</label>
                                <div class="col-sm-9">
                                    <select name="location_id" id="location_id" class="form-control" name="blood_group">
                                        <option value="">Select Location</option>  
                                        @foreach ( $location_list as $branch)
                                            <option value="{{ @$branch->id }}"
                                                {{ isset($user->location_id) && $user->vs == $branch->id || old('location_id') == $branch->id ? 'selected' : '' }}>
                                                {{  $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="row mb-7">
                        <hr />
                        <div class="col-12">
                            <!--begin::Label-->
                            <h5 class="card-title text-secondary">@lang('User Roles')</h5>
                            <div>
                                <a class="mb-0 font-medium p-0">
                                    <span class="text-muted">@lang('Choose the roles for the user.')</span>
                            </div>
                            <!--end::Label-->
                            <!--begin::Roles-->
                            <div class="row">
                                @foreach ($roles as $role)
                                    <div class="col-md-3 col-sm-12 mb-1">
                                        <div class="card m-0 P-0 ">
                                            <div class="card-body m-0 p-1">
                                                <div class="d-flex fv-row">
                                                    <!--begin::Radio-->
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input me-1" name="roles[]" type="radio"
                                                            value="{{ $role->id }}" id="role_{{ $role->id }}"
                                                            @if (isset($user) && $user->hasRole($role)) checked @endif>
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <label class="form-check-label" for="role_{{ $role->id }}">
                                                            <div class="mb-0 font-medium p-0 text-secondary">
                                                                {{ $role->name }}

                                                            </div>
                                                            <div class="mb-0 font-medium p-0  text-muted">
                                                                <a target="_blank"
                                                                    href="{{ route('roles.show', [$role->id]) }}">
                                                                    {{ __('View Details') }}
                                                                </a>
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
                </div>
                {{-- <="card-body"> --}}

                <div class="border-top">
                    <div class="card-body">
                        <input type="submit" value="Submit" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>

    @endsection
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    @endpush
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>

        {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.6.7/js/min/perfect-scrollbar.jquery.min.js"></script> --}}

        <script>
            if ($('#showPasswordButton').length > 0) {

                document.getElementById('showPasswordButton').addEventListener('click', function() {
                    var passwordInput = document.getElementById('password');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        this.textContent = 'Hide';
                    } else {
                        passwordInput.type = 'password';
                        this.textContent = 'Show';
                    }
                });
            }

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
                            required: function(element) {
                            return $("#user_id_enc").val() === ""; // Password is required if user_id is empty
                            },
                            minlength: 3
                        },
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
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });


                $(document).ready(function() {
                    $('input[name="email"]').on('change', function() {
                        //add email validation
                        $.ajax({
                            url: "{{ route('email.exists') }}",
                            type: 'post',
                            data: {
                                "email": $(this).val(),
                                'user_id': '{{ @$user->id }}'
                            },
                            success: function(response) {
                                if (response.status == 'error') {
                                    $('input[name="email"]').val('{{ @$user->email }}');
                                    swalError(response.message);
                                } else {
                                    //success
                                }

                            },
                            error: function(xhr, status, error) {
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    swalError("Error", xhr.responseJSON.message);
                                } else {
                                    swalError("Error", "Failed to proceed");
                                }
                                $('input[name="email"]').val('{{ @$user->email }}');
                            }
                        });
                    });
                    var phoneInput = document.querySelector("#phone_number");
                    var dialingCodeInput = document.querySelector("#phone_code");

                    // Initialize the intl-tel-input
                    var iti = window.intlTelInput(phoneInput, {
                        separateDialCode: true,
                        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                    });

                    // Listen for changes in the selected country
                    phoneInput.addEventListener("change", function() {
                        const errorMap = ["Invalid number", "Invalid country code",
                            "Phone number is too short", "Phone number is too long",
                            "Invalid number"
                        ];

                        if (phoneInput.value.trim()) {
                            if (iti.isValidNumber()) {

                            } else {

                                const errorCode = iti.getValidationError();
                                console.log( iti.getValidationError());
                                $('.err-phone').html('');
                                if(errorCode > 0 ){
                                    $('.err-phone').html(errorMap[errorCode]);
                                }
                            }
                        }

                        var selectedCountryData = iti.getSelectedCountryData();
                        if (selectedCountryData) {
                            dialingCodeInput.value = "" + selectedCountryData.dialCode;
                        }
                    });
                    if (dialingCodeInput.value != "") {
                        iti.setNumber("+" + dialingCodeInput.value + phoneInput.value);
                    }
                });

            });
        </script>
    @endpush
