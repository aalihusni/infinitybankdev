<p>Please return {{$DisputeDetail->amount}} BTC to the wallet Address below.
               	 Your account will be suspended until receiver user's respond<br>
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
                
                
                
                
                @if($DisputeDetail->status==0)  
	               	<!-- STATUS 0 -->
	               	<p><span class="label label-primary mainnew">Note :</span> <strong>After completion please copy transaction link below and click <b>Paid</b></strong></p>
	               	<!-- STATUS 0 -->
	               	 
	               	 @if (count($errors) > 0)
					    <div class="alert alert-danger">
					        <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					@endif
					
					
	               	 
	               	 {!!Form::open(array('route' => 'dispute-post-update','id'=>'disputeForm','method'=>'POST','class'=>"form-horizontal form-bordered",'autocomplete'=>"off"))!!}
	               	 <input type="hidden" name="dispute_id" value="{{$DisputeDetail->id}}"/>
	                        <div class="panel-body">
	                            <div class="form-group">
	                                <label class="col-md-3 control-label" for="inputDefault">Enter Transaction Link</label>
	                                <div class="col-md-6">
	                                    <input class="form-control" name="transaction_link" id="transaction_link" placeholder="Enter the transaction link" type="text" value="{{old('transaction_link')}}">
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
	                 <!-- STATUS 0 -->
	                 @else
	                 <!-- STATUS 1 -->
	                 <p><strong>We are waiting for confirmation from user <b>{{$SuspensionDetail['ComplainDetailUser']->alias}}</b></strong>.</p>
				                 @if(session('message'))
								<div class="alert alert-success">
								        {{session('message')}}
								    </div>
								@endif
	          @endif <!-- STATUS 0 END -->
	          
	          
	         
             