<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="description" content="">
  <meta name="author" content="">

  <title></title>

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="" />

  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="{{asset('frontend')}}/plugins/bootstrap/css/bootstrap.min.css">
  <!-- Icon Font Css -->
  <link rel="stylesheet" href="{{asset('frontend')}}/plugins/themify/css/themify-icons.css">
  <link rel="stylesheet" href="{{asset('frontend')}}/plugins/fontawesome/css/all.css">
  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="{{asset('frontend')}}/css/style.css">

</head>

<body>



	<nav class="navbar navbar-expand-lg py-4 navigation header-padding bg-dark" id="navbar">
		<div class="container d-flex">
		  <a class="navbar-brand text-white" href="{{url('/')}}"> Mera Shiping </a>
		  <div class="d-flex">
		      @guest
    		      <a href="{{route('login')}}" class="btn btn-solid-border border-white text-white">Login <i class="fa fa-angle-right mr-2"></i></a>
    		      <a href="{{route('register')}}" class="btn btn-solid-border border-white text-white">Register <i class="fa fa-angle-right ml-2"></i></a>
		      @else
		          <a href="{{url('profile')}}/{{ Auth::user()->id }}" class="btn btn-solid-border border-white text-white"> <i class="fa fa-user mr-2"></i> {{ Auth::user()->name }}</a>
		      @endguest
		  </div>
		</div>
	</nav>


<!-- Slider Start -->
<section class="banner d-flex align-items-center pt-5">
	<div class="banner-img-part"></div>
	<div class="container">
		<div class="row">
			<div class="col-lg-10 col-md-12 col-xl-8">
				<div class="block">
					<span class="text-uppercase text-sm letter-spacing ">The most powerful Solution</span>
					<h4 class="mb-3 mt-3">Welcome to Merashiping</h4>
					<p class="mb-5">Mera Shiping is committed to safeguarding the confidentiality, integrity and availability of all physical and electronic information assets of the organization. We ensure that the regulatory, operational and contractual requirements are fulfilled.
				    <br/>Empower your business with same-day delivery as your competitive advantage.</p>
				    <h4 class="text-white">Special offers</h4>
				    <ul class="text-white">
				        <li>RTO charges free.</li>
				        <li>COD remittance same day.</li>
				        <li>Offer money back rs.1000 send 50 orders par day.</li>
				        <li>Same day pickup and fast delivery.</li>
				    </ul>
				    <h4>Create Shipment Details</h4>
                    <p>Create a shipment delivery by entering the shipping address, package details, and any notes you may have for the delivery driver.</p>
			    </div>
			</div>
		</div>
	</div>
</section>
<hr/>
<section class="section about">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-6 ">
				<div class="about-item mb-5 mb-lg-5">
					<div class="icon">
						<i class="ti-light-bulb"></i>
					</div>

					<div class="content">
						<h4 class="mt-3 mb-3">Safety & Support</h4>
						<p class="mb-4">We don’t leave our drivers hung out to dry. Our best-in-class support team helps you stay safe and protected both on and off the road.</p>
					</div>
				</div>
			</div>

			<div class="col-lg-4 col-md-6">
				<div class="about-item mb-5 mb-lg-5">
					<div class="icon">
						<i class="ti-panel"></i>
					</div>
					<div class="content">
						<h4 class="mt-3 mb-3">Courier Service</h4>
						<p class="mb-4">Scale your business, expedite your deliveries, and delight your customers wherever they are with the fastest delivery times at the most affordable prices.</p>
					</div>
				</div>
			</div>
			
			<div class="col-lg-4 col-md-6">
				<div class="about-item">
					<div class="icon">
						<i class="ti-headphone-alt"></i>
					</div>
					<div class="content">
						<h4 class="mt-3 mb-3">Transparent Pricing</h4>
						<p class="mb-4">Providing same-day delivery convenience to your customers shouldn’t break the bank. What payment methods are accepted? Can we pay with cash on arrival?</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<hr/>
<!-- section Counter End  -->
<section class="">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="heading">
					<h2 class="mb-4">What they say about us</h2>
					<p>Mera Shiping aim is to build the operating system for commerce. We provide express parcel transportation, PTL and TL freight, cross-border and supply chain services to over 21000 customers, including large & small e-commerce participants, SMEs, and other leading enterprises & brands. Our supply chain platform and logistics operations bring flexibility, breadth, efficiency and innovation to our customers’ supply chain and logistics. Our operations, infrastructure and technology enable our customers to transact with us and our partners at low costs.</p>
				</div>
			</div>
			<div class="col-lg-4">
			    <img src="{{asset('frontend/images/2.jpg')}}"/>
		    </div>
		</div>
	</div>
</section>
<hr/>
<section class="contact-form-wrap section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <span class="text-color">Send a message</span>
                <h3 class="text-md mb-5">Contact Form</h3>

                <div class="row">
                    <div class="col-lg-6">
                        <form  class="contact__form " method="post" action="{{route('query')}}">
                            @csrf
                         <!-- form message -->
                            <div class="form-group">
                                <input name="name" id="name" type="text" class="form-control" placeholder="Your Name">
                            </div>

                            <div class="form-group">
                                <input name="phone" id="phone" type="number" class="form-control" placeholder="Mobile No">
                            </div>
                            
                            <div class="form-group">
                                <input name="email" id="email" type="email" class="form-control" placeholder="Email Address">
                            </div>

                            <div class="form-group">
                                <input name="subject" id="subject" type="text" class="form-control" placeholder="Your Subject">
                            </div>

                            <div class="form-group-2 mb-4">
                                <textarea name="message" id="message" class="form-control" rows="4" placeholder="Your Message"></textarea>
                            </div>
                            <button class="btn btn-main" name="submit" type="submit">Send Message</button>
                        </form>
                    </div>

                    <div class="col-lg-4">
                        <div class="short-info mt-5 mt-lg-0">
                             <ul class="list-unstyled">
                                 <li>
                                    <h5>Call Us</h5>
                                    +91-9870793502
                                </li>
                                <li>
                                    <h5>Email Us</h5>
                                    customermerashiping@gmail.com
                                </li>
                                <li>
                                    <h5>Location Map</h5>
                                    Office. H.no 207 Dixit Hospital Sector 3 Awas Vikas Colony Bodla Agra 282007
                                </li>
                            </ul>

                            {{--<ul class="social-icons list-inline mt-5">
                                <li class="list-inline-item">
                                    <a href="http://www.themefisher.com/"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="http://www.themefisher.com/"><i class="fab fa-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="http://www.themefisher.com/"><i class="fab fa-linkedin-in"></i></a>
                                </li>
                            </ul> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div>
    <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d28390.42505466475!2d77.95545486929235!3d27.193923662036255!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1s207%20Dixit%20Hospital%20Sector%203%20Awas%20Vikas%20Colony%20Bodla%20Agra%20282007!5e0!3m2!1sen!2sin!4v1647362919994!5m2!1sen!2sin" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</div>
<!-- footer Start -->
<footer class="footer">
	<div class="container">
		<div class="footer-btm py-4">
			<div class="row">
				<div class="col-lg-12">
					<div class="copyright">
						&copy; Copyright Reserved to <span class="text-color">Mera shiping <!-- <a href="www.zaibainfotech.com">Zaiba Infotech</a> --></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
   

    <!-- 
    Essential Scripts
    =====================================-->

    
    <!-- Main jQuery -->
    <script src="{{asset('frontend')}}/plugins/jquery/jquery.js"></script>
    <!-- Bootstrap 4.3.2 -->
    <script src="{{asset('frontend')}}/plugins/bootstrap/js/popper.js"></script>
    <script src="{{asset('frontend')}}/plugins/bootstrap/js/bootstrap.min.js"></script>
    
    <script src="{{asset('frontend')}}/js/script.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" id="theme-styles">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>

    @if(Session::has('status'))
    <script>
        $(function () {
            Swal.fire(
            'Success Message',
            '{{Session::get('status')}}',
            'success');
        });
    </script>
    @endif
    @if(Session::has('error'))
    <script>
        $(function () {
            Swal.fire(
            'Error Message',
            '{{Session::get('error')}}',
            'error');
        });
    </script>
    @endif
  </body>
  
</html>
   