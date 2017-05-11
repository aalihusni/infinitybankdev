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
      <h1 class="page-title"><i class="fa fa-cogs"></i> Media :: Videos
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
                                <th>Type</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>URL</th>
                                <th>Cover</th>
                                <th class="text-center">Ordering</th>
                                <th>Added On</td>
                                <th>Action</th>
                            </tr>
                            
                            
                            </thead>
                            <tbody>
                                    @foreach($lists as $list)
                                        <tr>
                                            <td>{{ $list->v_type }}</td>
                                            <td><span contenteditable="true" onBlur="saveToDatabase(this,'title_1','{{$list->id}}')" onClick="showEdit(this);" >{{ $list->title_1 }}</span>
                                             <br><span contenteditable="true" onBlur="saveToDatabase(this,'title_2','{{$list->id}}')" onClick="showEdit(this);" >{{ $list->title_2 }}</span> </td>
                                            <td><span class="badge badge-{{($list->status)?'success':'warning'}}">{{($list->status)?'Published':'Unpublish'}}</span></td>
                                            <td>
                                            <span contenteditable="false" onBlur="saveToDatabase(this,'v_url','{{$list->id}}')" onClick="showEdit(this);" >{{$list->v_url}}</span>
                                            <!-- <iframe width="210" height="157" src="{{str_replace('watch?v=','embed/',$list->v_url)}}" frameborder="0" allowfullscreen></iframe> -->
                                            <a href="{{$list->v_url}}" target="__BLANK">Go</a>
                                             </td>
                                             <td><img alt="" class="img-responsive" src="{{asset('web_content/img/projects/'.$list->cover_image.'')}}" width="60"></td>
                                              <td contenteditable="true" onBlur="saveToDatabase(this,'ordering','{{$list->id}}')" onClick="showEdit(this);" class="text-center">{{ $list->ordering }}</td>
                                             <td>{{ $list->created_at }}</td>
                                             <td>
                                             <button data-value="{{$list->id}}" data-whatever="Update Dispute User's Status" class="btn btn-icon btn-warning btn-round waves-effect waves-round waves-light btn-sm" 
                                            data-target="#editVIdeoModal" data-toggle="modal" type="button">
                                             <i class="fa-pencil-square-o" aria-hidden="true"></i></button>
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
                          <h4 class="modal-title">Manage Videos :: ADD NEW</h4>
                        </div>
                        {!!Form::open(array('route' => 'admin-post-video','id'=>'videoForm','enctype'=>"multipart/form-data",'method'=>'POST','class'=>"form-horizontal",'autocomplete'=>"off"))!!}
                        <input type="hidden" name="video_id" value="" />
                        <div class="modal-body">
                    <div class="form-group form-material row">
                      <div class="col-sm-6">
                        <label for="video_type" class="control-label">Video Type</label>
                        <select class="form-control" name="video_type">
                        <option value="">--SELECT--</option>
                        <option value="Videos">Videos</option>
                        <option value="PDF Guide">PDF Guide</option>
                        <option value="Testimonial">Testimonial</option>
                        </select>
                        
                      </div>
                      <div class="col-sm-6">
                      <div class="input-group input-group-file">
                      <label for="complain_to" class="control-label">Cover Image</label>
                    	<input type="text" class="form-control" >
	                    <span class="input-group-btn">
	                      <span class="btn btn-success btn-file waves-effect waves-light">
	                        <i aria-hidden="true" class="icon md-upload"></i>
	                        <input type="file" name="cover_image">
	                      </span>
	                    </span>
                  </div>
                      </div>
                    </div>
                    
                    <div class="form-group form-material row">
                      <div class="col-sm-12">
                        <label for="title_1" class="control-label">Title (Main Title)</label>
                        <input type="text" autocomplete="off" placeholder="Enter the Title One" name="title_1" class="form-control">
                      </div>
                    </div>
                    <div class="form-group form-material row">
                      <div class="col-sm-12">
                        <label for="title_2" class="control-label">Title (Sub Title)</label>
                        <input type="text" autocomplete="off" placeholder="Enter the Title Two" name="title_2" class="form-control">
                      </div>
                    </div>
                    
                    <div class="form-group form-material row">
                      <div class="col-sm-9">
                        <label for="v_url" class="control-label">Video URL</label>
                        <input type="text" autocomplete="off" placeholder="Enter the URL" name="v_url" class="form-control">
                      </div>
                      <div class="col-sm-3">
                        <label for="ordering" class="control-label">Ordering</label>
                        <input type="text" autocomplete="off" placeholder="Enter the ORDER" name="ordering" class="form-control">
                        
                      </div>
                    </div>
                    
                    <div class="form-group form-material row">
                      <div class="col-sm-6">
                        <label for="v_url" class="control-label">Publish</label>
                        <select class="form-control" name="status">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        </select>
                      </div>
                      
                    </div>
                    
                     
                    
                     <input type="hidden" name="custom-err" id="custom-err" class="form-control">
                 
                        </div>
                        <div class="modal-footer">
                        
                       
                        
                        <span class="loading hide"><img src="{{ asset('remark/images/loader/ajax-loader.gif') }}" /></span>
                        <span class="btn-area">
                          <button type="button" class="btn btn-default btn-pure margin-0" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save</button>
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
                  
                  
                  
                  <!-- EDIT -->
                  <div class="modal fade modal-just-me" id="editVIdeoModal" aria-hidden="true"
                  aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title">Video Detail</h4>
                        </div>
                        <div id="loadForm"></div>
                        
                        
                      </div>
                    </div>
                  </div>
                  <!-- EDIT -->
 @section('extend-js')
 
 <script>
 
 $("#videoForm").on("submit", function(e){
	 postSubmit('videoForm');
	 return false;
}); 

 function postSubmit(formID)
 {
	 FormResponse('processing','',formID);
		var fd = new FormData(document.getElementById(formID));
	   $.ajax({
	       type: 'post',
	       url: $('#'+formID+'').attr('action'),
	       data: fd,
	       processData: false,  
	       contentType: false ,
	       dataType: 'json',
	       success: function (data) {
	       	if (data.response == 1)
	       	{
	           	 FormResponse('success',data,formID);
	           	 setInterval(function(){ location.reload() }, 2000);
	       	}
	           else
	           	FormResponse('failed',data,formID);
	       }
	   });
	   
	 };



	
	$('#editVIdeoModal').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget)
	  var video_id = button.data('value')
	  var modal = $(this)
	  $.ajax({
	        type: 'get',
	        url: "{{url('admin/manage/video')}}/"+video_id,
	        dataType: 'html',
	        success: function (data) {
	        	modal.find('#loadForm').html(data);
	        }
	  });
	})
	/*
	
	$("td").click(function(){
    if($(this).attr("contentEditable") == true){
        $(this).attr("contentEditable","false");
    } else {
        $(this).attr("contentEditable","true");
    }
}) */
function showEdit(editableObj) {
	$(editableObj).css("background","#FFF");
} 

function saveToDatabase(editableObj,column,id) {
	$(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
	$.ajax({
		url: "{{URL::route('admin-video-quick-edit')}}",
		type: "POST",
		 dataType: 'json',
		data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id+'&_token={{csrf_token()}}',
		success: function(data){
			$(editableObj).css("background","#4caf50");
		}        
   });
}

</script>
 @endsection

@Stop