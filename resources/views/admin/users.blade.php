@extends('admin.default')

@section('title'){{trans('member.emails')}} @Stop
@section('homeclass')nav-active @Stop

@section('content')

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
                <h1 class="page-header">User List ({{ $type_name }})</h1>
            </div>
            <div class="panel-heading">
                {{ $user_count }} Members
            </div>
                <form id="filter_form" action="{{ URL::to('/') }}/admin/users/{{ $user_type }}/{{ $filter_type }}/{{ $filter_value }}" class="form-horizontal mb-lg" method="post">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">Field</label>
                        <div class="col-md-4">
                            <select id="filter_type" name="filter_type" class="form-control mb-md">
                                <option value="id" @if($filter_type=='id') selected @endif>ID</option>
                                <option value="firstname" @if($filter_type=='firstname') selected @endif>Firstname</option>
                                <option value="lastname" @if($filter_type=='lastname') selected @endif>Lastname</option>
                                <option value="email" @if($filter_type=='email') selected @endif>Email</option>
                                <option value="mobile" @if($filter_type=='mobile') selected @endif>Mobile</option>
                                <option value="country_code" @if($filter_type=='country_code') selected @endif>Country Code</option>
                                <option value="alias" @if($filter_type=='alias') selected @endif>Alias</option>
                                <option value="referral_user_id" @if($filter_type=='referral_user_id') selected @endif>Referral User ID</option>
                                <option value="upline_user_id" @if($filter_type=='upline_user_id') selected @endif>Upline User ID</option>
                                <option value="tree_position" @if($filter_type=='tree_position') selected @endif>Tree Position</option>
                                <option value="user_class" @if($filter_type=='user_class') selected @endif>User Class</option>
                                <option value="global_level" @if($filter_type=='global_level') selected @endif>Global Level</option>
                                <option value="hierarchy" @if($filter_type=='hierarchy') selected @endif>Hierarchy</option>
                                <option value="hierarchy_bank" @if($filter_type=='hierarchy_bank') selected @endif>Hierarchy Referral</option>
                                <option value="wallet_address" @if($filter_type=='wallet_address') selected @endif>Wallet Address</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">Filter</label>
                        <div class="col-md-4">
                            <input type="text" id="filter_value" name="filter_value" value="{{$filter_value}}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-7 text-right">
                            <!--
                            <a href="{{ URL::to('/') }}/admin/users/{{ $user_type }}/{{ $filter_type }}/{{ $filter_value }}" id="filter_submit" class="btn btn-primary modal-confirm" disabled>Submit</a>
                            -->
                            <button type="submit" id="filter_submit" class="btn btn-primary modal-confirm" disabled>Submit</button>
                        </div>
                    </div>
                </form>

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

            <div class="panel-body" >
                <table class="table table-striped table-bordered table-hover" id="dataTables-share">
                    <thead>
                    <tr>
                        <th class="hidden-xs">ID</th>
                        <th>User Details</th>
                        <th class="hidden-xs">Account Details</th>
                        <th>Action</th>
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
                                <strong>Wallet Address :</strong> {{ $user->wallet_address }}<br>
                                <strong>Country Code :</strong> {{ $user->country_code }}<br>
                                <strong>Registered Date :</strong> {{ $user->created_at }}<br>
                                <strong>Profile Photo :</strong> <a href="{{S3Files::url('profiles/'.$user->profile_pic)}}" target="_blank">{{ $user->profile_pic }}</a>
                            </td>
                            <td class="hidden-xs">
                                <strong>Referral User ID :</strong> {{ $user->referral_user_id }} <a href="{{ URL::to('/') }}/admin/user-referrer/{{ $user->id }}" class="simple-ajax-modal"><span class="fa fa-sitemap fa-fw"></span></a><br>
                                <strong>Upline User ID :</strong> {{ $user->upline_user_id }}<br>
                                <strong>User Class :</strong> {{ $user->user_class }}<br>
                                <strong>Tree Position :</strong> {{ $user->tree_position }}<br>
                                <strong>Tree Slot :</strong> {{ $user->tree_slot }}<br>
                                <strong>Passport Balance :</strong> {{ $user->passport_balance }}<br>
                                <strong>Micro Passport Balance :</strong> {{ $user->micro_passport_balance }}<br>
                                <strong>ID Vefify :</strong> <a href="{{S3Files::url('private/id_verify/'.$user->id_verify_file)}}" target="_blank">{{ $user->id_verify_file }}</a><img src="{{asset('assets/images/iv_'.$user->id_verify_status.'.png')}}"><br>
                                <strong>Photo Verify :</strong> <a href="{{S3Files::url('private/photo_verify/'.$user->selfie_verify_file)}}" target="_blank">{{ $user->selfie_verify_file }}</a><img src="{{asset('assets/images/pv_'.$user->selfie_verify_status.'.png')}}">
                                @if (!empty($downline))
                                @if (count($downline))
                                <br><strong>Downline Count :</strong> {{ $downline[$user->id] }}
                                @endif
                                @endif
                                @if (!empty($referral))
                                @if (count($referral))
                                <br><strong>Referral Count :</strong> {{ $referral[$user->id] }}
                                @endif
                                @endif
                            </td>
                            <td class="visible-xs">
                                <strong>User ID :</strong> {{ $user->id }}<br>
                                <strong>Alias :</strong> {{ $user->alias }}<br>
                                <strong>First Name :</strong> {{ $user->firstname }}<br>
                                <strong>Last Name :</strong> {{ $user->lastname }}<br>
                                <strong>Email :</strong> {{ $user->email }}<br>
                                <strong>Mobile :</strong> {{ $user->mobile }}<br>
                                <strong>Wallet Address :</strong> {{ $user->wallet_address }}<br>
                                <strong>Country Code :</strong> {{ $user->country_code }}<br>
                                <strong>Registered Date :</strong> {{ $user->created_at }}<br>
                                <strong>Profile Photo :</strong> <a href="{{S3Files::url('profiles/'.$user->profile_pic)}}" target="_blank">{{ $user->profile_pic }}</a><br>
                                <strong>Referral User ID :</strong> {{ $user->referral_user_id }} <a href="{{ URL::to('/') }}/admin/user-referrer/{{ $user->id }}" class="simple-ajax-modal"><span class="fa fa-sitemap fa-fw"></span></a><br>
                                <strong>Upline User ID :</strong> {{ $user->upline_user_id }}<br>
                                <strong>User Class :</strong> {{ $user->user_class }}<br>
                                <strong>Tree Position :</strong> {{ $user->tree_position }}<br>
                                <strong>Tree Slot :</strong> {{ $user->tree_slot }}<br>
                                <strong>Passport Balance :</strong> {{ $user->passport_balance }}<br>
                                <strong>Micro Passport Balance :</strong> {{ $user->micro_passport_balance }}<br>
                                <strong>ID Vefify :</strong> <a href="{{S3Files::url('private/id_verify/'.$user->id_verify_file)}}" target="_blank">{{ $user->id_verify_file }}</a><img src="{{asset('assets/images/iv_'.$user->id_verify_status.'.png')}}"><br>
                                <strong>Photo Verify :</strong> <a href="{{S3Files::url('private/photo_verify/'.$user->selfie_verify_file)}}" target="_blank">{{ $user->selfie_verify_file }}</a><img src="{{asset('assets/images/pv_'.$user->selfie_verify_status.'.png')}}">
                                @if (!empty($downline))
                                @if (count($downline))
                                <br><strong>Downline Count :</strong> {{ $downline[$user->id] }}
                                @endif
                                @endif
                                @if (!empty($referral))
                                @if (count($referral))
                                <br><strong>Referral Count :</strong> {{ $referral[$user->id] }}
                                @endif
                                @endif
                            </td>
                            <td>
                                <a href="{{ URL::to('/') }}/admin/quick-login/{{ $user->id }}" class="clearfix"><span class="fa fa-external-link fa-fw"></span></a>
                                <a href="{{URL::to('/')}}/admin/analytics/{{ $user->id }}" id="1" class="simple-ajax-modal clearfix"><span class="fa fa-link fa-fw"></span></a>
                                <a href="{{URL::to('/')}}/admin/logs/{{ $user->id }}" id="1" class="simple-ajax-modal clearfix"><span class="fa fa-list-ol fa-fw"></span></a>
                                <a href="{{URL::to('/')}}/admin/payments/{{ $user->id }}" id="1" class="simple-ajax-modal clearfix"><span class="fa fa-arrows-v"></span></a>
                                <a href="{{URL::to('/')}}/admin/receivings/{{ $user->id }}" id="1" class="simple-ajax-modal clearfix"><span class="fa fa-long-arrow-right"></span></a>
                                <a href="{{URL::to('/')}}/admin/callbacks/{{ $user->id }}" id="1" class="simple-ajax-modal clearfix"><span class="fa fa-exchange"></span></a>
                                <a href="{{URL::to('/')}}/admin/passports/{{ $user->id }}" id="1" class="simple-ajax-modal clearfix"><i class="" aria-hidden="true"><img src="{{asset('assets/images/passport_ico.png')}}" width="20"/></i></a>
                                <a href="#" data-toggle="modal" data-target="#updateReferrer" data-id="{{ $user->id }}" class="modal-referrer on-default edit-row"><span class="fa fa-share"></span></a>
                                @if($user->user_type == 3)
                                <a href="#" data-toggle="modal" data-target="#assignUser" data-id="{{ $user->id }}" class="modal-assign on-default edit-row"><span class="fa fa-user"></span></a>
                                @else
                                <a href="{{URL::to('/')}}/admin/shares/{{ $user->id }}" id="1" class="simple-ajax-modal clearfix"><i class="" aria-hidden="true"><img src="{{asset('assets/images/brwallet_ico.png')}}" width="20"/></i></a>
                                @endif
                                <a href="#" data-toggle="modal" data-target=".transferPassport" data-id="{{ $user->id }}" class="modal-passport on-default edit-row clearfix"><img src="{{asset('assets/images/passport_ico.png')}}" width="20"/></a>

                                <a href="#" data-toggle="modal" data-target=".reclaimAccount" data-id="{{ $user->id }}" class="modal-reclaim on-default edit-row clearfix"><span class="fa fa-recycle"></span></a>
                                <a href="#" data-toggle="modal" data-target="#moveNetwork" data-id="{{ $user->id }}" class="modal-movenetwork on-default edit-row clearfix"><span class="fa fa-bomb"></span></a>
                                <a href="#" data-toggle="modal" data-target="#GHB" data-id="{{ $user->id }}" class="modal-ghb on-default edit-row clearfix">GH</a>

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
<!-- /#page-wrapper -->

<div class="modal fade" id="assignUser" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ URL::route('assign-upline') }}" class="form-horizontal form-bordered" method="POST">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Assign Upline To User ID : <span id="theuser"></span></h4>
            </div>
            <div class="modal-body">
                <input type="text" name="upline_id" class="form-control" placeholder="Upline ID"/>
            </div>
            <div class="modal-footer">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input id="modalid" type="hidden" name="id" value="">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Assign Upline</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="updateReferrer" tabindex="2" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ URL::route('update-referrer') }}" class="form-horizontal form-bordered" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Assign Referrer To User ID : <span id="theuser3"></span></h4>
                </div>
                <div class="modal-body">
                    <input type="text" name="referrer_id" class="form-control" placeholder="Referrer ID"/>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input id="modalid3" type="hidden" name="id" value="">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Referrer</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade reclaimAccount" tabindex="4" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ URL::route('reclaim-account') }}" class="form-horizontal form-bordered" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Reclaim Account User ID : <span id="theuser4"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        Reclaim
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input id="modalid4" type="hidden" name="id" value="">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Reclaim Account</button>
                    </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div></div>

<div class="modal fade transferPassport" tabindex="5" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ URL::route('transfer-passport') }}" class="form-horizontal form-bordered" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Transfer Passport To User ID : <span id="theuser2"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <input type="text" name="passport" class="form-control" placeholder="Passport"/>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input id="modalid2" type="hidden" name="id" value="">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Transfer Passport</button>
                    </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div></div>

<div class="modal fade" id="moveNetwork" tabindex="3" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ URL::route('move-network') }}" class="form-horizontal form-bordered" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Transfer Network for User ID : <span id="theuser5"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <input type="text" name="upline_user_id" class="form-control" placeholder="Upline ID"/>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="tree_position" class="form-control" placeholder="Tree Position"/>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input id="modalid5" type="hidden" name="id" value="">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Transfer Network</button>
                    </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</div>

<div class="modal fade" id="GHB" tabindex="3" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ URL::route('admin-ghb') }}" class="form-horizontal form-bordered" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">GHB for User ID : <span id="theuser5"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <input type="text" name="ghUserid1" id="ghUserid1" class="form-control" placeholder="User ID"/>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="value_in_btc" class="form-control" placeholder="Amoutn IN BTC"/>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input id="secret" type="hidden" name="secret" value="{{ \App\Classes\BitcoinWalletClass::generateSecret() }}">
                        <input id="ghUserid" type="text" name="ghUserid" value="">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit GHB</button>
                    </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    var filter_type = "";
    var filter_value = "";

    $(".modal-assign").click(function(){
        var dataval = $(this).attr('data-id');
        $('#modalid').val(dataval);
        $('#theuser').html(dataval);
    });

    $(".modal-passport").click(function(){
        var dataval = $(this).attr('data-id');
        $('#modalid2').val(dataval);
        $('#theuser2').html(dataval);
    })

    $(".modal-referrer").click(function(){
        var dataval = $(this).attr('data-id');
        $('#modalid3').val(dataval);
        $('#theuser3').html(dataval);
    })

    $(".modal-reclaim").click(function(){
        var dataval = $(this).attr('data-id');
        $('#modalid4').val(dataval);
        $('#theuser4').html(dataval);
    })

    $(".modal-movenetwork").click(function(){
        var dataval = $(this).attr('data-id');
        $('#modalid5').val(dataval);
        $('#theuser5').html(dataval);
    })

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


    $(".modal-ghb").click(function(){
        var dataval = $(this).attr('data-id');
        $('#ghUserid').val(dataval);
        $('#ghUserid1').val(dataval);

        
    })
</script>
@Stop