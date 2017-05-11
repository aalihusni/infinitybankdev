@extends('admin.default')

@section('title'){{trans('member.emails')}} @Stop
@section('homeclass')nav-active @Stop
@section('content')
 
 <link href="{{asset('helpdesk/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet" type="text/css" /> 
 <link href="{{asset('helpdesk/css/style.css')}}" rel="stylesheet" type="text/css" />
        <!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        
        <div class="row">
            
            <div class="col-lg-12">
                <h1 class="page-header">{{$thread->title}} ( {{$tickets->ticket_number}} )</h1>
            </div>
            </div>
        <div class="row">
        
       
        
            <section class="panel panel-warning">
								<header class="panel-heading">
									<h2 class="panel-title"><i class="fa fa-user"> </i> {{$thread->title}} </h2>
								</header>
								<div class="panel-body">
								 <div class="row" style="padding:0 10px 10px 0;">
                                <!-- <button type="button" class="btn btn-default"><i class="fa fa-edit" style="color:green;"> </i> Edit</button> -->                            
                                {{-- <button type="button" class="btn btn-default"><i class="fa fa-print" style="color:blue;"> </i> {!! link_to_route('ticket.print','Print',[$tickets->id]) !!}</button> --}}
                                <!-- </div> -->
                                <div class="btn-group pull-right"> 
                                   <button type="button" class="btn btn-default hide" id="Edit_Ticket" data-toggle="modal" data-target="#Edit"><i class="fa fa-edit" style="color:green;"> </i> {!! Lang::get('helpdesk.edit') !!}</button>
            <button type="button" id="surrender_button" class="btn btn-default" data-toggle="modal" data-target="#assignModal"> <i class="fa fa-hand-o-right" style="color:red;"></i> Assign</button>
          
          <!-- Surrender Modal -->
    <div class="modal fade" id="modalSurrender">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{!! Lang::get('helpdesk.surrender') !!}</h4>
                </div>
                <div class="modal-body">
                    <p>{!! Lang::get('helpdesk.are_you_sure_you_want_to_surrender_this_ticket') !!}?</p>
                    <div class="alert alert-danger hide" id="modalSurrenderMessage">......</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis6">{!! Lang::get('helpdesk.close') !!}</button>
                    <button type="button" class="btn btn-warning pull-right" id="SurrenderBtn">{!! Lang::get('helpdesk.surrender') !!}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
          
           
                                    									
                                    
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="fa fa-exchange" style="color:teal;"> </i> 
                                        {!! Lang::get('helpdesk.change_status') !!} <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" id="open"><i class="fa fa-folder-open" style="color:#FFD600;"> </i>{!! Lang::get('helpdesk.open') !!}</a></li>
                                        <li><a href="#" id="close"><i class="fa fa-check" style="color:#15F109;"> </i>{!! Lang::get('helpdesk.close') !!}</a></li>
                                        <li><a href="#" id="pending"><i class="fa fa-check-circle " style="color:#9c27b0;"> </i> Pending (Admin Only) </a></li>
                                    </ul>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            
                            
                             <div class="row">
                                            
                                            <div class="col-md-6 col-md-offset-3 hide" id="loader">
                                                <img src="{{ asset('helpdesk/img/ajax-loader.gif') }}"><br/><br/>
                                            </div>
                                            
                                            <div class="col-md-6 col-md-offset-3 hide" id="msgDiv">
                                            <div class="alert alert-success" id="changeStatusMessage">......</div>
                                            </div>
                              </div>
                           
                            
                            <div class="row">
                                        
                                        
                                        <section class="panel" style="padding:5px;">
										<div class="panel-body bg-tertiary">
											<div class="widget-summary">
												<div class="widget-summary-col">
													<div class="col-md-2 hide"> 
														<b>{!! Lang::get('helpdesk.sla_plan') !!}: {{$SlaPlan->grace_period}} </b>
													</div>
													<div class="col-md-3"> 
														<b>{!! Lang::get('helpdesk.created_date') !!}: </b> {{ $tickets->created_at }}
													</div>
													<div class="col-md-3"> 
	                                                    <b>{!! Lang::get('helpdesk.due_date') !!}: </b> 
	                                                    <?php 
	                                                    $time = $tickets->created_at;
	                                                    $time = date_create($time);
	                                                    date_add($time, date_interval_create_from_date_string($SlaPlan->grace_period));
	                                                    echo date_format($time, 'd/m/Y H:i:s');
	                                                    ?>
	                                                </div>
	                                                <div class="col-md-4">
	                                                    <b>{!! Lang::get('helpdesk.last_response') !!}: </b> {{ $ResponseDate }} 
	                                                </div>
												</div>
												
												
											</div>
										</div>
								</section>
                                        
                                <section class="content"  id="refresh" style="margin-bottom:-10px;margin-top:-10px">
                                         
                                    <div class="col-md-4"> 
                                        <table class="table table-hover">
                                            <!-- <tr><th></th><th></th></tr> -->
                                            <tr><td><b>{!! Lang::get('helpdesk.status') !!}:</b></td>       
                                            @if($status->id == 1)
                                                <td title="{{$status->properties}}" style="color:orange">{{$status->name}}</td></tr>
                                            @elseif($status->id == 2)
                                                <td title="{{$status->properties}}" style="color:green">{{$status->name}}</td></tr>
                                            @elseif($status->id == 3)
                                                <td title="{{$status->properties}}" style="color:green">{{$status->name}}</td></tr>
                                            
                                            @elseif($status->id == 4)
                                                <td title="{{$status->properties}}" style="color:orange">{{$status->name}}</td></tr>
                                            @elseif($status->id == 5)
                                                <td title="{{$status->properties}}" style="color:red">{{$status->name}}</td></tr>
                                            @endif
                                            <tr><td><b>{!! Lang::get('helpdesk.priority') !!}:</b></td>     
                                            @if($priority->id == 1)
                                                <td title="{{$priority->priority_desc}}" style="color:green;">{{$priority->priority_desc}}</td>
                                            @elseif($priority->id == 2)
                                                <td title="{{$priority->priority_desc}}" style="color:orange;">{{$priority->priority_desc}}</td>
                                            @elseif($priority->id == 3)
                                                <td title="{{$priority->priority_desc}}" style="color:red;">{{$priority->priority_desc}}</td>
                                            @endif

                                            </tr>
                                            <tr class="hide"><td><b>{!! Lang::get('helpdesk.department') !!}:</b></td>   
                                        
                                            <td title="{{ $department->name }}">{!! $department->name !!}</td></tr>
                                            
                                            <tr><td><b>Assign To:</b></td>   
                                            <td title="">
                                            @if($tickets->assigned_to)
						                		<span style="color:orange;">{!! $assignToDetail->firstname !!} {!! $assignToDetail->lastname !!}</span>
						                		@else
						                		<span style="color:red;">Unassigned</span>
						                		@endif
                                            
                                            </td></tr>
                                            @if($tickets->system_status)
                                            <tr>
                                            <td colspan="2"><span class="btn btn-danger btn-xs" title="Pending"><i class="fa fa-bell" aria-hidden="true"></i> Pending</span>
                                            </td> </tr>   
                                            @endif
                                            
                                            <tr>
                                             <tr><td><b>User ID:</b></td> <td>{{$Creator->id}} <strong>{{$Creator->alias}} , {{$Creator->country_code}}</strong></td></tr>
                                            </td> </tr> 
                                            
                                        </table>
                                        <!-- </div> -->
                                    </div>
                                    <div class="col-md-8"> 
                                        <!-- <div class="callout callout-success"> -->
                                        <table class="table table-hover">
                                            
                                            <tr><td><b>{!! Lang::get('helpdesk.help_topic') !!}:</b></td>    
                                             <td title="{{$help_topic->topic}}"><span id="helpTopic"> {{$help_topic->topic}}</span>
                                              <button class="btn btn-default btn-sm fa fa-pencil-square-o update-topic" aria-hidden="true" title="Click To Edit Help Topic" 
                        							data-value="{{$tickets->id}}" data-title="{{$thread->title}}" data-topic="{{$help_topic->topic}}"></button>
                                             </td></tr>
                                             <tr><td><b>{!! Lang::get('helpdesk.email') !!}:</b></td>    
                                             <td title="{{$help_topic->topic}}">{{$Creator->email}} </td></tr>
                                            <tr><td><b>{!! Lang::get('helpdesk.last_message') !!}:</b></td>   <td>{{ucwords($last->poster)}}</td></tr>
                                       		<tr><td><b>{!! Lang::get('helpdesk.phone') !!}:</b></td>   
                                            <td title="{{ $department->name }}">{!! $Creator->mobile !!}</td></tr>
                                       
                                        </table>
                                    </div>
                                    
                                    
                                    <!-- </div> -->
                                </section> 
                            </div>
								</div>
							</section>
							
							
							<h4>Previous Tickets (<span class="text-info">{{$totalPrev}}</span>) <button class="btn btn-info btn-xs" onClick="$('#prev-tkts').toggle('slow');">Show/Hide</button> </h4>
							<div id="prev-tkts" style="display:none;"> 
							<table class="table table-striped table-bordered table-hover" >
                                        <thead>
               
                <th>
                    {!! Lang::get('helpdesk.subject') !!}
                </th>
                <th>
                    {!! Lang::get('helpdesk.ticket_id') !!}
                </th>
                <th>
                    Posted On
                </th>
                <th>
                    {!! Lang::get('helpdesk.last_replier') !!}
                </th>
                <th>
                    {!! Lang::get('helpdesk.last_activity') !!}
                </th>
                <th>
                    {!! Lang::get('helpdesk.status') !!}
                </th>
                </thead>
                        <tbody id="hello">
                     @foreach ($prevTkts  as $ticket )
                    <tr style="color:green;" >
                     
                        <td class="mailbox-name"><a href="{!! URL('Admin/Ticket/Detail',[Crypt::encrypt($ticket->id)]) !!}" title="{!! $ticket->title !!}">
                        {{$ticket->tktTitle}} </a> ({!! $ticket->count!!}) <i class="fa fa-comment"></i></td>
                        <td class="mailbox-Id">#{!! $ticket->ticket_number !!}</td>
                        <td class="mailbox-priority">{{$ticket->created_at}}</td>
                		<td class="mailbox-last-reply" style="color: {!! $ticket->rep !!}">{!! $ticket->lastreplier !!}</td>
                		<td class="mailbox-last-activity">{!! $ticket->last_updated_at !!}</td>
                		<td class="mailbox-date"><spam class="btn btn-{{($ticket->status==1)?'info':'success'}} btn-xs">{!! $ticket->tktstatus !!}</spam></td>
                		</tr>
                @endforeach
                </tbody>                
                                        
                                    </table></div>
							
							
							
							
							
							
							
							
							
							
							
							<section class="panel">
								<header class="panel-heading">
									<div class="panel-actions">
										<a data-panel-toggle="" class="panel-action panel-action-toggle" href="#"></a>
										<a data-panel-dismiss="" class="panel-action panel-action-dismiss" href="#"></a>
									</div>

									<h2 class="panel-title">Leave a Reply</h2>
								</header>
								<div class="panel-body">
								{!! Form::model($tickets->id, ['id'=>'form3', 'name'=>'form3' ,'method' => 'PATCH', 'enctype'=>'multipart/form-data','class'=>'form-horizontal form-bordered'] )!!}
								<input type="hidden" name="ticket_ID" value="{{$tickets->id}}">
											<div class="form-group">
												
												<div class="col-md-12 form-group">
									            <div class="col-md-2"> {!! Form::label('To', Lang::get('helpdesk.to').':') !!}</div>
									            <div class="col-md-9">
									              {!! Form::text('To',$Creator->email,['disabled'=>'disabled','id'=>'email','class'=>'form-control','style'=>'width:55%'])!!}
									            
									            </div>
        										</div>
												
												<div class="col-md-12  form-group">
												 <div class="col-md-2">
												 {!! Form::label('Reply Content', Lang::get('helpdesk.reply_content').':') !!}
                                                 <p><input type="radio" name="we_have_fix" class="we_have_fix" value="we_have_fix"> We have fix this for you.</p>
                                                 <p><input type="radio" name="we_have_fix" class="we_have_fix" value="check_few_moments"> Please check in few moments.</p>
                                                 <p><input type="radio" name="we_have_fix" class="we_have_fix" value="check_few_hours"> Please check in few hours.</p>
                                                 <p><input type="radio" name="we_have_fix" class="we_have_fix" value="passport"> We have transferred the passport to you.</p>
                                                 <p><input type="radio" name="we_have_fix" class="we_have_fix" value="suspend"> We have open dispute for you.</p>
												</div>
												<div class="col-md-9">
												
		
											{!! Form::textarea('ReplyContent',null,['class' => 'form-control','id'=>'ReplyContent',  'placeholder'=>Lang::get('helpdesk.enter_the_description') ]) !!}	
												<br/>
                                        <div type="file" class="btn btn-default btn-file"><i class="fa fa-paperclip"> </i> {!! Lang::get('helpdesk.attachment') !!}<input type="file" name="attachment[]" multiple/></div><br/>
                                        <!--   {!! Lang::get('helpdesk.max') !!}. 10MB -->
												</div>
												</div>
												
												<div class="col-md-12 form-group">
									            <div class="col-md-2"> Note : </div>
									            <div class="col-md-9">
									              <input type="text" class="form-control" name="note" placeholder="Only Admin Can see this note. You can update without Reply Text"/>
									            
									            </div>
        										</div>
												
												<div class="col-md-12 form-group">
									            <div class="col-md-2"> I am : </div>
									            <div class="col-md-9">
									              @foreach($leaders as $mgr)
									              <input type="radio" name="replier" value="{{$mgr->manager_code}}" {{($loggedInMgrCode==$mgr->manager_code)?'checked':''}}> {{$mgr->manager_code}}
									              @endforeach
									              <!-- 
									              <input type="radio" name="replier" value="D"> D
									              <input type="radio" name="replier" value="F"> F
									              <input type="radio" name="replier" value="L"> L
									             -->
									            </div>
        										</div>
												
												
												
												<div class="col-md-12">
							      				<div class="col-md-2"></div>
							      				<div class="col-md-9">
							      				<span class="btn-area">
							      				 <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o" style="color:white;"> </i> {!! Lang::get('helpdesk.update') !!}</button>
							                     <input name="custom_msg" type="hidden" />
							                      </span>
							                      <span class="loading hide"><img src="{{ asset('helpdesk/img/ajax-loader.gif') }}" /></span>
												</div>
												</div>
												
												
												
												
												
												<div class="col-md-offset-1 col-md-10 alert alert-success hide" role="alert">
        										<i class="fa fa-info pull-right"></i>
         										<span></span>
       											</div>
											</div>
								{!!Form::close()!!}
								</div>
							</section>
							
							<div class="col-md-12">
							<div class="timeline">
						        <ul class="simple-post-list">
										@foreach($conversations as $com)
										<li>
											<div class="post-image">
												<div class="img-thumbnail">
													<a href="#">
													<img alt="" src="{{S3Files::url('profiles/'.$com->profile_pic.'')}}" width="50">
													</a>
													
												</div>
											</div>
											<div class="post-info">
											<span>
												<i class="fa fa-user fa-fw"></i> <a href="#">{{$com->name}} @if($com->replier) (<span class="text-danger"><strong> {{$com->replier}} </strong>  </span> ) @endif</a>
											</span>
											<span>
											<i class="fa fa-film fa-fw"></i> <time datetime="2013-09-19T20:01:58+00:00">
											{{$com->created_at}}</time>
											</span>
												<div class="post-meta">
												{!! $com->body !!}
												</div>
											<!-- ATTACHMENT -->	
											
                                        
                                        @if(count($com->attachments)>0)
										<div data-appear-animation="fadeInRight" class="tm-box appear-animation fadeInRight appear-animation-visible">
										<hr style='border-top: 0px dotted #FFFFFF;margin-top:0px;margin-bottom:0px;background-color:#8B8C90;'><h4 class='box-title'><b>{{count($com->attachments)}}</b> Attachments</h4>
										
										<div class="thumbnail-gallery">
										@foreach($com->attachments as $attachment)
										@if($attachment->fileType == "Image")
										<a href="{{asset($attachment->file_path)}}" target="_blank" class="img-thumbnail">
            							<img width="215" src="{{asset($attachment->file_path)}}"/><span class="zoom">
													<i class="fa fa-search"></i>
												</span></a>
										@else
										<a href="{{URL::route('image', array('image_id' => $attachment->image_id))}}" target="_blank" class="img-thumbnail">
                                		<p class="colored" style="background-color:#fff;font-size:55px;color:#e2a129;padding:10px;">{{$attachment->attachmentType}}
                                   		</p>
            							<span class="zoom">
										<i class="fa fa-search"></i>
										</span></a>		
										@endif
										<!-- {!! $attachment->fileDetail !!}  -->
											<div class="well info pull-right" style="padding:10px;margin-top:10px;">
											<div class="tm-meta">
											<span>
												<i class="fa fa-file"></i>  {{$attachment->filename}}
											</span>
											<span style="margin-left:10px;">
												<i class="fa fa-floppy-o"></i>
											 {{$attachment->filesize}}
											</span>
										</div>
											</div>
											@endforeach
										</div>
									</div> @endif
											<!-- ATTACHMENT -->	
											@if($com->note)
											<div class="alert alert-warning">{{$com->note}}</div>
											@endif	
												
											</div>
										</li>
										@endforeach
									</ul></div>
            				</div>
            
            
            
                
                <!-- /.panel -->
           

        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
</div>
</div>
</div>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('helpdesk/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
        $(function () {
            $("textarea").wysihtml5();
        });
            
   </script>

<!-- MODAL DELETE -->
<!-- Ticket Assign Modal -->
    <div class="modal fade" id="assignModal">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['id'=>'form1','method' => 'PATCH'] )!!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Assign</h4>
                </div>
                <div id="assign_alert" class="alert alert-success alert-dismissable p-10" style="display:none;">
                    <button id="assign_dismiss" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i>Alert!</h4>
                    <div id="message-success1"></div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-6" id="assign_loader" style="display:none;">
                            <img src="{{asset('helpdesk/img/ajax-loader.gif')}}"><br/><br/><br/>
                        </div>
                    </div>
                    <div id="assign_body">
                        <p>Whome do you want to assign ticket?</p>
                        <select id="asssign" class="form-control" name="assign_to">
                            <optgroup label="Leaders">
                               @foreach($leaders as $led)
                                    <option  value="{{$led->id}}">{{$led->manager_code}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis4">Close</button>
                    <button type="submit" class="btn btn-success pull-right" id="submt2">Assign</button>
                </div>
                {!! Form::close()!!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<!-- MODAL DELETE -->


<!-- UPDATE HELP TOPIC -->
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
<!-- UPDATE HELP TOPIC -->

<meta name="csrf-token" content="{{ csrf_token() }}" />
 <script src="{{asset('helpdesk/js/functions.js')}}"></script> 
<script>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$('#form3').on('submit', function() {
	 
	 FormResponse('processing','','form3');
    var fd = new FormData(document.getElementById("form3"));
    $.ajax({
        type: "POST",
        url:"{{URL::route('ticket.reply',[$tickets->id])}}",
        enctype: 'multipart/form-data',
        dataType: "json",
        data: fd,
        processData: false,  // tell jQuery not to process the data
        contentType: false ,  // tell jQuery not to set contentType
        beforeSend: function() {
            $("#t1").hide();
            $("#show3").show();
        },
        success: function(data) {
       	 if (data.response == 1){
           	 FormResponse('success',data,'form3');
           	 setTimeout(function()
                 		{
            			//window.location.href = "{!! URL('Ticket/Thread',[Crypt::encrypt($tickets->id)]) !!}";
         			     //location.reload();
                 		},3000)
            } else {
               FormResponse('failed',data,'form3');
                  
            }
           
        }
    })
    return false;
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
$("#update-topic-form").on("submit", function(e){
	FormResponse('processing','','update-topic-form');
    $.ajax({
        type: 'post',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function (data) { 
            	$('#helpTopic').html(data.topic);
            	$('#tktUpateTopicModal').modal('hide'); 
        }
    });
    return false;
    
});

//Assign a ticket
$('#form1').on('submit', function() {
    $.ajax({
        type: "POST",
        url: "{{URL::route('admin.assign.ticket',[$tickets->id])}}",
        dataType: "json",
        data: $(this).serialize(),
        beforeSend: function() {
            $("#assign_body").hide();
            $("#assign_loader").show();
        },
        success: function(data) {
        	$("#assign_body").show();
            $("#assign_loader").hide();
            if(data.response == 1)
            {
                var message = "Success!";
                $(".alert").show();
                $('#message-success1').html(message);
                setInterval(function(){location.reload(); },3000);   
            }
          // $("#dismis4").trigger("click");
            
        }
    })
    return false;
});

$('#open').on('click', function(e) {
    $.ajax({
        type: "GET",
        url: "{{url('ticket/open')}}/{{$tickets->id}}",
        beforeSend: function() {
            $('#loader').removeClass('hide');
        },
        success: function(response) {
       	 $('#loader').addClass('hide');
       	 $('#msgDiv').removeClass('hide');
            var message = "Success! Your Ticket have been Opened";
            $('#changeStatusMessage').html(message);
            setInterval(function(){location.reload(); },3000);   
        }
    })
    return false;
});

$('#close').on('click', function(e) {
	
    $.ajax({
        type: "GET",
        url: "{{url('ticket/close')}}/{{$tickets->id}}",
        beforeSend: function() {
            $('#loader').removeClass('hide');
        },
        success: function(response) {
       	 $('#loader').addClass('hide');
       	 $('#msgDiv').removeClass('hide');
            var message = "Success! Your Ticket have been Closed";
            $('#changeStatusMessage').html(message);
            setInterval(function(){location.reload(); },3000);   
              
        }
    })
    return false;
});


$('#pending').on('click', function(e) {
    $.ajax({
        type: "GET",
        url: "{{url('admin/ticket/pending')}}/{{$tickets->id}}",
        beforeSend: function() {
            $('#loader').removeClass('hide');
        },
        success: function(response) {
       	 $('#loader').addClass('hide');
       	 $('#msgDiv').removeClass('hide');
            var message = "Success! Ticket Status Has Been Updated";
            $('#changeStatusMessage').html(message);
            setInterval(function(){location.reload(); },3000);   
        }
    })
    return false;
});

$('.we_have_fix').on('click', function(e) {
    if ($( this ).val() == "we_have_fix")
    {
        var iContentBody = $(".wysihtml5-sandbox").contents().find("body");
        iContentBody.text('We have fix this for you.');
        $('#ReplyContent').text(iContentBody.text());
    }
    else if ($( this ).val() == "check_few_moments") {
        var iContentBody = $(".wysihtml5-sandbox").contents().find("body");
        iContentBody.text('We have fix this for you. Please check in few moments.');
        $('#ReplyContent').text(iContentBody.text());
    }
    else if ($( this ).val() == "check_few_hours") {
        var iContentBody = $(".wysihtml5-sandbox").contents().find("body");
        iContentBody.text('We have fix this for you. Please check in few hours.');
        $('#ReplyContent').text(iContentBody.text());
    }
    else if ($( this ).val() == "passport") {
        var iContentBody = $(".wysihtml5-sandbox").contents().find("body");
        iContentBody.text('We have transferred the passport to you.');
        $('#ReplyContent').text(iContentBody.text());
    }
    else if ($( this ).val() == "suspend") {
        var iContentBody = $(".wysihtml5-sandbox").contents().find("body");
        iContentBody.text('We have open dispute for you, please wait for the suspended member to return the btc to you.');
        $('#ReplyContent').text(iContentBody.text());
    }
});
</script>
@Stop