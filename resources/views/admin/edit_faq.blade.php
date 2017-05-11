@extends('admin.default')

@section('title')Edit FAQ @Stop

@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Edit FAQ</h1>

                <div class="panel panel-default">
                    <div class="panel-body">

                        <form action="{{ URL::route('edit-faq') }}" class="form-horizontal form-bordered" method="POST">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="id" value="{{$faq->id}}">

                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">Question</label>
                                <div class="col-md-9">
                                    <input type="text" name="question" class="form-control"
                                           id="inputDefault" value="{{$faq->question}}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">Order</label>
                                <div class="col-md-9">
                                    <input type="text" name="order" class="form-control"
                                           value="{{$faq->order}}" required style="width:100px;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">Languange</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="lang">
                                        <option value="my" @if($faq->lang == 'my') selected @endif>B. Melayu</option>
                                        <option value="en" @if($faq->lang == 'en') selected @endif>English</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">Answer</label>
                                <div class="col-md-9">
                                                            <textarea name="answer" rows="10" cols="50"
                                                                      class="form-control" required>{{$faq->answer}}</textarea>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-2 control-label" for="inputDefault"></label>
                                <div class="col-md-9">
                                    <a href="{{URL::route('manage-faq')}}" class="btn btn-default">Back to Manage FAQ</a>
                                    <input class="btn btn-primary hidden-xs" type="submit"
                                           value="Update FAQ">
                                    <input class="btn btn-primary btn-block btn-lg visible-xs mt-lg"
                                           type="submit" value="Update FAQ">

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