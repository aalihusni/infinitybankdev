@extends('member.default')

@section('title')Personal Testimonial @Stop

@section('faq-class')nav-active @Stop

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-md-12">
        <div class="row">

            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Personal Testimonial</h2>
                        <p class="panel-subtitle">Please upload your testimonial video via Youtube, Youku or Vimeo.</p>
                    </div>
                    <div class="panel-body">

                        @if($data < 1)


                        {!! Form::open(array('url'=>'members/testimonial','method'=>'POST', 'class'=>'form-horizontal form-bordered')) !!}

                        <div class="form-group">
                            <div class="col-md-12 small">
                            To make your video be approved:<br />
                            1.	Please mention “Bitregion” and show your face clearly<br />
                            2.	Your name<br />
                            3.	Your country<br />
                            4.	Joining date<br />
                            5.	Please discuss why you love Bitregion in constructive ways (you may discuss topics related to your profit, financial freedom experience, exposure about Bitcoin banking system, about our technology regarding crowdfunding matrix platform, or mutual aid community arrangement and/or any relevant topics that gives positive impression about Bitregion<br />
                            6.	Please welcome new member to join your referral ID (please also mention your referral link)<br />
                            7.	Please express your hope, wish and any suggestions for the community <br />
                            8.	The video must be genuinely made by yourself<br />
                            </div>
                        </div>


                            <div class="form-group">
                            <label class=" col-md-3 control-label">Video Website</label>
                            <div class="col-md-6">
                                <select name="website" class="form-control mb-md" required>
                                    <option value="" disabled="disabled" selected>- Select One -</option>
                                    <option value="Youtube">Youtube</option>
                                    <option value="Youku">Youku</option>
                                    <option value="Vimeo">Vimeo</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-md-3 control-label">Video URL </label>
                            <div class="col-md-6">
                                {!! Form::url('url', old('url'), array('class'=>'form-control','required'=>'required')) !!}
                                <small>Please copy & paste your video link here!</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 text-right">
                                <input type="checkbox" value="" required>
                            </div>
                            <div class="col-md-6">
                                <p class="form-control-static">I hereby agree to allow BitRegion and all its members to use my video and download the video for promotional purposes.</p>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">&nbsp;</label>
                            <div class="col-md-4">
                                {!! Form::submit('Submit', array('class'=>'btn btn-primary btn-block' )) !!}
                            </div>
                        </div>



                        {!! Form::close() !!}

                        @else

                            @if($testi->status <2)
                            <div class="text-center">
                                <img src="{{asset('img/testi.png')}}">
                            </div>

                            <div class="text-center">
                                <h3>Thank you for your submission.</h3>
                                <p>We will review your video and review it accordingly:</p>
                                <p><strong>Website:</strong> {{$testi->website}}<br>
                                    <strong>URL:</strong> <a href="{{$testi->url}}" target="_blank">{{$testi->url}}</a></p>
                            </div>
                            @else

                                <div class="text-center">
                                    <img src="{{asset('img/testi.png')}}">
                                </div>

                                <div class="text-center">
                                    <h3>Your video has been approved. You have received 2 passport.</h3>
                                    <p>Please make sure the video is up live for at least 6 month or your passport will be revoke.</p>
                                    <p><strong>Website:</strong> {{$testi->website}}<br>
                                        <strong>URL:</strong> <a href="{{$testi->url}}" target="_blank">{{$testi->url}}</a></p>
                                </div>

                            @endif

                        @endif
                    </div>
                </div>

            </div>

            <div class="col-md-4">
                <div class="well">
                    <p><span class="fa fa-info-circle"></span> <strong>Information</strong></p>
                    <p>Please upload your video to one of the sites below:</p>
                    <ul>
                        <li><strong>Youtube</strong></li>
                        <li><strong>Youku</strong></li>
                        <li><strong>Vimeo</strong></li>
                    </ul>
                    <br>
                    <p>Be creative in your video! All approved testimonials will be rewarded with 2 passports.</p>
                    <p>We will review your video submission. Please wait and you will receive 2 passports if your video is approved.</p>
                </div>
            </div>
        </div>
    </div>
@Stop