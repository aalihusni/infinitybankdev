@extends('member.default')

@section('title'){{trans('member.change_password')}} @Stop

@section('menu_main') @Stop
@section('menu_setting')active @Stop

@section('content')


    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">

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


                    <div class="panel panel-default">
                        {!! Form::open(array('url'=>'members/change-password','method'=>'POST', 'class'=>'form-horizontal form-bordered')) !!}
                        <div class="panel-body">

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault">{{trans('front.password')}}</label>
                                <div class="col-md-6">
                                    <label class="control-label -align-left">**********</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault"></label>
                                <div class="col-md-6 text-muted small">
                                    <label>{{trans('member.if_you_wish_to_change_password')}}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault">{{trans('member.new_password')}}</label>
                                <div class="col-md-6">
                                    {!! Form::password('newpassword', array('class'=>'form-control' )) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault">{{trans('member.repeat_new_password')}}</label>
                                <div class="col-md-6">
                                    {!! Form::password('renewpassword', array('class'=>'form-control')) !!}
                                </div>
                            </div>

                            <br>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault">{{trans('member.current_password')}}</label>
                                <div class="col-md-6">
                                    {!! Form::password('password', array('class'=>'form-control' )) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault"></label>
                                <div class="col-md-4">
                                    {!! Form::submit(trans('member.update_password'), array('class'=>'btn btn-primary btn-block')) !!}
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