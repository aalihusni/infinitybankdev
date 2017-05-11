@extends('member.default')
@section('title')Support Center @Stop
@section('kb-manage-cat-class')nav-active @Stop
@section('kb-class')nav-expanded nav-active @Stop
@section('content')
@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

 <link href="{{asset('helpdesk/css/style.css')}}" rel="stylesheet" type="text/css" />
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
       
         
            <div class="col-lg-12">
            <h2 class="pb-lg">Category</h2>
                @if ($user_details['id_verify_status'] == 10 || $user_details['selfie_verify_status'] == 10)
                <div class="alert alert-danger">
                    <span class="fa fa-exclamation-triangle fa-4x pull-left" style="color:#a94442;"></span>
                    <p><strong>Verification Required</strong></p>
                    <p>Account verification is required to Get Help (GH). To verify your account, please <a class="text-danger" href="{{URL::route('verification')}}">Click Here!</a></p>
                </div>
                @endif
            </div>
            
            <div class="col-lg-12">
    				<section class="panel">
							<header class="panel-heading">
								<h2 class="panel-title">Basic
								<span class="pull-right"><a href="category/create" class="btn btn-primary btn-xs">Add Category</a></span>
								</h2>
							</header>
							<div class="panel-body">
							
								
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>{{Lang::get('helpdesk.name')}}</th>
											<th>{{Lang::get('helpdesk.create')}}</th>
											<th>{{Lang::get('helpdesk.action')}}(s)</th>
										</tr>
									</thead>
									<tbody>
									@foreach($categories as $cat)
										<tr class="gradeX" id="row-{{$cat->id}}">
											<td>{{$cat->name}}</td>
											<td>{{$cat->created_at->format('d M Y h.i A')}}
											</td>
											<td>
											<button data-toggle="modal" data-target="#deleteCategory" data-whatever="{{$cat->name}}" data-value="{{$cat->id}}" title="Remove" class="btn btn-danger btn-xs" type="button">
                                             <i aria-hidden="true" class="fa fa-trash"></i>
                                             </button>
											<a href="category/{{$cat->id}}/edit" class="btn btn-warning btn-xs"><i aria-hidden="true" class="fa fa-pencil"></i></a>&nbsp;
											<a href="{{url('category-list/'.$cat->slug)}}" class="btn btn-primary btn-xs"><i aria-hidden="true" class="fa fa-eye"></i></a>
												
								    			
								    	</td>
											
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</section>
    
    		</div>
    
            
            

        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>


<!-- MODAL DELETE -->
<div class="modal fade" id="deleteCategory" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title"></h3>
      </div>
      <form id="DeleteForm" method="post" action="{{ URL::route('category-delete') }}">
      {!! csrf_field() !!}
      <div class="modal-body">
        <p></p>
         <input type="hidden" name="category_id" value="" />
         <input type="hidden" name="custom_message" id="custom_message" />
      </div>
      <div class="alert alert-success m-10 p-5 hide" role="alert">
        <i class="fa fa-info pull-right"></i>
         <span></span>
       </div>
      <div class="modal-footer">
      <span class="loading hide"><img src="{{ asset('helpdesk/img/ajax-loader.gif') }}" /></span>
      <span class="btn-area pull-right">
        <button type="button" class="btn btn-success" id="YesDelete">Delete</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </span>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- MODAL DELETE -->
 <meta name="csrf-token" content="{{ csrf_token() }}" />
 <script src="{{asset('helpdesk/js/functions.js')}}"></script> 
 
 <script src="{{asset('assets/javascripts/tables/examples.datatables.default.js')}}"></script>
<script>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$('#deleteCategory').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var title = button.data('whatever') // Extract info from data-* attributes
	  var cat_id = button.data('value')
	  var modal = $(this)
	  modal.find('.modal-title').text('Are You Sure ? : ' + title)
	  modal.find('.modal-body input[name=category_id]').val(cat_id)
	  modal.find('.modal-body p').text(title)
		var DeleteForm = $('#DeleteForm');
		$("#YesDelete").click(function(ev){
		FormResponse('processing','','DeleteForm');
	    $.ajax({
	        type: 'post',
	        url: DeleteForm.attr('action'),
	        data: DeleteForm.serialize(),
	        dataType: 'json',
	        success: function (data) {
	            if (data.response == 0)
	            	FormResponse('failed',data,'DeleteForm');
	            else
	            {
	            	FormResponse('success',data,'DeleteForm');
	            	$('#row-'+cat_id).fadeOut(1000);
	            }
	            
	        }
	    });
	    ev.preventDefault();
	});
	})
</script>
<!-- /#page-wrapper -->

@Stop