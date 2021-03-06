<!DOCTYPE html>
<html>
<head>

    <!-- Basic -->
    <meta charset="utf-8">
    <title>Bitregion - @yield('title')</title>
    <meta name="keywords" content="bitregion, mmm, network, investment, community bank" />
    <meta name="description" content="Bitregion - Bank by community for the community">
    <meta name="author" content="bitregion.com">
    <link rel="shortcut icon" type="image/png" href="{{asset('favicon.png')}}"/>
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('extrameta')
    <!-- Web Fonts  -->
    <!--
    <link href="web_content/http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Alegreya|Alegreya+SC|Oswald:400,300" rel="stylesheet" type="text/css">
    -->

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset('web_content/vendor/bootstrap/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('web_content/vendor/fontawesome/css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('web_content/vendor/rs-plugin/css/settings.css')}}">
    <link rel="stylesheet" href="{{asset('web_content/vendor/owlcarousel/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('web_content/vendor/owlcarousel/owl.theme.css')}}">
    <link rel="stylesheet" href="{{asset('web_content/vendor/magnific-popup/magnific-popup.css')}}">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{asset('web_content/css/theme.css')}}">
    <link rel="stylesheet" href="{{asset('web_content/css/landing.css')}}">
    <link rel="stylesheet" href="{{asset('web_content/css/theme-elements.css')}}">
    <link rel="stylesheet" href="{{asset('web_content/css/theme-blog.css')}}">
    <link rel="stylesheet" href="{{asset('web_content/css/theme-shop.css')}}">
    <link rel="stylesheet" href="{{asset('web_content/css/theme-animate.css')}}">
    <link href="{{asset('assets_old/plugin/polygot/css/polyglot-language-switcher-website.css')}}" rel="stylesheet" type="text/css">



    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{asset('web_content/css/skins/default.css')}}">

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{asset('web_content/css/custom.css')}}">

    <!-- Head Libs -->
    <script src="{{asset('web_content/vendor/modernizr/modernizr.js')}}"></script>

    <!--[if IE]>
    <link rel="stylesheet" href="{{asset('web_content/css/ie.css')}}">
    <![endif]-->

    <!--[if lte IE 8]>
    <script src="{{asset('web_content/vendor/respond/respond.js')}}"></script>
    <script src="{{asset('web_content/vendor/excanvas/excanvas.js')}}"></script>
    <![endif]-->

    <!-- Vendor -->
    <script src="{{asset('web_content/vendor/jquery/jquery.js')}}"></script>
    <script src="{{asset('web_content/vendor/jquery.appear/jquery.appear.js')}}"></script>
    <script src="{{asset('web_content/vendor/jquery.easing/jquery.easing.js')}}"></script>
    <script src="{{asset('web_content/vendor/jquery-cookie/jquery-cookie.js')}}"></script>
    <script src="{{asset('web_content/vendor/bootstrap/bootstrap.js')}}"></script>
    <script src="{{asset('web_content/vendor/common/common.js')}}"></script>
    <script src="{{asset('web_content/vendor/rs-plugin/js/jquery.themepunch.tools.min.js')}}"></script>
    <script src="{{asset('web_content/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js')}}"></script>
    <script src="{{asset('web_content/vendor/jquery.validation/jquery.validation.js')}}"></script>
    <script src="{{asset('web_content/vendor/jquery.stellar/jquery.stellar.js')}}"></script>
    <script src="{{asset('web_content/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js')}}"></script>
    <script src="{{asset('web_content/vendor/jquery.gmap/jquery.gmap.js')}}"></script>
    <script src="{{asset('web_content/vendor/twitterjs/twitter.js')}}"></script>
    <script src="{{asset('web_content/vendor/isotope/jquery.isotope.js')}}"></script>
    <script src="{{asset('web_content/vendor/owlcarousel/owl.carousel.js')}}"></script>
    <script src="{{asset('web_content/vendor/jflickrfeed/jflickrfeed.js')}}"></script>
    <script src="{{asset('web_content/vendor/magnific-popup/jquery.magnific-popup.js')}}"></script>
    <script src="{{asset('web_content/vendor/vide/vide.js')}}"></script>
    <script src="{{asset('assets_old/plugin/polygot/js/jquery.polyglot.language.switcher.js')}}" type="text/javascript"></script>
    <style type="text/css">iframe.goog-te-banner-frame{ display: none !important;}</style>
    <style type="text/css">body {position: static !important; top:0px !important;}</style>

</head>
<body>
<div class="body">
    <header id="header">



        <div class="container">
            <div class="brlogo">
                <img src="{{asset('assets/images/logo.png')}}" width="350px"/>
            </div>
            <button class="btn btn-responsive-nav btn-inverse" data-toggle="collapse" data-target=".nav-main-collapse">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <div class="navbar-collapse nav-main-collapse collapse">
            <div class="container">

                <nav class="nav-main mega-menu">
                    <ul class="nav nav-pills nav-main" id="mainMenu">
                        <li>
                            <a id="autoconbutton" class="btn btn-primary btn-sm" href="{{ env('SITE_URL') }}/{{$promopages->alias}}" style="color:#FFF;">Continue <span class="fa fa-arrow-right"></span></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <script type="text/javascript"> //<![CDATA[
        var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.comodo.com/" : "http://www.trustlogo.com/");
        document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
        //]]>
    </script>
