@extends('member.default')

@section('title'){{trans('member.home')}} @Stop
@section('homeclass')nav-active @Stop

@section('menu_main')active @Stop
@section('menu_setting') @Stop

@section('content')

        <!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-6">

                <div class="panel panel-default">
                    <div class="panel-body">

                        Assistant & Give Back Report


                    </div>
                </div>


            </div>

            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-body">

                        Community Bank Report


                    </div>
                </div>
            </div>




        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>

@Stop