@extends('member.default')

@section('title')Network Hierarchy @Stop

@section('nh-class')nav-active @Stop
@section('hierarchy-class')nav-expanded nav-active @Stop

@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">

            <div class="net_wrapper">
                <div style="position:absolute; font-weight:bold; color:#999;">
                    <div>&nbsp;</div>
                    <div style="margin-top:150px;">1</div>
                    <div class="hidden-xs" style="margin-top:160px;">2</div>
                    <div class="hidden-sm hidden-xs" style="margin-top:80px;">3</div>
                </div>

                <table border="0" style="width:100%; text-align:center;">
                    <tr>
                        <td colspan="27" class="net_first">
                            <img src="{{asset('assets/images/iv_'.$user_1['vid'].'.png')}}" class="verified_icon_id_l1" data-toggle="tooltip" data-placement="right" title="ID Verified"/>
                            <img src="{{asset('assets/images/pv_'.$user_1['vph'].'.png')}}" class="verified_icon_ph_l1" data-toggle="tooltip" data-placement="right" title="Photo Verified"/>
                            <img src="{{asset('profiles/'.$user_1['img'])}}" class="img-rounded bor_dark" width="120" style="border-width:medium;"/>
                            <div style="margin-top:-40px; margin-left:80px;">
                                <span class="label">
                                    @if($user_1['class'] != '0')
                                    <img src="{{asset('assets/images/class/'.$user_1['class'].'.png')}}" width="50" data-toggle="tooltip" data-placement="bottom" title="Immigrant"/></span>
                                    @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="27"><div class="first_line"></div></td>
                    </tr>
                    <tr class="net_second hierow_color">
                        <td colspan="9">
                            <div class="verticle_line"></div>
                            <img src="{{asset('assets/images/iv_0.png')}}" class="verified_icon_id_l2" data-toggle="tooltip" data-placement="right" title="ID Not Verified"/>
                            <img src="{{asset('assets/images/pv_0.png')}}" class="verified_icon_ph_l2" data-toggle="tooltip" data-placement="right" title="Photo Not Verified"/>
                            <a class="seemore" href="#3">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a><br>
                            <img class="classbadge_l2" src="{{asset('assets/images/class/7.png')}}" width="40" data-toggle="tooltip" data-placement="bottom" title="Vice President"/>
                        </td>
                        <td colspan="9">

                            <div id="navigation">
                            </div>
                            <div class="verticle_line ver_mid"></div>
                            <img src="{{asset('assets/images/iv_1.png')}}" class="verified_icon_id_l2" data-toggle="tooltip" data-placement="right" title="ID Verified"/>
                            <img src="{{asset('assets/images/pv_1.png')}}" class="verified_icon_ph_l2" data-toggle="tooltip" data-placement="right" title="Photo Verified"/>
                            <a class="seemore" href="#4">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a><br>
                            <img class="classbadge_l2" src="{{asset('assets/images/class/7.png')}}" width="40" data-toggle="tooltip" data-placement="bottom" title="Vice President"/>
                        </td>
                        <td colspan="9">
                            <!--<div style="position:absolute;">info::</div>-->
                            <div class="verticle_line"></div>
                            <img src="{{asset('assets/images/iv_1.png')}}" class="verified_icon_id_l2" data-toggle="tooltip" data-placement="right" title="ID Verified"/>
                            <img src="{{asset('assets/images/pv_1.png')}}" class="verified_icon_ph_l2" data-toggle="tooltip" data-placement="right" title="Photo Verified"/>
                            <a class="seemore" href="#5">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a><br>
                            <img class="classbadge_l2" src="{{asset('assets/images/class/7.png')}}" width="40" data-toggle="tooltip" data-placement="bottom" title="Vice President"/>
                        </td>
                    </tr>
                    <tr class="hidden-xs">
                        <td colspan="9"><div class="first_line"></div></td>
                        <td colspan="9"><div class="first_line"></div></td>
                        <td colspan="9"><div class="first_line"></div></td>
                    </tr>
                    <tr class="net_third hidden-xs">
                        <td colspan="3">
                            <div class="verticle_line"></div>
                            <img src="{{asset('assets/images/iv_1.png')}}" class="verified_icon_id_l3" data-toggle="tooltip" data-placement="right" title="ID Verified"/>
                            <img src="{{asset('assets/images/pv_1.png')}}" class="verified_icon_ph_l3" data-toggle="tooltip" data-placement="right" title="Photo Verified"/>
                            <a class="seemore" href="#6"><img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/></a><br><br>
                            <img class="classbadge_l3" src="{{asset('assets/images/class/7.png')}}" width="25" data-toggle="tooltip" data-placement="bottom" title="Vice President"/>
                        </td>
                        <td colspan="3">
                            <div class="verticle_line ver_mid"></div>
                            <img src="{{asset('assets/images/iv_0.png')}}" class="verified_icon_id_l3" data-toggle="tooltip" data-placement="right" title="ID Verified"/>
                            <img src="{{asset('assets/images/pv_0.png')}}" class="verified_icon_ph_l3" data-toggle="tooltip" data-placement="right" title="Photo Verified"/>
                            <a class="seemore" href="#7"><img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/></a><br><br>
                            <img class="classbadge_l3" src="{{asset('assets/images/class/7.png')}}" width="25" data-toggle="tooltip" data-placement="bottom" title="Vice President"/>
                        </td>
                        <td colspan="3">
                            <div class="verticle_line"></div>
                            <img src="{{asset('assets/images/iv_0.png')}}" class="verified_icon_id_l3" data-toggle="tooltip" data-placement="right" title="ID Verified"/>
                            <img src="{{asset('assets/images/pv_0.png')}}" class="verified_icon_ph_l3" data-toggle="tooltip" data-placement="right" title="Photo Verified"/>
                            <a class="seemore" href="#8"><img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/></a><br><br>
                            <img class="classbadge_l3" src="{{asset('assets/images/class/7.png')}}" width="25" data-toggle="tooltip" data-placement="bottom" title="Vice President"/>
                        </td>
                        <td colspan="3">
                            <div class="verticle_line"></div>
                            <img src="{{asset('assets/images/iv_0.png')}}" class="verified_icon_id_l3" data-toggle="tooltip" data-placement="right" title="ID Verified"/>
                            <img src="{{asset('assets/images/pv_0.png')}}" class="verified_icon_ph_l3" data-toggle="tooltip" data-placement="right" title="Photo Verified"/>
                            <a class="seemore" href="#9"><img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/></a><br><br>
                            <img class="classbadge_l3" src="{{asset('assets/images/class/7.png')}}" width="25" data-toggle="tooltip" data-placement="bottom" title="Vice President"/>
                        </td>
                        <td colspan="3">
                            <div class="verticle_line ver_mid"></div>
                            <img src="{{asset('assets/images/iv_0.png')}}" class="verified_icon_id_l3" data-toggle="tooltip" data-placement="right" title="ID Verified"/>
                            <img src="{{asset('assets/images/pv_0.png')}}" class="verified_icon_ph_l3" data-toggle="tooltip" data-placement="right" title="Photo Verified"/>
                            <a class="seemore" href="#10"><img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/></a><br><br>
                            <img class="classbadge_l3" src="{{asset('assets/images/class/7.png')}}" width="25" data-toggle="tooltip" data-placement="bottom" title="Vice President"/>
                        </td>
                        <td colspan="3">
                            <div class="verticle_line"></div>
                            <img src="{{asset('assets/images/iv_0.png')}}" class="verified_icon_id_l3" data-toggle="tooltip" data-placement="right" title="ID Verified"/>
                            <img src="{{asset('assets/images/pv_0.png')}}" class="verified_icon_ph_l3" data-toggle="tooltip" data-placement="right" title="Photo Verified"/>
                            <a class="seemore" href="#11"><img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/></a><br><br>
                            <img class="classbadge_l3" src="{{asset('assets/images/class/7.png')}}" width="25" data-toggle="tooltip" data-placement="bottom" title="Vice President"/>
                        </td>
                        <td colspan="3">
                            <div class="verticle_line"></div>
                            <img src="{{asset('assets/images/iv_0.png')}}" class="verified_icon_id_l3" data-toggle="tooltip" data-placement="right" title="ID Verified"/>
                            <img src="{{asset('assets/images/pv_0.png')}}" class="verified_icon_ph_l3" data-toggle="tooltip" data-placement="right" title="Photo Verified"/>
                            <a class="seemore" href="#12"><img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/></a><br><br>
                            <img class="classbadge_l3" src="{{asset('assets/images/class/7.png')}}" width="25" data-toggle="tooltip" data-placement="bottom" title="Vice President"/>
                        </td>
                        <td colspan="3">
                            <div class="verticle_line ver_mid"></div>
                            <img src="{{asset('assets/images/iv_0.png')}}" class="verified_icon_id_l3" data-toggle="tooltip" data-placement="right" title="ID Verified"/>
                            <img src="{{asset('assets/images/pv_0.png')}}" class="verified_icon_ph_l3" data-toggle="tooltip" data-placement="right" title="Photo Verified"/>
                            <a class="seemore" href="#13"><img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/></a><br><br>
                            <img class="classbadge_l3" src="{{asset('assets/images/class/7.png')}}" width="25" data-toggle="tooltip" data-placement="bottom" title="Vice President"/>
                        </td>
                        <td colspan="3">
                            <div class="verticle_line"></div>
                            <img src="{{asset('assets/images/iv_0.png')}}" class="verified_icon_id_l3" data-toggle="tooltip" data-placement="right" title="ID Verified"/>
                            <img src="{{asset('assets/images/pv_0.png')}}" class="verified_icon_ph_l3" data-toggle="tooltip" data-placement="right" title="Photo Verified"/>
                            <a class="seemore" href="#14"><img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/></a><br><br>
                            <img class="classbadge_l3" src="{{asset('assets/images/class/7.png')}}" width="25" data-toggle="tooltip" data-placement="bottom" title="Vice President"/>
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
                    <tr class="net_forth hidden-sm hidden-xs">
                        <td>
                            <div class="verticle_line_forth"></div>
                            <a class="seemore" href="#15">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth ver_mid_forth"></div>
                            <a class="seemore" href="#16">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            <a class="seemore" href="#17">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            <a class="seemore" href="#18">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth ver_mid_forth"></div>
                            <a class="seemore" href="#19">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            <a class="seemore" href="#20">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            <a class="seemore" href="#21">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth ver_mid_forth"></div>
                            <a class="seemore" href="#22">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            <a class="seemore" href="#23">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>



                        <td>
                            <div class="verticle_line_forth"></div>
                            <a class="seemore" href="#24">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth ver_mid_forth"></div>
                            <a class="seemore" href="#25">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            <a class="seemore" href="#26">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            <a class="seemore" href="#27">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth ver_mid_forth"></div>
                            <a class="seemore" href="#28">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            <a class="seemore" href="#29">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            <a class="seemore" href="#30">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth ver_mid_forth"></div>
                            <a class="seemore" href="#31">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            <a class="seemore" href="#32">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>



                        <td>
                            <div class="verticle_line_forth"></div>
                            <a class="seemore" href="#33">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth ver_mid_forth"></div>
                            <a class="seemore" href="#34">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            <a class="seemore" href="#35">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            <a class="seemore" href="#36">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth ver_mid_forth"></div>
                            <a class="seemore" href="#37">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            <a class="seemore" href="#38">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            <a class="seemore" href="#39">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth ver_mid_forth"></div>
                            <a class="seemore" href="#40">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                        <td>
                            <div class="verticle_line_forth"></div>
                            <a class="seemore" href="#41">
                                <img src="{{asset('profiles/no_img.jpg')}}" class="img-rounded bor_dark"/>
                            </a>
                            <img class="classbadge" src="{{asset('assets/images/class/5.png')}}" width="15" data-toggle="tooltip" data-placement="bottom" title="Embassador"/>
                        </td>
                    </tr>
                </table>

            </div>


        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

@Stop