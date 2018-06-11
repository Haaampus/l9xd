<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="icon" href="<?php echo asset('website_assets/img/favicon.ico'); ?>" />
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo asset('website_assets/css/app.css'); ?>">
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<title>Contact Us — Kattboost</title>
</head>
<body>
	
	<header class="header_contact text-center">
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
                            <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('coaching'); ?>">Coaching</a>
					      <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('our-team'); ?>">Our team</a>
					      <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('faq'); ?>">FAQ</a>
					      <a class="nav-item nav-link active" href="<?php echo App\Router\Router::url('contact'); ?>">Contact us <span class="sr-only">(current)</span></a>
					      <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('join-our-team'); ?>">Join our team</a>
					      <a class="nav-item nav-link nav-pink" href="<?php echo App\Router\Router::url('login.show'); ?>">Login</a>
					    </div>
					  </div>
					</nav>
				</div>
				<div class="header-content">
					<h1 class="header-page-title">contact us</h1>
					<div class="header-page-description">
						<p>We will answer any question you may have! Don't be afraid to send us an email or message us on discord. We will reply within 24 hours.</p>
					</div>
				</div>
			</div>
		</div>
	</header><!-- /header -->

	<section class="black">
		<div class="container">
			<form action="<?php echo App\Router\Router::url('post_contact'); ?>" method="POST" accept-charset="utf-8" style="margin: 0 auto; width: 650px;">
				<div class="form-group">
					<label>Email Address</label>
					<input type="email" name="email" class="form-control">
				</div>
				<div class="form-group">
					<label>Subject</label>
					<input type="text" name="subject" class="form-control">
				</div>
				<div class="form-group">
					<label>Message</label>
					<textarea name="message" class="form-control"></textarea>
				</div>
				<div class="form-groupt text-center mt-lg-5">
					<button type="submit" class="button button-sm button-pink">Submit</button>
				</div>
			</form>
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
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<script>
		<?php if (App\Library\Session\Flash::exist('success')) { ?>
	    toastr.success('<?php echo App\Library\Session\Flash::get('success'); ?>');
	  <?php } else if (App\Library\Session\Flash::exist('error')) { ?>
	    toastr.error('<?php echo App\Library\Session\Flash::get('error'); ?>');
	  <?php } ?>
	</script>
</body>
</html>