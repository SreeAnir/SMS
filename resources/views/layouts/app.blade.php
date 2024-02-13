<!doctype html>
<html lang="en">

<head>
    <title>{{ env('APP_NAME') }} | @yield('title', 'Authentication')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/assets/images/favicon.png') }}" />
    {{-- <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('dist_login/css/web-styles.min.css') }} ">

<style>

            body {
                background-color: #fff;
                opacity: 0;
                /* Start with zero opacity */
                animation: fadeIn 2s forwards;
                /* 2 seconds animation duration */
            }

            @keyframes fadeIn {
                to {
                    opacity: 1;
                    /* Fade in to full opacity */
                }
            }
            body::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgb(96 7 7 / 50%); /* Adjust the alpha value for the overlay effect */
                /* Adjust the alpha value for the overlay effect */
            }
    .logo-header{
        height: 50px;
        border-radius: 50%;
        border: 1px solid #641414;
    }
    .logo-header:hover{
        opacity: 0.7;
        border: 2px ;
    }
    </style>
    @stack('styles')
</head>

<body class="img js-fullheight"
    style="background-color: #3c0202f2;background-image: url({{ asset('dist_login/images/bg1.jpg') }} );">

    <section class="ftco-section">
      {{-- @if(!Route::is('login')) --}}
      <div class="col-6 mx-auto">
        @include('layouts.admin.includes.common-alert')
    </div>
      {{-- @endif --}}
        
        @yield('content')
    </section>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('dist_login/js/jquery.min.js') }}"></script>
    <script src="{{ asset('dist_login/js/popper.js') }}"></script>
    <script src="{{ asset('dist_login/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dist_login/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @stack('scripts')
</body>

</html>
