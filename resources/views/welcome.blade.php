@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h1 class="display-1 text-white  font-weight-light">{{ __('Coming Soon') }}</h1>
                <div class="p-3 d-flex flex-row justify-content-center" >
                    <div class="text-nowrap bd-highlight px-2"  >
                        <a href="{{ route('login')}}" class="btn btn-success text-white   font-weight-light text-underline px-4">{{ __('Login as Student') }}</a>
                      </div>
                      <div class="text-nowrap bd-highlight px-2"  >
                        <a  href="{{ route('application.new')}}" class="btn btn-danger text-white  font-weight-light px-4">{{ __('New Student Application') }}</a>
                      </div>
                    

                </div>
                
            </div>
        </div>
            
    </div>
     
@endsection
