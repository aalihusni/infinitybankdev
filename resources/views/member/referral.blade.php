@extends('member.default')

@section('title') {{ trans('referral.referral') }} @Stop

@section('rh-class')nav-active @Stop
@section('hierarchy-class')nav-expanded nav-active @Stop

@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">

            <div id="ref_generation" class="col-lg-3">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        {{ trans('referral.referralfie') }}
                    </div>
                    {{--*/ $first_ref = "" /*--}}
                    @if (!empty($referrers))
                        @foreach($referrers as $referrer)
                        <div class="panel-footer">
                            {!! $first_ref !!}
                            <a class="seemore" data-id="{{ $referrer['id'] }}" href="#">
                            <span class="pull-left">{{ $referrer['alias'] }}</span>
                            </a>
                            <span class="pull-right"><strong>{{ $referrer['referrals_count'] }}</strong></span>
                            <div class="clearfix"></div>
                        </div>
                        {{--*/ $first_ref = '<img class="ref_pointer" src="'.asset('assets/images/ref_arrow.png').'"/>' /*--}}
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ trans('referral.referral') }}
                    </div>
                    <div class="panel-body" >
                        <table class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                            <tr>
                                <th class="hidden-xs hidden-sm">{{ trans('referral.username') }}</th>
                                <th class="hidden-xs hidden-sm">{{ trans('referral.usertype') }}</th>
                                <th class="hidden-xs hidden-sm">{{ trans('referral.userclass') }}</th>
                                <th class="hidden-xs hidden-sm">{{ trans('referral.uplineusername') }}</th>
                                <th class="hidden-xs hidden-sm">{{ trans('referral.position') }}</th>
                                <th class="hidden-xs hidden-sm">{{ trans('referral.referral') }}</th>
                                <th class="hidden-xs hidden-sm">{{ trans('referral.contacts') }}</th>
                                <th class="hidden-lg">&nbsp</th>
                                <th>&nbsp</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (!empty($referrals))
                            @foreach($referrals as $referral)
                            <tr class="odd gradeX">
                                <td class="hidden-xs hidden-sm">{{ $referral['alias'] }}</td>
                                <td class="hidden-xs hidden-sm">{{ $referral['user_type_name'] }}</td>
                                <td class="hidden-xs hidden-sm">{{ $referral['user_class_name'] }}</td>
                                <td class="hidden-xs hidden-sm">{{ $referral['upline_alias'] }}</td>
                                <td class="hidden-xs hidden-sm">{{ $referral['tree_position_name'] }}</td>
                                <td class="hidden-xs hidden-sm">{{ $referral['referrals'] }}</td>
                                <td class="hidden-xs hidden-sm">
                                    @if($referral['email']!='')
                                        <span data-toggle="tooltip" data-placement="top" title="Email"><a href="#" title="Email" data-content="{{$referral['email']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-envelope"></span></a></span>
                                    @endif

                                    @if($referral['mobile']!='')
                                        <span data-toggle="tooltip" data-placement="top" title="Mobile"><a href="#" title="Mobile" data-content="{{$referral['mobile']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-mobile"></span></a></span>
                                    @endif

                                    @if($referral['sos_wechat']!='')
                                        <span data-toggle="tooltip" data-placement="top" title="Wechat"><a href="#" title="Wechat" data-content="{{$referral['sos_wechat']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-wechat"></span></a></span>
                                    @endif

                                    @if($referral['sos_qq']!='')
                                        <span data-toggle="tooltip" data-placement="top" title="QQ"><a href="#" title="QQ" data-content="{{$referral['sos_qq']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-qq"></span></a></span>
                                    @endif

                                    @if($referral['sos_whatsapp']!='')
                                        <span data-toggle="tooltip" data-placement="top" title="Whatsapp"><a href="#" title="Whatsapp" data-content="{{$referral['sos_whatsapp']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-whatsapp"></span></a></span>
                                    @endif

                                    @if($referral['sos_line']!='')
                                        <span data-toggle="tooltip" data-placement="top" title="Line"><a href="#" title="Line" data-content="{{$referral['sos_line']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-minus-square"></span></a></span>
                                    @endif

                                    @if($referral['sos_viber']!='')
                                        <span data-toggle="tooltip" data-placement="top" title="Viber"><a href="#" title="Viber" data-content="{{$referral['sos_viber']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-vimeo-square"></span></a></span>
                                    @endif

                                    @if($referral['sos_skype']!='')
                                        <span data-toggle="tooltip" data-placement="top" title="Skype"><a href="#" title="Skype" data-content="{{$referral['sos_skype']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-skype"></span></a></span>
                                    @endif

                                    @if($referral['sos_bbm']!='')
                                        <span data-toggle="tooltip" data-placement="top" title="BBM"><a href="#" title="BBM" data-content="{{$referral['sos_bbm']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-weixin"></span></a></span>
                                    @endif
                                </td>
                                <td class="hidden-lg">
                                <strong>{{ trans('referral.username') }} :</strong> {{ $referral['alias'] }}<br>
                                <strong>{{ trans('referral.usertype') }} :</strong> {{ $referral['user_type_name'] }}<br>
                                <strong>{{ trans('referral.userclass') }} :</strong> {{ $referral['user_class_name'] }}<br>
                                <strong>{{ trans('referral.uplineusername') }} :</strong> {{ $referral['upline_alias'] }}<br>
                                <strong>{{ trans('referral.position') }} :</strong> {{ $referral['tree_position_name'] }}<br>
                                <strong>{{ trans('referral.referral') }} :</strong> {{ $referral['referrals'] }}<br>
                                    @if($referral['email']!='')
                                        <span data-toggle="tooltip" data-placement="top" title="Email"><a href="#" title="Email" data-content="{{$referral['email']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-envelope"></span></a></span>
                                    @endif
                                    &nbsp;
                                    @if($referral['mobile']!='')
                                        <span data-toggle="tooltip" data-placement="top" title="Mobile"><a href="#" title="Mobile" data-content="{{$referral['mobile']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-mobile"></span></a></span>
                                    @endif
                                    &nbsp;
                                    @if($referral['sos_wechat']!='')
                                        <span data-toggle="tooltip" data-placement="top" title="Wechat"><a href="#" title="Wechat" data-content="{{$referral['sos_wechat']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-wechat"></span></a></span>
                                    @endif
                                    &nbsp;
                                    @if($referral['sos_qq']!='')
                                        <span data-toggle="tooltip" data-placement="top" title="QQ"><a href="#" title="QQ" data-content="{{$referral['sos_qq']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-qq"></span></a></span>
                                    @endif
                                    &nbsp;
                                    @if($referral['sos_whatsapp']!='')
                                        <span data-toggle="tooltip" data-placement="top" title="Whatsapp"><a href="#" title="Whatsapp" data-content="{{$referral['sos_whatsapp']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-whatsapp"></span></a></span>
                                    @endif
                                    &nbsp;
                                    @if($referral['sos_line']!='')
                                        <span data-toggle="tooltip" data-placement="top" title="Line"><a href="#" title="Line" data-content="{{$referral['sos_line']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-minus-square"></span></a></span>
                                    @endif
                                    &nbsp;
                                    @if($referral['sos_viber']!='')
                                        <span data-toggle="tooltip" data-placement="top" title="Viber"><a href="#" title="Viber" data-content="{{$referral['sos_viber']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-vimeo-square"></span></a></span>
                                    @endif
                                    &nbsp;
                                    @if($referral['sos_skype']!='')
                                        <span data-toggle="tooltip" data-placement="top" title="Skype"><a href="#" title="Skype" data-content="{{$referral['sos_skype']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-skype"></span></a></span>
                                    @endif
                                    &nbsp;
                                    @if($referral['sos_bbm']!='')
                                        <span data-toggle="tooltip" data-placement="top" title="BBM"><a href="#" title="BBM" data-content="{{$referral['sos_bbm']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-weixin"></span></a></span>
                                    @endif
                                </td>
                                <td class="center">
                                    <a data-toggle="tooltip" data-placement="bottom" title="View Unilevel Referral" class="seemore" data-id="{{ $referral['id'] }}" href="#"><span class="glyphicon glyphicon-zoom-in"></span></a>
                                    <a data-toggle="tooltip" data-placement="bottom" title="Manage Account" class="seemore" href="{{URL::to('/')."/members/manage-account/".$referral['cryptid']}}"><span class="fa fa-briefcase"></span></a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <form id="hierarchy" href="{{URL::route('referral')}}" method="post">
                <input id="user_id" name="id" type="hidden" value="3">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            </form>

        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<script type="text/javascript">
    $('.seemore').click(function(){
        var userid = $(this).attr('data-id');
        $('#user_id').val(userid);
        if(userid>0) {
            $('#hierarchy').submit();
        }
    })

    var datatableInit = function() {

        $('#dataTables').dataTable();

    };

    $(function() {
        datatableInit();
    });
</script>
@Stop