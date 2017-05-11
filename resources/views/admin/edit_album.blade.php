@extends('admin.default')

@section('title')Edit Album @Stop

@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Album </h1>

                <p><a href="{{URL::Route('image-gallery')}}">< Back to Gallery</a></p>

                <div class="panel panel-default">
                    <div class="panel-body">

                        <form action="{{ URL::route('save-gallery') }}" class="form-horizontal form-bordered" method="POST">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="album_id" value="{{$album->id}}">
                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">Album Title</label>
                                <div class="col-md-9">
                                    <input type="text" name="title" class="form-control" value="{{$album->title}}"
                                           id="inputDefault" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">Country</label>
                                <div class="col-md-9">
                                    <div id="basic" data-input-name="country" data-selected-country="{{$album->country}}"></div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">Description</label>
                                <div class="col-md-9">
                                                            <textarea name="description" rows="5" cols="50"
                                                                      class="form-control" required>{{$album->description}}</textarea>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-2 control-label" for="inputDefault"></label>
                                <div class="col-md-9">
                                    <input class="btn btn-primary hidden-xs" type="submit"
                                           value="Update Album Info">
                                    <input class="btn btn-primary btn-block btn-lg visible-xs mt-lg"
                                           type="submit" value="Update Album Info">

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

                                    <div class="well">
                                    {!! Form::open(array('url'=>'admin/upload-images','method'=>'POST', 'files'=>true)) !!}
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="album_id" value="{{$album->id}}">
                                    <div class="control-group">
                                        <div class="controls">
                                            {!! Form::file('images[]', array('multiple'=>true)) !!}
                                            <p class="errors">{!!$errors->first('images')!!}</p>
                                            @if(Session::has('error'))
                                                <p class="errors">{!! Session::get('error') !!}</p>
                                            @endif
                                        </div>
                                    </div>
                                    {!! Form::submit('Upload All', array('class'=>'send-btn')) !!}
                                    {!! Form::close() !!}
                                    </div>

                                    <div>
                                        @foreach($images as $image)
                                            <div class="col-lg-2 col-sm-3 col-xs-6"
                                                 style="border:5px solid #FFF;
                                                         height:150px; background-image:url('../gallery/{{$image->image_file}}'); background-size:cover; background-position:center center; ">
                                                <a href="#deleteModal" data-toggle="modal" data-target="#deleteModal" data-id="{{$image->id}}" class="modal-delete pull-right btn-danger"><span class="fa fa-close"></span></a> &nbsp;
                                                @if($album->images == $image->image_file)
                                                <a href="#" class="modal-delete pull-right btn-warning">
                                                    <span class="fa fa-star"></span>
                                                </a>
                                                @else
                                                <a href="{{URL::route('set-default-image',['album_id'=>$album->id,'imagename'=>$image->image_file])}}" class="modal-delete pull-right">
                                                    <span class="fa fa-star"></span>
                                                </a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>


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
                                <form action="{{ URL::route('delete-image') }}" class="form-horizontal form-bordered" method="POST">
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

    $('#basic').flagStrap({
        buttonSize: "btn-md btn-block",
        labelMargin: "10px",
        scrollable: true,
        scrollableHeight: "300px"
    });

    CKEDITOR.replace( 'answer' );
</script>
@Stop