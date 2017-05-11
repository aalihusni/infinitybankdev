@extends('admin.default')

@section('title')Image Gallery @Stop

@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Image Gallery</h1>

                <div class="panel panel-default">
                    <div class="panel-body">

                        <form action="{{ URL::route('create-gallery') }}" class="form-horizontal form-bordered" method="POST">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">Album Title</label>
                                <div class="col-md-9">
                                    <input type="text" name="title" class="form-control"
                                           id="inputDefault" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">Country</label>
                                <div class="col-md-9">
                                    <div id="basic" data-input-name="country" data-selected-country="{{empty(old('country')) ? Auth::user()->country_code : old('country')}}"></div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">Description</label>
                                <div class="col-md-9">
                                                            <textarea name="description" rows="5" cols="50"
                                                                      class="form-control" required></textarea>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-2 control-label" for="inputDefault"></label>
                                <div class="col-md-9">
                                    <input class="btn btn-primary hidden-xs" type="submit"
                                           value="Create New Album">
                                    <input class="btn btn-primary btn-block btn-lg visible-xs mt-lg"
                                           type="submit" value="Create New Album">

                                </div>
                            </div>


                        </form>

                        </div>
                    </div>

                <style>
                    img.square {
                        height: 100px;
                        width: 100px;
                        margin-right:10px;
                        object-fit: cover;
                    }
                </style>
                <div class="col-md-12">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="panel-group" id="accordion">


                                @foreach($albums as $album)
                                <div class="well">
                                    <a href="#deleteModal" data-toggle="modal" data-target="#deleteModal" data-id="{{$album->id}}" class="modal-delete pull-right btn btn-xs btn-danger text-danger"><span class="fa fa-close"></span></a>
                                    <img class="square img-thumbnail" align="left" src="../gallery/{{$album->images}}"/>
                                    <h4><a href="{{URL::route('edit-album', ['id' => $album->id])}}">{{$album->title}}</a></h4>
                                    <p>{{$album->description}}</p>
                                    <p>COUNTRY: {{$album->country}}</p>
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
                                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
                            </div>
                            <div class="modal-body">
                                Are you sure to delete this? All pictures in this album will be deleted. This action can't be undone.
                            </div>
                            <div class="modal-footer">
                                <form action="{{ URL::route('delete-album') }}" class="form-horizontal form-bordered" method="POST">
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