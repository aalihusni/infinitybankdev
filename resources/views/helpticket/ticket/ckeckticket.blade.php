@extends('member.default')
@section('title')Support Center @Stop
@section('my-ticke-class')nav-active @Stop
@section('kb-class')nav-expanded nav-active @Stop
@section('content')

<!-- Page Content -->
<link rel="stylesheet" href="{{asset('assets/vendor/summernote/summernote.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/vendor/summernote/summernote-bs3.css')}}" />
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <section class="panel panel-warning">
								<header class="panel-heading">
									<h2 class="panel-title"><i class="fa fa-user"> </i> {{$thread->title}} ( {{$tickets->ticket_number}} )</h2>
								</header>
								<div class="panel-body">
								 <div class="row" style="padding:0 10px 10px 0;">
                                <!-- <button type="button" class="btn btn-default"><i class="fa fa-edit" style="color:green;"> </i> Edit</button> -->                            
                                {{-- <button type="button" class="btn btn-default"><i class="fa fa-print" style="color:blue;"> </i> {!! link_to_route('ticket.print','Print',[$tickets->id]) !!}</button> --}}
                                <!-- </div> -->
                                <div class="btn-group pull-right"> 
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="fa fa-exchange" style="color:teal;"> </i> 
                                        {!! Lang::get('helpdesk.change_status') !!} <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" id="open"><i class="fa fa-folder-open" style="color:#FFD600;"> </i>{!! Lang::get('helpdesk.open') !!}</a></li>
                                        <li><a href="#" id="close"><i class="fa fa-check" style="color:#15F109;"> </i>{!! Lang::get('helpdesk.close') !!}</a></li>
                                        <li class="hide"><a href="#" id="resolved"><i class="fa fa-check-circle " style="color:#0EF1BE;"> </i> {!! Lang::get('helpdesk.resolved') !!}</a></li>
                                    </ul>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            
                            
                             <div class="row">
                                            
                                            <div class="col-md-6 col-md-offset-3 hide" id="loader">
                                                <img src="{{ asset('js/img/ajax-loader.gif') }}"><br/><br/>
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
                                         
                                    <div class="col-md-6"> 
                                        <table class="table table-hover">
                                            <!-- <tr><th></th><th></th></tr> -->
                                            <tr><td><b>{!! Lang::get('helpdesk.status') !!}:</b></td>       
                                            @if($status->id == 1)
                                                <td title="{{$status->properties}}" style="color:orange">{{$status->name}}</td></tr>
                                            @elseif($status->id == 2)
                                                <td title="{{$status->properties}}" style="color:green">{{$status->name}}</td></tr>
                                            @elseif($status->id == 3)
                                                <td title="{{$status->properties}}" style="color:green">{{$status->name}}</td></tr>
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
                                        </table>
                                        <!-- </div> -->
                                    </div>
                                    <div class="col-md-6"> 
                                        <!-- <div class="callout callout-success"> -->
                                        <table class="table table-hover">
                                            <!-- <tr><th></th><th></th></tr> -->
                                            <tr><td><b>{!! Lang::get('helpdesk.help_topic') !!}:</b></td>    
                                             <td title="{{$help_topic->topic}}">{{$help_topic->topic}}</td></tr>
                                            <tr><td><b>{!! Lang::get('helpdesk.last_message') !!}:</b></td>   <td>{{ucwords($last->poster)}}</td></tr>
                                        </table>
                                    </div>
                                    
                                    <div class="col-md-12">
                                    <div class="timeline">
						        <ul class="simple-post-list">
										@foreach($conversations as $com)
										@if($com->body)
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
												<i class="fa fa-user fa-fw"></i> <a href="#">{{$com->name}}</a>
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
												
											</div>
										</li>
										@endif
										@endforeach
									</ul></div>
                                    
                                    
                                    
                                    </div>
                                    <!-- </div> -->
                                </section> 
                            </div>
								</div>
							</section>
							
							<section class="panel">
								<header class="panel-heading">
									<div class="panel-actions">
										<a data-panel-toggle="" class="panel-action panel-action-toggle" href="#"></a>
										<a data-panel-dismiss="" class="panel-action panel-action-dismiss" href="#"></a>
									</div>

									<h2 class="panel-title">Leave a Reply</h2>
								</header>
								<div class="panel-body">
								{!! Form::open(['url'=>'Ticket/Post/Comment/'.$tickets->id.'#formabc','class'=>'form-horizontal form-bordered','name'=>"commentForm",'enctype'=>'multipart/form-data', 'id'=>"commentForm"]) !!}
											<div class="form-group">
												<div class="col-md-12">
												{!! Form::textarea('comment',null,['class' => 'form-control','id'=>'Details','data-plugin-summernote data-plugin-options'=>'{ "height": 100, "codemirror": { "theme": "ambiance" } }',  'placeholder'=>Lang::get('helpdesk.enter_the_description') ]) !!}
												</div>
												
												<div class="col-md-12">
							      				<span class="btn-area">
							      				<button class="mb-xs mt-xs mr-xs btn btn-primary" type="submit" id="SubmitBtn">Post Comment</button>
							                      </span>
							                      <span class="loading hide"><img src="{{ asset('helpdesk/img/ajax-loader.gif') }}" /></span>
												</div>
												
												<div class="col-md-offset-1 col-md-10 alert alert-success hide" role="alert">
        										<i class="fa fa-info pull-right"></i>
         										<span></span>
       											</div>
											</div>
								{!!Form::close()!!}
								</div>
							</section>
            
            
            
            
                
                <!-- /.panel -->
           

        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<script src="{{asset('assets/vendor/summernote/summernote.js')}}"></script>
<!-- /#page-wrapper -->
<script>
jQuery(document).ready(function() {
	// Close a ticket
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
                 setTimeout(function()
                  		{
                	 window.location.href = "{{url('/Mytickets')}}";
                  		},3000);
                   
             }
         })
         return false;
     });
	
   

    // Resolved  a ticket
    $('#resolved').on('click', function(e) {
        $.ajax({
            type: "GET",
            url: "../ticket/resolve/{{$tickets->id}}",
            beforeSend: function() {
                $("#refresh").hide();
                $("#loader").show();
            },
            success: function(response) {
                $("#refresh").load("../check_ticket/{!! $id !!}  #refresh");
                $("#refresh").show();
                $("#loader").hide();

                var message = "Success! Your Ticket have been Resolved";
                $("#alert11").show();
                $('#message-success1').html(message);
                setInterval(function(){$("#alert11").hide();
                    setTimeout(function() {
                        var link = document.querySelector('#load-inbox');
                        if(link) {
                            link.click();
                        }
                    }, 500);
                },2000);   
            }
        })
        return false;
    });

    // Open a ticket
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
                   setTimeout(function()
                    		{
               			window.location.href = "{{url('/Mytickets')}}";
                    		},3000);
                  

            }
        })
        return false;
    });





    

});

</script>
@Stop