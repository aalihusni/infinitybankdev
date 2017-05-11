@extends('layout.admin')

@section('title'){{trans('member.home')}} @Stop


@section('system-setting-class')active open @Stop
@section('setting-lang')active @Stop

@section('extend-css')
  <link rel="stylesheet" href="{{asset('assets/examples/css/forms/layouts.css')}}">
@endsection 

@section('content')

<div class="page animsition">
    <div class="page-header">
      <h1 class="page-title"><i class="fa fa-cogs"></i> System :: Languages
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
                                <th>Language Name</th>
                               <th>Flag</th>
                                <th>Code</td>
                                <th>Sort Order</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            
                            
                            </thead>
                            <tbody>
                                    @foreach($languages as $list)
                                        <tr>
                                            <td>{{ $list->name }}</td>
                                            <td><img src="{{ asset('img/flags/'.$list->image.'') }}" /></td>
                                            <td>{{ $list->code }}</td>
                                            <td>{{ $list->sort_order }}</td>
                                            <td>
                                            <span class="badge badge-{{($list->status)?'success':'warning'}}">{{ ($list->status)?'Published':'Unpublished' }}</span>
                                            </td>
                                            <td>
                                            <button data-value="{{$list->id}}" data-whatever="Edit Language" class="btn btn-icon btn-warning btn-round waves-effect waves-round waves-light btn-sm" 
                                            data-target="#langAddEditModal" data-toggle="modal" type="button">
                                             <i class="fa fa-eye" aria-hidden="true"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                        
                        
                         
            </div>
          </div>
          <!-- End Example Iconified Tabs -->
          
          <!-- PAGE LIST -->
          <div class="panel">
            <div class="panel-body">
            <h4>Primary Language Files</h4>
              <table class="table">
                            <thead>
                            <tr>
                            	<th>#</th>
                                <th>Language File</th>
                                <th>Languages</th>
                            </tr>
                            </thead>
                            <tbody>
                               
                               @foreach($lists as $flist)
                              <tr>
                               <td>{{$flist->sn}}</td>
                              <td>{{$flist->filename}}</td>
                              <td>
                              
                               @foreach($languages as $list)
                              <!-- <a href="{{URL::route('admin-system-language-filedata',[Crypt::encrypt(''.$flist->filename.''),$list->code])}}">
								 --><span style="font-size: 11px;margin: 0 4px 0 0;">
								{{ $list->code }}</span><img src="{{ asset('img/flags/'.$list->image.'') }}" />
								<!-- </a>  -->&nbsp;&nbsp;
                                 @endforeach 
                                 
                               </td>
                               </tr>
                               @endforeach 
                            </tbody>
                        </table>
                        
                        
                         
            </div>
          </div>
          <!-- PAGE LIST -->
        </div>
        
      </div>
    </div>
  </div>
  
  
  
   
<!-- Modal -->
                  <div class="modal fade" id="langAddEditModal" aria-hidden="false" aria-labelledby="langAddEditModalLabel"
                  role="dialog" tabindex="-1">
                    <div class="modal-dialog">
                     {!!Form::open(array('route' => 'admin-lang-post-save','id'=>'langForm','method'=>'POST','class'=>"modal-content"))!!}
                      <form class="modal-content" id="langForm">
                      <input name="language_id" value="0" type="hidden"/>
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="langAddEditModalLabel">Language</h4>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-lg-8 form-group">
                              <input type="text" class="form-control" name="name" placeholder="Language Name">
                            </div>
                            <div class="col-lg-4 form-group">
                              <input type="text" class="form-control" name="code" placeholder="Language Code">
                            </div>
                            <div class="col-lg-4 form-group">
                              <input type="text" class="form-control" name="image" placeholder="Image:gb.png">
                            </div>
                            
                            <div class="col-lg-4 form-group">
                              <input type="number" class="form-control" name="sort_order" placeholder="Ordering">
                            </div>
                            
                            <div class="col-lg-12 form-group">
                            <div class="radio-custom radio-default radio-inline">
                        <input type="radio" name="status" id="inputLabelPublish" value="1">
                        <label for="inputLabelPublish">Publish</label>
                      </div>
                      <div class="radio-custom radio-default radio-inline">
                        <input type="radio" name="status" id="inputLabelUnPublish" value="0">
                        <label for="inputLabelUnPublish">Unpublish</label>
                      </div>
                            </div>
                            
                            	<div class="col-md-12 form-group">
									<div class="alert alert-success hide" role="alert">
				        				<i class="fa fa-info pull-right"></i>
				         				<span></span>
				       				</div></div>
                            
                            <div class="col-sm-12 pull-right">
                              <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <!-- End Modal -->
 @section('extend-js')
  <script src="{{asset('global/js/components/tabs.js')}}"></script>
  <script src="{{asset('global/js/plugins/responsive-tabs.js')}}"></script>
   <script>
//var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$('#langAddEditModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget)
		  var lang_id = button.data('value')
		  var modal = $(this)
		  
		  if(lang_id){
			  modal.find('#langForm .modal-title').html("Edit/View Language");
		  $.ajax({
		        type: 'get',
		        url: "{{URL::route('admin-lang-detail')}}",
		        data: {lang_id:lang_id},
		        dataType: 'json',
		        success: function (data) {
		        	 modal.find('#langForm input[name=language_id]').val(data.id)
		        	 modal.find('#langForm input[name=name]').val(data.name)
		        	 modal.find('#langForm input[name=code]').val(data.code)
		        	 modal.find('#langForm input[name=image]').val(data.image)
		        	 modal.find('#langForm input[name=sort_order]').val(data.sort_order)
		        	  $('#inputLabelPublish').prop("checked", true);
		        	 if(data.status==0){
			        	 $("#inputLabelUnPublish").prop("checked", true);
		        	 }
		        	 
		        }
		  });
		  }else{
			   modal.find('#langForm input[name=language_id]').val(0)
			   modal.find('#langForm input[name=name]').val('')
			   modal.find('#langForm input[name=code]').val('')
			   modal.find('#langForm input[name=image]').val('')
			   modal.find('#langForm .modal-title').html("Add Language");
			  }
		  
		 
		
		})
		
		var langForm = $("#langForm");
		  $("#langForm").on("submit", function(e){
			FormResponse('processing','','langForm');
		    $.ajax({
		        type: 'post',
		        url: langForm.attr('action'),
		        data: langForm.serialize(),
		        dataType: 'json',
		        success: function (data) {
		        	if (data.response == 1)
		        	{
		            	FormResponse('success',data,'langForm');
		            	 setInterval(function(){ location.reload() }, 2000);
		        	}
		            else
		            	FormResponse('failed',data,'langForm');
		        }
		    });
		    
		    return false;
		}); 
</script>
 @endsection

@Stop