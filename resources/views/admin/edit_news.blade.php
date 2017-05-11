@extends('admin.default')

@section('title')Edit News @Stop

@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Edit News</h1>

                <div class="panel panel-default">
                    <div class="panel-body">

                        <form action="{{ URL::route('edit-news') }}" class="form-horizontal form-bordered" method="POST">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="id" value="{{$news->id}}">

                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">Title</label>
                                <div class="col-md-9">
                                    <input type="text" name="title" class="form-control"
                                           id="inputDefault" value="{{$news->title}}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">Languange</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="lang">
                                        <option value="my" @if($news->lang == 'my') selected @endif>B. Melayu</option>
                                        <option value="en" @if($news->lang == 'en') selected @endif>English</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">Answer</label>
                                <div class="col-md-9">
                                                            <textarea name="news" rows="10" cols="50"
                                                                      class="form-control" required>{{$news->news}}</textarea>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-2 control-label" for="inputDefault"></label>
                                <div class="col-md-9">
                                    <a href="{{URL::route('manage-news')}}" class="btn btn-default">Back to Manage News</a>
                                    <input class="btn btn-primary hidden-xs" type="submit"
                                           value="Update News">
                                    <input class="btn btn-primary btn-block btn-lg visible-xs mt-lg"
                                           type="submit" value="Update News">

                                </div>
                            </div>


                        </form>

                        </div>
                    </div>


            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@Stop