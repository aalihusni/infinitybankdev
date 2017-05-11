@extends('admin.default')

@section('title'){{trans('member.emails')}} @Stop
@section('homeclass')nav-active @Stop
@section('content')
 <link href="{{asset('helpdesk/css/style.css')}}" rel="stylesheet" type="text/css" />
        <!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
        <div class="col-lg-12">
            <h2 class="pb-lg">Tickets <span class="pull-right"><small><a href="{{url('admin/manage/helptopicroles')}}">Manage</a></small> , <small>Welcome <strong>{{$manager}}</strong></small></span></h2>
               
            </div>

            <div class="col-lg-12">
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
					        <b>Alert!</b> Failed.
					        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					        {{Session::get('fails')}}
					    </div>
				    @endif
                
                <div>
                    <!-- /.panel-heading -->
                    <div>
                    
                    <div class="btn-group pull-right">
                    
                    
                     <select class='form-control pull-left' style="width:120px;margin-right:10px;" id="MGR_ID">
		                    @if($secondDrop)
			                    <option value="All" {{($secondDrop=='All')?'selected':''}}>All</option>
			                    <!-- <option value="Unassigned" {{($secondDrop=='Unassigned')?'selected':''}}>Unassigned</option>  -->
			                @else  
			                	<option value="All">All</option>
			                   <!-- <option value="Unassigned">Unassigned</option>    --> 
		                    @endif
		                    
		                    @foreach($managers as $mgr)
		                     @if($secondDrop)
		                    	<option value="{{$mgr->manager_code}}">{{$mgr->manager_code}}</option>
		                    	@else
		                    	<option value="{{$mgr->manager_code}}" {{($manager==$mgr->manager_code)?'selected':''}}>{{$mgr->manager_code}}</option>
		                    @endif
		                    @endforeach
		                   
                    </select>
                    
                    <select class='form-control pull-left' style="width:150px;margin-right:10px;" id="FILTER_CATEGORY">
		                    @if(empty($firstDrop))
		                    	<option value="BLANK" selected></option>
		                    	<option value="AssignedTo">Assigned To Me</option>
			                    @foreach($helptopic as $hTopic)
			                    <option value="{{$hTopic->id}}">{{$hTopic->topic}}</option>
			                    @endforeach
			                  @else  
			                  
			                  <option value="BLANK" {{($firstDrop=='BLANK')?'selected':''}}></option>
		                    	<option value="AssignedTo" {{($firstDrop=='AssignedTo')?'selected':''}}>Assigned To Me</option>
			                    @foreach($helptopic as $hTopic)
			                    <option value="{{$hTopic->id}}" {{($firstDrop==$hTopic->id)?'selected':''}}>{{$hTopic->topic}}</option>
			                    @endforeach
			                  
		                    @endif
		                    
		                    
                    </select>
                    
                   
                    
                    <a class="btn btn-{{($tktStatus=='Open')?'info':'default'}}" type="button" href="{{URL::route('admin-tickets',['Open'])}}" >{!! Lang::get('helpdesk.open') !!} <span class="badge">{{$ticket->countTicket(['status'=>['1']])}}</span></a>
                    <!-- <a class="btn btn-default" type="button" href="{{ url('/ticket/answered') }}" >{!! Lang::get('helpdesk.answered') !!}</a>-->
                    <a class="btn btn-{{($tktStatus=='Closed')?'info':'default'}}" type="button" href="{{URL::route('admin-tickets',['Closed'])}}" >{!! Lang::get('helpdesk.closed') !!} <span class="badge">{{$ticket->countTicket(['status'=>['2,3']])}}</span></a>  
                   <a class="btn btn-{{($tktStatus=='Unassigned')?'info':'default'}}" type="button" href="{{URL::route('admin-tickets',['Unassigned'])}}" >Unassigned Topic<span class="badge">{{$ticket->countTicket(['Unassigned'=>'NULL'])}}</span></a>
               	<!-- 
                <a class="btn btn-{{($tktStatus=='Surrendered')?'info':'default'}}" type="button" href="{{URL::route('admin-tickets',['Surrendered'])}}" >Surrender <span class="badge">{{$ticket->countSurrender(['status'=>['0']])}}</span></a> 
               
                <a class="btn btn-{{($tktStatus=='Trashed')?'info':'default'}}" type="button" href="{{URL::route('admin-tickets',['Trashed'])}}" >Trashed <span class="badge">{{$ticket->countTicket(['status'=>['5']])}}</span></a>  
                    -->
                   
												    
												    
												    
												</div>
                       
                       
                       
                        <!-- Nav tabs -->
                        
                        

                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#home" data-toggle="tab">{{$tktStatus}} <small class="label bg-primary">{!! $renderOpenList->total() !!}</small></a>
                            </li>
                            
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="home">
                            {!! Form::open(['route'=>'select_all','method'=>'post']) !!}
                            <div class="mailbox-controls p-t-20">
            <!-- Check all button -->
            <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
            @if($tktStatus!='Closed')
            <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="Close">
            @endif
            
            @if($tktStatus!='Open')
            <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="Open">
            @endif
            
            @if($tktStatus!='Trashed')
            <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="Delete">
            @endif
            <div class="pull-right" id="refresh21">
               Showing {{($renderOpenList->currentpage()-1)*$renderOpenList->perpage()+1}} to 
                                                                        {{($renderOpenList->currentpage()-1)*$renderOpenList->perpage()+count($renderOpenList)}}
                                                                        of  {{$renderOpenList->total()}} entries
            </div>
        </div>
        
        <!-- SEARCH -->
        <div class="form-group p-t-10">
		      <div class="col-sm-2">
			      <select id="filter_type" name="filter_type" class="form-control">
			      <option value="">--Select Option--</option>
	               <option value="id">User ID</option>
	                <option value="email">Email</option>
	                <option value="country_code">Country Code</option>
	                 <option value="alias">Alias</option>
	                 <option value="ticket_number">Ticket ID</option>
	               </select>
              </div>
		      <div class="col-sm-2">
		        <input type="text" name="filter-text" class="form-control" id="filter-text" placeholder="Enter Search Text">
		      </div>
		      
		      <div class="col-sm-2">
		        <input type="text" name="date-from" class="form-control" id="date-from" placeholder="Date From ( Y-m-d )">
		      </div>
		      <div class="col-sm-2">
		        <input type="text" name="date-from" class="form-control" id="date-to" placeholder="Date To ( Y-m-d )">
		      </div>
		      <div class="col-sm-2">
		       <select id="replier" name="replier" class="form-control">
		       <option value="">--Reply By--</option>
	               <option value="N">N</option>
	                <option value="D">D</option>
	                <option value="F">F</option>
                   <option value="F">L</option>
	               </select>
		      </div>
		        <button class="btn btn-default pull-right" type="button" id="filterBtn"> <span class="badge">GO</span></button>  
   		 </div>
        <!-- SEARCH -->
        <p style="text-align:center; position:fixed; margin-left:37%;margin-top:-50px;" id="show1" class="text-warning hide"><b>Loading...</b></p>
                                <div class="dataTable_wrapper mailbox-messages" style="padding-top:30px;" id="refresh1">
                                 
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-member">
                                        <thead>
               <th></th>
                <th>
                    {!! Lang::get('helpdesk.subject') !!}
                </th>
                <th>
                    {!! Lang::get('helpdesk.ticket_id') !!}
                </th>
                <th>
                    {!! Lang::get('helpdesk.priority') !!}
                </th>
                <th>
                    {!! Lang::get('helpdesk.from') !!}
                </th>
                <th>
                    {!! Lang::get('helpdesk.last_replier') !!}
                </th>
                <th>
                    Assigned To
                </th>
                <th>
                    {!! Lang::get('helpdesk.last_activity') !!}
                </th>
                <style>
                    .phghtick {
                        background-color:#FEF2EF !important;
                    }
                    .passporttick {
                        background-color:#F2FEEF !important;
                    }
                    .networktick {
                        background-color:#EFF4FE !important;
                    }
                    .boldthetext {
                        font-weight:bold;
                    }
                </style>
                </thead>
                        <tbody id="hello">
                     @foreach ($open  as $ticket )
                         <?php
                         
                         if($ticket->lastreplier == 'Support Team')
                         {
                             $boldthetext = '';
                         }
                         else
                          {
                            $boldthetext = 'boldthetext';
                          }
                         ?>
                    <tr class="<?=$ticket->css_class?> <?=$boldthetext?>" style="color:green;" >
                    <td><input type="checkbox" class="icheckbox_flat-blue" name="select_all[]" value="{{$ticket->id}}"/></td>
                     
                        <td class="mailbox-name"><a href="{!! URL('Admin/Ticket/Detail',[Crypt::encrypt($ticket->id)]) !!}" title="{!! $ticket->title !!}">
                        {{$ticket->tktTitle}} </a> ({!! $ticket->count!!}) <i class="fa fa-comment"></i> (<span class="text-warning"><small><span id="topic_{{$ticket->id}}">{{$ticket->topic}}</span></small></span>
                        <span class="fa fa-pencil-square-o update-topic" aria-hidden="true" title="Click To Edit Help Topic" 
                        data-value="{{$ticket->id}}" data-title="{{$ticket->tktTitle}}" data-topic="{{$ticket->topic}}"></span>
                        )
                        </td>
                        <td class="mailbox-Id">#{!! $ticket->ticket_number !!}</td>
                        <td class="mailbox-priority"><spam class="btn btn-{{$ticket->priority_color}} btn-xs">{{$ticket->priority}}</spam>
                        @if($ticket->system_status)<spam class="btn btn-danger btn-xs" title="Pending"><i class="fa fa-bell" aria-hidden="true"></i></spam>@endif
                        </td>
                        <td class="mailbox-last-reply">{!! $ticket->from !!} <span class="badge">{{$ticket->country_code}}</span></td>
                		<td class="mailbox-last-reply" style="color: {!! $ticket->rep !!}">{!! $ticket->lastreplier !!} 
                				 <span class="text-danger"> ( {{$ticket->replier}} )</span> 
                		</td>
                		<td class="mailbox-date">
                		@if($ticket->assigned_to)
                		{!! $ticket->assignTo !!}
                		@else
                		<span style="color:red;"></span>
                		@endif
                		</td>
                		<td class="mailbox-last-activity">{!! $ticket->last_updated_at !!}</td>
                		</tr>
                @endforeach
                </tbody>                
                                        
                                    </table>
                                    
                                    {!! str_replace('/?','?', $renderOpenList->render()) !!} 
                                    
                                </div>
                                {!! Form::close() !!}
                            </div>
                            
                            
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>

        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
</div>
</div>
</div>


<!-- MODAL DELETE -->
<div class="modal fade" id="tktUpateTopicModal" tabindex="-1" role="dialog" aria-labelledby="tktUpateTopicModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="tktTopicUpdateLabel">Update Ticket Help Topic</h4>
      </div>
      <div class="modal-body">
      
        <form action="{{ URL::route('admin-update-user-ticket-topic') }}" method="post" id="update-topic-form">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="updateTicketID" value="" id="updateTicketID">
		  <div class="form-group">
		    <label for="exampleSelect1">Select The Help Topic</label>
		    <select class="form-control" name="topicID" id="topicID">
		      @foreach($helptopic as $topic)
			      @if($topic->status == 1)
			      	<option value="{{$topic->id}}">{{$topic->topic}}</option>
			      @endif
		      @endforeach
		    </select>
		  </div>
		  
		  <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
		</form>
      </div>
      
    </div>
  </div>
</div>
<!-- MODAL DELETE -->
<meta name="csrf-token" content="{{ csrf_token() }}" />
 <script src="{{asset('helpdesk/js/functions.js')}}"></script> 
<script>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$("#update-topic-form").on("submit", function(e){
	FormResponse('processing','','update-topic-form');
    $.ajax({
        type: 'post',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function (data) { 
            	$('#topic_'+data.ticketID+'').html(data.topic);
            	$('#tktUpateTopicModal').modal('hide'); 
        }
    });
    return false;
    
});

$('#MGR_ID').change(function(){
	
	var manager = $(this).val();
	var firstVal = $('#FILTER_CATEGORY').val();
	$.ajax({
		 type: "GET",
        url: "{{url('admin/ticket/filterManager')}}",
        data:{manager,manager},
        dataType: "json",
        beforeSend: function() {
       	 $('#show1').removeClass('hide');
        },
        success: function(response) {
       	 	if(response.data)
       	 	{
       	 		
           	 	//location.reload();
       	        window.location.assign("{{url('admin/ticket/filterByCategory')}}?optionValue="+firstVal+'&secondDrop='+response.optionValue+'&tktStatus={{$tktStatus}}')
       	 	}
        }
			
	});
});


$('#FILTER_CATEGORY').change(function(){
	var optionValue = $(this).val();
	//if(optionValue=='BLANK')
		//return false;
	var secondDrop = $('#MGR_ID').val();

	window.location.assign("{{url('admin/ticket/filterByCategory')}}?optionValue="+optionValue+'&secondDrop='+secondDrop+'&tktStatus={{$tktStatus}}')
	/*
	$.ajax({
		 type: "GET",
        url: "{{url('admin/ticket/filterByCategory')}}",
        data:{optionValue:optionValue,secondDrop:secondDrop},
        dataType: "json",
        beforeSend: function() {
       	 $('#show1').removeClass('hide');
        },
        success: function(response) {
       	 	if(response.data)
           	 	location.reload();
        }
	}); */
});



$(function () {
    //Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
      var clicks = $(this).data('clicks');
      if (clicks) {
        //Uncheck all checkboxes
       // $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
        $(':checkbox').each(function() {
            this.checked = false;
        })
        $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
      } else {
    	  $(':checkbox').each(function() {
              this.checked = true;
          })
        //Check all checkboxes
       // $(".mailbox-messages input[type='checkbox']").iCheck("check");  //fa fa-square-o
        $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
      }          
      $(this).data("clicks", !clicks);
    });
  });

$('.update-topic').click(function(){
	var tktID = $(this).attr('data-value');
	$('#updateTicketID').val(tktID);
	var tktTitle = $(this).attr('data-title');
	$('#tktTopicUpdateLabel').html('Ticket Subject : '+tktTitle);
	var tktTopic = $(this).attr('data-topic');
	$('select#topicID option').each(function () {
		if ($(this).text().toLowerCase() == tktTopic.toLowerCase()) {
		    $(this).prop('selected','selected');
		    return;
		}});
	$('#tktUpateTopicModal').modal('show'); 
});

$('#filterBtn').click(function(){

	var Category = $('#FILTER_CATEGORY').val();
	var MgrCode = $('#MGR_ID').val();

	
	
	var filter_type 	= $('#filter_type').val();
	var filter_text 	= $('#filter-text').val();
	var filter_datefrom = $('#date-from').val();
	var filter_dateto 	= $('#date-to').val();
	var filter_replier 	= $('#replier').val();
	var ticket_status = '{{$tktStatus}}';
	$.ajax({
		 type: "GET",
         url: "{{url('admin/ticket/filter')}}",
         data:{filter_type,filter_text,filter_datefrom,filter_dateto,filter_replier,ticket_status,MgrCode:MgrCode,Category:Category},
         dataType: "html",
         beforeSend: function() {
        	 $('#show1').removeClass('hide');
         },
         success: function(response) {
        	 $('#refresh1').html(response);
        	 $('#show1').addClass('hide');
         }
			
		});
});

</script>
@Stop