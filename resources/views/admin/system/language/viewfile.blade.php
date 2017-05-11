@extends('layout.admin')

@section('title'){{trans('member.home')}} @Stop
@section('token-withdraw')active @Stop
@section('manage-main-class')open @Stop

@section('extend-css')

@endsection 

@section('content')

<div class="page animsition">
    <div class="page-header">
      <h5 class="page-title hide"><i class="fa fa-cogs"></i> System :: Languages
      </h5>
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
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Floating Lables</h3>
            </div>
            <div class="panel-body container-fluid">
              <form autocomplete="off">
                @foreach($mainData as $key => $txt)
                <div class="form-group form-material floating" style="margin:0 0 20px 0!important;"><!-- style="margin:0!important;" --> 
               <span class="help-block" style="margin:0 0 0 0!important;">English : <span style="color:#ff9800;">{!!$txt!!}</span></span>
                
                @if(strlen($txt) > 180)
                  <textarea class="form-control" name="{{$key}}" rows="2" name="textareaFloating">{{$selLangData[$key]}}</textarea>
                @else
                <input type="text" class="form-control input-sm" name="{{$key}}" value="{{$selLangData[$key]}}"/>
                @endif
                 <label class="floating-label hide">dsfasdf</label>
                </div>
                @endforeach
                
              </form>
            </div>
          </div>
          
          
          <div class="panel">
            <div class="panel-body">
              
             
               
             
             <button type="button" class="btn btn-primary" id="UpdateData">Save changes</button>
              
              <h2>Reference</h2>
                         
            </div>
          </div>
          <!-- End Example Iconified Tabs -->
          
          <!-- PAGE LIST -->
          
          <!-- PAGE LIST -->
        </div>
        
      </div>
    </div>
  </div>
  
  
  
  <meta name="csrf-token" content="{{ csrf_token() }}" />  
  <!-- MODAL DELETE -->

<!-- MODAL DELETE -->
 @section('extend-js')
  <script src="{{asset('global/js/components/tabs.js')}}"></script>
  <script src="{{asset('global/js/plugins/responsive-tabs.js')}}"></script>
   
   <script src="{{asset('global/js/components/jquery-placeholder.js')}}"></script>
  <script src="{{asset('global/js/components/material.js')}}"></script>
   <script>
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
   $( document ).ready(function() {
	     
	});
	$('#UpdateData').click(function(){
		var editorData = ace.edit("editedData");
		var myEditedData = editorData.getSession().getValue();
		$.ajax({
			url:"{{URL::route('admin-language-post-filedata')}}",
			data:{code:'<?=$langCode?>',fileName:'<?=$fileName?>',langData:myEditedData,_token:CSRF_TOKEN},
			method:'POST',
			dataType:'json',
			success:function(){
					alert('ddd');
				}

			});
		//alert(myEditedData);
	
	});
//var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

</script>
 @endsection

@Stop