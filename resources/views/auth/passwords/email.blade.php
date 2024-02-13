@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section">{{ __('Reset Password') }}</h2>
            </div>
        </div>

        <form method="POST" action="{{ route('password.email') }}">
                        @csrf
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                         @if (session('status'))
                        <div class="alert alert-success text-center" style="color: green;">
                            {{ session('status') }}
                        </div>
                    @endif
                        <h3 class="mb-4 text-center">{{ __('Enter Your Email Address') }}</h3>
                            <div class="form-group">
                               <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">

                                <button type="submit"
                                    class="form-control btn btn-primary submit px-3">{{ __('Send Password Reset Link') }}</button>
                            </div>
                      
                    </div>
                </div>
            </div>
        </form>
    </div>
   

    <style>
        .invalid-feedback{
            color : #fff !important; 
        }
        .was-validated .form-control:invalid, .form-control.is-invalid{
            border-color: #fff !important; 
        }
            </style>
            
@endsection
