@extends('layouts.student.web')
@section('content')
@section('title', isset($user) ? 'Edit Student' : 'New Student')
@php
    $user = auth()->user();
@endphp
{{-- @include('student.includes.top-info') --}}
<div class="container theme-border bg-white">
    <h5 class="text-success py-3">Payment Summary</h5>
    <form id="pay-confirm" action="{{ route('payment.create.order') }}" method="post">
        @csrf
        @if (isset($error))
            <div class="row">

                <div class="m-2 p-9 alert alert-danger text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-octagon-fill" viewBox="0 0 16 16">
                        <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353zM8 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                      </svg>
                        {{ $error }}

                </div>
                <div class="m-2 p-9  text-right">
                    <a class="text-info" href="{{ route('web.dashboard')}}" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-arrow-bar-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12.5 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5M10 8a.5.5 0 0 1-.5.5H3.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L3.707 7.5H9.5a.5.5 0 0 1 .5.5"/>
                      </svg>Dashboard </a>     
                </div>
            </div>
        @endif
        @if (isset($fee_log) && $fee_log != '')
            @php
                $pay_description = 'Payment for student fee #' . auth()->user()->ID_Number . '(' . $fee_log->id . '-' . $fee_log->fee_id . '-' . $fee_log->current_installment.")";
            @endphp
            <div class="row">
                <div class="card">

                    <div class="card-body border-top p-9">
                        <div class="row text-muted">
                            <div class="mb-3 col-md-6">
                                {{ $pay_description }}
                            </div>
                            <div class="mb-3 col-md-6">
                                Fee Amount : {{ priceFormatted($fee_log->amount) }}
                            </div>
                        </div>
                    </div>
                    <form class="form-horizontal p-2"
                        action="{{ isset($user) ? route('students.update', ['user' => $user]) : route('students.store') }}"
                        method="POST" id="create-student">
                        @csrf()
                        <h6 class="card-title my-4 text-info"><em class="fab fa-expeditedssl"></em>
                            {{ __('Student Info') }}
                        </h6>

                        <div class="card-body border-top p-9">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">{{ __('First Name') }}</label>
                                        <input maxlength="20" placeholder="{{ __('First name') }}" type="text"
                                            class="form-control" id="first_name" name="first_name"
                                            value="{{ isset($user->first_name) ? $user->first_name : old('first_name') }}">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <label for="sur_name">{{ __('Last name') }}</label>
                                        <input maxlength="20" type="text" class="form-control" id="sur_name"
                                            name="sur_name"
                                            value="{{ isset($user->last_name) ? $user->last_name : old('sur_name') }}">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <label for="email">{{ __('Email Id') }}</label>
                                        <input maxlength="20" type="email" class="form-control" id="email"
                                            name="email"
                                            value="{{ isset($user->email) ? $user->email : old('email') }}">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <div class="form-group">
                                        <label for="phone">{{ __('Phone') }}</label>
                                        <input maxlength="15" type="text" class="form-control" id="phone"
                                            name="phone"
                                            value="{{ isset($user->phone_code) ? $user->phone_code .  $user->phone_number : old('phone') }}">
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <label for="address_1">{{ __('Address Line 1') }}</label>
                                        <input maxlength="150" type="text" class="form-control" id="address_1"
                                            name="address_1" value="{{ old('address_1') }}">
                                    </div>
                                </div>
                              

                                <div class="mb-3 col-md-4">
                                    <div class="form-group">
                                        <label for="city">{{ __('city') }}</label>
                                        <input maxlength="20" type="text" class="form-control" id="city"
                                            name="city" value="{{ old('city') }}">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <div class="form-group">
                                        <label for="region">{{ __('Region') }}</label>
                                        <input maxlength="20" type="text" class="form-control"  
                                            name="region" value="{{ old('region') }}"
                                            value="{{ isset($user->location) ? $user->location->name : old('region') }}" name="region" 
                                            >
                                    </div>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <div class="form-group">
                                        <label for="country">{{ __('country') }}</label>
                                        <input maxlength="30" type="text" class="form-control" id="country_name"
                                        value="{{ isset($user->country) ? $user->country->name : old('country_name') }}" name="country_name" >
                                        <input  type="hidden"  id="country"  
                                        value="{{ isset($user->country) ? ( $user->country->code ) : old('country') }}" name="country" >
                                    </div>
                                </div>
                                
                                <div class="mb-3 col-md-2">
                                    <div class="form-group">
                                        <label for="zip">{{ __('zip') }}</label>
                                        <input maxlength="7" min="2" type="text" class="form-control" id="zip" name="zip"
                                        value="{{ isset($user->student) ? $user->student->po_box : old('zip') }}"   >
                                    </div>
                                </div>
                                <input type="hidden" value="{{ Crypt::encrypt($fee_log->id )}}" name="fee_log_enc" />

                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-12 p-2 d-flex  justify-content-center">
                                    <input type="submit" class="btn btn-lg btn-success mx-1"
                                        value="Confirm">
                                    <input type="button" class="btn btn-lg btn-secondary mx-1"
                                        value="Cancel">
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

            </div>
        @endif
</div>
</form>
</div>

@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script>
    window.addEventListener('load', function() {
        $("#pay-confirm").validate({
            rules: {
                first_name: {
                    required: true,
                    maxlength: 50,
                },
                sur_name: {
                    required: true,
                    maxlength: 50,
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 150
                },
                address_1: {
                    required: true,
                    maxlength: 100,
                    minlength : 3
                },
                 
                phone_number: {
                    required: true,
                    maxlength: 15,
                    minlength : 9
                },
                country: {
                    required: true,
                    maxlength: 30
                },
                zip: {
                    required: true,
                    maxlength: 7,
                    minlength: 3
                },
                city: {
                    required: true,
                    maxlength: 20,
                    minlength: 3
                },
                region: {
                    required: true,
                    maxlength: 20,
                    minlength: 3
                },
                
            },
            messages: {
                first_name: {
                    required: "First Name is required",
                    maxlength: "Name cannot be more than 50 characters"
                },
                sur_name: {
                    required: "Last Name is required",
                    maxlength: "Name cannot be more than 50 characters"
                },
                email: {
                    required: "Email is required",
                    email: "Email must be a valid email address",
                    maxlength: "Email cannot be more than 150 characters",
                },
                city: {
                    required: "City is required",
                },
                country: {
                    required: "Country is required",
                    maxlength: "Country cannot be more than 30 characters",
                },
                phone_number: {
                    required: "Phone number is required",
                    maxlength: "Email cannot be more than 15 characters",
                    minlength: "Email cannot be less than 9 characters",
                },
                address_1: {
                    required: "address line 1 is required",
                    maxlength: "Email cannot be more than 100 characters",
                    minlength: "Email cannot be less than 3 characters",
                },
                zip: {
                    maxlength: "zip cannot be more than 7 characters",
                    minlength: "Email cannot be less than 2 characters",
                },
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
        ,
        submitHandler: function(form) {
          swalLoader("Redirecting to Payment page." );
          form.submit();
        }

        });
    });
</script>
@endpush
