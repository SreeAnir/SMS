<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('dist_login/css/web-styles.css') }} ">

</head>

<style>
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
<body>
    <!-- Navbar -->
    @include('layouts.student.includes.header')

    <!-- User Home Page -->
    <div class="container mt-4">
        <!-- Add your home page content here -->
        @yield('content')
    </div>



    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
