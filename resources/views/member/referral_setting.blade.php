@extends('member.default')

@section('title'){{trans('member.referral_setting')}} @Stop

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

    <div class="col-md-12">
        <div class="row">

            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">{{trans('member.referral_setting')}}</h2>
                        <p class="panel-subtitle">{{trans('member.referral_setting_details')}}</p>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(array('url'=>'members/referral-setting','method'=>'POST', 'class'=>'form-horizontal form-bordered')) !!}
                        <input type="hidden" name="alias_old" id="alias_old" value="{{ $alias }}"/>
                        <div class="form-group">
                            <label class=" col-md-3 control-label">{{trans('member.referral_link')}}</label>
                            <div class="col-lg-6">
                                <p class="form-control-static">http://bitregion.com/<span id="urlalias" style="font-weight:bold;">{{trans('member.your_username')}}</span></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-md-3 control-label">{{trans('member.change_username')}}</label>
                            <div class="col-md-4">

                                <div class="input-group input-group-icon">
                                    <input type="text" name="alias" id="alias" class="form-control" maxlength="12" required pattern="[a-z0-9]+" value="{{ $alias }}"/>
                                    <span class="input-group-addon">
                                        <span id="usericon" class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!--
                        <div class="form-group">
                            <label class=" col-md-3 control-label">{{trans('member.placement')}}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">{{trans('member.username')}}</span>
                                    <input type="text" class="form-control"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-md-3 control-label">&nbsp;</label>
                            <div class="col-lg-6">
                                <p class="small">{{trans('member.set_default_username')}}</p>
                            </div>
                        </div>
                        -->

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">{{trans('member.update_setting')}}</label>
                            <div class="col-md-4">
                                {!! Form::submit('Update Setting', array('class'=>'btn btn-primary btn-block')) !!}
                            </div>
                        </div>



                        {!! Form::close() !!}
                    </div>
                </div>

            </div>

            <!--
            <div class="col-md-4">
                <div class="well">
                    <p><span class="fa fa-info-circle"></span> <strong>{{trans('member.information')}}</strong></p>

                    <p>{{trans('member.referral_info_1')}}</p>
                    <p><strong>{{trans('member.referral_info_2')}}</strong></p>
                    <p class="small">{{trans('member.referral_info_3')}}<span id="urlalias" style="font-weight:bold;">{{trans('member.referral_info_4')}}</span>{{trans('member.referral_info_5')}}<br>
                        {{trans('member.referral_info_6')}}</p>
                    <p><strong>or</strong></p>
                    <p class="small">{{trans('member.referral_info_3')}}<span id="urlalias" style="font-weight:bold;">{{trans('member.referral_info_4')}}</span>{{trans('member.referral_info_7')}}<br>
                        {{trans('member.referral_info_8')}}</p>
                    <p>{{trans('member.referral_info_9')}}</p>

                </div>
            </div>
            -->
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            $("#ms_timer").countdowntimer({
                dateAndTime : "2015/12/01 00:00:00",
                size : "xs",
                borderColor : "transparent",
                backgroundColor : "transparent",
                fontColor : "#777",
                regexpMatchFormat: "([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})",
                regexpReplaceWith: "$1 days, $2 hours, $3 minutes, $4 seconds."
            });
        });

        (function( $ ) {

            'use strict';

            var datatableInit = function() {

                $('#datatable-default').dataTable();

            };

            $(function() {
                datatableInit();
            });

        }).apply( this, [ jQuery ]);

        $('#alias').keyup(function(){
            check_alias();
        });

        $('#alias').change(function(){
            check_alias();
        });

        function check_alias(){
            var check_alias = new RegExp('^(?=.*[a-z])[0-9a-z]{5,12}$');
            var alias = $('#alias').val();
            var alias_old = $('#alias_old').val();

            if (alias == alias_old)
            {
                $('#usericon').html('<i class="fa fa-check text-success"></i>');
            } else {
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
        }
    </script>
    @Stop