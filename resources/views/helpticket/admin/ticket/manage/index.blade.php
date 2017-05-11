@extends('admin.default')

@section('title'){{trans('member.emails')}} @Stop
@section('homeclass')nav-active @Stop
@section('content')
 <link href="{{asset('helpdesk/css/style.css')}}" rel="stylesheet" type="text/css" />
 <style>
 input[type="button"] {
    margin-top: 5px;
}
.save {
    display: none;
}
 </style>
        <!-- Page Content -->
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
       	@include('helpticket.admin.ticket.manage.topic')
       	
       	@include('helpticket.admin.ticket.manage.supportuser')
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->


<!-- Modal confirm -->
<div class="modal" id="confirmModal" style="display: none; z-index: 1050;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" id="confirmMessage">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="confirmOk">Ok</button>
                <button type="button" class="btn btn-default" id="confirmCancel">Cancel</button>
            </div>
        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}" />
 <script src="{{asset('helpdesk/js/functions.js')}}"></script> 
<script>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


function edit_row(no)
{
 document.getElementById("edit_button"+no).style.display="none";
 document.getElementById("save_button"+no).style.display="block";
	
 var topic=document.getElementById("topic_row"+no);
 var description=document.getElementById("description_row"+no);

 var css_class=document.getElementById("css_class_row"+no);
 var status=document.getElementById("status_row"+no);

 var StatusVal = $('#td_status_'+no+'').val();
 
 var ordering=document.getElementById("ordering_row"+no);
	
 var topic_data=topic.innerHTML;
 var description_data=description.innerHTML;
 var css_class_data=css_class.innerHTML;
 var status_data=status.innerHTML;
 var ordering_data=ordering.innerHTML;
	
 topic.innerHTML="<input type='text' class='form-control'  id='topic_text"+no+"' value='"+topic_data+"'>";
 description.innerHTML="<input type='text' class='form-control' id='description_text"+no+"' value='"+description_data+"'>";
 css_class.innerHTML="<input type='text' class='form-control' id='css_class_text"+no+"' value='"+css_class_data+"'>";
 status.innerHTML="<select type='text' class='form-control' id='status_text"+no+"'><option value='1'>{{getStatusString(1)}}</option><option value='0'>{{getStatusString(0)}}</option></select>";
 ordering.innerHTML="<input type='text' class='form-control' id='ordering_text"+no+"' value='"+ordering_data+"'>";
 $("#status_text"+no+" option[value="+StatusVal+"]").prop('selected', true);
}


function save_row(no)
{
	 var topic_val=$("#topic_text"+no).val();
	 var description_val=$("#description_text"+no).val();
	 var css_class_val=$("#css_class_text"+no).val();
	 var status_val=$("#status_text"+no).val();
	 var ordering_val=$("#ordering_text"+no).val();
	
	 document.getElementById("topic_row"+no).innerHTML=topic_val;
	 document.getElementById("description_row"+no).innerHTML=description_val;
	 document.getElementById("css_class_row"+no).innerHTML=css_class_val;
	// document.getElementById("status_row"+no).innerHTML="{{getStatusString("+status_val+")}}";
	 document.getElementById("ordering_row"+no).innerHTML=ordering_val;
	
	 $.ajax({
	        type: 'POST',
	        url: "{{URL::route('admin-manage-update-helptopic')}}",
	        data: {topic_id:no,topic:topic_val,description:description_val,css_class:css_class_val,status:status_val,ordering:ordering_val,_token:CSRF_TOKEN},
	        dataType: 'json',
	        success: function (data) { 
	            if(data.response==1)
	            {
	            	document.getElementById("edit_button"+no).style.display="block";
	           	 	document.getElementById("save_button"+no).style.display="none";
	           	    document.getElementById("status_row"+no).innerHTML= data.StatusText+"<input type='hidden' id='td_status_"+no+"' value='"+status_val+"' />";
	           	 
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

function save_new_topic(no)
{
	 var topic_val=$("#new_topic").val();
	 var description_val=$("#new_description").val();
	 var css_class_val=$("#new_css_class").val();
	 var status_val=$("#new_status").val();
	 var ordering_val=$("#new_ordering").val();
	 $.ajax({
	        type: 'POST',
	        url: "{{URL::route('admin-manage-insert-helptopic')}}",
	        data: {topic:topic_val,description:description_val,css_class:css_class_val,status:status_val,ordering:ordering_val,_token:CSRF_TOKEN},
	        dataType: 'json',
	        success: function (data) { 
	        	 if(data.response==1)
		            {
		           	 $("#tbody").append(data.newRow);
		           	 $('#new').hide();
		           	 $("#new").appendTo('table');
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



function delete_row(topic_id,topic)
{
	confirmDialog('Are you sure you want to delete TOPIC : '+topic+' ', function(){
       	// Delete Here
		 $.ajax({
		        type: 'POST',
		        url: "{{URL::route('admin-manage-delete-helptopic')}}",
		        data: {topic_id:topic_id,_token:CSRF_TOKEN},
		        dataType: 'json',
		        success: function (data) { 
		        	if(data.response==1)
		        	document.getElementById("row"+topic_id+"").outerHTML="";
		        	else alert(data.message);
		        }
		 });
    });
 		
}

function confirmDialog(message, onConfirm){
    var fClose = function(){
        modal.modal("hide");
    };
    var modal = $("#confirmModal");
    modal.modal("show");
    $("#confirmMessage").empty().append(message);
    $("#confirmOk").one('click', onConfirm);
    $("#confirmOk").one('click', fClose);
    $("#confirmCancel").one("click", fClose);
}

function add_row()
{
	$("#new_topic").val('');
	$("#new_description").val('');
	$("#new_css_class").val('');
	$("#new_ordering").val('');
	$('#new').show();
	return false;
	/*
	 var new_topic=document.getElementById("new_topic").value;
	 var new_description=document.getElementById("new_description").value;
	 var new_ordering=document.getElementById("new_ordering").value; 
	 var new_topic='dfasdfasdfasd';
	 var new_description='';
	 var new_ordering='';
		
	 var table=document.getElementById("data_table");
	 var table_len=(table.rows.length)-1;
	 var row = table.insertRow(table_len).outerHTML="<tr id='row"+table_len+"'><td id='topic_row"+table_len+"'>"+new_topic+"</td><td id='description_row"+table_len+"'>"+new_description+"</td><td id='ordering_row"+table_len+"'>"+new_ordering+"</td><td><input type='button' id='edit_button"+table_len+"' value='Edit' class='edit' onclick='edit_row("+table_len+")'> <input type='button' id='save_button"+table_len+"' value='Save' class='save' onclick='save_row("+table_len+")'> <input type='button' value='Delete' class='delete' onclick='delete_row("+table_len+")'></td></tr>";
	
	 document.getElementById("new_topic").value="";
	 document.getElementById("new_description").value="";
	 document.getElementById("new_ordering").value=""; */
}
</script>
@Stop
