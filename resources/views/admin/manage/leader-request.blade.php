@extends('layout.admin')

@section('title'){{trans('member.home')}} @Stop


@section('system-setting-class')active open @Stop
@section('leadership-requests')active @Stop

@section('extend-css')
  <link rel="stylesheet" href="{{asset('assets/examples/css/forms/layouts.css')}}">
@endsection 

@section('content')

<div class="page animsition">
    <div class="page-header">
      <h1 class="page-title"><i class="fa fa-cogs"></i> Leadership Requests :: All
      </h1>
    </div>
    <div class="page-content container-fluid">
      <div class="row">
        <div class="col-lg-12">
            <!-- Example Continuous Accordion -->
            <div class="examle-wrap">
              <h4 class="example-title">Leadership Requests :: All</h4>
              <div class="example">
                <div role="tablist" aria-multiselectable="true" id="ListAccordionContinuous" class="panel-group panel-group-continuous">
                   @foreach($lists as $list)
                  <div class="panel">
                    <div role="tab" id="listHeading{{$list->id}}" class="panel-heading">
                      <a aria-expanded="false" aria-controls="listCollapse{{$list->id}}" href="#listCollapse{{$list->id}}" data-id="{{$list->id}}" data-toggle="collapse" data-parent="#ListAccordionContinuous" class="panel-title">
                      <span class="badge badge-primary">{{ $list->id }}</span> &nbsp;&nbsp;{{ $list->name }} , {{ $list->email }} , <i class="fa fa-mobile" aria-hidden="true"></i> {{ $list->phone }}  
                      <span class="pull-right text-primary"><i class="fa fa-calendar" aria-hidden="true"></i> {{ $list->created_at }}&nbsp;&nbsp;</span>
                    </a>
                    </div>
                    <div role="tabpanel" aria-labelledby="listHeading{{$list->id}}" id="listCollapse{{$list->id}}" class="panel-collapse collapse">
                      <div class="panel-body p-t-0">
                        <table class="table"><tbody>
                        <tr>
                                           
                                             <td>
                                             @if($list->is_member) <i class="fa fa-user" aria-hidden="true"></i>
                                             <a href="{{ URL::to('/') }}/admin/quick-login/{{ App\User::whereAlias($list->member_alias)->pluck('id') }}"> {{$list->member_alias}}</a>
                                             <br>
                                              @endif
                                             <i class="fa fa-facebook-official" aria-hidden="true"></i>&nbsp;
                                             @if($list->fb_url)
                                              <a href="{{$list->fb_url}}" target="__BLANK">{{ $list->fb_name }}</a>
                                              @else NA
                                              
                                             @endif
                                              <br><i class="fa fa-weixin" aria-hidden="true"></i>
                                            @if($list->wechat_url) 
                                            <a href="{{$list->wechat_url}}" target="__BLANK">{{ $list->wechat_name }}</a>
                                            @else NA
                                           
                                            @endif
                                             <br>
                                            @foreach($list->social_account as $acc)
                                             	@if($acc)
                                             		<br><i class="fa fa-external-link" aria-hidden="true"></i>
                                             		<a href="{{$acc}}" target="__BLANK">{{ $acc }}</a>
                                             	@endif
                                             @endforeach
                                            
                                            </td>
                                            <td>{!! $list->convince_detail !!}</td>
                                            
                                            <td>
                                            @if($list->image)<a href="{{asset(''.$list->image.'')}}" target="__BLANK">
                                            <img src="{{asset(''.$list->image.'')}}" width="100"/></a><br><br>
                                            @endif
                                            @if($list->document)<a href="{{asset(''.$list->document.'')}}" target="__BLANK">
                                            <i class="fa fa-file-word-o" aria-hidden="true"></i> Attach File
											</a>
                                            @endif
                                             </td>
                                             
                                        </tr></tbody></table>
                                        <div role="alert" class="alert alert-info"><i class="fa fa-info-circle" aria-hidden="true"></i> {!!$list->description!!}</div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                  
                  
                </div> {!! str_replace('/?','?', $renderList->render()) !!}
              </div>
            </div>
            <!-- End Example Continuous Accordion -->
          </div>
        
        
        
        
        
        
      </div>
    </div>
  </div>
  
  
  
   
<!-- Modal -->
                  
                  
                  
                  
                  
                  
                  <!-- End Modal -->>
                  
                  
                  
                  <!-- EDIT -->
                  
                  <!-- EDIT -->
 @section('extend-js')
   <script>
 $('.panel-title').click(function(){
	 	$.ajax({
			url:"{{URL::route('admin-leadership-update')}}",
			type:'post',
			data:{req_id:$(this).data('id'),_token:'{{csrf_token()}}'},
			 dataType: 'json',
		        success: function (data) {
		           
		        }

		 	})
		
	 });
</script>
 @endsection

@Stop