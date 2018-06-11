<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="icon" href="<?php echo asset('website_assets/img/favicon.ico'); ?>" />
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo asset('website_assets/css/app.css'); ?>">
	<title>Our Services — Kattboost</title>
</head>
<body>
	
	<header class="header_our_services text-center">
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
					      <a class="nav-item nav-link active" href="<?php echo App\Router\Router::url('our-services'); ?>">Our services <span class="sr-only">(current)</span></a>
					      <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('order-now'); ?>">Order now</a>
                            <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('coaching'); ?>">Coaching</a>
                            <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('our-team'); ?>">Our team</a>
					      <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('faq'); ?>">FAQ</a>
					      <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('contact'); ?>">Contact us</a>
					      <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('join-our-team'); ?>">Join our team</a>
					      <a class="nav-item nav-link nav-pink" href="<?php echo App\Router\Router::url('login.show'); ?>">Login</a>
					    </div>
					  </div>
					</nav>
				</div>
				<div class="header-content">
					<h1 class="header-page-title">our services</h1>
					<div class="header-page-description">
						<p>These are the services we offer here at Kattboost Elo Boosting!</p>
					</div>
				</div>
			</div>
		</div>
	</header><!-- /header -->

	<section class="black">
		<div class="container text-center">
			<a href="<?php echo App\Router\Router::url('order-now'); ?>" class="button button-lg">buy boost</a>
			<h3 class="section-h3-blue">services</h3>
			<p>Please read our terms of service before buying a boost.</p>
			<p>For assistance, use our Live Chat or swing us a message through Email or Discord!</p>
			<hr>
			<h1 class="section-h1-pink">WHAT WE OFFER</h1>

			<h3 class="section-h3-blue">KATTBOOST SPECIAL BOOST</h3>
			<p>This is a special boost ordered only from us! You get a LAN Server account done from Level 30 Unranked to Challenger!</p>
			<p>This price is a base set price that is unfixable; meaning it can't be changed!</p>
			<p>People buy this special order because once we get to Challenger and hand you over the account, most transfer their accounts to different servers at the end of the season after they receive their rewards, meaning the shiny Challenger border and icon, along with the Physical Reward + In Game Specialties + Challenger MMR on their new server and fresh unplaced games.</p>
			<p>*Champions/Skins/Runes will all be randomized depending on which booster plays and what they play, there is no choosing which champions you want on the account. IP/RP will be whatever is on the account when you receive it. Name cannot be requested either.*</p>
			
			<h3 class="section-h3-blue">SOLO DIVISION BOOSTING</h3>
			<p>Solo Division Boost will guarantee the League and Division you desire, with the booster playing on your account.</p>

			<h3 class="section-h3-blue">DUO DIVISION BOOSTING</h3>
			<p>Duo Division Boost will guarantee the League and Division you desire with the booster playing alongside you!</p>

			<h3 class="section-h3-blue">SOLO NET WINS</h3>
			<p>Solo Net Wins will guarantee the positive wins you desire, with the booster playing on your account. Every Loss is +1 Win.</p>
			<p>Ex: 2 Net Wins= 2 Wins 0 Losses , 3 Wins 1 Loss. </p>

			<h3 class="section-h3-blue">DUO NET WINS</h3>
			<p>Duo Net Wins will guarantee the positive wins you desire, with the booster playing along with you!</p>

			<h3 class="section-h3-blue">SOLO PLACEMENT MATCHES</h3>
			<p>Solo Placement Matches guarantees 7/10 wins with the booster playing on your account although we average a very high 8.9/10 placements order completion.</p>

			<h3 class="section-h3-blue">DUO PLACEMENT MATCHES</h3>
			<p>Duo Placement Matches guarantees 7/10 wins while you play on your account. The booster will play with you.</p>

			<h3 class="section-h3-blue">SOLO NORMALS GAMES</h3>
			<p>Solo Normals Games for IP farming, grinding to a level, or getting out of your own ranked restrictions. Booster plays on your account.</p>

			<h3 class="section-h3-blue">COACHING</h3>
			<p style="margin-bottom: 60px;">To purchase coaching, head on over to our COACHING page, where you can purchase coaching directly from there. IF YOU DO NOT SEE AN OPTION YOU LIKE OR IF YOU WOULD LIKE TO DISCUSS PRIVATE PAYMENTS , PLEASE SEND AN ORDER FORM BELOW OR CONTACT US!</p>
			<a href="<?php echo App\Router\Router::url('order-now'); ?>" class="button button-lg">boost order form</a>
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

    <script type='text/javascript' data-cfasync='false'>window.purechatApi = { l: [], t: [], on: function () { this.l.push(arguments); } }; (function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({c: '0c16e816-4dde-41ce-b314-5147fd52f1f7', f: true }); done = true; } }; })();</script>

	<script
  src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>