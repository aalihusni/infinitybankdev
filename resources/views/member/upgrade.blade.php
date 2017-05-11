@extends('member.default')

@section('title'){{ trans('upgrade.upgrade') }} @Stop

@section('menu_main')active @Stop
@section('menu_setting') @Stop

@section('content')

        <!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">

        <div class="col-md-12">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <div class="col-md-8 form-horizontal form-bordered">

                            <div class="form-group col-md-12">
                                <br>{{ trans('upgrade.to_upgrade_account') }}
                            </div>

                            @if ($time_left['min'] > 0 || $time_left['sec'] > 0)
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ trans('upgrade.bitcoin_qr') }}</label>
                                <div class="col-md-6">
                                    <div class="row">
                                        <img class="qrcode" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(500)->margin(1)->errorCorrection('L')->generate('bitcoin:'.$upgrade_details['receiving_address'].'?amount='.$upgrade_details['class_details']['class_value_upgrade'])) !!} ">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ trans('upgrade.address') }}</label>
                                <div class="col-md-6">
                                    <input id="copyaddress" class="form-control" value="{{ $upgrade_details['receiving_address'] }}"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ trans('upgrade.amount') }}</label>
                                <div class="col-md-6">
                                    <label class="control-label -align-left">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-bitcoin"></span></span>
                                            <input id="copyamount" class="form-control col-lg-12" value="{{ $upgrade_details['class_details']['class_value_upgrade'] }}"/>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-6 small">
                                    <div class="alert alert-danger">
                                        <ul>
                                            <li>
                                                Please make sure that your Bitcoin app is configured to automatically <strong>include mining fee</strong> and <strong>pay exact amount</strong> as shown above or payment will not go through.
                                            </li>
                                            <li>
                                                Any error by participants is not reversible or refundable.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ trans('upgrade.timeout') }}</label>
                                <div class="col-md-6">
                                    <label class="control-label -align-left"> <span id="ms_timer"><span></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-6">
                                    <div>
                                        <img class="payment-waiting" src="{{asset('assets/images/waiting.gif')}}"/><br>
                                    </div>
                                    <div class="payment-waiting-text">
                                        <strong>{{ trans('upgrade.waiting_for_payment') }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-5 small">
                                    <label style="font-weight:normal;">
                                        <em>{{ trans('upgrade.redirect_page') }}</em>
                                    </label>
                                </div>
                            </div>
                            @else
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ trans('upgrade.bitcoin_qr') }}</label>
                                <div class="col-md-6">
                                    <div class="row">
                                        <img class="qrcode" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(500)->margin(1)->errorCorrection('L')->merge('/public/img/timeout.jpg')->generate('TIME OUT')) !!} ">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ trans('upgrade.address') }}</label>
                                <div class="col-md-6">
                                    <input id="copyaddress" class="form-control" value="TIME OUT"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ trans('upgrade.amount') }}</label>
                                <div class="col-md-6">
                                    <label class="control-label -align-left">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-bitcoin"></span></span>
                                            <input id="copyamount" class="form-control col-lg-12" value="TIME OUT"/>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ trans('upgrade.timeout') }}</label>
                                <div class="col-md-6">
                                    <div class="payment-waiting-text">
                                        <strong>TIME OUT</strong>
                                    </div>
                                </div>
                            </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-5 small">
                                        <label style="font-weight:normal;">
                                            <em>{{ trans('upgrade.try_in_five') }}</em>
                                        </label>
                                    </div>
                                </div>
                            @endif

                        </div>

                        <div class="col-md-4 well">
                            <p><strong>{{ trans('upgrade.instruction') }}</strong></p>
                            <p>{{ trans('upgrade.i_one') }}</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    var timerCheckEmpty = null;

    $(document).ready(function() {
        check_status();
        manual_callback();
        setInterval(function(){
            check_status();
        }, 1000);
        setInterval(function(){
            manual_callback();
        }, 5000);
        timerCheckEmpty = setInterval(function(){
            check_empty();
        }, 2000);
    });

    @if ($time_left['min'] > 0 || $time_left['sec'] > 0)
    $(function(){
        $('#ms_timer').countdowntimer({
            minutes : {{ $time_left['min'] }},
            seconds : {{ $time_left['sec'] }},
            size : "lg",
            borderColor : "transparent",
            backgroundColor : "transparent",
            fontColor : "#000"
        });
    });
    @endif

    function check_empty()
    {
        clearInterval(timerCheckEmpty);

        var receiving_address = $('#copyaddress').val();
        var value_in_btc = $('#copyamount').val();

        if ($.trim(receiving_address) == "" || $.trim(value_in_btc) == "")
        {
            location.reload();
        }
    }

    function check_status(){
        var loadUrl = '{{ URL::to('/') }}/blockio-status/{{ $upgrade_details['receiving_address'] }}';
        $.ajax({url: loadUrl, success: function(result) {
            if (result >= 1) {
                window.location.href = '{{ URL::route('payment-confirmation') }}';
            }
        }});
    };

    function manual_callback(){
        var loadUrl = '{{ URL::to('/') }}/blockio-single-callback/{{ $upgrade_details['receiving_address'] }}';
        $.ajax({url: loadUrl, success: function(result) {
            if (result == "") {

            }
        }});
    }

    $('#copyaddress').click(function () {
        $(this).select();
    });

    $('#copyamount').click(function () {
        $(this).select();
    });
</script>
<!-- /#page-wrapper -->

@Stop