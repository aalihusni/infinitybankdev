@extends('member.default')

@section('title'){{trans('member.account_verification')}} @Stop

@section('menu_main') @Stop
@section('menu_setting')active @Stop

@section('content')

        <!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">

        <div class="col-md-12">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <div class="col-md-8">

                            <div class="form-horizontal form-bordered">

                                <div class="form-group col-md-12">
                                    <br>{{trans('member.account_verification_info')}}<br><br>
                                </div>
                                {!! Form::open(array('url'=>'members/upload-veriid-type','method'=>'POST', 'files'=>true)) !!}

                                <div class="form-group">
                                    <label class="col-md-3 control-label">1. ID Type:</label>
                                    <div class="col-md-8">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="id_type" value="1" @if(Auth::user()->id_verify_type <= 1) checked @endif>
                                                National ID Card
                                            </label>
                                            <br>
                                            <label>
                                                <input type="radio" name="id_type" value="2" @if(Auth::user()->id_verify_type == 2) checked @endif>
                                                Driving License
                                            </label>
                                            <br>
                                            <label>
                                                <input type="radio" name="id_type" value="3" @if(Auth::user()->id_verify_type == 3) checked @endif>
                                                Passport
                                            </label>
                                            <br>
                                            <label>
                                                <input type="radio" name="id_type" value="4" @if(Auth::user()->id_verify_type == 4) checked @endif>
                                                Company Registration
                                            </label>
                                        </div>
                                        <br>
                                        {!! Form::text('id_no',Auth::user()->id_verify_no , array('class'=>'form-control','placeholder'=>'ID Number')) !!}

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-5">
                                        {!! Form::submit('Update ID Type', array('class'=>'btn btn-primary btn-block')) !!}
                                    </div>
                                </div>
                                {!! Form::close() !!}

                                <hr>

                                @if(Auth::user()->id_verify_status == 2)
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">{{trans('member.personal_id')}}</label>
                                        <div class="col-md-8">
                                            <h4 class="text-success"><span class="fa fa-check"></span> {{trans('member.personal_id_approved')}}</h4>
                                        </div>
                                    </div>
                                @elseif(Auth::user()->id_verify_status == 1)
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">{{trans('member.personal_id')}}</label>
                                        <div class="col-md-8">
                                            <h4><span class="fa fa-history"></span> {{trans('member.review_in_progress')}}</h4>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">{{trans('member.personal_id')}}</label>
                                        <div class="col-md-5">
                                            <label style="font-weight:normal; padding-top:10px; margin-bottom:20px;">
                                                <em>{{trans('member.type_personal_id')}}</em>
                                            </label>
                                        </div>
                                    </div>
                                    {!! Form::open(array('url'=>'members/upload-veriid','method'=>'POST', 'files'=>true)) !!}

                                    <div class="form-group">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-5">
                                            {!! Form::file('image', '', array('class'=>'form-control','placeholder'=>trans('front.lastname'))) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-5">
                                            @if(Auth::user()->id_verify_type < 1 || empty(Auth::user()->id_verify_no))
                                                {!! Form::submit(trans('member.upload_photo'), array('class'=>'btn btn-primary btn-block','disabled'=>'disabled')) !!}
                                            @else
                                                {!! Form::submit(trans('member.upload_photo'), array('class'=>'btn btn-primary btn-block')) !!}
                                            @endif
                                        </div>
                                    </div>

                                    {!! Form::close() !!}
                                @endif
                            </div>



                            <div class="form-group col-md-12">
                                <hr>
                            </div>

                            <div class="form-horizontal form-bordered">


                                @if(Auth::user()->selfie_verify_status == 2)
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">{{trans('member.selfie_br')}}</label>
                                        <div class="col-md-8">
                                            <h4 class="text-success"><span class="fa fa-check"></span> {{trans('member.personal_id_approved')}}</h4>
                                        </div>
                                    </div>
                                @elseif(Auth::user()->selfie_verify_status == 1)
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">{{trans('member.selfie_br')}}</label>
                                        <div class="col-md-8">
                                            <h4><span class="fa fa-history"></span> {{trans('member.review_in_progress')}}</h4>
                                        </div>
                                    </div>
                                @else

                                    {!! Form::open(array('url'=>'members/upload-veriselfie','method'=>'POST', 'files'=>true)) !!}

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">{{trans('member.selfie_br')}}</label>
                                        <div class="col-md-5">
                                            <label style="font-weight:normal; padding-top:10px; margin-bottom:20px;">
                                                <em>{{trans('member.type_selfie_br')}}</em>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-5">
                                            {!! Form::file('image', '', array('class'=>'form-control','placeholder'=>trans('front.lastname'))) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-5">
                                            {!! Form::submit(trans('member.upload_photo'), array('class'=>'btn btn-primary btn-block')) !!}
                                        </div>
                                    </div>

                                    {!! Form::close() !!}

                                @endif

                            </div>

                            <br><br><br>


                        </div>

                        <div class="col-md-4 well">
                            <p><strong>{{trans('member.instruction')}}</strong></p>
                            <p>{{trans('member.instruction_1')}}</p>
                            <p>{{trans('member.instruction_2')}}</p>
                            <p>{{trans('member.instruction_3')}}</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /#page-wrapper -->

@Stop