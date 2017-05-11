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
            <h2 class="pb-lg">Tickets</h2>
               
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
                    <a class="btn btn-{{($tktStatus=='Open')?'info':'default'}}" type="button" href="{{URL::route('admin-tickets',['Open'])}}" >{!! Lang::get('helpdesk.open') !!} <span class="badge">{{$ticket->countTicket(['status'=>['1']])}}</span></a>
                    <!-- <a class="btn btn-default" type="button" href="{{ url('/ticket/answered') }}" >{!! Lang::get('helpdesk.answered') !!}</a>-->
                    <a class="btn btn-{{($tktStatus=='Closed')?'info':'default'}}" type="button" href="{{URL::route('admin-tickets',['Closed'])}}" >{!! Lang::get('helpdesk.closed') !!} <span class="badge">{{$ticket->countTicket(['status'=>['2,3']])}}</span></a>  
                   <a class="btn btn-{{($tktStatus=='Unassigned')?'info':'default'}}" type="button" href="{{URL::route('admin-tickets',['Unassigned'])}}" >Unassigned <span class="badge">{{$ticket->countTicket(['Unassigned'=>'NULL'])}}</span></a>
                    <a class="btn btn-{{($tktStatus=='Surrendered')?'info':'default'}}" type="button" href="{{URL::route('admin-tickets',['Surrendered'])}}" >Surrender <span class="badge"></span></a> 
                <a class="btn btn-{{($tktStatus=='Trashed')?'info':'default'}}" type="button" href="{{URL::route('admin-tickets',['Trashed'])}}" >Trashed <span class="badge">{{$ticket->countTicket(['status'=>['5']])}}</span></a>  
                   
                   
												    
												    
												    
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
        
        
                                <div class="dataTable_wrapper mailbox-messages" style="padding-top:30px;" id="refresh1">
                                 <p style="display:none;text-align:center; position:fixed; margin-left:37%;margin-top:-80px;" id="show1" class="text-red"><b>Loading...</b></p>
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
                    Surrendered By
                </th>
                <th>
                    {!! Lang::get('helpdesk.last_activity') !!}
                </th>
                
                </thead>
                        <tbody id="hello">
                     @foreach ($open  as $ticket )
                    <tr style="color:green;" >
                    <td><input type="checkbox" class="icheckbox_flat-blue" name="select_all[]" value="{{$ticket->id}}"/></td>
                     
                        <td class="mailbox-name">{{$ticket->id}}<a href="{!! URL('Admin/Ticket/Detail',[Crypt::encrypt($ticket->id)]) !!}" title="{!! $ticket->title !!}">
                        {{$ticket->tktTitle}} </a> ({!! $ticket->count!!}) <i class="fa fa-comment"></i></td>
                        <td class="mailbox-Id">#{!! $ticket->ticket_number !!}</td>
                        <td class="mailbox-priority"><spam class="btn btn-{{$ticket->priority_color}} btn-xs">{{$ticket->priority}}</spam></td>
                        <td class="mailbox-last-reply">{!! $ticket->from !!} <span class="badge">{{$ticket->country_code}}</span></td>
                		<td class="mailbox-last-reply" style="color: {!! $ticket->rep !!}">{!! $ticket->lastreplier !!}</td>
                		<td class="mailbox-date">
                		{!! $ticket->surrenderedBy !!}
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

<!-- MODAL DELETE -->
<meta name="csrf-token" content="{{ csrf_token() }}" />
 <script src="{{asset('helpdesk/js/functions.js')}}"></script> 
<script>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

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
</script>
@Stop