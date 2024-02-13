{{-- <!doctype html>
<html lang="en">
  <head>
  	<title>Login 10</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="{{ asset('dist_login/css/style.css') }} ">
 </head>

<body class="img js-fullheight" style="background-image: url({{ asset('dist_login/images/bg1.jpg') }} );">


    <section class="ftco-section">


        @yield('content')
    </section>

    <script src="{{ asset('dist_login/js/jquery.min.js') }}"></script>
    <script src="{{ asset('dist_login/js/popper.js') }}"></script>
    <script src="{{ asset('dist_login/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dist_login/js/main.js') }}"></script>

</body>

</html> --}}

<!doctype html>
<html lang="en">

<head>
    <title>{{ env('APP_NAME') }} | @yield('title', '2Factor Authentication')</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="{{ asset('auth2F/css/style.css') }} ">

    <link
    rel="icon"
    type="image/png"
    sizes="16x16"
    href="{{ asset('/assets/images/favicon.png') }}"
  />
</head>

<body>
    <section class="ftco-section">
        <div class="container">
             
            <div class="row justify-content-center">
				@yield('content')
                {{-- <div class="col-md-7 col-lg-8">
                    <div class="login-wrap p-4 p-md-5">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-user-o"></span>
                        </div>
                        

                    </div>
                </div> --}}
            </div>
        </div>
    </section>

    <script src="{{ asset('auth2F/js/jquery.min.js') }}"  ></script>
    <script src="{{ asset('auth2F/js/popper.js') }}"  ></script>
	<script src="{{ asset('auth2F/js/bootstrap.min.js') }}"  ></script>
	<script src="{{ asset('auth2F/js/main.js') }}"  ></script>

</body>

</html>
