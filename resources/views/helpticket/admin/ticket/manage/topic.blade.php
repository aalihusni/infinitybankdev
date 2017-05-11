<div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Manage Help Topic
                
                <span class="pull-right"><small><a href="{{url('Admin/Ticket/Open')}}">Go To Ticket List</a></small></span>
                </h3>
                
                <div class="row clearfix">
		<div class="col-md-12 column">
			<table class="table table-bordered table-hover" id="data_table">
				<thead>
					<tr >
						
						<th class="text-center">
							Topic
						</th>
						<th class="text-center">
							<i class="fa fa-folder-open" aria-hidden="true"></i> <i class="fa fa-ticket" aria-hidden="true"></i>
						</th>
						<th class="text-center">
							Description
						</th>
						<th class="text-center">
							CSS
						</th>
						<th class="text-center">
							Status
						</th>
						<th class="text-center">
							Order
						</th>
						<th class="text-center">
							Action
						</th>
					</tr>
				</thead>
				<tbody id="tbody">
				@foreach($Topics as $topic)
					<tr id="row{{$topic->id}}">
						
						<td id="topic_row{{$topic->id}}">{{$topic->topic}}</td>
						<td id="open_row{{$topic->id}}">
						<a href="{{url('admin/ticket/filterByCategory?optionValue='.$topic->id.'&secondDrop=All&tktStatus=Open')}}">
						<span class="text-danger">{{$topic->countTicket(['help_topic_id'=>$topic->id,'status'=>1])}}</span></a></td>
						<td id="description_row{{$topic->id}}">{{$topic->description}}</td>
						<td id="css_class_row{{$topic->id}}">{{$topic->css_class}}</td>
						<td id="status_row{{$topic->id}}">{{getStatusString($topic->status)}}<input type="hidden" id="td_status_{{$topic->id}}" value="{{$topic->status}}" /></td>
						<td id="ordering_row{{$topic->id}}">{{$topic->ordering}}</td>
						<td><button type="button" class="btn btn-primary btn-xs" id="edit_button{{$topic->id}}" onclick="edit_row('{{$topic->id}}')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> 
						<button type="button" class="btn btn-danger btn-xs save" id="save_button{{$topic->id}}" 
						onclick="save_row('{{$topic->id}}')"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
						
						
						<button type="button" class="btn btn-danger btn-xs delete" onclick="delete_row({{$topic->id}},'{{$topic->topic}}')"><i class="fa fa-trash" aria-hidden="true"></i></button>
						</td>
					</tr>
					@endforeach
					
					<tr id="new">
						<td><input type="text" id="new_topic"></td>
						<td>0</td>
						<td><input type="text" id="new_description"></td>
						<td><input type="text" id="new_css_class"></td>
						<td><select id="new_status" class='form-control'><option value='1'>{{getStatusString(1)}}</option><option value="0">{{getStatusString(0)}}</option></select></td>
						<td><input type="text" id="new_ordering"></td>
						<td>  <button type="button" class="btn btn-danger btn-xs" 
						onclick="save_new_topic()"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
						<!-- <input type="button" class="add" onclick="add_row();" value="Add Row">   --></td>
					</tr>
                    
				</tbody>
			</table>
		</div>
	</div>
		<a class="btn btn-default pull-left" onclick="add_row();">Add New Topic</a>
	
                
                
            </div>
            <!-- /.col-lg-12 -->
        </div>