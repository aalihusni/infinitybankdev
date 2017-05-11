@extends('member.default')
@section('title')Support Center @Stop
@section('ticket-create-class')nav-active @Stop
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
				<div class="col-lg-12 hide">
					<h2 class="pb-lg">Add Article</h2>

				</div>

				{!! Form::open(['action'=>'Member\helpdesk\FormController@postedForm','method'=>'post','id'=>'ticketForm',]) !!}
				<div class="col-lg-12">
					<section class="panel">
						<header class="panel-heading">
							<div class="panel-actions hide">
								<a data-panel-toggle="" class="panel-action panel-action-toggle" href="#"></a>
								<a data-panel-dismiss="" class="panel-action panel-action-dismiss" href="#"></a>
							</div>

							<h2 class="panel-title">Submit A Ticket</h2>


						</header>
						<div class="panel-body">
							<div class="row">

								<div class="col-md-12 form-group {{ $errors->has('help_topic') ? 'has-error' : '' }}">
									{!! Form::hidden('helptopic',$topic,['id' => 'selectid','class' => 'form-control']) !!}
								</div>

								<div class="col-md-12 form-group">
									{!! Form::label('Subject',Lang::get('helpdesk.subject')) !!}
									{!! Form::text('Subject',null,['class' => 'form-control']) !!}
								</div>



								<div class="col-md-12 form-group">
									{!! Form::label('description',Lang::get('helpdesk.message')) !!}

											<!--{!! Form::textarea('Details',null,['class' => 'form-control','id'=>'Details','data-plugin-summernote data-plugin-options'=>'{ "height": 100, "codemirror": { "theme": "ambiance" } }',  'placeholder'=>Lang::get('helpdesk.enter_the_description') ]) !!}
											-->
									<textarea class="hide" name="Details"></textarea>
									<div class="summernote" data-plugin-summernote data-plugin-options='{ "height": 200, "codemirror": { "theme": "ambiance" } }'></div>

								</div>

								{!! Form::hidden('custom_msg',null) !!}

								<div class="col-md-12 form-group">
									<div class="alert alert-success hide" role="alert">
									<span></span>
										<i class="fa fa-info pull-right"></i>
									</div>
								</div>
							</div>

						</div>

						<footer class="panel-footer">
						<span class="btn-area text-right">
							<button class="btn btn-primary text-right">{{Lang::get('helpdesk.save')}}</button>
						</span>
							<span class="loading hide"><img src="{{ asset('helpdesk/img/ajax-loader.gif') }}" /></span>
						</footer>
					</section>
				</div>

				<div class="col-lg-4 hide">

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
											{!! Form::radio('status','1',true) !!} {{Lang::get('helpdesk.published')}}
										</div>
										<div class="col-xs-6">
											{!! Form::radio('status','0',null) !!} {{Lang::get('helpdesk.draft')}}
										</div>
									</div>
								</div>
								<hr>
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
		$("#ticketForm").on("submit", function(e){
			//$('textarea').summernote();
			$('textarea[name="Details"]').html($('.summernote').code());

			FormResponse('processing','','ticketForm');
			$.ajax({
				type: 'post',
				url: $(this).attr('action'),
				data: $(this).serialize(),
				dataType: 'json',
				success: function (data) {
					if (data.response == 1){
						FormResponse('success',data,'ticketForm');
						setTimeout(function()
						{
							window.location.href = "{{url('/Mytickets')}}";
							//location.reload();
						},3000)
					}
					else
					{
						FormResponse('failed',data,'ticketForm');
					}
				}
			});
			return false;

		});
	</script>
	<!-- /#page-wrapper -->

	@Stop