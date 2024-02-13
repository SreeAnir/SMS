<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form action="{{ isset($staff_payment) ? route('staff-payments.update', [$staff_payment]) : route('staff-payments.store') }}"
                class="form-horizontal" method="POST" id="create-staff-payment">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <div id="form-alert" class="alert alert-warning">

                        </div>
                    </div>
                    @if (isset($staff_payment))
                        {{ method_field('PUT') }}
                    @endif
                    <h4 class="card-title">@lang('Staff & payment Info')</h4>
                  
                    <div class="card-body border-top p-9">
                        @if(@$staff_payment!=null)
                        @php
                            $user = $staff_payment->user;
                        @endphp
                        @include('admin.users.user-card')
                    @endif
                        <div class="row" style="{{ (@$staff_payment!=null ?  'display:none' : '') }} ">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user_id">Staff</label>
                                    <select class="form-control" name="user_id">
                                        <option value="">{{ __('Select Staff') }}</option>
                                        @if (!empty($staffs))
                                            @foreach ($staffs as $staff)
                                                <option value="{{ $staff->id }}" 
                                                    @if(isset( $staff_payment ))
                                                    {{ (  $staff_payment->user_id == $staff->id )  ? ' selected ' : '' }}
                                                    @endif
                                                   {{  old('user_id') == $staff->id   ? ' selected ' : '' }}
                                                  >
                                                    {{ $staff->full_name }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="last_name">E-Mail</label>
                                    <input   type="text" class="form-control" id="email" readonly
                                         >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="last_name">Phone</label>
                                    <input maxlength="20" type="text" class="form-control" id="phone" readonly
                                        value="">
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_id">{{ __('Basic Salary') }}</label>
                                    <input maxlength="8" value="{{ isset($staff_payment) ? $staff_payment->basic_salary : old('basic_salary') }}"
                                        name="basic_salary" type="text" class="form-control price-validate"
                                        placeholder="{{ __('Basic Salary') }}, 1000" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="last_name">{{ __('HRA') }}</label>
                                    <input maxlength="8" value="{{ isset($staff_payment) ? $staff_payment->hra : old('hra') }}"
                                        name="hra" type="text" class="form-control price-validate"
                                        placeholder="{{ __('HRA') }} 100.502" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="last_name">{{ __('Other allowance') }}</label>
                                    <input maxlength="8"
                                        value="{{ isset($staff_payment) ? $staff_payment->other_allowance : old('other_allowance') }}"
                                        name="other_allowance" type="text" class="form-control"
                                        placeholder="{{ __('Other allowance') }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="note">{{ __('Any Special Note to add?') }}</label>
                                    <textarea name="note" maxlength="500" placeholder="{{ __('Note about this payment') }}" class="form-control">{{ isset($staff_payment) ? $staff_payment->note : old('note') }}</textarea>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <input type="submit" value="Save Details" class="btn btn-primary">
                            <input type="reset" value="Reset Details" class="btn btn-secondary">
                        </div>
                    </div>
            </form>

        </div>
    </div>

    
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

        <script>
            window.addEventListener('load', function() {
                $("#create-staff-payment").validate({
                    rules: {
                        user_id: {
                            required: true,
                            maxlength: 3,
                        },
                        basic_salary: {
                            required: true,
                            maxlength: 8,
                        },
                        hra: {
                            required: true,
                            maxlength: 8,
                        },
                        other_allowance: {
                            maxlength: 8,
                        },
                        note: {
                            maxlength: 500,
                        },
                    },
                    messages: {
                        user_id: {
                            required: "Select a Staff",
                        },
                        basic_salary: {
                            required: "Basic salary is required",
                            maxlength: "Name cannot be more than 8 characters"
                        },
                        hra: {
                            required: "HRA is required",
                            maxlength: "Hra cannot be more than 8 characters",
                        },
                        other_allowance: {
                            maxlength: "Required less than 8 characters",
                        },
                        note: {
                            maxlength: 500,
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
                });


                $(document).ready(function() {
                    $('#form-alert').hide();
                    $(document).on('change', 'select[name="user_id"]', function(e) {
                        $('#form-alert').hide();
                        $.ajax({
                            type: 'post',
                            url: " {{ route('admin.get-staff-payment') }} ",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "user_id": this.value
                            },
                            success: function(response) {
                                if (response.message != "") {
                                    $('#form-alert').html(response.message);
                                    let staff = response.staff;
                                    $('#email').val(staff.email);
                                    $('#phone').val('+' + staff.phone_code + ' ' + staff
                                        .phone_number);
                                    $('#form-alert').show();
                                } else {

                                }
                            },
                            error: function(error) {
                                swalError(__(error.responseJSON.message));
                            }
                        });
                    });
                    $('select[name="user_id"]').trigger('change');

                });
                $(document).on('change', '.price-validate', function(e) {
                    validatePrice(this);
                });
            });

            function validatePrice(input) {
                const value = input.value;

                // Remove any characters that are not digits, dots, or commas
                const cleanedValue = value.replace(/[^0-9.,]/g, '');

                // Replace multiple dots with a single dot
                const sanitizedValue = cleanedValue.replace(/(\..*)\./g, '$1');

                // Update the input value
                input.value = sanitizedValue;
            }
        </script>
    @endpush
