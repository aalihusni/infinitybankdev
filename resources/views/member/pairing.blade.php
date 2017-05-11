@extends('member.default')

@section('title'){{trans('pairing.flex_pairing')}} @Stop

@section('pairing-class')nav-active @Stop
@section('bank-class')nav-expanded nav-active @Stop

@section('content')

    <div class="col-md-12">
        <div class="row">

            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">{{trans('pairing.flex_pairing')}}</h2>
                        <p class="panel-subtitle">{{trans('pairing.info_about_pairing')}}</p>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(array('url'=>'members/change-password','method'=>'POST', 'class'=>'form-horizontal form-bordered')) !!}

                        <div class="form-group">
                            <label class=" col-md-3 control-label">{{trans('pairing.next_pair_in')}}</label>
                            <div class="col-lg-9">
                                <p class="form-control-static"><span id="ms_timer"></span></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-md-3 control-label">{{trans('pairing.current_pairing')}}</label>
                            <div class="col-lg-6">
                                <p class="form-control-static">{{ $pair['pair'] }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-md-3 control-label">{{trans('pairing2.bonuspercent')}}</label>
                            <div class="col-lg-6">
                                <p class="form-control-static">{{ $percent }} %</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-md-3 control-label">{{trans('pairing2.bonusamnt')}}</label>
                            <div class="col-lg-6">
                                <p class="form-control-static">{{ $bonus_amount }} @if ($bonus_amount != $bonus_amount_actual) (Actual :{{ $bonus_amount_actual }}) @endif</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-md-3 control-label">{{trans('pairing2.totalactiveph')}}</label>
                            <div class="col-lg-6">
                                <p class="form-control-static">{{ $active_ph }}</p>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <section id="post_left" class="{{ $selected[1] }}">
                                <header class="panel-heading -align-right">
                                    <h2 class="panel-title text-center">{{ number_format($pair['balance_left'],4) }}</h2>
                                    <p class="panel-subtitle text-center">{{trans('pairing.left')}}</p>
                                </header>
                            </section>
                        </div>

                        <div class="col-lg-6">
                            <section id="post_middle" class="{{ $selected[2] }}">
                                <header class="panel-heading">
                                    <a href="pair_move/1" style="color:gray"><span id="move_left" class="fa fa-chevron-left pull-left movepair-left"></span></a>
                                    <a href="pair_move/3" style="color:gray"><span id="move_right" class="fa fa-chevron-right pull-right movepair-right"></span></a>
                                    <h2 class="panel-title text-center">{{ number_format($pair['balance_middle'],4) }}</h2>
                                    <p class="panel-subtitle text-center">{{trans('pairing.middle')}}</p>
                                </header>
                            </section>
                        </div>

                        <div class="col-lg-3">
                            <section id="post_right" class="{{ $selected[3] }}">
                                <header class="panel-heading">
                                    <h2 class="panel-title text-center">{{ number_format($pair['balance_right'],4) }}</h2>
                                    <p class="panel-subtitle text-center">{{trans('pairing.right')}}</p>
                                </header>
                            </section>
                        </div>



                        {!! Form::close() !!}
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p class="panel-subtitle">{{trans('pairing.pair_history')}}</p>
                    </div>
                    <div class="panel-body">
                        <table id="datatable-default" class="table table-bordered table-striped mb-none dataTable no-footer">
                            <thead>
                            <!--
                            <tr>
                                <td>{{trans('pairing.time_date')}}</td>
                                <td>{{trans('pairing.description')}}</td>
                                <td>{{trans('pairing.debit')}}</td>
                                <td>{{trans('pairing.credit')}}</td>
                            </tr>
                            -->
                            <tr>
                                <td class="hidden-xs hidden-sm">{{trans('pairing2.date')}}</td>
                                <td class="hidden-xs hidden-sm">{{trans('pairing2.total')}}</td>
                                <td class="hidden-xs hidden-sm">{{trans('pairing2.pair')}}</td>
                                <td class="hidden-xs hidden-sm">{{trans('pairing2.move')}}</td>
                                <td class="hidden-xs hidden-sm">{{trans('pairing2.flushmiddle')}}</td>
                                <td class="hidden-xs hidden-sm">{{trans('pairing2.bonus')}}</td>
                                <th class="hidden-lg">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pair_history as $pair)
                                <tr>
                                    <td class="hidden-xs hidden-sm">{{ $pair->created_at }}</td>
                                    <td class="hidden-xs hidden-sm">
                                        <p>L : {{ number_format($pair->total_left,4) }}</p>
                                        <p>M : {{ number_format($pair->total_middle,4) }}</p>
                                        <p>R : {{ number_format($pair->total_right,4) }}</p>
                                    </td>
                                    <td class="hidden-xs hidden-sm">
                                        <p>L : {{ number_format($pair->pair_left,4) }}</p>
                                        <p>M : {{ number_format($pair->pair_middle,4) }}</p>
                                        <p>R : {{ number_format($pair->pair_right,4) }}</p>
                                    </td>
                                    @if ($pair->pair_move == "1")
                                    <td class="hidden-xs hidden-sm">{{trans('pairing2.left')}}</td>
                                    @elseif ($pair->pair_move == "3")
                                    <td class="hidden-xs hidden-sm">{{trans('pairing2.right')}}</td>
                                    @else
                                    <td class="hidden-xs hidden-sm">{{trans('pairing2.middle')}}</td>
                                    @endif
                                    <td class="hidden-xs hidden-sm">{{ $pair->flush }}</td>
                                    <td class="hidden-xs hidden-sm">
                                        <p>% : {{ $pair->bonus_percent }}</p>
                                        <p><img src="{{asset('assets/images/brwallet_ico.png')}}" width="20"/> : {{ $pair->bonus_amount }}</p>
                                    </td>
                                    <td class="hidden-lg">
                                        <p><strong>{{trans('pairing2.date')}} :</strong> {{ $pair->created_at }}</p>
                                        <p><strong>{{trans('pairing2.total')}}</strong></p>
                                        <p>L : {{ number_format($pair->total_left,4) }}</p>
                                        <p>M : {{ number_format($pair->total_middle,4) }}</p>
                                        <p>R : {{ number_format($pair->total_right,4) }}</p>
                                        <p><strong>{{trans('pairing2.pair')}}</strong></p>
                                        <p>L : {{ number_format($pair->pair_left,4) }}</p>
                                        <p>M : {{ number_format($pair->pair_middle,4) }}</p>
                                        <p>R : {{ number_format($pair->pair_right,4) }}</p>
                                        @if ($pair->pair_move == "1")
                                        <p><strong>{{trans('pairing2.move')}} :</strong> {{trans('pairing2.left')}}</p>
                                        @elseif ($pair->pair_move == "3")
                                        <p><strong>{{trans('pairing2.pairmove')}} :</strong> {{trans('pairing2.right')}}</p>
                                        @else
                                        <p><strong>{{trans('pairing2.pairmove')}} :</strong> {{trans('pairing2.middle')}}</p>
                                        @endif
                                        <p><strong>{{trans('pairing2.flush')}} :</strong> {{ $pair->flush }}</p>
                                        <p><strong>{{trans('pairing2.bonus')}}</strong></p>
                                        <p>% : {{ $pair->bonus_percent }}</p>
                                        <p><img src="{{asset('assets/images/brwallet_ico.png')}}" width="20"/> : {{ $pair->bonus_amount }}</p>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="well">
                    <p><strong>{{trans('pairing.instructions')}}</strong></p>
                    <p>{{trans('pairing.instruction_info')}}</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="well">
                    <p><strong>{{trans('pairing2.title1')}}</strong></p>
                    <p>{{trans('pairing2.titledecr')}}</p>
                    <p>
                        {{trans('pairing2.example')}}:
                        <ul>
                        <li>{{trans('pairing2.text1')}}</li>
                        <li>{{trans('pairing2.text2')}}</li>
                        <li>{{trans('pairing2.text3')}}</li>
                        <li>{{trans('pairing2.text4')}}</li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">

    $('#move_left').click(function(e) {
        $('#post_left').removeClass('panel-primary panel-featured panel-featured-dark');
        $('#post_left').addClass('panel-primary');
        $('#post_middle').removeClass('panel-primary panel-featured panel-featured-dark');
        $('#post_middle').addClass('panel-featured panel-featured-dark');
        $('#post_right').removeClass('panel-primary panel-featured panel-featured-dark');
        $('#post_right').addClass('panel-featured panel-featured-dark');
    });

    $('#move_right').click(function(e) {
        $('#post_left').removeClass('panel-primary panel-featured panel-featured-dark');
        $('#post_left').addClass('panel-featured panel-featured-dark');
        $('#post_middle').removeClass('panel-primary panel-featured panel-featured-dark');
        $('#post_middle').addClass('panel-featured panel-featured-dark');
        $('#post_right').removeClass('panel-primary panel-featured panel-featured-dark');
        $('#post_right').addClass('panel-primary');
    });

    $(function(){
        $("#ms_timer").countdowntimer({
            startDate : "{{ Carbon\Carbon::now() }}",
            dateAndTime : "{{ Carbon\Carbon::now()->endOfMonth() }}",
            size : "xs",
            borderColor : "transparent",
            backgroundColor : "transparent",
            fontColor : "#777",
            regexpMatchFormat: "([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})",
      		regexpReplaceWith: "$1 days, $2 hours, $3 minutes, $4 seconds."
    });
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