@extends('member.default')

@section('title'){{trans('member.home')}} @Stop
@section('home-class')nav-active @Stop

@section('menu_setting') @Stop

@section('content')



    <div class="row">
    


    <div class="col-md-12">
    <div class="row">
        <section class="panel panel-danger">
            <header class="panel-heading">
                <h2 class="panel-title"><span class="fa fa-user-times"></span>&nbsp; &nbsp; Your account has been suspended</h2>
                <p class="panel-subtitle hide">Your account has been suspended.</p>
            </header>
            <div class="panel-body">
               	
               	@if($SuspensionDetail['SuspensionType']==1)
               	<p>Your account has been suspended. Please contact to support team for detail.<br></p>
               	@endif
               
               	
               	@if($SuspensionDetail['SuspensionType']==0)
               	
		               	@if($SuspensionDetail['ComplainTo']=="ME") 
		               		@include('member.dispute.complain-to')
		               	@else
		               		@include('member.dispute.complain-by')
		               	@endif
		               	
               		
               	@endif
               	
               	
                
                
                
                
                
            </div>
        </section>
    </div>
</div>

    







</div>


<script type="text/javascript">
    

</script>

@Stop