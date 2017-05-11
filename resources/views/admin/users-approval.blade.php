@extends('admin.default')

@section('title'){{trans('member.emails')}} @Stop
@section('homeclass')nav-active @Stop

@section('content')
        <style>
            .thumbnail {
                position: relative;
                width: 250px;
                height: 250px;
                overflow: hidden;
                text-align:center;
                margin-right:auto;
                margin-left:auto;
            }
            .thumbnail img {
                position: absolute;
                left: 50%;
                top: 50%;
                height: 100%;
                width: auto;
                -webkit-transform: translate(-50%,-50%);
                -ms-transform: translate(-50%,-50%);
                transform: translate(-50%,-50%);
            }
            .thumbnail img.portrait {
                width: 100%;
                height: auto;
            }
        </style>

        <!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            @if ($user_type == "pool")
                {{--*/ $type_name = "Pool" /*--}}
            @elseif ($user_type == "member")
                {{--*/ $type_name = "Member" /*--}}
            @else
                {{--*/ $type_name = "Non-Member" /*--}}
            @endif
            <div class="col-lg-12">
                <h1 class="page-header">User Verification</h1>
            </div>
            <div class="panel-heading">
                {{ $user_count }} User(s) need Approvals
            </div>


                @if(Session::has('success'))
                    <div class="alert alert-success">
                        <div>{{ Session::get('success') }}</div>
                    </div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover" id="dataTables-share">
                    <thead>
                    <tr>
                        <th class="hidden-xs">ID</th>
                        <th>User Details</th>
                        <th class="hidden-xs">ID Vefify</th>
                        <th class="hidden-xs">Photo Verify</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr class="odd gradeX">
                            <td class="hidden-xs">{{ $user->id }}</td>
                            <td class="hidden-xs">
                                <strong>Alias :</strong> {{ $user->alias }}<br>
                                <strong>First Name :</strong> {{ $user->firstname }}<br>
                                <strong>Last Name :</strong> {{ $user->lastname }}<br>
                                <strong>Email :</strong> {{ $user->email }}<br>
                                <strong>Mobile :</strong> {{ $user->mobile }}<br>
                                <strong>Country Code :</strong> {{ $user->country_code }}<br>
                                <strong>Registered Date :</strong> {{ $user->created_at }}<br>
                                <hr>
                                @if($user->id_verify_type == '1')
                                    <strong>ID Type :</strong> National ID Card<br>
                                @elseif($user->id_verify_type == '2')
                                    <strong>ID Type :</strong> Driving License<br>
                                @elseif($user->id_verify_type == '3')
                                    <strong>ID Type :</strong> Passport<br>
                                @elseif($user->id_verify_type == '4')
                                    <strong>ID Type :</strong> Company Registration<br>
                                @else
                                    <strong>ID Type :</strong> Unknown<br>
                                @endif
                                    <strong>No :</strong> {{ $user->id_verify_no }}

                                @if(App\User::checkidduplicate($user->id_verify_no) > '0')
                                    ( {{App\User::checkidduplicate($user->id_verify_no)}} duplicated )
                                @endif
                                <br>
                                <hr>
                                <button id="approve_both_{{ $user->id }}" data-id="{{ $user->id }}" class="approveboth btn-lg btn btn-block btn-primary">APPROVE BOTH</button>
                            </td>
                            <td class="hidden-xs">
                                <div class="thumbnail">
                                    <img class="portrait" width="100%" src="{{S3Files::url('private/id_verify/'.$user->id_verify_file)}}" target="_blank"/>
                                </div>
                                <div id="id_verify_{{ $user->id }}" style="margin-top:-70px; position:relative; z-index:100; text-align:center; padding-bottom:30px;">
                                    @if($user->id_verify_status == 1)
                                    <button data-id="{{ $user->id }}" class="approveid btn btn-primary">APPROVE</button>
                                    <a href="{{S3Files::url('private/id_verify/'.$user->id_verify_file)}}" class="btn btn-default image-popup-vertical-fit" class="simple-ajax-modal"><span class="fa fa-search"></span></a>
                                    <a href="#rejectID" data-id="{{ $user->id }}" data-toggle="modal" class="btn btn-danger modal-rejectid">REJECT</a>
                                    @elseif($user->id_verify_status == 0 && $user->id_verify_file != '')
                                    <button href="#" class="btn btn-danger" disabled>REJECTED</button>
                                    @elseif($user->id_verify_status == 2)
                                    <button href="#" class="btn btn-success" disabled><span class="fa fa-check"></span> APPROVED</button>
                                    @else
                                    <button href="#" class="btn btn-default" disabled>No Document Uploaded</button>
                                    @endif
                                </div>
                            </td>
                            <td class="visible-xs">
                                MOBILE VIEW TEMPORARILY DISABLED
                            </td>
                            <td class="hidden-xs">
                                <div class="thumbnail"><img class="portrait" width="100%" src="{{S3Files::url('private/photo_verify/'.$user->selfie_verify_file)}}" target="_blank"/></div>
                                <div id="selfie_verify_{{ $user->id }}" style="margin-top:-70px; position:relative; z-index:100; text-align:center;">
                                    @if($user->selfie_verify_status == 1)
                                    <button data-id="{{ $user->id }}" class="approveselfie btn btn-primary">APPROVE</button>
                                    <a href="{{S3Files::url('private/photo_verify/'.$user->selfie_verify_file)}}" class="btn btn-default image-popup-vertical-fit"><span class="fa fa-search"></span></a>
                                    <a href="#rejectSELFIE" data-id="{{ $user->id }}" data-toggle="modal" class="btn btn-danger modal-rejectselfie">REJECT</a>
                                    @elseif($user->selfie_verify_status == 0 && $user->selfie_verify_file != '')
                                    <button href="#" class="btn btn-danger" disabled>REJECTED</button>
                                    @elseif($user->selfie_verify_status == 2)
                                    <button href="#" class="btn btn-success" disabled>APPROVED</button>
                                    @else
                                    <button href="#" class="btn btn-default" disabled>No Document Uploaded</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $users->render() !!}
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>


<div class="modal fade" id="rejectID" tabindex="3" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="form-horizontal form-bordered">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Reject ID Verification</h4>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        Reason for rejection:<br>
                        <select id="IDrejectselect" class="form-control">
                            <option selected value="This is not a valid ID.">This is not a valid ID.</option>
                            <option value="The image is not clear.">The image is not clear.</option>
                            <option value="custom">Custom</option>
                        </select>
                    </div>
                    <div class="modal-body">
                        <textarea disabled id="customrejectid" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input id="rejectID" type="hidden" name="id" value="">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button id="confirmRejectID" type="submit" class="btn btn-danger" data-dismiss="modal">Reject</button>
                    </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div></div>

<div class="modal fade" id="rejectSELFIE" tabindex="3" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="form-horizontal form-bordered">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Reject SELFIE Verification</h4>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        Reason for rejection:<br>
                        <select id="SELFIErejectselect" class="form-control">
                            <option selected value="This is not a valid ID.">No BitRegion text visible in the picture.</option>
                            <option value="The image is not clear.">The image is not clear.</option>
                            <option value="custom">Custom</option>
                        </select>
                    </div>
                    <div class="modal-body">
                        <textarea disabled id="customrejectselfie" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input id="rejectSELFIE" type="hidden" name="id" value="">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button id="confirmRejectSELFIE" type="submit" class="btn btn-danger" data-dismiss="modal">Reject</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div></div>

        <script>
            $('.approveid').click(function(){
                var id = $(this).attr('data-id');
                $('#id_verify_'+id).html('<button href="#" class="btn btn-default" disabled>approving...</button>');
                $.ajax({
                    method: "POST",
                    url: "{{URL::route('approve-id')}}",
                    data: { id: id, verify: "id", _token: '<?php echo csrf_token(); ?>' }
                })
                .done(function(msg) {
                    if(msg == 1)
                        $('#id_verify_'+id).html('<button href="#" class="btn btn-success" disabled><span class="fa fa-check"></span> APPROVED</button>');
                        $('#approve_both_'+id).attr('disabled','true');
                });
            })
            $('.approveselfie').click(function(){
                var id = $(this).attr('data-id');
                $('#selfie_verify_'+id).html('<button href="#" class="btn btn-default" disabled>approving...</button>');
                $.ajax({
                    method: "POST",
                    url: "{{URL::route('approve-id')}}",
                    data: { id: id, verify: "selfie", _token: '<?php echo csrf_token(); ?>' }
                })
                .done(function(msg) {
                    if(msg == 1)
                        $('#selfie_verify_'+id).html('<button href="#" class="btn btn-success" disabled><span class="fa fa-check"></span> APPROVED</button>');
                        $('#approve_both_'+id).attr('disabled','true');
                });
            })
            $('.approveboth').click(function(){
                var id = $(this).attr('data-id');
                $('#approve_both_'+id).html('<button href="#" class="btn btn-default" disabled>approving...</button>');
                $('#id_verify_'+id).html('<button href="#" class="btn btn-default" disabled>approving...</button>');
                $('#selfie_verify_'+id).html('<button href="#" class="btn btn-default" disabled>approving...</button>');
                $.ajax({
                    method: "POST",
                    url: "{{URL::route('approve-id')}}",
                    data: { id: id, verify: "both", _token: '<?php echo csrf_token(); ?>' }
                })
                .done(function(msg) {
                    if(msg == 1)
                        $('#approve_both_'+id).removeClass('btn-primary').addClass('btn-success').html('Approved').attr('disabled','true');
                        $('#id_verify_'+id).html('<button href="#" class="btn btn-success" disabled><span class="fa fa-check"></span> APPROVED</button>');
                        $('#selfie_verify_'+id).html('<button href="#" class="btn btn-success" disabled><span class="fa fa-check"></span> APPROVED</button>');
                });
            })
            $('#confirmRejectID').click(function(){
                var rid = $('#rejectID').val();
                $('#id_verify_'+rid).html('<button href="#" class="btn btn-default" disabled>rejecting...</button>');
                if($('#IDrejectselect').val() == 'custom')
                {
                    var idreason = $('#customrejectid').val();
                }
                else
                {
                    var idreason = $('#IDrejectselect').val();
                }
                $.ajax({
                    method: "POST",
                    url: "{{URL::route('reject-id')}}",
                    data: { id: rid, verify: "id", reason:idreason, _token: '<?php echo csrf_token(); ?>' }
                })
                .done(function(msg) {
                    if(msg == 1)
                        $('#id_verify_'+rid).html('<button href="#" class="btn btn-danger" disabled><span class="fa fa-check"></span> REJECTED</button>');
                        $('#approve_both_'+rid).attr('disabled','true');
                });
            })
            $('#IDrejectselect').change(function(){
                var idreason = $(this).val();
                if(idreason == 'custom')
                {
                    $('#customrejectid').attr('disabled',false);
                }
                else
                {
                    $('#customrejectid').val('');
                    $('#customrejectid').attr('disabled','true');
                }
            })
            $('#confirmRejectSELFIE').click(function(){
                var rid = $('#rejectSELFIE').val();
                $('#selfie_verify_'+rid).html('<button href="#" class="btn btn-default" disabled>rejecting...</button>');
                //Reject SELFIE ajax process here!!
                if($('#SELFIErejectselect').val() == 'custom')
                {
                    var idreason = $('#customrejectselfie').val();
                }
                else
                {
                    var idreason = $('#SELFIErejectselect').val();
                }
                $.ajax({
                    method: "POST",
                    url: "{{URL::route('reject-id')}}",
                    data: { id: rid, verify: "selfie", reason:idreason, _token: '<?php echo csrf_token(); ?>' }
                })
                .done(function(msg) {
                    if(msg == 1)
                        $('#selfie_verify_'+rid).html('<button href="#" class="btn btn-danger" disabled><span class="fa fa-check"></span> REJECTED</button>');
                        $('#approve_both_'+rid).attr('disabled','true');
                });
            })
            $('#SELFIErejectselect').change(function(){
                var idreason = $(this).val();
                if(idreason == 'custom')
                {
                    $('#customrejectselfie').attr('disabled',false);
                }
                else
                {
                    $('#customrejectselfie').val('');
                    $('#customrejectselfie').attr('disabled','true');
                }
            })
        </script>

<script>
    var filter_type = "";
    var filter_value = "";

    $(".modal-rejectid").click(function(){
        var dataval = $(this).attr('data-id');
        $('#rejectID').val(dataval);
    });

    $(".modal-rejectselfie").click(function(){
        var dataval = $(this).attr('data-id');
        $('#rejectSELFIE').val(dataval);
    });

    $(document).ready(function() {
        update_form();
    });

    $('#filter_type').change(function(){
        update_form();
    });

    $('#filter_value').change(function(){
        update_form();
    });

    $('#filter_value').keyup(function(){
        update_form();
    });

    function update_form()
    {
        filter_type = $('#filter_type').val();
        filter_value = $('#filter_value').val();
        $('#filter_form').attr('action', '{{ URL::to('/') }}/admin/users/{{ $user_type }}/' + filter_type + '/' + filter_value);
        //$('#filter_submit').attr('href', '{{ URL::to('/') }}/admin/users/{{ $user_type }}/' + filter_type + '/' + filter_value);

        if (filter_value == "")
        {
            $('#filter_submit').attr('disabled', true);
        } else {
            $('#filter_submit').attr('disabled', false);
        }
    }

    $('.simple-ajax-modal').magnificPopup({
        type: 'ajax',
        modal: true
    });

    $(document).on('click', '.modal-dismiss', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });

    $(document).on('click', '.close', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });

    $(document).ready(function() {

        $('.image-popup-vertical-fit').magnificPopup({
            type: 'image',
            closeBtnInside: false,
            closeOnContentClick: false,
            image: {
                verticalFit: true
            }

        });
    });
</script>
@Stop