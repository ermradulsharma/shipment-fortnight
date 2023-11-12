<!DOCTYPE html>
<html lang="zxx">
	<head>
		<!-- Meta Tag -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name='copyright' content='pavilan'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Title Tag  -->
		<title>Mera shiping | welcome to merashping </title>

		<!-- Favicon -->
		<link rel="icon" type="image/favicon.png" href="{{asset('frontend_live')}}/img/favicon.png">

		<!-- Web Font -->
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

		<!-- Bizwheel Plugins CSS -->
		<link rel="stylesheet" href="{{asset('frontend_live')}}/css/animate.min.css">
		<link rel="stylesheet" href="{{asset('frontend_live')}}/css/bootstrap.min.css">
		<link rel="stylesheet" href="{{asset('frontend_live')}}/css/cubeportfolio.min.css">
		<link rel="stylesheet" href="{{asset('frontend_live')}}/css/font-awesome.css">
		<link rel="stylesheet" href="{{asset('frontend_live')}}/css/jquery.fancybox.min.css">
		<link rel="stylesheet" href="{{asset('frontend_live')}}/css/magnific-popup.min.css">
		<link rel="stylesheet" href="{{asset('frontend_live')}}/css/owl-carousel.min.css">
		<link rel="stylesheet" href="{{asset('frontend_live')}}/css/slicknav.min.css">

		<!-- Bizwheel Stylesheet -->
		<link rel="stylesheet" href="{{asset('frontend_live')}}/css/reset.css">
		<link rel="stylesheet" href="{{asset('frontend_live')}}/style.css">
		<link rel="stylesheet" href="{{asset('frontend_live')}}/css/responsive.css">
		<!-- Bizwheel Colors -->

	</head>
	<body id="bg">

		<!-- Boxed Layout -->
		<div id="page" class="site boxed-layout">

		<!-- Header -->
		<header class="header">
			<!-- Topbar -->
			<div class="topbar d-none d-lg-block d-md-block">
				<div class="container">
					<div class="row">
						<div class="col-lg-8 col-12">
							<!-- Top Contact -->
							<div class="top-contact">
								<!-- <div class="single-contact"><i class="fa fa-phone"></i>Phone: +9870793502</div>  -->
								<div class="single-contact"><i class="fa fa-envelope-open"></i>Email: customermerashiping@gmail.com</div>
								<div class="single-contact"><i class="fa fa-clock-o"></i>Opening: All time</div>
							</div>
							<!-- End Top Contact -->
						</div>
					</div>
				</div>
			</div>
			<!--/ End Topbar -->
			<!-- Middle Header -->
			<div class="middle-header">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<div class="middle-inner">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-12">
										<!-- Logo -->
										<div class="logo">
											<!-- Image Logo -->
											<div class="img-logo">
												<a href="{{url('/')}}">
													<img src="{{asset('frontend_live')}}/img/logo.png" alt="#">
												</a>
											</div>
										</div>
										<div class="mobile-nav"></div>
									</div>
									<div class="col-lg-10 col-md-9 col-12">
										<div class="menu-area">
											<!-- Main Menu -->
											<nav class="navbar navbar-expand-lg">
												<div class="navbar-collapse">
													<div class="nav-inner">
														<div class="menu-home-menu-container">
															<!-- Naviagiton -->
															<ul id="nav" class="nav main-menu menu navbar-nav">
																<li class="{{ request()->is('login') ? 'active' : '' }}"><a href="{{route('login')}}">Login</a></li>
																<li class="{{ request()->is('register') ? 'active' : '' }}"><a href="{{route('register')}}">Register</a></li>
															</ul>
															<!--/ End Naviagiton -->
														</div>
													</div>
												</div>
											</nav>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
		<!--/ End Header -->

        @yield('content')

        		<!-- Footer -->
		<footer class="footer" style="background-image:url('{{asset('frontend_live')}}/img/map.png')">
			<!-- Copyright -->
			<div class="copyright">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<div class="copyright-content d-lg-flex justify-content-between">
								<p>© Copyright Reserved to <a href="#">Mera shiping</a> <a class="d-none" target="_blank" href="http://zaibainfotech.com/">zaibainfotech.com</a></p>
                                <ul class="text-white d-lg-flex">
                                    <li class="px-1 {{ request()->is('term-conditions') ? 'active' : '' }}"><a href="{{route('term-conditions')}}">Terms & Conditions</a></li>
                                    <li class="px-1 {{ request()->is('policy') ? 'active' : '' }}"><a href="{{route('policy')}}">Policy</a></li>
                                    <li class="px-1 {{ request()->is('shipingPolicy') ? 'active' : '' }}"><a href="{{route('shipingPolicy')}}">Shipping policies</a></li>
                                    <li class="px-1 {{ request()->is('refundPolicy') ? 'active' : '' }}"><a href="{{route('refundPolicy')}}">Refund & cancellation policy</a></li>
                                </ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Copyright -->
		</footer>

		<!-- Jquery JS -->
		<script src="{{asset('frontend_live')}}/js/jquery.min.js"></script>
		<script src="{{asset('frontend_live')}}/js/jquery-migrate-3.0.0.js"></script>
		<!-- Popper JS -->
		<script src="{{asset('frontend_live')}}/js/popper.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="{{asset('frontend_live')}}/js/bootstrap.min.js"></script>
		<!-- Modernizr JS -->
		<script src="{{asset('frontend_live')}}/js/modernizr.min.js"></script>
		<!-- ScrollUp JS -->
		<script src="{{asset('frontend_live')}}/js/scrollup.js"></script>
		<!-- FacnyBox JS -->
		<script src="{{asset('frontend_live')}}/js/jquery-fancybox.min.js"></script>
		<!-- Cube Portfolio JS -->
		<script src="{{asset('frontend_live')}}/js/cubeportfolio.min.js"></script>
		<!-- Slick Nav JS -->
		<script src="{{asset('frontend_live')}}/js/slicknav.min.js"></script>
		<!-- Slick Nav JS -->
		<script src="{{asset('frontend_live')}}/js/slicknav.min.js"></script>
		<!-- Slick Slider JS -->
		<script src="{{asset('frontend_live')}}/js/owl-carousel.min.js"></script>
		<!-- Easing JS -->
		<script src="{{asset('frontend_live')}}/js/easing.js"></script>
		<!-- Magnipic Popup JS -->
		<script src="{{asset('frontend_live')}}/js/magnific-popup.min.js"></script>
		<!-- Active JS -->
		<script src="{{asset('frontend_live')}}/js/active.js"></script>
	</body>
</html>
