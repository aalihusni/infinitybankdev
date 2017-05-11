@extends('front.default')
@section('title')Please fill your profile @Stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-md-offset-3">
                <div class="login-panel panel panel-default margin-top-50">

                    <div class="panel-body">
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                <div>{{ Session::get('success') }}</div>
                            </div>
                        @endif

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <h3 class="panel-title" style="margin-bottom:20px; color:#fff;">{{trans('member.please_complete_profile')}}</h3>
                        <div class="col-md-8">
                            {!! Form::open(array('url'=>'complete-profile','method'=>'POST')) !!}
                            <div class="form-group">
                                <label>{{trans('member.username')}}</label>
                                {!! Form::text('alias', '', array('class'=>'form-control', 'id'=>'username_b')) !!}
                            </div>

                            <div class="form-group">
                                <label>{{trans('member.firstname')}}</label>
                                {!! Form::text('firstname', '', array('class'=>'form-control', 'id'=>'firstname_b')) !!}
                            </div>

                            <div class="form-group">
                                <label>{{trans('member.lastname')}}</label>
                                {!! Form::text('lastname', '', array('class'=>'form-control', 'id'=>'lastname_b')) !!}
                            </div>

                            <div class="form-group">
                                <label>Bitcoin Wallet Address</label>
                                {!! Form::text('wallet_address', '', array('class'=>'form-control', 'id'=>'wallet_address')) !!}
                                <span class="small text-muted">If you don't have any bitcoin Wallet, <a class="text-default" href="{{URL::route('bitcoinwallet')}}" target="_blank">CLICK HERE</a> to create.</span>
                            </div>

                            <div class="form-group">
                                <label>{{trans('member.country')}}</label>
                                <div id="basic" data-input-name="country_code" data-selected-country=""></div>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary btn-block">{{trans('member.continue')}}</button>
                            </div>

                            {!! Form::close() !!}
                        </div>
                            <div class="col-md-4 text-center">
                                {!! Form::open(array('id'=>'uploadpicform','url'=>'members/upload-profile-pic','method'=>'POST', 'files'=>true, 'class'=>'form-horizontal form-bordered')) !!}
                                <br>
                                <img class="img-rounded" src="@if(Auth::user()->profile_pic){{S3Files::url('profiles/'.Auth::user()->profile_pic)}} @else {{asset('profiles/no_img.jpg')}} @endif"/>
                                <div class="form-group">
                                    <label class="small text-muted">{{trans('member.profile_picture')}}</label>
                                    {!! Form::file('image', array('id'=>'uploadprofilepic','class'=>'form-control', 'style'=>'display:none;')) !!}
                                    <div class="btn btn-default btn-sm btn-block uploadpic">{{trans('member.upload_photo')}}</div>
                                    <input id="username_a" name="alias" type="hidden" value="{{old('alias')}}">
                                    <input id="firstname_a" name="firstname" type="hidden" value="{{old('firstname')}}">
                                    <input id="lastname_a" name="lastname" type="hidden" value="{{old('lastname')}}">
                                </div>
                                {!! Form::close() !!}
                            </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $( ".uploadpic" ).click(function() {
            $( "#uploadprofilepic" ).click();
        });

        $( "#uploadprofilepic" ).change(function() {
            $( "#uploadpicform" ).submit();
        });

        $('#username_b').change(function(){
            $('#username_a').val($('#username_b').val());
        })

        $('#firstname_b').change(function(){
            $('#firstname_a').val($('#firstname_b').val());
        })

        $('#lastname_b').change(function(){
            $('#lastname_a').val($('#lastname_b').val());
        })


        jQuery.ajax( {
            //url: '{{ str_replace("http://","https://",URL::to('/').'/geoip/') }}',
            url: 'https://{{ str_replace("www.","", Request::server("SERVER_NAME")) }}/geoip/{{ App\Classes\IPClass::getip() }}',
            type: 'GET',
            dataType: 'json',
            success: function(location) {
                $('#basic').attr('data-selected-country',location.country_code);

            }
        } );

        $('#basic').flagStrap({
            buttonSize: "btn-md btn-block",
            labelMargin: "10px",
            scrollable: true,
            scrollableHeight: "300px"
        });

    </script>
    @Stop