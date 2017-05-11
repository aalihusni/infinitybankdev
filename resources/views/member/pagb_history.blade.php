@extends('member.default')

@section('title'){{ trans('assistant.history') }} @Stop

@section('pagb-class')nav-expanded nav-active @Stop
@section('assistance-history-class')nav-active @Stop

@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="home">
                                <div class="dataTable_wrapper" style="padding-top:30px;">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                                        <thead>
                                        <tr>
                                            <th class="hidden-xs hidden-sm">{{ trans('assistant.date') }}</th>
                                            <th class="hidden-xs hidden-sm">{{ trans('assistant.payment_for') }}</th>
                                            <th class="hidden-xs hidden-sm">{{ trans('assistant.payment_type') }}</th>
                                            <th class="hidden-xs hidden-sm">{{ trans('assistant.payment_from') }}</th>
                                            <th class="hidden-xs hidden-sm">{{ trans('assistant.payment_to') }}</th>
                                            <th class="hidden-xs hidden-sm">{{ trans('assistant.payment_details') }}</th>
                                            <th class="hidden-lg">{{ trans('assistant.payment_details') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {{--*/ $PA = '<img src="'.asset('assets/images/badges/BLACK-ASIISTANCE.png').'" title="PA" width="66">' /*--}}
                                        {{--*/ $GB = '<img src="'.asset('assets/images/badges/BLACK-GIVE-BACK.png').'" title="GB" width="66">' /*--}}
                                        @if (!empty($histories))
                                        @foreach($histories as $history)
                                            <tr class="odd gradeX">
                                                <td class="hidden-xs hidden-sm">{{ $history['created_at'] }}</td>
                                                <td class="hidden-xs hidden-sm" style="text-align:center; vertical-align: middle;"><img src="{{asset('assets/images/class/'.$history['new_user_class'].'.png') }}" title={{ $history['new_user_class_name'] }} width="50"></td>
                                                <td class="hidden-xs hidden-sm" style="text-align:center; vertical-align: middle;">{!! $$history['type'] !!}</td>
                                                <!--
                                                <td>{{ $history['new_user_class'] }}</td>
                                                -->
                                                <td class="hidden-xs hidden-sm">{{ $history['sender_user_id'] }}</td>
                                                <td class="hidden-xs hidden-sm">{{ $history['user_id'] }}</td>
                                                <td class="hidden-xs hidden-sm">
                                                    <strong>{{ trans('pagb_history_2.from') }}</strong> <a href="https://blockchain.info/address/{{ $history['sender_address'] }}" target="_blank">{{ $history['sender_address'] }}</a><br>
                                                    <strong>{{ trans('pagb_history_2.to') }}</strong> <a href="https://blockchain.info/address/{{ $history['receiving_address'] }}" target="_blank">{{ $history['receiving_address'] }}</a><br>
                                                    <strong>{{ trans('pagb_history_2.transaction') }}</strong> <a href="https://blockchain.info/tx/{{ $history['transaction_hash'] }}" target="_blank">{{ $history['transaction_hash'] }}</a><br>
                                                    <strong>{{ trans('pagb_history_2.value') }}</strong> {{ $history['value_in_btc'] }}
                                                </td>
                                                <!--
                                                <td class="hidden-xs hidden-sm">
                                                    <strong>From :</strong> <a href="https://chain.so/address/BTCTEST/{{ $history['sender_address'] }}" target="_blank">{{ $history['sender_address'] }}</a><br>
                                                    <strong>To :</strong> <a href="https://chain.so/address/BTCTEST/{{ $history['receiving_address'] }}" target="_blank">{{ $history['receiving_address'] }}</a><br>
                                                    <strong>Tx Hash :</strong> <a href="https://chain.so/tx/BTCTEST/{{ $history['transaction_hash'] }}" target="_blank">{{ $history['transaction_hash'] }}</a><br>
                                                    <strong>Value :</strong> {{ $history['value_in_btc'] }}
                                                </td>
                                                <td class="hidden-lg">
                                                    <strong>Date :</strong> {{ $history['created_at'] }}<br>
                                                    <img src="{{asset('assets/images/class/'.$history['new_user_class'].'.png') }}" title={{ $history['new_user_class_name'] }} width="50">
                                                    {!! $$history['type'] !!}<br>
                                                    <strong>Payment From :</strong> {{ $history['sender_user_id'] }}<br>
                                                    <strong>Payment To :</strong> {{ $history['user_id'] }}<br>
                                                    <strong>From :</strong> <a href="https://blockchain.info/address/{{ $history['sender_address'] }}" target="_blank">{{ $history['sender_address'] }}</a><br>
                                                    <strong>To :</strong> <a href="https://blockchain.info/address/{{ $history['receiving_address'] }}" target="_blank">{{ $history['receiving_address'] }}</a><br>
                                                    <strong>Transaction :</strong> <a href="https://blockchain.info/tx/{{ $history['transaction_hash'] }}" target="_blank">{{ $history['transaction_hash'] }}</a><br>
                                                    <strong>Value :</strong> {{ $history['value_in_btc'] }}
                                                </td>
                                                -->
                                                <td class="hidden-lg">
                                                    <strong>{{ trans('pagb_history_2.date') }}</strong> {{ $history['created_at'] }}<br>
                                                    <img src="{{asset('assets/images/class/'.$history['new_user_class'].'.png') }}" title={{ $history['new_user_class_name'] }} width="50">
                                                    {!! $$history['type'] !!}<br>
                                                    <strong>{{ trans('pagb_history_2.paymentfrom') }}</strong> {{ $history['sender_user_id'] }}<br>
                                                    <strong>{{ trans('pagb_history_2.paymentto') }}</strong> {{ $history['user_id'] }}<br>
                                                    <strong>{{ trans('pagb_history_2.from') }}</strong> <a href="https://blockchain.info/address/{{ $history['sender_address'] }}" target="_blank">{{ $history['sender_address'] }}</a><br>
                                                    <strong>{{ trans('pagb_history_2.to') }}</strong> <a href="https://blockchain.info/address/{{ $history['receiving_address'] }}" target="_blank">{{ $history['receiving_address'] }}</a><br>
                                                    <strong>{{ trans('pagb_history_2.transaction') }}</strong> <a href="https://blockchain.info/tx/{{ $history['transaction_hash'] }}" target="_blank">{{ $history['transaction_hash'] }}</a><br>
                                                    <strong>{{ trans('pagb_history_2.value') }}</strong> {{ $history['value_in_btc'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.panel-body -->

                </div>
                <!-- /.panel -->
            </div>

        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    var datatableInit = function() {

        $('#dataTables').dataTable();

    };
    $(function() {
        datatableInit();
    });
</script>
@Stop