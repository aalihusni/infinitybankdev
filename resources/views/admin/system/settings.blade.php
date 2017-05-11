@extends('layout.admin')

@section('title'){{trans('member.home')}} @Stop

@section('token-withdraw')active open @Stop
@section('manage-main-class')active @Stop

@section('extend-css')
@endsection

@section('content')
<div class="page animsition">
    <div class="page-header">
      <h1 class="page-title"><i class="fa fa-cogs"></i> System :: Settings
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
        
          <!-- Example Iconified Tabs -->
          <div class="example-wrap">
            <h4 class="example-title">Iconified Tabs</h4>
            <div class="example">
               
              <div class="nav-tabs-horizontal nav-tabs-inverse">
                <ul class="nav nav-tabs nav-tabs-solid" data-plugin="nav-tabs" role="tablist">
                  <li class="active" role="presentation">
                    <a data-toggle="tab" href="#exampleIconifiedTabsOne" aria-controls="exampleIconifiedTabsOne"
                    role="tab">
                      <i class="icon md-account" aria-hidden="true"></i> PH & GH (Matching)
                    </a>
                  </li>
                  <li role="presentation" class="hide">
                    <a data-toggle="tab" href="#exampleIconifiedTabsTwo" aria-controls="exampleIconifiedTabsTwo"
                    role="tab">
                      <i class="icon md-roller" aria-hidden="true"></i> PH & GH Queue Priority
                    </a>
                  </li>
                  
                </ul>
                <div class="tab-content padding-top-15">
                  
                  
                  <div class="tab-pane active" id="exampleIconifiedTabsOne" role="tabpanel">
                  {!! Form::model($setting,['url' => 'admin/setting/post/'.$setting->id,  'method' => 'PATCH','autocomplete'=>"off"]) !!}
                    <div class="form-group form-material">
					{!! Form::label('day_queue_before_assign','How many days to queue PH & GH before assign (A)',['class'=>"control-label"]) !!}
					 {!! $errors->first('day_queue_before_assign', '<spam class="error-txt">:message</spam>') !!}
					{!! Form::input('number', 'day_queue_before_assign', $setting->day_queue_before_assign, ['class' => 'form-control']); !!}
					</div>
					<div class="form-group form-material">
					{!! Form::label('day_assigned_expiry','How many days after assigned to expired',['class'=>"control-label"]) !!}
					{!! $errors->first('day_assigned_expiry', '<spam class="error-txt">:message</spam>') !!}
					{!! Form::input('number', 'day_assigned_expiry', $setting->day_assigned_expiry, ['class' => 'form-control']); !!}
					</div>
					
					<div class="form-group form-material">
					{!! Form::label('expired_limit','Limit to Expired PH (How many times PH can be Requeue)',['class'=>"control-label"]) !!}
					{!! $errors->first('expired_limit', '<spam class="error-txt">:message</spam>') !!}
					{!! Form::input('number', 'expired_limit', $setting->expired_limit, ['class' => 'form-control']); !!}
					</div>
					
					
					<div class="form-group form-material">
					{!! Form::label('expired_limit','Default Priority',['class'=>"control-label"]) !!}
					
					<div class="radio-custom radio-primary">
                  		<input type="radio" name="default_priority" value="50" {{($setting->default_priority==50)?'checked':''}} id="default_priority_high">
                  		<label for="default_priority_high">Immediate</label>
                	</div>
					
					<div class="radio-custom radio-primary">
                  		<input type="radio" name="default_priority" value="0" {{($setting->default_priority==0)?'checked':''}}  id="default_priority_normal">
                  		<label for="default_priority_normal">Based On PH GH Queue (A)</label>
                	</div>
                	
                	
					</div>
					
					<div class="form-group form-material">
					{!! Form::label('ph_gh_page_limit','How many records you want to list per page.',['class'=>"control-label"]) !!}
					{!! $errors->first('ph_gh_page_limit', '<spam class="error-txt">:message</spam>') !!}
					{!! Form::input('number', 'ph_gh_page_limit', $setting->ph_gh_page_limit, ['class' => 'form-control']); !!}
					</div>
                      
                    
                    <div class="form-group form-material p-b-20">
                      <div class="col-sm-9 col-sm-offset-3">
                        <button class="btn btn-primary waves-effect waves-light" type="submit">Update PH & GH </button>
                        <!-- <button class="btn btn-warning waves-effect waves-light" type="reset">Reset</button>  -->
                      </div>
                    </div>
                  </form>
                  </div>
                   
                  <div class="tab-pane" id="exampleIconifiedTabsTwo" role="tabpanel">
                  </div>
                </div>
                
              </div>
             
            </div>
          </div>
          <!-- End Example Iconified Tabs -->
        </div>
        
      </div>
    </div>
  </div>
  
  
  
   
  <!-- MODAL DELETE -->

<!-- MODAL DELETE -->
 @section('extend-js')
  <script src="{{asset('global/js/components/tabs.js')}}"></script>
  <script src="{{asset('global/js/plugins/responsive-tabs.js')}}"></script>
   <script>
//var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

</script>
 @endsection

@Stop