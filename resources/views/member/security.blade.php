@extends('member.default')

@section('title')Security @Stop

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
                        <h2 class="panel-title">Two-Factor Authentication</h2>
                        <p class="panel-subtitle">You will first need to install the Google Authenticator app on your phone before enabling two-factor authentication:</p>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(array('url'=>'members/security','method'=>'POST', 'class'=>'form-horizontal form-bordered')) !!}

                        @if (!$google2fa)

                        <div class="form-group">
                            <label class=" col-md-3 control-label">&nbsp;</label>
                            <div class="col-lg-6">
                                <p class="small">Scan this qr code with your Google Authenticator app:</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-md-3 control-label">QR Code</label>
                            <div class="col-md-6">
                                {!! Html::image($google2fa_url) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-md-3 control-label">&nbsp;</label>
                            <div class="col-lg-6">
                                <p class="small text-danger"><strong>Print out</strong> this page and store the qr code in a safe place.
                                    Otherwise, there will be no way to regain access to your account if you lose your phone.</p>
                            </div>
                        </div>

                        @endif

                        <div class="form-group">
                            <label class=" col-md-3 control-label">Authentication Code</label>
                            <div class="col-md-6">
                                {!! Form::text('secret', old('secret'), array('class'=>'form-control' )) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">&nbsp;</label>
                            <div class="col-md-4">
                                {!! Form::submit(!$google2fa ? 'Enable Two-Factor Auth' : 'Disable Two-Factor Auth', array('class'=>'btn btn-primary btn-block')) !!}
                            </div>
                        </div>



                        {!! Form::close() !!}
                    </div>
                </div>

            </div>

            <div class="col-md-4">
                <div class="well">
                    <p><span class="fa fa-info-circle"></span> <strong>Information</strong></p>
                    <p>You will first need to install the Google Authenticator app on your phone before enabling two-factor authentication:</p>
                    <ul>
                        <li><strong>Android:</strong> Install <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank">Google Authenticator</a> from the Google Play Store.</li>
                        <li><strong>iPhone, iPod Touch, iPad:</strong> Install <a href="https://itunes.apple.com/app/google-authenticator/id388497605?mt=8" target="_blank">Google Authenticator</a> from the App Store.</li>
                        <li><strong>BlackBerry:</strong> Open <a href="http://m.google.com/authenticator" target="_blank">m.google.com/authenticator</a> in the web browser on your BlackBerry.</li>
                    </ul>
                    <br>
                    <p><a href="https://support.google.com/accounts/answer/1066447?hl=en" target="_blank">More detailed instructions</a></p>
                </div>
            </div>
        </div>
    </div>

    @Stop