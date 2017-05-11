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
            <h2 class="pb-lg">Manage Article</h2>
            </div>
            {!! Form::model($artDetail,['url' => 'article/'.$article->id , 'id'=>'articleForm','method' => 'PATCH'] )!!}
            <div class="col-lg-8">
    		<section class="panel">
								<header class="panel-heading">
									<div class="panel-actions hide">
										<a data-panel-toggle="" class="panel-action panel-action-toggle" href="#"></a>
										<a data-panel-dismiss="" class="panel-action panel-action-dismiss" href="#"></a>
									</div>
									<h2 class="panel-title">Edit Article</h2>
									
								</header>
								<div class="panel-body">
									<div class="row">
					<div class="col-xs-12 form-group">
						{!! Form::label('name',Lang::get('helpdesk.name')) !!}
						{!! Form::text('name',null,['class' => 'form-control']) !!}
					</div>

				

		<div class="col-md-12 form-group">
			{!! Form::label('description',Lang::get('helpdesk.description')) !!}
			{!! Form::textarea('description',null,['class' => 'form-control','id'=>'description',  'placeholder'=>Lang::get('helpdesk.enter_the_description') ]) !!}
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
									<h2 class="panel-title">{{Lang::get('helpdesk.published')}}</h2>
								</header>
								<div class="panel-body">
									<div class="row">
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
										<input type="radio" name="category_id" value="{{$val}}" {{($article->category_id==$val)?'checked':''}}>
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
					<div class="col-xs-12 form-group">
						{!! Form::label('language','Language') !!}
						<div class="row">
							<div class="col-xs-12">
							<span style="font-size: 11px;margin: 0 4px 0 0;">
							{{ $language->name }}</span><img src="{{ asset('img/flags/'.$language->image.'') }}" />
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
$("#articleForm").on("submit", function(e){
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
            			window.location.href = "{{url('/Admin/Manage/Article')}}";
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
@Stop