<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Laxiom Investments Company</title>
	
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="keywords" content="Laxiom, Web" />
	<script type="application/x-javascript">
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!--// Meta tag Keywords -->
    
	<!-- css files -->
	<link rel="stylesheet" href="css/bootstrap.css"> <!-- Bootstrap-Core-CSS -->
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" /> <!-- Style-CSS --> 
	<link rel="stylesheet" href="css/fontawesome-all.css"> <!-- Font-Awesome-Icons-CSS -->
	<!-- //css files -->
	
	<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="all" /><!-- for testimonials -->

	<!--web font-->
	<link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
	<!--//web font-->

</head>

<body>
<?php include 'lang.php';?>
<!-- header -->
<header>
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-light">
			<a class="navbar-brand" href="index.php">
				<span class="fab fa-sketch"></span>Laxiom
			</a>
			<button class="navbar-toggler ml-md-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
				aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mx-auto text-center">
					<li class="nav-item active  mr-lg-3">
						<a class="nav-link" href="index.php">Home
							<span class="sr-only">(current)</span>
						</a>
					</li>
					<li class="nav-item  mr-lg-3">
						<a class="nav-link" href="about.php">about</a>
					</li>
						
					<li class="nav-item">
						<a class="nav-link" href="contact.php">contact</a>
					</li>
					<?php if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){ 
					echo 
						'<li class="nav-item">
						<a class="nav-link" href="register.php">Register</a>
						</li>
						<li class="nav-item">
						<a class="nav-link" href="login.php">Login</a>
						</li>';
						}
					else
					{
						echo
						'<li class="nav-item">
						<a class="nav-link" href="dashboard.php">Dashboard</a>
						</li>';
					}
					?>
				</ul>
				<div class="buttons">
					<p><i class="fas mr-1 fa-phone"></i> +1 571-350-0598</p>
				</div>
				
			</div>
		</nav>
	</div>
</header>
<!-- //header -->

<!-- banner -->
<section class="banner" id="home">
	<div class="callbacks_container">
		<ul class="rslides" id="slider3">
			<li>
				<div class="slider-info bg1 w3-agile-grid">
					<div class="bs-slider-overlay">
					<div class="banner-text container agile-info">
						<h5 class="tag text-center mb-3 text-uppercase">We are professional </h5>
						<h1 class="movetxt text-center agile-title text-uppercase">Management Services</h1>
						<h2 class="movetxt text-center mb-3 agile-title text-uppercase">Best Solution </h2>							
						
					</div>
					</div>
				</div>
			</li>
			<li>
				<div class="slider-info bg2 w3-agile-grid">
					<div class="bs-slider-overlay">
					<div class="banner-text container agile-info">
						<h5 class="tag text-center mb-3 text-uppercase">We are unique</h5>
						<h4 class="movetxt text-center agile-title text-uppercase">Capital Management </h4>
						<h4 class="movetxt text-center mb-3 agile-title text-uppercase">Better Service </h4>	
						
					</div>
					</div>
				</div>
			</li>
			<li>
				<div class="slider-info bg3 w3-agile-grid">
					<div class="bs-slider-overlay">
					<div class="banner-text container agile-info">
						<h5 class="tag text-center mb-3 text-uppercase">We are expert</h5>
						<h4 class="movetxt text-center agile-title text-uppercase">Investment Solutions </h4>
						<h4 class="movetxt text-center mb-3 agile-title text-uppercase">Providers </h4>	
						
					</div>
					</div>
				</div>
			</li>
			
		</ul>
	</div>
</section>
<!-- //banner -->

<!-- about -->
<!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
  {
  "symbols": [
    {
      "title": "S&P 500",
      "proName": "OANDA:SPX500USD"
    },
    {
      "title": "Nasdaq 100",
      "proName": "OANDA:NAS100USD"
    },
    {
      "title": "EUR/USD",
      "proName": "FX_IDC:EURUSD"
    },
    {
      "title": "BTC/USD",
      "proName": "BITSTAMP:BTCUSD"
    },
    {
      "title": "ETH/USD",
      "proName": "BITSTAMP:ETHUSD"
    },
    {
      "description": "BTC/GBP",
      "proName": "COINBASE:BTCGBP"
    },
    {
      "description": "BTC/USDC",
      "proName": "COINBASE:BTCUSDC"
    }
  ],
  "colorTheme": "light",
  "isTransparent": false,
  "displayMode": "adaptive",
  "locale": "en"
}
  </script>
</div>
<!-- TradingView Widget END -->
<section class="about py-5">
	<div class="container py-md-3">
		<h3 class="heading mb-md-5 mb-4">Laxiom Investments</h3>
		<div class="row about-grids agile-info">
			<div class="col-lg-6 mb-lg-0 w3-agile-grid mb-5">
				<p>We are an investment company focused primarily on Crypto Currency Mining, trading of Stock Market indices, individual Stocks, Options, ETFs, and Futures while providing stock market analysis. Throughout the duration of our 14 year long trading experience, we have developed a feel for the markets that can help educate traders to navigate through their journey with confidence. During those years we have seen both Bull and Bear Markets, which added to the experience needed to provide information that is essential to survive volatile markets. Futures, Equities, and Options provide vehicles that can bring both long and short term gains if risk can be controlled and leverage is used properly. Laxiom uses an Elliott Wave Hybrid strategy which involves Moving averages, Fractals and Momentum indicators to determine opportunities with set risk scenarios. We use Facebook as our primary platform for providing our services. Due to the overwhelming demand from our Facebook followers and communications with fellow traders on Facebook who urged us to provide this investment platform,we have decided to offer this service.</p>
				<p class="mt-2 mb-3">Laxiom has qualified and licensed financiers that manages and provides financial consultating services for her investors. We pride ourselves a world class professional customer service, unique trading strategies, optimum transparency and fidelity.</p>
				<a href="about">Read More </a>
			</div>
			<div class="col-lg-3 col-md-4 w3-agile-grid pr-md-0">
				<h3 class="margin">13+ years experience</h3>
				<h3 class="black">Valuable Services</h3>
			</div>
			<div class="col-lg-3 col-md-4 w3-agile-grid mt-md-0 mt-4">
				<h3 class="margin green">Experienced Professionals</h3>
				<h3 class="grey">Management Solutions</h3>
			</div>
		</div>
	</div>
</section>
<!-- //about -->




<!-- quotes -->
<section class="quotes py-5 text-center">
	<div class="container py-md-3">
		<!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-screener.js" async>
  {
  "width": "100%",
  "height": "490",
  "defaultColumn": "overview",
  "screener_type": "crypto_mkt",
  "displayCurrency": "USD",
  "colorTheme": "light",
  "locale": "en"
}
  </script>
</div>
<!-- TradingView Widget END -->
	</div>
</section>
<!-- //quotes -->

<!-- about -->
<section class="quotes py-5 text-center">
	
		<div class="quotes-info agile-info-quotes">
			<h3 class="mb-3">choose a plan and start trading with us today</h3>
		</div>
	</div>
	</section>
<section class="about py-5">
		
	<div class="container py-md-3">

		<div class="row about-grids agile-info">
			<div class="col-lg-6 mb-lg-0 w3-agile-grid mb-5">
			<h2 class="mb-3" class="quotes py-5 text-center">BEGINNER PLAN</h3>
				<p>7% Weekly</p>
				<p>$500 Minimum Deposit</p>
				<a href="dashboard.php">Select Plan</a>
			</div>
			<div class="col-lg-6 mb-lg-0 w3-agile-grid mb-5">
			<h2 class="mb-3" class="quotes py-5 text-center">REGULAR PLAN</h3>
				<p>2% Daily</p>
				<p>$1,000 Minimum Deposit</p>
				<a href="dashboard.php">Select Plan</a>
			</div>
		</div>
	</div>
</section>
<!-- //about -->
<!-- how we work -->
<section class="work">
	<div class="work-layer py-5">
	<div class="container py-md-3">
		<h3 class="heading mb-lg-5 mb-4">How It Works</h3>
		<div class="row join agile-info">
			<div class="col-md-3 col-sm-6 steps-reach w3-agile-grid">
				<span class="fab fa-algolia"></span>
				<h4>Step 1</h4>
				<p>Register an account with an active e-mail.</p>
				<div class="style-border">
					<img src="images/sty1.png" alt="">
				</div>
			</div>
			<div class="col-md-3 col-sm-6 mt-sm-0 mt-5 steps-reach w3-agile-grid">
				<span class="fab fa-asymmetrik"></span>
				<h4>Step 2</h4>
				<p>Activate your account, login and choose a plan.</p>
				<div class="style-border second-border">
					<img src="images/sty2.png" alt="">
				</div>
			</div>
			<div class="col-md-3 col-sm-6 mt-md-0 mt-5 pt-md-0 pt-sm-5 steps-reach w3-agile-grid">
				<span class="fas fa-bug" aria-hidden="true"></span>
				<h4>Step 3</h4>
				<p>Deposit funds and start earn daily.</p>
				<div class="style-border">
					<img src="images/sty1.png" alt="">
				</div>
			</div>
			<div class="col-md-3 col-sm-6 mt-md-0 mt-5 pt-md-0 pt-sm-5 steps-reach w3-agile-grid">
				<span class="fas fa-check-square" aria-hidden="true"></span>
				<h4>Step 4</h4>
				<p>Withdraw your earnings.</p>
			</div>
		</div>
	</div>
	</div>
</section>
<!-- //how we work -->

<!-- servicesbottom -->
<section class="service-bottom">
	<div class="container-fluid">
		<div class="row">
			<!-- Counter -->
			<div class="col-lg-6 p-0 services-bottom">
				<div class="layer agile-info">
					<h3 class="heading mb-lg-5 mb-4">Company Stats</h3>
					<div class="row">
						<div class="col-sm-6 col-6 agileits_w3layouts_about_counter_left w3-agile-grid">
							<div class="countericon">
								<span class="fab fa-algolia" aria-hidden="true"></span>
							</div>
							<div class="counterinfo agile-info">
								<p class="counter">736</p> 
								<h3>Customers</h3>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="col-sm-6 col-6 agileits_w3layouts_about_counter_left w3-agile-grid">
							<div class="countericon">
								<span class="fab fa-asymmetrik" aria-hidden="true"></span>
							</div>
							<div class="counterinfo agile-info">
								<p class="counter">1147</p> 
								<h3>Payments</h3>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="col-sm-6 col-6 mt-5 agileits_w3layouts_about_counter_left w3-agile-grid">
							<div class="countericon">
								<span class="fas fa-bug" aria-hidden="true"></span>
							</div>
							<div class="counterinfo agile-info">
								<p class="counter">13</p>
								<h3>Years Experience</h3>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="col-sm-6 col-6 mt-5 agileits_w3layouts_about_counter_left w3-agile-grid">
							<div class="countericon">
								<span class="fas fa-check-square" aria-hidden="true"></span>
							</div>
							<div class="counterinfo agile-info">
								<p class="counter">17</p>
								<h3>Management Team</h3>
							</div>
							<div class="clearfix"> </div>
						</div>
					</div>
				</div>
			</div>
			<!-- //Counter -->
			<!-- Clients -->
			<div class=" col-lg-6 clients">
				<h3 class="heading mb-lg-5 mb-4">Our Clients...</h3>
				<section class="slider w3-agile-grid">
					<div class="flexslider">
						<ul class="slides">
							<li>
									<p>Laxiom Investment have provided me with capital to undertake various ventures around the world. They know their job and they are the best.</p>
									<div class="client">
										<img src="images/cc1.jpg" alt="" />
										<h5>Yin Alex Chang</h5>
										<div class="clearfix"> </div>
									</div>
							</li>
							<li>
									<p>This platform is perfect. Wonderful customer service, intellectually balanced workers who understand the financial market very well.</p>
									<div class="client">
									<img src="images/cc2.jpg" alt="" />
										<h5>Rita Sabat</h5>
										<div class="clearfix"> </div>
									</div>
							</li>
							<li>
									<p>Obviously it is normal to be skeptical at first but after my first dealing with Laxiom I can boldly say it has been one of my greatest business decision so far.</p>
									<div class="client">
									<img src="images/cc3.jpg" alt="" />
										<h5>Olga Mathews</h5>
										<div class="clearfix"> </div>
									</div>
							</li>
							<li>
									<p>Although I had my reservations initially but all doubts were cleared when I saw my colleague got paid right before me then I knew it was time to invest for myself. Yes I’m very glad I did.</p>
									<div class="client">
									<img src="images/cc4.jpg" alt="" />
										<h5>Imran Mohammed</h5>
										<div class="clearfix"> </div>
									</div>
							</li>
							<li>
									<p>All doubts were cleared when I saw my colleague got paid right before me then I knew it was time to invest for myself and I’m very glad I did.</p>
									<div class="client">
									<img src="images/cc5.jpg" alt="" />
										<h5>Shantelle Benders</h5>
										<div class="clearfix"> </div>
									</div>
							</li>
						</ul>
					</div>
				</section>
			</div>
			<div class="clearfix"> </div>
			<!-- //Clients -->
		</div>
	</div>
</section>
<!-- //servicesbottom -->

<!-- quotes -->
<section class="quotes py-5 text-center">
	<div class="container py-md-3">
		<div class="quotes-info agile-info-quotes">
			<h3 class="mb-3">start trading with us today</h3>
			<p>and start earning.</p>
			<a class="bt mt-4 mr-2 text-capitalize" href="login" role="button"> Get Started</a>
		</div>
	</div>
</section>
<!-- //quotes -->

<!-- footer -->	
<footer>
	<div class="container-fluid p-5">
		<div class="row footer-gap">
			<div class="col-lg-6 mb-lg-0 mb-4">
				<h3 class="text-capitalize mb-3">Company Links</h3>
				<div><a class="nav-link" href="index.php">Home</a></div>
				<div class="nav-item"><a class="nav-link" href="about.php">About</a></div>
				<div class="nav-item"><a class="nav-link" href="contact.php">Contact</a></div>
				<div><a class="nav-link" href="terms.php">Terms</a></div>
				<div><a class="nav-link" href="policy.php">Policy</a></div>
				<div class="row mt-4">
					<div class="col-md-6">
						
					</div>
					<div class="col-md-6 mt-md-0 mt-5">
						
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 mt-lg-0 mt-sm-0 p-md-0">
				<h3 class="text-capitalize mb-3">Head Quarters</h3>
						<address class="mb-0">
							<p class="mb-2"><i class="fas fa-map-marker"></i> 873 Panacella Dr NE, Abingdon<br>Virginia(VA), 24210</p>
							<p><i class="fas mr-1 fa-clock"></i> Timings: 10 a.m to 6 p.m</p>
							<p><i class="fas mr-1 fa-phone"></i> +1 571-350-0598</p>
							
							<p><i class="fas mr-1 fa-envelope-open"></i> <a href="mailto:info@laxiominvestment.com">info@laxiominvestment.com</a></p>
						</address>
			</div>
			<div class="col-lg-3 col-md-6 mt-lg-0 mt-md-0 mt-4 p-md-0">
				<h3 class="text-capitalize mb-3">Connect With Us</h3>
				
				<p><span class="fab fa-instagram"></span> instagram/@Laxiom_Investment_firm</p>
				<p><span class="fab fa-youtube mb-4"></span> youtube/@my_website</p>
				<a href="#" class="facebook mr-2"><span class="fab mr-1 fa-facebook-f"></span> Facebook</a>
				<a href="#" class="twitter"><span class="fab mr-1 fa-twitter"></span> Twitter</a>
					
			</div>
		</div>
	</div>
	<div class="copyright pb-sm-5 pb-4 text-center">
		<p>© 2017 Grade. All Rights Reserved</p>
	</div>
</footer>
<!-- footer -->

	<!-- Vertically centered Modal -->

	<!-- //Vertically centered Modal -->

	<!-- js -->
	<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script> <!-- Necessary-JavaScript-File-For-Bootstrap --> 
	<!-- //js -->	
	
	<!-- Stats-Number-Scroller-Animation-JavaScript -->
		<script src="js/waypoints.min.js"></script> 
		<script src="js/counterup.min.js"></script> 
		<script>
			jQuery(document).ready(function( $ ) {
				$('.counter').counterUp({
					delay: 100,
					time: 1000
				});
			});
		</script>
	<!-- //Stats-Number-Scroller-Animation-JavaScript -->
	
	<!-- Banner Responsiveslides -->
	<script src="js/responsiveslides.min.js"></script>
	<script>
		// You can also use "$(window).load(function() {"
		$(function () {
			// Slideshow 4
			$("#slider3").responsiveSlides({
				auto: true,
				pager: true,
				nav: false,
				speed: 500,
				namespace: "callbacks",
				before: function () {
					$('.events').append("<li>before event fired.</li>");
				},
				after: function () {
					$('.events').append("<li>after event fired.</li>");
				}
			});

		});
	</script>
	<!-- // Banner Responsiveslides -->

	<!-- start-smoth-scrolling -->
	<script src="js/SmoothScroll.min.js"></script>
	<script type="text/javascript" src="js/move-top.js"></script>
	<script type="text/javascript" src="js/easing.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".scroll").click(function(event){		
				event.preventDefault();
				$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
			});
		});
	</script>
	<!-- here stars scrolling icon -->
	<script type="text/javascript">
		$(document).ready(function() {
			/*
				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
				};
			*/
								
			$().UItoTop({ easingType: 'easeOutQuart' });
								
			});
	</script>
	<!-- //here ends scrolling icon -->
	<!-- start-smoth-scrolling -->

	<!-- FlexSlider-JavaScript -->
	<script defer src="js/jquery.flexslider.js"></script>
	<script type="text/javascript">
		$(function(){
			SyntaxHighlighter.all();
				});
				$(window).load(function(){
				$('.flexslider').flexslider({
					animation: "slide",
					start: function(slider){
						$('body').removeClass('loading');
					}
			});
		});
	</script>
	<!-- //FlexSlider-JavaScript -->

<?php include 'tawk.php';?>
</body>
</html>