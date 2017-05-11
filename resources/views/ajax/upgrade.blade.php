<div id="updateModal">
<div class="modal-block modal-block-primary" id="upgradeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">{{trans('upgrade.pls_make_bitcoin_payment')}}...</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="row" id="qr_code">
                            <img class="qrcode" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(500)->margin(1)->errorCorrection('L')->generate('bitcoin:'.$upgrade_details['receiving_address'].'?amount='.$upgrade_details['class_details']['class_value_upgrade'])) !!} ">
                        </div>
                    </div>
                    <div class="col-lg-8 form-horizontal form-bordered">

                        <div class="form-group">
                            <label class="col-md-3 control-label"><strong>{{trans('upgrade.address')}}</strong></label>
                            <div class="col-md-8">
                                <input id="copyaddress" class="form-control" value="{{ $upgrade_details['receiving_address'] }}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault"><strong>{{trans('upgrade.amount')}}</strong></label>
                            <div class="col-md-8">
                                <label class="control-label -align-left" id="value_in_btc">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-bitcoin"></span></span>
                                        <input id="copyamount" class="form-control col-lg-12" value="{{ $upgrade_details['class_details']['class_value_upgrade'] }}"/>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 small">
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
                            <label class="col-md-3 control-label"><strong>{{trans('upgrade.timeout')}}</strong></label>
                            <div class="col-md-6">
                                <label class="control-label -align-left"> <span id="ms_timer"><span></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <div>
                                    <img class="payment-waiting" src="{{asset('assets/images/waiting.gif')}}"/><br>
                                </div>
                                <div class="payment-waiting-text">
                                    <strong>{{trans('upgrade.waiting_for_payment')}}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 small">
                                <label style="font-weight:normal;">
                                    <em>{{trans('upgrade.redirect_page')}}</em>
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default modal-dismiss">{{trans('upgrade.cancel')}}</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script type="text/javascript">
    $(document).ready(function() {
        myTimer = setInterval(function(){
            check_status();
        }, 1000);
        myTimer2 = setInterval(function(){
            manual_callback();
        }, 5000);
        timerCheckEmpty = setInterval(function(){
            check_empty();
        }, 2000);
    });

    @if ($time_left['min'] > 0)
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
                clearInterval(myTimer);
                clearInterval(myTimer2);
                payment_confirmation();
            }
        }});
    }

    function manual_callback(){
        var loadUrl = '{{ URL::to('/') }}/blockio-single-callback/{{ $upgrade_details['receiving_address'] }}';
        $.ajax({url: loadUrl, success: function(result) {
            if (result == "") {

            }
        }});
    }

    function payment_confirmation(){
        var loadUrl = '{{ URL::to('/') }}/members/ajax-confirmation/{{ $cryptid }}';
        $.ajax({url: loadUrl, success: function(result) {
            $('#updateModal').html(result);
        }});
    }


    $('#copyaddress').click(function () {
        $(this).select();
    });

    $('#copyamount').click(function () {
        $(this).select();
    });

</script>
</div>