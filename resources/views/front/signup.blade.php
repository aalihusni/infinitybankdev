@extends('front.default')
@section('title'){{trans('front.sign_up')}} @Stop
@section('content')

    <body>
    <div id="single-wrapper">
        {!! Form::open(array('url'=>'signup','method'=>'POST','class' => 'frm-single', 'style'=>'max-width: 450px;' )) !!}
        <div class="inside">
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
            <div class="frm-title">New Register</div>
            {!! Form::hidden('referral', $referral, array('class'=>'form-control','placeholder'=>trans('front.referral'))) !!}
            {!! Form::hidden('position', $position, array('class'=>'form-control','placeholder'=>trans('front.referral'))) !!}
            <div class="form-group">
                {!! Form::email('email', '', array('class'=>'form-control','placeholder'=> 'Email Address')) !!}
            </div>
            <div class="form-group">
                {!! Form::password('password', array('class'=>'form-control','placeholder'=>'Password')) !!}
            </div>
            <div class="form-group">
                {!! Form::password('repassword', array('class'=>'form-control','placeholder'=>'Confirm Password')) !!}
            </div>
            <hr>
            <h5 class="margin-bottom-0">Your Referrer Name</h5>
            <p class="help-block" style="margin: 4px 0 22px 0">Check manual if you have referral name.</p>
            <div class="form-group" id="position">
                <div class="radio">
                    <input type="radio" name="referrer" id="default" value="default" >
                    <label for="default">Default (Username: {{ $referral }})</label>
                </div>
                <div class="radio">
                    <input type="radio" name="referrer" id="manual" value="manual" checked>
                    <label for="manual">Manual</label>
                </div>
                <div class="form-group" id="referrer">
                    <div class="form-group">
                        <div class="form-with-icon">
                            {!! Form::text('alias', '', array('id'=>'alias','class'=>'form-control','placeholder'=>'Username')) !!}
                            <span id="usericon" class="icon"> </span>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            @if ($_COOKIE['country_code'] != "CN")
                <div class="margin-bottom-40">
                    <div class="form-group margin-bottom-120" align="center">
                        <div class="input-group ">
                            {!! app('captcha')->display() !!}
                        </div>
                    </div>
                </div>
            @endif
        <!-- Change this to a button or input when using this as a form -->
            {!! Form::submit('Register', array('class'=>'btn btn-primary btn-quirk btn-block ')) !!}
            <br>
            <a href="{{URL::route('login')}}"
               class="btn btn-default btn-block">{{trans('front.already_a_member')}} {{trans('front.login_now')}}</a>
            <!-- /.row -->
            <div class="frm-footer">{{ env("SITE_NAME") }} © {{ date('Y') }}.</div>
            <!-- /.footer -->
        </div>
        {!! Form::close() !!}
    </div>

    <script>
        $('#manual').change(function () {
            $('#referrer').toggle();
        });

        $('#default').change(function () {
            $('#referrer').toggle();
        });

        $('#alias').keyup(function () {
            check_upline();
        });

        $('#alias').change(function () {
            check_upline();
        });

        function check_upline() {
            var alias = $('#alias').val();

            var loadUrl = '{{ URL::to('/') }}/check-alias/' + alias;
            $.ajax({
                url: loadUrl, success: function (result) {
                    if (result == "KO") {
                        $('#usericon').html('<i class="text-success fa fa-check item-icon item-icon-right"></i>');
                    } else {
                        $('#usericon').html('<i class="text-danger fa fa-times item-icon item-icon-right"></i>');
                    }
                }
            });
        }
    </script>
    @Stop