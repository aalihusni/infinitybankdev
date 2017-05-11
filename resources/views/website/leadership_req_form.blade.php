@extends('website.default')

@section('title'){{trans('websitenew.contactus')}}  @Stop

@section('contactusclass')active @Stop

@section('content')
<style>.error-txt { color:#f66; font-size: 10px; font-weight: 400; margin:4px 0 -9px; }</style>
    <div role="main" class="main">

        <div class="container">
<div class="panel panel-default">
    <div class="panel-heading">{{trans('form.la_heading')}}</div>
    <div class="panel-body"><div class="col-md-12">
                    
                    <p>{!! trans('form.la_text_1') !!}
</p><p>
<span class="text-danger blink">{!! trans('form.la_text_warning') !!}</span>
</p>
                    <form id="leaderForm" type="post" action="{{URL::route('post-leader-request-from')}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label>{{trans('websitenew.ur_name')}}:</label>
                                    <input type="text" name="full_name" class="form-control" placeholder="{{trans('websitenew.ur_name')}}" id="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label>{{trans('websitenew.ur_email')}}:</label>
                                    <input type="text" name="email" class="form-control" placeholder="{{trans('websitenew.ur_email')}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                
                                <div class="col-md-6">
                                    <label>{{trans('websitenew.ur_phone')}}:</label>
                                    <input type="text" name="phone" class="form-control" placeholder="{{trans('websitenew.ur_phone')}}" required>
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label>{{trans('form.entry_fb_name')}}:</label>
                                    <input type="text" name="fb_name" class="form-control" placeholder="{{trans('form.entry_fb_name')}}">
                                </div>
                                <div class="col-md-6">
                                    <label>{{trans('form.entry_fb_url')}}:</label>
                                    <input type="text" name="fb_url" class="form-control" placeholder="{{trans('form.entry_fb_url')}}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group">
                                
                                <div class="col-md-6">
                                    <label>{{trans('form.entry_wc_name')}}:</label>
                                    <input type="text" name="wechat_name" class="form-control" placeholder="{{trans('form.entry_wc_name')}}">
                                </div>
                                <div class="col-md-6">
                                    <label>{{trans('form.entry_wc_url')}}:</label>
                                    <input type="text" name="wechat_url" class="form-control" placeholder="{{trans('form.entry_wc_url')}}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group multiUrl" id="multiUrl">
                                <div class="col-md-12">
                                <label>{{trans('form.entry_social')}}:</label>
                                <div class="input-group"> 
                                <input type="text" name="social_account[]" class="form-control"  placeholder="{{trans('form.entry_social_placeholder')}}">
                                <span class="input-group-btn "> <button type="button" class="btn btn-default" style="padding:5px!important;" id="btAdd">{{trans('form.btn_add_more')}}</button>
                                 </span> </div>
                                </div>
                                
                                
                            </div>
                        </div>
                        
                        
                        
                        
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>{{trans('form.entry_la_description')}}:</label>
                                    <textarea name="description" class="form-control" placeholder="{{trans('form.entry_la_description_placeholder')}}"  rows="5" required></textarea>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        
                        <div class="row">
                            <div class="form-group">
                                
                                <div class="col-md-12">
                                    <label>{{trans('form.entry_provide_proof')}}:</label>
                                    <input type="file" name="photo" class="form-control" placeholder="Browse image">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>{{trans('form.entry_provide_document')}}:</label>
                                    <input type="file" name="document" class="form-control">
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-12"><label>{{trans('form.entry_how_many')}}:</label></div>
                                <div class="col-md-6">
                                     <div class="col-md-3"><b>{{trans('form.entry_in_2_weeks')}}:</b></div>
                                    <div class="col-md-9"><select class="form-control pull-right" name="in_2_weeks"><option value="0 - 10">0 to 10</option>
                                    <option value="0 - 50">0-50</option>
                                    <option value="0 - 100">0-100</option>
                                    <option value="0 - 150">0-150</option>
                                    <option value="0 - 200">0-200</option>
                                    <option value="0 - 300">0-300</option>
                                    <option value="0 - 400">0-400</option>
                                    <option value="0 - 500">0-500</option>
                                    <option value="0 - 1000">0-1000</option>
                                    <option value="0 - 1500">0-1500</option>
                                    <option value="0 - 2000">0-2000</option>
                                    <option value="0 - 3000">0-3000</option>
                                    <option value="0 - 4000">0-4000</option>
                                    <option value="0 - 5000">0-5000</option>
                                    <option value="0 - 6000">0-6000</option>
                                    <option value="0 - 7000">0-7000</option>
                                    <option value="0 - 8000">0-8000</option>
                                    <option value="0 - 9000">0-9000</option>
                                    <option value="0 - 10000">0-10000</option>
                                    <option value="More Than 10000">More Than 10000</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                     <div class="col-md-3"><b>{{trans('form.entry_in_1_month')}}:</b></div>
                                    <div class="col-md-9"><select class="form-control pull-right" name="in_month"><option value="0 - 10">0 to 10</option>
                                    <option value="0 - 50">0-50</option>
                                    <option value="0 - 100">0-100</option>
                                    <option value="0 - 150">0-150</option>
                                    <option value="0 - 200">0-200</option>
                                    <option value="0 - 300">0-300</option>
                                    <option value="0 - 400">0-400</option>
                                    <option value="0 - 500">0-500</option>
                                    <option value="0 - 1000">0-1000</option>
                                    <option value="0 - 1500">0-1500</option>
                                    <option value="0 - 2000">0-2000</option>
                                    <option value="0 - 3000">0-3000</option>
                                    <option value="0 - 4000">0-4000</option>
                                    <option value="0 - 5000">0-5000</option>
                                    <option value="0 - 6000">0-6000</option>
                                    <option value="0 - 7000">0-7000</option>
                                    <option value="0 - 8000">0-8000</option>
                                    <option value="0 - 9000">0-9000</option>
                                    <option value="0 - 10000">0-10000</option>
                                    <option value="More Than 10000">More Than 10000</option>
                                    </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                   <div class="col-md-3"><b>{{trans('form.entry_in_3_month')}}:</b> </div>
                                    <div class="col-md-9"><select class="form-control pull-right" name="in_3_months"><option value="0 - 10">0 to 10</option>
                                    <option value="0 - 50">0-50</option>
                                    <option value="0 - 100">0-100</option>
                                    <option value="0 - 150">0-150</option>
                                    <option value="0 - 200">0-200</option>
                                    <option value="0 - 300">0-300</option>
                                    <option value="0 - 400">0-400</option>
                                    <option value="0 - 500">0-500</option>
                                    <option value="0 - 1000">0-1000</option>
                                    <option value="0 - 1500">0-1500</option>
                                    <option value="0 - 2000">0-2000</option>
                                    <option value="0 - 3000">0-3000</option>
                                    <option value="0 - 4000">0-4000</option>
                                    <option value="0 - 5000">0-5000</option>
                                    <option value="0 - 6000">0-6000</option>
                                    <option value="0 - 7000">0-7000</option>
                                    <option value="0 - 8000">0-8000</option>
                                    <option value="0 - 9000">0-9000</option>
                                    <option value="0 - 10000">0-10000</option>
                                    <option value="More Than 10000">More Than 10000</option>
                                    </select></div>
                                   
                                </div>
                                
                                <div class="col-md-6">
                                   <div class="col-md-3"><b>{{trans('form.entry_in_6_month')}}:</b></div>
                                    <div class="col-md-9"><select class="form-control pull-right" name="in_6_months"><option value="0 - 10">0 to 10</option>
                                    <option value="0 - 50">0-50</option>
                                    <option value="0 - 100">0-100</option>
                                    <option value="0 - 150">0-150</option>
                                    <option value="0 - 200">0-200</option>
                                    <option value="0 - 300">0-300</option>
                                    <option value="0 - 400">0-400</option>
                                    <option value="0 - 500">0-500</option>
                                    <option value="0 - 1000">0-1000</option>
                                    <option value="0 - 1500">0-1500</option>
                                    <option value="0 - 2000">0-2000</option>
                                    <option value="0 - 3000">0-3000</option>
                                    <option value="0 - 4000">0-4000</option>
                                    <option value="0 - 5000">0-5000</option>
                                    <option value="0 - 6000">0-6000</option>
                                    <option value="0 - 7000">0-7000</option>
                                    <option value="0 - 8000">0-8000</option>
                                    <option value="0 - 9000">0-9000</option>
                                    <option value="0 - 10000">0-10000</option>
                                    <option value="More Than 10000">More Than 10000</option>
                                    </select></div>
                                   
                                </div>
                                
                                
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label>{{trans('form.entry_member_bitregion')}}:</label>
                                   <select class="form-control" name="is_member" id="is_member">
                                    <option value="1">{{trans('form.text_yes')}}</option>
                                    <option value="0" selected>{{trans('form.text_no')}}</option>
                                  
                                    </select>
                                </div>
                                <div class="col-md-6 hide" id="provide_username">
                                    <label>{{trans('form.entry_br_username')}}:</label>
                                    <input type="text" name="bitregion_username" class="form-control" placeholder="{{trans('form.entry_br_username_placeholder')}}">
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        <div class="row">
                        
                        <div class="col-md-12">
                                    <label>{{trans('form.text_pleasebe')}}</label>
                                </div>
                        </div>
                        
                        <div class="row">
                        <div class="form-group">
                        <div class="checkbox pull-left">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" value="1" name="aware" required>
                                    {{trans('form.entry_agree_yes')}}
                            </div>
                            </div>
                        </div>
                        
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div id="{{trans('websitenew.success')}}"></div>
                                
                                <span class="btn-area">
                                   <button id="contactformsubmit" type="submit" class="btn btn-primary btn-lg">{{trans('form.btn_submit')}}</button>
                                </span>
                                <span class="loading hide"><img src="{{ asset('helpdesk/img/ajax-loader.gif') }}" /></span>
                                
                               
                            </div>
                        </div>
                        
                        <div class="col-md-offset-1 col-md-10 col-md-offset-1 alert alert-success hide" role="alert">
        										<i class="fa fa-info pull-right"></i>
         										<span></span>
       					</div>
                    </form>
                </div></div>
  </div>

           

        </div>

    </div>
    <script src="{{asset('helpdesk/js/functions.js')}}"></script>
    <script>
    
		$('#is_member').change(function(){
				if($(this).val()==1)
					$('#provide_username').removeClass('hide');	
				else
					$('#provide_username').addClass('hide');	
	     });

	     $(document).ready(function(){

	    	 if($('#is_member').val()==1)
					$('#provide_username').removeClass('hide');	
				else
					$('#provide_username').addClass('hide');	

		     });

		$('#leaderForm').on('submit', function() {
				FormResponse('processing','','leaderForm');
			    var fd = new FormData(document.getElementById("leaderForm"));
			    $.ajax({
			        type: "POST",
			        url: $(this).attr('action'),
			        enctype: 'multipart/form-data',
			        dataType: "json",
			        data: fd,
			        processData: false,  
			        contentType: false ,
			        success: function(data) {
			        	 if (data.response == 1)
				            	FormResponse('success',data,'leaderForm');
				            else
				            	FormResponse('failed',data,'leaderForm');
			        }
			    })
			    return false;
			});
		 $(document).ready(function() {

			 var iCnt = 1;
				$('#btAdd').click(function() {
					if (iCnt > 4)
						return false;

					var div = "<div class=\"col-md-6\"><label></label><input type=\"text\" name=\"social_account[]\" class=\"form-control\" placeholder=\"{{trans('form.entry_social_placeholder')}}\"></div>";
					$('#multiUrl').append(div);
					iCnt = iCnt + 1;
					//$( $('.cpy') ).clone().prependTo($('#multiUrl'));
					/*
		            if (iCnt <= 19) {
		                iCnt = iCnt + 1;
		                // ADD TEXTBOX.
		                $(container).append('<input type=text class="input" id=tb' + iCnt + ' ' +
		                            'value="Text Element ' + iCnt + '" />');

		                // SHOW SUBMIT BUTTON IF ATLEAST "1" ELEMENT HAS BEEN CREATED.
		                if (iCnt == 1) {
		                    var divSubmit = $(document.createElement('div'));
		                    $(divSubmit).append('<input type=button class="bt"' + 
		                        'onclick="GetTextValue()"' + 
		                            'id=btSubmit value=Submit />');
		                }

		                // ADD BOTH THE DIV ELEMENTS TO THE "main" CONTAINER.
		                $('#main').after(container, divSubmit);
		            }
		            // AFTER REACHING THE SPECIFIED LIMIT, DISABLE THE "ADD" BUTTON.
		            // (20 IS THE LIMIT WE HAVE SET)
		            else {      
		                $(container).append('<label>Reached the limit</label>'); 
		                $('#btAdd').attr('class', 'bt-disable'); 
		                $('#btAdd').attr('disabled', 'disabled');
		            } */
		        });
			 
		 });
		
		
		
		
		 function blinker() {
		 	$('.blink').fadeOut(500);
		 	$('.blink').fadeIn(500);
		 }
		 setInterval(blinker, 1000);
		 </script>
@stop