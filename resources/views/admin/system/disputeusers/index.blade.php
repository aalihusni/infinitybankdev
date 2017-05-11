@extends('layout.admin')

@section('title'){{trans('member.home')}} @Stop


@section('user-class')active open @Stop
@section('disputes')active @Stop

@section('extend-css')
  <link rel="stylesheet" href="{{asset('assets/examples/css/forms/layouts.css')}}">
@endsection 

@section('content')

<div class="page animsition">
    <div class="page-header">
      <h1 class="page-title"><i class="fa fa-cogs"></i> Users :: Disputes
      </h1>
    </div>
    <div class="page-content container-fluid">
      <div class="row">
        <div class="col-sm-12">
        
        
        <!-- check whether success or not -->
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <b>Success!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>Fail!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
    @endif
          <!-- Language List -->
          <div class="panel">
            <div class="panel-body">
            <div class="col-sm-12 pull-right">
                              <button class="btn btn-primary pull-right" data-value="" data-target="#langAddEditModal" data-toggle="modal"
                               type="button" title="Add New"><i class="fa fa-plus"></i></button>
                            </div>
              <table class="table">
                            <thead>
                            
                            <tr>
                                <th>Complain By</th>
                               <th>Complain To</th>
                                <th>Created At</td>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            
                            
                            </thead>
                            <tbody>
                                    @foreach($lists as $list)
                                        <tr>
                                            <td>{{ $list->byAlias }} , {{ $list->complain_by }}, {{ $list->byCode }}<br>
                                            	Status : <span class="badge badge-{{($list->statusBy)?'warning':'success'}}">{{($list->statusBy)?'Suspended':'Active'}}</span>   </td>
                                             <td>{{ $list->toAlias }},{{ $list->complain_to }}, {{ $list->toCode }},<br>
                                            	Status : <span class="badge badge-{{($list->statusTo)?'warning':'success'}}">{{($list->statusTo)?'Suspended':'Active'}}</span></td>
                                            <td>{{ $list->created_at }}</td>
                                            <td>@if($list->status==2) Closed @endif @if($list->status==0) Pending @endif @if($list->status==1) Waiting Confirmation @endif</td>
                                            <td><button class="btn btn-icon btn-warning btn-round waves-effect waves-round waves-light btn-sm" type="button" data-value="{{$list->id}}" data-target="#viewLogsModal" data-toggle="modal">
                                             <i class="fa fa-eye" aria-hidden="true"></i></button>
                                             
                                             @if($list->status <> 2)
                                             <button data-value="{{$list->id}}" data-whatever="Update Dispute User's Status" class="btn btn-icon btn-warning btn-round waves-effect waves-round waves-light btn-sm" 
                                            data-target="#updateDisputeModal" data-toggle="modal" type="button">
                                             <i class="fa-pencil-square-o" aria-hidden="true"></i></button>
                                             @endif
                                             </td>
                                           
                                            
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                        
                        
                         
            </div>
          </div>
          <!-- End Example Iconified Tabs -->
          
          
        </div>
        
      </div>
    </div>
  </div>
  
  
  
   
<!-- Modal -->
                  
                  <div class="modal fade modal-just-me" id="langAddEditModal" aria-hidden="true"
                  aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title">Manage Dispute :: ADD NEW</h4>
                        </div>
                        {!!Form::open(array('route' => 'admin-user-dispute-post','id'=>'disputeForm','method'=>'POST','class'=>"form-horizontal",'autocomplete'=>"off"))!!}
                        <div class="modal-body">
                    <div class="form-group form-material row">
                      <div class="col-sm-12">
                        <label for="complain_by" class="control-label">Complain By (Enter the User's ID)</label>
                        <input type="text" autocomplete="off" placeholder="Enter the User's ID Who sent a complain" name="complain_by" id="complain_by" class="form-control">
                      </div>
                    </div>
                    
                    <div class="form-group form-material row">
                      <div class="col-sm-12">
                        <label for="complain_to" class="control-label">Complain To (Enter the User's ID) <span class="badge badge-warning">Note : This user will be suspended after submit.</span></label>
                        <input type="text" autocomplete="off" placeholder="Enter the User's ID you want to complain" name="complain_to" id="complain_to" class="form-control">
                      </div>
                    </div>
                    
                    <div class="form-group form-material row">
                      <div class="col-sm-12">
                        <label for="amount" class="control-label">Amount to return</label>
                        <input type="text" autocomplete="off" placeholder="Enter Amount To Return" name="amount" id="amount" class="form-control">
                      </div>
                    </div>
                    
                     <div class="form-group form-material row">
                      <div class="col-sm-12">
                        <label for="description" class="control-label">Description</label>
                        <input type="text" autocomplete="off" placeholder="Enter short description" name="description" id="description" class="form-control">
                      </div>
                    </div>
                    
                     <input type="hidden" name="custom-err" id="custom-err" class="form-control">
                 
                        </div>
                        <div class="modal-footer">
                        
                       
                        
                        <span class="loading hide"><img src="{{ asset('remark/images/loader/ajax-loader.gif') }}" /></span>
                        <span class="btn-area">
                          <button type="button" class="btn btn-default btn-pure margin-0" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save changes</button>
                          </span>
                          
                          <div class="alert alert-success hide" role="alert">
				        				<i class="fa fa-info pull-right"></i>
				         				<span></span>
				       				</div>
                          
                        </div>
                         {!!form::close()!!}
                      </div>
                    </div>
                  </div>
                  
                  
                  
                  
                  <!-- End Modal -->>
                  
                  <!-- LOGS -->
                  <div class="modal fade modal-just-me" id="viewLogsModal" aria-hidden="true"
                  aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title">Disputes Detail</h4>
                        </div>
                        <div class="modal-body p-t-0">
                        ddd
                        </div>
                        
                      </div>
                    </div>
                  </div>
                  <!-- LOGS -->
                  
                  
                  <!-- EDIT -->
                  <div class="modal fade modal-just-me" id="updateDisputeModal" aria-hidden="true"
                  aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title">Disputes Detail</h4>
                        </div>
                        <div class="modal-body p-t-0">
                        ddd
                        </div>
                        
                      </div>
                    </div>
                  </div>
                  <!-- EDIT -->
 @section('extend-js')
   <script>
 var disputeForm = $("#disputeForm");
 $("#disputeForm").on("submit", function(e){
	FormResponse('processing','','disputeForm');
   $.ajax({
       type: 'post',
       url: disputeForm.attr('action'),
       data: disputeForm.serialize(),
       dataType: 'json',
       success: function (data) {
       	if (data.response == 1)
       	{
           	FormResponse('success',data,'disputeForm');
           	 setInterval(function(){ location.reload() }, 3000);
       	}
           else
           	FormResponse('failed',data,'disputeForm');
       }
   });
   
   return false;
}); 


 $('#viewLogsModal').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget)
	  var dispute_id = button.data('value')
	  var modal = $(this)
	  $.ajax({
	        type: 'get',
	        url: "{{url('admin/dispute/detail')}}/"+dispute_id,
	        dataType: 'html',
	        success: function (data) {
	        	modal.find('.modal-body').html(data);
	        }
	  });
	})
	
	
	$('#updateDisputeModal').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget)
	  var dispute_id = button.data('value')
	  var modal = $(this)
	  $.ajax({
	        type: 'get',
	        url: "{{url('admin/dispute/update')}}/"+dispute_id,
	        dataType: 'html',
	        success: function (data) {
	        	modal.find('.modal-body').html(data);
	        }
	  });
	})
</script>
 @endsection

@Stop