@extends('admin.default')

@section('title'){{trans('member.home')}} @Stop
@section('homeclass')nav-active @Stop

@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Admin Home</h1>
                @if(isset($lists))
                @foreach($lists as $l)
                
                {{$l}} <br>
                
                @endforeach
                @endif
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

@Stop