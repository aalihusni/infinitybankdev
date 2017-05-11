@extends('member.default')

@section('title') {{ trans('gh.gh') }} @Stop

@section('gh-class')nav-active @Stop
@section('bank-class')nav-expanded nav-active @Stop

@section('content')

@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">

                @if ($user_details['id_verify_status'] == 10 || $user_details['selfie_verify_status'] == 10)
                <div class="alert alert-danger">
                    <span class="fa fa-exclamation-triangle fa-4x pull-left" style="color:#a94442;"></span>
                    <p><strong>{{ trans('gh.veriyrequired') }}</strong></p>
                    <p>{{ trans('gh.verifytogh') }} <a class="text-danger" href="{{URL::route('verification')}}">{{ trans('gh.clickhere') }}</a></p>
                </div>
                @endif

                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ trans('gh.pendinggh') }}
                        @if ($user_details['id_verify_status'] != 13 && $user_details['selfie_verify_status'] != 13)
                        @if ($total_gh_active['balance'] > 0)
                            <a href="#GHModal" class="btn btn-primary pull-right modal-with-form">{{ trans('gh.gh') }}</a>
                        @endif
                        @endif
                    </div>
                    <div class="panel-body" >
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <td>&nbsp;</td>
                                <th class="hidden-xs hidden-sm">{{ trans('gh.date') }}</th>
                                <th class="hidden-xs hidden-sm">{{ trans('gh.xsgh') }}</th>
                                <th class="hidden-xs hidden-sm">{{ trans('gh.filled') }}</th>
                                <th class="hidden-xs hidden-sm">{{ trans('gh.status') }}</th>
                                <th class="hidden-xs hidden-sm">{{ trans('gh.queue') }}</th>
                                <th class="hidden-lg">{{ trans('gh.xsgh') }}</th>
                                <th>{{ trans('gh.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($gh_active))
                            @foreach($gh_active as $gh)
                            <tr class="odd gradeX moreinfo" data-target=".class{{ $gh['id'] }}">
                                <td class="center"><span class="fa fa-plus-square-o morecontent"></span></td>
                                <td class="hidden-xs hidden-sm">{{ $gh['time_start'] }}</td>
                                <td class="hidden-xs hidden-sm">{{ $gh['value_in_btc'] }}</td>
                                <td class="hidden-xs hidden-sm">{{ $gh['phgh']['filled'] }}</td>
                                <td class="hidden-xs hidden-sm">{{ $gh['status_name'] }}</td>
                                <td class="hidden-xs hidden-sm center">{{ $gh['queue'] }}</td>
                                <td class="hidden-lg">
                                    <strong>{{ trans('gh.date') }} : </strong>{{ $gh['time_start'] }}<br>
                                    <strong>{{ trans('gh.xsgh') }} : </strong>{{ $gh['value_in_btc'] }}<br>
                                    <strong>{{ trans('gh.filled') }} : </strong>{{ $gh['phgh']['filled'] }}<br>
                                    <strong>{{ trans('gh.status') }} : </strong>{{ $gh['status_name'] }}<br>
                                    <strong>{{ trans('gh.queue') }} : </strong>{{ $gh['queue'] }}
                                </td>
                                <td class="center">
                                    @if ($gh['status'] == 0)
                                    <a href="#CancelGHModal" class="btn btn-danger btn-xs modal-cancel-gh cancel_gh" style="color:#FFF;" data-id="{{ $gh['id'] }}" data-secret="{{ \App\Classes\BitcoinWalletClass::generateSecret() }}" data-value="{{ $gh['value_in_btc'] }}">Cancel</a>
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            <tr class="toggletableclass class{{ $gh['id'] }}">
                                <td colspan="10">

                                    <table class="table table-striped mb-none">
                                        <thead>
                                        <tr>
                                            <td>{{ trans('gh.assigneddate') }}</td>
                                            <td>{{ trans('gh.value') }} <span class="fa fa-bitcoin">TC</td>
                                            <td>{{ trans('gh.status') }}</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if (count($gh['phgh']['data']))
                                            @foreach ($gh['phgh']['data'] as $phgh)
                                                <tr>
                                                    <td>{{ $phgh['created_at'] }}</td>
                                                    <td>{{ $phgh['value_in_btc'] }}</td>
                                                    <td>{{ $phgh['status_name'] }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="center" colspan="4">none</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>

                                </td>
                            </tr>
                            @endforeach
                            @else
                                <tr class="odd gradeX">
                                    <td class="center" colspan="7">none</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        {{ trans('gh.completedgh') }}
                    </div>
                    <div class="panel-body" >
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <td>&nbsp;</td>
                                <th class="hidden-xs hidden-sm">{{ trans('gh.date') }}</th>
                                <th class="hidden-xs hidden-sm">{{ trans('gh.xsgh') }}</th>
                                <th class="hidden-xs hidden-sm">{{ trans('gh.filled') }}</th>
                                <th class="hidden-xs hidden-sm">{{ trans('gh.status') }}</th>
                                <th class="hidden-xs hidden-sm">{{ trans('gh.queue') }}</th>
                                <th class="hidden-lg">{{ trans('gh.xsgh') }}</th>
                                <th>{{ trans('gh.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($gh_ended))
                                @foreach($gh_ended as $gh)
                                    <tr class="odd gradeX moreinfo" data-target=".class{{ $gh['id'] }}">
                                        <td class="center"><span class="fa fa-plus-square-o morecontent"></span></td>
                                        <td class="hidden-xs hidden-sm">{{ $gh['time_start'] }}</td>
                                        <td class="hidden-xs hidden-sm">{{ $gh['value_in_btc'] }}</td>
                                        <td class="hidden-xs hidden-sm">{{ $gh['phgh']['filled'] }}</td>
                                        <td class="hidden-xs hidden-sm">{{ $gh['status_name'] }}</td>
                                        <td class="hidden-xs hidden-sm center">-</td>
                                        <td class="hidden-lg">
                                            <strong>{{ trans('gh.date') }} : </strong>{{ $gh['time_start'] }}<br>
                                            <strong>{{ trans('gh.xsgh') }} : </strong>{{ $gh['value_in_btc'] }}<br>
                                            <strong>{{ trans('gh.filled') }} : </strong>0<br>
                                            <strong>{{ trans('gh.status') }} : </strong>{{ $gh['status_name'] }}<br>
                                            <strong>{{ trans('gh.queue') }} : </strong>-
                                        </td>
                                        <td class="center">-</td>
                                    </tr>
                                    <tr class="toggletableclass class{{ $gh['id'] }}">
                                        <td colspan="10">

                                            <table class="table table-striped mb-none">
                                                <thead>
                                                <tr>
                                                    <td>{{ trans('gh.assigneddate') }}</td>
                                                    <td>{{ trans('gh.value') }} <span class="fa fa-bitcoin">TC</td>
                                                    <td>{{ trans('gh.status') }}</td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if (count($gh['phgh']['data']))
                                                    @foreach ($gh['phgh']['data'] as $phgh)
                                                        <tr>
                                                            <td>{{ $phgh['created_at'] }}</td>
                                                            <td>{{ $phgh['value_in_btc'] }}</td>
                                                            <td>{{ $phgh['status_name'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td class="center" colspan="4">none</td>
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="odd gradeX">
                                    <td class="center" colspan="7">none</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if ($user_details['id_verify_status'] != 13 && $user_details['selfie_verify_status'] != 13)
            @if ($total_gh_active['balance'] > 0)
                <div class="modal-block modal-block-primary mfp-hide" id="GHModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <form>

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">{{ trans('gh.insertamounttogh') }}</h4>
                                </div>

                                <div class="modal-body">

                                    <div>{{ trans('gh.umaygethelp') }} <span class="fa fa-bitcoin"></span>TC 0.1 {{ trans('gh.upto') }} <span class="fa fa-bitcoin"></span>TC 30<br><br></div>

                                    <div class="form-horizontal form-bordered">

                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><strong>{{ trans('gh.ghallowed') }}</strong></label>
                                            <div class="col-md-6">
                                                <label class="control-label -align-left"><span class="fa fa-bitcoin"></span>{{ $total_gh_active['balance'] }}</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><strong>{{ trans('gh.ghfrom') }}</strong></label>
                                            <div class="col-md-6">
                                                <label class="control-label"><input name="from" id="from" type="radio" value="shares" checked> {{ trans('gh.brshares') }}</label>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><strong>{{ trans('gh.amnttogh') }}</strong></label>
                                            <div class="col-md-6">
                                                <div class="input-group btn-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-bitcoin"></i>
                                        </span>
                                                    <select class="form-control" id="value_in_btc">
                                                        @if ($total_gh_active['balance'] >= 0.01)
                                                            <option value="0.01000000">0.01000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 0.02)
                                                            <option value="0.02000000">0.02000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 0.03)
                                                            <option value="0.03000000">0.03000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 0.04)
                                                            <option value="0.04000000">0.04000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 0.05)
                                                            <option value="0.05000000">0.05000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 0.1)
                                                            <option value="0.10000000">0.10000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 0.2)
                                                            <option value="0.20000000">0.20000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 0.3)
                                                            <option value="0.30000000">0.30000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 0.4)
                                                            <option value="0.40000000">0.40000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 0.5)
                                                            <option value="0.50000000">0.50000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 1)
                                                            <option value="1.00000000">1.00000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 2)
                                                            <option value="2.00000000">2.00000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 3)
                                                            <option value="3.00000000">3.00000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 4)
                                                            <option value="4.00000000">4.00000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 5)
                                                            <option value="5.00000000">5.00000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 10)
                                                            <option value="10.00000000">10.00000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 15)
                                                            <option value="15.00000000">15.00000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 20)
                                                            <option value="20.00000000">20.00000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 25)
                                                            <option value="25.00000000">25.00000000</option>
                                                        @endif
                                                        @if ($total_gh_active['balance'] >= 30)
                                                            <option value="30.00000000">30.00000000</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>



                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default modal-dismiss">{{ trans('gh.cancel') }}</button>
                                    <a href="#" class="btn btn-primary modal-dismiss" data-toggle="modal" data-target="#submitGHModal">{{ trans('gh.newgh') }}</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            @endif
            @endif

            <div class="modal fade" id="submitGHModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">{{ trans('gh.urabouttogh') }}</h4>
                        </div>
                        <div class="modal-body">
                            {{ trans('gh.byagreetoaccept') }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('gh.iwilldecidelater') }}</button>
                            <a href="{{URL::route('get-help')}}" class="btn btn-primary" id="get_help">{{ trans('gh.confirm') }}</a>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <div class="modal-block modal-block-primary mfp-hide" id="CancelGHModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form>

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Cancel Get Help (GH)</h4>
                            </div>

                            <div class="modal-body">

                                <div>You are about to cancel your Get Help (GH)<br><br></div>

                                <div class="form-horizontal form-bordered">


                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Get Help Amount</strong></label>
                                        <div class="col-md-6">
                                            <label class="control-label -align-left" id="cancel_gh_value"><span class="fa fa-bitcoin"></span>15.00000000</label>
                                        </div>
                                    </div>

                                    <br>
                                </div>

                                <div class="alert alert-danger">
                                    <ul>
                                        <li>
                                            Are you sure want to cancel this Get Help (GH) ?
                                        </li>
                                        <li>
                                            Your passport will not be refunded.
                                        </li>
                                        <li>
                                            This action can't be reversed.
                                        </li>
                                    </ul>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default modal-dismiss">Cancel</button>
                                <a href="#" class="btn btn-primary" id="cancel_gh_link">Confirm Cancel GH</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>

<script>
    var from = "bitcoin";
    var value_in_btc;
    var secret;

    $(document).ready(function() {
        value_in_btc = $('#value_in_btc').val();

        update_get_help()
    });

    $(':radio[name="from"]').change(function() {
        from = this.value;
        value_in_btc = $('#value_in_btc').val();

        update_get_help();
    });

    $('#value_in_btc').change(function(){
        value_in_btc = $('#value_in_btc').val();

        update_get_help();
    });

    function update_get_help()
    {
        secret = "{{ \App\Classes\BitcoinWalletClass::generateSecret() }}";
        $('#get_help').attr('href', '{{ URL::to('/') }}/members/gh/' + from + "/" + value_in_btc + "/" + secret);
    }

    $('.cancel_gh').click(function(e) {
        var gh_id = $(this).attr("data-id");
        var gh_value = $(this).attr("data-value");
        var secret = $(this).attr("data-secret");
        $('#cancel_gh_value').html('<span class="fa fa-bitcoin"></span> '+gh_value);
        $('#cancel_gh_link').attr('href', '{{ URL::to('/') }}/members/gh-cancel/' + gh_id + "/" + secret);
    });

    $('.modal-with-form').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',
        modal: true,

        // When elemened is focused, some mobile browsers in some cases zoom in
        // It looks not nice, so we disable it:
        callbacks: {
            beforeOpen: function() {
                if($(window).width() < 700) {
                    this.st.focus = false;
                } else {
                    this.st.focus = '#name';
                }
            }
        }
    });

    $('.modal-cancel-gh').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',
        modal: true,

        // When elemened is focused, some mobile browsers in some cases zoom in
        // It looks not nice, so we disable it:
        callbacks: {
            beforeOpen: function() {
                if($(window).width() < 700) {
                    this.st.focus = false;
                } else {
                    this.st.focus = '#name';
                }
            }
        }
    });

    $(document).on('click', '.modal-dismiss', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });

    $(document).on('click', '.close', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });

    $('.moreinfo').click(function(e) {

        if($(e.target).is('.modal-convert')|| $(e.target).is('.cancel_gh') ){
            e.preventDefault();
            return;
        }
        var dtarget = $(this).attr('data-target');
        var idx = dtarget.replace(".class", "");
        var check = $('span.morecontent',this).attr('class');

        if (check.indexOf('fa-plus-square-o') > -1) {
            $('.class' + idx).html("<td align='center' colspan='10'>Loading ...</td>");
            var loadUrl = '{{ URL::to('/') }}/members/get-help-ajax/' + idx;
            $.ajax({
                url: loadUrl, success: function (result) {
                    $('.class' + idx).html(result);
                }
            });
        }

        $(dtarget).toggle();
        $('span.morecontent',this).toggleClass("fa-minus-square-o fa-plus-square-o");
    });
</script>
<!-- /#page-wrapper -->

@Stop