<?php
$transaction = array('sender_address'=>'xxx','receiving_address'=>'xxx','transaction_hash'=>'b746784b013e95a69755362b9b3e526175cbe7891205e12cba9a4f1e87866eb9','value_in_btc'=>'xxx','confirmations'=>'xxx')
?>
<div class="modal-block modal-block-primary" id="passportModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Payment Confirmation</h4>
            </div>
            <div class="modal-body form-horizontal form-bordered">

                    <div class="form-group">
                        <label class="col-md-3 control-label">Sender Address</label>
                        <div class="col-md-9">
                            <div class="input-group mb-md">
                                <input type="text" class="form-control" value="{{ $transaction['sender_address'] }}">
                                <span class="input-group-btn">
                                        <a class="btn btn-default" type="button" target="_blank" href="https://blockchain.info/address/{{ $transaction['sender_address'] }}"><span class="fa fa-external-link"></span></a>
                                    </span>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-3 control-label">Receiver Address</label>
                        <div class="col-md-9">
                            <div class="input-group mb-md">
                                <input type="text" class="form-control" value="{{ $transaction['receiving_address'] }}">
                                <span class="input-group-btn">
                                        <a class="btn btn-default" type="button" target="_blank" href="https://blockchain.info/address/{{ $transaction['receiving_address'] }}"><span class="fa fa-external-link"></span></a>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Transaction Hash</label>
                        <div class="col-md-9">
                            <div class="input-group mb-md">
                                <input type="text" class="form-control" value="{{ $transaction['transaction_hash'] }}">
                                <span class="input-group-btn">
                                        <a class="btn btn-default" type="button" target="_blank" href="https://blockchain.info/tx/{{ $transaction['transaction_hash'] }}"><span class="fa fa-external-link"></span></a>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Amount</label>
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
                                <strong id="confirmations">Waiting for confirmation {{ $transaction['confirmations'] }} of 3.</strong>
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
            <div class="modal-footer">
                <button class="btn btn-default modal-dismiss">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script>
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