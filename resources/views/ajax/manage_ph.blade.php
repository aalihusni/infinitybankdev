
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        Pledge PH
                        @if ($total_ph_active['balance'] > 0)
                            @if (Auth::user()->passport_balance)
                                <a href="#PHModal" class="btn btn-primary pull-right modal-with-form">Pledge New Provide Help (PH)</a>
                            @else
                                <a href="#PassportModal" class="btn btn-primary pull-right modal-purchase-passport"><span class="fa fa-lock"></span> Pledge New Provide Help (PH)</a>
                            @endif
                        @endif
                    </div>
                    <div class="panel-body" >
                        <table id="dataTables" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <td>&nbsp;</td>
                                <th class="hidden-xs hidden-sm">Date</th>
                                <th class="hidden-xs hidden-sm">PH</th>
                                <th class="hidden-xs hidden-sm">Filled</th>
                                <th class="hidden-xs hidden-sm">Day</th>
                                <th class="hidden-xs hidden-sm" style="text-align:center;">%</th>
                                <th class="hidden-xs hidden-sm" style="text-align:center;">Dividen <img src="{{asset('assets/images/brwallet_ico.png')}}" width="20"/></th>
                                <th class="hidden-xs hidden-sm">Released <img src="{{asset('assets/images/brwallet_ico.png')}}" width="20"/></th>
                                <th class="hidden-lg">PH</th>
                                <th>Status</th>

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
                                                <strong>Date : </strong>{{ $ph['time_start'] }}<br>
                                                <strong>PH : </strong>{{ $ph['value_in_btc'] }}<br>
                                                <strong>Filled : </strong>{{ $ph['phgh']['filled'] }}<br>
                                                <strong>Day : </strong>{{ $ph['day'] }}<br>
                                                <strong>% : </strong>{{ $ph['percent'] }}<br>
                                                @if ($ph['status'] >= 4)
                                                    <strong>Dividen : </strong>{{ $ph['dividen_value_in_btc'] }}<br>
                                                @else
                                                    <strong>Dividen : </strong>{{ $ph['dividen_now_in_btc'] }}<br>
                                                @endif
                                                <strong>Released : </strong>{{ $ph['released_value_in_btc'] }}<br>
                                            </td>
                                            <td>{{ $ph['status_name'] }}</td>

                                        </tr>
                                        <tr class="toggletableclass class{{ $ph['id'] }}" style="{{ $ph['phgh']['showrow'] }}">
                                            <td colspan="10">

                                                <table class="table table-striped mb-none">
                                                    @if ($ph['status'] != 3)
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
                                                                    <td>{{ $phgh['status_name'] }}</td>
                                                                    @if ($phgh['status'] == 0)
                                                                        <td>
                                                                            <a class="simple-ajax-modal btn btn-primary btn-block" href="{{URL::to('/')}}/members/phgh/{{ $phgh['id'] }}" id="{{ $phgh['id'] }}">Pay</a>
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
                        Active PH
                    </div>
                    <div class="panel-body" >
                        <table id="dataTables" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <td>&nbsp;</td>
                                <th class="hidden-xs hidden-sm">Date</th>
                                <th class="hidden-xs hidden-sm">PH</th>
                                <th class="hidden-xs hidden-sm">Filled</th>
                                <th class="hidden-xs hidden-sm">Day</th>
                                <th class="hidden-xs hidden-sm" style="text-align:center;">%</th>
                                <th class="hidden-xs hidden-sm" style="text-align:center;">Dividen <img src="{{asset('assets/images/brwallet_ico.png')}}" width="20"/></th>
                                <th class="hidden-xs hidden-sm">Released <img src="{{asset('assets/images/brwallet_ico.png')}}" width="20"/></th>
                                <th class="hidden-lg">PH</th>
                                <th>Status</th>

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
                                                <strong>Date : </strong>{{ $ph['time_start'] }}<br>
                                                <strong>PH : </strong>{{ $ph['value_in_btc'] }}<br>
                                                <strong>Filled : </strong>{{ $ph['phgh']['filled'] }}<br>
                                                <strong>Day : </strong>{{ $ph['day'] }}<br>
                                                <strong>% : </strong>{{ $ph['percent'] }}<br>
                                                @if ($ph['status'] >= 4)
                                                    <strong>Dividen : </strong>{{ $ph['dividen_value_in_btc'] }}<br>
                                                @else
                                                    <strong>Dividen : </strong>{{ $ph['dividen_now_in_btc'] }}<br>
                                                @endif
                                                <strong>Released : </strong>{{ $ph['released_value_in_btc'] }}<br>
                                            </td>
                                            <td>{{ $ph['status_name'] }}</td>

                                        </tr>
                                        <tr class="toggletableclass class{{ $ph['id'] }}">
                                            <td colspan="10">

                                                <table class="table table-striped mb-none">
                                                    @if ($ph['status'] != 3)
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
                                                                    <td>{{ $phgh['status_name'] }}</td>
                                                                    @if ($phgh['status'] == 0)
                                                                        <td>
                                                                            <a class="simple-ajax-modal btn btn-primary btn-block" href="{{URL::to('/')}}/members/phgh/{{ $phgh['id'] }}" id="{{ $phgh['id'] }}">Pay</a>
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
                        Ended PH
                    </div>
                    <div class="panel-body" >
                        <table id="dataTables2" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <td>&nbsp;</td>
                                <th class="hidden-xs hidden-sm">Date</th>
                                <th class="hidden-xs hidden-sm">PH</th>
                                <th class="hidden-xs hidden-sm">Filled</th>
                                <th class="hidden-xs hidden-sm">Day</th>
                                <th class="hidden-xs hidden-sm" style="text-align:center;">%</th>
                                <th class="hidden-xs hidden-sm" style="text-align:center;">Dividen <img src="{{asset('assets/images/brwallet_ico.png')}}" width="20"/></th>
                                <th class="hidden-xs hidden-sm">Released <img src="{{asset('assets/images/brwallet_ico.png')}}" width="20"/></th>
                                <th class="hidden-lg">PH</th>
                                <th>Status</th>

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
                                            <strong>Date : </strong>{{ $ph['time_start'] }}<br>
                                            <strong>PH : </strong>{{ $ph['value_in_btc'] }}<br>
                                            <strong>Filled : </strong>{{ $ph['phgh']['filled'] }}<br>
                                            <strong>Day : </strong>{{ $ph['day_on_hold'] }}<br>
                                            <strong>% : </strong>{{ $ph['percent'] }}<br>
                                            @if ($ph['status'] >= 4)
                                                <strong>Dividen : </strong>{{ $ph['dividen_value_in_btc'] }}<br>
                                            @else
                                                <strong>Dividen : </strong>{{ $ph['dividen_now_in_btc'] }}<br>
                                            @endif
                                            <strong>Released : </strong>{{ $ph['released_value_in_btc'] }}<br>
                                        </td>
                                        <td>{{ $ph['status_name'] }}</td>

                                    </tr>
                                    <tr class="toggletableclass class{{ $ph['id'] }}">
                                        <td colspan="10">

                                            <table class="table table-striped mb-none">
                                                @if ($ph['status'] != 3)
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
                                                                <td>{{ $phgh['status_name'] }}</td>
                                                                @if ($phgh['status'] == 0)
                                                                    <td>
                                                                        <a class="simple-ajax-modal btn btn-primary btn-block" href="{{URL::to('/')}}/members/phgh/{{ $phgh['id'] }}" id="{{ $phgh['id'] }}">Pay</a>
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
                            <h4 class="modal-title" id="myModalLabel"><th>{{trans('manageph.pls_insert_amount_to_ph')}}</th></h4>
                        </div>

                        <div class="modal-body">

                        <div>You may provide help (PH) any amount that you want start from <span class="fa fa-bitcoin"></span>{{trans('manageph.btc')}} 0.1 {{trans('manageph.up_to')}}<span class="fa fa-bitcoin"></span>{{trans('manageph.btc')}} 30<br><br></div>

                        <div class="form-horizontal form-bordered">

                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>{{trans('manageph.ph_allowed')}}</strong></label>
                                <div class="col-md-6">
                                    <label class="control-label -align-left"><span class="fa fa-bitcoin"></span>{{ $total_ph_active['balance'] }}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>{{trans('manageph.ph_from')}}</strong></label>
                                <div class="col-md-6">
                                    <label class="control-label"><input name="from" id="from" type="radio" value="bitcoin" checked> <span class="fa fa-bitcoin"></span>{{trans('manageph.itcoin')}}</label> &nbsp;&nbsp;
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>{{trans('manageph.amount_to_ph')}}</strong></label>
                                <div class="col-md-6">
                                    <div class="input-group btn-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-bitcoin"></i>
                                        </span>
                                        <select class="form-control" id="value_in_btc">
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
                                            @if ($total_ph_active['balance'] >= 1)
                                                <option value="1.00000000">1.00000000</option>
                                            @endif
                                            @if ($total_ph_active['balance'] >= 2)
                                                <option value="2.00000000">2.00000000</option>
                                            @endif
                                            @if ($total_ph_active['balance'] >= 3)
                                                <option value="3.00000000">3.00000000</option>
                                            @endif
                                            @if ($total_ph_active['balance'] >= 4)
                                                <option value="4.00000000">4.00000000</option>
                                            @endif
                                            @if ($total_ph_active['balance'] >= 5)
                                                <option value="5.00000000">5.00000000</option>
                                            @endif
                                            @if ($total_ph_active['balance'] >= 10)
                                                <option value="10.00000000">10.00000000</option>
                                            @endif
                                            @if ($total_ph_active['balance'] >= 15)
                                                <option value="15.00000000">15.00000000</option>
                                            @endif
                                            @if ($total_ph_active['balance'] >= 20)
                                                <option value="20.00000000">20.00000000</option>
                                            @endif
                                            @if ($total_ph_active['balance'] >= 25)
                                                <option value="25.00000000">25.00000000</option>
                                            @endif
                                            @if ($total_ph_active['balance'] >= 30)
                                                <option value="30.00000000">30.00000000</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>



                        </div>

                                </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default modal-dismiss">{{trans('manageph.cancel')}}</button>
                            <!--<a href="{{URL::route('provide-help')}}" class="btn btn-primary" id="provide_help">Pledge New PH</a>-->
                            <a href="#" class="btn btn-primary modal-dismiss" data-toggle="modal" data-target="#submitPHModal">{{trans('manageph.pledge_new_ph')}}</a>
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
                                <h4 class="modal-title" id="myModalLabel">{{trans('manageph.passport_required')}}</h4>
                            </div>

                            <div class="modal-body">

                               <div class="alert alert-danger">
                                   <span class="fa fa-exclamation-triangle fa-5x pull-left" style="color:#a94442;"></span>
                                   <p><strong>{{trans('manageph.action_not_allowed')}}</strong></p>
                                   {{trans('manageph.pls_purchase_passport')}}
                               </div>



                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default modal-dismiss">{{trans('manageph.cancel')}}</button>
                                <a href="{{URL::route('passport')}}" class="btn btn-primary">{{trans('manageph.purchase_passport')}}</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>



            <div class="modal-block modal-block-primary mfp-hide" id="ConvertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form>

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">{{trans('manageph.release_ph')}}</h4>
                            </div>

                            <div class="modal-body">

                                <div>{{trans('manageph.release_ph_to_brshare')}}<br><br></div>

                                <div class="form-horizontal form-bordered">


                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>{{trans('manageph.amount_to_convert')}}</strong></label>
                                        <div class="col-md-6">
                                            <label class="control-label -align-left"><span class="fa fa-bitcoin"></span>15.00000000</label>
                                        </div>
                                    </div>

                                <br>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default modal-dismiss">{{trans('manageph.cancel')}}</button>
                                <a href="#" class="btn btn-primary">{{trans('manageph.confirm_release')}}</a>
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
                            <h4 class="modal-title" id="myModalLabel">{{trans('manageph.you_are_about_to_ph_for')}} '{{ $user_details['alias'] }}'.</h4>
                        </div>
                        <div class="modal-body">
                            {{trans('manageph.deduct_passport')}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('manageph.i_will_decide_later')}}</button>
                            <!--<a href="{{URL::route('upgrade')}}" class="btn btn-primary">Accept</a>-->
                            <a href="{{URL::route('provide-help')}}" class="btn btn-primary" id="provide_help">{{trans('manageph.accept')}}</a>
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
    var secret;

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

    function update_provide_help()
    {
        secret = "{{ \App\Classes\BitcoinWalletClass::generateSecret() }}";
        $('#provide_help').attr('href', '{{ URL::to('/') }}/members/ajax-ph/' + "{{ $cryptid }}/" + from + "/" + value_in_btc + "/" + secret + "/{{ $onbehalf_user_id }}");
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

    $('.modal-convert').magnificPopup({
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
        clearInterval(window['timer_MSms_timer']);
        window = [];
    });

    $(document).on('click', '.close', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
        clearInterval(window['timer_MSms_timer']);
        window = [];
    });

    $('.moreinfo').click(function(e) {

        if($(e.target).is('.modal-convert')){
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