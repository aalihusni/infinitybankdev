
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                @if ($user_details['user_class'] < 6)
                    @if ($user_details['upline_diff_class'] >= 2)
                        <section class="panel panel-featured panel-featured-danger">
                            <header class="panel-heading">
                                <h2 class="panel-title"><span class="fa fa-warning text-danger"></span> {{trans('assistant.dont_miss_your_gb')}}</h2>
                            </header>
                            <div class="panel-body">
                                <p><strong>{{trans('assistant.your_upline_is_now')}} {{ $user_details['upline_diff_class'] }} {{trans('assistant.min_two_classes')}}</strong></p>

                            </div>
                        </section>
                    @endif
                @endif

                @if ($new_class_details)
                <div class="panel panel-yellow">
                    @if ($user_details['upline_user_id'] == 0)
                    <a href="#" data-toggle="modal" data-target="#upgradePlacement">
                    @else
                    <a href="#" data-toggle="modal" data-target="#upgradeModal">
                    @endif
                        <div class="panel-footer">
                            <span class="pull-left" style="font-size:14px; padding:7px;"><strong>{{trans('assistant.upgrade')}} '{{ $user_details['alias'] }}' {{trans('assistant.to')}} {{ $new_class_details['class_name'] }}</strong></span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right fa-3x"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                    <!--
                    <a class="simple-ajax-modal" href="{{URL::to('/')."/members/ajax-upgrade/".$user_details['cryptid']}}" id="quantity_href">
                        <div class="panel-footer">
                            <span class="pull-left" style="font-size:14px; padding:7px;"><strong>Upgrade '{{ $user_details['alias'] }}' to {{ $new_class_details['class_name'] }}</strong></span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right fa-3x"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                    -->
                </div>
                @endif



                <div class="panel panel-default">
                    <div id="dada" class="panel-body">
                        <table class="table mb-none">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('assistant.class')}}</th>
                                <th style="text-align:center;">{{trans('assistant.member_slot')}}</th>
                                <th style="text-align:right;">{{trans('assistant.class')}} <span class="fa fa-bitcoin"></span></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="{{ $user_details['primary1'] }} moreinfo" data-toggle="collapse" data-target=".class1" data-parent="#dada">
                                <td><span class="fa fa-plus-square-o"></span></td>
                                <td>Immigrant</td>
                                <td align="center">{{ $matrix[1][2] }}/3</td>
                                <td align="right">0.45</td>
                            </tr>
                            <tr class="class1 collapse">
                                <td colspan="5">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <p>{{trans('assistant.bonus_entitlement')}}</p>
                                                <img data-toggle="tooltip" data-placement="top" title="Provide Assistance" src="{{asset('assets/images/badges/BLACK-ASIISTANCE.png')}}" width="50"/>
                                                <img data-toggle="tooltip" data-placement="top" title="Region Bank"  src="{{asset('assets/images/badges/BLACK-REGION-BANK.png')}}" width="50"/>
                                                <img data-toggle="tooltip" data-placement="top" title="Passport Referral" src="{{asset('assets/images/badges/BLACK-PASPORT-10.png')}}" width="50"/>
                                                <img data-toggle="tooltip" data-placement="top" title="PH Referral" src="{{asset('assets/images/badges/NEW-BLACK-DIVIDEND-10.png')}}" width="50"/>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="pull-right" style="height:80px; overflow:hidden; width:95px;">
                                                    <img src="{{asset('assets/images/class/1.png')}}" width="120" style="margin-top:-20px;"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="{{ $user_details['primary2'] }} moreinfo" data-toggle="collapse" data-target=".class2" data-parent="#dada">
                                <td><span class="fa fa-plus-square-o"></span></td>
                                <td>Visa Holder</td>
                                <td align="center">{{ $matrix[2][3] }}/9</td>
                                <td align="right">4.05</td>
                            </tr>
                            <tr class="class2 collapse">
                                <td colspan="5">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <p>{{trans('assistant.bonus_entitlement')}}</p>
                                                <img data-toggle="tooltip" data-placement="top" title="Passport Referral" src="{{asset('assets/images/badges/BLACK-PASPORT-5.png')}}" width="50"/>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="pull-right" style="height:80px; overflow:hidden; width:95px;">
                                                    <img src="{{asset('assets/images/class/2.png')}}" width="120" style="margin-top:-20px;"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="{{ $user_details['primary3'] }} moreinfo" data-toggle="collapse" data-target=".class3" data-parent="#dada">
                                <td><span class="fa fa-plus-square-o"></span></td>
                                <td>Permanent Resident</td>
                                <td align="center">{{ $matrix[3][4] }}/27</td>
                                <td align="right">12.15</td>
                            </tr>
                            <tr class="class3 collapse">
                                <td colspan="5">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <p>{{trans('assistant.bonus_entitlement')}}</p>
                                                <img data-toggle="tooltip" data-placement="top" title="Receive Give Back" src="{{asset('assets/images/badges/BLACK-GIVE-BACK.png')}}" width="50"/>
                                                <img data-toggle="tooltip" data-placement="top" title="Passport Referral" src="{{asset('assets/images/badges/BLACK-PASPORT-3.png')}}" width="50"/>
                                                <img data-toggle="tooltip" data-placement="top" title="Pairing Bonus" src="{{asset('assets/images/badges/BLACK-FLEX-PAIRING-0.5.png')}}" width="50"/>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="pull-right" style="height:80px; overflow:hidden; width:95px;">
                                                    <img src="{{asset('assets/images/class/3.png')}}" width="120" style="margin-top:-20px;"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="{{ $user_details['primary4'] }} moreinfo" data-toggle="collapse" data-target=".class4" data-parent="#dada">
                                <td><span class="fa fa-plus-square-o"></span></td>
                                <td>Citizen</td>
                                <td align="center">{{ $matrix[4][5] }}/81</td>
                                <td align="right">72.90</td>
                            </tr>
                            <tr class="class4 collapse">
                                <td colspan="5">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <p>{{trans('assistant.bonus_entitlement')}}</p>
                                                <img data-toggle="tooltip" data-placement="top" title="Passport Referral" src="{{asset('assets/images/badges/BLACK-PASPORT-1.png')}}" width="50"/>
                                                <img data-toggle="tooltip" data-placement="top" title="PH Referral" src="{{asset('assets/images/badges/NEW-BLACK-DIVIDEND-5.png')}}" width="50"/>
                                                <img data-toggle="tooltip" data-placement="top" title="Pairing Bonus" src="{{asset('assets/images/badges/BLACK-FLEX-PAIRING-1.png')}}" width="50"/>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="pull-right" style="height:80px; overflow:hidden; width:95px;">
                                                    <img src="{{asset('assets/images/class/4.png')}}" width="120" style="margin-top:-20px;"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="{{ $user_details['primary5'] }} moreinfo" data-toggle="collapse" data-target=".class5" data-parent="#dada">
                                <td><span class="fa fa-plus-square-o"></span></td>
                                <td>Ambassador</td>
                                <td align="center">{{ $matrix[5][6] }}/243</td>
                                <td align="right">291.60</td>
                            </tr>
                            <tr class="class5 collapse">
                                <td colspan="5">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <p>{{trans('assistant.bonus_entitlement')}}</p>
                                                <img data-toggle="tooltip" data-placement="top" title="Passport Referral" src="{{asset('assets/images/badges/BLACK-PASPORT-0.5.png')}}" width="50"/>
                                                <img data-toggle="tooltip" data-placement="top" title="PH Referral" src="{{asset('assets/images/badges/NEW-BLACK-DIVIDEND-3.png')}}" width="50"/>
                                                <img data-toggle="tooltip" data-placement="top" title="Pairing Bonus" src="{{asset('assets/images/badges/BLACK-FLEX-PAIRING-3.png')}}" width="50"/>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="pull-right" style="height:80px; overflow:hidden; width:95px;">
                                                    <img src="{{asset('assets/images/class/5.png')}}" width="120" style="margin-top:-20px;"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="{{ $user_details['primary6'] }} moreinfo" data-toggle="collapse" data-target=".class6" data-parent="#dada">
                                <td><span class="fa fa-plus-square-o"></span></td>
                                <td>Senator</td>
                                <td align="center">{{ $matrix[6][7] }}/729</td>
                                <td align="right">1,530.90</td>
                            </tr>
                            <tr class="class6 collapse">
                                <td colspan="5">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <p>{{trans('assistant.bonus_entitlement')}}</p>
                                                <img data-toggle="tooltip" data-placement="top" title="Passport Referral" src="{{asset('assets/images/badges/BLACK-PASPORT-0.1.png')}}" width="50"/>
                                                <img data-toggle="tooltip" data-placement="top" title="PH Referral" src="{{asset('assets/images/badges/NEW-BLACK-DIVIDEND-1.png')}}" width="50"/>
                                                <img data-toggle="tooltip" data-placement="top" title="Pairing Bonus" src="{{asset('assets/images/badges/BLACK-FLEX-PAIRING-5.png')}}" width="50"/>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="pull-right" style="height:80px; overflow:hidden; width:95px;">
                                                    <img src="{{asset('assets/images/class/6.png')}}" width="120" style="margin-top:-20px;"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="{{ $user_details['primary7'] }} moreinfo" data-toggle="collapse" data-target=".class7" data-parent="#dada">
                                <td><span class="fa fa-plus-square-o"></span></td>
                                <td>Vice President</td>
                                <td align="center">{{ $matrix[7][8] }}/2187</td>
                                <td align="right">6,561.00</td>
                            </tr>
                            <tr class="class7 collapse">
                                <td colspan="5">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <p>{{trans('assistant.bonus_entitlement')}}</p>
                                                <img data-toggle="tooltip" data-placement="top" title="Passport Referral" src="{{asset('assets/images/badges/BLACK-PASPORT-0.05.png')}}" width="50"/>
                                                <img data-toggle="tooltip" data-placement="top" title="PH Referral" src="{{asset('assets/images/badges/NEW-BLACK-DIVIDEND-0.5.png')}}" width="50"/>
                                                <img data-toggle="tooltip" data-placement="top" title="Pairing Bonus" src="{{asset('assets/images/badges/BLACK-FLEX-PAIRING-7.png')}}" width="50"/>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="pull-right" style="height:80px; overflow:hidden; width:95px;">
                                                    <img src="{{asset('assets/images/class/7.png')}}" width="120" style="margin-top:-20px;"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr class="{{ $user_details['primary8'] }} moreinfo" data-toggle="collapse" data-target=".class8" data-parent="#dada">
                                <td><span class="fa fa-plus-square-o"></span></td>
                                <td>President</td>
                                <td align="center">{{ $matrix[8][9] }}/6561</td>
                                <td align="right">29,524.50</td>
                            </tr>
                            <tr class="class8 collapse">
                                <td colspan="5">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <p>{{trans('assistant.bonus_entitlement')}}</p>
                                                <img data-toggle="tooltip" data-placement="top" title="Passport Referral" src="{{asset('assets/images/badges/BLACK-PASPORT-0.01.png')}}" width="50"/>
                                                <img data-toggle="tooltip" data-placement="top" title="PH Referral" src="{{asset('assets/images/badges/NEW-BLACK-DIVIDEND-0.1.png')}}" width="50"/>
                                                <img data-toggle="tooltip" data-placement="top" title="Pairing Bonus" src="{{asset('assets/images/badges/BLACK-FLEX-PAIRING-10.png')}}" width="50"/>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="pull-right" style="height:80px; overflow:hidden; width:95px;">
                                                    <img src="{{asset('assets/images/class/8.png')}}" width="120" style="margin-top:-20px;"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>


            </div>

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="ranktab table table-striped table-bordered table-hover">
                            <thead>
                            <tr class="classinfo">
                                <th>DG</th>
                                <th><img data-toggle="tooltip" data-placement="top" title="Immigrant" class="img-circle chart-icon" src="{{asset('assets/images/class/1.png')}}" style="width:100%;"/></th>
                                <th><img data-toggle="tooltip" data-placement="top" title="Visa Holder" class="img-circle chart-icon" src="{{asset('assets/images/class/2.png')}}" style="width:100%;"/></th>
                                <th><img data-toggle="tooltip" data-placement="top" title="Permanent Resident" class="img-circle chart-icon" src="{{asset('assets/images/class/3.png')}}" style="width:100%;"/></th>
                                <th><img data-toggle="tooltip" data-placement="top" title="Citizen" class="img-circle chart-icon" src="{{asset('assets/images/class/4.png')}}" style="width:100%;"/></th>
                                <th><img data-toggle="tooltip" data-placement="top" title="Ambassador" class="img-circle chart-icon" src="{{asset('assets/images/class/5.png')}}" style="width:100%;"/></th>
                                <th><img data-toggle="tooltip" data-placement="top" title="Senator" class="img-circle chart-icon" src="{{asset('assets/images/class/6.png')}}" style="width:100%;"/></th>
                                <th><img data-toggle="tooltip" data-placement="top" title="Vice President" class="img-circle chart-icon" src="{{asset('assets/images/class/7.png')}}" style="width:100%;"/></th>
                                <th><img data-toggle="tooltip" data-placement="top" title="President" class="img-circle chart-icon" src="{{asset('assets/images/class/8.png')}}" style="width:100%;"/></th>
                                <th>ALL</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td align="center" class="grey">{{ $matrix[1][1] }}</td>
                                <td align="center" class="red">{{ $matrix[1][2] }}</td>
                                <td align="center">{{ $matrix[1][3] }}</td>
                                <td align="center">{{ $matrix[1][4] }}</td>
                                <td align="center">{{ $matrix[1][5] }}</td>
                                <td align="center">{{ $matrix[1][6] }}</td>
                                <td align="center">{{ $matrix[1][7] }}</td>
                                <td align="center">{{ $matrix[1][8] }}</td>
                                <td align="center">{{ $matrix[1][9] }}</td>
                                <td align="center">{{ $matrix[1][10] }}</td>
                            </tr>
                            <tr>
                                <td align="center" class="grey">{{ $matrix[2][1] }}</td>
                                <td align="center" class="orange">{{ $matrix[2][2] }}</td>
                                <td align="center" class="red">{{ $matrix[2][3] }}</td>
                                <td align="center">{{ $matrix[2][4] }}</td>
                                <td align="center">{{ $matrix[2][5] }}</td>
                                <td align="center">{{ $matrix[2][6] }}</td>
                                <td align="center">{{ $matrix[2][7] }}</td>
                                <td align="center">{{ $matrix[2][8] }}</td>
                                <td align="center">{{ $matrix[2][9] }}</td>
                                <td align="center">{{ $matrix[2][10] }}</td>
                            </tr>
                            <tr>
                                <td align="center" class="grey">{{ $matrix[3][1] }}</td>
                                <td align="center">{{ $matrix[3][2] }}</td>
                                <td align="center" class="orange">{{ $matrix[3][3] }}</td>
                                <td align="center" class="red">{{ $matrix[3][4] }}</td>
                                <td align="center">{{ $matrix[3][5] }}</td>
                                <td align="center">{{ $matrix[3][6] }}</td>
                                <td align="center">{{ $matrix[3][7] }}</td>
                                <td align="center">{{ $matrix[3][8] }}</td>
                                <td align="center">{{ $matrix[3][9] }}</td>
                                <td align="center">{{ $matrix[3][10] }}</td>
                            </tr>
                            <tr>
                                <td align="center" class="grey">{{ $matrix[4][1] }}</td>
                                <td align="center">{{ $matrix[4][2] }}</td>
                                <td align="center">{{ $matrix[4][3] }}</td>
                                <td align="center" class="orange">{{ $matrix[4][4] }}</td>
                                <td align="center" class="red">{{ $matrix[4][5] }}</td>
                                <td align="center">{{ $matrix[4][6] }}</td>
                                <td align="center">{{ $matrix[4][7] }}</td>
                                <td align="center">{{ $matrix[4][8] }}</td>
                                <td align="center">{{ $matrix[4][9] }}</td>
                                <td align="center">{{ $matrix[4][10] }}</td>
                            </tr>
                            <tr>
                                <td align="center" class="grey">{{ $matrix[5][1] }}</td>
                                <td align="center">{{ $matrix[5][2] }}</td>
                                <td align="center">{{ $matrix[5][3] }}</td>
                                <td align="center">{{ $matrix[5][4] }}</td>
                                <td align="center" class="orange">{{ $matrix[5][5] }}</td>
                                <td align="center" class="red">{{ $matrix[5][6] }}</td>
                                <td align="center">{{ $matrix[5][7] }}</td>
                                <td align="center">{{ $matrix[5][8] }}</td>
                                <td align="center">{{ $matrix[5][9] }}</td>
                                <td align="center">{{ $matrix[5][10] }}</td>
                            </tr>
                            <tr>
                                <td align="center" class="grey">{{ $matrix[6][1] }}</td>
                                <td align="center">{{ $matrix[6][2] }}</td>
                                <td align="center">{{ $matrix[6][3] }}</td>
                                <td align="center">{{ $matrix[6][4] }}</td>
                                <td align="center">{{ $matrix[6][5] }}</td>
                                <td align="center" class="orange">{{ $matrix[6][6] }}</td>
                                <td align="center" class="red">{{ $matrix[6][7] }}</td>
                                <td align="center">{{ $matrix[6][8] }}</td>
                                <td align="center">{{ $matrix[6][9] }}</td>
                                <td align="center">{{ $matrix[6][10] }}</td>
                            </tr>
                            <tr>
                                <td align="center" class="grey">{{ $matrix[7][1] }}</td>
                                <td align="center">{{ $matrix[7][2] }}</td>
                                <td align="center">{{ $matrix[7][3] }}</td>
                                <td align="center">{{ $matrix[7][4] }}</td>
                                <td align="center">{{ $matrix[7][5] }}</td>
                                <td align="center">{{ $matrix[7][6] }}</td>
                                <td align="center" class="orange">{{ $matrix[7][7] }}</td>
                                <td align="center" class="red">{{ $matrix[7][8] }}</td>
                                <td align="center">{{ $matrix[7][9] }}</td>
                                <td align="center">{{ $matrix[7][10] }}</td>
                            </tr>
                            <tr>
                                <td align="center" class="grey">{{ $matrix[8][1] }}</td>
                                <td align="center">{{ $matrix[8][2] }}</td>
                                <td align="center">{{ $matrix[8][3] }}</td>
                                <td align="center">{{ $matrix[8][4] }}</td>
                                <td align="center">{{ $matrix[8][5] }}</td>
                                <td align="center">{{ $matrix[8][6] }}</td>
                                <td align="center">{{ $matrix[8][7] }}</td>
                                <td align="center" class="orange">{{ $matrix[8][8] }}</td>
                                <td align="center" class="red">{{ $matrix[8][9] }}</td>
                                <td align="center">{{ $matrix[8][10] }}</td>
                            </tr>
                            <tr style="background-color:#EEE; font-weight:bold;">
                                <td align="center" class="grey">{{ $matrix[9][1] }}</td>
                                <td align="center">{{ $matrix[9][2] }}</td>
                                <td align="center">{{ $matrix[9][3] }}</td>
                                <td align="center">{{ $matrix[9][4] }}</td>
                                <td align="center">{{ $matrix[9][5] }}</td>
                                <td align="center">{{ $matrix[9][6] }}</td>
                                <td align="center">{{ $matrix[9][7] }}</td>
                                <td align="center">{{ $matrix[9][8] }}</td>
                                <td align="center">{{ $matrix[9][9] }}</td>
                                <td align="center">{{ $matrix[9][10] }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="upgradeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">{{trans('assistant.you_are_about_to_upgrade')}} '{{ $user_details['alias'] }} {{trans('assistant.account')}}.</h4>
                        </div>
                        <div class="modal-body">
                            {{trans('assistant.agree_to_upgrade')}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('assistant.i_will_decide_later')}}</button>
                            <!--
                            <a href="{{URL::route('upgrade')}}" class="btn btn-primary">Accept</a>
                            -->
                            <a class="simple-ajax-modal btn btn-primary" data-dismiss="modal" href="{{URL::to('/')."/members/ajax-upgrade/".$user_details['cryptid']}}" id="upgradesubmit">{{trans('assistant.accept')}}</a>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            @if ($user_details['upline_user_id'] == 0)
                <div class="modal fade" id="upgradePlacement" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Placement Position</h4>
                            </div>
                            <div class="modal-body">
                                <div class="col-sm-4">
                                    <div class="well">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="referrer" id="default" value="default">
                                                Auto
                                            </label>
                                        </div>

                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="referrer" id="manual" value="manual" checked>
                                                Manual
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="well">

                                        <div class="form-group" id="default-placement" style="display: none;">
                                            <div class="mb-md ">
                                                Auto Placement
                                            </div>
                                        </div>

                                        <div class="form-group" id="manual-placement">
                                            <div class="mb-md ">
                                                <div class="input-group ">
                                                    <span class="input-group-addon ">{{trans('member.username')}}</span>
                                                    <input type="text" name="upline" id="upline" class="form-control"/>
                                                <span class="input-group-addon">
                                                    <span id="usericon" class="icon"></span>
                                                </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group" id="position" style="display: none;">
                                            <label class="col-md-3 control-label" for="inputDefault">{{trans('member.position')}}</label>
                                            <div class="col-md-6">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="position" id="post1" class="manual_position" value="1">
                                                        Left
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="position" id="post2" class="manual_position" value="2">
                                                        Center
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="position" id="post3" class="manual_position" value="3">
                                                        Right
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <a href="#" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#upgradeModal" id="upgradecontinue" disabled>Continue</a>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            @endif

        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    var myTimer = null;
    var timerCheckEmpty = null;
    var alias = "";
    var position = "";

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

    $('.simple-ajax-modal').magnificPopup({
        type: 'ajax',
        modal: true
    });

    $(document).on('click', '.modal-dismiss', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
        clearInterval(myTimer);
    });

    $(document).on('click', '.close', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
        clearInterval(myTimer);
    });

    $('.moreinfo').click(function() {
        $('span',this).toggleClass("fa-minus-square-o fa-plus-square-o");
    });

    $('#upgradePlacement').on('show.bs.modal', function () {
        $('#upgradecontinue').attr('disabled', true);
        $('#manual').prop('checked', true);
        $('#default-placement').hide();
        $('#manual-placement').show();
        resetPlacement();
    });

    $('.manual_position').change(function(){
        alias = $('#upline').val();
        position = $(this).val();
        $('#upgradesubmit').attr('href', '{{ URL::to('/')."/members/ajax-upgrade/".$user_details['cryptid'] }}/' + alias + '/' + position);
        $('#upgradecontinue').attr('disabled', false);
    });

    $('#manual').change(function(){
        $('#upgradecontinue').attr('disabled', true);
        $('#default-placement').hide();
        $('#manual-placement').show();
        resetPlacement();
    });

    $('#default').change(function(){
        $('#upgradecontinue').attr('disabled', false);
        $('#default-placement').show();
        $('#manual-placement').hide();
        resetPlacement();
    });

    $('#upline').keyup(function(){
        check_upline();
    });

    $('#upline').change(function(){
        check_upline();
    });

    function resetPlacement()
    {
        alias = "";
        position = 0;
        $('#upline').val("");
        $('#usericon').html("");
        $('#position').hide();
        $('#upgradesubmit').attr('href', '{{ URL::to('/')."/members/ajax-upgrade/".$user_details['cryptid'] }}');
    }

    function check_upline(){
        alias = $('#upline').val();
        var upline_id = {{ $user_details['referral_user_id'] }};
        $('#post1').prop('checked', false);
        $('#post2').prop('checked', false);
        $('#post3').prop('checked', false);
        $('#upgradesubmit').attr('href', '{{ URL::to('/')."/members/ajax-upgrade/".$user_details['cryptid'] }}/' + alias + '/' + position);

        if (upline == "")
        {
            $('#usericon').html('<i class="fa fa-remove text-danger"></i>');
            $('#position').hide();
            $('#upgradecontinue').attr('disabled', true);
        } else {
            var loadUrl = '{{ URL::to('/') }}/check-upline/' + alias + '/' + upline_id;
            $.ajax({
                url: loadUrl, success: function (result) {
                    var obj = $.parseJSON(result);
                    var obj2 = obj.position;

                    if (obj.slot > 0) {
                        $('#usericon').html('<i class="fa fa-check text-success"></i>');
                        $('#position').show();

                        if (obj2.slot1 == 1) {
                            $('#post1').prop('disabled', true);
                        } else {
                            $('#post1').prop('disabled', false);
                        }

                        if (obj2.slot2 == 1) {
                            $('#post2').prop('disabled', true);
                        } else {
                            $('#post2').prop('disabled', false);
                        }

                        if (obj2.slot3 == 1) {
                            $('#post3').prop('disabled', true);
                        } else {
                            $('#post3').prop('disabled', false);
                        }

                        if ($('#upline').val() == "")
                        {
                            $('#usericon').html('<i class="fa fa-remove text-danger"></i>');
                            $('#position').hide();
                        }
                    } else {
                        $('#usericon').html('<i class="fa fa-remove text-danger"></i>');
                        $('#position').hide();
                        $('#upgradecontinue').attr('disabled', true);
                    }
                }
            });
        }
    }
</script>
