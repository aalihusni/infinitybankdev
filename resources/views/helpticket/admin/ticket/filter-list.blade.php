  <h4 class="text-info">Filter Results : {{$labelText}}</h4>                               
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
                
                </thead>
                        <tbody id="hello">
                     @foreach ($lists  as $ticket )
                    <tr style="color:green;" >
                    <td><input type="checkbox" class="icheckbox_flat-blue" name="select_all[]" value="{{$ticket->id}}"/></td>
                     
                        <td class="mailbox-name"><a href="{!! URL('Admin/Ticket/Detail',[Crypt::encrypt($ticket->id)]) !!}" title="{!! $ticket->title !!}">
                        {{$ticket->tktTitle}} </a> ({!! $ticket->count!!}) <i class="fa fa-comment"></i> (<span class="text-warning"><small>{{$ticket->topic}}</small></span>)</td>
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
                		<span style="color:red;">Unassigned</span>
                		@endif
                		</td>
                		<td class="mailbox-last-activity">{!! $ticket->last_updated_at !!}</td>
                		</tr>
                @endforeach
                </tbody>                
                                        
                                    </table>
                                    
                                    
                                    
                               