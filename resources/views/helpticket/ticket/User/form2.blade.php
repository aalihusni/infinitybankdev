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

				{!! Form::open(['action'=>'Member\helpdesk\FormController@getForm','method'=>'post','id'=>'ticketForm',]) !!}
				<div class="col-lg-8">
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
									{!! Form::label('help_topic', 'Before you open a ticket, please select the purpose of your ticket. This is to ensure your ticket can be solved as soon as possible.') !!}
								</div>

								<div class="col-md-12 form-group">
									<div class="form-group">
										<label class="col-md-1 control-label" for="inputSuccess"></label>
										<div class="col-md-11">
											
											@foreach($helptopic as $topic)
											<div class="radio">
												<label>
													<input type="radio" name="topic" id="optionsRadios{{$topic->id}}" value="{{$topic->id}}" required>
													<strong>{{$topic->topic}}</strong> - {{$topic->description}}
												</label>
											</div>
											@endforeach
											<!-- 
											<div class="radio">
												<label>
													<input type="radio" name="topic" id="optionsRadios1" value="10" required>
													<strong>PASSPORT</strong> - Any issue related to purchasing passport/token/battery
												</label>
											</div>
											<div class="radio">
												<label>
													<input type="radio" name="topic" id="optionsRadios2" value="11">
													<strong>PH/GH</strong> - Regarding Provide Help (PH) or Get Help (GH)
												</label>
											</div>
											<div class="radio">
												<label>
													<input type="radio" name="topic" id="optionsRadios3" value="12">
													<strong>Upgrade Level/Sponsor/Hierarchy</strong> - Hierarchy issue regarding sponsoring or positioning during upgrading level.
												</label>
											</div>
											<div class="radio">
												<label>
													<input type="radio" name="topic" id="optionsRadios3" value="13">
													<strong>Others</strong> - Something else
												</label>
											</div>
											 -->
										</div>
										<div class="col-md-11">
											<br><br>
										</div>
									</div>
								</div>

							</div>

						</div>

						<footer class="panel-footer text-right">
						<span class="btn-area">
							<button class="btn btn-primary" type="submit">Continue Submit Ticket</button>
						</span>
						</footer>
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

	</script>
	<!-- /#page-wrapper -->

	@Stop