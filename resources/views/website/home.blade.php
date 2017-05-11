@extends('website.default')

@section('title')Bank by community for the community @Stop

@section('homeclass')active @Stop

@section('content')
    <style>
        .tp-caption {
            text-shadow: 0px 2px 6px rgba(0, 0, 0, 1);
        }
    </style>
<div role="main" class="main">
    <section class="home-top clean">
        <div class="slider-container">
            <div class="slider" id="revolutionSlider" data-plugin-revolution-slider data-plugin-options='{"startheight": 500}'>
                <ul>
                    <li data-transition="fade" data-slotamount="13" data-masterspeed="300" >

                        <img src="web_content/img/slides/slide-together-bg-video.jpg" data-bgposition="left top" data-bgrepeat="no-repeat">

                        <div class="tp-caption white top-label md white customin"
                             style="width:600px; text-align:right;"
                             data-x="right" data-hoffset="-50"
                             data-y="75"
                             data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                             data-speed="800"
                             data-start="0"
                             data-easing="Back.easeInOut"
                             data-endspeed="300"><img src="web_content/img/video_pre.png" width="100%"/>
                        </div>

                        <div class="tp-caption white top-label md white customin"
                             data-x="left" data-hoffset="140"
                             data-y="120"
                             data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                             data-speed="800"
                             data-start="0"
                             data-easing="Back.easeInOut"
                             data-endspeed="300">{{trans('websitenew.pri_vid-1')}}<br>{{trans('websitenew.pri_vid-2')}}
                        </div>

                        <div class="tp-caption main-label md white customin"
                             style="font-size:20px; line-height: 25px;"
                             data-x="left" data-hoffset="140"
                             data-y="190"
                             data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                             data-speed="800"
                             data-start="300"
                             data-easing="Back.easeInOut"
                             data-endspeed="300">{{trans('websitenew.pri_vid-3')}} <br>{{trans('websitenew.pri_vid-4')}}<br> {{trans('websitenew.pri_vid-5')}} <br>{{trans('websitenew.pri_vid-6')}}<br> {{trans('websitenew.pri_vid-7')}}
                        </div>



                        <a class="tp-caption btn btn-lg btn-primary main-button popup-youtube" href="{{trans('websitenew.primary_video')}}"
                           data-x="left" data-hoffset="140"
                           data-y="340"
                           data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                           data-speed="800"
                           data-start="700"
                           data-easing="Back.easeInOut"
                           data-endspeed="300">
                            <span class="fa fa-film"></span> &nbsp;<span class="blink">Watch Now</span>
                        </a>


                    </li>

                    <li data-transition="fade" data-slotamount="13" data-masterspeed="300" >

                        <img src="web_content/img/slides/slide-together-bg-1.jpg" data-bgposition="left top" data-bgrepeat="no-repeat">

                        <div class="tp-caption white top-label md white customin"
                             data-x="left" data-hoffset="190"
                             data-y="170"
                             data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                             data-speed="800"
                             data-start="0"
                             data-easing="Back.easeInOut"
                             data-endspeed="300">{{trans('websitenew.slider1')}}
                        </div>

                        <div class="tp-caption main-label md white customin"
                             style="font-size:80px;"
                             data-x="left" data-hoffset="190"
                             data-y="190"
                             data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                             data-speed="800"
                             data-start="300"
                             data-easing="Back.easeInOut"
                             data-endspeed="300">{{trans('websitenew.slider1_1')}}
                        </div>

                        <a class="tp-caption customin btn btn-lg btn-primary main-button signupbutton" data-hash href="#" onclick="window.location.href = '{{URL::route('signup')}}'"
                           data-x="left" data-hoffset="190"
                           data-y="290"
                           data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                           data-speed="800"
                           data-start="700"
                           data-easing="Back.easeInOut"
                           data-endspeed="300">
                            <span class="blink">{{trans('websitenew.slider1_2')}}</span>
                        </a>


                    </li>
                    <li data-transition="fade" data-slotamount="13" data-masterspeed="300" >

                        <img src="web_content/img/slides/slide-reward-bg-1.jpg" data-bgposition="left top" data-bgrepeat="no-repeat">

                        <div class="tp-caption white top-label md white customin"
                             data-x="right" data-hoffset="-75"
                             data-y="220"
                             data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                             data-speed="800"
                             data-start="0"
                             data-easing="Back.easeInOut"
                             data-endspeed="300">{{trans('websitenew.slider2')}}
                        </div>

                        <div class="tp-caption main-label md white customin"
                             style="font-size:80px;"
                             data-x="right" data-hoffset="-75"
                             data-y="240"
                             data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                             data-speed="800"
                             data-start="300"
                             data-easing="Back.easeInOut"
                             data-endspeed="300">{{trans('websitenew.slider2_1')}}
                        </div>



                    </li>
                    <li data-transition="fade" data-slotamount="13" data-masterspeed="300" >

                        <img src="web_content/img/slides/slide-manage-bg-1.jpg" data-bgposition="left top" data-bgrepeat="no-repeat">

                        <div class="tp-caption sfr"
                             data-x="center" data-hoffset="-200"
                             data-y="center" data-voffset="30"
                             data-speed="800"
                             data-start="0"
                             data-easing="Back.easeInOut"
                             data-endspeed="300">
                            <img src="web_content/img/slides/slide-mockup-1.png">
                        </div>

                        <div class="tp-caption sfr"
                             data-x="center" data-hoffset="0"
                             data-y="center" data-voffset="30"
                             data-speed="800"
                             data-start="300"
                             data-easing="Back.easeInOut"
                             data-endspeed="300">
                            <img src="web_content/img/slides/slide-mockup-2.png">
                        </div>

                        <div class="tp-caption sfr"
                             data-x="center" data-hoffset="200"
                             data-y="center" data-voffset="30"
                             data-speed="800"
                             data-start="600"
                             data-easing="Back.easeInOut"
                             data-endspeed="300">
                            <img src="web_content/img/slides/slide-mockup-3.png">
                        </div>

                        <div class="tp-caption text-bg text-bg-dark white top-label sfr"
                             data-x="left" data-hoffset="130"
                             data-y="center" data-voffset="-52"
                             data-speed="800"
                             data-start="500"
                             data-easing="Back.easeInOut"
                             data-endspeed="300"
                             style="z-index: 1001; padding: 10px;">{{trans('websitenew.slider3')}}<br>
                        </div>

                        <div class="tp-caption text-bg white top-label sfr"
                             data-x="left" data-hoffset="130"
                             data-y="center" data-voffset="-10"
                             data-speed="800"
                             data-start="500"
                             data-easing="Back.easeInOut"
                             data-endspeed="300"
                             style="z-index: 1001; padding: 10px;"><small>{{trans('websitenew.slider3_1')}}</small>
                        </div>

                    </li>
                </ul>
            </div>
        </div>
    </section>

    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="feature-box secundary">
                            <div class="feature-box-icon">
                                <i class="fa fa-group"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="shorter">{{trans('websitenew.box1')}}</h4>
                                <p class="tall">{{trans('websitenew.box1_1')}}</p>
                            </div>
                        </div>
                        <div class="feature-box secundary push-top">
                            <div class="feature-box-icon">
                                <i class="fa fa-file"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="shorter">{{trans('websitenew.box2')}}</h4>
                                <p class="tall">{{trans('websitenew.box2_1')}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-box secundary">
                            <div class="feature-box-icon">
                                <i class="fa fa-film"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="shorter">{{trans('websitenew.box3')}}</h4>
                                <p class="tall">{{trans('websitenew.box3_1')}}</p>
                            </div>
                        </div>
                        <div class="feature-box secundary push-top">
                            <div class="feature-box-icon">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="shorter">{{trans('websitenew.box4')}}</h4>
                                <p class="tall">{{trans('websitenew.box4_1')}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-box secundary">
                            <div class="feature-box-icon">
                                <i class="fa fa-bars"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="shorter">{{trans('websitenew.box5')}}</h4>
                                <p class="tall">{{trans('websitenew.box5_1')}}</p>
                            </div>
                        </div>
                        <div class="feature-box secundary push-top">
                            <div class="feature-box-icon">
                                <i class="fa fa-desktop"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="shorter">{{trans('websitenew.box6')}}</h4>
                                <p class="tall">{{trans('websitenew.box6_1')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <section class="parallax" data-stellar-background-ratio="0.4" style="background-image: url('web_content/img/parallax-2.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-md-6" data-appear-animation="fadeInLeft">
                    <h2 class="push-top white"><i class="fa fa-mobile"></i> {{trans('websitenew.mobile1')}} <strong>{{trans('websitenew.mobile2')}}</strong></h2>
                    <p class="white lead">
                        {{trans('websitenew.mobiledecs_1')}}
                    <p class=" white tall">
                        {{trans('websitenew.mobiledecs_2')}}<br>
                        {{trans('websitenew.mobiledecs_3')}}
                    </p>

                    <img src="web_content/img/storecoomingsoon.png" width="300px">

                </div>
                <div class="col-md-5 col-md-offset-1" data-appear-animation="fadeInRight" data-appear-animation-delay="300">
                    <img class="img-responsive pull-right" src="web_content/img/appsmobile.png">
                </div>
            </div>
        </div>
    </section>

    <div class="container" >

        <div class="row" id="EmbdeVideo">
        

            <div class="row">
                <ul class="nav nav-pills sort-source pull-right push-bottom" data-sort-id="portfolio" data-option-key="filter">
                    <li data-option-value="*" class="active"><a href="#">{{trans('websitenew.showall')}}</a></li>
                    <li data-option-value=".pdf"><a href="#">{{trans('websitenew.pdfguide')}}</a></li>
                    <li data-option-value=".videos"><a href="#">{{trans('websitenew.video')}}</a></li>
                    <li data-option-value=".testimonial"><a href="#">{{trans('websitenew.testimonial')}}</a></li>
                </ul>
            </div>
            
            <!-- 
             <div class="row hide">
            	<div class="col-md-12"><iframe id="iFrame" width="100%" height="500" src="https://www.youtube.com/embed/NAMp13hXzaw" frameborder="0" allowfullscreen></iframe></div>
			</div>
			<br>  -->
            <div class="row">
            
            

                <ul class="portfolio-list sort-destination" data-sort-id="portfolio">
                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item videos">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.youtube.com/watch?v=ytyWckgDt9Q" class="thumb-info popup-youtube">
										<span class="thumb-info-image">
											<img alt="" class="img-responsive" src="web_content/img/projects/project-1b.jpg">
										</span>
										<span class="thumb-info-title">
											<span class="thumb-info-inner">Bitregion Facts</span>
											<span class="thumb-info-type">{{trans('websitenew.video')}}</span>
										</span>
										<span class="thumb-info-action">
											<span class="thumb-info-action-left"><em>{{trans('websitenew.view')}}</em></span>
											<span class="thumb-info-action-right"><em><i class="fa fa-plus"></i> {{trans('websitenew.details')}}</em></span>
										</span>
                            </a>
                        </div>
                    </li>
                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item videos">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.youtube.com/watch?v=fHIzU5KYomY" class="thumb-info popup-youtube">
										<span class="thumb-info-image">
											<img alt="" class="img-responsive" src="web_content/img/projects/project-1a.jpg">
										</span>
										<span class="thumb-info-title">
											<span class="thumb-info-inner">Donation Hybrid System</span>
											<span class="thumb-info-type">{{trans('websitenew.video')}}</span>
										</span>
										<span class="thumb-info-action">
											<span class="thumb-info-action-left"><em>{{trans('websitenew.view')}}</em></span>
											<span class="thumb-info-action-right"><em><i class="fa fa-plus"></i> {{trans('websitenew.details')}}</em></span>
										</span>
                            </a>
                        </div>
                    </li>
                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item pdf">
                        <div class="portfolio-item img-thumbnail">
                            <a href="web_content/ajax/pdf_marketing_plan.html" class="thumb-info simple-ajax-modal">
										<span class="thumb-info-image">
											<img alt="" class="img-responsive" src="web_content/img/projects/project.jpg">
										</span>
										<span class="thumb-info-title">
											<span class="thumb-info-inner">{{trans('websitenew.marketingplanebook')}}</span>
											<span class="thumb-info-type">{{trans('websitenew.pdfebook')}}</span>
										</span>
										<span class="thumb-info-action">
											<span class="thumb-info-action-left"><em>{{trans('websitenew.view')}}</em></span>
											<span class="thumb-info-action-right"><em><i class="fa fa-plus"></i> {{trans('websitenew.details')}}</em></span>
										</span>
                            </a>
                        </div>
                    </li>
                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item videos">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.youtube.com/watch?v=E_90BCsQPMA" class="thumb-info popup-youtube">
										<span class="thumb-info-image">
											<img alt="" class="img-responsive" src="web_content/img/projects/project-1.jpg">
										</span>
										<span class="thumb-info-title">
											<span class="thumb-info-inner">{{trans('websitenew.marketingplanvideo')}}</span>
											<span class="thumb-info-type">{{trans('websitenew.video')}}</span>
										</span>
										<span class="thumb-info-action">
											<span class="thumb-info-action-left"><em>{{trans('websitenew.view')}}</em></span>
											<span class="thumb-info-action-right"><em><i class="fa fa-plus"></i> {{trans('websitenew.details')}}</em></span>
										</span>
                            </a>
                        </div>
                    </li>
                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item pdf">
                        <div class="portfolio-item img-thumbnail">
                            <a href="web_content/ajax/pdf_getting_started.html" class="thumb-info simple-ajax-modal">
										<span class="thumb-info-image">
											<img alt="" class="img-responsive" src="web_content/img/projects/project-2.jpg">
										</span>
										<span class="thumb-info-title">
											<span class="thumb-info-inner">{{trans('websitenew.getstartedebook')}}</span>
											<span class="thumb-info-type">{{trans('websitenew.pdfebook')}}</span>
										</span>
										<span class="thumb-info-action">
											<span class="thumb-info-action-left"><em>{{trans('websitenew.view')}}</em></span>
											<span class="thumb-info-action-right"><em><i class="fa fa-plus"></i> {{trans('websitenew.details')}}</em></span>
										</span>
                            </a>
                        </div>
                    </li>
                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item videos">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.youtube.com/watch?v=q4AGISsaM-s" class="thumb-info popup-youtube">
										<span class="thumb-info-image">
											<img alt="" class="img-responsive" src="web_content/img/projects/project-3.jpg">
										</span>
										<span class="thumb-info-title">
											<span class="thumb-info-inner">{{trans('websitenew.brmarketingplancn')}}</span>
											<span class="thumb-info-type">{{trans('websitenew.video')}}</span>
										</span>
										<span class="thumb-info-action">
											<span class="thumb-info-action-left"><em>{{trans('websitenew.view')}}</em></span>
											<span class="thumb-info-action-right"><em><i class="fa fa-plus"></i> {{trans('websitenew.details')}}</em></span>
										</span>
                            </a>
                        </div>
                    </li>
                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item videos">
                        <div class="portfolio-item img-thumbnail">
                            <a href="http://player.youku.com/embed/XMTQzMDA1MzU2MA==" class="thumb-info popup-youtube">
										<span class="thumb-info-image">
											<img alt="" class="img-responsive" src="web_content/img/projects/project-3-youku.jpg">
										</span>
										<span class="thumb-info-title">
											<span class="thumb-info-inner">{{trans('websitenew.brmarketingvideocn')}}</span>
											<span class="thumb-info-type">{{trans('websitenew.video')}}</span>
										</span>
										<span class="thumb-info-action">
											<span class="thumb-info-action-left"><em>{{trans('websitenew.view')}}</em></span>
											<span class="thumb-info-action-right"><em><i class="fa fa-plus"></i> {{trans('websitenew.details')}}</em></span>
										</span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item pdf">
                        <div class="portfolio-item img-thumbnail">
                            <a href="web_content/ajax/cccn.html" class="thumb-info simple-ajax-modal">
                                    <span class="thumb-info-image">
                                        <img alt="" class="img-responsive" src="web_content/img/projects/project.jpg">
                                    </span>
                                    <span class="thumb-info-title">
                                        <span class="thumb-info-inner">{{trans('websitenew.marketebookcn')}}</span>
                                        <span class="thumb-info-type">{{trans('websitenew.pdfebook')}}</span>
                                    </span>
                                    <span class="thumb-info-action">
                                        <span class="thumb-info-action-left"><em>{{trans('websitenew.view')}}</em></span>
                                        <span class="thumb-info-action-right"><em><i class="fa fa-plus"></i> {{trans('websitenew.details')}}</em></span>
                                    </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item testimonial">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.youtube.com/watch?v=eAVVv_r1KfA" class="thumb-info popup-youtube">
										<span class="thumb-info-image">
											<img alt="" class="img-responsive" src="web_content/img/projects/testi01.jpg">
										</span>
										<span class="thumb-info-title">
											<span class="thumb-info-inner">{{trans('websitenew.germantesti')}}</span>
											<span class="thumb-info-type">{{trans('websitenew.testivideo')}}</span>
										</span>
										<span class="thumb-info-action">
											<span class="thumb-info-action-left"><em>{{trans('websitenew.view')}}</em></span>
											<span class="thumb-info-action-right"><em><i class="fa fa-plus"></i> {{trans('websitenew.details')}}</em></span>
										</span>
                            </a>
                        </div>
                    </li>
                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item testimonial">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.youtube.com/watch?v=U1GiDU3C-uo" class="thumb-info popup-youtube">
										<span class="thumb-info-image">
											<img alt="" class="img-responsive" src="web_content/img/projects/testi02.jpg">
										</span>
										<span class="thumb-info-title">
											<span class="thumb-info-inner">{{trans('websitenew.spaintesti')}}</span>
											<span class="thumb-info-type">{{trans('websitenew.testivideo')}}</span>
										</span>
										<span class="thumb-info-action">
											<span class="thumb-info-action-left"><em>{{trans('websitenew.view')}}</em></span>
											<span class="thumb-info-action-right"><em><i class="fa fa-plus"></i> {{trans('websitenew.details')}}</em></span>
										</span>
                            </a>
                        </div>
                    </li>
                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item testimonial">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.youtube.com/watch?v=EZxwMUGCoCs" class="thumb-info popup-youtube">
										<span class="thumb-info-image">
											<img alt="" class="img-responsive" src="web_content/img/projects/testi03.jpg">
										</span>
										<span class="thumb-info-title">
											<span class="thumb-info-inner">{{trans('websitenew.indiatesti')}}</span>
											<span class="thumb-info-type">{{trans('websitenew.testivideo')}}</span>
										</span>
										<span class="thumb-info-action">
											<span class="thumb-info-action-left"><em>{{trans('websitenew.view')}}</em></span>
											<span class="thumb-info-action-right"><em><i class="fa fa-plus"></i> {{trans('websitenew.details')}}</em></span>
										</span>
                            </a>
                        </div>
                    </li>
                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item testimonial">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.youtube.com/watch?v=VQ4flvFefEU" class="thumb-info popup-youtube">
										<span class="thumb-info-image">
											<img alt="" class="img-responsive" src="web_content/img/projects/testi04.jpg">
										</span>
										<span class="thumb-info-title">
											<span class="thumb-info-inner">{{trans('websitenew.africatesti')}}</span>
											<span class="thumb-info-type">{{trans('websitenew.testivideo')}}</span>
										</span>
										<span class="thumb-info-action">
											<span class="thumb-info-action-left"><em>{{trans('websitenew.view')}}</em></span>
											<span class="thumb-info-action-right"><em><i class="fa fa-plus"></i> {{trans('websitenew.details')}}</em></span>
										</span>
                            </a>
                        </div>
                    </li>
                    
                </ul>
            </div>

        </div>

        <div class="center">

            <div class="divider tall colored">
                <i class="fa fa-star"></i>
            </div>

            <h2>{{trans('websitenew.footer1')}} <strong>{{trans('websitenew.footer2')}}</strong></h2>
            <p class="lead">{{trans('websitenew.footer3')}} </p>
            <p>{{trans('websitenew.footer4')}}</p>
        </div>

    </div>

</div>

<div class="container">
    <section class="call-to-action featured footer">
        <div class="container">
            <div class="row">
                <div class="center">
                    <h3>{{trans('websitenew.footer5')}} <strong>{{trans('websitenew.footer6')}}</strong> {{trans('websitenew.footer7')}} <strong>{{trans('websitenew.footer8')}}</strong> <a href="{{URL::route('signup')}}" target="_blank" class="btn btn-lg btn-primary blink" data-appear-animation="bounceIn">Join Us Now!</a> <span class="arrow hlb hidden-xs hidden-sm hidden-md" data-appear-animation="rotateInUpLeft" style="top: -22px;"></span></h3>
                </div>
            </div>
        </div>
    </section>
</div>

<hr class="invisible tall">

<section class="featured highlight footer">
    <div class="container">
        <h3 class="text-center">Live Statistics Of Our Community </h3>
        
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

</div>
<style>
    .comodologo img {
        position:fixed;
        z-index:10000;
        bottom:10px;
        left:10px;
    }
</style>
    <div class="comodologo">
    <!--
    <script language="JavaScript" type="text/javascript">
        TrustLogo("https://www.bitregion.com/img/comodo.png", "CL1", "none");
    </script>
    -->
    <a href="https://trustlogo.com/ttb_searcher/trustlogo?v_querytype=W&v_shortname=CL1&v_search=http://{{ Request::server ("SERVER_NAME") }}/&x=6&y=5" target="_blank">
    <img src="img/comodo.png">
    </a>
    </div>
    
    <script>

    /*
    $(function(){
        $(".Videos").click(function(){ 
        	$( "#EmbdeVideo" ).scroll();
        });
    });
    var $iframe = $('#iFrame');
    $(document).ready(function(){
    	$('a[href^="#"]').on('click',function (e) {
    		if ( $(this).attr('media').length )
    	        $iframe.attr('src',$(this).attr('media')); 
    	    e.preventDefault();
    	    var target = this.hash;
    	    var $target = $(target);
    	    $('html, body').stop().animate({
    	        'scrollTop': $target.offset().top
    	    }, 900, 'swing', function () {
    	        //window.location.hash = target;
    	    });
    	});
    });
    */


function blinker() {
	$('.blink').fadeOut(500);
	$('.blink').fadeIn(500);
}
setInterval(blinker, 1000);


   
</script>
@stop
