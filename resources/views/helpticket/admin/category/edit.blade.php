@extends('admin.default')

@section('title'){{trans('member.emails')}} @Stop
@section('homeclass')nav-active @Stop

@section('content')

 <link href="{{asset('helpdesk/css/style.css')}}" rel="stylesheet" type="text/css" /> 
 <link href="{{asset('helpdesk/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet" type="text/css" /> 
        <!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
            <h2 class="pb-lg">Edit Category</h2>
                @if ($user_details['id_verify_status'] == 10 || $user_details['selfie_verify_status'] == 10)
                <div class="alert alert-danger">
                    <span class="fa fa-exclamation-triangle fa-4x pull-left" style="color:#a94442;"></span>
                    <p><strong>Verification Required</strong></p>
                    <p>Account verification is required to Get Help (GH). To verify your account, please <a class="text-danger" href="{{URL::route('verification')}}">Click Here!</a></p>
                </div>
                @endif
            </div>
            <div class="col-lg-12">
            {!! Form::model($category,['url' => 'category/'.$category->id , 'id'=>'categoryForm','method' => 'PATCH'] )!!}
    		<section class="panel">
								<header class="panel-heading">
									<div class="panel-actions hide">
										<a data-panel-toggle="" class="panel-action panel-action-toggle" href="#"></a>
										<a data-panel-dismiss="" class="panel-action panel-action-dismiss" href="#"></a>
									</div>
									<h2 class="panel-title">Edit : {{$category->name}}</h2>
									
								</header>
								<div class="panel-body">
									<div class="row">
					<div class="col-xs-6 form-group">
						{!! Form::label('name',Lang::get('helpdesk.name')) !!}
						{!! Form::text('name',null,['class' => 'form-control']) !!}
					</div>

					<div class="col-xs-3 form-group">
						{!! Form::label('slug',Lang::get('helpdesk.slug')) !!}
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
			{!! Form::textarea('description',null,['class' => 'form-control', 'data-plugin-summernote data-plugin-options'=>'{ "height": 100, "codemirror": { "theme": "ambiance" } }', 
			'id'=>'description','placeholder'=>'Enter the description']) !!}
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
<!-- /#page-wrapper -->





</div>


</div>

</div>

<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('helpdesk/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
        $(function () {
            $("textarea").wysihtml5();
        });
            
   </script>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('helpdesk/js/functions.js')}}"></script> 
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
@Stop