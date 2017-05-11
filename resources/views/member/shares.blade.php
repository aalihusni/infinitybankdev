@extends('member.default')

@section('title') {{trans('brshare.br_Shares')}} @Stop

@section('shares-class')nav-active @Stop

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
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">


            <div id="ref_generation" class="col-lg-4">
                <section class="panel">
                    <div class="panel-body bg-primary">
                        <div class="widget-summary widget-summary-md">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon">
                                    <i class="fa"><img src="{{asset('assets/images/brwallet_ico_white.png')}}" width="70"/></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">{{trans('brshare.br_Shares')}}</h4>
                                    <div class="info">
                                        <strong class="amount" id="profit_bonus">{{ $shares_balance['shares_balance'] }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="panel panel-yellow">

                    <div class="panel-footer">
                        <span class="pull-left">{{trans('brshare.pr')}}</span>
                        <span class="pull-right"><strong> {{ number_format($shares_balance_type['PR']['shares_balance'],8) }}</strong></span>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left">{{trans('brshare.po')}}</span>
                        <span class="pull-right"><strong> {{ number_format($shares_balance_type['PO']['shares_balance'],8) }}</strong></span>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left">{{trans('brshare.phc')}}</span>
                        <span class="pull-right"><strong> {{ number_format($shares_balance_type['PH']['shares_balance'],8) }}</strong></span>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left">{{trans('brshare.phd')}}</span>
                        <span class="pull-right"><strong> {{ number_format($shares_balance_type['PHD']['shares_balance'],8) }}</strong></span>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left">{{trans('brshare.phr')}}</span>
                        <span class="pull-right"><strong> {{ number_format($shares_balance_type['PHR']['shares_balance'],8) }}</strong></span>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left">{{trans('brshare.pho')}}</span>
                        <span class="pull-right"><strong> {{ number_format($shares_balance_type['PHO']['shares_balance'],8) }}</strong></span>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left">{{trans('pairing.flex_pairing')}}</span>
                        <span class="pull-right"><strong> {{ number_format($shares_balance_type['FP']['shares_balance'],8) }}</strong></span>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="panel panel-yellow panel-featured-top panel-featured-primary">
                    <div class="panel-heading">
                        {{trans('brshare.your')}} <span class="fa fa-bitcoin"></span>{{trans('brshare.btc_wallet_info')}}
                    </div>
                    <div class="panel-footer">
                        <span class="pull-right"><a href="#SetWalletAddress" class="modal-with-form">{{trans('brshare.update_wallet')}}</a></span>
                        <div>{{trans('brshare.wallet_address')}}</div>
                        <div><strong>{{ $wallet_address }}</strong></div>
                        <div class="clearfix"></div>
                    </div>
                    <a href="{{URL::route('get-help')}}">
                        <div class="panel-footer">
                            <span class="pull-left"><strong>{{trans('gh.gh')}}</strong></span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right fa-2x"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{trans('brshare.brshare_transac')}}
                    </div>
                    <div class="panel-body" >
                        {!! $shares_transactions->render() !!}
                        <table class="table table-striped table-bordered table-hover" id="dataTables-share">
                            <thead>
                            <tr>
                                <th>{{trans('brshare.datetime')}}</th>
                                <th>{{trans('brshare.type')}}</th>
                                <th>{{trans('brshare.debit')}}</th>
                                <th>{{trans('brshare.credit')}}</th>
                                <th>{{trans('brshare.balance')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($shares_transactions) && $shares_transactions)
                            @foreach($shares_transactions as $shares_transaction)
                            <tr class="odd gradeX">
                                <td>{{ $shares_transaction->created_at }}</td>
                                <td>{{ $shares_transaction->shares_type }}</td>
                                <td>{{ $shares_transaction->debit_value_in_btc }}</td>
                                <td>{{ $shares_transaction->credit_value_in_btc }}</td>
                                <td>{{ $shares_transaction->balance_value_in_btc }}</td>
                            </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                        {!! $shares_transactions->render() !!}
                    </div>
                </div>
            </div>


        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->


<div class="modal-block modal-block-primary mfp-hide" id="SetWalletAddress">
    <div class="modal-dialog">
        {!! Form::open(array('url'=>'members/update-wallet','method'=>'POST')) !!}
        <input type="hidden" name="page" id="page" value="shares"/>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">{{trans('brshare.update_your_bitcoin_wallet')}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 form-horizontal form-bordered">


                        <div class="form-group">
                            <label class="col-md-4 control-label" for="inputDefault"><strong>{{trans('brshare.wallet_address')}}</strong></label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="wallet_address" id="wallet_address" value="{{ $wallet_address }}"/>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{trans('brshare.update_wallet')}}</button>
                <button class="btn btn-default modal-dismiss">{{trans('brshare.cancel')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script>
    $('.modal-with-form').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',
        modal: true,

        // When elemened is focused, some mobile browsers in some cases zoom in
        // It looks not nice, so we disable it:
        callbacks: {
            beforeOpen: function() {
                if($(window).width() < 700) {
                    this.st.focus = false;
                } else {
                    this.st.focus = '#name';
                }
            }
        }
    });

    $(document).on('click', '.modal-dismiss', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });

    $(document).on('click', '.close', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });
</script>

@Stop