<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="icon" href="<?php echo asset('website_assets/img/favicon.ico'); ?>" />
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo asset('website_assets/css/app.css'); ?>">
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<title>Join Our Team — L9 Boosting</title>
</head>
<body>
	
	<header class="header_join_our_team text-center">
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
					      <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('contact'); ?>">Contact us</a>
					      <a class="nav-item nav-link active" href="<?php echo App\Router\Router::url('join-our-team'); ?>">Join our team <span class="sr-only">(current)</span></a>
					      <a class="nav-item nav-link nav-pink" href="<?php echo App\Router\Router::url('login.show'); ?>">Login</a>
					    </div>
					  </div>
					</nav>
				</div>
				<div class="header-content">
					<h1 class="header-page-title">join our team</h1>
				</div>
			</div>
		</div>
	</header><!-- /header -->

	<section class="black" style="padding-top: 1px;">
		<div class="container">
			<h3 class="section-h3-blue">WANT TO BE A PART OF OUR TEAM?</h3>
			<p>All Submissions are confidential and will be reviewed only by our management team.</p>
			<p>Kattboost has available job positions, we offer a fair chance to join our team,</p>
			<p>if you think you will be a great addition to our team and are looking for a reliable paying job,</p>
			<p>then please do not hesitate to contact us!</p>
			<p>When your application is sent in, it will be reviewed within 24 hours, and you will get a reply.</p>
			<p>If you are serious about being apart of Kattboost Boosting Team, send in your application and you could potentially be joining our team.</p>
			<p>We work with famous streamers and guests occasionally , we will not tolerate anything unprofessional.</p>

			<h3 class="section-h3-blue">WHAT YOU GET OUT OF WORKING FOR US?</h3>
			<p>High Pay % Cuts , Friendly Community With Other Boosters , No Late Payments , Friendly Service ,</p>
			<p>One of the Best Boosting Groups Reputation and the Opportunity To Work Alongside Season 6 Rank 1 Player.</p>
			<p>We never fire without pay, you deserve what you boosted for.</p>
			<p>*special circumstances do apply*
			70-90% Payout *depending on age, experience , performance on boosts*</p>
			<p>80-100% Pay during RUSH ORDERS *orders that are required to be done on a specific date ,</p>
			<p>end of season or with extreme account circumstances*</p>
		
			<h3 class="section-h3-blue">CURRENTLY HIRING ON ALL SERVERS!</h3>
			<p>We have a very strict application session , please link your OP,GG of ALL your owned accounts .</p>
			<p>We will be checking OP,GG , Interviewing , Test Games , How our team accepts you and more...</p>
			<p>If you do not qualify for the following ranks , please do not send an application to join our team ,</p>
			<p>you will be likely be ignored. We receive an average of 25 applications a month , and usually only 1 makes it in. </p>
			<p>- Master NA/EUW</p>
			<p>- Challenger 550+ LP EUNE</p>
			<p>- Challenger 600+ LP LAN/LAS/OCE/BR</p>
			<p>If you do not get a reply within 24 hours , you are most likely not accepted. We here only hire the best of the best.</p>
			<p>We have 3 Tier types you are able to apply for:</p>
			<p>Tier 1 - Challenger</p>
			<p>Tier 2 - Current rank of Master 150+ LP </p>
			<p>Tier 2X - Current Master but not Above 150LP or Below Masters.</p>
			<p>If you get accepted , you are first placed into "Trial Booster" where you will be able to see our booster chat , but not the more secretive channels such as orders. As a Trial Booster, you will be stocking up accounts to D5 on your specific region. These accounts are all yours, we mainly do this to test your skill and how the team likes you. If you are successful and we like what we see ; you will be promoted to your Tier that you applied for ; if you qualify. These stock D5 accounts could be sold when customers purchase them. You as a trial booster will get your money ~100 USD for your stocked D5 account , you will keep stocking accounts and maintaining your rank of Master to be able to join our Team once we think you are worthy. This process could be a few days to a few weeks for a final result from us.</p>

			<h3 class="section-h3-blue">PLEASE COMPLETE THE FORM BELOW</h3>
			<form action="<?php echo App\Router\Router::url('post_join_our_team'); ?>" method="POST">
				<div class="form-group">
					<label>Email Address</label>
					<input type="email" name="email" class="form-control">
				</div>
				<div class="form-group">
					<label>Subject</label>
					<br>
					<small>TCLB x Kattboost Applicants will be REQUIRED to be Challenger 500+ LP in NA/EUW to be eligible for trial testing.</small>
					<select name="subject" class="form-control">
						<option value="">Choose the tier you would like to apply for</option>
						<option value="TCLB x L9 Collab">TCLB x Kattboost Collab</option>
						<option value="Tier 1">Tier 1</option>
						<option value="Tier 2">Tier 2</option>
						<option value="Tier 3">Tier 3</option>
					</select>
				</div>
				<div class="form-group">
					<label>Current Rank</label>
					<select name="current_rank" class="form-control">
						<option value="">Select your current rank</option>
						<option value="Master 150 LP and under">Master 150 LP and under</option>
						<option value="Master 150 LP and over">Master 150 LP and over</option>
						<option value="Challenger 0-500 LP">Challenger 0-500 LP</option>
						<option value="Challenger 500-750 LP">Challenger 500-750 LP</option>
						<option value="Challenger 750-1000 LP">Challenger 750-1000 LP</option>
						<option value="Challenger 1000+LP">Challenger 1000+LP</option>
					</select>
				</div>
				<div class="form-group">
					<label>Regions you can boost</label>
					<br>
					<small>Check all that apply</small>
					<label style="display: block; padding-top: 15px;" for="na">
					<input type="checkbox" name="regions[NA]" id="na">
					    NA
					  </label>
					  <label style="display: block;" for="euw">
					<input type="checkbox" name="regions[EUW]" id="euw">
					    EUW
					  </label>
					  <label style="display: block;" for="eune">
					<input type="checkbox" name="regions[EUNE]" id="eune">
					    EUNE
					  </label>
					  <label style="display: block;" for="las">
					<input type="checkbox" name="regions[LAS]" id="las">
					    LAS
					  </label>
					  <label style="display: block;" for="LAN">
					<input type="checkbox" name="regions[LAN]" id="LAN">
					    LAN
					  </label>
					  <label style="display: block;" for="RUS">
					<input type="checkbox" name="regions[RUS]" id="RUS">
					    RUS
					  </label>
					  <label style="display: block;" for="TR">
					<input type="checkbox" name="regions[TR]" id="TR">
					    TR
					  </label>
					  <label style="display: block;" for="BR">
					<input type="checkbox" name="regions[BR]" id="BR">
					    BR
					  </label>
					  <label style="display: block;" for="OCE">
					<input type="checkbox" name="regions[OCE]" id="OCE">
					    OCE
					  </label>
				</div>
				<div class="form-group">
					<label>Time Availability</label>
					<br>
					<small>Check All That Apply</small>
					<label style="display: block; padding-top: 15px;" for="2-4 Hours a day">
					<input type="checkbox" name="availability[2-4 Hours a day]" id="2-4 Hours a day">
					    2-4 Hours a day
					  </label>
					  <label style="display: block;" for="4-5 Hours a day">
					<input type="checkbox" name="availability[4-5 Hours a day]" id="4-5 Hours a day">
					    4-5 Hours a day
					  </label>
					  <label style="display: block;" for="5-7 Hours a day">
					<input type="checkbox" name="availability[5-7 Hours a day]" id="5-7 Hours a day">
					    5-7 Hours a day
					  </label>
					  <label style="display: block;" for="7-9 Hours a day">
					<input type="checkbox" name="availability[7-9 Hours a day]" id="7-9 Hours a day">
					    7-9 Hours a day
					  </label>
					  <label style="display: block;" for="9+ Hours a day">
					<input type="checkbox" name="availability[9+ Hours a day]" id="9+ Hours a day">
					    9+ Hours a day
					  </label>
				</div>
				<div class="form-group">
					<label>Message</label>
					<br>
					<small>This is where you impress us on why we should consider taking you to be apart of our Kattboost Team.</small>
					<textarea name="message" class="form-control" placeholder="Why choose you over the 30+ other applicants ?"></textarea>
				</div>
				<div class="form-group">
					<label>OP.GG Link(s)</label>
					<br>
					<small>Please link your main account and your smurf(s).</small>
					<input type="text" name="opgg" class="form-control" placeholder="na.op.gg/test123">
				</div>
				<div class="form-group">
					<label>Screenshot Proofs</label>
					<br>
					<small>Please include you going onto your main account , take a picture of your profile tab without hiding characters and play a Ranked Game on your main while taking a picture in game and after game ends.</small>
					<textarea name="screenshot" class="form-control" placeholder="Gyazo/Imgur Image"></textarea>
				</div>
				<div class="form-group">
					<label>Check all that apply</label>
					<label style="display: block;" for="18 Year or older">
					<input type="checkbox" name="boosting[18 Year or older]" id="18 Year or older">
					    18 Year or older
					  </label>
					  <label style="display: block;" for="Have past experience boosting">
					<input type="checkbox" name="boosting[Have past experience boosting]" id="Have past experience boosting">
					    Have past experience boosting
					  </label>
					  <label style="display: block;" for="Work for more than 2 Websites">
					<input type="checkbox" name="boosting[Work for more than 2 Websites]" id="Work for more than 2 Websites">
					    Work for more than 2 Websites
					  </label>
					  <label style="display: block;" for="Heard of us from someone else">
					<input type="checkbox" name="boosting[Heard of us from someone else]" id="Heard of us from someone else">
					    Heard of us from someone else
					  </label>
				</div>
				<div class="form-group">
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