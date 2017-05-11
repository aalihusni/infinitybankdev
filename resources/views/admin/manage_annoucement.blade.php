@extends('admin.default')

@section('title')Manage FAQ @Stop

@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Manage News</h1>

                <div class="panel panel-default">
                    <div class="panel-body">

                        <form action="{{ URL::route('add-faq') }}" class="form-horizontal form-bordered" method="POST">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">Question</label>
                                <div class="col-md-9">
                                    <input type="text" name="question" class="form-control"
                                           id="inputDefault" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">Order</label>
                                <div class="col-md-9">
                                    <input type="text" name="order" class="form-control"
                                           value="@if($last != 'none') {{$last->id+1}} @else 1 @endif" required style="width:100px;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">Languange</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="lang">
                                        <option value="my">B. Melayu</option>
                                        <option value="en" selected>English</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">Answer</label>
                                <div class="col-md-9">
                                                            <textarea name="answer" rows="5" cols="50"
                                                                      class="form-control" required></textarea>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-2 control-label" for="inputDefault"></label>
                                <div class="col-md-9">
                                    <input class="btn btn-primary hidden-xs" type="submit"
                                           value="Insert New FAQ">
                                    <input class="btn btn-primary btn-block btn-lg visible-xs mt-lg"
                                           type="submit" value="Insert New FAQ">

                                </div>
                            </div>


                        </form>

                        </div>
                    </div>


                <div class="col-md-12">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="panel-group" id="accordion">


                                    @foreach($faqs as $faq)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$faq->id}}">{{$faq->question}}</a>
                                            </h4>
                                        </div>
                                        <div id="collapse{{$faq->id}}" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div style="border-bottom:thin solid #CCC; padding-bottom:20px;">{!!nl2br($faq->answer)!!}</div>
                                                <div class="pull-right" style="margin-top:10px;">
                                                    ORDER: {{$faq->order}} | Lang: {{$faq->lang}} |
                                                    <a href="{{ URL::route('edit-faq', ['id' => $faq->id]) }}"
                                                       class="data-modal on-default edit-row"><span class="fa fa-pencil"></span> edit</a> |
                                                    <a href="#deleteModal" data-toggle="modal" data-target="#deleteModal" data-id="{{$faq->id}}"
                                                       class="modal-delete on-default edit-row"><span class="fa fa-trash"></span> delete </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                            </div>
                            <div class="modal-body">
                                Are you sure to delete this? This action can't be undone.
                            </div>
                            <div class="modal-footer">
                                <form action="{{ URL::route('delete-faq') }}" class="form-horizontal form-bordered" method="POST">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <input id="modalid" type="hidden" name="id" value="">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Yes, Confirm!</button>
                                </form>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>


            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<script type="text/javascript">
    $(".modal-delete").click(function(){
        var dataval = $(this).attr('data-id');
        $('#modalid').val(dataval);
    });

    CKEDITOR.replace( 'answer' );
</script>
@Stop