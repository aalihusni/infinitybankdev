<div class="modal-block modal-block-primary" id="PassportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">{{trans('passport.passport_required')}}</h4>
                </div>

                <div class="modal-body">

                    <div class="alert alert-danger">
                        <span class="fa fa-exclamation-triangle fa-5x pull-left" style="color:#a94442;"></span>
                        <p><strong>{{trans('passport.action_not_allowed')}}</strong></p>
                        {{trans('passport.pls_purchase_passport')}}
                    </div>



                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default modal-dismiss">{{trans('passport.cancel')}}</button>
                    <a href="{{URL::route('passport')}}" class="btn btn-primary">{{trans('passport.purchase_passport')}}</a>
                </div>

            </form>
        </div>
    </div>
</div>