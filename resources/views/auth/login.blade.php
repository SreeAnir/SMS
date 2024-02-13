@extends('layouts.app')

@section('content')
@php
    use App\Models\Role;
@endphp
    <div class="container">

        <form method="POST" action="{{ route('student.login') }}">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center">{{ __('Have a student account?') }}</h3>
                       
                        <div class="form-group">
                            <input id="user_name" placeholder="User ID" type="text"
                                class="form-control rounded @error('user_name') is-invalid @enderror" name="user_name"
                                value="{{ old('user_name') }}" required autocomplete="user_name" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="password" type="password"
                                class="form-control rounded @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror


                            <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group">

                            <button type="submit"
                                class="form-control rounded btn btn-primary submit px-3">{{ __('Sign In') }}</button>
                        </div>
                        <div class="form-group d-md-flex">
                            <div class="w-50">

                                <label class="checkbox-wrap checkbox-primary">{{ __('Remember Me') }}
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="w-50 text-md-right">
                                @if (Route::has('password.request'))
                                    <a style="color: #fff" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif

                                {{-- <a href="#" style="color: #fff">{{ __('Forgot Password') }}</a> --}}
                            </div>


                        </div>
                        <input type="hidden" value="{{ Role::USER_TYPE_STUDENT }} " name="user_type"/>
                        <div class="container mt-5 text-center">
                            <p>Ready to apply as a new student? Click Apply Now:</p>
                            <a  href="{{ route('application.new') }}" class="custom-button">Apply Now</a>
                        </div>

                        
                       
                        {{-- <p class="w-100 text-center">&mdash; {{ __('Or Sign In With') }} &mdash;</p> --}}
                        {{-- <div class="social d-flex text-center">
                            <a href="#" class="px-2 py-2 mr-md-1 rounded"><span class="ion-logo-facebook mr-2"></span>
                                {{ __('Google') }}</a>
                            <a href="#" class="px-2 py-2 ml-md-1 rounded"><span class="ion-logo-twitter mr-2"></span>
                                {{ __('Twitter') }}</a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </form>
    </div>
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <style>
        .invalid-feedback {
            color: #fff !important;
        }

        .was-validated .form-control:invalid,
        .form-control.is-invalid {
            border-color: #fff !important;
        }

        /* Custom styles for the button */
        .custom-button {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            transition-duration: 0.4s;
            cursor: pointer;
            border: none;
        }

        .custom-button:hover {
            background-color: #45a049; /* Darker green on hover */
        }
           /* Overlay effect */
    </style>
@endsection
