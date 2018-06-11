<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="icon" href="<?php echo asset('website_assets/img/favicon.ico'); ?>" />
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo asset('website_assets/css/app.css'); ?>">
	<title>Past Orders — Kattboost</title>
</head>
<body>
	
	<header class="header_past_orders text-center">
		<div class="layer">
			<div class="container">
				<div class="header-header">
					<a href="<?php echo App\Router\Router::url('home'); ?>">
						<img src="<?php echo asset('website_assets/img/logo.png'); ?>" class="logo" alt="L9 ELO BOOSTING LOGO">
					</a>
					<nav class="navbar navbar-expand-lg navbar-dark">
					  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
					    <span class="navbar-toggler-icon"></span>
					  </button>
					  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
					    <div class="navbar-nav">
					      <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('home'); ?>">Home</a>
					      <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('home'); ?>#why_choose_us">Why choose us</a>
					      <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('our-services'); ?>">Our services</a>
					      <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('order-now'); ?>">Order now</a>
					      <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('our-team'); ?>">Our team</a>
					      <a class="nav-item nav-link active" href="<?php echo App\Router\Router::url('past-orders'); ?>">Past orders <span class="sr-only">(current)</span></a>
					      <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('faq'); ?>">FAQ</a>
					      <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('contact'); ?>">Contact us</a>
					      <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('join-our-team'); ?>">Join our team</a>
					      <a class="nav-item nav-link nav-pink" href="<?php echo App\Router\Router::url('login.show'); ?>">Login</a>
					    </div>
					  </div>
					</nav>
				</div>
				<div class="header-content">
					<h1 class="header-page-title">past orders</h1>
					<div class="header-page-description">
						<p>Due to the amount of space, order completion photos will not be posted here, but they can be brought up upon request to confirm. Quote-Reviews are left here instead to save up space.</p>
					</div>
				</div>
			</div>
		</div>
	</header><!-- /header -->

	<section class="black">
		<div class="container text-center">
			<h1 class="section-h1-pink section-title-green">Reviews</h1>
			<div class="review">
				<span>"</span>
				<p>@T3 Koko did my placements and went 10-0. Great booster</p>
				<small>— jitter</small>
			</div>
			<div class="review">
				<span>"</span>
				<p>Order challenger coaching by Veigar v2. It was a great experience, a lot of new knowledge and very high class coaching! We went through mechanics, warding spots, laning and VOD reviews. Definintely reccommended!</p>	
				<small>— anonymous</small>
			</div>
		</div>
	</section>

	<section class="pink">
		<div class="container text-center">
			<a href="<?php echo App\Router\Router::url('terms-of-services'); ?>" class="button button-sm button-pink">Terms of services</a>
			<h3 style="margin-top: 50px;">KATTBOOST</h3>
			<p>League of Legends is a registered trademark of Riot Games, Inc. We are in no way affiliated with, associated with or endorsed by Riot Games, Inc.</p>
			<br>
			<br>
			<p class="text-left">2017-2018 Kattboost | ALL RIGHTS RESERVED</p>
		</div>
	</section>
	
	<script
  src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>