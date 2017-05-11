@extends('website.default')

@section('title'){{trans('websitenew.contactus')}}  @Stop

@section('contactusclass')active @Stop

@section('content')
    <div role="main" class="main">

        <div class="container">


            <div class="row">
                <div class="col-md-6">

                    <div class="alert alert-success hidden" id="contactSuccess">
                        <strong>{{trans('websitenew.success')}}</strong> {{trans('websitenew.ur_message_sent')}}
                    </div>

                    <div class="alert alert-danger hidden" id="contactError">
                        <strong>{{trans('websitenew.error')}}</strong> {{trans('websitenew.error_send_msg')}}
                    </div>

                    <h2 class="short"><strong>{{trans('websitenew.contactus')}}</strong> </h2>
                    <div id="thecontactform">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>{{trans('websitenew.ur_name')}}</label>
                                    <input type="text" class="form-control" placeholder="{{trans('websitenew.ur_name')}}" id="name" required data-validation-required-message="{{trans('websitenew.your_name_details')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label>{{trans('websitenew.ur_email')}}</label>
                                    <input type="email" class="form-control" placeholder="{{trans('websitenew.ur_email')}}" id="email" required data-validation-required-message="{{trans('websitenew.your_email_details')}}">
                                </div>
                                <div class="col-md-6">
                                    <label>{{trans('websitenew.ur_phone')}}</label>
                                    <input type="tel" class="form-control" placeholder="{{trans('websitenew.ur_phone')}}" id="phone" required type="number" data-validation-required-message="{{trans('websitenew.your_phone_details')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>{{trans('websitenew.message')}}</label>
                                    <textarea class="form-control" placeholder="{{trans('websitenew.message')}}" id="message" rows="10" required data-validation-required-message="{{trans('websitenew.your_message_details')}}"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="{{trans('websitenew.success')}}"></div>
                                <button id="contactformsubmit" type="submit" class="btn btn-primary btn-lg">{{trans('websitenew.sendmessage')}}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    $('#contactformsubmit').click(function(){

                        var name = $('#name').val();
                        var email = $('#email').val();
                        var phone = $('#phone').val();
                        var message = $('#message').val();
                        var ref = "{{$referral}}";

                        $.ajax({
                            method: "POST",
                            url: "{{URL::route('submit-message')}}",
                            data: { _token: "<?php echo csrf_token(); ?>", c_name: name, c_email: email, c_phone: phone, c_message: message, c_ref: ref },
                            success:function() {
                                $('#thecontactform').html('<h3 class="section-heading">{{trans('websitenew.thankyou_contact_shortly')}}</h3>');
                            }
                        });
                    })
                </script>

                <div class="col-md-6">

                    <h4 class="push-top">{{trans('websitenew.getintouch')}}</h4>
                    <p>{!! trans('websitenew.getintouch_note') !!}</p>

                    <hr />

                    @if (isset($_COOKIE['country_code']))
                    @if ($_COOKIE['country_code'] == 'CN' || $_COOKIE['country_code'] == 'HK' || $_COOKIE['country_code'] == 'TW')
                    <div>
                    <h4 class="push-top"><span class="fa fa-qq"></span> <strong>QQ</strong>: <span style="color:#999;">3120013960</span></h4>
                    <hr />
                    <h4 class="push-top"><span class="fa fa-wechat"></span> <strong>WeChat</strong>: <span style="color:#999;">bitregion</span></h4>
                    <hr />
                    <h4 class="push-top"><span class="fa fa-envelope"></span> <strong>Email</strong>: <span style="color:#999;">bitregion@qq.com</span></h4>
                    </div>
                    @else
                        <div class="hide">NC{{$_COOKIE['country_code']}}<br></div>
                    @endif
                    @else
                        <div class="hide">NS<br></div>
                    @endif
                    <h4>{{trans('form.la_heading')}}</h4>
                    <p>{{trans('form.la_heading_text')}}
						
												</p>
					 <a href="{{URL::route('leader-request-from')}}" type="button" class="btn btn-danger btn-sm "><span class="blink">{{trans('form.btn_apply')}}</span></a>

                </div>

            </div>

        </div>

    </div>
    <script>
    function blinker() {
    	$('.blink').fadeOut(500);
    	$('.blink').fadeIn(500);
    }
    setInterval(blinker, 1000);
    </script>
@stop