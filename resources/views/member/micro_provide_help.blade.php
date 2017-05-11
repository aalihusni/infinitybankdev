@extends('member.default')

@section('title') {{trans('mph.mph')}} @Stop

@section('micro-ph-class')nav-active @Stop
@section('micro-bank-class')nav-expanded nav-active @Stop

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

            <div class="col-lg-12">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        {{trans('mph.pmph')}}
                        @if ($total_ph_active['balance'] > 0)
                            @if (Auth::user()->micro_passport_balance)
                                <a href="#PHModal" class="btn btn-primary pull-right modal-with-form">{{trans('mph.pnmph')}}</a>
                            @else
                                <a href="#PassportModal" class="btn btn-primary pull-right modal-purchase-passport"><span class="fa fa-lock"></span> {{trans('mph.pnmph')}}</a>
                            @endif
                        @endif
                    </div>
                    <div class="panel-body" >
                        <table id="dataTables" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <td>&nbsp;</td>
                                <th class="hidden-xs hidden-sm">{{trans('ph.date')}}</th>
                                <th class="hidden-xs hidden-sm">{{trans('mph.xsmPH')}}</th>
                                <th class="hidden-xs hidden-sm">{{trans('ph.filled')}}</th>
                                <th class="hidden-xs hidden-sm">{{trans('ph.day')}}</th>
                                <th class="hidden-xs hidden-sm" style="text-align:center;">%</th>
                                <th class="hidden-xs hidden-sm" style="text-align:center;">{{trans('ph.dividend')}} <img src="{{asset('assets/images/brwallet_ico.png')}}" width="20"/></th>
                                <th class="hidden-xs hidden-sm">{{trans('ph.released')}} <img src="{{asset('assets/images/brwallet_ico.png')}}" width="20"/></th>
                                <th class="hidden-lg">{{trans('mph.xsmPH')}}</th>
                                <th>{{trans('ph.status')}}</th>
                                <th>{{trans('ph.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($ph_active) && $ph_active)
                                @foreach($ph_active as $ph)
                                    @if ($ph['status'] != 3)
                                        <tr class="odd gradeX moreinfo" data-target=".class{{ $ph['id'] }}">
                                            <td class="center"><span class="fa @if (empty($ph['phgh']['showrow'])) fa-plus-square-o @else fa-minus-square-o @endif morecontent"></span></td>
                                            <td class="hidden-xs hidden-sm">{{ $ph['time_start'] }}</td>
                                            <td class="hidden-xs hidden-sm">{{ $ph['value_in_btc'] }}</td>
                                            <td class="hidden-xs hidden-sm">{{ $ph['phgh']['filled'] }}</td>
                                            <td class="hidden-xs hidden-sm center">{{ $ph['day'] }}</td>
                                            <td class="hidden-xs hidden-sm center">{{ $ph['percent'] }}%</td>
                                            @if ($ph['status'] >= 4)
                                                <td class="hidden-xs hidden-sm center">{{ $ph['dividen_value_in_btc'] }}</td>
                                            @else
                                                <td class="hidden-xs hidden-sm center">{{ $ph['dividen_now_in_btc'] }}</td>
                                            @endif
                                            <td class="hidden-xs hidden-sm center">{{ $ph['released_value_in_btc'] }}</td>
                                            <td class="hidden-lg">
                                                <strong>{{trans('ph.date')}} : </strong>{{ $ph['time_start'] }}<br>
                                                <strong>{{trans('mph.xsmPH')}} : </strong>{{ $ph['value_in_btc'] }}<br>
                                                <strong>{{trans('ph.filled')}} : </strong>{{ $ph['phgh']['filled'] }}<br>
                                                <strong>{{trans('ph.day')}} : </strong>{{ $ph['day'] }}<br>
                                                <strong>% : </strong>{{ $ph['percent'] }}<br>
                                                @if ($ph['status'] >= 4)
                                                    <strong>{{trans('ph.dividend')}} : </strong>{{ $ph['dividen_value_in_btc'] }}<br>
                                                @else
                                                    <strong>{{trans('ph.dividend')}} : </strong>{{ $ph['dividen_now_in_btc'] }}<br>
                                                @endif
                                                <strong>{{trans('ph.released')}} : </strong>{{ $ph['released_value_in_btc'] }}<br>
                                            </td>
                                            <td>{{ $ph['status_name'] }}</td>
                                            <td @if (!empty($ph['phgh']['showrow']) && ($ph['status'] == 1 || $ph['status'] == 2)) style="background-color:#F00; color:#FFF;" @endif>
                                                @if ($ph['status'] == 0)
                                                    <span><strong>{{trans('ph.waitingmatch')}}</strong></span>
                                                @elseif ($ph['status'] == 1 || $ph['status'] == 2)
                                                    <span><strong>{{trans('ph.makepayment')}}</strong></span>
                                                @elseif ($ph['status'] == 3 && $ph['day'] >= 20)
                                                    <a href="#ReleaseAllModal" class="btn btn-primary btn-xs modal-release release_all" style="color:#FFF;" data-id="{{ $ph['id'] }}" data-value="{{ ($ph['dividen_now_in_btc'] + $ph['value_in_btc']) }}">{{trans('ph.releaseall')}}</a>
                                                    <a href="#ReleaseModal" class="btn btn-success btn-xs modal-release release_profit" style="color:#FFF;" data-id="{{ $ph['id'] }}" data-value="{{ $ph['dividen_now_in_btc'] }}">{{trans('ph.releaseprofit')}}</a>
                                                @elseif ($ph['status'] == 3)
                                                    <span><strong>{{ $ph['day_matured'] }} {{trans('ph.daytomature')}}</strong></span>
                                                @elseif ($ph['status'] == 4)
                                                    <span><strong>Auto Release in {{ $ph['day_on_hold_matured'] }} {{trans('ph.days')}}</strong></span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="toggletableclass class{{ $ph['id'] }}" style="{{ $ph['phgh']['showrow'] }}">
                                            <td colspan="10">

                                                <table class="table table-striped mb-none">
                                                    @if ($ph['status'] != 3)
                                                        <thead>
                                                        <tr>
                                                            <td>{{trans('ph.no')}}</td>
                                                            <td>{{trans('ph.assigned')}}</td>
                                                            <td>{{trans('ph.value')}} <span class="fa fa-bitcoin">TC</td>
                                                            <td>{{trans('ph.status')}}</td>
                                                            <td>{{trans('ph.action')}}</td>
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
                                                                            <a class="phgh_status simple-ajax-modal btn btn-primary btn-block" href="{{URL::to('/')}}/members/micro-phgh/{{ $phgh['id'] }}" id="{{ $phgh['id'] }}">Pay</a>
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
                                                    @elseif ($ph['status'] == 3)
                                                        <thead>
                                                        <tr>
                                                            <td>{{trans('ph.no')}}</td>
                                                            <td>{{trans('ph.releasedate')}}</td>
                                                            <td>{{trans('ph.value')}} <span class="fa fa-bitcoin">TC</td>
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
                                                    @endif
                                                </table>

                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr class="odd gradeX">
                                    <td class="center" colspan="10">none</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        {{trans('mph.activemph')}} 
                    </div>
                    <div class="panel-body" >
                        <table id="dataTables" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <td>&nbsp;</td>
                                <th class="hidden-xs hidden-sm">{{trans('ph.date')}}</th>
                                <th class="hidden-xs hidden-sm">{{trans('mph.xsmPH')}}</th>
                                <th class="hidden-xs hidden-sm">{{trans('ph.filled')}}</th>
                                <th class="hidden-xs hidden-sm">{{trans('ph.day')}}</th>
                                <th class="hidden-xs hidden-sm" style="text-align:center;">%</th>
                                <th class="hidden-xs hidden-sm" style="text-align:center;">{{trans('ph.dividend')}} <img src="{{asset('assets/images/brwallet_ico.png')}}" width="20"/></th>
                                <th class="hidden-xs hidden-sm">{{trans('ph.released')}} <img src="{{asset('assets/images/brwallet_ico.png')}}" width="20"/></th>
                                <th class="hidden-lg">{{trans('mph.xsmPH')}}</th>
                                <th>{{trans('ph.status')}}</th>
                                <th>{{trans('ph.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($ph_active) && $ph_active)
                                @foreach($ph_active as $ph)
                                    @if ($ph['status'] == 3)
                                        <tr class="odd gradeX moreinfo" data-target=".class{{ $ph['id'] }}">
                                            <td class="center"><span class="fa fa-plus-square-o morecontent"></span></td>
                                            <td class="hidden-xs hidden-sm">{{ $ph['time_start'] }}</td>
                                            <td class="hidden-xs hidden-sm">{{ $ph['value_in_btc'] }}</td>
                                            <td class="hidden-xs hidden-sm">{{ $ph['phgh']['filled'] }}</td>
                                            <td class="hidden-xs hidden-sm center">{{ $ph['day'] }}</td>
                                            <td class="hidden-xs hidden-sm center">{{ $ph['percent'] }}%</td>
                                            @if ($ph['status'] >= 4)
                                                <td class="hidden-xs hidden-sm center">{{ $ph['dividen_value_in_btc'] }}</td>
                                            @else
                                                <td class="hidden-xs hidden-sm center">{{ $ph['dividen_now_in_btc'] }}</td>
                                            @endif
                                            <td class="hidden-xs hidden-sm center">{{ $ph['released_value_in_btc'] }}</td>
                                            <td class="hidden-lg">
                                                <strong>{{trans('ph.date')}} : </strong>{{ $ph['time_start'] }}<br>
                                                <strong>{{trans('mph.xsmPH')}} : </strong>{{ $ph['value_in_btc'] }}<br>
                                                <strong>{{trans('ph.filled')}} : </strong>{{ $ph['phgh']['filled'] }}<br>
                                                <strong>{{trans('ph.day')}} : </strong>{{ $ph['day'] }}<br>
                                                <strong>% : </strong>{{ $ph['percent'] }}<br>
                                                @if ($ph['status'] >= 4)
                                                    <strong>{{trans('ph.dividend')}} : </strong>{{ $ph['dividen_value_in_btc'] }}<br>
                                                @else
                                                    <strong>{{trans('ph.dividend')}} : </strong>{{ $ph['dividen_now_in_btc'] }}<br>
                                                @endif
                                                <strong>{{trans('ph.released')}} : </strong>{{ $ph['released_value_in_btc'] }}<br>
                                            </td>
                                            <td>{{ $ph['status_name'] }}</td>
                                            <td>
                                                @if ($ph['status'] == 0)
                                                    <span><strong>{{trans('ph.waitingmatch')}}</strong></span>
                                                @elseif ($ph['status'] == 1 || $ph['status'] == 2)
                                                    <span><strong>{{trans('ph.makepayment')}}</strong></span>
                                                @elseif ($ph['status'] == 3 && $ph['day'] >= 20)
                                                    <a href="#ReleaseAllModal" class="btn btn-primary btn-xs modal-release release_all" style="color:#FFF;" data-id="{{ $ph['id'] }}" data-value="{{ ($ph['dividen_now_in_btc'] + $ph['value_in_btc']) }}">Release All</a>
                                                    <a href="#ReleaseModal" class="btn btn-success btn-xs modal-release release_profit" style="color:#FFF;" data-id="{{ $ph['id'] }}" data-value="{{ $ph['dividen_now_in_btc'] }}">Release Profit</a>
                                                @elseif ($ph['status'] == 3)
                                                    <span><strong>{{ $ph['day_matured'] }} {{trans('ph.daytomature')}}</strong></span>
                                                @elseif ($ph['status'] == 4)
                                                    <span><strong>Auto Release in {{ $ph['day_on_hold_matured'] }} {{trans('ph.days')}}</strong></span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="toggletableclass class{{ $ph['id'] }}">
                                            <td colspan="10">

                                                <table class="table table-striped mb-none">
                                                    @if ($ph['status'] != 3)
                                                        <thead>
                                                        <tr>
                                                            <td>{{trans('ph.no')}}</td>
                                                            <td>{{trans('ph.assigned')}}</td>
                                                            <td>{{trans('ph.value')}} <span class="fa fa-bitcoin">TC</td>
                                                            <td>{{trans('ph.status')}}</td>
                                                            <td>{{trans('ph.action')}}</td>
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
                                                                            <a class="phgh_status simple-ajax-modal btn btn-primary btn-block" href="{{URL::to('/')}}/members/micro-phgh/{{ $phgh['id'] }}" id="{{ $phgh['id'] }}">Pay</a>
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
                                                    @elseif ($ph['status'] == 3)
                                                        <thead>
                                                        <tr>
                                                            <td>{{trans('ph.no')}}</td>
                                                            <td>{{trans('ph.releasedate')}}</td>
                                                            <td>{{trans('ph.value')}} <span class="fa fa-bitcoin">TC</td>
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
                                                    @endif
                                                </table>

                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr class="odd gradeX">
                                    <td class="center" colspan="10">none</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{trans('mph.emph')}}
                    </div>
                    <div class="panel-body" >
                        <table id="dataTables2" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <td>&nbsp;</td>
                                <th class="hidden-xs hidden-sm">{{trans('ph.date')}}</th>
                                <th class="hidden-xs hidden-sm">{{trans('mph.xsmPH')}}</th>
                                <th class="hidden-xs hidden-sm">{{trans('ph.filled')}}</th>
                                <th class="hidden-xs hidden-sm">{{trans('ph.day')}}</th>
                                <th class="hidden-xs hidden-sm" style="text-align:center;">%</th>
                                <th class="hidden-xs hidden-sm" style="text-align:center;">{{trans('ph.dividend')}} <img src="{{asset('assets/images/brwallet_ico.png')}}" width="20"/></th>
                                <th class="hidden-xs hidden-sm">{{trans('ph.released')}} <img src="{{asset('assets/images/brwallet_ico.png')}}" width="20"/></th>
                                <th class="hidden-lg">{{trans('mph.xsmPH')}}</th>
                                <th>{{trans('ph.status')}}</th>
                                <th>{{trans('ph.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($ph_ended) && $ph_ended)
                                @foreach($ph_ended as $ph)
                                    <tr class="odd gradeX moreinfo" data-target=".class{{ $ph['id'] }}">
                                        <td class="center"><span class="fa fa-plus-square-o morecontent"></span></td>
                                        <td class="hidden-xs hidden-sm">{{ $ph['time_start'] }}</td>
                                        <td class="hidden-xs hidden-sm">{{ $ph['value_in_btc'] }}</td>
                                        <td class="hidden-xs hidden-sm">{{ $ph['phgh']['filled'] }}</td>
                                        <td class="hidden-xs hidden-sm center">{{ $ph['day_on_hold'] }}</td>
                                        <td class="hidden-xs hidden-sm center">{{ $ph['percent'] }}%</td>
                                        @if ($ph['status'] >= 4)
                                            <td class="hidden-xs hidden-sm center">{{ $ph['dividen_value_in_btc'] }}</td>
                                        @else
                                            <td class="hidden-xs hidden-sm center">{{ $ph['dividen_now_in_btc'] }}</td>
                                        @endif
                                        <td class="hidden-xs hidden-sm center">{{ $ph['released_value_in_btc'] }}</td>
                                        <td class="hidden-lg">
                                            <strong>{{trans('ph.date')}} : </strong>{{ $ph['time_start'] }}<br>
                                            <strong>{{trans('mph.xsmPH')}}  : </strong>{{ $ph['value_in_btc'] }}<br>
                                            <strong>{{trans('ph.filled')}} : </strong>{{ $ph['phgh']['filled'] }}<br>
                                            <strong>{{trans('ph.day')}} : </strong>{{ $ph['day_on_hold'] }}<br>
                                            <strong>% : </strong>{{ $ph['percent'] }}<br>
                                            @if ($ph['status'] >= 4)
                                                <strong>{{trans('ph.dividend')}} : </strong>{{ $ph['dividen_value_in_btc'] }}<br>
                                            @else
                                                <strong>{{trans('ph.dividend')}} : </strong>{{ $ph['dividen_now_in_btc'] }}<br>
                                            @endif
                                            <strong>{{trans('ph.released')}} : </strong>{{ $ph['released_value_in_btc'] }}<br>
                                        </td>
                                        <td>{{ $ph['status_name'] }}</td>
                                        <td>
                                            @if ($ph['status'] == 0)
                                                <span><strong>{{trans('ph.waitingmatch')}}</strong></span>
                                            @elseif ($ph['status'] == 1 || $ph['status'] == 2)
                                                <span><strong>{{trans('ph.makepayment')}}</strong></span>
                                            @elseif ($ph['status'] == 3 && $ph['day'] >= 20)
                                                <a href="#ReleaseAllModal" class="btn btn-primary btn-xs modal-release release_all" style="color:#FFF;" data-id="{{ $ph['id'] }}" data-value="{{ ($ph['dividen_now_in_btc'] + $ph['value_in_btc']) }}">Release All</a>
                                                <a href="#ReleaseModal" class="btn btn-success btn-xs modal-release release_profit" style="color:#FFF;" data-id="{{ $ph['id'] }}" data-value="{{ $ph['dividen_now_in_btc'] }}">Release Profit</a>
                                            @elseif ($ph['status'] == 3)
                                                <span><strong>{{ $ph['day_matured'] }} {{trans('ph.daytomature')}}</strong></span>
                                            @elseif ($ph['status'] == 4)
                                                <span><strong>Auto Release in {{ $ph['day_on_hold_matured'] }} {{trans('ph.days')}}</strong></span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="toggletableclass class{{ $ph['id'] }}">
                                        <td colspan="10">

                                            <table class="table table-striped mb-none">
                                                @if ($ph['status'] != 3)
                                                    <thead>
                                                    <tr>
                                                        <td>{{trans('ph.no')}}</td>
                                                        <td>{{trans('ph.assigned')}}</td>
                                                        <td>{{trans('ph.value')}} <span class="fa fa-bitcoin">TC</td>
                                                        <td>{{trans('ph.status')}}</td>
                                                        <td>{{trans('ph.action')}}</td>
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
                                                                        <a class="phgh_status simple-ajax-modal btn btn-primary btn-block" href="{{URL::to('/')}}/members/micro-phgh/{{ $phgh['id'] }}" id="{{ $phgh['id'] }}">Pay</a>
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
                                                @elseif ($ph['status'] == 3)
                                                    <thead>
                                                    <tr>
                                                        <td>{{trans('ph.no')}}</td>
                                                        <td>{{trans('ph.releasedate')}}</td>
                                                        <td>{{trans('ph.value')}} <span class="fa fa-bitcoin">TC</td>
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
                                                @endif
                                            </table>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="odd gradeX">
                                    <td class="center" colspan="10">none</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if ($total_ph_active['balance'] > 0)
            <div class="modal-block modal-block-primary mfp-hide" id="PHModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form>

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">{{trans('mph.amnttoph')}}</h4>
                        </div>

                        <div class="modal-body">

                        <div>{{trans('mph.startphfrom')}} <span class="fa fa-bitcoin"></span>TC 0.01 {{trans('ph.upto')}} <span class="fa fa-bitcoin"></span>TC 0.5<br><br></div>

                        <div class="form-horizontal form-bordered">

                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>{{trans('mph.phallowed')}}</strong></label>
                                <div class="col-md-6">
                                    <label class="control-label -align-left"><span class="fa fa-bitcoin"></span>{{ $total_ph_active['balance'] }}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>{{trans('mph.phfrom')}}</strong></label>
                                <div class="col-md-6">
                                    <label class="control-label"><input name="from" id="from" type="radio" value="bitcoin" checked> <span class="fa fa-bitcoin"></span>itcoin</label> &nbsp;&nbsp;
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>{{trans('mph.amnttoph')}}</strong></label>
                                <div class="col-md-6">
                                    <div class="input-group btn-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-bitcoin"></i>
                                        </span>
                                        <select class="form-control" id="value_in_btc">
                                            @if ($total_ph_active['balance'] >= 0.01)
                                            <option value="0.01000000">0.01000000</option>
                                            @endif
                                            @if ($total_ph_active['balance'] >= 0.02)
                                            <option value="0.02000000">0.02000000</option>
                                            @endif
                                            @if ($total_ph_active['balance'] >= 0.03)
                                            <option value="0.03000000">0.03000000</option>
                                            @endif
                                            @if ($total_ph_active['balance'] >= 0.04)
                                            <option value="0.04000000">0.04000000</option>
                                            @endif
                                            @if ($total_ph_active['balance'] >= 0.05)
                                            <option value="0.05000000">0.05000000</option>
                                            @endif
                                            @if ($total_ph_active['balance'] >= 0.1)
                                            <option value="0.10000000">0.10000000</option>
                                            @endif
                                            @if ($total_ph_active['balance'] >= 0.2)
                                            <option value="0.20000000">0.20000000</option>
                                            @endif
                                            @if ($total_ph_active['balance'] >= 0.3)
                                            <option value="0.30000000">0.30000000</option>
                                            @endif
                                            @if ($total_ph_active['balance'] >= 0.4)
                                            <option value="0.40000000">0.40000000</option>
                                            @endif
                                            @if ($total_ph_active['balance'] >= 0.5)
                                            <option value="0.50000000">0.50000000</option>
                                            @endif
                                            <!--
                                            @if ($total_ph_active['balance'] >= 1)
                                            <option value="1.00000000">1.00000000</option>
                                            @endif
                                            -->
                                        </select>
                                    </div>
                                </div>
                            </div>



                        </div>

                                </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default modal-dismiss">{{trans('ph.cancel')}}</button>
                            <!--<a href="{{URL::route('micro-provide-help')}}" class="btn btn-primary" id="provide_help">Pledge New PH</a>-->
                            <a href="#" class="btn btn-primary modal-dismiss" data-toggle="modal" data-target="#submitPHModal">{{trans('mph.pledgemnewph')}}</a>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
            @endif


            <div class="modal-block modal-block-primary mfp-hide" id="PassportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form>

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">{{trans('ph.passportrequired')}}</h4>
                            </div>

                            <div class="modal-body">

                               <div class="alert alert-danger">
                                   <span class="fa fa-exclamation-triangle fa-5x pull-left" style="color:#a94442;"></span>
                                   <p><strong>{{trans('ph.actionnotallow')}}</strong></p>
                                   {{trans('ph.inordertoph')}}
                               </div>



                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default modal-dismiss">{{trans('ph.cancel')}}</button>
                                <a href="{{URL::route('micro-passport')}}" class="btn btn-primary">{{trans('ph.purchasepass')}}</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="modal-block modal-block-primary mfp-hide" id="ReleaseAllModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form>

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">{{trans('ph.releasephall')}}</h4>
                            </div>

                            <div class="modal-body">

                                <div>{{trans('ph.inforeleasephall')}}<br><br></div>

                                <div class="form-horizontal form-bordered">


                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>{{trans('ph.amnttoconver')}}</strong></label>
                                        <div class="col-md-6">
                                            <label class="control-label -align-left" id="release_all_value"><span class="fa fa-bitcoin"></span>15.00000000</label>
                                        </div>
                                    </div>

                                    <br>
                                </div>

                                <div class="alert alert-danger">
                                    <ul>
                                        <li>
                                            {{trans('ph.info1')}}
                                        </li>
                                        <li>
                                            {{trans('ph.info2')}}
                                        </li>
                                        <li>
                                            {{trans('ph.info3')}} <div class="btn btn-default btn-xs">{{trans('ph.cancel')}}</div> {{trans('ph.nclick')}} <div class="btn btn-success btn-xs">{{trans('ph.releaseprofit')}}</div>.
                                        </li>
                                    </ul>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default modal-dismiss">{{trans('ph.cancel')}}</button>
                                <a href="#" class="btn btn-primary" id="release_all_link">{{trans('ph.confirmrelease')}}</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="modal-block modal-block-primary mfp-hide" id="ReleaseModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form>

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">{{trans('ph.releasephprofit')}}</h4>
                            </div>

                            <div class="modal-body">

                                <div>{{trans('ph.pro1')}}<br><br></div>

                                <div class="form-horizontal form-bordered">


                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>{{trans('ph.amnttoconver')}}</strong></label>
                                        <div class="col-md-6">
                                            <label class="control-label -align-left" id="release_value"><span class="fa fa-bitcoin"></span>15.00000000</label>
                                        </div>
                                    </div>

                                <br>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default modal-dismiss">{{trans('ph.cancel')}}</button>
                                <a href="#" class="btn btn-primary" id="release_link">{{trans('ph.confirmrelease')}}</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="submitPHModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">{{trans('ph.abouttoph')}}</h4>
                        </div>
                        <div class="modal-body">
                            {{trans('ph.byagreeto')}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('ph.willdecidelater')}}</button>
                            <!--<a href="{{URL::route('upgrade')}}" class="btn btn-primary">Accept</a>-->
                            <a href="{{URL::route('micro-provide-help')}}" class="btn btn-primary" id="provide_help">{{trans('ph.accept')}}</a>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    var myTimer = null;
    var from = "bitcoin";
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
            var loadUrl = '{{ URL::to('/') }}/members/micro-phgh-status/' + phgh_id;
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

    $(':radio[name="from"]').change(function() {
        from = this.value;
        value_in_btc = $('#value_in_btc').val();

        update_provide_help();
    });

    $('#value_in_btc').change(function(){
        value_in_btc = $('#value_in_btc').val();

        update_provide_help();
    });

    $('.release_all').click(function(e) {
        var ph_id = $(this).attr("data-id");
        var ph_value = $(this).attr("data-value");
        $('#release_all_value').html('<span class="fa fa-bitcoin"></span> '+ph_value);
        $('#release_all_link').attr('href', '{{ URL::to('/') }}/members/micro-ph-release/all/' + ph_id + "/" + ph_value);
    });

    $('.release_profit').click(function(e) {
        var ph_id = $(this).attr("data-id");
        var ph_value = $(this).attr("data-value");
        $('#release_value').html('<span class="fa fa-bitcoin"></span> '+ph_value);
        $('#release_link').attr('href', '{{ URL::to('/') }}/members/micro-ph-release/profit/' + ph_id + "/" + ph_value);
    });

    function update_provide_help()
    {
        $('#provide_help').attr('href', '{{ URL::to('/') }}/members/micro-ph/' + from + "/" + value_in_btc);
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
                if($(window).width() < 700) {
                    this.st.focus = false;
                } else {
                    this.st.focus = '#name';
                }
            }
        }
    });

    $('.modal-purchase-passport').magnificPopup({
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

    $('.modal-release').magnificPopup({
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

    $('.moreinfo').click(function(e) {

        if($(e.target).is('.modal-convert') || $(e.target).is('.release_all') || $(e.target).is('.release_profit')){
            e.preventDefault();
            return;
        }
        var dtarget = $(this).attr('data-target');
        $(dtarget).toggle();
        $('span.morecontent',this).toggleClass("fa-minus-square-o fa-plus-square-o");
    });

    $('.simple-ajax-modal').magnificPopup({
        type: 'ajax',
        modal: true
    });
</script>
@Stop