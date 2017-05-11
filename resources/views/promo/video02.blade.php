@extends('promo.default_page')

@section('title')How it work?  @Stop

@section('contactusclass')active @Stop

@section('extrameta')
<meta property="og:url"           content="{{ env('SITE_URL') }}/marketing-plan-video" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="BitRegion Marketing Plan Video" />
<meta property="og:description"   content="Let us explain how you can earn unlimited Bitcoin income by just contributing 0.15BTC!" />
<meta property="og:image"         content="{{asset('web_content/img/promo02.jpg')}}" />

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@bitregion">
<meta name="twitter:creator" content="@bitregion">
<meta name="twitter:title" content="BitRegion Marketing Plan Video">
<meta name="twitter:description" content="Let us explain how you can earn unlimited Bitcoin income by just contributing 0.15BTC!">
<meta name="twitter:image" content="{{asset('web_content/img/promo02.jpg')}}">
@Stop

@section('content')
<div role="main" class="main">
    <div class="container">
        <div class="col-lg-8 landing_container">
            <p class="lp_main_headline">Bitregion Marketing Plan Video</p>
            <p class="lp_sub_headline">Let us explain how you can earn unlimited Bitcoin income by just contributing 0.15BTC!</p>
            <video width="100%" autoplay controls>
                <source src="{{asset('download/marketing_plan.mp4')}}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="col-lg-4 landing_container">
            <div class="optin-container-top"></div>
            <div class="optin-container-mid">
                <div class="col-lg-12 optin-container-mid">

                    <div class="form-horizontal form-bordered">

                        @if(Session::has('success'))
                            <div>
                                <div>{!! Session::get('success') !!}</div>
                            </div>
                        @else
                            <div class="optin-subtitle">If you need guidance to know more about this community, please let us contact you directly:<br><br>

                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <span class="optin-subtitle-lg">Just leave us your contact details below...</span>
                                @endif
                            </div>

                            <form id="subscribeform" method="post" action="{{URL::route('do-subscribe-page')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Firstname" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Lastname" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Email" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-2">
                                        <div class="text-right">
                                            <input class="input-lg" type="checkbox" required>
                                        </div>
                                    </div>
                                    <div class="col-md-10 form-control-static">
                                        I agree to have someone in Bitregion community to contact me for further explanation.
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-block btn-lg">Yes! Please contact me!</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                        <br>
                        <table width="100%">
                            <tr>
                                <td align="right">Follow Us on: </td>
                                <td align="left">&nbsp;&nbsp;
                                    <a href="https://facebook.com/bitregion" target="_blank"><img  width="40" src="{{asset('assets/social/fb.png')}}"</a>&nbsp;
                                    <a href="https://twitter.com/bitregion" target="_blank"><img width="40" src="{{asset('assets/social/tw.png')}}"</a>&nbsp;
                                    <a href="https://instagram.com/bitregion" target="_blank"><img width="40" src="{{asset('assets/social/ig.png')}}"</a>
                                </td>
                            </tr>
                        </table>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">

    <div class="center">

        <div class="divider tall colored">
            <i class="fa fa-star"></i>
        </div>

        <h2>{{trans('websitenew.footer1')}} <strong>{{trans('websitenew.footer2')}}</strong></h2>
        <p class="lead">{{trans('websitenew.footer3')}} </p>
        <p>{{trans('websitenew.footer4')}}</p>
    </div>

</div>

<div class="container">
    <section class="call-to-action featured footer">
        <div class="container">
            <div class="row">
                <div class="center">
                    <h3>{{trans('websitenew.footer5')}} <strong>{{trans('websitenew.footer6')}}</strong> {{trans('websitenew.footer7')}} <strong>{{trans('websitenew.footer8')}}</strong> <a href="{{URL::route('signup')}}" target="_blank" class="btn btn-lg btn-primary" data-appear-animation="bounceIn">Join Us Now!</a> <span class="arrow hlb hidden-xs hidden-sm hidden-md" data-appear-animation="rotateInUpLeft" style="top: -22px;"></span></h3>
                </div>
            </div>
        </div>
    </section>
</div>

<hr class="invisible tall">

<section class="featured highlight footer">
    <div class="container">
        <div class="row center counters">
            <div class="col-md-3">
                <div data-appear-animation="bounceIn" data-appear-animation-delay="0">
                    <strong data-to="{{$totaluser}}">{{$totaluser}}</strong>
                    <label>{{trans('websitenew.happyparticipants')}}</label>
                </div>
            </div>
            <div class="col-md-3">
                <div data-appear-animation="bounceIn" data-appear-animation-delay="200">
                    <strong data-to="{{$totalcountries}}">{{$totalcountries}}</strong>
                    <label>{{trans('websitenew.countries')}}</label>
                </div>
            </div>
            <div class="col-md-3">
                <div data-appear-animation="bounceIn" data-appear-animation-delay="400">
                    <strong data-to="{{$totalleader}}">{{$totalleader}}</strong>
                    <label>{{trans('websitenew.countryleader')}}</label>
                </div>
            </div>
            <div class="col-md-3">
                <div data-appear-animation="bounceIn" data-appear-animation-delay="600">
                    <strong data-to="2015">2015</strong>
                    <label>{{trans('websitenew.launched')}}</label>
                </div>
            </div>
        </div>
    </div>
</section>


@stop