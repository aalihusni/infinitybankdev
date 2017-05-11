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

		<link rel="stylesheet" href="{{asset('assets/vendor/summernote/summernote.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/vendor/summernote/summernote-bs3.css')}}" />

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
            <h2 class="pb-lg">Add Category</h2>
                @if ($user_details['id_verify_status'] == 10 || $user_details['selfie_verify_status'] == 10)
                <div class="alert alert-danger">
                    <span class="fa fa-exclamation-triangle fa-4x pull-left" style="color:#a94442;"></span>
                    <p><strong>Verification Required</strong></p>
                    <p>Account verification is required to Get Help (GH). To verify your account, please <a class="text-danger" href="{{URL::route('verification')}}">Click Here!</a></p>
                </div>
                @endif
            </div>
            
            <div class="col-lg-12">
            
    		{!! Form::open(array('action' => 'Member\Manage\kb\CategoryController@store' , 'id'=>'categoryForm', 'method' => 'post') )!!}
    		<section class="panel">
								<header class="panel-heading">
									<div class="panel-actions hide">
										<a data-panel-toggle="" class="panel-action panel-action-toggle" href="#"></a>
										<a data-panel-dismiss="" class="panel-action panel-action-dismiss" href="#"></a>
									</div>

									<h2 class="panel-title">Add Category</h2>

									<p class="panel-subtitle">
										This is an example of form with multiple block columns.
									</p>
								</header>
								<div class="panel-body">
									<div class="row">
					<div class="col-xs-6 form-group">
			
						{!! Form::label('name',Lang::get('helpdesk.name')) !!}
						{!! $errors->first('name', '<spam class="help-block">:message</spam>') !!}
						{!! Form::text('name',null,['class' => 'form-control']) !!}
			
					</div>

					<div class="col-xs-3 form-group">
			
						{!! Form::label('slug',Lang::get('helpdesk.slug')) !!}
						{!! $errors->first('slug', '<spam class="help-block">:message</spam>') !!}
						{!! Form::text('slug',null,['class' => 'form-control']) !!}
			
					</div>

				<div class="col-xs-3 form-group">
					{!! Form::label('status',Lang::get('helpdesk.status')) !!}
					{!! $errors->first('status', '<spam class="help-block">:message</spam>') !!}
					<br/>
							{!! Form::radio('status','1',true) !!} {{Lang::get('helpdesk.active')}}
							{!! Form::radio('status','0',null) !!} {{Lang::get('helpdesk.inactive')}}
				</div>

		<div class="col-md-12 form-group">
			{!! Form::label('description',Lang::get('helpdesk.description')) !!}
			{!! Form::textarea('description',null,['class' => 'form-control','id'=>'description','data-plugin-summernote data-plugin-options'=>'{ "height": 100, "codemirror": { "theme": "ambiance" } }',  'placeholder'=>Lang::get('helpdesk.enter_the_description') ]) !!}
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
    		{!! Form::close() !!}		
    
    		</div>
    
            
            

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
$("#categoryForm").on("submit", function(e){
	FormResponse('processing','','categoryForm');
    $.ajax({
        type: 'post',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function (data) { 
            if (data.response == 1)
            	FormResponse('success',data,'categoryForm');
            else
            {
            	FormResponse('failed',data,'categoryForm');
            }
        }
    });
    return false;
    
});
</script>
<!-- /#page-wrapper -->

@Stop