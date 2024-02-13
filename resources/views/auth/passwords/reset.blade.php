@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-5">
            <h2 class="heading-section">{{ __('Reset Password') }}</h2>
        </div>
    </div>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-wrap p-0">
                    @if (session('status'))
                        <div class="alert alert-success text-center" style="color: green;">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="email" class="col-form-label text-md-end">{{ __('Enter email address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label text-md-end">{{ __('New Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm"
                            class="col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="form-control btn btn-primary submit px-3">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .invalid-feedback {
        color: #fff !important;
    }

    .was-validated .form-control:invalid,
    .form-control.is-invalid {
        border-color: #fff !important;
    }
</style>
@endsection
    