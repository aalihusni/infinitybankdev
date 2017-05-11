<!doctype html>
<html class="fixed header-dark">
<head>

    <!-- Basic -->
    <meta charset="UTF-8">

    <title>@yield('title') - {{env('SITE_NAME')}}</title>
    <meta name="keywords" content="member infinitebank dashboard"/>
    <meta name="description" content="Member Dashboard">
    <meta name="author" content="{{ env('SITE_NAME') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="hexto" content="{{ csrf_token() }}">
    <meta name="hexid" content="{{ Auth::user()->id }}">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('/favicon-16x16.png') }}" sizes="16x16">
    <link rel="icon" type="image/png" href="{{ asset('/favicon-16x16.png') }}" sizes="16x16">

    <!-- Main Styles -->

    <link rel="stylesheet" href="{{ asset('backe/styles/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backe/styles/color/dark-green.min.css') }}">
    <!-- mCustomScrollbar -->
    <link rel="stylesheet" href="{{ asset('backe/plugin/mCustomScrollbar/jquery.mCustomScrollbar.min.css') }}">
    <!-- Waves Effect -->
    <link rel="stylesheet" href="{{ asset('backe/plugin/waves/waves.min.css') }}">
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="{{ asset('backe/plugin/sweet-alert/sweetalert.css') }}">
    <!-- Google Design Iconic -->
    <link rel="stylesheet" href="{{ asset('backe/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css') }}">

    <!-- Percent Circle -->
    <link rel="stylesheet" href="{{ asset('backe/plugin/percircle/css/percircle.css') }}">
    <!-- Chartist Chart -->
    <link rel="stylesheet" href="{{ asset('backe/plugin/chart/chartist/chartist.min.css') }}">

    <!-- start js -->
    <!-- start javascript emp3r0r -->
    <!--/#wrapper -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="{{ asset('backe/script/html5shiv.min.js')}}"></script>
    <script src="{{ asset('backe/script/respond.min.js')}}"></script>
    <![endif]-->
    <!--
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('backe/scripts/jquery.min.js')}}"></script>
    <script src="{{ asset('backe/scripts/modernizr.min.js')}}"></script>
    <script src="{{ asset('backe/plugin/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('backe/plugin/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script src="{{ asset('backe/plugin/sweet-alert/sweetalert.min.js')}}"></script>
    @include('sweet::alert')
    <script src="{{ asset('backe/plugin/waves/waves.min.js')}}"></script>
    <!-- Full Screen Plugin -->
    <script src="{{asset('backe/plugin/countdownTimer/jquery.countdownTimer.js')}}"></script>
    <!-- Percent Circle -->
    <script src="{{ asset('backe/plugin/percircle/js/percircle.js')}}"></script>
    <!-- Google Chart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Chartist Chart -->
    <script src="{{ asset('backe/plugin/chart/chartist/chartist.min.js')}}"></script>
    <script src="{{ asset('backe/scripts/chart.chartist.init.min.js')}}"></script>
    <!-- FullCalendar -->
    <script src="{{ asset('backe/plugin/moment/moment.js')}}"></script>


    <!-- end javascript emp3r0r -->


</head>
<body>
<div class="main-menu">
    <header class="header">
        <a href="{{ url('members/home') }}" class="logo">{{ env('SITE_NAME') }}</a>
        <button type="button" class="button-close fa fa-times js__menu_close"></button>
        <div class="user">
            <a href="#" class="avatar"><img
                        src="@if(Auth::user()->profile_pic == "no_img.jpg") {{asset('profiles/no_img.jpg')}} @else {{S3Files::url('profiles/'.Auth::user()->profile_pic)}}  @endif"
                        alt="avatar"></a>
            <h5 class="name"><a href="#">{{Auth::user()->alias}}</a></h5>
            <h5 class="position">{{ \App\Classes\UserClass::getUserClass(Auth::user()->id)['user_class_name'] }}</h5>
            <!-- /.name -->
            <div class="control-wrap js__drop_down">
                <i class="fa fa-caret-down js__drop_down_button"></i>
                <div class="control-list">
                    <div class="control-item"><a href="#"><i class="fa fa-user"></i> Profile</a></div>
                    <div class="control-item"><a href="#"><i class="fa fa-gear"></i> Settings</a></div>
                    <div class="control-item"><a href="{{URL::route('logout')}}"><i class="fa fa-sign-out"></i> Log out</a>
                    </div>
                </div>
                <!-- /.control-list -->
            </div>
            <!-- /.control-wrap -->
        </div>
        <!-- /.user -->
    </header>
    <!-- /.header -->
    <!-- /.main-menu -->
    @if(Auth::user()->user_type == '3')
        @include('member.menu_unreg')
    @else
        @include('member.menu_unreg')
    @endif
</div>
<div class="fixed-navbar">
    <div class="pull-left">
        <button type="button" class="menu-mobile-button glyphicon glyphicon-menu-hamburger js__menu_mobile"></button>
        <h1 class="page-title">@yield('title')</h1>
        <!-- /.page-title -->
    </div>
    <!-- /.pull-left -->
    <div class="pull-right">
        @if (isset($_COOKIE['cookieFile']))
            @if (Crypt::decrypt($_COOKIE['cookieFile']))
                <li>
                    <a href="{{ URL::to('/') }}/admin/quick-login/1" class="clearfix">Admin Page</a>
                </li>
            @endif
        @endif
    <!-- /.ico-item -->
        <?php $shares_balance = number_format(\App\Classes\SharesClass::getSharesBalance(Auth::user()->id)['shares_balance'], 8) ?>
        <a class="btn btn-icon btn-icon-left btn-primary btn-xs waves-effect waves-light"><i
                    class="ico fa fa-bitcoin"></i>{{ $shares_balance }}</a>
        <?php $emails = App\Classes\EmailClass::get_all_email(Auth::user()->id, "", "", "", 5) ?>
        <?php $email_count = App\Classes\EmailClass::get_email_count(Auth::user()->id, 0) ?>
        @if(!$email_count>0)
            <a href="#" class="ico-item pulse"><span class="ico-item fa fa-envelope notice-alarm js__toggle_open"
                                                     data-target="#message-popup"></span></a>
        @else
            <a href="#" class="ico-item fa fa-envelope notice-alarm js__toggle_open" data-target="#message-popup"></a>
        @endif
        <a href="#"
           class="ico-item  @if(Auth::user()->selfie_verify_status < 1 && Auth::user()->id_verify_status < 1) pulse @endif"><span
                    class="ico-item fa fa-bell notice-alarm js__toggle_open"
                    data-target="#notification-popup"></span></a>
        <a href="{{URL::route('logout')}}" class="ico-item fa fa-power-off"></a>
    </div>
    <!-- /.pull-right -->
</div>
<!-- /.fixed-navbar -->

<div id="notification-popup" class="notice-popup js__toggle" data-space="75">
    <h2 class="popup-title">Your Notifications</h2>
    <!-- /.popup-title -->
    <div class="content">
        <ul class="notice-list" style="margin-bottom:0">
            @if(Auth::user()->id_verify_status < 1)
                <li>
                    <a href="{{URL::route('verification')}}">
                        <span class="avatar"><img src="{{ asset('img/warning-icon.png') }}" alt=""></span>
                        <span class="name">Please verify your identity</span>
                        <span class="desc">Click here to verify your identity</span>
                    </a>
                </li>
            @endif
            @if(Auth::user()->selfie_verify_status < 1)
                <li>
                    <a href="#">
                        <span class="avatar"><img src="{{ asset('img/warning-icon.png') }}" alt=""></span>
                        <span class="name">Please verify your photo</span>
                        <span class="desc">Click here to verify your identity</span>
                    </a>
                </li>
            @endif
        </ul>
        {{--<!-- /.notice-list -->--}}
        {{--<a href="#" class="notice-read-more">See more messages <i class="fa fa-angle-down"></i></a>--}}
    </div>
    <!-- /.content -->
</div>
<!-- /#notification-popup -->
<div id="message-popup" class="notice-popup js__toggle" data-space="75">

    @if (!empty($emails))
        @if (count($emails))
            <h2 class="popup-title">Recent Messages</h2>
            <!-- /.popup-title -->
            <div class="content">
                <ul class="notice-list">
                    @foreach($emails as $email)
                        @if ($email->status)
                            <?php $strong_start = "" ?>
                            <?php $strong_end = "" ?>
                        @else
                            <?php $strong_start = "<strong>" ?>
                            <?php $strong_end = "</strong>" ?>
                        @endif
                        <li>
                            <a href="{{ URL::route('emails') }}?view={{ Crypt::encrypt($email->id) }}">
                                <span class="avatar"><img src="{{ asset('img/mailbox-icon.png') }}" alt=""></span>
                                <span class="name">{!! $strong_start !!}{{ env('SITE_NAME') }}{!! $strong_end !!}</span>
                                <span class="desc">{!! $strong_start !!}{{ $email->subject }}{!! $strong_end !!}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <!-- /.notice-list -->
                <a href="{{URL::route('emails')}}" class="notice-read-more">See more messages <i
                            class="fa fa-angle-down"></i></a>
            </div>
        @else
            <h2 class="popup-title">Inbox</h2>
            <!-- /.popup-title -->
            <div class="content">
                <ul class="notice-list">
                    <li>
                        <a href="#">
                            <span class="name">No Message</span>
                            <span class="desc">Your inbox is empty.</span>
                        </a>
                    </li>
                </ul>
                <a href="{{URL::route('emails')}}" class="notice-read-more">Go to inbox <i class="fa fa-angle-down"></i></a>
            </div>
    @endif
@endif
<!-- /.content -->
</div>
<!-- /#message-popup -->