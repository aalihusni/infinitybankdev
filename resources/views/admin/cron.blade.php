@extends('admin.default')

@section('title')Cron @Stop
@section('homeclass')nav-active @Stop

@section('content')

        <!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Cron Log</h1>
                <div class="alert alert-info">
                    Last cron run is {{ \App\Classes\AdminClass::checkLastCron() }} hours ago.
                </div>
                <div class="alert alert-info">
                    Last full cron run is {{ \App\Classes\AdminClass::checkLastFullCron() }} hours ago.
                </div>
                <strong>{{ Carbon\Carbon::now() }} # Current Server Time</strong>
                @if(isset($cron_log))
                <table border="0">
                    @foreach($cron_log as $log)
                        <tr>
                            <td>{{$log->type}}</td>
                            <td>&nbsp;</td>
                            <td>{{$log->created_at}}</td>
                            <td>&nbsp;</td>
                            <td>{{$log->description}}</td>
                        </tr>
                    @endforeach
                </table>
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