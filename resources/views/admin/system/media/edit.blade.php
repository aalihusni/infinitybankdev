{!!Form::open(array('route' => 'admin-post-video','id'=>'videoEditForm','enctype'=>"multipart/form-data",'method'=>'POST','class'=>"form-horizontal",'autocomplete'=>"off"))!!}
<input type="hidden" name="video_id" value="{{$Detail->id}}" />
                    <div class="modal-body p-t-0">
                    <div class="form-group form-material row">
                      <div class="col-sm-6">
                        <label for="video_type" class="control-label">Video Type</label>
                        <select class="form-control" name="video_type">
                        <option value="">--SELECT--</option>
                        <option value="Videos" {{($Detail->v_type=='Videos')?'selected':''}}>Videos</option>
                        <option value="PDF Guide" {{($Detail->v_type=='PDF Guide')?'selected':''}}>PDF Guide</option>
                        <option value="Testimonial" {{($Detail->v_type=='Testimonial')?'selected':''}}>Testimonial</option>
                        </select>
                        
                      </div>
                      <div class="col-sm-6">
                      <div class="input-group input-group-file">
                      <label for="complain_to" class="control-label">Cover Image</label>
                    	<input type="text" class="form-control" >
	                    <span class="input-group-btn">
	                      <span class="btn btn-success btn-file waves-effect waves-light">
	                        <i aria-hidden="true" class="icon md-upload"></i>
	                        <input type="file" name="cover_image">
	                      </span>
	                    </span>
                  </div>
                      </div>
                    </div>
                    
                    <div class="form-group form-material row">
                      <div class="col-sm-12">
                        <label for="title_1" class="control-label">Title (Main Title)</label>
                        <input type="text" autocomplete="off" placeholder="Enter the Title One" name="title_1" value="{{$Detail->title_1}}" class="form-control">
                      </div>
                    </div>
                    <div class="form-group form-material row">
                      <div class="col-sm-12">
                        <label for="title_2" class="control-label">Title (Sub Title)</label>
                        <input type="text" autocomplete="off" placeholder="Enter the Title Two" name="title_2" value="{{$Detail->title_2}}" class="form-control">
                      </div>
                    </div>
                    
                    <div class="form-group form-material row">
                      <div class="col-sm-9">
                        <label for="v_url" class="control-label">Video URL</label>
                        <input type="text" autocomplete="off" placeholder="Enter the URL" name="v_url" value="{{$Detail->v_url}}" class="form-control">
                      </div>
                      <div class="col-sm-3">
                        <label for="ordering" class="control-label">Ordering</label>
                        <input type="text" autocomplete="off" placeholder="Enter the ORDER" name="ordering" value="{{$Detail->ordering}}" class="form-control">
                        
                      </div>
                    </div>
                    
                    <div class="form-group form-material row">
                      <div class="col-sm-6">
                        <label for="v_url" class="control-label">Publish</label>
                        <select class="form-control" name="status">
                        <option value="1" {{($Detail->status)?'selected':''}}>Yes</option>
                        <option value="0" {{($Detail->status==0)?'selected':''}}>No</option>
                        </select>
                      </div>
                      
                    </div>
                    
                     
                    
                     <input type="hidden" name="custom-err" id="custom-err" class="form-control">
                 
                        </div>
                        <div class="modal-footer">
                        
                       
                        
                        <span class="loading hide"><img src="{{ asset('remark/images/loader/ajax-loader.gif') }}" /></span>
                        <span class="btn-area">
                          <button type="button" class="btn btn-default btn-pure margin-0" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save</button>
                          </span>
                          
                          <div class="alert alert-success hide" role="alert">
				        				<i class="fa fa-info pull-right"></i>
				         				<span></span>
				       				</div>
                          
                        </div>
                         {!!form::close()!!}
                        
                         <script>
                         $("#videoEditForm").on("submit", function(e){
                        	 postSubmit('videoEditForm');
                        	 return false;
                        });
                         </script>