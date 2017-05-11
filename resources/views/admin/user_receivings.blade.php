<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Receiving Address</h1>
            </div>
            <div class="panel-body" >
                <table class="table table-striped table-bordered table-hover" id="dataTables-share">
                    <thead>
                    <tr>
                        <th>Server Date/Time</th>
                        <th>Blockchain Date/Time</th>
                        <th>Receiving ID</th>
                        <th>User ID</th>
                        <th>Sender User ID</th>
                        <th>Type</th>
                        <th>Specific</th>
                        <th>BTC</th>
                        <th>Address</th>
                        <th>Confirmations</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($receivings as $receiving)
                        <tr class="odd gradeX">
                            <td>{{ $receiving->created_at }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $receiving->created_at)->addHours(4) }}</td>
                            <td>{{ $receiving->id}}</td>
                            <td>{{ $receiving->user_id }}</td>
                            <td>{{ $receiving->sender_user_id }}</td>
                            <td>{{ $receiving->payment_type }}</td>
                            <td>{{ $receiving->payment_specific }}</td>
                            <td>{{ $receiving->value_in_btc }}</td>
                            <td>{{ $receiving->receiving_address }}</td>
                            <td>{{ $receiving->confirmations }}</td>
                            <td>
                                {{ $receiving->status }}
                                <a href="#" data-toggle="modal" data-target="#changeReceivingStatus" data-id="{{ $receiving->id }}" class="modal-changereceivingstatus on-default edit-row clearfix"><span class="fa fa-refresh"></span></a>
                                @if ($receiving->payment_type == "PA")
                                <a href="#" data-toggle="modal" data-target="#PAGBFix" data-id="{{ $receiving->id }}" class="modal-pagbfix on-default edit-row clearfix"><span class="fa fa-money"></span></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default modal-dismiss">Close</button>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<div class="modal fade" id="changeReceivingStatus" tabindex="3" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ URL::route('change-receiving-status') }}" class="form-horizontal form-bordered" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Reset Receiving Status for Receiving ID : <span id="theid5"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        Are you sure to reset this user receiving status ?
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input id="modalid5" type="hidden" name="id" value="">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div></div>

<div class="modal fade" id="PAGBFix" tabindex="3" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ URL::route('pagb-fix') }}" class="form-horizontal form-bordered" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Transfer Fund for Receiving ID : <span id="theid6"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        Are you sure to transfer fund this user receiving status ?
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input id="modalid6" type="hidden" name="id" value="">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div></div>

<script>
    $(".modal-changereceivingstatus").click(function(){
        var dataval = $(this).attr('data-id');
        $('#modalid5').val(dataval);
        $('#theuser5').html(dataval);
    })

    $(".modal-pagbfix").click(function(){
        var dataval = $(this).attr('data-id');
        $('#modalid6').val(dataval);
        $('#theuser6').html(dataval);
        })
</script>