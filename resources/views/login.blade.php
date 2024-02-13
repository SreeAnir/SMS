{{-- <!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>
@if ($errors->has('email'))
    <div class="alert alert-danger">
        {{ $errors->first('email') }}
    </div>
@endif

<form action="{{ route('authenticate')}}" method="post">
    @csrf  
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Login">
</form>

</body>
</html> --}}

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Test Login!</title>
</head>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
    body {
        margin: 0;
        padding: 0;
        background-color: #FFF;
        /* #17a2b8; */
        height: 100vh;
    }

    #login .container #login-row #login-column #login-box {
        margin-top: 120px;
        max-width: 600px;
        height: 320px;
        /* border: 1px solid #9C9C9C; */
        background-color: #EAEAEA;
    }

    #login .container #login-row #login-column #login-box #login-form {
        padding: 20px;
    }

    #login .container #login-row #login-column #login-box #login-form #register-link {
        margin-top: -85px;
    }
</style>

<body>
    <div id="login">
        <h3 class="text-center text-white pt-5">Login form</h3>
        <div class="container">
            @if ($errors->has('email'))
                <div class="alert alert-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif
            <form action="{{ route('authenticate') }}" method="post">
                @csrf
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6">
                        <div id="login-box" class="col-md-12">
                            <form id="login-form" class="form" action="" method="post">
                                <h3 class="text-center text-info">Login</h3>
                                <div class="form-group">
                                    <label for="username" class="text-info">Username:</label><br>
                                    <input type="email" id="email" name="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="text-info">Password:</label><br>
                                    <input type="password" id="password" name="password" required class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="remember-me" class="text-info"><span>Remember me</span> <span><input
                                                id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                                    <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                                </div>
                                {{-- <div id="register-link" class="text-right">
                                    <a href="#" class="text-info">Register here</a>
                                </div> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>


</html>
