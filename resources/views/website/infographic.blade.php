@extends('website.default')

@section('title')Infographic @Stop

@section('infographicclass')active @Stop

@section('content')
<link href="web_content/infographic/css/igstyle.css" rel="stylesheet" type="text/css"/>
<div role="main" class="main">

    <div class="container ">
        <div class="row bg-dark b-dark">
            <div class="col-lg-12 ">
                <br/><br/>
                <p class="center-txt">
                    <span class="robo-bold center-txt grey-txt fs120">{{trans('websitenew.howto')}} <br> {{trans('websitenew.makemoney')}}</span>
                </p>
                <p class="right-txt line75 pr180">
                    <span class="oren-txt fs40">{{trans('websitenew.brway')}}</span>
                </p>
                <br/><br/>

            </div>
        </div>

        <div class="row">
            <div class="ribbon">{{trans('websitenew.starterguide')}}</div>
        </div>

        <div class="row bg-dark b-dark">
            <br/><br/>
            <div class="col-lg-4">
                <div class="col-xs-5">
                    <img src="web_content/infographic/img/no1.png" alt="Step 1" class='img-responsive'/>
                </div>
                <div class="col-xs-7">
                    <span class="red-txt fs26 robo-bold">{{trans('websitenew.registerat')}}</span><br/>
                    <span class="grey-txt fs24 mont-norm">bitregion.com</span>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="col-xs-5">
                    <img src="web_content/infographic/img/no2.png" alt="Step 2" class='img-responsive'/>
                </div>
                <div class="col-xs-7">
                    <span class="oren-txt fs26 robo-bold">{{trans('websitenew.clickupgrade')}}</span><br/>
                    <span class="grey-txt fs24 mont-norm">{{trans('websitenew.toimmigrant')}} <span class="oren-txt">*</span></span>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="col-xs-5">
                    <img src="web_content/infographic/img/no3.png" alt="Step 3" class='img-responsive'/>
                </div>
                <div class="col-xs-7">
                    <span class="blu-txt fs26 robo-bold">{{trans('websitenew.fullaccess')}}</span><br/>
                    <span class="grey-txt fs24 mont-norm">{{trans('websitenew.tosystem')}}</span>
                </div>
            </div>
            <div class="clearfix"></div>
            <br/>
            <div class="col-lg-12">
                <p class="oren-txt fs18 robo-norm">
                    {{trans('websitenew.byupgradeto')}}
                </p>
            </div>
            <br/>
        </div>

        <div class="row">
            <div class="ribbon">{{trans('websitenew.howtogrow')}}</div>
        </div>

        <div class="row bg-dark b-dark">
            <br/>
            <div class="col-lg-12 center-txt">
                <span class="robo-norm center-txt grey-txt fs50">{{trans('websitenew.thereare')}} <span class="robo-bold oren-txt fs60">2</span> {{trans('websitenew.waysto')}}</span>
            </div>
            <div class="clearfix"></div>
            <br/><br/>
            <div class="col-lg-6">
                <div class="col-sm-5">
                    <img src="web_content/infographic/img/assistance.png" alt="Assistance" width="250" class="img-responsive"/>
                </div>
                <div class="col-sm-7 center-txt">
                    <span class="red-txt fs24 robo-bold">{{trans('websitenew.way1')}}</span><br/>
                    <span class="grey-txt fs20 robo-norm">{{trans('websitenew.way2')}}</span><br/>
                    <span class="red-txt fs24 robo-bold">{{trans('websitenew.way3')}}</span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="col-sm-5">
                    <img src="web_content/infographic/img/region.png" alt="Region" width="250" class="img-responsive"/>
                </div>
                <div class="col-sm-7 center-txt">
                    <span class="blu-txt fs24 robo-bold">{{trans('websitenew.way5')}}</span><br/>
                    <span class="grey-txt fs20 robo-norm">{{trans('websitenew.way6')}}</span><br/>
                    <span class="grey-txt fs20 robo-norm">{{trans('websitenew.way7')}}</span><br/>
                    <span class="blu-txt fs24 robo-bold">{{trans('websitenew.way8')}}</span>
                </div>
            </div>
            <div class="clearfix"></div>
            <br/><br/>
        </div>

        <div class="row">
            <div class="ribbon">{{trans('websitenew.brlevel')}}</div>
        </div>

        <div class="row bg-dark b-dark">
            <br/><br/>
            <div class="col-md-6">
                <div class="col-sm-4">
                    <img src="web_content/infographic/img/lvl1.png" alt="Level 1" class="img-responsive"/>
                </div>
                <div class="col-sm-8">
                    <span class="lime-txt fs20 robo-bold">{{trans('websitenew.level1')}}</span><br/>
                                    <span class="grey-txt fs18 robo-norm">
                                        {{trans('websitenew.promotereferral')}} <span class="lime-txt">0.45 BTC</span> {{trans('websitenew.peoplesignup')}} ({{trans('websitenew.max')}} 3 {{trans('websitenew.members')}})
                                        {{trans('websitenew.andupgrade')}} Immigrant {{trans('websitenew.thruref')}}
                                    </span><br/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-sm-4">
                    <img src="web_content/infographic/img/lvl2.png" alt="Level 2" class="img-responsive"/>
                </div>
                <div class="col-sm-8">
                    <span class="lime-dark-txt fs20 robo-bold">{{trans('websitenew.level2')}}</span><br/>
                                    <span class="grey-txt fs18 robo-norm">
                                        {{trans('websitenew.promotereferral')}} <span class="lime-dark-txt">4.05 BTC</span> {{trans('websitenew.peoplesignup')}} ({{trans('websitenew.max')}} 9 {{trans('websitenew.members')}})
                                        {{trans('websitenew.andupgrade')}} Visa Holder {{trans('websitenew.thruref')}}
                                    </span><br/>
                </div>
            </div>
            <div class="clearfix"></div>
            <br/>
            <div class="col-md-6">
                <div class="col-sm-4">
                    <img src="web_content/infographic/img/lvl3.png" alt="Level 3" class="img-responsive"/>
                </div>
                <div class="col-sm-8">
                    <span class="green-txt fs20 robo-bold">{{trans('websitenew.level3')}}</span><br/>
                                    <span class="grey-txt fs18 robo-norm">
                                        {{trans('websitenew.promotereferral')}} <span class="green-txt">12.15 BTC</span> {{trans('websitenew.peoplesignup')}} ({{trans('websitenew.max')}} 27 {{trans('websitenew.members')}})
                                        {{trans('websitenew.andupgrade')}} Permanent Resident {{trans('websitenew.thruref')}}
                                    </span><br/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-sm-4">
                    <img src="web_content/infographic/img/lvl4.png" alt="Level 4" class="img-responsive"/>
                </div>
                <div class="col-sm-8">
                    <span class="green-dark-txt fs20 robo-bold">{{trans('websitenew.level4')}}</span><br/>
                                    <span class="grey-txt fs18 robo-norm">
                                        {{trans('websitenew.promotereferral')}} <span class="green-dark-txt">72.9 BTC</span> {{trans('websitenew.peoplesignup')}} ({{trans('websitenew.max')}} 81 {{trans('websitenew.members')}})
                                        {{trans('websitenew.andupgrade')}} Citizen {{trans('websitenew.thruref')}}
                                    </span><br/>
                </div>
            </div>
            <div class="clearfix"></div>
            <br/>
            <div class="col-md-6">
                <div class="col-sm-4">
                    <img src="web_content/infographic/img/lvl5.png" alt="Level 5" class="img-responsive"/>
                </div>
                <div class="col-sm-8">
                    <span class="blu-txt fs20 robo-bold">{{trans('websitenew.level5')}}</span><br/>
                                    <span class="grey-txt fs18 robo-norm">
                                        {{trans('websitenew.promotereferral')}} <span class="blu-txt">291.6 BTC</span> {{trans('websitenew.peoplesignup')}} ({{trans('websitenew.max')}} 243 {{trans('websitenew.members')}})
                                        {{trans('websitenew.andupgrade')}} Ambassador {{trans('websitenew.thruref')}}
                                    </span><br/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-sm-4">
                    <img src="web_content/infographic/img/lvl6.png" alt="Level 6" class="img-responsive"/>
                </div>
                <div class="col-sm-8">
                    <span class="blu-dark-txt fs20 robo-bold">{{trans('websitenew.level6')}}</span><br/>
                                    <span class="grey-txt fs18 robo-norm">
                                        {{trans('websitenew.promotereferral')}} <span class="blu-dark-txt">1,530.9 BTC</span> {{trans('websitenew.peoplesignup')}} ({{trans('websitenew.max')}} 729 {{trans('websitenew.members')}})
                                        {{trans('websitenew.andupgrade')}} Senator {{trans('websitenew.thruref')}}
                                    </span><br/>
                </div>
            </div>
            <div class="clearfix"></div>
            <br/>
            <div class="col-md-6">
                <div class="col-sm-4">
                    <img src="web_content/infographic/img/lvl7.png" alt="Level 7" class="img-responsive"/>
                </div>
                <div class="col-sm-8">
                    <span class="oren-txt fs20 robo-bold">{{trans('websitenew.level7')}}</span><br/>
                                    <span class="grey-txt fs18 robo-norm">
                                        {{trans('websitenew.promotereferral')}} <span class="oren-txt">6561 BTC</span> {{trans('websitenew.peoplesignup')}} ({{trans('websitenew.max')}} 2187 {{trans('websitenew.members')}})
                                        {{trans('websitenew.andupgrade')}} Vice President {{trans('websitenew.thruref')}}
                                    </span><br/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-sm-4">
                    <img src="web_content/infographic/img/lvl8.png" alt="Level 8" class="img-responsive"/>
                </div>
                <div class="col-sm-8">
                    <span class="red-txt fs20 robo-bold">{{trans('websitenew.level8')}}</span><br/>
                                    <span class="grey-txt fs18 robo-norm">
                                        {{trans('websitenew.promotereferral')}} <span class="red-txt">29524 BTC</span> {{trans('websitenew.peoplesignup')}} ({{trans('websitenew.max')}} 6187 {{trans('websitenew.members')}})
                                        {{trans('websitenew.andupgrade')}} President {{trans('websitenew.thruref')}}
                                    </span><br/>
                </div>
            </div>
            <div class="clearfix"></div>
            <br/><br/>
        </div>

        <div class="row">
            <div class="ribbon">{{trans('websitenew.brrewards')}}</div>
        </div>

        <div class="row bg-dark b-dark">
            <br/><br/>
            <div class="col-lg-12 center-txt">
                <span class="robo-norm center-txt grey-txt fs50">{{trans('websitenew.dhigherdle')}}</span><br/>
                <span class="robo-bold red-txt fs60">{{trans('websitenew.dhigherdrew')}}</span>
            </div>
            <div class="clearfix"></div>
            <br/><br/>
            <div class="col-lg-4">
                <img src="web_content/infographic/img/passport.png" alt="passport" class="img-responsive m-center"/>
                <br/>
                <p class="text-center robo-norm fs16 grey-txt">
                    {{trans('websitenew.rew1')}}
                </p>
                <p class="text-center robo-norm fs20 oren-txt">
                    {{trans('websitenew.dref')}} <span class="grey-txt fs26">10%</span>
                </p>
                <p class="text-center robo-norm fs20 oren-txt">
                    {{trans('websitenew.over')}} <span class="grey-txt fs26">0.01%</span> {{trans('websitenew.to')}} <span class="grey-txt fs26">5%</span>
                </p>
            </div>
            <div class="col-lg-4">
                <img src="web_content/infographic/img/bonus.png" alt="bonus" class="img-responsive m-center"/>
                <br/>
                <p class="text-center robo-norm fs16 grey-txt">
                    {{trans('websitenew.rew2')}}
                </p>
                <br/>
                <p class="text-center robo-norm fs20 green-txt">
                    {{trans('websitenew.dref')}} <span class="grey-txt fs26">10%</span>
                </p>
                <p class="text-center robo-norm fs20 green-txt">
                    {{trans('websitenew.over')}} <span class="grey-txt fs26">0.1%</span> {{trans('websitenew.to')}} <span class="grey-txt fs26">5%</span>
                </p>
            </div>
            <div class="col-lg-4">
                <img src="web_content/infographic/img/pairing.png" alt="pairing" class="img-responsive m-center"/>
                <br/>
                <p class="text-center robo-norm fs16 grey-txt">
                    {{trans('websitenew.rew3')}}
                </p>
                <br/>
                <p class="text-center robo-norm fs20 blu-txt">
                    {{trans('websitenew.pairing')}} <span class="grey-txt fs26">0.5%</span> {{trans('websitenew.to')}} <span class="grey-txt fs26">10%</span>
                </p>
            </div>
            <div class="clearfix"></div>
            <br/><br/>
        </div>

        <div class="row">
            <div class="ribbon">{{trans('websitenew.community')}}</div>
        </div>
        <div class="clearfix"></div>
        <br/>
        <div class="row map b-dark">
            <div class="col-lg-6">
                <img src="web_content/infographic/img/graph.png" alt="graph" width="400" class="img-responsive m-center" style="margin-top: 80px"/>
            </div>
            <div class="col-lg-6" style="padding-top: 120px">

                <p class="fs20 grey-txt mont-norm"><i class="fa fa-square fs24" style="color:#E23A13"></i> {{trans('websitenew.spain')}}</p>
                <p class="fs20 grey-txt mont-norm"><i class="fa fa-square fs24" style="color:#0055bb"></i> {{trans('websitenew.vietnam')}}</p>
                <p class="fs20 grey-txt mont-norm"><i class="fa fa-square fs24" style="color:#eaf8b5"></i> {{trans('websitenew.indonesia')}}</p>
                <p class="fs20 grey-txt mont-norm"><i class="fa fa-square fs24" style="color:#d10d38"></i> {{trans('websitenew.russia')}}</p>
                <p class="fs20 grey-txt mont-norm"><i class="fa fa-square fs24" style="color:#8bc53e"></i> {{trans('websitenew.ukraine')}}</p>
                <p class="fs20 grey-txt mont-norm"><i class="fa fa-square fs24" style="color:#d2466c"></i> {{trans('websitenew.southafrica')}}</p>
                <p class="fs20 grey-txt mont-norm"><i class="fa fa-square fs24" style="color:#06c5f1"></i> {{trans('websitenew.philippines')}}</p>
                <p class="fs20 grey-txt mont-norm"><i class="fa fa-square fs24" style="color:#49d9d9"></i> {{trans('websitenew.india')}}</p>
                <p class="fs20 grey-txt mont-norm"><i class="fa fa-square fs24" style="color:#f5a403"></i> {{trans('websitenew.china')}}</p>
            </div>
        </div>
        <div class="clearfix"></div>
        <br/>

        <div class="row">
            <div class="ribbon">{{trans('websitenew.joinnow')}}</div>
        </div>
        <div class="row bg-dark b-dark">
            <div class="col-lg-12 ">
                <br/><br/>
                <p class="center-txt">
                    <span class="oren-txt fs80 robo-bold">www.bitregion.com</span>
                </p>
                <br/><br/>
                <p class="center-txt">
                    <span class="robo-bold grey-txt fs50">{{trans('websitenew.2gether')}}</span>
                </p>
                <br/><br/>
                <p class="center-txt">
                    <span class="oren-txt fs50 robo-bold">{{trans('websitenew.redefinedbank')}}</span>
                </p>
                <br/>
                <p class="center-txt fs20 grey-txt mont-norm"> {{trans('websitenew.broughtby')}}</p>
                <img src="web_content/infographic/img/logo.png" width="350" alt="logo" class="img-responsive m-center">
                <br/>
            </div>
        </div>


    </div>
</div>

</div>
@stop