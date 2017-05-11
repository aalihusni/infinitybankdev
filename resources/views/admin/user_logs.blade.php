<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Logs</h1>
            </div>
            <div class="panel-body" >
                <table class="table table-striped table-bordered table-hover" id="dataTables-share">
                    <thead>
                    <tr>
                        <th>Date/Time</th>
                        <th>Title</th>
                        <th>From</th>
                        <th>To</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($logs as $log)
                        <tr class="odd gradeX">
                            <td>{{ $log->created_at }}</td>
                            <td>{{ $log->title }}</td>
                            <td>{{ $log->from }}</td>
                            <td>{{ $log->to }}</td>
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
