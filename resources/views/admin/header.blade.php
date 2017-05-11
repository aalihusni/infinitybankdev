<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{env('SITE_NAME')}} | ADMIN | @yield('title')</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('assets_old/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{asset('assets_old/bower_components/metisMenu/dist/metisMenu.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('assets_old/dist/css/sb-admin-2.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{asset('assets_old/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('assets_old/plugin/polygot/css/polyglot-language-switcher.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{asset('assets/vendor/magnific-popup/magnific-popup.css')}}" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="{{asset('assets_old/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('assets_old/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets_old/plugin/polygot/js/jquery.polyglot.language.switcher.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets_old/bower_components/metisMenu/dist/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets_old/dist/js/sb-admin-2.js')}}"></script>
    <script src="{{asset('assets_old/plugin/flagstrap/js/jquery.flagstrap.min.js')}}" type="text/javascript"></script>
    <script src="//cdn.ckeditor.com/4.5.5/standard/ckeditor.js"></script>
    <script src="{{asset('assets/vendor/magnific-popup/magnific-popup.js')}}"></script>

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    @if (\App\Classes\AdminClass::checkLastCron(1) != false)
        <div class="alert alert-danger">
            <a href="{{URL::route('cron')}}" style="color:#a94442; text-decoration:none"><strong>ALERT !!! : </strong>Last cron run is {{ \App\Classes\AdminClass::checkLastCron() }} hours ago.</a>
        </div>
    @endif
    @if (\App\Classes\AdminClass::checkLastFullCron(1) != false)
        <div class="alert alert-danger">
            <a href="{{URL::route('cron')}}" style="color:#a94442; text-decoration:none"><strong>ALERT !!! : </strong>Last full cron run is {{ \App\Classes\AdminClass::checkLastFullCron() }} hours ago.</a>
        </div>
    @endif
    @if (\App\Classes\AdminClass::checkLastCron(2) != false)
        <div class="alert alert-danger">
            <a href="{{URL::route('cron')}}" style="color:#a94442; text-decoration:none"><strong>ALERT !!! : </strong>Last PAGB cron run is {{ \App\Classes\AdminClass::checkLastCron() }} hours ago.</a>
        </div>
    @endif
    @if (\App\Classes\AdminClass::checkLastFullCron(2) != false)
        <div class="alert alert-danger">
            <a href="{{URL::route('cron')}}" style="color:#a94442; text-decoration:none"><strong>ALERT !!! : </strong>Last PAGB full cron run is {{ \App\Classes\AdminClass::checkLastFullCron() }} hours ago.</a>
        </div>
    @endif
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{URL::route('admin-home')}}">{{env('SITE_NAME')}} | Administrator</a>
        </div>
        <!-- /.navbar-header -->

        <div id="polyglotLanguageSwitcher" class="front_langchooser" style="margin-right:20px;">
            <form id="updatelang" action="{{URL::route('set-locale')}}">
                <select id="polyglot-language-options">
                    <option id="en" value="en" @if(Lang::locale() == 'en') selected @endif>English</option>
                    <option id="my" value="my" @if(Lang::locale() == 'my') selected @endif>Bahasa</option>
                </select>
            </form>
        </div>

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-messages">
                    <li>
                        <a href="#">
                            <div>
                                <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                            </div>
                            <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                            </div>
                            <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                            </div>
                            <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>Read All Messages</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
                <!-- /.dropdown-messages -->
            </li>
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-tasks">
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong>Task 1</strong>
                                    <span class="pull-right text-muted">40% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                        <span class="sr-only">40% Complete (success)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong>Task 2</strong>
                                    <span class="pull-right text-muted">20% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                        <span class="sr-only">20% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong>Task 3</strong>
                                    <span class="pull-right text-muted">60% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                        <span class="sr-only">60% Complete (warning)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong>Task 4</strong>
                                    <span class="pull-right text-muted">80% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                        <span class="sr-only">80% Complete (danger)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>See All Tasks</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
                <!-- /.dropdown-tasks -->
            </li>
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-comment fa-fw"></i> New Comment
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                <span class="pull-right text-muted small">12 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-envelope fa-fw"></i> Message Sent
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-tasks fa-fw"></i> New Task
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>See All Alerts</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
                <!-- /.dropdown-alerts -->
            </li>
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="{{URL::route('personal-info')}}"><i class="fa fa-user fa-fw"></i> {{trans('member.personal_info')}}</a>
                    </li>
                    <li><a href="{{URL::route('communication-info')}}"><i class="fa fa-gear fa-fw"></i> {{trans('member.communication_info')}}</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{URL::route('logout')}}"><i class="fa fa-sign-out fa-fw"></i> {{trans('member.logout')}}</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        @include('admin.menu')
        <!-- /.navbar-static-side -->
    </nav>