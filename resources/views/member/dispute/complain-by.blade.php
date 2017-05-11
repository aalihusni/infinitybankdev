<p>We are waiting for your confirmation for your complain regarding returning {{$DisputeDetail->amount}} BTC from the Member Below<br>
               	</p>
               	
               	
               	<div class="panel panel-yellow">
                    <div class="panel-footer">
                        <span class="pull-left">Wallet Address</span>
                        <span class="pull-right"><strong>{{$SuspensionDetail['ComplainDetailUser']->wallet_address}}</strong></span>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left">Amount to return</span>
                        <span class="pull-right"><strong>{{$DisputeDetail->amount}} BTC</strong></span>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left">Member Detail</span>
                        <span class="pull-right"><strong> {{$SuspensionDetail['ComplainDetailUser']->alias}}</strong></span>
                        <div class="clearfix"></div>
                    </div>
                </div>
              
              
              @if (count($errors) > 0)
					    <div class="alert alert-danger">
					        <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					@endif
              
              {!!Form::open(array('route' => 'dispute-post-update-complainBY','id'=>'disputeForm','method'=>'POST','class'=>"form-horizontal form-bordered",'autocomplete'=>"off"))!!}
	               	 <input type="hidden" name="dispute_id" value="{{$DisputeDetail->id}}"/>
	                        <div class="panel-body">
	                           
	                           @foreach($logs as $log)
	                           <div class="form-group">
	                                <label class="col-md-3 control-label" for="inputDefault">Transaction Link</label>
	                                <div class="col-md-4"><div class="input-group">
	                                     <input type="text" value="{{$log->transaction_link}}" class="form-control" readonly>
                    <span class="input-group-btn">
                      <a href="{{$log->transaction_link}}" target="__blank" class="btn btn-primary waves-effect waves-light" type="button">Go!</a>
                    </span></div>
	                                </div>
	                            </div> 	
	                            @endforeach
	                                                      
	                           
	                           <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault">Did you receive the amount ?</label>
                                <div class="col-md-6">
                                    <label class="control-label"><input name="response" type="radio" value="Yes"> Yes</label> &nbsp;&nbsp;
                                    <label class="control-label"><input name="response" type="radio" value="No"> Not Yet</label>
                                </div>
                            </div>
                            
                            <div class="form-group">
	                                <label class="col-md-3 control-label" for="inputDefault">Note (Optional)</label>
	                                <div class="col-md-6">
	                                    <input class="form-control" name="description" id="description" placeholder="Write short detail" type="text" value="{{old('description')}}">
	                                </div>
	                            </div>
	                           
	                           
	                            <div class="form-group">
	                                <label class="col-md-3 control-label" for="inputDefault"></label>
	                                <div class="col-md-4">
	                                    <input class="btn btn-primary btn-block" type="submit" value="Paid">
	                                </div>
	                            </div>
	                        </div>
	               {!!form::close()!!}