<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Shares</h1>
            </div>
            <div class="panel-body" >
                <table class="table table-striped table-bordered table-hover" id="dataTables-share">
                    <thead>
                    <tr>
                        <th>Date/Time</th>
                        <th>Type</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($shares as $share)
                        <tr class="odd gradeX">
                            <td>{{ $share->created_at }}</td>
                            <td>{{ $share->shares_type }}</td>
                            <td>{{ $share->debit_value_in_btc }}</td>
                            <td>{{ $share->credit_value_in_btc }}</td>
                            <td>{{ $share->balance_value_in_btc }}</td>
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
