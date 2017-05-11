@extends('member.default')

@section('title'){{trans('payment.payment_confirmation')}} @Stop

@section('menu_main')active @Stop
@section('menu_setting') @Stop

@section('content')

<!-- Page Content -->
<div class="row">
        <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">{{trans('payment.payment_confirmation')}}</h2>
                        <p class="panel-subtitle">{{trans('payment.waiting_for_payment_confirmation')}}</p>
                    </div>
                    <div class="panel-body">

                        <div class="col-md-12 form-horizontal form-bordered">

                            <div class="form-group">
                                <label class="col-md-3 control-label">{{trans('payment.sender_address')}}</label>
                                <div class="col-md-5">
                                    <div class="input-group mb-md">
                                    <input type="text" class="form-control" value="{{ $transaction['sender_address'] }}">
                                    <span class="input-group-btn">
                                        <a class="btn btn-default" type="button" target="_blank" href="https://blockchain.info/address/{{ $transaction['sender_address'] }}"><span class="fa fa-external-link"></span></a>
                                    </span>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-3 control-label">{{trans('payment.receiver_address')}}</label>
                                <div class="col-md-5">
                                    <div class="input-group mb-md">
                                    <input type="text" class="form-control" value="{{ $transaction['receiving_address'] }}">
                                    <span class="input-group-btn">
                                        <a class="btn btn-default" type="button" target="_blank" href="https://blockchain.info/address/{{ $transaction['receiving_address'] }}"><span class="fa fa-external-link"></span></a>
                                    </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">{{trans('payment.transaction_hash')}}</label>
                                <div class="col-md-5">
                                    <div class="input-group mb-md">
                                    <input type="text" class="form-control" value="{{ $transaction['transaction_hash'] }}">
                                    <span class="input-group-btn">
                                        <a class="btn btn-default" type="button" target="_blank" href="https://blockchain.info/tx/{{ $transaction['transaction_hash'] }}"><span class="fa fa-external-link"></span></a>
                                    </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">{{trans('payment.amount')}}</label>
                                <div class="col-md-5">
                                    <label class="control-label -align-left"><span class="fa fa-bitcoin"></span> {{ $transaction['value_in_btc'] }}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-5" id="status">
                                    <label class="control-label -align-left">
                                        <img src="{{asset('assets/images/waiting.gif')}}"/><br>
                                    </label>
                                    <label class="control-label -align-left">
                                        <strong id="confirmations">{{trans('payment.waiting_for_confirmation')}} {{ $transaction['confirmations'] }} {{trans('payment.of')}} 4.</strong>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-5 small">
                                    <label style="font-weight:normal;">
                                        <em>{{trans('payment.redirect_page')}}</em>
                                    </label>
                                </div>
                            </div>

                        </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="well">
            <p><strong>{{trans('payment.instruction')}}</strong></p>
            <p>{{trans('payment.three_of_three')}}</p>
            <p>{{trans('payment.network_fee')}}</p>
            </div>
        </div>
</div>
<script>
    var myTimer = null;

    $(document).ready(function() {
        get_confirmations();
        get_transaction();
        myTimer = setInterval(function(){
            get_confirmations();
            get_transaction();
        }, 5000);
    });

    function get_transaction(){
        var loadUrl = '{{ URL::to('/') }}/blockio-status/{{ $transaction['receiving_address'] }}';
        $.ajax({url: loadUrl, success: function(result) {
            if (result == 2) {
                $('#status').html('Completed');
                clearInterval(myTimer);
            }
        }});
    };

    function get_confirmations(){
        var loadUrl = '{{ URL::to('/') }}/blockio-confirmations/{{ $transaction['receiving_address'] }}';
        $.ajax({url: loadUrl, success: function(result) {
            $('#confirmations').html('Waiting for confirmation ' + result + ' of 3.');
        }});
    };

</script>
<!-- /#page-wrapper -->

@Stop