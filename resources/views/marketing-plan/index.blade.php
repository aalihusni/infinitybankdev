<!doctype html style="height:100%;">
<!--[if lt IE 7 ]> <html lang="en" class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
<meta name="viewport" content="width = 1050, user-scalable = yes" />
	<script src="{{asset('assets/vendor/jquery/jquery.js')}}"></script>
	<script src="{{asset('assets/vendor/modernizr/modernizr.js')}}"></script>
</head>
<style>
	body {
		background: #f2f2f2;
		background: -moz-linear-gradient(top,  #f2f2f2 0%, #919191 100%);
		background: -webkit-linear-gradient(top,  #f2f2f2 0%,#919191 100%);
		background: linear-gradient(to bottom,  #f2f2f2 0%,#919191 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f2f2f2', endColorstr='#919191',GradientType=0 );

	}
</style>
<body>
<div class="flipbook-viewport">
	<div class="container">
		<div class="flipbook">
			<div style="background-image:url({{asset('assets/pages/1.jpg')}})"></div>
			<div style="background-image:url({{asset('assets/pages/2.jpg')}})"></div>
			<div style="background-image:url({{asset('assets/pages/3.jpg')}})"></div>
			<div style="background-image:url({{asset('assets/pages/4.jpg')}})"></div>
			<div style="background-image:url({{asset('assets/pages/5.jpg')}})"></div>
			<div style="background-image:url({{asset('assets/pages/6.jpg')}})"></div>
			<div style="background-image:url({{asset('assets/pages/7.jpg')}})"></div>
			<div style="background-image:url({{asset('assets/pages/8.jpg')}})"></div>
		</div>
	</div>
</div>


<script type="text/javascript">

function loadApp() {

	// Create the flipbook

	$('.flipbook').turn({
			// Width

			width:922,
			
			// Height

			height:600,

			// Elevation

			elevation: 50,
			
			// Enable gradients

			gradients: true,
			
			// Auto center this flipbook

			autoCenter: true

	});
}

// Load the HTML4 version if there's not CSS transform

yepnope({
	test : Modernizr.csstransforms,
	yep: ["{{asset('assets/plugin/turnjs/turn.js')}}"],
	nope: ["{{asset('assets/plugin/turnjs/turn.html4.min.js')}}"],
	both: ["{{asset('assets/stylesheets/turnjs.css')}}"],
	complete: loadApp
});

</script>

</body>
</html>