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

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
            <h2 class="pb-lg">{{$Category->name}}</h2>
                @if ($user_details['id_verify_status'] == 10 || $user_details['selfie_verify_status'] == 10)
                <div class="alert alert-danger">
                    <span class="fa fa-exclamation-triangle fa-4x pull-left" style="color:#a94442;"></span>
                    <p><strong>Verification Required</strong></p>
                    <p>Account verification is required to Get Help (GH). To verify your account, please <a class="text-danger" href="{{URL::route('verification')}}">Click Here!</a></p>
                </div>
                @endif
            </div>
            <div class="col-lg-8">
           
    
    <section class="panel">
								
								<div class="panel-body">
									<div class="timeline timeline-simple mt-xlg mb-md" style="margin-top:0!important;">
										<div class="tm-body" style="padding-top:0!important;">
											<ol class="tm-items">
												 @foreach($articles as $arti)
												<li>
													<div class="tm-box">
														<p class="text-muted mb-none"><span class="date"><i class="fa fa-clock-o fa-fw"></i> 
														<time>
														{{$arti->created_at}}</time></span> , <!-- {{$arti->created_at->diffForHumans()}}.  -->
														@foreach($arti->languages as $vasa)
														<a href="javascript:void(0)" @if($arti->totalLang>1) onClick="loadDetail({{$arti->article_id}},{{$vasa->id}},'{{$arti->slug}}')" @endif>
														<span style="font-size: 11px;margin: 0 4px 0 0;">
														{{ $vasa->filename }}</span><img src="{{ asset('img/flags/'.$vasa->image.'') }}" /></a>
														@endforeach
														</p>
														<span id="article-{{$arti->article_id}}">
														<h4>
															<i class="fa fa-list-alt fa-2x fa-fw pull-left text-muted"></i> {{$arti->name}} 
														</h4>
														<p>{!! str_limit(strip_tags($arti->description),220) !!}
														<a class="readmore-link" href="{{url('show/'.$arti->slug)}}">{!! Lang::get('helpdesk.read_more') !!}</a>
														</p>
														<p class="pull-right hide">
															<a class="readmore-link" href="{{url('show/'.$arti->slug)}}">{!! Lang::get('helpdesk.read_more') !!}</a>
														</p>
														</span>
														<p>&nbsp;</p>
														
													</div>
												</li>
												@endforeach
												
											</ol>
										</div>
									</div>
								</div>
							</section>
    </div>
    <div class="col-lg-4">
    
							<section class="panel">
								<header class="panel-heading panel-heading-transparent">
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
 <meta name="csrf-token" content="{{ csrf_token() }}" />
<script>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    function loadDetail(articleID,LangId,slug)
    {
        $.ajax({
        	 type: 'post',
        	 url: "{{URL::route('member-article-selected-lang')}}",
           	 data:{articleID:articleID,langID:LangId,_token:CSRF_TOKEN,slug:slug},
        	 dataType: 'html',
        	 success: function (data) {
            	 $('#article-'+articleID+'').html(data);
        	 }
       });
    };
</script>
<!-- /#page-wrapper -->

@Stop