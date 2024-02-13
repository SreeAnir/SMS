<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} | @yield('title', 'Dashboard')</title>

    <!-- Bootstrap CSS with a red-based theme -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@200&family=Lato&family=Open+Sans:wght@400;700&family=Roboto+Condensed:wght@200&family=Roboto+Flex:opsz,wght@8..144,600&family=Roboto+Mono:wght@400;500&display=swap"
        rel="stylesheet"> --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap%22"
        rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />  
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />  
    <link rel="stylesheet" href="{{ asset('student/css/styles.css') }} ">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    @stack('styles')
      <style>
        .swal2-icon.swal2-question{
        font-size: 1rem !important;
    }
    .swal2-popup .swal2-title{
        font-size: 19px !important;
        padding: 30px  !important;
    }
    .swal2-popup .swal2-styled{
        margin: 2px 5px 0 !important;
    }
    </style>  
</head>

<body>

    @include('layouts.student.includes.header')

     
    <div class="wrapper">
            @include('layouts.admin.includes.common-alert')
       
        @yield('content')
    </div>
    </div>
    <footer class="footer text-center">
        © 2023 Tricta Technologies. All Rights Reserved.
    </footer>
    </div>
    <!-- Bootstrap JS and Popper.js -->
   
    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('/student/js/common.js') }}"></script>


</body>

</html>
