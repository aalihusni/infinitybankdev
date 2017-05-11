@extends('member.default')

@section('title'){{trans('member.personal_info')}} @Stop
@section('homeclass')nav-active @Stop

@section('content')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                <h1 class="page-header">{{trans('member_new')}}</h1>

                @if (isset($message))
                    <div class="alert alert-success">
                        <ul>
                            <li>{{ $message }}</li>
                        </ul>
                    </div>
                @endif

                <div class="panel panel-default">
                    <div class="panel-body">

                        {!! Form::open(array('url'=>'members/upload-profile-pic','method'=>'POST', 'files'=>true, 'class'=>'form-horizontal form-bordered')) !!}

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault"><img class="img-rounded" src="@if(Auth::user()->profile_pic){{S3Files::url('profiles/'.Auth::user()->profile_pic)}} @else {{asset('profiles/no_img.jpg')}} @endif"/></label>
                            <div class="col-md-4">
                                <label class="control-label">{{trans('member.profile_picture')}}</label><br><br>
                                {!! Form::file('image', '', array('class'=>'form-control','placeholder'=>trans('front.lastname'))) !!}<br>
                                @if(Auth::user()->profile_pic)
                                    {!! Form::submit(trans('member.replace_photo'), array('class'=>'btn btn-primary btn-block')) !!}
                                @else
                                    {!! Form::submit(trans('member.upload_photo'), array('class'=>'btn btn-primary btn-block')) !!}
                                @endif
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="panel panel-default">
                    {!! Form::open(array('url'=>'members/personal-info','method'=>'POST', 'class'=>'form-horizontal form-bordered')) !!}
                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">{{trans('member.firstname')}}</label>
                            <div class="col-md-6">
                                {!! Form::text('firstname', old('firstname'), array('class'=>'form-control','value'=> Auth::user()->firstname )) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">{{trans('member.lastname')}}</label>
                            <div class="col-md-6">
                                {!! Form::text('lastname', old('lastname'), array('class'=>'form-control', 'value'=>Auth::user()->lastname)) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">{{trans('member.gender')}}</label>
                            <div class="col-md-6">
                                <label class="control-label">{!! Form::radio('gender', 'male', (Input::old('gender') == 'male')) !!} {{trans('member.male')}}</label> &nbsp;&nbsp;
                                <label class="control-label">{!! Form::radio('gender', 'female', (Input::old('gender') == 'female')) !!} {{trans('member.female')}}</label>
                            </div>
                        </div>

                    </div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">{{trans('member.address')}}</label>
                            <div class="col-md-6">
                                {!! Form::text('address', old('address'), array('class'=>'form-control' )) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">{{trans('member.city')}}</label>
                            <div class="col-md-6">
                                {!! Form::text('city', old('city'), array('class'=>'form-control', 'value'=>Auth::user()->city)) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">{{trans('member.zipcode')}}</label>
                            <div class="col-md-3">
                                {!! Form::text('zipcode', old('zipcode'), array('class'=>'form-control', 'value'=>Auth::user()->zipcode)) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">{{trans('member.state')}}</label>
                            <div class="col-md-6">
                                {!! Form::text('state', old('state'), array('class'=>'form-control', 'value'=>Auth::user()->state )) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">{{trans('member.country')}}</label>
                            <div class="col-md-6">
                                {!! Form::text('country', old('country'), array('class'=>'form-control', 'value'=>Auth::user()->country_code )) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault"></label>
                            <div class="col-md-4">
                                {!! Form::submit(trans('member.save_update'), array('class'=>'btn btn-primary btn-block')) !!}
                            </div>
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
</div>

@Stop