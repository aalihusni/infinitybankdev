<?php
session_start();

include("php/simple-php-captcha/simple-php-captcha.php");
include("php/php-mailer/class.phpmailer.php");

// Step 1 - Enter your email address below.
$to = 'you@domain.com';

if(isset($_POST['emailSent'])) {

	$subject = $_POST['subject'];

	// Step 2 - If you don't want a "captcha" verification, remove that IF.
	if (strtolower($_POST["captcha"]) == strtolower($_SESSION['captcha']['code'])) {

		$name = $_POST['name'];
		$email = $_POST['email'];

		// Step 3 - Configure the fields list that you want to receive on the email.
		$fields = array(
			0 => array(
				'text' => 'Name',
				'val' => $_POST['name']
			),
			1 => array(
				'text' => 'Email address',
				'val' => $_POST['email']
			),
			2 => array(
				'text' => 'Message',
				'val' => $_POST['message']
			),
			3 => array(
				'text' => 'Checkboxes',
				'val' => implode($_POST['checkboxes'], ", ")
			),
			4 => array(
				'text' => 'Radios',
				'val' => $_POST['radios']
			)
		);

		$message = "";

		foreach($fields as $field) {
			$message .= $field['text'].": " . htmlspecialchars($field['val'], ENT_QUOTES) . "<br>\n";
		}

		$mail = new PHPMailer;

		$mail->IsSMTP();

		// Debug Mode
		$mail->SMTPDebug = 0;

		// Step 4 - If you don't receive the email, try to configure the parameters below:

		//$mail->Host = 'mail.yourserver.com';				  // Specify main and backup server
		//$mail->SMTPAuth = true;                             // Enable SMTP authentication
		//$mail->Username = 'username';             		  // SMTP username
		//$mail->Password = 'secret';                         // SMTP password
		//$mail->SMTPSecure = 'tls';                          // Enable encryption, 'ssl' also accepted

		$mail->From = $email;
		$mail->FromName = $_POST['name'];
		$mail->AddAddress($to);
		$mail->AddReplyTo($email, $name);

		$mail->IsHTML(true);

		$mail->CharSet = 'UTF-8';

		$mail->Subject = $subject;
		$mail->Body    = $message;

		// Step 5 - If you don't want to attach any files, remove that code below
		if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
			$mail->AddAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
		}

		if($mail->Send()) {
			$arrResult = array('response'=> 'success');
		} else {
			$arrResult = array('response'=> 'error', 'error'=> $mail->ErrorInfo);
		}

	} else {

		$arrResult['response'] = 'captchaError';

	}

}
?>
<!DOCTYPE html>
<html>
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<title>Contact Us Advanced | Tucson - Responsive HTML5 Template 2.1.0</title>		
		<meta name="keywords" content="HTML5 Template" />
		<meta name="description" content="Tucson - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Alegreya|Alegreya+SC|Oswald:400,300" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="vendor/bootstrap/bootstrap.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.css">
		<link rel="stylesheet" href="vendor/rs-plugin/css/settings.css">
		<link rel="stylesheet" href="vendor/owlcarousel/owl.carousel.css">
		<link rel="stylesheet" href="vendor/owlcarousel/owl.theme.css">
		<link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.css">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="css/theme.css">
		<link rel="stylesheet" href="css/theme-elements.css">
		<link rel="stylesheet" href="css/theme-blog.css">
		<link rel="stylesheet" href="css/theme-shop.css">
		<link rel="stylesheet" href="css/theme-animate.css">

		<!-- Skin CSS -->
		<link rel="stylesheet" href="css/skins/default.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="css/custom.css">

		<!-- Head Libs -->
		<script src="vendor/modernizr/modernizr.js"></script>

		<!--[if IE]>
			<link rel="stylesheet" href="css/ie.css">
		<![endif]-->

		<!--[if lte IE 8]>
			<script src="vendor/respond/respond.js"></script>
			<script src="vendor/excanvas/excanvas.js"></script>
		<![endif]-->

	</head>
	<body>

		<div class="body">
			<header id="header">



				<div class="container">
					<h1 class="logo">
						<a href="index.html">
							<img alt="Tucson" width="148" height="44" data-sticky-width="134" data-sticky-height="40" src="img/logo.png">
						</a>
					</h1>
					<button class="btn btn-responsive-nav btn-inverse" data-toggle="collapse" data-target=".nav-main-collapse">
						<i class="fa fa-bars"></i>
					</button>
				</div>
				<div class="navbar-collapse nav-main-collapse collapse">
					<div class="container">
						<div class="search" id="headerSearch">
							<a href="#" id="headerSearchOpen"><i class="fa fa-search"></i></a>
							<div class="search-input">
								<form id="headerSearchForm" action="page-search-results.html" method="get">
									<div class="input-group">
										<input type="text" class="form-control search" name="q" id="q" placeholder="Search..." required>
										<span class="input-group-btn">
											<button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
										</span>
									</div>
								</form>
							</div>
						</div>
						<nav class="nav-main mega-menu">
							<ul class="nav nav-pills nav-main" id="mainMenu">
								<li class="dropdown">
									<a class="dropdown-toggle" href="#">
										Home
										<i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu">
										<li><a href="index.html">Home - Default</a></li>
										<li><a href="index-2.html">Home - Portfolio</a></li>
										<li><a href="index-3.html">Home - Basic</a></li>
										<li><a href="index-4.html">Home - Video</a></li>
									</ul>
								</li>
								<li>
									<a href="shortcodes.html">Shortcodes</a>
								</li>
								<li class="dropdown">
									<a class="dropdown-toggle" href="#">
										About Us
										<i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu">
										<li><a href="about-us.html">About Us</a></li>
										<li><a href="about-me.html">About Me</a></li>
									</ul>
								</li>
								<li class="dropdown mega-menu-item mega-menu-fullwidth">
									<a class="dropdown-toggle" href="#">
										Features
										<i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu">
										<li>
											<div class="mega-menu-content">
												<div class="row">
													<div class="col-md-3">
														<ul class="sub-menu">
															<li>
																<span class="mega-menu-sub-title">Main Features</span>
																<ul class="sub-menu">
																	<li><a href="feature-pricing-tables.html">Pricing Tables</a></li>
																	<li><a href="feature-icons.html">Icons</a></li>
																	<li><a href="feature-animations.html">Animations</a></li>
																	<li><a href="feature-typography.html">Typography</a></li>
																	<li><a href="feature-grid-system.html">Grid System</a></li>
																</ul>
															</li>
														</ul>
													</div>
													<div class="col-md-3">
														<ul class="sub-menu">
															<li>
																<span class="mega-menu-sub-title">Headers</span>
																<ul class="sub-menu">
																	<li><a href="index-header-1.html">Header Version 1</a></li>
																	<li><a href="index-header-2.html">Header Version 2</a></li>
																	<li><a href="index-header-3.html">Header Version 3</a></li>
																	<li><a href="index-header-4.html">Header Version 4</a></li>
																	<li><a href="index-header-5.html">Header Version 5 (Big Logo)</a></li>
																</ul>
															</li>
														</ul>
													</div>
													<div class="col-md-3">
														<ul class="sub-menu">
															<li>
																<span class="mega-menu-sub-title">Shop</span>
																<ul class="sub-menu">
																	<li><a href="shop-full-width.html">Shop - Full Width</a></li>
																	<li><a href="shop-sidebar.html">Shop - Sidebar</a></li>
																	<li><a href="shop-product-full-width.html">Shop - Product Full Width</a></li>
																	<li><a href="shop-product-sidebar.html">Shop - Product Sidebar</a></li>
																	<li><a href="shop-cart.html">Shop - Cart</a></li>
																	<li><a href="shop-login.html">Shop - Login</a></li>
																	<li><a href="shop-checkout.html">Shop - Checkout</a></li>
																</ul>
															</li>
														</ul>
													</div>
													<div class="col-md-3">
														<ul class="sub-menu">
															<li>
																<span class="mega-menu-sub-title">Blog</span>
																<ul class="sub-menu">
																	<li><a href="blog-full-width.html">Blog Full Width</a></li>
																	<li><a href="blog-large-image.html">Blog Large Image</a></li>
																	<li><a href="blog-medium-image.html">Blog Medium Image</a></li>
																	<li><a href="blog-timeline.html">Blog Timeline</a></li>
																	<li><a href="blog-post.html">Single Post</a></li>
																</ul>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</li>
									</ul>
								</li>
								<li class="dropdown">
									<a class="dropdown-toggle" href="#">
										Portfolio
										<i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu">
										<li><a href="portfolio-4-columns.html">4 Columns</a></li>
										<li><a href="portfolio-3-columns.html">3 Columns</a></li>
										<li><a href="portfolio-2-columns.html">2 Columns</a></li>
										<li><a href="portfolio-lightbox.html">Portfolio Lightbox</a></li>
										<li><a href="portfolio-timeline.html">Portfolio Timeline</a></li>
										<li><a href="portfolio-full-width.html">Portfolio Full Width</a></li>
										<li><a href="portfolio-single.html">Single - Basic</a></li>
										<li><a href="portfolio-single-extended.html">Single - Extended</a></li>
										<li><a href="portfolio-single-full-slider.html">Single - Full Slider</a></li>
										<li><a href="portfolio-single-sidebar.html">Single - Sidebar</a></li>
									</ul>
								</li>
								<li class="dropdown">
									<a class="dropdown-toggle" href="#">
										Pages
										<i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu">
										<li><a href="page-full-width.html">Full width</a></li>
										<li><a href="page-left-sidebar.html">Left sidebar</a></li>
										<li><a href="page-right-sidebar.html">Right sidebar</a></li>
										<li class="dropdown-submenu">
											<a href="#">Custom Header</a>
											<ul class="dropdown-menu">
												<li><a href="page-custom-header.html">Product - Header</a></li>
												<li><a href="page-custom-header-basic.html">Basic - Header</a></li>
												<li><a href="page-custom-header-video.html">Video - Header</a></li>
												<li><a href="page-custom-header-overlay.html">Overlay - Header</a></li>
												<li><a href="page-custom-header-parallax.html">Parallax - Header</a></li>
												<li><a href="page-custom-header-slideshow.html">Slideshow - Header</a></li>
											</ul>
										</li>
										<li><a href="page-404.html">404 Error</a></li>
										<li><a href="page-team.html">Team</a></li>
										<li><a href="page-services.html">Services</a></li>
										<li><a href="page-careers.html">Careers</a></li>
										<li><a href="page-faq.html">FAQ</a></li>
										<li><a href="page-login.html">Login / Register</a></li>
										<li><a href="sitemap.html">Sitemap</a></li>
									</ul>
								</li>
								<li class="dropdown active">
									<a class="dropdown-toggle" href="#">
										Contact Us
										<i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu">
										<li><a href="contact-us.html">Contact Us - Basic</a></li>
										<li><a href="contact-us-advanced.php">Contact Us - Advanced</a></li>
									</ul>
								</li>

							</ul>
						</nav>
					</div>
				</div>
			</header>

			<div role="main" class="main">

				<!-- Google Maps -->
				<div id="googlemaps" class="google-map"></div>

				<div class="container">

					<div class="row">
						<div class="col-md-6">

							<div class="offset-anchor" id="contact-sent"></div>

							<?php
							if (isset($arrResult)) {
								if($arrResult['response'] == 'success') {
								?>
								<div class="alert alert-success" id="contactSuccess">
									<strong>Success!</strong> Your message has been sent to us.
								</div>
								<?php
								} else if($arrResult['response'] == 'error') {
								?>
								<div class="alert alert-danger" id="contactError">
									<strong>Error!</strong> There was an error sending your message. (<?php echo $arrResult['error'];?>)
								</div>
								<?php
								} else if($arrResult['response'] == 'captchaError') {
								?>
								<div class="alert alert-danger" id="contactError">
									<strong>Error!</strong> Verificantion failed.
								</div>
								<?php
								}
							}
							?>

							<h2 class="short"><strong>Contact</strong> Us</h2>
							<form id="contactFormAdvanced" action="contact-us-advanced.php#contact-sent" method="POST" enctype="multipart/form-data">
								<input type="hidden" value="true" name="emailSent" id="emailSent">
								<div class="row">
									<div class="form-group">
										<div class="col-md-6">
											<label>Your name *</label>
											<input type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control" name="name" id="name" required>
										</div>
										<div class="col-md-6">
											<label>Your email address *</label>
											<input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control" name="email" id="email" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Subject</label>
											<select data-msg-required="Please enter the subject." class="form-control" name="subject" id="subject" required>
												<option value=""></option>
												<option value="Option 1">Option 1</option>
												<option value="Option 2">Option 2</option>
												<option value="Option 3">Option 3</option>
												<option value="Option 4">Option 4</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-12">
													<label>Checkboxes</label>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="checkbox-group" data-msg-required="Please select at least one option.">
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox1" value="option1"> 1
														</label>
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox2" value="option2"> 2
														</label>
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox3" value="option3"> 3
														</label>
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox2" value="option4"> 4
														</label>
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox3" value="option5"> 5
														</label>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-12">
													<label>Radios</label>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="radio-group" data-msg-required="Please select one option.">
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio1" value="option1"> 1
														</label>
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio2" value="option2"> 2
														</label>
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio3" value="option3"> 3
														</label>
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio2" value="option4"> 4
														</label>
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio3" value="option5"> 5
														</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Attachment</label>
											<input type="file" name="attachment" id="attachment">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Message *</label>
											<textarea maxlength="5000" data-msg-required="Please enter your message." rows="10" class="form-control" name="message" id="message" required></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<label>Human Verification *</label>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-4">
											<div class="captcha form-control">
												<div class="captcha-image">
													<?php
													$_SESSION['captcha'] = simple_php_captcha(array(
														'min_length' => 6,
														'max_length' => 6,
														'min_font_size' => 22,
														'max_font_size' => 22,
														'angle_max' => 3
													));

													$_SESSION['captchaCode'] = $_SESSION['captcha']['code'];

													echo '<img src="' . "php/simple-php-captcha/simple-php-captcha.php/" . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code">';
													?>
												</div>
											</div>
										</div>
										<div class="col-md-8">
											<input type="text" value="" maxlength="6" data-msg-captcha="Wrong verification code." data-msg-required="Please enter the verification code." placeholder="Type the verification code." class="form-control input-lg captcha-input" name="captcha" id="captcha" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<hr>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<input type="submit" id="contactFormSubmit" value="Send Message" class="btn btn-primary btn-lg pull-right" data-loading-text="Loading...">
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-6">

							<h4 class="push-top">Get in <strong>touch</strong></h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget leo at velit imperdiet varius. In eu ipsum vitae velit congue iaculis vitae at risus.</p>

							<hr />

							<h4>The <strong>Office</strong></h4>
							<ul class="list-unstyled">
								<li><i class="fa fa-map-marker"></i> <strong>Address:</strong> 1234 Street Name, City Name, United States</li>
								<li><i class="fa fa-phone"></i> <strong>Phone:</strong> (123) 456-7890</li>
								<li><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:mail@example.com">mail@example.com</a></li>
							</ul>

							<hr />

							<h4>Business <strong>Hours</strong></h4>
							<ul class="list-unstyled">
								<li><i class="fa fa-time"></i> Monday - Friday 9am to 5pm</li>
								<li><i class="fa fa-time"></i> Saturday - 9am to 2pm</li>
								<li><i class="fa fa-time"></i> Sunday - Closed</li>
							</ul>

						</div>
					</div>

				</div>

			</div>

			<footer id="footer">
				<div class="container">
					<div class="row">
						<div class="col-md-3">
							<a href="index.html" class="logo push-bottom">
								<img alt="Tucson - Responsive HTML5 Template" src="img/logo-footer.png">
							</a>
							<p>Tucson is a very powerful HTML5 template, you will be able to create an awesome website in a very simple way. <a href="#" class="btn-flat btn-xs">View More <i class="fa fa-arrow-right"></i></a></p>
							<div class="contact-details">
								<ul class="contact">
									<li><p><i class="fa fa-map-marker"></i> <strong>Address:</strong> 123 Street Name, City, USA</p></li>
									<li><p><i class="fa fa-phone"></i> <strong>Phone:</strong> (123) 456-7890</p></li>
									<li><p><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:mail@example.com">mail@example.com</a></p></li>
								</ul>
							</div>
						</div>
						<div class="col-md-3">
							<h4>Latest Posts</h4>
							<ul class="nav nav-list primary push-bottom">
								<li><a title="Class aptent taciti sociosqu ad litora torquent" href="blog-post.html">Class aptent taciti sociosqu ad...</a></li>
								<li><a title="Class aptent taciti sociosqu ad litora torquent" href="blog-post.html">Aptent class taciti sociosqu...</a></li>
								<li><a title="Class aptent taciti sociosqu ad litora torquent" href="blog-post.html">Taciti aptent class sociosqu ad...</a></li>
								<li><a title="Class aptent taciti sociosqu ad litora torquent" href="blog-post.html">Sociosqu class aptent taciti...</a></li>
							</ul>
						</div>
						<div class="col-md-3">
							<h4>Latest Tweets</h4>
							<div id="tweet" class="twitter" data-plugin-tweets data-plugin-options='{"username": "", "count": 2}'>
								<p>Please wait...</p>
							</div>
						</div>
						<div class="col-md-3">
							<h4>Latest Works</h4>
			
							<ul class="list-unstyled recent-work">
								<li>
									<a class="thumb-info" href="portfolio-single.html">
										<img class="img-responsive" src="img/projects/project-1.jpg" alt="">
									</a>
								</li>
								<li>
									<a class="thumb-info" href="portfolio-single.html">
										<img class="img-responsive" src="img/projects/project-2.jpg" alt="">
									</a>
								</li>
								<li>
									<a class="thumb-info" href="portfolio-single.html">
										<img class="img-responsive" src="img/projects/project-3.jpg" alt="">
									</a>
								</li>
								<li>
									<a class="thumb-info" href="portfolio-single.html">
										<img class="img-responsive" src="img/projects/project-4.jpg" alt="">
									</a>
								</li>
								<li>
									<a class="thumb-info" href="portfolio-single.html">
										<img class="img-responsive" src="img/projects/project-5.jpg" alt="">
									</a>
								</li>
								<li>
									<a class="thumb-info" href="portfolio-single.html">
										<img class="img-responsive" src="img/projects/project-6.jpg" alt="">
									</a>
								</li>
							</ul>
			
							<a href="#" class="btn-flat pull-right btn-xs view-more-recent-work">View More <i class="fa fa-arrow-right"></i></a>
			
						</div>
					</div>
				</div>
				<div class="footer-copyright">
					<div class="container">
						<div class="row">
							<div class="col-md-6">
								<p>Copyright © 2014. All Rights Reserved.</p>
							</div>
							<div class="col-md-6">
								<ul class="social-icons">
									<li><a href="http://www.twitter.com/" target="_blank" rel="tooltip" title="Twitter"><i class="fa fa-twitter"></i></a></li>
									<li><a href="http://www.facebook.com/" target="_blank" rel="tooltip" title="Facebook"><i class="fa fa-facebook"></i></a></li>
									<li><a href="http://www.google.com/" target="_blank" rel="tooltip" title="Google+"><i class="fa fa-google-plus"></i></a></li>
									<li><a href="http://www.linkedin.com/" target="_blank" rel="tooltip" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>

		<!-- Vendor -->
		<script src="vendor/jquery/jquery.js"></script>
		<script src="vendor/jquery.appear/jquery.appear.js"></script>
		<script src="vendor/jquery.easing/jquery.easing.js"></script>
		<script src="vendor/jquery-cookie/jquery-cookie.js"></script>
		<script src="vendor/bootstrap/bootstrap.js"></script>
		<script src="vendor/common/common.js"></script>
		<script src="vendor/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
		<script src="vendor/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
		<script src="vendor/jquery.validation/jquery.validation.js"></script>
		<script src="vendor/jquery.stellar/jquery.stellar.js"></script>
		<script src="vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js"></script>
		<script src="vendor/jquery.gmap/jquery.gmap.js"></script>
		<script src="vendor/twitterjs/twitter.js"></script>
		<script src="vendor/isotope/jquery.isotope.js"></script>
		<script src="vendor/owlcarousel/owl.carousel.js"></script>
		<script src="vendor/jflickrfeed/jflickrfeed.js"></script>
		<script src="vendor/magnific-popup/jquery.magnific-popup.js"></script>
		<script src="vendor/vide/vide.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="js/theme.js"></script>

		<!-- Specific Page Vendor and Views -->
		<script src="js/views/view.contact.js"></script>
		
		<!-- Theme Custom -->
		<script src="js/custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="js/theme.init.js"></script>

		<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script>

			/*
			Map Settings

				Find the Latitude and Longitude of your address:
					- http://universimmedia.pagesperso-orange.fr/geo/loc.htm
					- http://www.findlatitudeandlongitude.com/find-address-from-latitude-and-longitude/

			*/

			// Map Markers
			var mapMarkers = [{
				address: "217 Summit Boulevard, Birmingham, AL 35243",
				html: "<strong>Alabama Office</strong><br>217 Summit Boulevard, Birmingham, AL 35243<br><br><a href='#' onclick='mapCenterAt({latitude: 33.44792, longitude: -86.72963, zoom: 16}, event)'>[+] zoom here</a>",
				icon: {
					image: "img/pin.png",
					iconsize: [26, 46],
					iconanchor: [12, 46]
				}
			},{
				address: "645 E. Shaw Avenue, Fresno, CA 93710",
				html: "<strong>California Office</strong><br>645 E. Shaw Avenue, Fresno, CA 93710<br><br><a href='#' onclick='mapCenterAt({latitude: 36.80948, longitude: -119.77598, zoom: 16}, event)'>[+] zoom here</a>",
				icon: {
					image: "img/pin.png",
					iconsize: [26, 46],
					iconanchor: [12, 46]
				}
			},{
				address: "New York, NY 10017",
				html: "<strong>New York Office</strong><br>New York, NY 10017<br><br><a href='#' onclick='mapCenterAt({latitude: 40.75198, longitude: -73.96978, zoom: 16}, event)'>[+] zoom here</a>",
				icon: {
					image: "img/pin.png",
					iconsize: [26, 46],
					iconanchor: [12, 46]
				}
			}];

			// Map Initial Location
			var initLatitude = 37.09024;
			var initLongitude = -95.71289;

			// Map Extended Settings
			var mapSettings = {
				controls: {
					draggable: true,
					panControl: true,
					zoomControl: true,
					mapTypeControl: true,
					scaleControl: true,
					streetViewControl: true,
					overviewMapControl: true
				},
				scrollwheel: false,
				markers: mapMarkers,
				latitude: initLatitude,
				longitude: initLongitude,
				zoom: 5
			};

			var map = $("#googlemaps").gMap(mapSettings);

			// Map Center At
			var mapCenterAt = function(options, e) {
				e.preventDefault();
				$("#googlemaps").gMap("centerAt", options);
			}

		</script>

		<!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information.
		<script type="text/javascript">
		
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-12345678-1']);
			_gaq.push(['_trackPageview']);
		
			(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		
		</script>
		 -->

	</body>
</html>
