@extends('layout.admin')

@section('title'){{trans('member.home')}} @Stop
@section('system-setting-class')active open @Stop
@section('setting-lang-requests')active @Stop

@section('extend-css')
 <link rel="stylesheet" href="{{asset('global/vendor/filament-tablesaw/tablesaw.css')}}">
<link rel="stylesheet" href="{{asset('global/vendor/c3/c3.css')}}">
@endsection 

@section('content')

<div class="page animsition">
    <div class="page-header">
      <h1 class="page-title"><i class="fa fa-cogs"></i> System :: Languages :: Translation Requests
      </h1>
    </div>
    <div class="page-content container-fluid">
      <div class="row">
        <div class="col-sm-12">
        
        
        <!-- check whether success or not -->
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <b>Success!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>Fail!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
    @endif
          <!-- Language List -->
            
            	<blockquote class="blockquote blockquote-warning">
              {!!Form::open(array('route' => 'admin-member-post-language-request', 'class'=>'form-inline', 'id'=>'lang_req_form','method'=>'POST'))!!}
                <div class="form-group form-material">
                  <label for="inputInlineUsername" class="control-label">ID :</label>
                 <input type="text" autocomplete="off" placeholder="Enter User ID" name="filter_id" id="filter_id" value="" class="form-control input-lg">
                </div>
                <div class="form-group form-material">
                  <label for="inputInlineUsername" class="control-label">Email :</label>
                 <input type="text" autocomplete="off" placeholder="Enter Email" name="filter_email" id="filter_email" value="" class="form-control input-lg">
                </div>
                <div class="form-group form-material">
                  <label for="inputInlinePassword" class="control-label">Alias :</label>
                  <input type="text" autocomplete="off" placeholder="Enter Username" name="filter_alias" id="filter_alias" value="" class="form-control input-lg">
                </div>
                
                <div class="row hide" id="loaderBox">
                <div class="col-md-12">
          		<div class="form-group form-material">
                        <div class="col-md-12" id="quickInfo">
                        </div>
                    </div>
                </div>
                
                
                
                
                 
                    </div>
                    
                    
                    
                   
                 <div class="form-group form-material hide chk">
                 <ul class="list-unstyled example chkBox">
                 <li><input type="checkbox" id="selecctall"/> Selecct All</li>
                  @foreach($langFiles as $lFiles)
                  <li class="m-b-5">
                  	@foreach($lFiles as $fle)
                    <input type="checkbox" value="{{$fle->filename}}" class="icheckbox-primary checkbox1" name="lang_files[]"
                    data-plugin="iCheck" data-checkbox-class="icheckbox_flat-blue"
                    />
                    <label for="inputUnchecked" class="p-r-10">{{$fle->filename}}</label>
                    @endforeach
                  </li>
                  @endforeach
                </ul>
                
               
                   
                   
                 </div>
                 
                 <div class="row">
	                <div class="col-md-12">
	                  		<div class="alert alert-success hide" role="alert">
					        <i class="fa fa-info pull-right"></i>
					         <span></span>
					       </div>
	                </div>
	                 
                 
                 
                 <div class="col-md-12 hide langBox">
                 <div class="col-md-3">
                 	<label>Choose Language</label>
                 </div>
                 <div class="col-md-7">
                 <ul class="list-unstyled">
                  @foreach($languages as $langs)
                   <li>
                   @foreach($langs as $lang)
                    <input type="radio" value="{{$lang->id}}" class="icheckbox-primary" id="inputRadiosChecked" name="language_id"
                    		data-plugin="iCheck" data-radio-class="iradio_flat-blue"
                    />
                    <label for="inputRadiosChecked">{{$lang->name}}</label>
                     @endforeach
                  </li>
                  @endforeach
                </ul>
                </div>
                <div class="col-md-2">
                 <span class="btn-area hide">
		                  <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">
		                  <i aria-hidden="true" class="icon md-plus pull-right"></i>Request</button>
		                  </span>
                  		<span class="loading hide"><img src="{{ asset('remark/images/loader/ajax-loader.gif') }}" /></span>
                 </div>
                 </div>
                 </div>
             
          		{!! Form::close() !!}
              </blockquote>
            	
            	
            <div class="nav-tabs-horizontal nav-tabs-inverse">
               
               <ul class="nav nav-tabs nav-tabs-solid" data-plugin="nav-tabs" role="tablist">
                  @foreach($AllLists as $langList)
                  <li class="{{($langList->sn==1)?'active':''}}" role="presentation">
                    <a data-toggle="tab" href="#Tab-{{$langList->langDetail->id}}" aria-controls="Tab-Summary"
                    role="tab">
                    <span>{{$langList->langDetail->code}}</span>
                    </span><img src="{{ asset('img/flags/'.$langList->langDetail->image.'') }}" />
                    </a>
                  </li>
                  @endforeach
                </ul>
                <div class="tab-content padding-top-15">
                @foreach($AllLists as $langList)
                <div class="tab-pane {{($langList->sn==1)?'active':''}}" id="Tab-{{$langList->langDetail->id}}" role="tabpanel">
                	<div class="row">
       				<div class="col-md-12">
		              <table class="table">
                            <thead>
                            <tr>
                                <td>Language Name</td>
                                <td>User (Alias,ID)</td>
                                <td>Language File</td>
                                <td>Status</td>
                                <td>Request On</td>
                                <td>Action</td>
                            </tr>
                            </thead>
                            <tbody>
                                    @foreach($langList->lists as $list)
                                        <tr>
                                            <td>{{ $list->name }}</td>
                                            <td>{{ $list->alias }} ({{ $list->user_id }})</td>
                                            <td>{{ $list->filename }}</td>
                                            <td><span class="badge badge-{{$list->cssname}}">{{ $list->translationStatus }}</span></td>
                                            <td>{{ $list->created_at }}</td>
                                            <td>
                                            @if($list->hasRecord)
                                            <a href="{{URL::route('admin-lang-trans-filedata',[Crypt::encrypt(''.$list->filename.''),$list->id])}}">
                                            <button class="btn btn-icon btn-warning btn-round waves-effect waves-round waves-light btn-sm" type="button">
                                             <i class="fa fa-eye" aria-hidden="true"></i></button>
                                             </a>
                                             @endif
                                           </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
		              
		              
		            </div>
          		</div>
                  </div> @endforeach
                </div>
                </div>
                         
          <!-- End Example Iconified Tabs -->
          
          
        </div>
        
      </div>
    </div>
  </div>
  
  
  
   
<!-- REQUEST FORM -->
 <div class="modal fade" id="transferPassport" aria-hidden="false" aria-labelledby="transferPassportLabel"
                  role="dialog" tabindex="-1">
                    <div class="modal-dialog">
                      <form action="{{ URL::route('admin-member-transfer-passport') }}" class="modal-content" method="POST">
                        <div class="modal-header">
                          <button aria-label="Close" data-dismiss="modal" class="close" type="button">
                            <span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="transferPassportLabel">Transfer Token To User ID : <span id="theuser2"></span></h4>
                        </div>
                        <div class="modal-body">
                        <input type="text" name="passport" class="form-control" placeholder="Passport"/>
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input id="modalid2" type="hidden" name="id" value="">
                          <div class="row">
                            <div class="col-lg-4 form-group hide">
                              <input type="text" placeholder="First Name" name="firstName" class="form-control">
                            </div>
                            <div class="col-sm-12 pull-right p-t-10">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                             <button type="submit" class="btn btn-primary waves-effect waves-light">Transfer Token</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
 <!-- REQUEST FORM --> 
 @section('extend-js')
<script src="{{asset('global/vendor/filament-tablesaw/tablesaw.js')}}"></script>
  <script src="{{asset('global/vendor/filament-tablesaw/tablesaw-init.js')}}"></script>
  
  <script src="{{asset('global/js/components/tabs.js')}}"></script>
  <script src="{{asset('global/js/plugins/responsive-tabs.js')}}"></script>
   <script>
//var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


$(document).ready(function(){
    $("#selecctall").change(function(){
      $(".checkbox1").prop('checked', $(this).prop("checked"));
      });
});

$(function(){
	   var myHandler = function(e){ 
		   $('#loaderBox').addClass('hide');
		   $('.btn-area').addClass('hide');
		   var 
		   step        = $('#lang_req_form')
		   data = step.serializeArray();
		   var input_name = e.target.name
		   		input_id = e.target.id
		   		input_value = $('#' + input_id).val();
		   		$.ajax({
	               type: step.attr('method'),
	               url: "{{URL::route('admin-member-postkeyup-language-request')}}",
	               data: data,
	               dataType:'json',
	               success: function (data) {
	            	   $('#loaderBox').removeClass('hide');
	            	   $('#quickInfo').html(data.content);
	            	   $('.chk').removeClass('hide');
	            	   $('.langBox').removeClass('hide');
	            	   
	            	    $('.chk input[type="checkbox"]').each(function() { 
	            		   if ($.inArray($(this).attr('value'), data.hasRecord) > -1)
	            			   $(this).prop( "checked", true );
	            		});
	      				
	      				if(data.btnStatus)
	      				$('.btn-area').removeClass('hide');
	               }
          		 });
		    };
	   //Bind it:
	   $("#lang_req_form input[type=text]").on('keyup',function(e){ myHandler(e);  });

	});

$("#lang_req_form").on("submit", function(e){
	FormResponse('processing','','lang_req_form');
    $.ajax({
        type: 'post',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function (data) { 
            if (data.response == 1){
            	 $('.langBox').addClass('hide');
            	 FormResponse('success',data,'lang_req_form');
            	 setTimeout(function(){location.reload();},3000);
            }
            else
            	FormResponse('failed',data,'lang_req_form');
            
        }
    });
    return false;
    
});
</script>
 @endsection

@Stop