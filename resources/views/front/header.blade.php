<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{env('SITE_NAME')}} | @yield('title')</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('/favicon-16x16.png') }}" sizes="16x16">
    <link rel="icon" type="image/png" href="{{ asset('/favicon-16x16.png') }}" sizes="16x16">
    <!-- Main Styles -->
    <link rel="stylesheet" href="{{ asset('backe/styles/style.min.css') }}">

    <!-- mCustomScrollbar -->
    <link rel="stylesheet" href="{{ asset('backe/plugin/mCustomScrollbar/jquery.mCustomScrollbar.min.css') }}">

    <!-- Waves Effect -->
    <link rel="stylesheet" href="{{ asset('backe/plugin/waves/waves.min.css') }}">
    <!-- flagstrap -->
    <link rel="stylesheet" href="{{ asset('backe/flagStrap/css/flags.css') }}">

    <!-- new update Emp3r0r -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('backe/scripts/jquery.min.js') }} "></script>
    <script src="{{ asset('backe/scripts/modernizr.min.js') }}"></script>
    <script src="{{ asset('backe/plugin/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backe/plugin/waves/waves.min.js') }}"></script>
    <script src="{{ asset('backe/flagStrap/js/jquery.flagstrap.min.js') }}"></script>

    <!-- end -->

</head>