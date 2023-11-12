@extends('layouts.frontend')
@section('content')
		<!-- Hero Slider -->
		<section class="hero-slider style1">
			<div class="home-slider">
				<!-- Single Slider -->
				<div class="single-slider" style="background-image:url('{{asset('frontend_live/img/slider1.jpg')}}')">
					<div class="container">
						<div class="row">
							<div class="col-lg-7 col-md-8 col-12">
								<div class="welcome-text"> 
									<div class="hero-text"> 
										<h4>We are always ready to help you</h4>
										<h1 class="text-warning">Create Shipment Details</h1>
										<div class="p-text">
											<p class="text-warning">Create a shipment delivery by entering the shipping address, package details, and any notes you may have for the delivery driver.</p>
										</div>
										<div class="button">
											<a href="{{route('login')}}" class="bizwheel-btn theme-1 effect">Login</a>
											<a href="{{route('register')}}" class="bizwheel-btn theme-2 effect">Register Now</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--/ End Single Slider -->
				<!-- Single Slider -->
				<div class="single-slider" style="background-image:url('{{asset('frontend_live/img/slider.jpg')}}')">
					<div class="container">
						<div class="row">
							<div class="col-lg-7 col-md-8 col-12">
								<div class="welcome-text"> 
									<div class="hero-text"> 
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--/ End Single Slider -->
				<!-- Single Slider -->
				<div class="single-slider" style="background-image:url('{{asset('frontend_live/img/slider3.jpg')}}')">
					<div class="container">
						<div class="row">
							<div class="col-lg-7 col-md-8 col-12">
								<div class="welcome-text"> 
									<div class="hero-text"> 
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--/ End Single Slider -->
			</div>
		</section>
		<!--/ End Hero Slider -->
		
		<!-- Call To Action -->
		<section class="call-action overlay">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 col-12">
						<div class="call-inner text-justify">
							<h2>Welcome to Merashiping</h2>
							<h3>About Us : <h3>
								<hr/>
							<p>Mera Shiping aim is to build the operating system for commerce. We provide express parcel transportation, PTL and TL freight, cross-border and supply chain services to over 21000 customers, including large & small e-commerce participants, SMEs, and other leading enterprises & brands. Our supply chain platform and logistics operations bring flexibility, breadth, efficiency and innovation to our customers’ supply chain and logistics. Our operations, infrastructure and technology enable our customers to transact with us and our partners at low costs.</p>
							<p>Mera Shiping is committed to safeguarding the confidentiality, integrity and availability of all physical and electronic information assets of the organization. We ensure that the regulatory, operational and contractual requirements are fulfilled.</p>
							<p>Empower your business with same-day delivery as your competitive advantage.</p>
						    <br>
						    <h4 class="text-white">Special offers</h4>
        				    <ul class="text-white ml-3 mt-3">
        				        <li>RTO charges free.</li>
        				        <li>COD remittance same day.</li>
        				        <li>Offer money back rs.1000 send 50 orders par day.</li>
        				        <li>Same day pickup and fast delivery.</li>
        				    </ul>
						</div>
					</div>
					<div class="col-lg-4 col-12">
						<div class="button">
							<img class="img-fluid" src="{{asset('frontend_live')}}/img/2.jpg"><br><br>
							<a href="{{route('register')}}" class="bizwheel-btn">Register now</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--/ End Call to action -->

		
		<!-- Features Area -->
		<section class="features-area section-bg">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-6 col-12">
						<!-- Single Feature -->
						<div class="single-feature">
							<div class="icon-head"><i class="fa fa-podcast"></i></div>
							<h4>Transparent Pricing</h4>
							<p>Providing same-day delivery convenience to your customers shouldn’t break the bank. What payment methods are accepted? Can we pay with cash on arrival?</p>
						</div>
						<!--/ End Single Feature -->
					</div>
					<div class="col-lg-4 col-md-6 col-12">
						<!-- Single Feature -->
						<div class="single-feature">
							<div class="icon-head"><i class="fa fa-podcast"></i></div>
							<h4><a href="#">Safety & Support</a></h4>
							<p>We don’t leave our drivers hung out to dry. Our best-in-class support team helps you stay safe and protected both on and off the road.</p>
							<br>
						</div>
						<!--/ End Single Feature -->
					</div>
					<div class="col-lg-4 col-md-6 col-12">
						<!-- Single Feature -->
						<div class="single-feature active">
							<div class="icon-head"><i class="fa fa-podcast"></i></div>
							<h4><a href="#">Courier Service</a></h4>
							<p>Scale your business, expedite your deliveries, and delight your customers wherever they are with the fastest delivery times at the most affordable prices.</p>
						</div>
						<!--/ End Single Feature -->
					</div>
				</div>
			</div>
		</section>
		<!--/ End Features Area -->
		
		<section class="contact-form-wrap section">
            <div class="container p-5">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <span class="text-color">Send a message</span>
                        <h3 class="text-md mb-5">Contact Form</h3>
        
                        <div class="row">
                            <div class="col-lg-8">
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
                                    <button class="btn btn-main btn-warning" name="submit" type="submit">Send Message</button>
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
                                            H.no 207 Dixit Hospital Sector 3 Awas Vikas Colony Bodla Agra 282007
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d28390.42505466475!2d77.95545486929235!3d27.193923662036255!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1s207%20Dixit%20Hospital%20Sector%203%20Awas%20Vikas%20Colony%20Bodla%20Agra%20282007!5e0!3m2!1sen!2sin!4v1647362919994!5m2!1sen!2sin" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
@endsection