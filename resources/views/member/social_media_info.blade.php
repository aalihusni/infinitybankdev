@extends('member.default')

@section('title'){{trans('member.social_media_info')}} @Stop

@section('menu_main') @Stop
@section('menu_setting')active @Stop

@section('content')

    <style>
        .socialicon {
            font-size:40px !important;
            margin-top:-10px;
        }
    </style>




    <!-- Page Content -->
    <div class="col-md-12">
        <div class="row">

            @if(Session::has('success'))
                <div class="alert alert-success">
                    <div>{{ Session::get('success') }}</div>
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Social Media Information</h2>
                        <p class="panel-subtitle">Let other people on your network communicate with you via social network</p>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(array('url'=>'members/social-media-info','method'=>'POST', 'class'=>'form-horizontal form-bordered')) !!}
                        <div class="panel-body">

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault"><span class="fa fa-qq socialicon"></span></label>
                                <div class="col-md-2">
                                    <label class="col-md-2 control-label">QQ</label>
                                </div>
                                <div class="col-md-5">
                                    {!! Form::text('sos_qq', empty(old('sos_qq')) ? Auth::user()->sos_qq : old('sos_qq'), array('class'=>'form-control' )) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault"><span class="fa fa-wechat socialicon"></span></label>
                                <div class="col-md-2">
                                    <label class="col-md-2 control-label">Wechat</label>
                                </div>
                                <div class="col-md-5">
                                    {!! Form::text('sos_wechat', empty(old('sos_wechat')) ? Auth::user()->sos_wechat : old('sos_wechat'), array('class'=>'form-control' )) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault"><img class="socialicon" src="{{asset('assets/images/viber.png')}}" width="50px"/></label>
                                <div class="col-md-2">
                                    <label class="col-md-2 control-label">Viber</label>
                                </div>
                                <div class="col-md-5">
                                    {!! Form::text('sos_viber', empty(old('sos_viber')) ? Auth::user()->sos_viber : old('sos_viber'), array('class'=>'form-control' )) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault"><span class="fa fa-whatsapp socialicon"></span></label>
                                <div class="col-md-2">
                                    <label class="col-md-2 control-label">Whatsapp</label>
                                </div>
                                <div class="col-md-5">
                                    {!! Form::text('sos_whatsapp', empty(old('sos_whatsapp')) ? Auth::user()->sos_whatsapp : old('sos_whatsapp'), array('class'=>'form-control' )) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault"><img class="socialicon" src="{{asset('assets/images/line.png')}}" width="50px"/></label>
                                <div class="col-md-2">
                                    <label class="col-md-2 control-label">Line</label>
                                </div>
                                <div class="col-md-5">
                                    {!! Form::text('sos_line', empty(old('sos_line')) ? Auth::user()->sos_line : old('sos_line'), array('class'=>'form-control' )) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault"><span class="fa fa-skype socialicon"></span></label>
                                <div class="col-md-2">
                                    <label class="col-md-2 control-label">Skype</label>
                                </div>
                                <div class="col-md-5">
                                    {!! Form::text('sos_skype', empty(old('sos_skype')) ? Auth::user()->sos_skype : old('sos_skype'), array('class'=>'form-control' )) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault"><img class="socialicon" src="{{asset('assets/images/bbm.png')}}" width="50px"/></label>
                                <div class="col-md-2">
                                    <label class="col-md-2 control-label">BBM</label>
                                </div>
                                <div class="col-md-5">
                                    {!! Form::text('sos_bbm', empty(old('sos_bbm')) ? Auth::user()->sos_bbm : old('sos_bbm'), array('class'=>'form-control' )) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-5 control-label" for="inputDefault"></label>
                                <div class="col-md-6">
                                    <label class="small"><input name="share" type="checkbox" value="1" @if(Auth::user()->sos_share > 0) checked @endif /> Share your social info with public</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-5 control-label" for="inputDefault"></label>
                                <div class="col-md-4">
                                    {!! Form::submit(trans('member.update_social'), array('class'=>'btn btn-primary btn-block')) !!}
                                </div>
                            </div>


                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="well">
                    <p><strong>{{trans('member.instruction')}}</strong></p>
                    <p>If you wish to display your social media information on your promotional page, check on the 'Share your sicial info with public' checkbox.</p>
                </div>
            </div>
        </div>
    </div>


    <!-- /#page-wrapper -->
@Stop