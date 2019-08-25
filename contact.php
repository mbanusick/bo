<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Contact Us</title>
	
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="keywords" content="Grade Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
	Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
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
	
	<!--web font-->
	<link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
	<!--//web font-->

</head>

<body>

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
							
						</a>
					</li>
					<li class="nav-item  mr-lg-3">
						<a class="nav-link" href="about.php">about</a>
					</li>
						
					<li class="nav-item">
						<a class="nav-link" href="contact.php">contact</a>
						<span class="sr-only">(current)</span>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="register.php">Register</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="login.php">Login</a>
					</li>
				</ul>
				<div class="buttons">
					<p><i class="fas mr-1 fa-phone"></i> +12 445 8976 2334</p>
				</div>
				
			</div>
		</nav>
	</div>
</header>
<!-- //header -->

<!-- banner -->
<section class="inner-banner">
	<div class="banner-layer">
		<h1 class="text-center">Contact Page</h1>
	</div>
</section>
<!-- //banner -->

<!-- contact -->
<section class="contact py-5">
	<div class="container">
		<h2 class="heading mb-lg-5 mb-4">Contact Us</h2>
		<div class="row contact-grids w3-agile-grid">
			<div class="row col-md-4 col-sm-6 contact-grid1 w3-agile-grid">
				<div class="col-3 text-center">
					<i class="fas fa-envelope-open"></i>
				</div>
				<div class="col-9 p-0">
					<h4>Email</h4>
					<p><a href="mailto:info@example.com">info@example.com</a></p>
				</div>
			</div>
			<div class="row col-md-4 col-sm-6 mt-sm-0 mt-4 contact-grid1 w3-agile-grid">
				<div class="col-3 text-center">
					<i class="fas fa-phone"></i>
				</div>
				<div class="col-9 p-0">
					<h4>Call Us</h4>
					<p>+11 887 8976 2334</p>
				</div>
			</div>
			<div class="row col-md-4 col-sm-6 mt-md-0 mt-4 contact-grid1 w3-agile-grid">
				<div class="col-3 text-center">
					<i class="fas fa-laptop"></i>
				</div>
				<div class="col-9 p-0">
					<h4>Career</h4>
					<p><a href="mailto:example@career.com">example@career.com</a></p>
				</div>
			</div>
		</div>
		<div class="row contact_full w3-agile-grid">
			<div class="col-md-7 contact-us w3-agile-grid">
				<form action="#" method="post">
					<div class="row">
						<div class="col-md-6 styled-input">
							<input type="text" name="Name" placeholder="Name" required="">
						</div>
						<div class="col-md-6 styled-input">
							<input type="email" name="Email" placeholder="Email" required=""> 
						</div> 
					</div>
					<div class="styled-input">
						<input type="text" name="phone" placeholder="Phone Number" required="">
					</div>
					<div class="styled-input">
						<textarea name="Message" placeholder="Message" required=""></textarea>
					</div>
					<div class="click mt-3">
						<input type="submit" value="SEND">
					</div>
				</form>
			</div>
			<div class="col-md-5 map">
				 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1398183.40180821!2d7.103180750702041!3d46.80771447968857!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x478c64ef6f596d61%3A0x5c56b5110fcb7b15!2sSwitzerland!5e0!3m2!1sen!2sin!4v1529102870533"></iframe>
				 </div>
		</div>
	</div>
</section>
<!-- //contact -->

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
							<p><i class="fas mr-1 fa-phone"></i> +12 445 8976 2334</p>
							<p><i class="fas mr-1 fa-fax"></i> +11 887 8976 2334 </p>
							<p><i class="fas mr-1 fa-envelope-open"></i> <a href="mailto:info@example.com">info@example.com</a></p>
						</address>
			</div>
			<div class="col-lg-3 col-md-6 mt-lg-0 mt-md-0 mt-4 p-md-0">
				<h3 class="text-capitalize mb-3">Connect With Us</h3>
				<p><span class="fab fa-twitter"></span> twitter/@my_website</p>
				<p><span class="fab fa-instagram"></span> instagram/@my_website</p>
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

	<!-- js -->
	<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script> <!-- Necessary-JavaScript-File-For-Bootstrap --> 
	<!-- //js -->	
	
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

</body>
</html>