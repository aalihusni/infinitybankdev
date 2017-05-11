@extends('member.default')

@section('title'){{ trans('member.register_new_member') }} @Stop

@section('newmember-class')nav-active @Stop

@section('content')

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Page Content -->
<div class="col-md-12">
    <div class="row">

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">{{ trans('member.register_new_member') }}</h2>
                    <p class="panel-subtitle">{{ trans('member.register_subline') }}</p>
                </div>
                <div class="panel-body">
                    {!! Form::open(array('url'=>'members/new-member','method'=>'POST', 'class'=>'form-horizontal form-bordered','id'=>'registernewmember')) !!}

                    <div class="form-group">
                        <label class="col-md-3 control-label">{{ trans('member.username') }}</label>
                        <div class="col-md-6">
                            <div class="input-group input-group-icon">
                                <input type="text" name="alias" id="alias" class="form-control" required pattern="[a-z0-9]+">
                                    <span class="input-group-addon">
                                        <span id="usericon" class="icon"></span>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault"></label>
                        <div class="col-md-6 text-muted small">
                            <label>{{ trans('member.pw_restrict') }}
                            </label>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">{{trans('member.firstname')}}</label>
                        <div class="col-md-6">
                            {!! Form::text('firstname', old('firstname'), array('class'=>'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">{{trans('member.lastname')}}</label>
                        <div class="col-md-6">
                            {!! Form::text('lastname', old('lastname'), array('class'=>'form-control', 'value'=>Auth::user()->lastname)) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">{{trans('member.country')}}</label>
                        <div class="col-md-6">
                            <div id="basic" data-input-name="country_code" data-selected-country="{{ old('country_code') }}"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault"></label>
                        <div class="col-md-6 text-muted small">
                            <label>{{trans('member.user_verify_to_complete')}}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">{{trans('member.new_email')}}</label>
                        <div class="col-md-6">
                            {!! Form::text('email', old('email'), array('class'=>'form-control' )) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">{{trans('member.new_password')}}</label>
                        <div class="col-md-6">
                            {!! Form::password('password', array('class'=>'form-control' )) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">{{trans('member.repeat_new_password')}}</label>
                        <div class="col-md-6">
                            {!! Form::password('repassword', array('class'=>'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault"></label>
                        <div class="col-md-6 text-muted small">
                            <label>{{trans('member.enter_bitcoin_wallet')}}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class=" col-md-3 control-label">{{trans('member.wallet_address')}}</label>
                        <div class="col-md-6">
                            {!! Form::text('wallet_address', old('wallet_address'), array('class'=>'form-control' )) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault"></label>
                        <div class="col-md-6 text-muted small">
                            <label>{{trans('member.place_position')}}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">{{trans('member.placement')}}</label>
                        <div class="mb-md col-md-6">
                            <div class="input-group ">
                            <span class="input-group-addon ">{{trans('member.username')}}</span>
                            <input type="text" name="upline" id="upline" class="form-control"/>
                            <span class="input-group-addon">
                                <span id="usericon2" class="icon"></span>
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="position" style="display: none;">
                        <label class="col-md-3 control-label" for="inputDefault">{{trans('member.position')}}</label>
                        <div class="col-md-6">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="position" id="post1" value="1">
                                    Left
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="position" id="post2" value="2">
                                    Center
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="position" id="post3" value="3">
                                    Right
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault"></label>
                        <div class="col-md-4">
                            <a class="btn btn-primary" data-toggle="modal" data-target="#upgradeModal">{{trans('member.register_new_account')}}</a>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="well">
                <p><strong>{{trans('member.instruction')}}</strong></p>
                <p>{{trans('member.i_one')}}</p>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="upgradeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">{{trans('member.u_r_about_to_reg_new_acc')}}</h4>
            </div>
            <div class="modal-body">
                {{trans('member.deduct_one_passport')}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('member.i_Will_decide_later')}}</button>
                <a href="#" id="reg_continue" class="btn btn-primary">{{trans('member.continue_register')}}</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- /#page-wrapper -->

<script type="text/javascript">
    $('#reg_continue').click(function(){
        $('#registernewmember').submit();
    })

    $('#alias').keyup(function(){
        check_alias();
    });

    $('#alias').change(function(){
        check_alias();
    });

    $('#upline').keyup(function(){
        check_upline();
    });

    $('#upline').change(function(){
        check_upline();
    });

    function check_alias(){
        var check_alias = new RegExp('^(?=.*[a-z])[0-9a-z]{5,12}$');
        var alias = $('#alias').val();

        if (check_alias.test(alias)) {
            var loadUrl = '{{ URL::to('/') }}/check-alias/' + alias;
            $.ajax({
                url: loadUrl, success: function (result) {
                    if (result == "OK") {
                        $('#usericon').html('<i class="fa fa-check text-success"></i>');
                    } else {
                        $('#usericon').html('<i class="fa fa-remove text-danger"></i>');
                    }
                }
            });
        } else {
            $('#usericon').html('<i class="fa fa-remove text-danger"></i>');
        }
    }

    function check_upline(){
        var alias = $('#upline').val();
        var upline_id = {{ Auth::user()->id }};
        $('#post1').prop('checked', false);
        $('#post2').prop('checked', false);
        $('#post3').prop('checked', false);

        if (upline == "")
        {
            $('#usericon2').html('<i class="fa fa-remove text-danger"></i>');
            $('#position').hide();
        } else {
            var loadUrl = '{{ URL::to('/') }}/check-upline/' + alias + '/' + upline_id;
            $.ajax({
                url: loadUrl, success: function (result) {
                    var obj = $.parseJSON(result);
                    var obj2 = obj.position;

                    if (obj.slot > 0) {
                        $('#usericon2').html('<i class="fa fa-check text-success"></i>');
                        $('#position').show();

                        if (obj2.slot1 == 1) {
                            $('#post1').prop('disabled', true);
                        } else {
                            $('#post1').prop('disabled', false);
                        }

                        if (obj2.slot2 == 1) {
                            $('#post2').prop('disabled', true);
                        } else {
                            $('#post2').prop('disabled', false);
                        }

                        if (obj2.slot3 == 1) {
                            $('#post3').prop('disabled', true);
                        } else {
                            $('#post3').prop('disabled', false);
                        }
                    } else {
                        $('#usericon2').html('<i class="fa fa-remove text-danger"></i>');
                        $('#position').hide();
                    }
                }
            });
        }
    }

    jQuery.ajax( {
        //url: '{{ str_replace("http://","https://",URL::to('/').'/geoip/') }}',
        url: 'https://{{ str_replace("www.","", Request::server("SERVER_NAME")) }}/geoip/{{ App\Classes\IPClass::getip() }}',
        type: 'GET',
        dataType: 'json',
        success: function(location) {
            $('#basic').attr('data-selected-country',location.country_code);

            $('#basic').flagStrap({
                buttonSize: "btn-md btn-block",
                labelMargin: "10px",
                scrollable: true,
                scrollableHeight: "300px"
            });
        }
    } );
</script>
@Stop