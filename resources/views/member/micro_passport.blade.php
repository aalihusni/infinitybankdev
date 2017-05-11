@extends('member.default')

@section('title'){{trans('micropassport.purchase_passport')}} @Stop

@section('micro-passport-class')nav-active @Stop
@section('menu_setting') @Stop

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
                            <h2 class="panel-title">{{trans('micropassport.purchase_passport')}}</h2>
                            <p class="panel-subtitle">{{trans('micropassport.commit_transaction')}}</p>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12 form-horizontal form-bordered">

                                <div class="form-group">
                                    <label class="col-md-3 control-label"><strong>{{trans('micropassport.balance_passport')}}</strong></label>
                                    <div class="col-md-5">
                                        <label class="control-label -align-left">{{ $passport_details['passport_balance'] }}</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"><strong>{{trans('micropassport.passport_price')}}</strong></label>
                                    <div class="col-md-5">
                                        <label class="control-label -align-left">1 = <span class="fa fa-bitcoin"></span> {{ $passport_details['passport_price'] }}</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="inputDefault"><strong>{{trans('micropassport.qty_to_purchase')}}</strong></label>
                                    <div class="col-md-6">
                                        <input type="number" name="quantity" id="quantity" class="form-control"  value="1">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"><strong>{{trans('micropassport.total_passport_price')}}</strong></label>
                                    <div class="col-md-5">
                                        <label class="control-label -align-left" id="total_price"><span class="fa fa-bitcoin"></span> 0.00000000</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"><strong>{{trans('micropassport.discount')}}</strong></label>
                                    <div class="col-md-5">
                                        <label class="control-label -align-left" id="percent_discount"><strong>%</strong> 0</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"><strong>{{trans('micropassport.total_discount')}}</strong></label>
                                    <div class="col-md-5">
                                        <label class="control-label -align-left" id="total_discount"><span class="fa fa-bitcoin"></span> 0.00000000</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"><strong>{{trans('micropassport.total_after_discount')}}</strong></label>
                                    <div class="col-md-5">
                                        <label class="control-label -align-left" id="total_after_discount"><span class="fa fa-bitcoin"></span> 0.00000000</label>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="inputDefault"></label>
                                    <div class="col-md-4">
                                        <a class="simple-ajax-modal btn btn-primary btn-block" href="{{URL::route('ajax-micro-passport')}}" id="quantity_href" disabled>{{trans('micropassport.purchase_passport')}}</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-subtitle">{{trans('micropassport.passport_transaction_history')}}</p>
                        </div>
                        <div class="panel-body">
                            <table id="datatable-default" class="table table-bordered table-striped mb-none dataTable no-footer">
                                <thead>
                                <tr>
                                    <td>{{trans('micropassport.time_date')}}</td>
                                    <td>{{trans('micropassport.decription')}}</td>
                                    <td>{{trans('micropassport.debit')}}</td>
                                    <td>{{trans('micropassport.credit')}}</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if ($passport_transactions)
                                @foreach($passport_transactions as $passport_transaction)
                                <tr>
                                    <td>{{ $passport_transaction->created_at }}</td>
                                    <td>{{ $passport_transaction->description }}</td>
                                    <td>{{ $passport_transaction->debit }}</td>
                                    <td>{{ $passport_transaction->credit }}</td>
                                </tr>
                                @endforeach
                                @endif
                                </tbody>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="well">
                        <p><span class="fa fa-info-circle"></span> <strong>{{trans('micropassport.information')}}</strong></p>
                        <p>{{trans('micropassport.passport_usage')}}</p>
                        <ul>
                            <li>{{trans('micropassport.use_to_ph')}}</li>
                            <li>{{trans('micropassport.use_to_gh')}}</li>
                        </ul>
                        <!--
                        <br>
                        <p>{{trans('micropassport.behalf_network_members')}}</p>
                        <p><strong>{{trans('micropassport.bulk_purchase')}}</strong></p>
                        <ul>
                            <li> >10 = 5%</li>
                            <li> >25 = 10%</li>
                            <li> >50 = 15%</li>
                            <li> >100 = 20%</li>
                        </ul>
                        -->
                    </div>
                </div>


                @if ($waiting_confirmations)
                    <div class="col-md-4">
                        <div class="panel-body bg-secondary">
                            <p><span class="fa fa-info-circle"></span> <strong>{{trans('micropassport.payment_waiting_confirmation')}}</strong></p>
                            <table id="datatable-default" class="table table-bordered table-striped mb-none dataTable no-footer">
                                <thead>
                                <tr>
                                    <td>{{trans('micropassport.time_date')}}</td>
                                    <td>{{trans('micropassport.quantity')}}</td>
                                    <td>{{trans('micropassport.confirmation')}}</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($waiting_confirmations as $waiting_confirmation)
                                    <tr style="background-color:transparent !important;">
                                        <td>{{ $waiting_confirmation->created_at }}</td>
                                        <td align="center">{{ $waiting_confirmation->payment_specific }}</td>
                                        <td align="center">{{ $waiting_confirmation->confirmations }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                </tr>
                            </table>
                        </div>
                    </div>
                @endif


            </div>
        </div>

        <div class="modal-block modal-block-primary mfp-hide" id="passportModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">{{trans('micropassport.pls_make_bitcoin_payment')}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="row" id="qr_code">
                                </div>
                            </div>
                            <div class="col-lg-8 form-horizontal form-bordered">

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label -align-left"><strong>{{trans('micropassport.wallet_address')}}</strong></label>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="control-label -align-left" id="receiving_address"><img src="{{asset('assets/images/tiny-loader.gif')}}"/></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="inputDefault"><strong>{{trans('micropassport.amount')}}</strong></label>
                                    <div class="col-md-8">
                                        <label class="control-label -align-left" id="value_in_btc"></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label -align-left">
                                            <img src="{{asset('assets/images/waiting.gif')}}"/><br>
                                        </label>
                                        <label class="control-label -align-left">
                                            <strong>{{trans('micropassport.waiting_for_your_payment')}}</strong>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 small">
                                        <label style="font-weight:normal;">
                                            <em>{{trans('micropassport.redirect_page')}}</em>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default modal-dismiss">{{trans('micropassport.cancel')}}</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    var myTimer = null;
    var ppTimer = null;
    var quantity = 1;
    var modal_status = false;

    var passport_price;
    var passport_percent_discount;
    var passport_discount;
    var passport_after_discount;
    var passport_total;
    var passport_total_discount;
    var passport_total_after_discount;

    $('#quantity').keyup(function(){
        quantity = $('#quantity').val();
        if (quantity > 0) {
            get_passport_price(quantity);
        } else {
            $('#total_price').html('<span class="fa fa-bitcoin"></span> ');
            $('#percent_discount').html('<strong>%</strong> ');
            $('#total_discount').html('<span class="fa fa-bitcoin"></span> ');
            $('#total_after_discount').html('<span class="fa fa-bitcoin"></span> ');
            $('#quantity_href').addClass('disabled');
        }
    });

    $('#quantity').change(function(){
        quantity = $('#quantity').val();
        if (quantity > 0) {
            get_passport_price(quantity);
        } else {
            quantity = 1;
            $('#quantity').val(quantity);
            get_passport_price(quantity);
        }
    });

    $(document).ready(function() {
        $('#quantity').val(quantity);
        if (quantity > 0) {
            get_passport_price(quantity);
        }
    });

    function check_passport_price()
    {
        if ($('#quantity_href').attr('disabled') == true) {
            clearInterval(ppTimer);
            ppTimer = setInterval(function () {
                get_passport_price(quantity);
            }, 3000);
        }
    }

    function get_passport_price(quantity){
        $('#quantity_href').attr('href', '{{ URL::to('/') }}/members/ajax-micro-passport/' + quantity);
        $('#total_price').html('<span class="fa fa-bitcoin"></span> ');
        $('#percent_discount').html('<strong>%</strong> ');
        $('#total_discount').html('<span class="fa fa-bitcoin"></span> ');
        $('#total_after_discount').html('<span class="fa fa-bitcoin"></span> ');
        $('#quantity_href').attr('disabled', true);
        check_passport_price();

        var loadUrl = '{{ URL::to('/') }}/micro-passport-price/' + quantity;
        $.ajax({url: loadUrl, success: function(result) {
            var obj = $.parseJSON(result);

            passport_price = obj.passport_price;
            passport_percent_discount = obj.passport_percent_discount;
            passport_discount = obj.passport_discount;
            passport_after_discount = obj.passport_after_discount;
            passport_total = obj.passport_total;
            passport_total_discount = obj.passport_total_discount;
            passport_total_after_discount = obj.passport_total_after_discount;

            $('#total_price').html('<span class="fa fa-bitcoin"></span> ' + passport_total.toFixed(8));
            $('#percent_discount').html('<strong>%</strong> ' + passport_percent_discount);
            $('#total_discount').html('<span class="fa fa-bitcoin"></span> ' + passport_total_discount.toFixed(8));
            $('#total_after_discount').html('<span class="fa fa-bitcoin"></span> ' + passport_total_after_discount.toFixed(8));
            if (passport_total_after_discount > 0) {
                $('#quantity_href').attr('disabled', false);
            } else {
                $('#quantity_href').attr('disabled', true);
            }
            clearInterval(ppTimer);

        }});
    }

    $('.modal-with-form').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',
        modal: true,

        // When elemened is focused, some mobile browsers in some cases zoom in
        // It looks not nice, so we disable it:
        callbacks: {
            beforeOpen: function() {
                get_receiving_address();
                if($(window).width() < 700) {
                    this.st.focus = false;
                } else {
                    this.st.focus = '#name';
                }
            }
        }
    });

    $('.simple-ajax-modal').magnificPopup({
        type: 'ajax',
        modal: true
    });

    $(document).on('click', '.modal-dismiss', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
        clearInterval(window['timer_MSms_timer']);
        window = [];
    });

    $(document).on('click', '.close', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
        clearInterval(window['timer_MSms_timer']);
        window = [];
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

</script>
@Stop