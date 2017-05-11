<div class="panel">
        <div class="panel-body container-fluid">
          <div class="row row-lg">
            <div class="col-sm-6">
              <!-- Example Basic Form -->
              <div class="example-wrap">
                <h4 class="example-title">Complain By Detail</h4>
                <div class="example">
                {!!Form::open(array('route' => 'admin-dispute-post-update','id'=>'disputeForm','method'=>'POST','autocomplete'=>"off"))!!}
                <input type="hidden" value="ComplainBy" name="UpdateFor"/>
                <input type="hidden" value="{{$Detail->id}}" name="dispute_id"/>
                    <div class="form-group form-material row">
                      <div class="col-sm-12">
                        <label for="inputBasicFirstName" class="control-label">Alias , UserID , Country Code</label>
                        <input type="text" value="{{$Detail->byAlias}}, {{$Detail->complain_by}} , {{$Detail->byCode}}" autocomplete="off" name="inputFirstName" id="inputBasicFirstName" class="form-control">
                      </div>
                    </div>
                    <div class="form-group form-material">
                      <label class="control-label">Current Status</label>
                      <div>
                        <div class="radio-custom radio-default radio-inline">
                          <input type="radio" name="status_complainby" id="complainby-0" value="0" {{($Detail->statusBy=='0')?'checked':''}}>
                          <label for="complainby-0">Active</label>
                        </div>
                        <div class="radio-custom radio-default radio-inline">
                          <input type="radio" name="status_complainby" id="complainby-1" value="1" {{($Detail->statusBy)?'checked':''}}>
                          <label for="complainby-1">Suspended</label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group form-material">
                      <button class="btn btn-primary waves-effect waves-light" type="submit">Update Complain By</button>
                    </div>
                  {!!Form::close()!!}
                </div>
              </div>
              <!-- End Example Basic Form -->
            </div>
            <div class="col-sm-6">
              <!-- Example Basic Form Without Label -->
              <div class="example-wrap">
                <h4 class="example-title">Complain To Detail</h4>
                <div class="example">
                  {!!Form::open(array('route' => 'admin-dispute-post-update','id'=>'disputeForm','method'=>'POST','autocomplete'=>"off"))!!}
                <input type="hidden" value="ComplainTo" name="UpdateFor"/>
                <input type="hidden" value="{{$Detail->id}}" name="dispute_id"/>
                    <div class="form-group form-material row">
                      <div class="col-sm-12">
                        <label for="inputBasicFirstName" class="control-label">Alias , UserID , Country Code</label>
                        <input type="text" value="{{$Detail->toAlias}}, {{$Detail->complain_to}} , {{$Detail->toCode}}" autocomplete="off" name="inputFirstName" id="inputBasicFirstName" class="form-control">
                      </div>
                    </div>
                    <div class="form-group form-material">
                      <label class="control-label">Current Status</label>
                      <div>
                        <div class="radio-custom radio-default radio-inline">
                          <input type="radio" name="status_complainto" id="complainto-0" value="0" {{($Detail->statusTo=='0')?'checked':''}}>
                          <label for="complainto-0">Active</label>
                        </div>
                        <div class="radio-custom radio-default radio-inline">
                          <input type="radio" name="status_complainto" id="complainto-1" value="1" {{($Detail->statusTo)?'checked':''}}>
                          <label for="complainto-1">Suspended</label>
                        </div>
                      </div>
                    </div>
                    
                    <div class="form-group form-material">
                      <button class="btn btn-primary waves-effect waves-light" type="submit">Update Complain To</button>
                    </div>
                  {!!Form::close()!!}
                </div>
              </div>
              <!-- End Example Basic Form Without Label -->
            </div>
            <div class="clearfix hidden-xs"></div>
            <div class="col-sm-12 col-md-6">
              <!-- Example Horizontal Form -->
              <div class="example-wrap">
                <h4 class="example-title">Update Both</h4>
                <p>
                  Please check option <code>To Update</code> both user's status.
                </p>
                <div class="example">
                 {!!Form::open(array('route' => 'admin-dispute-post-update','id'=>'disputeForm','class'=>"form-horizontal", 'method'=>'POST','autocomplete'=>"off"))!!}
                <input type="hidden" value="Both" name="UpdateFor"/>
                <input type="hidden" value="{{$Detail->id}}" name="dispute_id"/>
                 
                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">Status : </label>
                      <div class="col-sm-9">
                        <div class="radio-custom radio-default radio-inline">
                          <input type="radio" name="status_both" id="input0" value="0">
                          <label for="input0">Activate Both</label>
                        </div>
                        <div class="radio-custom radio-default radio-inline">
                          <input type="radio" name="status_both" id="input1" value="0">
                          <label for="input1">Suspend Both</label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group form-material">
                      <div class="col-sm-9 col-sm-offset-3">
                        <button class="btn btn-primary waves-effect waves-light" type="submit">Update All </button>
                        <button class="btn btn-warning waves-effect waves-light" type="button" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  {!!Form::close()!!}
                </div>
              </div>
              <!-- End Example Horizontal Form -->
            </div>
          </div>
        </div>
      </div>