<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Greenplatform {{ $page->title }}</title>
  <meta name="description" content="{{ $page->about }}. This is a Greenplatorm sustainability environmental eco-friendly Certificate.">
  <meta name="keywords" content="{{ $page->categories }}">
	<link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/favicon.png">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" href="/css/separate/vendor/slick.min.css">
	<link rel="stylesheet" href="/css/separate/pages/profile.min.css">
    <link rel="stylesheet" href="/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">

    <link rel="stylesheet" type="text/css" href="/js/lib/jssocials/jssocials.css" />
    <link rel="stylesheet" type="text/css" href="/js/lib/jssocials/jssocials-theme-flat.css" />

	<link rel="stylesheet" href="/js/lib/venobox/venobox.css" type="text/css" media="screen" />

  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
	<header class="site-header">
	  <div class="container-fluid">
      <a href="/" class="site-logo">
          <img class="hidden-md-down" src="/img/logo.png" alt="">
          <img class="hidden-lg-up" src="/img/leaf-120.png" alt="">
      </a>
      <div class="site-header-content">
        <div class="site-header-content-in">


          <a href="/pages/">
            <button type="button" class="btn btn-rounded">Marketplace</button>
          </a>
          @if(Auth::check())
          <a href="/logout">
            <button type="button" class="btn btn-rounded">Logout</button>
          </a>
          <a href="/user/{{ Auth::user()->id }}">
            <button type="button" class="btn btn-rounded">Profile Page</button>
          </a>
          @else
          <a href="/login">
            <button type="button" class="btn btn-rounded">Login</button>
          </a>
           or
          <a href="/">
            <button type="button" class="btn btn-rounded">Register</button>
          </a>
          @endif
          <div class="site-header-shown">
				   	<div class="dropdown">
              <button class="btn btn-rounded dropdown-toggle" id="dd-header-add" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Download App
              </button>
              <div class="dropdown-menu" aria-labelledby="dd-header-add">
                <a class="dropdown-item" href="https://itunes.apple.com/app/greenplatform/id1170382180" target="_blank">iOS</a>
                <a class="dropdown-item" href="https://play.google.com/store/apps/details?id=org.greenplatform.gpandroid" target="_blank">Android</a>
              </div>
            </div>
          </div><!--.site-header-shown-->
          <div class="mobile-menu-right-overlay"></div>
          <div class="site-header-collapsed">
            <div class="site-header-collapsed-in">
            </div><!--.site-header-collapsed-in-->
          </div><!--.site-header-collapsed-->
        </div><!--site-header-content-in-->
	    </div><!--.site-header-content-->
	  </div><!--.container-fluid-->
	</header><!--.site-header-->

	<div class="page-content">

		@yield('content')

	</div><!--.page-content-->

	@if(Route::getCurrentRoute()->uri() == '/')

		<div class="page-footer">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 footer-contact">
						<img src="/img/leaf-120.png" style="width:25px"> <b>GreenPlatform</b><br>
						<b>Phone:</b>+31(0)20 7725885<br>
						<b>Email:</b> <a href="mailto:info@greenplatform.org">info@greenplatform.org</a>
					</div>
				</div>
			</div>
		</div>

	@endif

	<script src="/js/lib/jquery/jquery.min.js"></script>
	<script src="/js/lib/tether/tether.min.js"></script>
	<script src="/js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="/js/plugins.js"></script>
	<script src="/js/lib/slick-carousel/slick.min.js"></script>
	<script src="/js/lib/jssocials/jssocials.min.js"></script>
	<script type="text/javascript" src="/js/lib/venobox/venobox.min.js"></script>
	<script>
		$(function () {

			var postsSlider = $(".posts-slider");

			postsSlider.slick({
				slidesToShow: 4,
				adaptiveHeight: true,
				arrows: false,
				responsive: [
					{
						breakpoint: 1700,
						settings: {
							slidesToShow: 3
						}
					},
					{
						breakpoint: 1350,
						settings: {
							slidesToShow: 2
						}
					},
					{
						breakpoint: 992,
						settings: {
							slidesToShow: 3
						}
					},
					{
						breakpoint: 768,
						settings: {
							slidesToShow: 2
						}
					},
					{
						breakpoint: 500,
						settings: {
							slidesToShow: 1
						}
					}
				]
			});

			$('.posts-slider-prev').click(function(){
				postsSlider.slick('slickPrev');
			});

			$('.posts-slider-next').click(function(){
				postsSlider.slick('slickNext');
			});


		});
	</script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDrTzy4Ni-jP0qghaTe1wWdEuL01-j9I4s&callback=initMap">
   </script>
  <script src="/js/app.js"></script>
  <script src="/js/share.js"></script>

  </body>
</html>
