@extends('layouts.admin.app')
@section('title', 'Change Password')
@push('style')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('Change Password') }}</div>

            <div class="card-body">
                <input type="hidden" name="">
                <form action="{{ route('update-password') }}" class="form-horizontal" method="POST" id="change-password-form">
                    @csrf
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 text-end control-label col-form-label">
                         {{ __('Current Password') }}
                        </label>
                        <div class="col-sm-6">
                             <input value="" name="password" type="password" class="form-control" id="password"
                            placeholder="Current Password" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="new_password" class="col-sm-3 text-end control-label col-form-label">
                         {{ __('New Password') }}
                        </label>
                        <div class="col-sm-6">
                            <input value="" name="new_password" type="password" class="form-control" id="new_password"
                            placeholder="New Password" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="new_password" class="col-sm-3 text-end control-label col-form-label">
                         {{ __('Confirm Password') }}
                        </label>
                        <div class="col-sm-6">
                            <input value="" name="confirm_password" type="password" class="form-control" id="confirm_password"
                            placeholder="Confirm Password" required>
                        </div>
                    </div>                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success text-white">{{ __('Change Password') }}</button>
                        <button type="button" class="btn btn-primary" id="cancelbtn">{{ __('Cancel') }}</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
<style>
    .card {
        margin-top: 50px;
    }

    .form-label {
        font-weight: bold;
    }
</style>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#change-password-form').validate({
            rules: {
                password: {
                    required: true,
                },
                new_password: {
                    required: true,
                    minlength: 8,
                },
                confirm_password: {
                    required: true,
                    equalTo: '#new_password', // Ensure confirm_password matches new_password
                }
            },
            messages: {
                password: {
                    required: 'Please enter your current password.',
                },
                new_password: {
                    required: 'Please enter a new password.',
                    minlength: 'Password must be at least 8 characters long.',
                },
                confirm_password: {
                    required: 'Please confirm your new password.',
                    equalTo: 'Passwords do not match.',
                }
            },
            submitHandler: function (form) {
                form.submit(); // Submit the form when it's valid
            }
        });
    });
$(document).on('click','#cancelbtn',function(){
    $('#change-password-form')[0].reset();
    $('#change-password-form').validate().resetForm();
});
</script>

@endpush

