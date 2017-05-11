@extends('member.default')

@section('title'){{trans('member.personal_info')}} @Stop

@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">

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

                    <div class="panel panel-default">
                        <div class="panel-body">

                            {!! Form::open(array('url'=>'members/upload-profile-pic','method'=>'POST', 'files'=>true, 'class'=>'form-horizontal form-bordered')) !!}

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault"><img class="img-rounded" src="@if(Auth::user()->profile_pic){{S3Files::url('profiles/'.Auth::user()->profile_pic)}} @else {{asset('profiles/no_img.jpg')}} @endif"/></label>
                                <div class="col-md-4">
                                    <label class="control-label">{{trans('member.profile_picture')}}</label><br><br>
                                    {!! Form::file('image', '', array('class'=>'form-control','placeholder'=>trans('front.choose_image'))) !!}<br>
                                    @if(Auth::user()->profile_pic)
                                        {!! Form::submit(trans('member.replace_photo'), array('class'=>'btn btn-primary btn-block')) !!}
                                    @else
                                        {!! Form::submit(trans('member.upload_photo'), array('class'=>'btn btn-primary btn-block')) !!}
                                    @endif
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>

                    <div class="panel panel-default">
                        {!! Form::open(array('url'=>'members/personal-info','method'=>'POST', 'class'=>'form-horizontal form-bordered')) !!}
                        <div class="panel-body">

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault">{{trans('member.firstname')}}</label>
                                <div class="col-md-6">
                                    {!! Form::text('firstname', empty(old('firstname')) ? Auth::user()->firstname : old('firstname'), array('class'=>'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault">{{trans('member.lastname')}}</label>
                                <div class="col-md-6">
                                    {!! Form::text('lastname', empty(old('lastname')) ? Auth::user()->lastname : old('lastname'), array('class'=>'form-control', 'value'=>Auth::user()->lastname)) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault">{{trans('member.gender')}}</label>
                                <div class="col-md-6">
                                    <label class="control-label"><input name="gender" type="radio" value="male" @if(Auth::user()->gender == 'male') checked @endif> {{trans('member.male')}}</label> &nbsp;&nbsp;
                                    <label class="control-label"><input name="gender" type="radio" value="female" @if(Auth::user()->gender == 'female') checked @endif> {{trans('member.female')}}</label>
                                </div>
                            </div>

                        </div>

                        <div class="panel-body">

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault">{{trans('member.address')}}</label>
                                <div class="col-md-6">
                                    {!! Form::text('address', empty(old('address')) ? Auth::user()->address : old('address'), array('class'=>'form-control' )) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault">{{trans('member.city')}}</label>
                                <div class="col-md-6">
                                    {!! Form::text('city', empty(old('city')) ? Auth::user()->city : old('city'), array('class'=>'form-control', 'value'=>Auth::user()->city)) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault">{{trans('member.zipcode')}}</label>
                                <div class="col-md-3">
                                    {!! Form::text('zipcode', empty(old('zipcode')) ? Auth::user()->zipcode : old('zipcode'), array('class'=>'form-control', 'value'=>Auth::user()->zipcode)) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault">{{trans('member.state')}}</label>
                                <div class="col-md-6">
                                    {!! Form::text('state', empty(old('state')) ? Auth::user()->state : old('state'), array('class'=>'form-control', 'value'=>Auth::user()->state )) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault">{{trans('member.country')}}</label>
                                <div class="col-md-6">
                                    <div id="basic" data-input-name="country" data-selected-country="{{empty(old('country')) ? Auth::user()->country_code : old('country')}}"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="inputDefault">{{trans('member.update_personal_info')}}</label>
                                <div class="col-md-4">
                                    {!! Form::submit(trans('member.update_personal_info'), array('class'=>'btn btn-primary btn-block')) !!}
                                </div>
                            </div>

                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">

        $('#basic').flagStrap({
            buttonSize: "btn-md btn-block",
            labelMargin: "10px",
            scrollable: true,
            scrollableHeight: "300px"
        });


    </script>
    @Stop