@extends('member.default')

@section('title')Upgrade @Stop

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
                                <br>To upgrade your account, you must provide assistant to qualified member. Please make your payment using Bitcoin as the following information below. You have 1 hour to complete this transaction.
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Bitcoin QR</label>
                                <div class="col-md-5">
                                    <div class="row">
                                        {!! QrCode::size(200)->margin(1)->errorCorrection('L')->generate('bitcoin:'.$upgrade_details['receiving_address'].'?amount='.$upgrade_details['class_details']['class_value_upgrade']) !!}
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-3 control-label">Wallet Address</label>
                                <div class="col-md-5">
                                    <label class="control-label -align-left">{{ $upgrade_details['receiving_address'] }}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Amount</label>
                                <div class="col-md-5">
                                    <label class="control-label -align-left"><span class="fa fa-bitcoin"></span> {{ $upgrade_details['class_details']['class_value_upgrade'] }}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Timeout</label>
                                <div class="col-md-5">
                                    <label class="control-label -align-left"> <span id="ms_timer"><span></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-5">
                                    <label class="control-label -align-left">
                                        <img src="{{asset('assets/images/waiting.gif')}}"/><br>
                                    </label>
                                    <label class="control-label -align-left">
                                        <strong>Waiting for your payment.</strong>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-5 small">
                                    <label style="font-weight:normal;">
                                        <em>This page will be automatically redirected after you complete your payment.</em>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-4 well">
                            <p><strong>Instructions</strong></p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sapien nisl, volutpat quis accumsan vitae, pharetra eget ante. Phasellus vel ligula eget metus ornare interdum. In maximus mi eget nisi facilisis, vel fermentum sapien auctor. In eu est varius, mollis tortor quis, molestie metus.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /#page-wrapper -->

@Stop