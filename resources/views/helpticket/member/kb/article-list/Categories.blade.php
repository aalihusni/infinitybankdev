@extends('member.default')
@section('title')Support Center @Stop
@section('kb-cats-class')nav-active @Stop
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

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">

        
            <div class="col-lg-12">
            <h2 class="pb-lg">Categories</h2>

                @if ($user_details['id_verify_status'] == 10 || $user_details['selfie_verify_status'] == 10)
                <div class="alert alert-danger">
                    <span class="fa fa-exclamation-triangle fa-4x pull-left" style="color:#a94442;"></span>
                    <p><strong>Verification Required</strong></p>
                    <p>Account verification is required to Get Help (GH). To verify your account, please <a class="text-danger" href="{{URL::route('verification')}}">Click Here!</a></p>
                </div>
                @endif
            </div>
            
           @foreach($categories as $category)
						<div class="col-md-6">
							<section class="panel">
								<header class="panel-heading">
									<div class="panel-actions">
										<a data-panel-toggle="" class="panel-action panel-action-toggle" href="#"></a>
										<a data-panel-dismiss="" class="panel-action panel-action-dismiss" href="#"></a>
									</div>

									<h2 class="panel-title">
										<span class="label-md text-weight-normal va-middle"><i class="fa fa-folder-open-o fa-fw text-muted"></i></span>
										<span class="va-middle">{{$category->name}}</span>
										<span class="label label-primary label-sm text-weight-normal va-middle mr-sm">{{$category->total}}</span>
									</h2>
								</header>
								<div class="panel-body">
									<div class="content">
										<ul class="simple-user-list">
											
											@foreach($category->articles as $arti)
											<li>
												<figure class="image rounded">
													<img class="img-circle" alt="Joseph Doe Junior" 
													src="{{S3Files::url('profiles/'.$arti->profile_pic.'')}}" width="35"
													>
												</figure>
												<span class="title">{{$arti->name}}</span>
												<span class="title message">{{$arti->created_at}}</span>
												<span class="message truncate">{!!str_limit($arti->description,145)!!}
												<a class="readmore-link" href="{{url('show/'.$arti->slug)}}">{!! Lang::get('helpdesk.read_more') !!}</a>
												</span>
											</li>
											 @endforeach
											
										</ul>
										<hr class="dotted short">
										<div class="text-right">
											<a href="{{url('category-list/'.$category->slug)}}" class="text-uppercase text-muted">(View All)</a>
										</div>
									</div>
								</div>
								<div class="panel-footer hide">
									<div class="input-group input-search">
										<input type="text" placeholder="Search..." id="q" name="q" class="form-control">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
											</button>
										</span>
									</div>
								</div>
							</section>
							
						 
						</div>
 	@endforeach
            
            

        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>

<script>
    
</script>
<!-- /#page-wrapper -->

@Stop