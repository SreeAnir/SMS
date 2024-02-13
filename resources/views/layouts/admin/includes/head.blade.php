<head>

  <base href="{{url('/')}}">
  <title>{{ env('APP_NAME') }} | @yield('title', 'Welcome')</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="@yield('meta-description','Khebrat')"/>
  <meta name="keywords" content="@yield('meta-keywords','Test')"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta property="og:locale" content="@yield('og-locale','en_US')"/>
  <meta property="og:type" content="@yield('og-type','article')"/>
  <meta property="og:title" content="@yield('og-title','Khebrat')"/>
  <meta property="og:url" content="{{request()->fullUrl()}}"/>
  <meta property="og:site_name" content="@yield('og-site_name','Khebrat')"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="robots" content="noindex,nofollow" />
  <meta name="theme-color" content="#ffffff">


  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:200,300,400,500,600,700"/>

    <!-- Tell the browser to be responsive to screen width -->
    
    <!-- Favicon icon -->
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="{{ asset('/assets/images/favicon.png') }}"
    />
    <!-- Custom CSS -->
    <link href="{{ asset('/assets/libs/flot/css/float-chart.css" rel="stylesheet') }}" />
    <!-- Custom CSS -->
  
    <link href="{{ asset('/dist/css/style.min.css') }}" rel="stylesheet" />
    <link
    href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
    rel="stylesheet"
  />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('style') --}}
    @stack('pre-styles')

<style type="text/css">.ui-timepicker-standard{z-index:10012 !important}</style>
  </head>
