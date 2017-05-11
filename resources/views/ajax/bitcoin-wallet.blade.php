<div class="modal-block modal-block-primary" id="updateWallet">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Please update user wallet</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url'=>'members/ajax-update-wallet','method'=>'POST', 'class'=>'form-horizontal form-bordered')) !!}
                {!! Form::hidden('id', $cryptid) !!}
                <div class="row">
                    <div class="col-lg-1">
                        &nbsp;
                    </div>
                    <div class="col-lg-10 form-horizontal form-bordered">
                        <div class="form-group">
                            <div class="col-lg-12">
                                <p class="small">This user must have valid Bitcoin wallet address before you can upgrade for them.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label"><strong>Wallet Address</strong></label>
                            <div class="col-md-7">
                                <input id="wallet_address" name="wallet_address" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="inputDefault">&nbsp;</label>
                            <div class="col-md-7">
                                {!! Form::submit('Update Wallet Address', array('class'=>'btn btn-primary btn-block')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button class="btn btn-default modal-dismiss">Cancel</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>