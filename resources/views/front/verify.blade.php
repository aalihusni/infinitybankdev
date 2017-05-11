@extends('front.default')
@section('title')Verify Email @Stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="hidden-sm hidden-xs" style="margin-left:-130px; margin-top:100px; margin-bottom:-100px;">
                    <img src="{{asset('assets_old/images/logo_large.png')}}" width="600"/>
                </div>
                <div class="login-panel panel panel-default">
                    <img class="visible-sm visible-xs" src="{{asset('assets_old/images/logo_large.png')}}" width="100%" style="margin-top:-80px;"/>
                    <div style="color:white; font-weight:bold; text-align:center; font-size:18px; padding-top:20px;">{{trans('front.pls_verify_email')}}</div>
                    <div class="panel-body">

                        @if (isset($success))
                            <div class="success alert-success" style="background-color:transparent; padding-bottom:10px;">
                                <strong>{{ $success }}</strong>
                            </div>
                        @endif

                        <div style="color:#fff;">
                            <p><strong>{{trans('front.pls_verify_ownership')}} {{$email}}.</strong></p>

                            <p><em>{{trans('front.if_cant_find_email')}}</em></p>

                            <p><strong>{{trans('front.or_click_button')}}</strong></p>
                            <a href="{{URL::route('resend-verify-email',['data' => $_GET['data']])}}" class="btn btn-default btn-block">{{trans('front.resend_email')}}</a>
                        </div>
                    </div>

                    <div class="pull-left" style="padding:15px;"><a href="{{URL::route('login')}}">{{trans('front.back_to_website')}}</a></div>

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

    @Stop