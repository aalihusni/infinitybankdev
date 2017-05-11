@extends('member.default')

@section('title')Dashboard @Stop
@section('home-class')current @Stop

@section('menu_setting') @Stop {{-- Yang ni xtauu menantang paa --}}

@section('content')
    <div id="wrapper">
        <div class="main-content">
            <div class="row small-spacing">
                <div class="col-xs-12">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if($user_details['user_type'] == '3')
                        <div class="col-lg-12">
                            <div class="box-content card js__card">
                                <h4 class="box-title with-control bg-warning"><i class="ico fa fa-check-circle"></i>Welcome
                                    to {{ env("SITE_NAME") }}
                                    <span class="controls">
                                        <button type="button" class="control fa fa-minus js__card_minus"></button>
                                        <button type="button" class="control fa fa-times js__card_remove"></button>
                                    </span>
                                </h4>
                                <div class="card-content js__card_content">
                                    <p class="margin-bottom-40">Is <strong>"{{$upline_details['alias']}}"</strong> your
                                        referrer? . If not ,you
                                        can you change your referral username.</p>
                                    @if($user_details['user_type'] == '3')
                                        {!! Form::open(['url' => '/members/home-check-alias']) !!}
                                        <ul class="list-inline margin-bottom-0">
                                            <li class="form-group">
                                                {!! Form::text('alias', $upline_details['alias'], array('class'=>'form-control','placeholder'=>'Referral Username')) !!}
                                            </li>
                                            <li class="form-group">
                                                <button type="submit" class="btn btn-warning waves-effect waves-light">
                                                    Update Referrer
                                                </button>
                                            </li>
                                        </ul>
                                        {!! Form::close() !!}
                                    @endif
                                    <hr>
                                    <div class="alert alert-success" data-appear-animation="fadeInUp">
                                        Please purchase <b>1</b> Soft-Keys first to upgrade to Public Account
                                    </div>
                                    <a href="{{URL::route('assistant')}}"
                                       class=" margin-bottom-20 btn btn-success btn-rounded btn-bordered waves-effect waves-light pull-right">Fixed
                                        Deposit</a>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($user_details['user_type'] != '3')
                        @if($news)
                            <div class="col-xs-12">
                                <div class="box-content bordered primary">
                                    <h4 class="box-title"><i class="fa fa-newspaper-o"></i><span
                                                class="controls"> {{$news->title}}</span></h4>
                                    <p class="panel-subtitle">
                                        <i>{{date('F d, Y h:mA', strtotime($news->created_at))}}</i>
                                    </p>
                                    <p>
                                        {!!nl2br($news->news)!!}
                                        <br><br><a href="{{URL::route('news')}}" class="text-danger pull-right">Read
                                            More
                                            News</a>
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endif
                    @if ($user_details['user_class'] < 6)
                        @if ($user_details['upline_diff_class'] >= 2)
                            <div class="col-xs-12">
                                <div class="box-content bordered-all danger">
                                    <h4 class="box-title"><i class="ico fa fa-warning"></i>Dont miss your Give Back
                                        incentive</h4>
                                    <!-- /.box-title -->
                                    <!-- /.dropdown js__dropdown -->
                                    <p>Your upline is now classes above you. You must always be minimum 2 classes status
                                        below your upline
                                        to receive Give Back. You should
                                        upgrade now so you won't miss the Give Back incentive if your
                                        upline upgrade to the next class.</p>
                                    <a href="{{URL::route('assistant')}}" class="btn btn-danger pull-right"><span
                                                class="glyphicon glyphicon-circle-arrow-right"></span> {{trans('home.upgrade_now')}}
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endif
                    <div class="col-xs-9">
                        <div class="box-content">
                            <h4 class="box-title">Balance History</h4>
                            <div class="ct-chart" style="height: 314px;"></div>
                            <script type="text/javascript">
                                new Chartist.Line('.ct-chart', {
                                    @if (!empty($charts))
                                    labels: [@foreach($charts as $chart)"{{ $chart['key'] }}",@endforeach],
                                    series: [
                                        [@foreach($charts as $chart){{ $chart['value'] }},@endforeach]
                                    ]
                                    @endif
                                }, {
                                    low: 0,
                                    showArea: true,
                                    fullWidth: true
                                });

                            </script>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="box-content">
                            <div class="statistics-box with-icon">
                                <i class="ico fa fa-users text-primary"></i>
                                <h2 class="counter text-inverse">{{ $total_pagb['members'] }}</h2>
                                <p class="text">Members</p>
                            </div>
                        </div>
                        <div class="box-content">
                            <div class="statistics-box with-icon">
                                <i class="ico zmdi zmdi-download zmdi-hc-fw text-success"></i>
                                <h2 class="counter text-inverse"><i class="fa fa-btc"
                                                                    aria-hidden="true"></i> {{ $total_pagb['send'] }}
                                </h2>
                                <p class="text">Fixed Deposit</p>
                            </div>
                        </div>
                        <div class="box-content">
                            <div class="statistics-box with-icon">
                                <i class="ico zmdi zmdi-upload zmdi-hc-fw text-danger"></i>
                                <h2 class="counter text-inverse"><i class="fa fa-btc"
                                                                    aria-hidden="true"></i> {{ $total_pagb['received'] }}
                                </h2>
                                <p class="text">Withdrawal</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="box-content">
                            <h4 class="box-title text-info">Active Fixed Deposit </h4>
                            <div class="content widget-stat">
                                <!-- /#traffic-sparkline-chart-1 -->
                                <div class="">
                                    <h2 class="counter text-info">{{ $total_active_dividen['total_active_ph'] }}</h2>
                                </div>
                                <!-- .right-content -->
                            </div>
                            <!-- /.content widget-stat -->
                        </div>
                        <!-- /.box-content -->
                    </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="box-content">
                                <h4 class="box-title text-info">Dividend</h4>
                                <div class="content widget-stat">
                                    <div class="">
                                        <h2 class="counter text-info" id="profit_bonus">{{ $total_active_dividen['balance_active_dividen'] }}</h2>
                                    </div>
                                    <!-- .right-content -->
                                </div>
                                <!-- /.content widget-stat -->
                            </div>
                            <!-- /.box-content -->
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="box-content">
                                <h4 class="box-title text-info">Current Pairing</h4>
                                <!-- /.box-title -->
                                <!-- /.dropdown js__dropdown -->
                                <div class="content widget-stat">
                                    <div class="right-content">
                                        <h2 class="counter text-info">0</h2>
                                    </div>
                                    <!-- .right-content -->
                                </div>
                                <!-- /.content widget-stat -->
                            </div>
                            <!-- /.box-content -->
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="box-content">
                                <h4 class="box-title text-info">Next Pairing in</h4>
                                <div class="content widget-stat margin-bottom-20">
                                    <div class="">
                                        <h6 class="counter text-info"><span id="ms_timer"></span></h6>
                                    </div>
                                    <!-- .right-content -->
                                </div>
                                <!-- /.content widget-stat -->
                            </div>
                            <!-- /.box-content -->
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <div class="box-content">
                                <h4 class="box-title">User Ranking</h4>
                                <!-- /.box-title -->

                                <!-- /.dropdown js__dropdown -->
                                <div class="table-responsive table-purchases">
                                    <table class="table table-striped margin-bottom-10">
                                        <thead>
                                        <tr>
                                            <th style="width:50%;">Title</th>
                                            <th>Member slot</th>
                                            <th>Potential earning</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Public Account</td>
                                            <td>0/3</td>
                                            <td><i class="fa fa-btc" aria-hidden="true"></i> 0.45</td>

                                        </tr>
                                        <tr>
                                            <td>Junior Account</td>
                                            <td>0/9</td>
                                            <td><i class="fa fa-btc" aria-hidden="true"></i> 4.05</td>
                                        </tr>
                                        <tr>
                                            <td>Basic Account</td>
                                            <td>0/27</td>
                                            <td><i class="fa fa-btc" aria-hidden="true"></i> 12.15</td>
                                        </tr>
                                        <tr>
                                            <td>Standard Account</td>
                                            <td>0/81</td>
                                            <td><i class="fa fa-btc" aria-hidden="true"></i> 72.90</td>
                                        </tr>
                                        <tr>
                                            <td>Advance Account</td>
                                            <td>0/243</td>
                                            <td><i class="fa fa-btc" aria-hidden="true"></i> 291.60</td>
                                        </tr>
                                        <tr>
                                            <td>Business Account</td>
                                            <td>0/729</td>
                                            <td><i class="fa fa-btc" aria-hidden="true"></i> 1,530.90</td>
                                        </tr>
                                        <tr>
                                            <td>Premier Account</td>
                                            <td>0/2187</td>
                                            <td><i class="fa fa-btc" aria-hidden="true"></i> 6,561.00</td>
                                        </tr>
                                        <tr>
                                            <td>Infinit Account</td>
                                            <td>0/6561</td>
                                            <td><i class="fa fa-btc" aria-hidden="true"></i> 29,524.50</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!-- /.table -->
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.box-content -->
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <div class="box-content card danger">
                                <h4 class="box-title">Profit &amp; Shares</h4>
                                <div class="card-content">
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <td>SKR</td>
                                            <td>SoftKey Referral</td>
                                            <td>{{ number_format($shares_balance_type['PR']['shares_balance'],8) }}</td>
                                        </tr>
                                        <tr>
                                            <td>SKO</td>
                                            <td>SoftKey Overiding</td>
                                            <td>{{ number_format($shares_balance_type['PO']['shares_balance'],8) }}</td>
                                        </tr>
                                        <tr>
                                            <td>SKC</td>
                                            <td>SoftKey Capital</td>
                                            <td>{{ number_format($shares_balance_type['PHC']['shares_balance'],8) }}</td>
                                        </tr>
                                        <tr>
                                            <td>FDD</td>
                                            <td>Fixed Deposit Dividend</td>
                                            <td>{{ number_format($shares_balance_type['PHD']['shares_balance'],8) }}</td>
                                        </tr>
                                        <tr>
                                            <td>FDR</td>
                                            <td>Fixed Deposit Referral</td>
                                            <td>{{ number_format($shares_balance_type['PHR']['shares_balance'],8) }}</td>
                                        </tr>
                                        <tr>
                                            <td>FDO</td>
                                            <td>Fixed Deposit Overiding</td>
                                            <td>{{ number_format($shares_balance_type['PHO']['shares_balance'],8) }}</td>
                                        </tr>
                                        <tr>
                                            <td>FP</td>
                                            <td>Flex Pairing</td>
                                            <td>{{ number_format($shares_balance_type['FP']['shares_balance'],8) }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-content -->
                            </div>
                            <!-- /.box-content -->
                        </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">

            var total_active_dividen = {{ $total_active_dividen['balance_active_dividen'] }};
            var timercount = 20;

            $('.moreinfo').click(function () {
                $('span', this).toggleClass("fa-minus-square-o fa-plus-square-o");
            });

            $(function () {
                setInterval(oneSecondFunction, 100);
            });

            function oneSecondFunction() {
                timercount++;
                var satoshi = 100000000;
                var value = total_active_dividen;
                var addvaluesatoshi = ({{ ($total_active_dividen['total_second_dividen_satoshi'] / 10) }} * timercount
            )
                ;
                var addvalue = (addvaluesatoshi / satoshi)
                var newvalue = parseFloat(value) + addvalue;
                $("#profit_bonus").html(newvalue.toFixed(8));
            }


            $(function () {
                $("#ms_timer").countdowntimer({
                    startDate: "{{ Carbon\Carbon::now() }}",
                    dateAndTime: "{{ Carbon\Carbon::now()->endOfMonth() }}",
                    size: "xs",
                    borderColor: "transparent",
                    backgroundColor: "transparent",
                    fontColor: "#000",
                    regexpMatchFormat: "([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})",
                    regexpReplaceWith: "$1 days, $2 hours, $3 minutes, $4 seconds."
                });
            });

            function blinker() {
                $('.blink').fadeOut(500);
                $('.blink').fadeIn(500);
            }
            setInterval(blinker, 1000);

            $('.modal-referrer').magnificPopup({
                type: 'inline',
                preloader: false,
                focus: '#name',
                modal: true,

                // When elemened is focused, some mobile browsers in some cases zoom in
                // It looks not nice, so we disable it:
                callbacks: {
                    beforeOpen: function () {
                        if ($(window).width() < 700) {
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
            $('#alias').keyup(function () {
                check_upline();
            });
            $('#alias').change(function () {
                check_upline();
            });

            function check_upline() {
                var alias = $('#alias').val();

                var loadUrl = '{{ URL::to('/') }}/check-alias/' + alias;
                $.ajax({
                    url: loadUrl, success: function (result) {
                        if (result == "KO") {
                            $('#usericon').html('<i class="fa fa-check text-success"></i>');
                            $('#referrer_link').attr('href', '{{ URL::to('/') }}/members/update-referrer/' + alias);
                            $('#referrer_link').attr('disabled', false);
                        } else {
                            $('#usericon').html('<i class="fa fa-remove text-danger"></i>');
                            $('#referrer_link').attr('href', '#');
                            $('#referrer_link').attr('disabled', true);
                        }
                    }
                });
            }
        </script>


@endsection