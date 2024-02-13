@extends('layouts.app')

@section('content')
    <header
        style="position: fixed;width: 100%;top: 0;background:rgb(26 0 0 / 80%);opacity:1 ;z-index:1;">
        <div class="container ">
            <p class="mx-auto ">
                <span> <img style="height:50px;" src="{{ asset('/assets/images/logo-icon.png') }}"> </span><span
                    class="text-white h4 brand_text ">KALARI CLUB DUBAI </span>
            </p>
        </div>
    </header>
        <div class="container mt-4">
            @if (session()->has('status'))
            @if (session()->get('status')=='success')

            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                    
                </div>
            </div>
            <div class="row ">
                <div class="col-md-8 offset-md-2 text-center">
                <div class="alert alert-info" role="alert">
                    <p>Welcome to Kalari Club Dubai</p>
                    <p>
                    We're thrilled to have you as a new student.</p>
                    <p>
                    
                    Your application is currently under review, and once the process is complete, you will receive an email containing your user ID and password.
                    </p>
                    <p>
                     This information will grant you access to your new student account.
                    </p>
                    <a href="{{ route('home')}}" role="button" class="btn btn-danger" data-dismiss="alert" aria-label="Close">
                        Back to Home
                    </a>
                   
                </div>
                </div>
    
            </div> 
                @else 

                <div class="row ">
                    <div class="col-md-8 offset-md-2 text-center">
                    <div class="alert alert-danger" role="alert">
                        
                        <p>
                        Your Application was not successful.Please contact us for further review.
                        </p>
                        <a href="{{ route('home')}}" role="button" class="btn btn-danger" data-dismiss="alert" aria-label="Close">
                            Back to Home
                        </a>
                       
                    </div>
                    </div>
        
                </div> 


                @endif

            @else 
            <div class="row ">
                <div class="col-md-8 offset-md-2 text-center">
                <div class="alert alert-danger" role="alert">
                    
                    <p>
                    Sorry,No Page available.
                    </p>
                    <p>Contact us if you have any queries or issues.</p>
                    <a href="{{ route('home')}}" role="button" class="btn btn-danger" data-dismiss="alert" aria-label="Close">
                        Back to Home
                    </a>
                   
                </div>
                </div>
    
            </div> 
            @endif
        </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                setTimeout(() => {
                    window.location = "{{ route('home')}}" ; 
                }, 20000);
             });
         </script>
    @endpush
    @push('styles')
        <style>
           
        </style>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="{{ asset('dist_login/css/form-style.css') }} ">
        <style>

        </style>
    @endpush
@endsection
