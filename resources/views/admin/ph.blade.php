@extends('admin.default')

@section('title')PH @Stop
@section('homeclass')nav-active @Stop

@section('content')

        <!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
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

            <div class="panel-heading">
                <button id="show">Show</button>
                <button id="hide">Hide</button>
            </div>

            <div class="panel-heading">
                Queue : {{ $queue_sum }} <button class="btndetails" data-id="queue">+</button>
            </div>
            <div class="panel-body details" style="display: none;" id="queue">
                <table class="table table-striped table-bordered table-hover" id="dataTables-share">
                    <thead>
                    <tr>
                        <th class="hidden-xs">ID</th>
                        <th>Created At</th>
                        <th>PH Details</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($queue_list as $ph)
                        <tr class="odd gradeX">
                            <td class="hidden-xs">{{ $ph->id }}</td>
                            <td>{{ $ph->created_at }}</td>
                            <td>
                                <strong>User ID :</strong> {{ $ph->user_id }} ({{ $ph->alias }})<br>
                                <strong>Country Code :</strong> {{ $ph->country_code }}<br>
                                <strong>BTC :</strong> {{ $ph->value_in_btc }}<br>
                                <strong>Status :</strong> {{ $ph->status }}<br>
                                <strong>Expired :</strong> {{ $ph->expired }}<br>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $queue_list->render() !!}
            </div>

            <div class="panel-heading">
                Match : {{ $match_sum }} ({{ $match_unpaid_sum }}/{{ $match_paid_sum }}) <button class="btndetails" data-id="match">+</button>
            </div>
            <div class="panel-body details" style="display: none;" id="match">
                <table class="table table-striped table-bordered table-hover" id="dataTables-share">
                    <thead>
                    <tr>
                        <th class="hidden-xs">ID</th>
                        <th>Created At</th>
                        <th>PH Details</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($match_list as $ph)
                        <tr class="odd gradeX">
                            <td class="hidden-xs">{{ $ph->id }}</td>
                            <td>{{ $ph->created_at }}</td>
                            <td>
                                <strong>User ID :</strong> {{ $ph->user_id }} ({{ $ph->alias }})<br>
                                <strong>Country Code :</strong> {{ $ph->country_code }}<br>
                                <strong>BTC :</strong> {{ $ph->value_in_btc }}<br>
                                <strong>Status :</strong> {{ $ph->status }}<br>
                                <strong>Expired :</strong> {{ $ph->expired }}<br>
                            </td>
                            <td><div id="PH{{ $ph->id }}"></div><button class="phgh" data-id="{{ $ph->id }}">PHGH</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $match_list->render() !!}
            </div>

            <div class="panel-heading">
                Active : {{ $active_sum }} <button class="btndetails" data-id="active">+</button>
            </div>
            <div class="panel-body details" style="display: none;" id="active">
                <table class="table table-striped table-bordered table-hover" id="dataTables-share">
                    <thead>
                    <tr>
                        <th class="hidden-xs">ID</th>
                        <th>Created At</th>
                        <th>PH Details</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($active_list as $ph)
                        <tr class="odd gradeX">
                            <td class="hidden-xs">{{ $ph->id }}</td>
                            <td>{{ $ph->created_at }}</td>
                            <td>
                                <strong>User ID :</strong> {{ $ph->user_id }} ({{ $ph->alias }})<br>
                                <strong>Country Code :</strong> {{ $ph->country_code }}<br>
                                <strong>BTC :</strong> {{ $ph->value_in_btc }}<br>
                                <strong>Status :</strong> {{ $ph->status }}<br>
                                <strong>Expired :</strong> {{ $ph->expired }}<br>
                            </td>
                            <td><div id="PH{{ $ph->id }}"></div><button class="phgh" data-id="{{ $ph->id }}">PHGH</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $active_list->render() !!}
            </div>

            <div class="panel-heading">
                On Hold : {{ $onhold_sum }} <button class="btndetails" data-id="onhold">+</button>
            </div>
            <div class="panel-body details" style="display: none;" id="onhold">
                <table class="table table-striped table-bordered table-hover" id="dataTables-share">
                    <thead>
                    <tr>
                        <th class="hidden-xs">ID</th>
                        <th>Created At</th>
                        <th>PH Details</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($onhold_list as $ph)
                        <tr class="odd gradeX">
                            <td class="hidden-xs">{{ $ph->id }}</td>
                            <td>{{ $ph->created_at }}</td>
                            <td>
                                <strong>User ID :</strong> {{ $ph->user_id }} ({{ $ph->alias }})<br>
                                <strong>Country Code :</strong> {{ $ph->country_code }}<br>
                                <strong>BTC :</strong> {{ $ph->value_in_btc }}<br>
                                <strong>Status :</strong> {{ $ph->status }}<br>
                                <strong>Expired :</strong> {{ $ph->expired }}<br>
                            </td>
                            <td><div id="PH{{ $ph->id }}"></div><button class="phgh" data-id="{{ $ph->id }}">PHGH</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $onhold_list->render() !!}
            </div>

            <div class="panel-heading">
                Released : {{ $released_sum }} <button class="btndetails" data-id="released">+</button>
            </div>
            <div class="panel-body details" style="display: none;" id="released">
                <table class="table table-striped table-bordered table-hover" id="dataTables-share">
                    <thead>
                    <tr>
                        <th class="hidden-xs">ID</th>
                        <th>Created At</th>
                        <th>PH Details</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($released_list as $ph)
                        <tr class="odd gradeX">
                            <td class="hidden-xs">{{ $ph->id }}</td>
                            <td>{{ $ph->created_at }}</td>
                            <td>
                                <strong>User ID :</strong> {{ $ph->user_id }} ({{ $ph->alias }})<br>
                                <strong>Country Code :</strong> {{ $ph->country_code }}<br>
                                <strong>BTC :</strong> {{ $ph->value_in_btc }}<br>
                                <strong>Status :</strong> {{ $ph->status }}<br>
                                <strong>Expired :</strong> {{ $ph->expired }}<br>
                            </td>
                            <td><div id="PH{{ $ph->id }}"></div><button class="phgh" data-id="{{ $ph->id }}">PHGH</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $released_list->render() !!}
            </div>

            <div class="panel-heading">
                Ended : {{ $ended_sum }} <button class="btndetails" data-id="ended">+</button>
            </div>
            <div class="panel-body details" style="display: none;" id="ended">
                <table class="table table-striped table-bordered table-hover" id="dataTables-share">
                    <thead>
                    <tr>
                        <th class="hidden-xs">ID</th>
                        <th>Created At</th>
                        <th>PH Details</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ended_list as $ph)
                        <tr class="odd gradeX">
                            <td class="hidden-xs">{{ $ph->id }}</td>
                            <td>{{ $ph->created_at }}</td>
                            <td>
                                <strong>User ID :</strong> {{ $ph->user_id }} ({{ $ph->alias }})<br>
                                <strong>Country Code :</strong> {{ $ph->country_code }}<br>
                                <strong>BTC :</strong> {{ $ph->value_in_btc }}<br>
                                <strong>Status :</strong> {{ $ph->status }}<br>
                                <strong>Expired :</strong> {{ $ph->expired }}<br>
                            </td>
                            <td><div id="PH{{ $ph->id }}"></div><button class="phgh" data-id="{{ $ph->id }}">PHGH</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $ended_list->render() !!}
            </div>

            <div class="panel-heading">
                Expired : {{ $expired_sum }} <button class="btndetails" data-id="expired">+</button>
            </div>
            <div class="panel-body details" style="display: none;" id="expired">
                <table class="table table-striped table-bordered table-hover" id="dataTables-share">
                    <thead>
                    <tr>
                        <th class="hidden-xs">ID</th>
                        <th>Created At</th>
                        <th>PH Details</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expired_list as $ph)
                        <tr class="odd gradeX">
                            <td class="hidden-xs">{{ $ph->id }}</td>
                            <td>{{ $ph->created_at }}</td>
                            <td>
                                <strong>User ID :</strong> {{ $ph->user_id }} ({{ $ph->alias }})<br>
                                <strong>Country Code :</strong> {{ $ph->country_code }}<br>
                                <strong>BTC :</strong> {{ $ph->value_in_btc }}<br>
                                <strong>Status :</strong> {{ $ph->status }}<br>
                                <strong>Expired :</strong> {{ $ph->expired }}<br>
                            </td>
                            <td><div id="PH{{ $ph->id }}"></div><button class="phgh" data-id="{{ $ph->id }}">PHGH</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $expired_list->render() !!}
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<script>
    $('#show').on('click', function () {
        $('.details').each(function() {
            $(this).show();
        })
        $('.btndetails').each(function() {
            $(this).html("-");
        })
    });

    $('#hide').on('click', function () {
        $('.details').each(function() {
            $(this).hide();
        })
        $('.btndetails').each(function() {
            $(this).html("+");
        })
    });

    $('.btndetails').on('click', function () {
        var id = $(this).attr("data-id");
        $('#'+id).toggle();
        if ($(this).html() == "+")
        {
            $(this).html("-");
        } else {
            $(this).html("+");
        }
    });

    $('.phgh').on('click', function () {
        var ph_id = $(this).attr("data-id");
        get_phgh(ph_id);
    });

    function get_phgh(ph_id){
        var loadUrl = '{{ URL::to('/') }}/admin/@if (strpos(Request::url(),'micro') > 0){{ "micro-getphgh" }}@else{{  "getphgh" }}@endif/ph/'+ph_id;
        $.ajax({url: loadUrl, success: function(result) {
            $('#PH'+ph_id).html(result);
        }});
    }
</script>
@Stop