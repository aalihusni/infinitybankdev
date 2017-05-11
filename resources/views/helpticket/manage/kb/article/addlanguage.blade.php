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

		<link rel="stylesheet" href="{{asset('assets/vendor/summernote/summernote.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/vendor/summernote/summernote-bs3.css')}}" />

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
            <h2 class="pb-lg">Add More Language On Article</h2>
                
            </div>
            {!! Form::open(['route' => 'post-article-add-lang' , 'id'=>'articleForm','method' => 'post'] )!!}
            {!! Form::hidden('article_id', $article->id) !!}
            {!! Form::hidden('article_detail_id','') !!}
            <div class="col-lg-8">
    		<section class="panel">
								<header class="panel-heading">
									<div class="panel-actions hide">
										<a data-panel-toggle="" class="panel-action panel-action-toggle" href="#"></a>
										<a data-panel-dismiss="" class="panel-action panel-action-dismiss" href="#"></a>
									</div>
									<h2 class="panel-title">Add More Language For Article</h2>
									<p class="panel-subtitle">
										{{$artDetail->name}}
									</p>
								</header>
								<div class="panel-body">
									<div class="row">
					<div class="col-xs-12 form-group">
						{!! Form::label('name',Lang::get('helpdesk.name')) !!}
						{!! Form::text('name',null,['class' => 'form-control']) !!}
						<p>English : {{$artDetail->name}}</p>
					</div>

				

		<div class="col-md-12 form-group">
			{!! Form::label('description',Lang::get('helpdesk.description')) !!}
			<textarea class="hide" name="description"></textarea>
			<div class="summernote" data-plugin-summernote data-plugin-options='{ "height": 120, "codemirror": { "theme": "ambiance" } }'>
			</div>
			
			<!-- {!! Form::textarea('description',null,['class' => 'form-control','id'=>'description','data-plugin-summernote data-plugin-options'=>'{ "height": 100, "codemirror": { "theme": "ambiance" } }',  'placeholder'=>Lang::get('helpdesk.enter_the_description') ]) !!}
				 -->
		<p>{!!$artDetail->description!!}</p>
		</div>
		<div class="col-md-12 form-group">
		<div class="alert alert-success hide" role="alert">
        				<i class="fa fa-info pull-right"></i>
         				<span></span>
       				</div></div>
		</div>
								</div>
								<footer class="panel-footer">
		        					<span class="btn-area">
									<button class="btn btn-primary">{{Lang::get('helpdesk.save')}}</button>
									</span>
									<span class="loading hide"><img src="{{ asset('helpdesk/img/ajax-loader.gif') }}" /></span>
								</footer>
							</section>
			</div>
			 <div class="col-lg-4">
			 <section class="panel">
								<header class="panel-heading">
									<div class="panel-actions hide">
										<a data-panel-toggle="" class="panel-action panel-action-toggle" href="#"></a>
										<a data-panel-dismiss="" class="panel-action panel-action-dismiss" href="#"></a>
									</div>
									<h2 class="panel-title">Language / Status / Category</h2>
								</header>
								<div class="panel-body">
									<div class="row">
					
					<div class="col-xs-12 form-group">
						{!! Form::label('type',Lang::get('helpdesk.select-language')) !!}
						<div class="row">
							<div class="col-xs-12">
							@foreach ($languages as $la)
							@if(!in_array($la->id,$existingLangs))
							<div class="row">
								<div class="form-group">
									<div class="col-md-1">
										<input type="radio" name="language_id" value="{{$la->id}}">
									</div>
									<div class="col-md-10">
										{{$la->name}} <img src="{{ asset('img/flags/'.$la->image.'') }}" />
									</div>
								</div>
							</div>
							@endif
						@endforeach
							</div>
						</div>
					</div>
					
					<div class="col-xs-12 form-group">
						{!! Form::label('type',Lang::get('helpdesk.status')) !!}
						<div class="row">
							<div class="col-xs-6">
							<input type="radio" name="status" value="1" {{($article->status==1)?'checked':''}}>
							{{Lang::get('helpdesk.published')}}
							</div>
							<div class="col-xs-6">
							<input type="radio" name="status" value="0" {{($article->status==0)?'checked':''}}>
							{{Lang::get('helpdesk.draft')}}
							</div>
						</div>
					</div>
					<hr>
					<div class="col-xs-12 form-group">
						{!! Form::label('type',Lang::get('helpdesk.category')) !!}
						<div class="row">
							<div class="col-xs-12">
							@foreach ($categories as $key=>$val)
							<div class="row">
								<div class="form-group">
									<div class="col-md-1">
										<input disabled type="radio" name="category_id" value="{{$val}}" {{($article->category_id==$val)?'checked':''}}>
									</div>
									<div class="col-md-10">
										{{$key}}
									</div>
								</div>
							</div>
						@endforeach
							</div>
						</div>
					</div>
					
		
		</div>
								</div>
								
							</section>
			 
			 </div>
    		{!! Form::close() !!}		
    
    		
    
            
            

        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
 <meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('helpdesk/js/functions.js')}}"></script> 
 
<script src="{{asset('assets/vendor/summernote/summernote.js')}}"></script>
<script>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$("#articleForm").on("submit", function(e){
	$('textarea[name="description"]').html($('.summernote').code());
	FormResponse('processing','','articleForm');
    $.ajax({
        type: 'post',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function (data) { 
            if (data.response == 1){
            	FormResponse('success',data,'articleForm');
            	setTimeout(function()
                 		{
            			window.location.href = "{{url('/article')}}";
         			     //location.reload();
                 		},2000)
            }
            else
            {
            	FormResponse('failed',data,'articleForm');
            }
        }
    });
    return false;
    
});
</script>
<!-- /#page-wrapper -->

@Stop