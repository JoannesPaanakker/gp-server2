<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Greenplatform</title>
  <meta name="keywords" content="">
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
  <!-- SideNav slide-out button -->
<a href="#" data-activates="slide-out" class="btn btn-primary p-3 button-collapse"><i class="fa fa-bars"></i></a>

<!-- Sidebar navigation -->
<div id="slide-out" class="side-nav fixed">
  <ul class="custom-scrollbar">
      <!-- Logo -->
      <li>
          <div class="logo-wrapper waves-light">
              <a href="#"><img src="https://mdbootstrap.com/img/logo/mdb-transparent.png" class="img-fluid flex-center"></a>
          </div>
      </li>
      <!--/. Logo -->
      <!--Social-->
      <li>
          <ul class="social">
              <li><a href="#" class="icons-sm fb-ic"><i class="fa fa-facebook"> </i></a></li>
              <li><a href="#" class="icons-sm pin-ic"><i class="fa fa-pinterest"> </i></a></li>
              <li><a href="#" class="icons-sm gplus-ic"><i class="fa fa-google-plus"> </i></a></li>
              <li><a href="#" class="icons-sm tw-ic"><i class="fa fa-twitter"> </i></a></li>
          </ul>
      </li>
      <!--/Social-->
      <!--Search Form-->
      <li>
          <form class="search-form" role="search">
              <div class="form-group md-form mt-0 pt-1 waves-light">
                  <input type="text" class="form-control" placeholder="Search">
              </div>
          </form>
      </li>
      <!--/.Search Form-->
      <!-- Side navigation links -->
      <li>
          <ul class="collapsible collapsible-accordion">
              <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-chevron-right"></i> Submit blog<i class="fa fa-angle-down rotate-icon"></i></a>
                  <div class="collapsible-body">
                      <ul>
                          <li><a href="#" class="waves-effect">Submit listing</a>
                          </li>
                          <li><a href="#" class="waves-effect">Registration form</a>
                          </li>
                      </ul>
                  </div>
              </li>
              <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-hand-pointer-o"></i> Instruction<i class="fa fa-angle-down rotate-icon"></i></a>
                  <div class="collapsible-body">
                      <ul>
                          <li><a href="#" class="waves-effect">For bloggers</a>
                          </li>
                          <li><a href="#" class="waves-effect">For authors</a>
                          </li>
                      </ul>
                  </div>
              </li>
              <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-eye"></i> About<i class="fa fa-angle-down rotate-icon"></i></a>
                  <div class="collapsible-body">
                      <ul>
                          <li><a href="#" class="waves-effect">Introduction</a>
                          </li>
                          <li><a href="#" class="waves-effect">Monthly meetings</a>
                          </li>
                      </ul>
                  </div>
              </li>
              <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-envelope-o"></i> Contact me<i class="fa fa-angle-down rotate-icon"></i></a>
                  <div class="collapsible-body">
                      <ul>
                          <li><a href="#" class="waves-effect">FAQ</a>
                          </li>
                          <li><a href="#" class="waves-effect">Write a message</a>
                          </li>
                          <li><a href="#" class="waves-effect">FAQ</a>
                          </li>
                          <li><a href="#" class="waves-effect">Write a message</a>
                          </li>
                          <li><a href="#" class="waves-effect">FAQ</a>
                          </li>
                          <li><a href="#" class="waves-effect">Write a message</a>
                          </li>
                          <li><a href="#" class="waves-effect">FAQ</a>
                          </li>
                          <li><a href="#" class="waves-effect">Write a message</a>
                          </li>
                      </ul>
                  </div>
              </li>
          </ul>
      </li>
      <!--/. Side navigation links -->
  </ul>
  <div class="sidenav-bg rgba-blue-strong"></div>
</div>
<!--/. Sidebar navigation -->



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
  </body>
</html>
