<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>GreenPlatform</title>
  <meta name="description" content="Greenplatform is the new must have app to save the planet. Check, review and reward your favorite bar, supermarket, NGO or school to make a statement. Be in control. Team up now and join your friends, expand your network and show what you are doing to make the world a better place.">
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
          @if(Auth::check())
      <a href="/user/{{ Auth::user()->id }}" class="site-logo">
          <img class="hidden-md-down" src="/img/logo.png" alt="">
          <img class="hidden-lg-up" src="/img/leaf-120.png" alt="">
      </a>
          @else
      <a href="/" class="site-logo">
          <img class="hidden-md-down" src="/img/logo.png" alt="">
          <img class="hidden-lg-up" src="/img/leaf-120.png" alt="">
      </a>
          @endif


      <div class="site-header-content">
        <div class="site-header-content-in">
          @if(Auth::check())
            <a href="/logout" class="hidden-sm-down">
              <button type="button" class="btn">Logout</button>
            </a>
            <a href="/user/{{ Auth::user()->id }}" class="hidden-sm-down">
              <button type="button" class="btn">Profile Page</button>
            </a>
            <a href="/users" class="hidden-sm-down">
              <button type="button" class="btn">People</button>
            </a>
          @else
            <a href="/login" class="hidden-sm-down">
              <button type="button" class="btn">eMail Login</button>
            </a>
            <a href="/fbredirect" class="hidden-sm-down">
              <button type="button" class="btn"><i class="fa fa-facebook"></i>
                Facebook Login
              </button>
            </a>
          @endif
          <div class="site-header-shown">
				   	<div class="dropdown">
              <button class="btn dropdown-toggle" id="dd-header-add" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Download App
              </button>
              <div class="dropdown-menu" aria-labelledby="dd-header-add">
                <a class="dropdown-item" href="https://itunes.apple.com/app/greenplatform/id1170382180" target="_blank">iOS</a>
                <a class="dropdown-item" href="https://play.google.com/store/apps/details?id=org.greenplatform.gpandroid" target="_blank">Android</a>
                <a class="dropdown-item" href='/pages'>Top Members</a>





          @if(Auth::check())
            <a href="/logout" class="dropdown-item hidden-md-up">
              Logout
            </a>
            <a href="/user/{{ Auth::user()->id }}" class="dropdown-item hidden-md-up">
              Profile Page
            </a>
            <a href="/users" class="dropdown-item hidden-md-up">
              People
            </a>
          @else
            <a href="/login" class="dropdown-item hidden-md-up">
              eMail Login
            </a>
            <a href="/fbredirect" class="dropdown-item hidden-md-up">
              <i class="fa fa-facebook"></i>
                Facebook Login

            </a>
          @endif






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
            <b>Whatsapp:</b>+31 624607856<br>
            <b>Phone:</b>+31 20772 58 85<br>
            <b>Web:</b> <a href="/" class="site-logo">www.greenplatform.org</a><br>
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
<script src="/js/app.js"></script>
</body>
</html>
