<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{trans('website.site_title')}}</title>
    <link rel="shortcut icon" type="image/png" href="{{asset('favicon.png')}}"/>

    <link href="{{asset('assets_old/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets_old/dist/css/agency.css')}}" rel="stylesheet">
    <link href="{{asset('assets_old/plugin/polygot/css/polyglot-language-switcher.css')}}" rel="stylesheet" type="text/css">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('{{asset('assets_old/images/siteloader.gif')}}') center no-repeat #000;
        }
    </style>

</head>

<body id="page-top" class="index">
<div class="se-pre-con"></div>
<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand page-scroll" href="#page-top"><img src="{{asset('assets_old/images/logo_large.png')}}" width="280" style="margin-top:-45px;"/></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="hidden">
                    <a href="#page-top"></a>
                </li>
                <li>
                    <a class="page-scroll thelink" href="#services">{{trans('website.about')}}</a>
                </li>

                <li>
                    <a class="page-scroll thelink" href="#about">{{trans('website.how_it_works')}}</a>
                </li>

                <li>
                    <a class="page-scroll thelink" href="#contact">{{trans('website.contact')}}</a>
                </li>
                <li>
                    <a class="page-scroll thelink" href="{{URL::route('login')}}">{{trans('website.login')}}</a>
                </li>
                <li>
                    <a class="page-scroll thelink" href="{{URL::route('signup')}}">{{trans('website.register')}}</a>
                </li>
                <li>
                    <div id="polyglotLanguageSwitcher" class="front_langchooser" style="margin-left:15px;">
                        <form id="updatelang" action="{{URL::route('set-locale')}}">
                            <select id="polyglot-language-options">
                                <option id="en" value="en" @if(Lang::locale() == 'en') selected @endif>English</option>
                                <option id="cn" value="cn" @if(Lang::locale() == 'cn') selected @endif>中文</option>
                            </select>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<!-- Header -->
<header>
    <div class="container">
        <div class="intro-text">
            <div class="intro-lead-in">{{trans('website.intro_lead_in')}}</div>
            <div class="intro-heading">{{trans('website.intro_heading')}}</div>
            <a href="#services" class="page-scroll btn btn-xl">{{trans('website.page_scroll_button')}}</a>
        </div>
    </div>
</header>

<!-- Services Section -->
<section id="services">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">{{trans('website.services_heading')}}</h2>
                <h3 class="section-subheading text-muted">{{trans('website.services_subheading')}}</h3>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-6">
                    <span class="fa-stack fa-4x">
                        <img src="{{asset('assets/images/regionbank.png')}}" width="100" class="img-circle" style="background-color:#e2a129; padding:20px;"/>
                    </span>
                <h4 class="service-heading">{{trans('website.agb')}}</h4>
                <p class="text-muted">{{trans('website.agb_description')}}</p>
            </div>
            <div class="col-md-6">
                    <span class="fa-stack fa-4x">
                        <img src="{{asset('assets/images/rb.png')}}" width="100" class="img-circle" style="background-color:#e2a129; padding:20px;"/>
                    </span>
                <h4 class="service-heading">{{trans('website.region_bank')}}</h4>
                <p class="text-muted">{{trans('website.region_bank_decription')}}</p>
            </div>
        </div>
    </div>
</section>

<!-- Portfolio Grid Section -->

</section>

<!-- About Section -->
<section id="about" class="bg-light-gray" >
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2 class="section-heading">{{trans('website.how_br_works')}}</h2>
            <div class="hidden-sm hidden-xs" style="margin-left:auto; margin-right:auto; text-align:center; margin-bottom:30px;"><iframe width="853" height="480" src="https://www.youtube.com/embed/-X2mS7HKJKU?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe></div>
            <div class="visible-sm visible-xs vidcontainer"><iframe class="video" width="100%" src="https://www.youtube.com/embed/-X2mS7HKJKU?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe></div>
            <h3 class="section-subheading text-muted">{{trans('website.how_br_works_description')}}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <ul class="timeline">
                <li>
                    <div class="timeline-image">
                        <img class="img-circle img-responsive" src="{{asset('assets/images/class/1.png')}}" width="200" alt="">
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>{{trans('website.immigrant')}}</h4>
                            <h4 class="subheading">{{trans('website.immigrant_header')}}</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">{{trans('website.immigrant_description')}}</p>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-image">
                        <img class="img-circle img-responsive" src="{{asset('assets/images/class/2.png')}}" width="200" alt="">
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>{{trans('website.visa_holder')}}</h4>
                            <h4 class="subheading">{{trans('website.visa_holder_header')}}</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">{{trans('website.visa_holder_description')}}</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="timeline-image">
                        <img class="img-circle img-responsive"  src="{{asset('assets/images/class/3.png')}}" width="200" alt="">
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>{{trans('website.permanent_resident')}}</h4>
                            <h4 class="subheading">{{trans('website.permanent_resident_header')}}</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">{{trans('website.permanent_resident_description')}}</p>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-image">
                        <img class="img-circle img-responsive" src="{{asset('assets/images/class/4.png')}}" width="200"  alt="">
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>{{trans('website.citizen')}}</h4>
                            <h4 class="subheading">{{trans('website.citizen_header')}}</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">{{trans('website.citizen_header_description')}}</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="timeline-image">
                        <img class="img-circle img-responsive" src="{{asset('assets/images/class/5.png')}}" width="200"  alt="">
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>{{trans('website.ambassador')}}</h4>
                            <h4 class="subheading">{{trans('website.ambassador_header')}}</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">{{trans('website.ambassador_description')}}</p>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-image">
                        <img class="img-circle img-responsive" src="{{asset('assets/images/class/6.png')}}" width="200"  alt="">
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>{{trans('website.senator')}}</h4>
                            <h4 class="subheading">{{trans('website.senator_header')}}</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">{{trans('website.senator_description')}}</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="timeline-image">
                        <img class="img-circle img-responsive" src="{{asset('assets/images/class/7.png')}}" width="200"  alt="">
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>{{trans('website.vice_president')}}</h4>
                            <h4 class="subheading">{{trans('website.vice_president_header')}}</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">{{trans('website.vice_president_description')}}</p>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-image">
                        <img class="img-circle img-responsive" src="{{asset('assets/images/class/8.png')}}" width="200"  alt="">
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>{{trans('website.president')}}</h4>
                            <h4 class="subheading">{{trans('website.president_header')}}</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">{{trans('website.president_description')}}</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    </div>
</section>

<!-- Team Section -->


<!-- Contact Section -->
<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">{{trans('website.need_more_info')}}</h2>
                <h3 class="section-subheading text-muted">Sponsored by <strong>{{$referral}}</strong></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                    <div class="row">
                        <div id="thecontactform" class="text-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="{{trans('website.your_name')}}" id="name" required data-validation-required-message="{{trans('website.your_name_details')}}">
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="{{trans('website.your_email')}}" id="email" required data-validation-required-message="{{trans('website.your_email_details')}}">
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="form-group">
                                <input type="tel" class="form-control" placeholder="{{trans('website.your_phone')}}" id="phone" required type="number" data-validation-required-message="{{trans('website.your_phone_details')}}">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <textarea class="form-control" placeholder="{{trans('website.your_message')}}" id="message" required data-validation-required-message="{{trans('website.your_message_details')}}"></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-12 text-center">
                            <div id="{{trans('website.success')}}"></div>
                            <button id="contactformsubmit" type="submit" class="btn btn-xl">{{trans('website.send_message')}}</button>
                        </div>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <span class="copyright">Copyright &copy; Bitregion</span>
            </div>
            <div class="col-md-4">
                <ul class="list-inline social-buttons">
                    <li><a target="_blank" href="http://tagboard.com/bitregion/search">#</a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</footer>

<!-- Portfolio Modals -->
<!-- Use the modals below to showcase details about your portfolio projects! -->

<!-- Portfolio Modal 1 -->
<div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="modal-body">
                        <!-- Project Details Go Here -->
                        <h2>Project Name</h2>
                        <p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
                        <img class="img-responsive img-centered" src="img/portfolio/roundicons-free.png" alt="">
                        <p>Use this area to describe your project. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est blanditiis dolorem culpa incidunt minus dignissimos deserunt repellat aperiam quasi sunt officia expedita beatae cupiditate, maiores repudiandae, nostrum, reiciendis facere nemo!</p>
                        <p>
                            <strong>Want these icons in this portfolio item sample?</strong>You can download 60 of them for free, courtesy of <a href="https://getdpd.com/cart/hoplink/18076?referrer=bvbo4kax5k8ogc">RoundIcons.com</a>, or you can purchase the 1500 icon set <a href="https://getdpd.com/cart/hoplink/18076?referrer=bvbo4kax5k8ogc">here</a>.</p>
                        <ul class="list-inline">
                            <li>Date: July 2014</li>
                            <li>Client: Round Icons</li>
                            <li>Category: Graphic Design</li>
                        </ul>
                        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Portfolio Modal 2 -->
<div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="modal-body">
                        <h2>Project Heading</h2>
                        <p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
                        <img class="img-responsive img-centered" src="img/portfolio/startup-framework-preview.png" alt="">
                        <p><a href="http://designmodo.com/startup/?u=787">Startup Framework</a> is a website builder for professionals. Startup Framework contains components and complex blocks (PSD+HTML Bootstrap themes and templates) which can easily be integrated into almost any design. All of these components are made in the same style, and can easily be integrated into projects, allowing you to create hundreds of solutions for your future projects.</p>
                        <p>You can preview Startup Framework <a href="http://designmodo.com/startup/?u=787">here</a>.</p>
                        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Portfolio Modal 3 -->
<div class="portfolio-modal modal fade" id="portfolioModal3" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="modal-body">
                        <!-- Project Details Go Here -->
                        <h2>Project Name</h2>
                        <p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
                        <img class="img-responsive img-centered" src="img/portfolio/treehouse-preview.png" alt="">
                        <p>Treehouse is a free PSD web template built by <a href="https://www.behance.net/MathavanJaya">Mathavan Jaya</a>. This is bright and spacious design perfect for people or startup companies looking to showcase their apps or other projects.</p>
                        <p>You can download the PSD template in this portfolio sample item at <a href="http://freebiesxpress.com/gallery/treehouse-free-psd-web-template/">FreebiesXpress.com</a>.</p>
                        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Portfolio Modal 4 -->
<div class="portfolio-modal modal fade" id="portfolioModal4" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="modal-body">
                        <!-- Project Details Go Here -->
                        <h2>Project Name</h2>
                        <p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
                        <img class="img-responsive img-centered" src="img/portfolio/golden-preview.png" alt="">
                        <p>Start Bootstrap's Agency theme is based on Golden, a free PSD website template built by <a href="https://www.behance.net/MathavanJaya">Mathavan Jaya</a>. Golden is a modern and clean one page web template that was made exclusively for Best PSD Freebies. This template has a great portfolio, timeline, and meet your team sections that can be easily modified to fit your needs.</p>
                        <p>You can download the PSD template in this portfolio sample item at <a href="http://freebiesxpress.com/gallery/golden-free-one-page-web-template/">FreebiesXpress.com</a>.</p>
                        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Portfolio Modal 5 -->
<div class="portfolio-modal modal fade" id="portfolioModal5" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="modal-body">
                        <!-- Project Details Go Here -->
                        <h2>Project Name</h2>
                        <p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
                        <img class="img-responsive img-centered" src="img/portfolio/escape-preview.png" alt="">
                        <p>Escape is a free PSD web template built by <a href="https://www.behance.net/MathavanJaya">Mathavan Jaya</a>. Escape is a one page web template that was designed with agencies in mind. This template is ideal for those looking for a simple one page solution to describe your business and offer your services.</p>
                        <p>You can download the PSD template in this portfolio sample item at <a href="http://freebiesxpress.com/gallery/escape-one-page-psd-web-template/">FreebiesXpress.com</a>.</p>
                        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Portfolio Modal 6 -->
<div class="portfolio-modal modal fade" id="portfolioModal6" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="modal-body">
                        <!-- Project Details Go Here -->
                        <h2>Project Name</h2>
                        <p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
                        <img class="img-responsive img-centered" src="img/portfolio/dreams-preview.png" alt="">
                        <p>Dreams is a free PSD web template built by <a href="https://www.behance.net/MathavanJaya">Mathavan Jaya</a>. Dreams is a modern one page web template designed for almost any purpose. It’s a beautiful template that’s designed with the Bootstrap framework in mind.</p>
                        <p>You can download the PSD template in this portfolio sample item at <a href="http://freebiesxpress.com/gallery/dreams-free-one-page-web-template/">FreebiesXpress.com</a>.</p>
                        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{asset('assets_old/bower_components/jquery/dist/jquery.js')}}" type="text/javascript"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{asset('assets_old/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<!-- Plugin JavaScript -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="{{asset('assets_old/js/classie.js')}}"></script>
<script src="{{asset('assets_old/js/cbpAnimatedHeader.js')}}"></script>

<!-- Contact Form JavaScript -->
<script src="{{asset('assets_old/js/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('assets_old/js/contact_me.js')}}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{asset('assets_old/js/agency.js')}}"></script>
<script src="{{asset('assets_old/plugin/polygot/js/jquery.polyglot.language.switcher.js')}}" type="text/javascript"></script>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-71230212-1', 'auto');
    ga('send', 'pageview');

</script>

<script type="text/javascript">
    $(window).load(function() {
        $(".se-pre-con").fadeOut("slow");;
    });
    $(document).ready(function() {
        $('#polyglotLanguageSwitcher').polyglotLanguageSwitcher({
            effect: 'fade',
            testMode: true,
            onChange: function(evt){
                $(location).attr('href','{{URL::route('set-locale')}}'+'?lang='+evt.selectedItem)
            }
        });
    });


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
                $('#thecontactform').html('<h3 class="section-heading">{{trans('website.thankyou_contact_shortly')}}</h3>');
            }
        });
    })
</script>
</body>

</html>
