@extends('layout.admin')

@section('title'){{trans('member.home')}} @Stop
@section('token-withdraw')active @Stop
@section('manage-main-class')open @Stop

@section('extend-css')
  <link rel="stylesheet" href="{{asset('remark/global/vendor/ace/ace.css')}}">

@endsection 

@section('content')

<div class="page animsition">
    <div class="page-header">
      <h1 class="page-title"><i class="fa fa-cogs"></i> System :: Languages
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
          <div class="panel">
            <div class="panel-body">
              
              {!!Form::open(array('route' => 'admin-update-translate-data', 'id'=>'lang-trans-form','method'=>'POST'))!!}
              <input type="hidden" name="fileName" value="<?=$fileName?>" />
              <input type="hidden" name="serial_number" value="<?=$RowDetail->id?>" />
              <pre class="ace-editor" id="editedData" data-plugin="ace" data-mode="javascript"
              style="width: 100%;">
              {!!$translatedData!!}
            </pre>
            
            <div class="col-md-12">
						<div class="form-group">
											<label class="col-sm-3 control-label">{{trans('general.text_lang_trans_progress')}} <span class="required">*</span></label>
											<div class="col-sm-9">
												<div class="radio-custom radio-primary">
													<input type="radio" value="0" name="status" id="status-0" {{($status==0)?'checked':''}}>
													<label for="status-0">{{Config::get('settings.translationStaus')[0]}}</label>
												</div>
												<div class="radio-custom radio-primary">
													<input type="radio" value="1" name="status" id="status-1" {{($status==1)?'checked':''}}>
													<label for="status-1">{{Config::get('settings.translationStaus')[1]}}</label>
												</div>
												<div class="radio-custom radio-primary">
													<input type="radio" value="2" name="status" id="status-2" {{($status==2)?'checked':''}}>
													<label for="status-2">{{Config::get('settings.translationStaus')[2]}}</label>
												</div>
												
												<div class="radio-custom radio-primary">
													<input type="radio" value="3" name="status" id="status-3" {{($status==3)?'checked':''}}>
													<label for="status-3">{{Config::get('settings.translationStaus')[3]}}</label>
												</div>
												
											</div>
										</div>
						
						
            	
            	
             	
            </div>
            <div class="alert alert-success hide" role="alert">
					        <i class="fa fa-info pull-right"></i>
					         <span></span>
					       </div>
             <button type="submit" class="btn btn-primary">Save changes</button>
              </form>
              <h2>Reference</h2>
             
              <pre class="ace-editor" id="mainData" data-plugin="ace" data-mode="javascript"
              style="width: 100%;">
              {!!$mainData!!}
             </pre>
            </div>
          </div>
          <!-- End Example Iconified Tabs -->
        </div>
        
      </div>
    </div>
  </div>
  
  
  
  <meta name="csrf-token" content="{{ csrf_token() }}" />  
  <!-- MODAL DELETE -->

<!-- MODAL DELETE -->
 @section('extend-js')
  <script src="{{asset('remark/global/js/components/tabs.js')}}"></script>
  <script src="{{asset('remark/global/js/plugins/responsive-tabs.js')}}"></script>
   <script src="{{asset('remark/global/vendor/ace/ace.js')}}"></script>
   <script src="{{asset('remark/global/js/components/ace.js')}}"></script>
   <script>
   $("#lang-trans-form").on("submit", function(e){
		$.ajax({
			url: $(this).attr('action'),
	        data: $(this).serialize(),
			method:'POST',
			dataType:'json',
			success:function(data){
				if (data.response == 1){
	           	    FormResponse('success',data,'lang-trans-form');
	           	 //setTimeout(function(){location.reload();},3000);
	           }
	           else
	           		FormResponse('failed',data,'lang-trans-form');
				}

			});
		 return false;

	});

</script>
 @endsection

@Stop