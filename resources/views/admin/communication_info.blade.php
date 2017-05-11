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

                        {!! Form::open(array('url'=>'members/test','method'=>'POST', 'files'=>true, 'class'=>'form-horizontal form-bordered')) !!}

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">{{trans('member.mobile_no')}}</label>
                            <div class="col-md-6">
                                {!! Form::text('country', old('country'), array('class'=>'form-control', 'value'=>Auth::user()->country_code )) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault"></label>
                            <div class="col-md-6">
                                <label><input name="rememberme" type="checkbox" value="1"> {{trans('member.show_this_number_public')}}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault"></label>
                            <div class="col-md-4">
                                {!! Form::submit(trans('member.save_update'), array('class'=>'btn btn-primary btn-block')) !!}
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
                    {!! Form::open(array('url'=>'members/test','method'=>'POST', 'class'=>'form-horizontal form-bordered')) !!}
                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">{{trans('front.email')}}</label>
                            <div class="col-md-6">
                                <label class="control-label -align-left">{{Auth::user()->email}}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault"></label>
                            <div class="col-md-6 text-muted small">
                                <label>{{trans('member.if_you_wish_to_change_email')}}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">{{trans('member.new_email')}}</label>
                            <div class="col-md-6">
                                {!! Form::text('firstname', old('firstname'), array('class'=>'form-control','value'=> Auth::user()->firstname )) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">{{trans('member_new')}}</label>
                            <div class="col-md-6">
                                {!! Form::text('lastname', old('lastname'), array('class'=>'form-control', 'value'=>Auth::user()->lastname)) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault"></label>
                            <div class="col-md-4">
                                {!! Form::submit(trans('member_new'), array('class'=>'btn btn-primary btn-block')) !!}
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