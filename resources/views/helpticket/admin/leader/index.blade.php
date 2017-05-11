@extends('admin.default')

@section('title'){{trans('member.emails')}} @Stop
@section('homeclass')nav-active @Stop

@section('content')
 <link href="{{asset('helpdesk/css/style.css')}}" rel="stylesheet" type="text/css" /> 

        <!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-lg-12">
                <h1 class="page-header">Leaders List ({{ $renderList->total() }})</h1>
            </div>
            
                <form id="leader_form" action="{{URL::route('Manage-Leader-Post-Add')}}" class="form-horizontal mb-lg" method="post">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">User ID</label>
                        <div class="col-md-4">
                        <input type="text" id="filter_id" name="filter_id" value="" class="form-control">
                            <select class="form-control mb-md hide" name="filter_type" id="filter_type">
                                <option value="id">ID</option>
                                <option value="email">Email</option>
                                <option value="country_code">Country Code</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">Email</label>
                        <div class="col-md-4">
                            <input type="text" id="filter_email" name="filter_email" value="" class="form-control">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">Detail</label>
                        <div class="col-md-4" id="quickInfo">
                            
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">Leader For (Enter Country Code)</label>
                        <div class="col-md-4">
                            <select class="form-control mb-md" name="country_code" id="country_code">
                            <option value="">--SELECT--</option>
                             @foreach($countryCode as $co)
                                <option value="{{$co->country_code}}">{{$co->country_code}}</option>
                              @endforeach  
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-7 text-right">
                        <span class="btn-area hide">
                        <button class="btn btn-primary" type="submit" >Add As Leader</button>
                        </span>
                        <span class="loading hide"><img src="{{ asset('helpdesk/img/ajax-loader.gif') }}" /></span>
                        </div>
                    </div>
                    
                    <div class="alert alert-success hide" role="alert">
        				<i class="fa fa-info pull-right"></i>
         				<span></span>
       				</div>
                </form>

                @if(Session::has('success'))
                    <div class="alert alert-success">
                        <div>{{ Session::get('success') }}</div>
                    </div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            <div class="panel-body" >
                <table class="table table-striped table-bordered table-hover" id="dataTables-share">
                    <thead>
                    <tr>
                        <th class="hidden-xs">ID</th>
                        <th>User Details</th>
                        <th class="hidden-xs">Account Details</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($Lists as $user)
                        <tr class="odd gradeX">
                            <td class="hidden-xs">{{ $user->id }}</td>
                            <td class="hidden-xs">
                                <strong>Alias :</strong> {{ $user->alias }} <b>({{ $user->country_code }})</b><br>
                                <strong>Name :</strong> {{ $user->firstname }} {{ $user->lastname }}<br>
                                <strong>Email :</strong> {{ $user->email }}<br>
                                <strong>Mobile :</strong> {{ $user->mobile }}<br>
                                <strong>Country Code :</strong> {{ $user->country_code }}<br>
                                <strong>Registered Date :</strong> {{ $user->created_at }}<br>
                                <strong>Profile Photo :</strong> <a href="{{S3Files::url('profiles/'.$user->profile_pic)}}" target="_blank">{{ $user->profile_pic }}</a>
                            </td>
                            <td class="hidden-xs">
                                <strong>Referral User ID :</strong> {{ $user->referral_user_id }}<br>
                                <strong>Upline User ID :</strong> {{ $user->upline_user_id }}<br>
                                <strong>User Class :</strong> {{ $user->user_class }}<br>
                               
                                @if (!empty($downline))
                                @if (count($downline))
                                <br><strong>Downline Count :</strong> {{ $downline[$user->id] }}
                                @endif
                                @endif
                                @if (!empty($referral))
                                @if (count($referral))
                                <br><strong>Referral Count :</strong> {{ $referral[$user->id] }}
                                @endif
                                @endif
                            </td>
                            
                            <td>
                                <a href="{{ URL::to('/') }}/admin/quick-login/{{ $user->id }}" class="clearfix"><span class="fa fa-external-link fa-fw"></span></a>
                                
                                <button data-toggle="modal" data-target="#deleteLeader" data-whatever="{{ $user->firstname }} {{ $user->lastname }}" 
                                data-value="{{$user->leaders_id}}" title="Remove" type="button" class="btn btn-danger btn-sm"><i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $Lists->render() !!}
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->





</div>


</div>

</div>

<!-- MODAL DELETE -->
<div class="modal fade" id="deleteLeader" tabindex="-1" role="dialog" aria-labelledby="deleteLeaderLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title"></h3>
      </div>
      <div class="modal-body">
        <p></p>
      </div>
      <div class="alert alert-success m-10 p-5 hide" role="alert">
        <i class="fa fa-info pull-right"></i>
         <span></span>
       </div>
      <div class="modal-footer">
      <span class="loading hide"><img src="{{ asset('helpdesk/img/ajax-loader.gif') }}" /></span>
      <span class="btn-area pull-right">
        <button type="button" class="btn btn-success" id="YesDelete">Yes! Remove</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </span>
      </div>
     
    </div>
  </div>
</div>
<!-- MODAL DELETE -->
<meta name="csrf-token" content="{{ csrf_token() }}" />

 <script src="{{asset('helpdesk/js/functions.js')}}"></script> 

<script>
$(function(){
	   //create one instance for handler:
	   
	   var myHandler = function(e){ 
		   $('.btn-area').addClass('hide');
		   var 
		   step        = $('#leader_form')
		   data = step.serializeArray();
           
		   var input_name = e.target.name
		   		input_id = e.target.id
		   		input_value = $('#' + input_id).val();
		   		$.ajax({
	               type: step.attr('method'),
	               url: "{{URL::route('Manage-Leader-Add-Keyup')}}",
	               data: data,
	               dataType:'json',
	               success: function (data) {
		               	
	      					$('#quickInfo').html(data.content);
	      					if(data.hasRecord)
		      					$('.btn-area').removeClass('hide');
		      					
	               }
          		 });
		   		//alert('ddd'); 
		    };

	   //Bind it:
	   $("#leader_form input[type=text]").on('keyup',function(e){ myHandler(e);  });

	});

$("#leader_form").on("submit", function(e){
	FormResponse('processing','','leader_form');
    $.ajax({
        type: 'post',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function (data) { 
            if (data.response == 1){
            	FormResponse('success',data,'leader_form');
            	
            	 setTimeout(function(){location.reload();},3000);
            }
            else
            {
            	FormResponse('failed',data,'leader_form');
            }
        }
    });
    return false;
    
});


var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$('#deleteLeader').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var title = button.data('whatever') // Extract info from data-* attributes
	  var leader_id = button.data('value')
	  var modal = $(this)
	  modal.find('.modal-title').text('Are You Sure You want to remove? : ' + title)
	  modal.find('.modal-body p').text(title)
		var DeleteForm = $('#DeleteForm');
		$("#YesDelete").click(function(ev){
			window.location.href = "{{URL::to('/')}}/Manage/Leaders/Delete/"+leader_id;
	});
	})
</script>
@Stop