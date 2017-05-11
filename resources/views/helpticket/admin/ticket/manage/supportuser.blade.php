<div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Manage Support Team</h3>
                <div class="row clearfix">
		<div class="col-md-12 column">
			<table class="table table-bordered table-hover" id="data_table_team">
				<thead>
					<tr>
						<th class="text-center">
						 User Code
						</th>
						<th class="text-center">
							Assigned Topics
						</th>
						<th class="text-center">
							Action
						</th>
					</tr>
				</thead>
				<tbody id="tbodyTeam">
				@foreach($Managers as $mgr)
					<tr id="row-team-{{$mgr->id}}">
						<td id="manager_code_row{{$mgr->id}}">{{$mgr->manager_code}}</td>
						<td>
						@foreach($mgr->assignedTopics as $asnTopic)
						<span id="topic-{{$mgr->manager_code}}-{{$asnTopic->id}}">		{{$asnTopic->topic}}
						<button type="button" class="btn btn-danger btn-xs delete" title="Unassigned {{$asnTopic->topic}} Topic"
										onclick="removeAssigned('Are you sure you want to unassigned [ {{$asnTopic->topic}} ] from [ {{$mgr->manager_code}} ]' ,{{$asnTopic->id}},'{{$mgr->manager_code}}')">
										<i class="fa fa-trash" aria-hidden="true"></i>
						</button>,</span>
						@endforeach
						</td>
						<td>
						<button type="button" class="btn btn-danger btn-xs save" id="save_button{{$mgr->id}}" 
						onclick="save_row('{{$mgr->id}}')"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
						<button type="button" class="btn btn-danger btn-xs delete" onclick="removeUser('Are you sure you want remove Team Member [ {{$mgr->manager_code}} ]',{{$mgr->id}})"><i class="fa fa-trash" aria-hidden="true"></i></button>
						<button type="button" class="btn btn-primary btn-xs" title="Assign Topic"
						data-toggle="modal" data-target="#exampleModal" data-code="{{$mgr->manager_code}}"><i class="fa fa-plus" aria-hidden="true"></i>
						</button>
						</td>
					</tr>
					@endforeach
					
					<tr id="newTeam">
						<td><input type="text" id="new_manager_code"></td>
						<td></td>
						<td>  <button type="button" class="btn btn-danger btn-xs" 
						onclick="save_new_manager()"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
						<!-- <input type="button" class="add" onclick="add_row();" value="Add Row">   --></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
		<a class="btn btn-default pull-left hide" onclick="add_row();">Add New Ticket Support</a>
                
            </div>
            <!-- /.col-lg-12 -->
        </div>
        
        
        
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Support Team Code</h4>
      </div>
      <div class="modal-body">
        <form action="{{ URL::route('admin-manage-assign-helptopic') }}" method="post" id="assign-topic-form">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="selected_manager_code" value="" id="selected_manager_code">
        	<div class="form-group">
            <label for="message-text" class="control-label">Please Select The Box To Assigned Topic:</label>
          </div>
          <div id="Topics"></div>
          <div class="modal-footer">
          <span class="btn-area">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-primary">Save</button>
         </span>
         
         <div class="col-md-offset-1 col-md-10 alert alert-success hide" role="alert">
        										<i class="fa fa-info pull-right"></i>
         										<span></span>
       											</div>
         
        
      </div>
        </form>
      </div>
      
    </div>
  </div>
</div>
        
        <script>
        $('#exampleModal').on('show.bs.modal', function (event) {
        	  var button = $(event.relatedTarget) 
        	  var mgrCode = button.data('code') 
        	  var modal = $(this)
        	  modal.find('.modal-title').text('Support Team Code : ' + mgrCode)
        	  modal.find('.modal-body input[name="selected_manager_code"]').val(mgrCode);
        	  $("#Topics").load("{{url('admin/manage/ajax/loadtopics')}}/"+mgrCode, function(responseTxt, statusTxt, xhr){
        	       
        	  });
        })
        
        $("#assign-topic-form").on("submit", function(e){
			FormResponse('processing','','assign-topic-form');
		    $.ajax({
		        type: 'post',
		        url: $(this).attr('action'),
		        data: $(this).serialize(),
		        dataType: 'json',
		        success: function (data) { 
			        if(data.response==1){
			        	FormResponse('success',data,'assign-topic-form');
			        	setInterval(function(){ location.reload(); }, 3000);
			        }else{
							alert(data.message);
				    }
		        }
		    });
		    return false;
		    
		});
        function removeAssigned(title,topic_id,mgr_code)
        {
        	confirmDialog(title, function(){
        		 $.ajax({
        		        type: 'POST',
        		        url: "{{URL::route('admin-manage-delete-assigned-topic')}}",
        		        data: {topic_id:topic_id,mgr_code:mgr_code,_token:CSRF_TOKEN},
        		        dataType: 'json',
        		        success: function (data) { 
        		        	if(data.response==1)
            		        	$('#topic-'+mgr_code+'-'+topic_id).remove();
        			        	
        			        	else alert(data.message);
        		        }
        		 });
            });
         		
        }
        function removeUser(title,mgr_id)
        {
        	confirmDialog(title, function(){
        		 $.ajax({
        		        type: 'POST',
        		        url: "{{URL::route('admin-manage-delete-team-manager')}}",
        		        data: {mgr_id:mgr_id,_token:CSRF_TOKEN},
        		        dataType: 'json',
        		        success: function (data) { 
        		        	if(data.response==1)
            		        	$('#row-team-'+mgr_id).remove();
        			        	else alert(data.message);
        		        }
        		 });
            });
         		
        }

        function save_new_manager(no)
        {
        	 var manager_code  =$("#new_manager_code").val();
        	 $.ajax({
        	        type: 'POST',
        	        url: "{{URL::route('admin-manage-add-team-manager')}}",
        	        data: {manager_code:manager_code,_token:CSRF_TOKEN},
        	        dataType: 'json',
        	        success: function (data) { 
        	        	 if(data.response==1)
        		            {
        		           		location.reload();
        			        }else
        			        {
        			       	 	var arr = data.errors;
        			            $.each(arr, function (index, value)
        			            {
        			                alert(value);
        			            });
        				    }   	
        	        }
        	 });
        	 
        }
        </script>