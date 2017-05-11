@extends('member.default')
@section('title')Support Center @Stop
@section('assigned-ticke-class')nav-active @Stop
@section('kb-class')nav-expanded nav-active @Stop
@section('content')

<!-- Page Content -->
<style>
html.fixed .content-body{ margin-left:260px!important;
padding-right:5px!important;
}


</style>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">

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
                    <a class="btn btn-{{($tktStatus=='Open')?'info':'default'}}" type="button" href="{{URL::route('assigned.ticket',['Open'])}}" >{!! Lang::get('helpdesk.open') !!}</a>
                    <!-- <a class="btn btn-default" type="button" href="{{ url('/ticket/answered') }}" >{!! Lang::get('helpdesk.answered') !!}</a>-->
                    <a class="btn btn-{{($tktStatus=='Closed')?'info':'default'}}" type="button" href="{{URL::route('assigned.ticket',['Closed'])}}" >{!! Lang::get('helpdesk.closed') !!}</a>  
                    <a class="btn btn-default" type="button" href="{{URL::route('create-ticket')}}" >Submit A Ticket</a>
												    
												    
												    
												</div>
                       
                       
                       
                        <!-- Nav tabs -->
                        
                        

                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#home" data-toggle="tab">{{$tktStatus}} <small class="label bg-warning">{!! $renderOpenList->total() !!}</small></a>
                            </li>
                            
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="home">
                            {!! Form::open(['route'=>'my-tickets-update-status','method'=>'post']) !!}
                            <div class="mailbox-controls">
            <!-- Check all button -->
            <a class="btn btn-default btn-sm checkbox-toggle hide"><i class="fa fa-square-o"></i></a>
            <a class="btn btn-default btn-sm hide" id="click1"><i class="fa fa-refresh"></i></a>
            <input type="submit" class="btn btn-default text-yellow btn-sm hide" name="submit" value="Close">
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
                    {!! Lang::get('helpdesk.last_activity') !!}
                </th>
                <th>
                    {!! Lang::get('helpdesk.status') !!}
                </th>
                </thead>
                        <tbody id="hello">
                     @foreach ($open  as $ticket )
                    <tr style="color:green;" >
                     
                        <td class="mailbox-name"><a href="{!! URL('Ticket/Thread',[Crypt::encrypt($ticket->id)]) !!}" title="{!! $ticket->title !!}">
                        {{$ticket->tktTitle}} </a> ({!! $ticket->count!!}) <i class="fa fa-comment"></i></td>
                        <td class="mailbox-Id">#{!! $ticket->ticket_number !!}</td>
                        <td class="mailbox-priority"><spam class="btn btn-{{$ticket->priority_color}} btn-xs">{{$ticket->priority}}</spam></td>
                        <td class="mailbox-last-reply">{!! $ticket->from !!}</td>
                		<td class="mailbox-last-reply" style="color: {!! $ticket->rep !!}">{!! $ticket->lastreplier !!}</td>
                		<td class="mailbox-last-activity">{!! $ticket->last_updated_at !!}</td>
                		<td class="mailbox-date">{!! $ticket->tktstatus !!}</td>
                		</tr>
                @endforeach
                </tbody>                
                                        
                                    </table>
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
<script>
$(document).ready(function() { /// Wait till page is loaded
    $('#click1').click(function() {
        $('#refresh1').load('Mytickets #refresh1');
        $('#refresh21').load('Mytickets #refresh21');
        $("#show1").show();
    });
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

</script>
@Stop