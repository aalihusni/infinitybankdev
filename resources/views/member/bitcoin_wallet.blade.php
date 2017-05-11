@extends('member.default')

@section('title'){{trans('member.bitcoin_wallet')}} @Stop

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
                        <h2 class="panel-title">{{trans('member.bitcoin_wallet')}}</h2>
                        <p class="panel-subtitle">{{trans('member.bitcoin_wallet_desc')}}</p>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(array('url'=>'members/update-wallet','method'=>'POST', 'class'=>'form-horizontal form-bordered')) !!}


                        <div class="form-group">
                            <label class=" col-md-3 control-label">{{trans('member.wallet_address')}}</label>
                            <div class="col-md-6">
                                {!! Form::text('wallet_address', empty(old('wallet_address')) ? Auth::user()->wallet_address : old('wallet_address'), array('class'=>'form-control' )) !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <label class=" col-md-3 control-label">&nbsp;</label>
                            <div class="col-lg-6">
                                <p class="small">{{trans('member.do_not_exchange')}}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">{{trans('member.update_bitcoin_wallet')}}</label>
                            <div class="col-md-4">
                                {!! Form::submit('Update Bitcoin Wallet', array('class'=>'btn btn-primary btn-block')) !!}
                            </div>
                        </div>



                        {!! Form::close() !!}
                    </div>
                </div>

            </div>

            <div class="col-md-4">
                <div class="well">
                    <p><span class="fa fa-info-circle"></span> <strong>Information</strong></p>
                    <p><strong>STEP 1:</strong> Create a Bitcoin wallet. Popular Bitcoin wallets are like:<p>
                    <ul>
                        <li>Blockchain</li>
                        <li>Coinbase</li>
                        <li>ChangeTip</li>
                    </ul>
                    <br>
                    <p>This wallet is served like your online bank account. Please do not exchange the private keys with anyone else.</p>
                    <p><strong>STEP 2:</strong> Change your fiat-currency to put some Bitcoin in your wallet from the exchangers like:</p>
                    <ul>
                        <li>Bitfinex</li>
                        <li>Coinbase</li>
                        <li>Cryptsy</li>
                    </ul>
                    <br>
                    <p>These exchangers also can transfer your Bitcoin back to your fiat-currency, if you need to be in that form back.</p>
                    <p><strong>STEP 3:</strong> Save and multiply your Bitcoin in your Bitregion account. Leverage the power of community to earn more Bitcoins</p>
                </div>
            </div>
        </div>
    </div>

@Stop