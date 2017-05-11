@extends('front.default')
@section('title')Login to Dashboard @Stop
@section('content')

    <div id="single-wrapper">
                            {!! Form::open(array('url'=>'login','method'=>'POST', 'class'=>'frm-single')) !!}
                            <div class="inside">
                                @if (isset($success))
                                    <div class="success alert-success" style="background-color:transparent; padding-bottom:10px;">
                                        <strong>{{ $success }}</strong>
                                    </div>
                                @endif
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger" style="background-color:transparent; border:none; color:#F00;">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="title"><strong>Infinite</strong>Bank</div>
                                <!-- /.title -->
                                <div class="frm-title">Login</div>
                             <div class="frm-input">
                                {!! Form::email('email', '', array('class'=>'frm-inp','placeholder'=>'Email','tabindex'=>'1')) !!}<i class="fa fa-user frm-ico"></i>
                            </div>
                            <div class="frm-input">
                                {!! Form::password('password', array('class'=>'frm-inp','placeholder'=>'Password','tabindex'=>'2')) !!}<i class="fa fa-lock frm-ico"></i>
                            </div>
                            @if ($_COOKIE['country_code'] != "CN")
                            <div class="form-group" align="center">
                                <div class="input-group ">
                                    {!! app('captcha')->display() !!}
                                </div>
                            </div>
                            @endif
                                    <div class="clearfix margin-bottom-20">
                                        <div class="pull-left">
                                            <div class="checkbox primary"><input  value="1" type="checkbox" id="rememberme"><label for="rememberme">Remember me</label></div>
                                            <!-- /.checkbox -->
                                        </div>
                                        <!-- /.pull-left -->
                                        <div class="pull-right"><a href="{{URL::route('forgot-password')}}" class="a-link"><i class="fa fa-unlock-alt"></i>Forgot password?</a></div>
                                        <!-- /.pull-right -->
                                    </div>

                            {!! Form::submit(trans('front.login'), array('class'=>'btn btn-primary btn-block')) !!}
                            <br>
                            <a href="{{URL::route('signup')}}" class="btn btn-default btn-block">{{trans('front.not_a_member_sign_up')}}</a>
                                    <div class="frm-footer">{{ env("SITE_NAME") }} © {{ date('Y') }}.</div>
                            </div>
                            {!! Form::close() !!}

    </div>
    @Stop