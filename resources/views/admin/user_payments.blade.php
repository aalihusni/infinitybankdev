<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">PAGB History</h1>
            </div>
            <div class="panel-body" >
                <table class="table table-striped table-bordered table-hover" id="dataTables-share">
                    <thead>
                    <tr>
                        <th>Date/Time</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Type</th>
                        <th>User Class</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payments as $payment)
                        <tr class="odd gradeX">
                            <td>{{ $payment->created_at }}</td>
                            <td>{{ $payment->sender_user_id }}</td>
                            <td>{{ $payment->user_id }}</td>
                            <td>{{ $payment->type }}</td>
                            <td>{{ $payment->new_user_class }}</td>
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
