@extends('layouts.auth.auth2factor')
@section('content')
    <div class="col-md-7 col-lg-8">
        <div class="login-wrap p-2 p-md-2">
            <div class="icon d-flex align-items-center justify-content-center">
                <span class="fa fa-user-o"></span>
            </div>
            <div class="card border-0">
                <h4 class="text-center">
                    Two Factor Authentication</h4>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="d-flex justify-content-center align-items-center">



                        <div class="alert  text-center">
                            <p> Enter the pin from Google Authenticator app: </p>

                            <form class="form-horizontal" action="{{ route('2faVerify') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('one_time_password-code') ? ' has-error' : '' }}">
                                    {{-- <label for="one_time_password" class="control-label">One Time Password</label> --}}
                                    <input autocomplete="off" id="one_time_password" name="one_time_password" class="form-control col-sm-12 col-mg-6"
                                        type="text" required />
                                </div>
                                <button class="btn btn-primary" type="submit">Authenticate</button>
                            </form>
                            <p>
                                Trouble getting code?  
                                <a  class="text-info" href="{{ route('new-2fa',[ auth()->user()])}}">
                                     Reset Now
                                 </a>
                            </p>

                            {{-- <p class="mt-2 text-info">For Development <a href="{{ route('new-2fa',[ auth()->user()->email ])}}" class="text-danger"><u>Click</u></a> to reset</p> --}}
                        </div>
                    </div>


                    <p class=" alert alert-info small">Two factor authentication (2FA) strengthens access security by requiring two methods
                        (also referred to as factors) to verify your identity. Two factor authentication protects against
                        phishing, social engineering and password brute force attacks and secures your logins from attackers
                        exploiting weak or stolen credentials.</p>




                </div>
            </div>
        </div>
    </div>
@endsection
