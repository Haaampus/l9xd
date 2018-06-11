<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="icon" href="<?php echo asset('website_assets/img/favicon.ico'); ?>" />
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo asset('website_assets/css/app.css'); ?>">
	<title>Solo Division Boost — Kattboost</title>
</head>
<body>
	
	<header class="header_order text-center">
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
					      <a class="nav-item nav-link active" href="<?php echo App\Router\Router::url('order-now'); ?>">Order now <span class="sr-only">(current)</span></a>
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
					<h1 class="header-page-title">solo division boost</h1>
				</div>
			</div>
		</div>
	</header><!-- /header -->

	<section class="black text-center">
		<div class="container">
			<div class="form-group">
				<label>Queue</label>
				<select id="queue" class="form-control" onchange="getPrice()">
					<option value="Solo/Duo" selected>Solo/Duo</option>
					<option value="Flex (5v5)">Flex (5v5)</option>
					<option value="Flex (3v3)">Flex (3v3)</option>
				</select>
			</div>
			<div class="form-group">
				<label>Server</label>
				<select id="server" class="form-control" onchange="getPrice()">
					<option value="EUW" selected>EUW</option>
					<option value="NA">NA</option>
					<option value="EUNE">EUNE</option>
				</select>
			</div>
			<div class="form-group">
				<label>Current rank</label>
				<select id="current_rank" class="form-control" onchange="getPrice()">
					<option value="Unranked">Unranked</option>
					<option value="Bronze">Bronze</option>
					<option value="Silver" selected>Silver</option>
					<option value="Gold">Gold</option>
					<option value="Platinum">Platinum</option>
					<option value="Diamond">Diamond</option>
					<option value="Master">Master</option>
					<option value="Challenger">Challenger</option>
				</select>
			</div>
			<div class="form-group">
				<select id="current_rank_division" class="form-control" onchange="getPrice()">
					<option value="V" selected>V</option>
					<option value="IV">IV</option>
					<option value="III">III</option>
					<option value="II">II</option>
					<option value="I">I</option>
				</select>
			</div>
			<div class="form-group">
				<label>Desired rank</label>
				<select id="desired_rank" class="form-control" onchange="getPrice()">
					<option value="Unranked">Unranked</option>
					<option value="Bronze">Bronze</option>
					<option value="Silver">Silver</option>
					<option value="Gold">Gold</option>
					<option value="Platinum" selected>Platinum</option>
					<option value="Diamond">Diamond</option>
					<option value="Master">Master</option>
					<option value="Challenger">Challenger</option>
				</select>
			</div>
			<div class="form-group">
				<select id="desired_rank_division" class="form-control" onchange="getPrice()">
					<option value="V">V</option>
					<option value="IV">IV</option>
					<option value="III">III</option>
					<option value="II" selected>II</option>
					<option value="I">I</option>
				</select>
			</div>
			<div class="form-group">
				<label style="display: block;" for="duo" onchange="getPrice()">
					<input type="checkbox" id="duo">
					    Duo ?
				</label>
			</div>
			<h3 class="section-h3-blue section-title-pink" id="price" style="margin-bottom: 50px; margin-top: 50px;"></h3>
			<a href="" id="submit_order" class="button button-sm button-pink">Let's go !</a>
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
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		function getPrice() {
			var e = document.getElementById("queue");
            var queue = e.options[e.selectedIndex].value;
            var e = document.getElementById("server");
            var server = e.options[e.selectedIndex].value;
            var e = document.getElementById("current_rank");
            var current_rank = e.options[e.selectedIndex].value;
            var e = document.getElementById("current_rank_division");
            var current_rank_division = e.options[e.selectedIndex].value;
            var e = document.getElementById("desired_rank");
            var desired_rank = e.options[e.selectedIndex].value;
            var e = document.getElementById("desired_rank_division");
            var desired_rank_division = e.options[e.selectedIndex].value;
            var duo = document.getElementById('duo').checked;
            if (duo === true) {
            	duo = 1;
            } else {
            	duo = 0;
            }

            current_rank_price = current_rank + ' ' + current_rank_division;
            desired_rank_price = desired_rank + ' ' + desired_rank_division;

            if (current_rank === "Master" || current_rank === "Challenger") {
            	current_rank_price = current_rank;
            }
            if (desired_rank === "Master" || desired_rank === "Challenger") {
            	desired_rank_price = desired_rank;
            }
            if (current_rank === "Unranked") {
            	current_rank_price = current_rank;
            }
            if (desired_rank === "Unranked") {
            	desired_rank_price = desired_rank;
            }

            var dataString = 'type=division&current_rank=' + current_rank_price + 
		    "&desired_rank=" + desired_rank_price + "&server=" + server + "&isDuo=" + duo;

		    $.ajax({
		      type: 'POST',
		      data: dataString,
		      url: '<?php echo App\Router\Router::url('getPrice'); ?>',
		      success: function (data) {
		          if(data == 0)
		          {
		            document.getElementById('price').innerHTML = "This boost is not possible.";
		          }else{
		            document.getElementById('price').innerHTML = data + " €";
		            document.getElementById("submit_order").href='<?php echo App\Router\Router::url('paypal_payment'); ?>?custom=Division Boost|' + queue + '|' + duo + '|' + data + '|EUR|' + server + '|' + current_rank + '|' + current_rank_division + '|0-20|' + desired_rank + '|' + desired_rank_division + '|0';
		          }
		        }
		    });
		}

		$( document ).ready(function() {
		    getPrice();
		});
	</script>

    <script type='text/javascript' data-cfasync='false'>window.purechatApi = { l: [], t: [], on: function () { this.l.push(arguments); } }; (function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({c: '0c16e816-4dde-41ce-b314-5147fd52f1f7', f: true }); done = true; } }; })();</script>
</body>
</html>