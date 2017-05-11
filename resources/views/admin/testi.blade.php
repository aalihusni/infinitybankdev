@extends('admin.default')

@section('title')Testimonial Approval(s) @Stop

@section('content')
    <style>
        img.square {
            height: 50px;
            width: 50px;
            object-fit: cover;
            margin-right:10px;
        }
    </style>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Testimonials</h1>


                <div class="col-md-12">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="panel-group" id="accordion">


                                    <table class="table table-striped table-bordered table-hover" id="dataTables-share">
                                        <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Video</th>
                                            <th valign="middle">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($objectData as $object)
                                        <tr>
                                            <td>
                                                <img align="left" class="square" src="{{S3Files::url('profiles/'.$object->user_img)}}"/>
                                                <strong>Full Name: </strong>{{$object->user_name}}<br>
                                                <strong>alias: </strong>{{$object->user_alias}}
                                            </td>
                                            <td>
                                                <strong>Website:</strong> {{$object->website}}<br>
                                                <strong>URL:</strong> <a href="{{$object->url}}" target="_blank">{{$object->url}}</a>
                                            </td>
                                            <td id="action_area_{{$object->id}}" valign="middle">

                                                    @if($object->status < 2)
                                                    <button class="btn btn-sm btn-success btn-block approve_button" data-id="{{$object->id}}">Approve</button>
                                                    <a href="#rejectVID" data-id="{{ $object->id }}" data-toggle="modal" class="btn btn-block btn-sm btn-danger modal-rejectvid">Reject</a>
                                                    @else
                                                    <div class="text-success text-center"><span class="fa fa-check"></span> Approved<br>
                                                        <small>{{ $object->updated_at }}</small></div>

                                                    @endif
                                            </td>
                                        </tr>
                                        @endforeach

                                        </tbody>
                                        </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="rejectVID" tabindex="3" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="form-horizontal form-bordered">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">Reject Testimonial</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="modal-body">
                                        Reason for rejection:<br>
                                        <select id="VIDrejectselect" class="form-control">
                                            <option selected value="Not a valid testimonial video.">Not a valid testimonial video.</option>
                                            <option value="Does not fullfill testimonial requirement.">Does not fullfill testimonial requirement.</option>
                                            <option value="custom">Custom</option>
                                        </select>
                                    </div>
                                    <div class="modal-body">
                                        <textarea disabled id="customrejectVID" class="form-control" rows="5"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <input id="rejectVIDv" type="hidden" name="id" value="">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <button id="confirmRejectVID" type="submit" class="btn btn-danger" data-dismiss="modal">Reject</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div></div>


            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<script type="text/javascript">
    $(".approve_button").click(function(){
        var dataval = $(this).attr('data-id');
        $('#action_area_'+dataval).html('<div class="text-success text-center">processing...</div>');
        $.ajax({
            method: "POST",
            url: "{{URL::route('approve-testi')}}",
            data: { id: dataval, _token: '<?php echo csrf_token(); ?>' }
        })
        .done(function(msg) {
            if(msg == 1)
                $('#action_area_'+dataval).html('<div class="text-success text-center"><span class="fa fa-check"></span> Approved</div>');
        });
    });

    $(".modal-rejectvid").click(function(){
        var dataval = $(this).attr('data-id');
        $('#rejectVIDv').val(dataval);
    });

    $('#VIDrejectselect').change(function(){
        var idreason = $(this).val();
        if(idreason == 'custom')
        {
            $('#customrejectVID').attr('disabled',false);
        }
        else
        {
            $('#customrejectVID').val('');
            $('#customrejectVID').attr('disabled','true');
        }
    });

    $('#confirmRejectVID').click(function(){
        var rid = $('#rejectVIDv').val();
        $('#action_area_'+rid).html('<div class="text-success text-center">processing...</div>');
        if($('#VIDrejectselect').val() == 'custom')
        {
            var idreason = $('#customrejectVID').val();
        }
        else
        {
            var idreason = $('#VIDrejectselect').val();
        }
        $.ajax({
            method: "POST",
            url: "{{URL::route('reject-testi')}}",
            data: { id: rid, reason:idreason, _token: '<?php echo csrf_token(); ?>' }
        })
        .done(function(msg) {
            if(msg == 1)
                $('#action_area_'+rid).html('<div class="text-danger text-center"><span class="fa fa-close"></span> Rejected</div>');
        });
    });

    CKEDITOR.replace( 'answer' );
</script>
@Stop