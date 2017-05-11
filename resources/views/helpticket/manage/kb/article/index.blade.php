@extends('member.default')
@section('title')Support Center @Stop
@section('kb-manage-art-class')nav-active @Stop
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
            <h2 class="pb-lg">Articles</h2>
            </div>
            
            <div class="col-lg-12">
    				<section class="panel">
							<header class="panel-heading">
								<h2 class="panel-title">Basic
								<span class="pull-right"><a href="article/create" class="btn btn-primary btn-xs">Add Article</a></span>
								</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>{{Lang::get('helpdesk.name')}}</th>
											<th>Languages</th>
											<th>{{Lang::get('helpdesk.create')}}</th>
											<th>{{Lang::get('helpdesk.action')}}(s)</th>
										</tr>
									</thead>
									<tbody>
									@foreach($articles as $art)
										<tr class="gradeX" id="row-{{$art->article_id}}">
											<td>{{$art->name}}</td>
											<td>@foreach($art->languages as $vasa)
											<div class="btn-group" role="group" aria-label="..." id="btnGroup-{{$vasa->id}}">
											<!-- <button type="button" class="btn btn-default btn-xs">{{ $vasa->code }}</button>-->
											<button type="button" class="btn btn-default btn-xs">
											<img src="{{ asset('img/flags/'.$vasa->image.'') }}" /></button>
											@if($vasa->added_by == Auth::user()->id)
											<button data-toggle="modal" data-target="#deleteArticle" 
											data-whatever="{{$art->name}} ({{$vasa->name}})" 
											data-value="{{$art->article_id}}" data-language="{{$vasa->id}}" title="Remove" class="btn btn-danger btn-xs" type="button">
                                             <i aria-hidden="true" class="fa fa-trash"></i>
                                             </button>
                                             <a href="Manage/Article/Edit/{{$art->article_id}}/{{$vasa->id}}" class="btn btn-warning btn-xs"><i aria-hidden="true" class="fa fa-pencil"></i></a>
                                             @endif
                                             <!-- 
														<span style="font-size: 11px;margin: 0 4px 0 0;">
														{{ $vasa->filename }}</span><img src="{{ asset('img/flags/'.$vasa->image.'') }}" /> -->
														</div>
														@endforeach
														@if($art->addMore)
                                            		 <a href="{{URL::route('manage-article-add-lang',[$art->article_id])}}" 
                                            		 title="Add More Language" class="btn btn-success btn-xs pull-right" type="button">
                                             				<i aria-hidden="true" class="fa fa-plus-circle"></i>
                                            		 </a>
													@endif
											</td>
											<td>{{$art->created_at}}</td>
											<td>
											@if($art->can_delete)
											<button data-toggle="modal" data-target="#deleteArticle" 
											data-whatever="{{$art->name}}" data-value="{{$art->article_id}}" 
											data-language="{{$art->language_id}}"
											title="Remove" class="btn btn-danger btn-xs" type="button">
                                             <i aria-hidden="true" class="fa fa-trash"></i>
                                             </button>
											<a href="article/{{$art->article_detail_id}}/edit" class="btn btn-warning btn-xs"><i aria-hidden="true" class="fa fa-pencil"></i></a>&nbsp;
											@endif
											<a href="{{url('show/'.$art->slug)}}" class="btn btn-primary btn-xs"><i aria-hidden="true" class="fa fa-eye"></i></a>
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
<div class="modal fade" id="deleteArticle" tabindex="-1" role="dialog" aria-labelledby="deleteArticleLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title"></h3>
      </div>
      <form id="DeleteForm" method="post" action="{{ URL::route('article-delete') }}">
      {!! csrf_field() !!}
      <div class="modal-body">
        <p></p>
         <input type="hidden" name="article_id" value="" />
          <input type="hidden" name="language_id" value="" />
         
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
$('#deleteArticle').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var title = button.data('whatever') // Extract info from data-* attributes
	  var article_id = button.data('value')
	  var language_id = button.data('language')
	  var modal = $(this)
	  modal.find('.modal-title').text('Are You Sure ? : ' + title)
	  modal.find('.modal-body input[name=article_id]').val(article_id)
	   modal.find('.modal-body input[name=language_id]').val(language_id)
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
	            	if(data.delRow=='1')
	            		$('#row-'+article_id).fadeOut(1000);
	            	else
	            	$('#btnGroup-'+language_id).fadeOut(1000);
	            		
	            }
	            
	        }
	    });
	    ev.preventDefault();
	});
	})
</script>
<!-- /#page-wrapper -->

@Stop