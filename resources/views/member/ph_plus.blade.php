@extends('member.default')

@section('title'){{trans('ph.xsPH')}} + (Plus) @Stop

@section('php-class')nav-active @Stop
@section('bank-class')nav-expanded nav-active @Stop
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
            @if (empty($ph_active))
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">PH + (Plus)</h2>
                    <p class="panel-subtitle">Get 100% Divident upon on special Provide Help with commitment.</p>
                </div>
                <div class="panel-body">
                    <div class="col-md-12 form-horizontal form-bordered">

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault"><strong>Amount to PH</strong></label>
                            <div class="col-md-6">
                                <div class="input-group btn-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-bitcoin"></i>
                                        </span>
                                    <select class="form-control" id="value_in_btc">
                                        @if ($total_ph_active['active'] > 0)
                                            <option value="{{ number_format($total_ph_active['active'],8) }}">{{ number_format($total_ph_active['active'],8) }}</option>
                                        @endif
                                        @if ($total_ph_active['active'] >= 0.1)
                                            <option value="0.10000000">0.10000000</option>
                                        @endif
                                        @if ($total_ph_active['active'] >= 0.2)
                                            <option value="0.20000000">0.20000000</option>
                                        @endif
                                        @if ($total_ph_active['active'] >= 0.3)
                                            <option value="0.30000000">0.30000000</option>
                                        @endif
                                        @if ($total_ph_active['active'] >= 0.4)
                                            <option value="0.40000000">0.40000000</option>
                                        @endif
                                        @if ($total_ph_active['active'] >= 0.5)
                                            <option value="0.50000000">0.50000000</option>
                                        @endif
                                        @if ($total_ph_active['active'] >= 1)
                                            <option value="1.00000000">1.00000000</option>
                                        @endif
                                        @if ($total_ph_active['active'] >= 2)
                                            <option value="2.00000000">2.00000000</option>
                                        @endif
                                        @if ($total_ph_active['active'] >= 3)
                                            <option value="3.00000000">3.00000000</option>
                                        @endif
                                        @if ($total_ph_active['active'] >= 4)
                                            <option value="4.00000000">4.00000000</option>
                                        @endif
                                        @if ($total_ph_active['active'] >= 5)
                                            <option value="5.00000000">5.00000000</option>
                                        @endif
                                        @if ($total_ph_active['active'] >= 10)
                                            <option value="10.00000000">10.00000000</option>
                                        @endif
                                        @if ($total_ph_active['active'] >= 15)
                                            <option value="15.00000000">15.00000000</option>
                                        @endif
                                        @if ($total_ph_active['active'] >= 20)
                                            <option value="20.00000000">20.00000000</option>
                                        @endif
                                        @if ($total_ph_active['active'] >= 25)
                                            <option value="25.00000000">25.00000000</option>
                                        @endif
                                        @if ($total_ph_active['active'] >= 30)
                                            <option value="30.00000000">30.00000000</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault"></label>
                            <div class="col-md-4">
                                <a href="#" class="btn btn-primary modal-dismiss" data-toggle="modal" data-target="#submitPHModal">Provide Help Plus</a>
                                <!--
                                <a class="simple-ajax-modal btn btn-primary btn-block" href="#" id="quantity_href">Provide Help</a>
                                -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @else
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if (count($ph_active) && $ph_active)
                        @foreach($ph_active as $ph)
                    <strong>Date</strong> :
                            @if ($ph['status'] == 3)
                                {{ $ph['time_on_hold'] }} <br>
                            @else
                                {{ $ph['time_start'] }} <br>
                            @endif
                    <strong>PH +</strong> : {{ $ph['value_in_btc'] }} <br>
                    <strong>Filled</strong> : {{ $ph['phgh']['filled'] }} <br>
                    <strong>Percent (%)</strong> : {{ $ph['percent'] }} <br>
                    <strong>Dividen</strong> : {{ number_format((($ph['value_in_btc'] / 100) * $ph['percent']),8) }} <br>
                    <strong>Status</strong> : {{ $ph['status_name'] }} <br>
                    <strong>Action</strong> :
                            @if ($ph['status'] == 0)
                                Waiting for your PH to match
                            @elseif ($ph['status'] == 1 || $ph['status'] == 2)
                                Please make payment
                            @endif
                        @endforeach
                    @endif
                </div>
                <div class="panel-body">
                    <div class="col-md-12 form-horizontal form-bordered">

                        <div class="table-responsive">
                            <table class="table table-striped mb-none">
                                <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Assigned Date</td>
                                    <td>Value <span class="fa fa-bitcoin">TC</td>
                                    <td>Status</td>
                                    <td>Action</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($ph['phgh']['data']) && $ph['phgh']['data'])
                                    @foreach ($ph['phgh']['data'] as $phgh)
                                        <tr>
                                            <td>{{ $phgh['no'] }}</td>
                                            <td>{{ $phgh['created_at'] }}</td>
                                            <td>{{ $phgh['value_in_btc'] }}</td>
                                            <td id="status{{ $phgh['id'] }}">{{ $phgh['status_name'] }}</td>
                                            @if ($phgh['status'] == 0)
                                                <td>
                                                    <a class="phgh_status simple-ajax-modal btn btn-primary btn-block" href="{{URL::to('/')}}/members/phgh/{{ $phgh['id'] }}" id="{{ $phgh['id'] }}">Pay</a>
                                                </td>
                                            @else
                                                <td>
                                                    &nbsp;
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="center" colspan="5">none</td>
                                    </tr>
                                @endif
                                </tbody>
                                <!--
                                <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Released Date</td>
                                    <td>Value <span class="fa fa-bitcoin">TC</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($ph['shares']) && $ph['shares'])
                                    @foreach ($ph['shares'] as $shares)
                                        <tr>
                                            <td>{{ $shares['no'] }}</td>
                                            <td>{{ $shares['created_at'] }}</td>
                                            <td>{{ $shares['debit_value_in_btc'] }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="center" colspan="3">none</td>
                                    </tr>
                                @endif
                                </tbody>
                                -->
                            </table>
                        </div>


                    </div>
                </div>
            </div>
            @endif

            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="panel-subtitle">Minimum New Member Recruitment With Active PH: {{ $requirement['total_recruitment'] }} of 10 people</p>
                </div>
                <div class="panel-body">
                    <div class="col-md-12 form-horizontal form-bordered">

                        <div class="table-responsive">
                            <table class="table table-condensed mb-none">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Alias</th>
                                    <th>Active PH (BTC)</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (!empty($requirement['recruitment']))
                                @if (count($requirement['recruitment']))
                                @foreach ($requirement['recruitment'] as $recruitment)
                                <tr>
                                    <td>{{ $recruitment['no'] }}</td>
                                    <td>{{ $recruitment['fullname'] }}</td>
                                    <td>{{ $recruitment['alias'] }}</td>
                                    <td>{{ $recruitment['ph'] }}</td>
                                </tr>
                                @endforeach
                                @endif
                                @endif
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12 form-horizontal form-bordered">
                        <div class="form-group">
                            <label class="col-md-5 control-label text-right" for="inputDefault"><strong>PH + Status:</strong></label>
                            <div class="col-md-7 form-control-static">
                                <span class="fa fa-history text-warning"></span> &nbsp;
                                Waiting
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label text-right" for="inputDefault"><strong>Recruitments:</strong></label>
                            <div class="col-md-7 form-control-static">
                                <span class="fa @if ($requirement['total_recruitment'] >= 10) fa-check text-success @else fa-close text-danger @endif"></span> &nbsp;
                                {{ $requirement['total_recruitment'] }}/10
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label text-right" for="inputDefault"><strong>Group PH:</strong></label>
                            <div class="col-md-7 form-control-static">
                                <span class="fa @if ($requirement['total_ph_active'] >= $total_ph_needed && $requirement['total_ph_active'] > 0) fa-check text-success @else fa-close text-danger @endif"></span> &nbsp;
                                {{ number_format($requirement['total_ph_active'],1) }} of {{ number_format($total_ph_needed,1) }} BTC
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--
            <div class="panel panel-default">
                <a class="btn btn-info btn-block" href="{{URL::route('ph-plus-history')}}" id="quantity_href">View PH+ History</a>
            </div>
            -->
            <div class="well">
                <p><span class="fa fa-info-circle"></span> <strong>What is PH + (Plus)?</strong></p>
                <p class="text-grey">PH+ is a right for Bitregion members to earn 100% after 30 days based on certain conditions.
                </p>
                <ul>
                    <li>
                        <strong>How to enroll in PH+?</strong></p>
                        <p class="text-grey">First you need to have active PH in Region Bank to be able to participate in PH+.
                        </p>
                    </li>
                    <li>
                        <strong>How much can you PH+?</strong>
                        <p class="text-grey">The amount you can PH+ is based on active PH you have in Region Bank.
                        </p>
                    </li>
                    <li>
                        <strong>What are the conditions to get 100% in PH+?</strong>
                        <p class="text-grey"><ul style="list-style-type: lower-alpha;">
                            <li> You need to bring minimum 10 new direct referral members to participate in Bitregion after you have committed and paid for PH+</li>
                            <li> Minimum 10 new direct referral members must have active PH</li>
                            <li> Total active PH from at least 10 new direct referral members must be five times greater than the amount you PH+ (Example: You PH+ 10 BTC. Total new active PH from your new members must be at least 50 BTC)</li>
                            <li> All these conditions must be met when 100% payout is given after 30 days from the date you paid for PH+</li>
                        </ul></p>
                    </li>
                    <!--
                    <li>
                        <strong>Penalty for PH+</strong>
                        <p class="text-grey">If you failed to meet ALL the conditions above, your PH+ will be penalized and you will only get back 90% from the amount you PH+
                        </p>
                    </li>
                    -->
                </ul>
            </div>
        </div>

        <div class="modal fade" id="submitPHModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">You are about to Provide Help Plus.</h4>
                    </div>
                    <div class="modal-body">
                        By agreeing to accept, your Passport will be automatically deducted for this Provide Help Plus.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">I will decide later</button>
                        <!--<a href="{{URL::route('upgrade')}}" class="btn btn-primary">Accept</a>-->
                        <a href="{{URL::route('provide-help')}}" class="btn btn-primary" id="provide_help">Accept</a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        </div>

    </div>
</div>
<script>
    var myTimer = null;
    var value_in_btc;
    var phgh_status_timer;

    $('.phgh_status').click(function () {
        phgh_status_timer = setInterval(function(){
            phgh_status();
        }, 5000);
    });

    function phgh_status()
    {
        $('.phgh_status').each(function() {
            var phgh_id = $(this).attr('id');
            var loadUrl = '{{ URL::to('/') }}/members/phgh-status/' + phgh_id;
            $.ajax({url: loadUrl, success: function(result) {
                if (result >= 1) {
                    $('#'+phgh_id).remove();
                    $('#status'+phgh_id).html('Completed');
                }
            }});
        });
    }

    $(document).ready(function() {
        value_in_btc = $('#value_in_btc').val();
        update_provide_help()
    });

    $('#value_in_btc').change(function(){
        value_in_btc = $('#value_in_btc').val();
        update_provide_help();
    });

    function update_provide_help()
    {
        $('#provide_help').attr('href', '{{ URL::to('/') }}/members/ph-plus/' + value_in_btc);
    }

    $(document).on('click', '.modal-dismiss', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
        clearInterval(myTimer);
        clearInterval(window['timer_MSms_timer']);
        window = [];
    });

    $(document).on('click', '.close', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
        clearInterval(myTimer);
        clearInterval(window['timer_MSms_timer']);
        window = [];
    });

    $('.simple-ajax-modal').magnificPopup({
        type: 'ajax',
        modal: true
    });
</script>
@Stop