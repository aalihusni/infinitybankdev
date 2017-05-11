@extends('member.default')

@section('title'){{trans('member.home')}} @Stop
@section('homeclass')nav-active @Stop

@section('content')

        <!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{trans('member.upgrade')}}</h1>
                {!! Form::open(array('url'=>'signup','method'=>'POST')) !!}
                <fieldset>
                    <div class="form-group">
                        {!! Form::email('email', '', array('class'=>'form-control','placeholder'=>trans('front.email'))) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::password('password', array('class'=>'form-control','placeholder'=>trans('front.password'))) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::password('repassword', array('class'=>'form-control','placeholder'=>trans('front.confirm_password'))) !!}
                    </div>
                    <!-- Change this to a button or input when using this as a form -->
                    {!! Form::submit(trans('front.sign_up'), array('class'=>'btn btn-success btn-quirk btn-block')) !!}
                    <br>
                    <a href="{{URL::route('login')}}" class="btn btn-default btn-block">{{trans('front.already_a_member')}} {{trans('front.login_now')}}</a>
                </fieldset>
                {!! Form::close() !!}
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

@Stop