@extends('member.default')

@section('title'){{trans('member.communication_info')}} @Stop

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
                        <div class="panel-body">

                            {!! Form::open(array('url'=>'members/update-mobile','method'=>'POST', 'files'=>true, 'class'=>'form-horizontal form-bordered')) !!}

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault">{{trans('member.mobile_no')}}</label>
                                <div class="col-md-6">
                                    {!! Form::text('mobile', empty(old('mobile')) ? Auth::user()->mobile : old('mobile'), array('class'=>'form-control', 'placeholder'=>'+'.$dc )) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault"></label>
                                <div class="col-md-6">
                                    <label class="small"><input name="share" type="checkbox" value="1" @if(Auth::user()->mobile_share > 0) checked @endif /> {{trans('member.show_this_number_public')}}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault"></label>
                                <div class="col-md-4">
                                    {!! Form::submit(trans('member.update_mobile_no'), array('class'=>'btn btn-primary btn-block')) !!}
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>


                    <div class="panel panel-default">
                        {!! Form::open(array('url'=>'members/update-email','method'=>'POST', 'class'=>'form-horizontal form-bordered')) !!}
                        <div class="panel-body">

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault">{{trans('member.email')}}</label>
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
                                    {!! Form::text('email', old('email'), array('class'=>'form-control' )) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault">{{trans('member.repeat_new_email')}}</label>
                                <div class="col-md-6">
                                    {!! Form::text('renewemail', old('renewemail'), array('class'=>'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault"></label>
                                <div class="col-md-4">
                                    {!! Form::submit(trans('member.update_email'), array('class'=>'btn btn-primary btn-block')) !!}
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