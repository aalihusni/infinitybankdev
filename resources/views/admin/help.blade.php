@extends('admin.default')

@section('title') Help @Stop
@section('homeclass')nav-active @Stop

@section('content')

        <!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">

        <br><br><br>

        <div class="col-md-12">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <div class="col-md-8">

                            <div class="form-horizontal form-bordered">

                                {!! Form::open(array('url'=>'admin/help','method'=>'POST', 'files'=>true)) !!}

                                <div class="form-group">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-5">
                                        {!! Form::file('file', '', array('class'=>'form-control')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-5">
                                        {!! Form::submit('Upload File', array('class'=>'btn btn-primary btn-block')) !!}
                                    </div>
                                </div>

                                {!! Form::close() !!}
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /#page-wrapper -->

@Stop