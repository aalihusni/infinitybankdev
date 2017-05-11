@extends('member.default')
@section('title')Support Center @Stop
@section('kb-art-class')nav-active @Stop
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
  
<link rel="stylesheet" href="{{asset('assets/vendor/summernote/summernote.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/vendor/summernote/summernote-bs3.css')}}" />
		<style>
		.p-t-0{
		padding-top:0!important;
		}
		.m-t-0{
		margin-top:0!important;
		}
		.post-meta p{
		line-height:15px;
		}
		
		</style>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
            <h2 class="pb-lg hide">Articles</h2>
                @if ($user_details['id_verify_status'] == 10 || $user_details['selfie_verify_status'] == 10)
                <div class="alert alert-danger">
                    <span class="fa fa-exclamation-triangle fa-4x pull-left" style="color:#a94442;"></span>
                    <p><strong>Verification Required</strong></p>
                    <p>Account verification is required to Get Help (GH). To verify your account, please <a class="text-danger" href="{{URL::route('verification')}}">Click Here!</a></p>
                </div>
                @endif
            </div>
            
            <div class="col-md-9">
    		<section class="panel">
								<div class="panel-body">
							       <header class="panel-heading panel-heading-transparent">
							            <h2 class="m-t-0">{{$arti->name}}</h2>
							            <div class="tm-meta">
											<span>
											<i class="fa fa-film fa-fw"></i> <time datetime="2013-09-19T20:01:58+00:00">{{$arti->created_at->format('l, d-m-Y')}}</time>
											</span>
											<span>
												<i class="fa fa-folder-open-o fa-fw"></i> <a href="#">{{$category->name}}</a>
											</span>
											<span class="pull-right">
											@foreach($languages as $vasa)
														<a href="{{url('show/'.$vasa->slug)}}" title="{{$vasa->name}}">
														<span style="font-size: 11px;margin: 0 4px 0 0;">
														{{ $vasa->filename }}</span><img src="{{ asset('img/flags/'.$vasa->image.'') }}" /></a>
														@endforeach
											</span>
										</div>
							        </header><!-- .entry-header -->
						        <hr style="margin-top:0!important;">
						        <div class="clearfix">
						            <p>{!!$arti->description!!}</p>
						        </div><!-- .entry-content -->
						        <div class="timeline">
						
						        <ul class="simple-post-list">
										@foreach($comments as $com)
										<li>
											<div class="post-image">
												<div class="img-thumbnail">
													<a href="#">
														<img alt="" src="{{S3Files::url('profiles/'.$com->profile_pic.'')}}" width="50">
													</a>
												</div>
											</div>
											<div class="post-info">
											<span>
												<i class="fa fa-user fa-fw"></i> <a href="#">{{$com->firstname}} {{$com->lastname}}</a>
											</span>
											<span>
											<i class="fa fa-film fa-fw"></i> <time datetime="2013-09-19T20:01:58+00:00">
											{{$com->created_at->format('l, d-m-Y')}}</time>
											</span>
											
												
												<div class="post-meta">
												{!! $com->comment !!}
												
												</div>
												
											</div>
										</li>
										@endforeach
										
										
									</ul></div>
						        
								</div>
							</section>
							
							<section class="panel">
								<header class="panel-heading">
									<div class="panel-actions">
										<a data-panel-toggle="" class="panel-action panel-action-toggle" href="#"></a>
										<a data-panel-dismiss="" class="panel-action panel-action-dismiss" href="#"></a>
									</div>

									<h2 class="panel-title">Leave a Reply</h2>
								</header>
								<div class="panel-body">
								{!! Form::open(['method'=>'post','url'=>'postcomment/'.$arti->slug,'class'=>'form-horizontal form-bordered','name'=>"commentForm", 'id'=>"commentForm"]) !!}
											<textarea class="hide" name="comment"></textarea>
											<div class="form-group">
												<div class="col-md-12">
												
													<div class="summernote" name="dd"
													data-plugin-summernote data-plugin-options='{ "height": 120, "codemirror": { "theme": "ambiance" } }'>
													</div>
												</div>
												
												<div class="col-md-12">
							      				<span class="btn-area">
							      				<button class="mb-xs mt-xs mr-xs btn btn-primary" type="submit" id="SubmitBtn">Post Message</button>
							                      </span>
							                      <span class="loading hide"><img src="{{ asset('helpdesk/img/ajax-loader.gif') }}" /></span>
												</div>
												
												<div class="col-md-offset-1 col-md-10 alert alert-success hide p-20" role="alert">
        										<i class="fa fa-info pull-right"></i>
         										<span></span>
       											</div>
											</div>
								{!!Form::close()!!}
								</div>
							</section>
    </div>
    <div class="col-md-3">
    
							<section class="panel">
								<header class="panel-heading panel-heading-transparent">
									<div class="panel-actions">
										<a data-panel-toggle="" class="panel-action panel-action-toggle" href="#"></a>
										<a data-panel-dismiss="" class="panel-action panel-action-dismiss" href="#"></a>
									</div>

									<h2 class="panel-title">Categories</h2>
								</header>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-striped mb-none">
											<thead>
												<tr>
													<th>Title</th>
													<th>Total</th>
												</tr>
											</thead>
											<tbody>
											@foreach($categorys as $cat)
												<tr>
													<td><a href="{{url('category-list/'.$cat->slug)}}">{{$cat->name}}</a></td>
													<td><span class="badge">{{$cat->total}}</span></td>
												</tr>
											@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</section>
						
    </div>
            
            

        </div>
        <!-- /.row -->
        
        
    </div>
    <!-- /.container-fluid -->
</div>
<script src="{{asset('assets/vendor/summernote/summernote.js')}}"></script>
<script src="{{asset('helpdesk/js/functions.js')}}"></script> 

<script>
$('.note-editable').focusout(function() { 
    $('#note-editable').val($('.Editor-editor').html());
});

var commentForm = $('#commentForm');
//$("#SubmitBtn").click(function(ev){
$("#commentForm").on("submit", function(e){
$('textarea[name="comment"]').html($('.summernote').code());
FormResponse('processing','','commentForm');
$.ajax({
 type: 'post',
 url: commentForm.attr('action'),
 data: commentForm.serialize(),
 dataType: 'json',
 success: function (data) {
     if (data.response == 1){
    	 FormResponse('success',data,'commentForm');
    	 setTimeout(function()
         		{
 			     location.reload();
         		},3000)
     }
     else
    	 FormResponse('failed',data,'commentForm');
     
 }
});
return false;
ev.preventDefault();
});
</script>
<!-- /#page-wrapper -->

@Stop