@extends('member.default')

@section('title')Network Hierarchy @Stop

@section('nh-class')nav-active @Stop
@section('hierarchy-class')nav-expanded nav-active @Stop

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

            <div class="net_wrapper">
                <div style="position:absolute; font-weight:bold;">
                    <div>
                        @if ($navigation['level'] > 1)
                        <a class="seemore btn btn-primary" data-id="{{ $navigation['top'] }}" style="position:absolute; width:120px;">Back to top <span class="fa fa-angle-double-up"></span></a>

                        <a class="seemore btn btn-primary" data-id="{{ $navigation['pageup'] }}" style="position:absolute; width:110px; margin-left:130px;">Up 1 Level <span class="fa fa-angle-up"></span></a>

                        @else
                        <!--
                        <a class="btn btn-primary modal-dismiss" data-toggle="modal" data-target="#movePlacement" style="position:absolute; width:120px; margin-top:45px;">Move Placement</a>
                        -->
                        @endif
                    </div>
                    <div style="margin-top:190px;">{{ $navigation['level'] }}</div>
                    <div class="hidden-xs" style="margin-top:140px;">{{ $navigation['level'] + 1 }}</div>
                    <div class="hidden-sm hidden-xs" style="margin-top:90px;">{{ $navigation['level'] + 2 }}</div>
                </div>

                <table border="0" style="width:100%; text-align:center;">
                    <tr>
                        <td colspan="27" class="net_first">
                            {{--*/ $user = $hierarchy /*--}}
                            <img src="{{asset('assets/images/iv_'.$user['id_verify_status'].'.png')}}" class="verified_icon_id_l1" data-toggle="tooltip" data-placement="right" title="{{ $user['id_verify_tooltip'] }}"/>
                            <img src="{{asset('assets/images/pv_'.$user['selfie_verify_status'].'.png')}}" class="verified_icon_ph_l1" data-toggle="tooltip" data-placement="right" title="{{ $user['selfie_verify_tooltip'] }}"/>
                            <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark" width="120" style="border-width:medium;"/>
                            <div style="margin-top:-40px; margin-left:100px;">
                                <span class="label">
                                    @if($user['user_class'] != '0')
                                    <img src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="50" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/></span>
                                    @endif
                            </div>
                            <div style="margin-top:0px; margin-bottom:20px; font-weight:bold;">{{$user['alias']}}</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="27"><div class="first_line"></div></td>
                    </tr>
                    @if (!empty(isset($hierarchy['downline'])))
                        {{--*/ $level1 = $hierarchy['downline'] /*--}}
                    @endif
                    <tr class="net_second hierow_color">
                        <td colspan="9">
                            <div class="verticle_line"></div>
                            @if (!empty(isset($level1['1'])))
                                {{--*/ $user = $level1['1'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <img src="{{asset('assets/images/iv_'.$user['id_verify_status'].'.png')}}" class="verified_icon_id_l2" data-toggle="tooltip" data-placement="right" title="{{ $user['id_verify_tooltip'] }}"/>
                            <img src="{{asset('assets/images/pv_'.$user['selfie_verify_status'].'.png')}}" class="verified_icon_ph_l2" data-toggle="tooltip" data-placement="right" title="{{ $user['selfie_verify_tooltip'] }}"/>
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#3">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a><br>
                            <img class="classbadge_l2" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                            <div style="margin-top:13px; margin-bottom:20px; font-weight:bold;">{{ $user['alias'] }}</div>
                        </td>
                        <td colspan="9">

                            <div id="navigation">
                            </div>
                            <div class="verticle_line ver_mid"></div>
                            @if (!empty(isset($level1['2'])))
                                {{--*/ $user = $level1['2'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <img src="{{asset('assets/images/iv_'.$user['id_verify_status'].'.png')}}" class="verified_icon_id_l2" data-toggle="tooltip" data-placement="right" title="{{ $user['id_verify_tooltip'] }}"/>
                            <img src="{{asset('assets/images/pv_'.$user['selfie_verify_status'].'.png')}}" class="verified_icon_ph_l2" data-toggle="tooltip" data-placement="right" title="{{ $user['selfie_verify_tooltip'] }}"/>
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#4">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a><br>
                            <img class="classbadge_l2" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                            <div style="margin-top:13px; margin-bottom:20px; font-weight:bold;">{{ $user['alias'] }}</div>
                        </td>
                        <td colspan="9">
                            <!--<div style="position:absolute;">info::</div>-->
                            <div class="verticle_line"></div>
                            @if (!empty(isset($level1['3'])))
                                {{--*/ $user = $level1['3'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <img src="{{asset('assets/images/iv_'.$user['id_verify_status'].'.png')}}" class="verified_icon_id_l2" data-toggle="tooltip" data-placement="right" title="{{ $user['id_verify_tooltip'] }}"/>
                            <img src="{{asset('assets/images/pv_'.$user['selfie_verify_status'].'.png')}}" class="verified_icon_ph_l2" data-toggle="tooltip" data-placement="right" title="{{ $user['selfie_verify_tooltip'] }}"/>
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#5">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a><br>
                            <img class="classbadge_l2" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                            <div style="margin-top:13px; margin-bottom:20px; font-weight:bold;">{{ $user['alias'] }}</div>
                        </td>
                    </tr>
                    <tr class="hidden-xs">
                        <td colspan="9"><div class="first_line"></div></td>
                        <td colspan="9"><div class="first_line"></div></td>
                        <td colspan="9"><div class="first_line"></div></td>
                    </tr>
                    @if (!empty(isset($level1[1]['downline'])))
                        {{--*/ $level21 = $level1[1]['downline'] /*--}}
                    @endif
                    @if (!empty(isset($level1[2]['downline'])))
                        {{--*/ $level22 = $level1[2]['downline'] /*--}}
                    @endif
                    @if (!empty(isset($level1[3]['downline'])))
                        {{--*/ $level23 = $level1[3]['downline'] /*--}}
                    @endif
                    <tr class="net_third hidden-xs">
                        <td colspan="3">
                            <div class="verticle_line"></div>
                            @if (!empty(isset($level21['1'])))
                                {{--*/ $user = $level21['1'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <img src="{{asset('assets/images/iv_'.$user['id_verify_status'].'.png')}}" class="verified_icon_id_l3" data-toggle="tooltip" data-placement="right" title="{{ $user['id_verify_tooltip'] }}"/>
                            <img src="{{asset('assets/images/pv_'.$user['selfie_verify_status'].'.png')}}" class="verified_icon_ph_l3" data-toggle="tooltip" data-placement="right" title="{{ $user['selfie_verify_tooltip'] }}"/>
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#6" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a><br><br>
                            <img class="classbadge_l3" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td colspan="3">
                            <div class="verticle_line ver_mid"></div>
                            @if (!empty(isset($level21['2'])))
                                {{--*/ $user = $level21['2'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <img src="{{asset('assets/images/iv_'.$user['id_verify_status'].'.png')}}" class="verified_icon_id_l3" data-toggle="tooltip" data-placement="right" title="{{ $user['id_verify_tooltip'] }}"/>
                            <img src="{{asset('assets/images/pv_'.$user['selfie_verify_status'].'.png')}}" class="verified_icon_ph_l3" data-toggle="tooltip" data-placement="right" title="{{ $user['selfie_verify_tooltip'] }}"/>
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#7" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a><br><br>
                            <img class="classbadge_l3" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td colspan="3">
                            <div class="verticle_line"></div>
                            @if (!empty(isset($level21['3'])))
                                {{--*/ $user = $level21['3'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <img src="{{asset('assets/images/iv_'.$user['id_verify_status'].'.png')}}" class="verified_icon_id_l3" data-toggle="tooltip" data-placement="right" title="{{ $user['id_verify_tooltip'] }}"/>
                            <img src="{{asset('assets/images/pv_'.$user['selfie_verify_status'].'.png')}}" class="verified_icon_ph_l3" data-toggle="tooltip" data-placement="right" title="{{ $user['selfie_verify_tooltip'] }}"/>
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#8" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a><br><br>
                            <img class="classbadge_l3" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td colspan="3">
                            <div class="verticle_line"></div>
                            @if (!empty(isset($level22['1'])))
                                {{--*/ $user = $level22['1'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <img src="{{asset('assets/images/iv_'.$user['id_verify_status'].'.png')}}" class="verified_icon_id_l3" data-toggle="tooltip" data-placement="right" title="{{ $user['id_verify_tooltip'] }}"/>
                            <img src="{{asset('assets/images/pv_'.$user['selfie_verify_status'].'.png')}}" class="verified_icon_ph_l3" data-toggle="tooltip" data-placement="right" title="{{ $user['selfie_verify_tooltip'] }}"/>
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#9" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a><br><br>
                            <img class="classbadge_l3" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td colspan="3">
                            <div class="verticle_line ver_mid"></div>
                            @if (!empty(isset($level22['2'])))
                                {{--*/ $user = $level22['2'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <img src="{{asset('assets/images/iv_'.$user['id_verify_status'].'.png')}}" class="verified_icon_id_l3" data-toggle="tooltip" data-placement="right" title="{{ $user['id_verify_tooltip'] }}"/>
                            <img src="{{asset('assets/images/pv_'.$user['selfie_verify_status'].'.png')}}" class="verified_icon_ph_l3" data-toggle="tooltip" data-placement="right" title="{{ $user['selfie_verify_tooltip'] }}"/>
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#10" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a><br><br>
                            <img class="classbadge_l3" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td colspan="3">
                            <div class="verticle_line"></div>
                            @if (!empty(isset($level22['3'])))
                                {{--*/ $user = $level22['3'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <img src="{{asset('assets/images/iv_'.$user['id_verify_status'].'.png')}}" class="verified_icon_id_l3" data-toggle="tooltip" data-placement="right" title="{{ $user['id_verify_tooltip'] }}"/>
                            <img src="{{asset('assets/images/pv_'.$user['selfie_verify_status'].'.png')}}" class="verified_icon_ph_l3" data-toggle="tooltip" data-placement="right" title="{{ $user['selfie_verify_tooltip'] }}"/>
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#11" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a><br><br>
                            <img class="classbadge_l3" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td colspan="3">
                            <div class="verticle_line"></div>
                            @if (!empty(isset($level23['1'])))
                                {{--*/ $user = $level23['1'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <img src="{{asset('assets/images/iv_'.$user['id_verify_status'].'.png')}}" class="verified_icon_id_l3" data-toggle="tooltip" data-placement="right" title="{{ $user['id_verify_tooltip'] }}"/>
                            <img src="{{asset('assets/images/pv_'.$user['selfie_verify_status'].'.png')}}" class="verified_icon_ph_l3" data-toggle="tooltip" data-placement="right" title="{{ $user['selfie_verify_tooltip'] }}"/>
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#12" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a><br><br>
                            <img class="classbadge_l3" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td colspan="3">
                            <div class="verticle_line ver_mid"></div>
                            @if (!empty(isset($level23['2'])))
                                {{--*/ $user = $level23['2'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <img src="{{asset('assets/images/iv_'.$user['id_verify_status'].'.png')}}" class="verified_icon_id_l3" data-toggle="tooltip" data-placement="right" title="{{ $user['id_verify_tooltip'] }}"/>
                            <img src="{{asset('assets/images/pv_'.$user['selfie_verify_status'].'.png')}}" class="verified_icon_ph_l3" data-toggle="tooltip" data-placement="right" title="{{ $user['selfie_verify_tooltip'] }}"/>
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#13" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a><br><br>
                            <img class="classbadge_l3" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td colspan="3">
                            <div class="verticle_line"></div>
                            @if (!empty(isset($level23['3'])))
                                {{--*/ $user = $level23['3'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <img src="{{asset('assets/images/iv_'.$user['id_verify_status'].'.png')}}" class="verified_icon_id_l3" data-toggle="tooltip" data-placement="right" title="{{ $user['id_verify_tooltip'] }}"/>
                            <img src="{{asset('assets/images/pv_'.$user['selfie_verify_status'].'.png')}}" class="verified_icon_ph_l3" data-toggle="tooltip" data-placement="right" title="{{ $user['selfie_verify_tooltip'] }}"/>
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#14" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a><br><br>
                            <img class="classbadge_l3" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                    </tr>
                    <tr class="hidden-sm hidden-xs">
                        <td colspan="3"><div class="first_line"></div></td>
                        <td colspan="3"><div class="first_line"></div></td>
                        <td colspan="3"><div class="first_line"></div></td>
                        <td colspan="3"><div class="first_line"></div></td>
                        <td colspan="3"><div class="first_line"></div></td>
                        <td colspan="3"><div class="first_line"></div></td>
                        <td colspan="3"><div class="first_line"></div></td>
                        <td colspan="3"><div class="first_line"></div></td>
                        <td colspan="3"><div class="first_line"></div></td>
                    </tr>
                    @if (!empty(isset($level21[1]['downline'])))
                        {{--*/ $level311 = $level21[1]['downline'] /*--}}
                    @endif
                    @if (!empty(isset($level21[2]['downline'])))
                        {{--*/ $level312 = $level21[2]['downline'] /*--}}
                    @endif
                    @if (!empty(isset($level21[3]['downline'])))
                        {{--*/ $level313 = $level21[3]['downline'] /*--}}
                    @endif


                    @if (!empty(isset($level22[1]['downline'])))
                        {{--*/ $level321 = $level22[1]['downline'] /*--}}
                    @endif
                    @if (!empty(isset($level22[2]['downline'])))
                        {{--*/ $level322 = $level22[2]['downline'] /*--}}
                    @endif
                    @if (!empty(isset($level22[3]['downline'])))
                        {{--*/ $level323 = $level22[3]['downline'] /*--}}
                    @endif


                    @if (!empty(isset($level23[1]['downline'])))
                        {{--*/ $level331 = $level23[1]['downline'] /*--}}
                    @endif
                    @if (!empty(isset($level23[2]['downline'])))
                        {{--*/ $level332 = $level23[2]['downline'] /*--}}
                    @endif
                    @if (!empty(isset($level23[3]['downline'])))
                        {{--*/ $level333 = $level23[3]['downline'] /*--}}
                    @endif
                    <tr class="net_forth hidden-sm hidden-xs">
                        <td>
                            <div class="verticle_line_forth"></div>
                            @if (!empty(isset($level311['1'])))
                                {{--*/ $user = $level311['1'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#15" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth ver_mid_forth"></div>
                            @if (!empty(isset($level311['2'])))
                                {{--*/ $user = $level311['2'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#16" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            @if (!empty(isset($level311['3'])))
                                {{--*/ $user = $level311['3'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#17" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            @if (!empty(isset($level312['1'])))
                                {{--*/ $user = $level312['1'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#18" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth ver_mid_forth"></div>
                            @if (!empty(isset($level312['2'])))
                                {{--*/ $user = $level312['2'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#19" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            @if (!empty(isset($level312['3'])))
                                {{--*/ $user = $level312['3'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#20" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            @if (!empty(isset($level313['1'])))
                                {{--*/ $user = $level313['1'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#21" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth ver_mid_forth"></div>
                            @if (!empty(isset($level313['2'])))
                                {{--*/ $user = $level313['2'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#22" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            @if (!empty(isset($level313['3'])))
                                {{--*/ $user = $level313['3'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#23" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>



                        <td>
                            <div class="verticle_line_forth"></div>
                            @if (!empty(isset($level321['1'])))
                                {{--*/ $user = $level321['1'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#24" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth ver_mid_forth"></div>
                            @if (!empty(isset($level321['2'])))
                                {{--*/ $user = $level321['2'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#25" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            @if (!empty(isset($level321['3'])))
                                {{--*/ $user = $level321['3'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#26" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            @if (!empty(isset($level322['1'])))
                                {{--*/ $user = $level322['1'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#27" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth ver_mid_forth"></div>
                            @if (!empty(isset($level322['2'])))
                                {{--*/ $user = $level322['2'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#28" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            @if (!empty(isset($level322['3'])))
                                {{--*/ $user = $level322['3'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#29" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            @if (!empty(isset($level323['1'])))
                                {{--*/ $user = $level323['1'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#30" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth ver_mid_forth"></div>
                            @if (!empty(isset($level323['2'])))
                                {{--*/ $user = $level323['2'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#31" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            @if (!empty(isset($level323['3'])))
                                {{--*/ $user = $level323['3'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#32" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>



                        <td>
                            <div class="verticle_line_forth"></div>
                            @if (!empty(isset($level331['1'])))
                                {{--*/ $user = $level331['1'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#33" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth ver_mid_forth"></div>
                            @if (!empty(isset($level331['2'])))
                                {{--*/ $user = $level331['2'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#34" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            @if (!empty(isset($level331['3'])))
                                {{--*/ $user = $level331['3'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#35" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            @if (!empty(isset($level332['1'])))
                                {{--*/ $user = $level332['1'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#36" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth ver_mid_forth"></div>
                            @if (!empty(isset($level332['2'])))
                                {{--*/ $user = $level332['2'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#37" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            @if (!empty(isset($level332['3'])))
                                {{--*/ $user = $level332['3'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#38" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            @if (!empty(isset($level333['1'])))
                                {{--*/ $user = $level333['1'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#39" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth ver_mid_forth"></div>
                            @if (!empty(isset($level333['2'])))
                                {{--*/ $user = $level333['2'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#40" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            @if (!empty(isset($level333['3'])))
                                {{--*/ $user = $level333['3'] /*--}}
                            @else
                                {{--*/ $user = $empty /*--}}
                            @endif
                            <a class="seemore" data-id="{{ $user['id'] }}" href="#41" data-toggle="tooltip" data-placement="top" title="{{ $user['alias'] }}">
                                <img onerror="imgError(this);" src="{{S3Files::url('profiles/'.$user['profile_pic'])}}" title="{{ $user['alias'] }}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/'.$user['user_class'].'.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="{{ $user['user_class_name'] }}"/>
                        </td>
                    </tr>
                </table>

            </div>


        </div>
        <form id="hierarchy" href="{{URL::route('hierarchy')}}" method="post">
            <input id="user_id" name="id" type="hidden" value="3">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        </form>
        <!-- /.row -->

        <div class="modal fade" id="movePlacement" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Move Network</h4>
                    </div>
                    <div class="modal-body">
                        <table width="100%">
                            <tr>
                                <td width="33.33%" align="center">
                                    <div>Left</div>
                                    <select id="move1">
                                        <option value="0">&nbsp;</option>
                                        @if (isset($level1['1']))
                                            @if (!count($level1['1']['downline']))
                                        <option value="{{ $level1['1']['id'] }}" @if ( $level1['1']['tree_position'] == "1") selected @endif>{{ $level1['1']['alias'] }}</option>
                                            @endif
                                        @endif
                                        @if (isset($level1['2']))
                                            @if (!count($level1['2']['downline']))
                                        <option value="{{ $level1['2']['id'] }}" @if ( $level1['2']['tree_position'] == "1") selected @endif>{{ $level1['2']['alias'] }}</option>
                                            @endif
                                        @endif
                                        @if (isset($level1['3']))
                                            @if (!count($level1['3']['downline']))
                                        <option value="{{ $level1['3']['id'] }}" @if ( $level1['3']['tree_position'] == "1") selected @endif>{{ $level1['3']['alias'] }}</option>
                                            @endif
                                        @endif
                                    </select>
                                </td>
                                <td width="33.33%" align="center">
                                    <div>Middle</div>
                                    <select id="move2">
                                        <option value="0">&nbsp;</option>
                                        @if (isset($level1['1']))
                                            @if (!count($level1['1']['downline']))
                                                <option value="{{ $level1['1']['id'] }}" @if ( $level1['1']['tree_position'] == "2") selected @endif>{{ $level1['1']['alias'] }}</option>
                                            @endif
                                        @endif
                                        @if (isset($level1['2']))
                                            @if (!count($level1['2']['downline']))
                                                <option value="{{ $level1['2']['id'] }}" @if ( $level1['2']['tree_position'] == "2") selected @endif>{{ $level1['2']['alias'] }}</option>
                                            @endif
                                        @endif
                                        @if (isset($level1['3']))
                                            @if (!count($level1['3']['downline']))
                                                <option value="{{ $level1['3']['id'] }}" @if ( $level1['3']['tree_position'] == "2") selected @endif>{{ $level1['3']['alias'] }}</option>
                                            @endif
                                        @endif
                                    </select>
                                </td>
                                <td width="33.33%" align="center">
                                    <div>Right</div>
                                    <select id="move3">
                                        <option value="0">&nbsp;</option>
                                        @if (isset($level1['1']))
                                            @if (!count($level1['1']['downline']))
                                                <option value="{{ $level1['1']['id'] }}" @if ( $level1['1']['tree_position'] == "3") selected @endif>{{ $level1['1']['alias'] }}</option>
                                            @endif
                                        @endif
                                        @if (isset($level1['2']))
                                            @if (!count($level1['2']['downline']))
                                                <option value="{{ $level1['2']['id'] }}" @if ( $level1['2']['tree_position'] == "3") selected @endif>{{ $level1['2']['alias'] }}</option>
                                            @endif
                                        @endif
                                        @if (isset($level1['3']))
                                            @if (!count($level1['3']['downline']))
                                                <option value="{{ $level1['3']['id'] }}" @if ( $level1['3']['tree_position'] == "3") selected @endif>{{ $level1['3']['alias'] }}</option>
                                            @endif
                                        @endif
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a href="#" class="btn btn-primary" id="move_placement">Move Placement</a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<script type="text/javascript">
    var oriMove1;
    var oriMove2;
    var oriMove3;

    $('.seemore').click(function(){
        var userid = $(this).attr('data-id');
        $('#user_id').val(userid);
        if(userid>0) {
            $('#hierarchy').submit();
        }
    })

    function imgError(image) {
        image.onerror = "";
        image.src = "{{S3Files::url('profiles/no_img.jpg')}}";
        return true;
    }

    $( document ).ready(function() {
        oriMove1 = $( "#move1" ).val();
        oriMove2 = $( "#move2" ).val();
        oriMove3 = $( "#move3" ).val();
    });

    function move_placement(alias, userMove) {
        if (alias != "") {
            if (alias == oriMove1) {
                $("#move1").val(userMove);
                $("#move1").css('background-color', 'lightgray');
            }
            else if (alias == oriMove2) {
                $("#move2").val(userMove);
                $("#move2").css('background-color', 'lightgray');
            }
            else if (alias == oriMove3) {
                $("#move3").val(userMove);
                $("#move3").css('background-color', 'lightgray');
            }
        }
        $('#move1').attr('disabled', true);
        $('#move2').attr('disabled', true);
        $('#move3').attr('disabled', true);
        $('#move_placement').attr('href', '{{ URL::to('/') }}/members/move_placement/' + $("#move1").val() + "/" + $("#move2").val() + "/" + $("#move3").val());
    }

    $( "#move1" ).change(function() {
        var alias = $(this).val();

        $(this).css('background-color', 'lightgray');
        move_placement(alias, oriMove1);

    });
    $( "#move2" ).change(function() {
        var alias = $(this).val();

        $(this).css('background-color', 'lightgray');
        move_placement(alias, oriMove2);
    });
    $( "#move3" ).change(function() {
        var alias = $(this).val();

        $(this).css('background-color', 'lightgray');
        move_placement(alias, oriMove3);
    });

    $(document).on('click', '.modal-dismiss', function (e) {
        e.preventDefault();
        $("#move1").val(oriMove1);
        $("#move2").val(oriMove2);
        $("#move3").val(oriMove3);
        $('#move1').attr('disabled', false);
        $('#move2').attr('disabled', false);
        $('#move3').attr('disabled', false);
        $("#move1").css('background-color', 'white');
        $("#move2").css('background-color', 'white');
        $("#move3").css('background-color', 'white');
        $.magnificPopup.close();
    });

    $(document).on('click', '.close', function (e) {
        e.preventDefault();
        $("#move1").val(oriMove1);
        $("#move2").val(oriMove2);
        $("#move3").val(oriMove3);
        $('#move1').attr('disabled', false);
        $('#move2').attr('disabled', false);
        $('#move3').attr('disabled', false);
        $("#move1").css('background-color', 'white');
        $("#move2").css('background-color', 'white');
        $("#move3").css('background-color', 'white');
        $.magnificPopup.close();
    });
</script>
@Stop