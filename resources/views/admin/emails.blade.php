@extends('admin.default')

@section('title'){{trans('member.emails')}} @Stop
@section('homeclass')nav-active @Stop

@section('content')

        <!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Admin Emails</h1>
            </div>
            <div class="panel-heading">
                Inbox
            </div>
            <div class="panel-body" >
                <table class="table table-striped table-bordered table-hover" id="dataTables-share">
                    <thead>
                    <tr>
                        <th>Date/Time</th>
                        <th>To</th>
                        <th>Subject</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($emails as $email)
                        @if ($email->status)
                            {{--*/ $strong_start = "" /*--}}
                            {{--*/ $strong_end = "" /*--}}
                        @else
                            {{--*/ $strong_start = "<strong>" /*--}}
                            {{--*/ $strong_end = "</strong>" /*--}}
                        @endif
                        <tr class="odd gradeX">
                            <td>{!! $strong_start !!}{{ $email->created_at }}{!! $strong_end !!}</td>
                            <td>{!! $strong_start !!}{{ $email->user_id }}{!! $strong_end !!}</td>
                            <td>{!! $strong_start !!}{{ $email->subject }}{!! $strong_end !!}</td>
                            <td>
                                <a href="{{ URL::route('admin-view-email') }}?id={{ $email->id }}" class="clearfix">X</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

@Stop