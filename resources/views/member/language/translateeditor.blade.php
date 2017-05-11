@extends('member.default')
@section('title'){{trans('member.menu_lang_trans_request')}} @Stop
@section('lang-class')nav-active @Stop
@section('content')

<div class="col-md-12">
	<div class="row">

		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">{!!trans('general.text_lang_trans')!!}</h2>
					<p class="panel-subtitle hide">{{trans('pairing.info_about_pairing')}}</p>
				</div>

			</div>

			<div class="panel panel-default">

				<div class="panel-body">
              <h4>Translate from <span class="highlight">English</span> To <span class="highlight">{{$LangDetail->name}}</span></h4>
              
              {!!Form::open(array('route' => 'member-language-post-translate-data', 'id'=>'lang-trans-form','method'=>'POST'))!!}
              <input type="hidden" name="fileName" value="<?=$fileName?>" />
              <input type="hidden" name="serial_number" value="<?=$RowDetail->id?>" />
             
						<div class="row">
							<div class="col-sm-9 col-sm-offset-3">
							<div class="alert alert-success hide" role="alert">
					        <i class="fa fa-info pull-right"></i>
					         <span></span>
					       </div>
								<span class="loading hide pull-right">&nbsp;&nbsp;&nbsp;<img src="{{ asset('remark/images/loader/ajax-loader.gif') }}" /></span>
								<span class="btn-area pull-right">
									<button class="btn btn-primary" type="submit">Submit</button>
								</span>
							</div>
						</div>
						@foreach($engData as $key => $txt)
						<div class="form-group form-material floating"
							style="margin: 0 0 20px 0 !important;">
							<!-- style="margin:0!important;" -->
							<span class="help-block" style="margin: 0 0 0 0 !important;">English
								: <span style="color: #ff9800;">{!!$txt!!}</span>
							</span> @if(strlen($txt) > 180)
							<textarea class="form-control" name="{{$key}}" rows="2"
								name="textareaFloating">{{(key_exists($key,$selLangData))?''.$selLangData[$key].'':''.$txt.'' }}</textarea>
							@else <input type="text" class="form-control input-sm"
								name="{{$key}}" value="{{(key_exists($key,$selLangData))?''.$selLangData[$key].'':'' }}" placeholder="Please change the text here"/> @endif <label
								class="floating-label hide">dsfasdf</label>
						</div>
						@endforeach
						
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
												
											</div>
										</div>
						
						
            	
            	
             	
            </div>
						
						<div class="row">
							<div class="col-sm-9 col-sm-offset-3">
							<div class="alert alert-success hide" role="alert">
					        <i class="fa fa-info pull-right"></i>
					         <span></span>
					       </div>
								<span class="loading hide pull-right">&nbsp;&nbsp;&nbsp;<img src="{{ asset('remark/images/loader/ajax-loader.gif') }}" /></span>
								<span class="btn-area pull-right">
									<button class="btn btn-primary" type="submit">Submit</button>
								</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>


	</div>
</div>
  <script src="{{asset('remark/functions.js')}}"></script>

<script type="text/javascript">
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
@Stop
