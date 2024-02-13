@extends('layouts.auth.auth2factor')
@section('content')
    <div class="col-md-7 col-lg-8">
        <div class="login-wrap p-4 p-md-5">


            <div class="card border-0">
                <div class="card-body">

                    @if ($data['user']->loginSecurity != null && $data['user']->loginSecurity->google2fa_enable)
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-info  float-right">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M5.646 1.646a.5.5 0 0 0-.708 0 .5.5 0 0 0 0 .708L9.293 7H1.5a.5.5 0 0 0 0 1h7.793l-4.147 4.146a.5.5 0 0 0 0 .708a.5.5 0 0 0 .708 0L13.207 8.5a.5.5 0 0 0 0-.708L6.147 1.646a.5.5 0 0 0 0-.708z">
                                </path>
                                <path fill-rule="evenodd"
                                    d="M2 0.5A1.5 1.5 0 0 1 3.5 0h9A1.5 1.5 0 0 1 14 1.5v13a1.5 1.1.5 0 0 1-1.5 1.5h-9a1.5 1.5 0 0 1-1.5-1.5V0.5z">
                                </path>
                            </svg>
                            Continue to Website
                        </a>
                    @else
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-user-o"></span>
                        </div>
                    @endif

                    <h4 class="text-center">
                        Two Factor Authentication</h4>

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($data['user']->loginSecurity == null)
                        <form class="form-horizontal" method="POST" action="{{ route('generate2faSecret') }}">
                            {{ csrf_field() }}
                            <div class="form-group text-center ">

                                <button type="submit" class="btn btn-info ">
                                    {{ __('Generate Secret Key to Enable 2FA') }}
                                </button>
                            </div>
                        </form>
                    @elseif(!$data['user']->loginSecurity->google2fa_enable)
                        Please download <a target="_blank"
                            href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en&gl=US&pli=1">authenticator</a>
                        app to your mobile phone.
                        <div> 1.Scan this QR code with your Google Authenticator App. Alternatively, you can use the code:
                        </div>

                        <div class="d-flex flex-column">
                            <div class="p-2 mx-auto"> <code
                                    style="color: #e83e8c;
                            word-break: break-word;
                            font-size: 18px;
                            border: 1px solid #dad7d7;
                            background: white;
                            padding: 5px;">{{ $data['secret'] }}</code>
                            </div>
                            <div class="p-2 mx-auto"> <img
                                    src="data:image/svg+xml;charset=utf-8,{{ rawurlencode($data['google2fa_url']) }}"
                                    alt="QR Code for Two-Factor Authentication" /></div>
                            <hr />
                            <div class="p-2 "> 2. Enter the pin from Google Authenticator app: </div>
                            
                            <div class="p-2 mx-auto">
                                <form  autocomplete="off"  class="form-horizontal" method="POST" action="{{ route('enable2fa') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group {{ $errors->has('verify-code') ? ' has-error' : '' }}">
                                        <input  autocomplete="off"  placeholder="Authenticator Code" id="secret" type="password"
                                            class="form-control col-md-12" name="secret" required>
                                        @if ($errors->has('verify-code'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('verify-code') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-success">
                                       Verify to Enable 2FA
                                    </button>
                                  
                                </form>
                                <p>
                                    Trouble getting code?  
                                    <a  class="text-info" href="{{ route('new-2fa',[ auth()->user()])}}">
                                         Reset Now
                                     </a>
                                </p>
                            </div>
                        </div>
                </div>


                {{-- @elseif($data['user']->loginSecurity->google2fa_enable) 
            
                <div class="alert alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                        <path
                            d="M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16Zm3.78-9.72a.751.751 0 0 0-.018-1.042.751.751 0 0 0-1.042-.018L6.75 9.19 5.28 7.72a.751.751 0 0 0-1.042.018.751.751 0 0 0-.018 1.042l2 2a.75.75 0 0 0 1.06 0Z">
                        </path>
                    </svg>
                    &nbsp; 2FA is currently <strong>enabled</strong> on your account.
                </div>
                <p>If you are looking to disable Two Factor Authentication. Please confirm your password and Click Disable
                    2FA Button.</p>
                <form class="form-horizontal" method="POST" action="{{ route('disable2fa') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                        <label for="change-password" class="control-label">Current Password</label>
                        <input id="current-password" type="password" class="form-control col-md-4" name="current-password"
                            required>
                        @if ($errors->has('current-password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('current-password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary ">Disable 2FA</button>
                </form> --}}
                @endif
                {{-- <p class="mt-2 text-info">For Development <a href="{{ route('new-2fa', [auth()->user()->email]) }}"
                        class="text-danger"><u>Click</u></a> to reset</p> --}}

                <p class="text-secondary mt-3 small">***
                    Two factor authentication (2FA) strengthens access security by requiring two methods (also referred
                    to as
                    factors) to verify your identity. Two factor authentication protects against phishing, social
                    engineering
                    and password brute force attacks and secures your logins from attackers exploiting weak or stolen
                    credentials.***</p>


            </div>
        </div>
    </div>

    </div>
    </div>
@endsection
