<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('email_subject')</title>
    <style>
        /* Define the theme color as orange */
        .theme-color {
            color: orange;
        }
    </style>
</head>
<body>
    <div style="background-color: #f2f2f2; padding: 20px;">
        <div style="background-color: #ffffff; padding: 20px; border-radius: 5px; box-shadow: 0px 0px 10px #888888;">
            <img src="{{ asset('dist_login/images//logo-icon.png')  }}" alt="Logo" style="max-width: 100px;">
            @yield('email_content')
        </div>
    </div>
    
<style>
    body{
        font-family: -apple-system,system-ui,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue','Fira Sans',Ubuntu,Oxygen,'Oxygen Sans',Cantarell,'Droid Sans','Apple Color Emoji','Segoe UI Emoji','Segoe UI Emoji','Segoe UI Symbol','Lucida Grande',Helvetica,Arial,sans-serif;
        font-size: 13px;
    }
    th {
        color: #0368ce;
        border: 1px solid #e5e5e5;
        vertical-align: middle;
        padding: 12px;
        text-align: left
    }
    td {
        color: #414141;
        border: 1px solid #e5e5e5;
        vertical-align: middle;
        padding: 12px;
        text-align: left
    }

    .heading {
        color: #fa9c00;
        display: block;
        font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
        font-size: 14px;
        font-weight: bold;
        line-height: 130%;
        margin: 0 0 18px;
        text-align: left"

    }
</style>
</body>
</html>
