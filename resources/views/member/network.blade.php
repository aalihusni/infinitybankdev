@extends('member.default')

@section('title')Manage Account @Stop

@section('network-class')nav-active @Stop

@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <!-- Nav tabs -->
                        <a href="{{URL::route('referral')}}" class="btn btn-primary pull-right">Manage Unilevel Account</a>

                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#home" data-toggle="tab">Member(s)</a>
                            </li>
                            <li><a href="#profile" data-toggle="tab">Non-Member(s)</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="home">
                                <div class="dataTable_wrapper" style="padding-top:30px;">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-member">
                                        <thead>
                                        <tr>
                                            <th class="hidden-xs hidden-sm">Username</th>
                                            <th class="hidden-xs hidden-sm">Class</th>
                                            <th class="hidden-xs hidden-sm">Email</th>
                                            <th class="hidden-xs hidden-sm">Country</th>
                                            <th class="hidden-xs hidden-sm" style="text-align:center;">Contact</th>
                                            <th class="hidden-lg">User</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if ($members)
                                            @foreach($members as $member)
                                                <tr class="odd gradeX">
                                                    <td class="hidden-xs hidden-sm">{{ $member['alias'] }}</td>
                                                    <td class="hidden-xs hidden-sm">{{ $member['user_class_name'] }}</td>
                                                    <td class="hidden-xs hidden-sm">{{ $member['email'] }}</td>
                                                    <td class="hidden-xs hidden-sm center">{{ $member['country_code'] }}</td>
                                                    <td class="hidden-xs hidden-sm center">
                                                        @if($member['mobile']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Mobile"><a href="#" title="Mobile" data-content="{{$member['mobile']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-mobile"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($member['sos_wechat']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Wechat"><a href="#" title="Wechat" data-content="{{$member['sos_wechat']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-wechat"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($member['sos_qq']!='')
                                                                <span data-toggle="tooltip" data-placement="top" title="QQ"><a href="#" title="QQ" data-content="{{$member['sos_qq']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-qq"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($member['sos_whatsapp']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Whatsapp"><a href="#" title="Whatsapp" data-content="{{$member['sos_whatsapp']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-whatsapp"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($member['sos_line']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Line"><a href="#" title="Line" data-content="{{$member['sos_line']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-minus-square"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($member['sos_viber']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Viber"><a href="#" title="Viber" data-content="{{$member['sos_viber']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-vimeo-square"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($member['sos_skype']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Skype"><a href="#" title="Skype" data-content="{{$member['sos_skype']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-skype"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($member['sos_bbm']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="BBM"><a href="#" title="BBM" data-content="{{$member['sos_bbm']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-weixin"></span></a></span>
                                                        @endif
                                                    </td>
                                                    <td class="hidden-lg">
                                                        Username : {{ $member['alias'] }}<br>
                                                        Class : {{ $member['user_class_name'] }}<br>
                                                        Email : {{ $member['email'] }}<br>
                                                        Country : {{ $member['country_code'] }}<br>
                                                        @if($member['mobile']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Mobile"><a href="#" title="Mobile" data-content="{{$member['mobile']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-mobile"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($member['sos_wechat']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Wechat"><a href="#" title="Wechat" data-content="{{$member['sos_wechat']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-wechat"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($member['sos_qq']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="QQ"><a href="#" title="QQ" data-content="{{$member['sos_qq']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-qq"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($member['sos_whatsapp']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Whatsapp"><a href="#" title="Whatsapp" data-content="{{$member['sos_whatsapp']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-whatsapp"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($member['sos_line']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Line"><a href="#" title="Line" data-content="{{$member['sos_line']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-minus-square"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($member['sos_viber']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Viber"><a href="#" title="Viber" data-content="{{$member['sos_viber']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-vimeo-square"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($member['sos_skype']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Skype"><a href="#" title="Skype" data-content="{{$member['sos_skype']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-skype"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($member['sos_bbm']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="BBM"><a href="#" title="BBM" data-content="{{$member['sos_bbm']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-weixin"></span></a></span>
                                                        @endif
                                                    </td>
                                                    <td class="center col-lg-2">
                                                        <a class="btn btn-primary btn-xs" href="{{URL::to('/')."/members/manage-account/".$member['cryptid']}}">Manage Account</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        <!--
                                        <tr class="odd gradeX">
                                            <td>Test</td>
                                            <td>Immigrant</td>
                                            <td>test@test.com</td>
                                            <td class="center">US</td>
                                            <td class="center col-lg-2">
                                                <a class="btn btn-primary btn-xs" href="{{URL::route('manage-account')}}">Manage Account</a>
                                            </td>
                                        </tr>
                                        <tr class="even gradeC">
                                            <td>Test</td>
                                            <td>Immigrant</td>
                                            <td>test@test.com</td>
                                            <td class="center">US</td>
                                            <td class="center col-lg-2">
                                                <a class="btn btn-primary btn-xs" href="{{URL::route('manage-account')}}">Manage Account</a>
                                            </td>
                                        </tr>
                                        -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile">
                                <div class="dataTable_wrapper" style="padding-top:30px;">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-referral">
                                        <thead>
                                        <tr>
                                            <th class="hidden-xs hidden-sm">Username</th>
                                            <th class="hidden-xs hidden-sm">Class</th>
                                            <th class="hidden-xs hidden-sm">Email</th>
                                            <th class="hidden-xs hidden-sm">Country</th>
                                            <th class="hidden-xs hidden-sm" style="text-align:center;">Contact</th>
                                            <th class="hidden-lg">User</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if ($subscribers)
                                            @foreach($subscribers as $subscriber)
                                                <tr class="odd gradeX">
                                                    <td class="hidden-xs hidden-sm">{{ $subscriber['alias'] }}</td>
                                                    <td class="hidden-xs hidden-sm">{{ $subscriber['user_class_name'] }}</td>
                                                    <td class="hidden-xs hidden-sm">{{ $subscriber['email'] }}</td>
                                                    <td class="hidden-xs hidden-sm center">{{ $subscriber['country_code'] }}</td>
                                                    <td class="hidden-xs hidden-sm center">
                                                        @if($subscriber['mobile']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Mobile"><a href="#" title="Mobile" data-content="{{$subscriber['mobile']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-mobile"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($subscriber['sos_wechat']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Wechat"><a href="#" title="Wechat" data-content="{{$subscriber['sos_wechat']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-wechat"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($subscriber['sos_qq']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="QQ"><a href="#" title="QQ" data-content="{{$subscriber['sos_qq']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-qq"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($subscriber['sos_whatsapp']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Whatsapp"><a href="#" title="Whatsapp" data-content="{{$subscriber['sos_whatsapp']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-whatsapp"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($subscriber['sos_line']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Line"><a href="#" title="Line" data-content="{{$subscriber['sos_line']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-minus-square"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($subscriber['sos_viber']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Viber"><a href="#" title="Viber" data-content="{{$subscriber['sos_viber']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-vimeo-square"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($subscriber['sos_skype']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Skype"><a href="#" title="Skype" data-content="{{$subscriber['sos_skype']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-skype"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($subscriber['sos_bbm']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="BBM"><a href="#" title="BBM" data-content="{{$subscriber['sos_bbm']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-weixin"></span></a></span>
                                                        @endif
                                                    </td>
                                                    <td class="hidden-lg">
                                                        Username : {{ $subscriber['alias'] }}<br>
                                                        Class : {{ $subscriber['user_class_name'] }}<br>
                                                        Email : {{ $subscriber['email'] }}<br>
                                                        Country : {{ $subscriber['country_code'] }}<br>
                                                        @if($subscriber['mobile']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Mobile"><a href="#" title="Mobile" data-content="{{$subscriber['mobile']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-mobile"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($subscriber['sos_wechat']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Wechat"><a href="#" title="Wechat" data-content="{{$subscriber['sos_wechat']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-wechat"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($subscriber['sos_qq']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="QQ"><a href="#" title="QQ" data-content="{{$subscriber['sos_qq']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-qq"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($subscriber['sos_whatsapp']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Whatsapp"><a href="#" title="Whatsapp" data-content="{{$subscriber['sos_whatsapp']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-whatsapp"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($subscriber['sos_line']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Line"><a href="#" title="Line" data-content="{{$subscriber['sos_line']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-minus-square"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($subscriber['sos_viber']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Viber"><a href="#" title="Viber" data-content="{{$subscriber['sos_viber']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-vimeo-square"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($subscriber['sos_skype']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="Skype"><a href="#" title="Skype" data-content="{{$subscriber['sos_skype']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-skype"></span></a></span>
                                                        @endif
                                                        &nbsp;
                                                        @if($subscriber['sos_bbm']!='')
                                                            <span data-toggle="tooltip" data-placement="top" title="BBM"><a href="#" title="BBM" data-content="{{$subscriber['sos_bbm']}}"  data-toggle="popover" data-placement="bottom" data-container="body" data-placement="top"><span class="fa fa-weixin"></span></a></span>
                                                        @endif
                                                    </td>
                                                    <td class="center col-lg-2">
                                                        <a class="btn btn-primary btn-xs" href="{{URL::to('/')."/members/manage-account/".$subscriber['cryptid']}}">Manage Account</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        <!--
                                        <tr class="odd gradeX">
                                            <td>Test</td>
                                            <td>Immigrant</td>
                                            <td>test@test.com</td>
                                            <td class="center">US</td>
                                            <td class="center col-lg-2">
                                                <a class="btn btn-primary btn-xs" href="{{URL::route('manage-account')}}">Manage Account</a>
                                            </td>
                                        </tr>
                                        <tr class="even gradeC">
                                            <td>Test</td>
                                            <td>Immigrant</td>
                                            <td>test@test.com</td>
                                            <td class="center">US</td>
                                            <td class="center col-lg-2">
                                                <a class="btn btn-primary btn-xs" href="{{URL::route('manage-account')}}">Manage Account</a>
                                            </td>
                                        </tr>
                                        -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>

        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

@Stop