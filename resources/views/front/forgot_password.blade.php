@extends('front.default')
@section('title')Forgot Password @Stop
@section('content')

    <div class="fullscreen-bg">
        <video preload="none" autoplay="true" loop="true" poster="{{asset('assets_old/videos/city_screenshot.jpg')}}" class="fullscreen-bg__video">
            <source src="{{asset('assets_old/videos/city.mp4')}}" type="video/mp4">
        </video>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="hidden-sm hidden-xs" style="margin-left:-130px; margin-top:100px; margin-bottom:-100px;">
                    <img src="{{asset('assets_old/images/logo_large.png')}}" width="600"/>
                </div>
                <div class="login-panel panel panel-default">
                    <img class="visible-sm visible-xs" src="{{asset('assets_old/images/logo_large.png')}}" width="100%" style="margin-top:-80px;"/>
                    <div style="color:white; font-weight:bold; text-align:center; font-size:18px; padding-top:20px;">{{trans('front.send_reset_pw_request')}}</div>
                    <div class="panel-body">

                        @if (isset($success))
                            <div class="success alert-success" style="background-color:transparent; padding-bottom:10px;">
                                <strong>{{ $success }}</strong>
                            </div>
                        @endif

                        {!! Form::open(array('url'=>'password-reset-request','method'=>'POST')) !!}
                        <div class="form-group">
                            {!! Form::email('email', '', array('class'=>'form-control','placeholder'=>trans('front.email'),'tabindex'=>'1')) !!}
                        </div>

                        {!! Form::submit(trans('front.request_pw_reset'), array('class'=>'btn btn-primary btn-block')) !!}
                        <br>

                        {!! Form::close() !!}

                        <div style="color:#fff;">
                            <p><strong>{{trans('front.we_send_pw_to_email')}}</strong></p>
                        </div>
                    </div>

                    <div class="pull-left" style="padding:15px;"><a href="{{URL::route('login')}}">{{trans('front.back_to_login')}}</a></div>

                    <div id="polyglotLanguageSwitcher" class="front_langchooser" style="margin-right:15px;">
                        <form id="updatelang" action="{{URL::route('set-locale')}}">
                            <select id="polyglot-language-options">
                                <option id="en" value="en" @if(Lang::locale() == 'en') selected @endif>English</option>
                                <option id="cn" value="cn" @if(Lang::locale() == 'cn') selected @endif>中文</option>
                            </select>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        $('video').on('ended', function () {
            this.load();
            this.play();
        });


    </script>


    @Stop