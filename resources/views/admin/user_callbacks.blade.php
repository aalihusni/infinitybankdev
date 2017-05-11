<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Callback</h1>
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
                        <th>Attempt</th>
                        <th>Notification Type</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($callbacks as $callback)
                        <tr class="odd gradeX">
                            <td>{{ $callback->created_at }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $callback->created_at)->addHours(4) }}</td>
                            <td>{{ $callback->bitcoin_wallet_receiving_id}}</td>
                            <td>{{ $callback->user_id }}</td>
                            <td>{{ $callback->sender_user_id }}</td>
                            <td>{{ $callback->payment_type }}</td>
                            <td>{{ $callback->payment_specific }}</td>
                            <td>{{ $callback->value_in_btc }}</td>
                            <td>{{ $callback->receiving_address }}</td>
                            <td>{{ $callback->confirmations }}</td>
                            <td>{{ $callback->notification_delivery_attempt }}</td>
                            <td>{{ $callback->notification_type }}</td>
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
