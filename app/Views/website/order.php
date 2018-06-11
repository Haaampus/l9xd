<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="icon" href="<?php echo asset('website_assets/img/favicon.ico'); ?>" />
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo asset('website_assets/css/app.css'); ?>">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo asset('boostpanel_assets/bower_components/select2/dist/css/select2.min.css'); ?>">
	<title>Order Now — Kattboost</title>
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
					<h1 class="header-page-title">order now</h1>
					<div class="header-page-description">
						<p>Select your choice of order! Special Requests such as Tarzaned or other famous streamers will be required to be contacted privately.</p>
					</div>
				</div>
			</div>
		</div>
	</header><!-- /header -->

	<section class="black text-center">
		<div class="container">
			<nav>
			  <div class="nav nav-tabs" id="nav-tab" role="tablist">
			    <a class="nav-item nav-link active" id="nav-division-boost-tab" data-toggle="tab" href="#nav-division-boost" role="tab" aria-controls="nav-division-boost" aria-selected="true" onclick="getPriceSolo()">Division Boost</a>
			    <a class="nav-item nav-link" id="nav-placement-tab" data-toggle="tab" href="#nav-placement" role="tab" aria-controls="nav-placement" aria-selected="false" onclick="getPricePlacement()">Placement Matches</a>
			    <a class="nav-item nav-link" id="nav-wins-tab" data-toggle="tab" href="#nav-wins" role="tab" aria-controls="nav-wins" aria-selected="false" onclick="getPriceWin()">Net Wins</a>
			  </div>
			</nav>
			<div class="tab-content" id="nav-tabContent">
			  <div class="tab-pane fade show active" id="nav-division-boost" role="tabpanel" aria-labelledby="nav-division-boost-tab">
			  	<div class="row">
			  		<div class="col-md-4">
			  			<h4>Current rank</h4>
			  			<img src="<?php echo asset('boostpanel_assets/img/tiers/Silver.png'); ?>" id="current_rank_img" class="img-responsive" alt="Silver">
			  			<div class="form-group">
							<select id="current_rank" class="form-control" onchange="getPriceSolo(); changeImage(this);">
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
							<select id="current_rank_division" class="form-control" onchange="getPriceSolo()">
								<option value="V" selected>V</option>
								<option value="IV">IV</option>
								<option value="III">III</option>
								<option value="II">II</option>
								<option value="I">I</option>
							</select>
						</div>
			  		</div>
			  		<div class="col-md-4">
			  			<h4>Desired rank</h4>
			  			<img src="<?php echo asset('boostpanel_assets/img/tiers/Platinum.png'); ?>" id="desired_rank_img" class="img-responsive" alt="Platinum">
			  			<div class="form-group">
							<select id="desired_rank" class="form-control" onchange="getPriceSolo(); changeImage(this);">
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
							<select id="desired_rank_division" class="form-control" onchange="getPriceSolo()">
								<option value="V">V</option>
								<option value="IV">IV</option>
								<option value="III">III</option>
								<option value="II" selected>II</option>
								<option value="I">I</option>
							</select>
						</div>
			  		</div>
			  		<div class="col-md-4">
			  			<h4>Server & Queue & Duo</h4>
			  			<div class="form-group">
							<label>Server</label>
							<select id="server" class="form-control" onchange="getPriceSolo()">
                                <?php if (!empty(App\Config::SERVERS)) {
                                    foreach (App\Config::SERVERS as $server) {
                                        $option = "<option value='$server'";
                                        $option .= ">$server</option>";
                                        echo $option;
                                    }
                                } else {
                                    ?>
                                    <option disabled selected>No Servers.</option>
                                    <?php
                                } ?>
							</select>
						</div>
						<div class="form-group">
							<label>Queue</label>
							<select id="queue" class="form-control" onchange="getPriceSolo()">
								<option value="Solo/Duo" selected>Solo/Duo</option>
								<option value="Flex (5v5)">Flex (5v5)</option>
								<option value="Flex (3v3)">Flex (3v3)</option>
							</select>
						</div>
						<div class="form-group">
							<label style="display: block;" for="duo" onchange="getPriceSolo()">
								<input type="checkbox" id="duo">
								    Duo ?
							</label>
						</div>
			  		</div>
			  	</div>
			  </div>

			  <div class="tab-pane fade" id="nav-placement" role="tabpanel" aria-labelledby="nav-placement-tab">
			  	<div class="row">
			  		<div class="col-md-4">
			  			<h4>Last season rank</h4>
			  			<img src="<?php echo asset('boostpanel_assets/img/tiers/Silver.png'); ?>" id="current_rank_placement_img" class="img-responsive" alt="Silver">
			  			<div class="form-group">
							<select id="current_rank_placement" class="form-control" onchange="getPricePlacement(); changeImage(this)">
								<option value="Unranked">Unranked</option>
								<option value="Bronze">Bronze</option>
								<option value="Silver" selected>Silver</option>
								<option value="Gold">Gold</option>
								<option value="Platinum">Platinum</option>
								<option value="Diamond">Diamond</option>
							</select>
						</div>
			  		</div>
			  		<div class="col-md-4">
			  			<h4>Amount of games</h4>
			  			<div class="form-group">
							<select id="number_of_games" class="form-control" onchange="getPricePlacement()">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10" selected>10</option>
							</select>
						</div>
			  		</div>
			  		<div class="col-md-4">
			  			<h4>Server & Queue & Duo</h4>
			  			<div class="form-group">
							<label>Server</label>
							<select id="server_placement" class="form-control" onchange="getPricePlacement()">
                                <?php if (!empty(App\Config::SERVERS)) {
                                    foreach (App\Config::SERVERS as $server) {
                                        $option = "<option value='$server'";
                                        $option .= ">$server</option>";
                                        echo $option;
                                    }
                                } else {
                                    ?>
                                    <option disabled selected>No Servers.</option>
                                    <?php
                                } ?>
							</select>
						</div>
						<div class="form-group">
							<label>Queue</label>
							<select id="queue_placement" class="form-control" onchange="getPricePlacement()">
								<option value="Solo/Duo" selected>Solo/Duo</option>
								<option value="Flex (5v5)">Flex (5v5)</option>
								<option value="Flex (3v3)">Flex (3v3)</option>
							</select>
						</div>
						<div class="form-group">
							<label style="display: block;" for="duo_placement" onchange="getPricePlacement()">
								<input type="checkbox" id="duo_placement">
								    Duo ?
							</label>
						</div>
			  		</div>
			  	</div>
			  </div>

			  <div class="tab-pane fade" id="nav-wins" role="tabpanel" aria-labelledby="nav-wins-tab">
			  	<div class="row">
			  		<div class="col-md-4">
			  			<h4>Last season rank</h4>
			  			<img src="<?php echo asset('boostpanel_assets/img/tiers/Silver.png'); ?>" id="current_rank_win_img" class="img-responsive" alt="Silver">
			  			<div class="form-group">
							<select id="current_rank_win" class="form-control" onchange="getPriceWin(); changeImage(this)">
								<option value="Unranked">Unranked</option>
								<option value="Bronze">Bronze</option>
								<option value="Silver" selected>Silver</option>
								<option value="Gold">Gold</option>
								<option value="Platinum">Platinum</option>
								<option value="Diamond">Diamond</option>
							</select>
						</div>
						<div class="form-group">
							<select id="current_rank_division_win" class="form-control" onchange="getPriceWin()">
								<option value="V" selected>V</option>
								<option value="IV">IV</option>
								<option value="III">III</option>
								<option value="II">II</option>
								<option value="I">I</option>
							</select>
						</div>
			  		</div>
			  		<div class="col-md-4">
			  			<h4>Amount of games</h4>
			  			<div class="form-group">
							<select id="number_of_games_win" class="form-control" onchange="getPriceWin()">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10" selected>10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
							</select>
						</div>
			  		</div>
			  		<div class="col-md-4">
			  			<h4>Server & Queue & Duo</h4>
			  			<div class="form-group">
							<label>Server</label>
							<select id="server_win" class="form-control" onchange="getPriceWin()">
                                <?php if (!empty(App\Config::SERVERS)) {
                                    foreach (App\Config::SERVERS as $server) {
                                        $option = "<option value='$server'";
                                        $option .= ">$server</option>";
                                        echo $option;
                                    }
                                } else {
                                    ?>
                                    <option disabled selected>No Servers.</option>
                                    <?php
                                } ?>
							</select>
						</div>
						<div class="form-group">
							<label>Queue</label>
							<select id="queue_win" class="form-control" onchange="getPriceWin()">
								<option value="Solo/Duo" selected>Solo/Duo</option>
								<option value="Flex (5v5)">Flex (5v5)</option>
								<option value="Flex (3v3)">Flex (3v3)</option>
							</select>
						</div>
						<div class="form-group">
							<label style="display: block;" for="duo_win" onchange="getPriceWin()">
								<input type="checkbox" id="duo_win">
								    Duo ?
							</label>
						</div>
			  		</div>
			  	</div>
			  </div>
			</div>
			<h3 class="section-h3-blue" id="price" style="margin-bottom: 30px; margin-top: 50px;"></h3>
            <label for="terms_services" style="margin-bottom: 35px;">
                <input type="checkbox" id="terms_services">
                I agree to terms and services
            </label>
            <br>
            <a href="" data-toggle="modal" id="lets_go" data-target="#modal-set-order" class="button button-sm" style="display: none;">Let's go !</a>
		</div>
	</section>

    <div class="modal fade" id="modal-set-order" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="modal-title"></h4>
                </div>
                <div class="modal-body text-center">
                    <div class="form-group">
                        <label>LoL Account</label>
                        <input type="text" name="lol_account" id="lol_account" onblur="setLolAccount(this);" class="form-control" placeholder="If solo boost">
                    </div>
                    <div class="form-group">
                        <label>LoL Password</label>
                        <input type="text" name="lol_password" id="lol_password" class="form-control" onblur="setLolPassword(this)" placeholder="If solo boost">
                    </div>
                    <div class="form-group">
                        <label>Summoner Name</label>
                        <input type="text" name="summoner_name" id="summoner_name" onblur="setSummonerName(this)" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Preferred Position(s)</label>
                        <select name="prefered_positions[]" id="prefered_positions" class="form-control select2" multiple="multiple" style="width: 100%">
                            <?php
                                $positions = [
                                        'top',
                                        'jungle',
                                        'mid',
                                        'bot',
                                        'support'
                                ];
                                foreach ($positions as $position):
                            ?>
                                    <option value="<?php echo $position; ?>"><?php echo $position; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Preferred Champions (5 minimum : +$5 to the total price)</label>
                        <select name="prefered_champions[]" id="prefered_champions" class="form-control select2" multiple="multiple" style="width: 100%">
                            <?php foreach(getAllChampions() as $champion): ?>
                                <option value="<?php echo $champion; ?>"><?php echo $champion; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Notes to booster</label>
                        <textarea name="notes" cols="30" id="notes_to_booster" onblur="setNotesToBooster(this)" rows="10" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <span style="display: none;" id="order_link"></span>
                    <a class="btn btn-default pull-left" data-dismiss="modal">Close</a>
                    <a class="btn btn-primary" id="submit_order">Pay</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

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
    <!-- Select2 -->
    <script src="<?php echo asset('boostpanel_assets/bower_components/select2/dist/js/select2.full.min.js'); ?>"></script>
    <script>
        var count = 0;
        var champions5 = false;

        var lol_account = "";
        var lol_password = "";
        var summoner_name = "";
        var notes_to_booster = "";

        function setLolAccount(el) {
            lol_account = el.value;
        }
        function setLolPassword(el) {
            lol_password = el.value;
        }
        function setSummonerName(el) {
            summoner_name = el.value;
        }
        function setNotesToBooster(el) {
            var length = $(el).val().length;
            if (length > 80) {
                alert("You can put maximum 80 characters. You will be able to enter more information when you log in.");
            }
            notes_to_booster = el.value;
        }

        var selectedPreferedPositions = [];
        $('#prefered_positions').on('select2:select', function() {
            $.each($("#prefered_positions").select2('data'), function (key, item) {
                selectedPreferedPositions.indexOf(item.text) === -1 ? selectedPreferedPositions.push(item.text) : null;
            });
        });

        $('#prefered_positions').on('select2:unselect', function (e) {
            var index = selectedPreferedPositions.indexOf(e.params.data.text);
            if (index !== -1) selectedPreferedPositions.splice(index, 1);
        });

        var selectedPreferedChampions = [];
        $('#prefered_champions').on('select2:select', function() {
            $.each($("#prefered_champions").select2('data'), function (key, item) {
                selectedPreferedChampions.indexOf(item.text) === -1 ? selectedPreferedChampions.push(item.text) : null;
            });
        });

        $('#prefered_champions').on('select2:unselect', function (e) {
            var index = selectedPreferedChampions.indexOf(e.params.data.text);
            if (index !== -1) selectedPreferedChampions.splice(index, 1);
        });

        $('#prefered_champions').on('select2:close', function (evt) {
            count = $(this).select2('data').length;
        });

        $('#submit_order').click(function()
        {
            var url = document.getElementById('order_link').innerText;
            var redirect_to = "";

            if (count > 0 && count < 5) {
                alert('You need to put atleast 5 champions.')
            } else if (count >= 5) {
                redirect_to = url + "|" + lol_account + "|" + lol_password + "|" + summoner_name +
                    "|" + selectedPreferedPositions + "|" + selectedPreferedChampions + "|"
                    + notes_to_booster + "|true";
                window.location.replace(redirect_to);
            } else if (summoner_name === "") {
                alert('You need to put your summoner name.');
            } else if (notes_to_booster.length > 80) {
                alert('You can put maximum 80 characters. You will be able to enter more information when you log in.');
            } else {
                redirect_to = url + "|" + lol_account + "|" + lol_password + "|" + summoner_name +
                    "|" + selectedPreferedPositions + "|" + selectedPreferedChampions + "|"
                    + notes_to_booster + "|false";
                window.location.replace(redirect_to);
            }
        });

        $(function() {
            var chk = $('#terms_services');

            chk.click(function() {
                if( $(this).is(':checked') ){
                    document.getElementById('lets_go').style["display"] = "initial";
                }else{
                    document.getElementById('lets_go').style["display"] = "none";
                }
            });
        });
		function changeImage(image)
		{
		  // Get id of the select
		  var e = document.getElementById(image.id);
		  var selected = e.options[e.selectedIndex].value;
		  
		  // If it's server, change server img
		  if(selected === "NA" || selected === 'OCE' || selected === 'EUW' || selected === 'TR' || selected === 'EUNE')
		  {
		    // Change img
		    var img = document.getElementById(image.id + "_img");
		    img.src="assets/img/regions/" + selected + ".png";
		  }else{ // Else, change league
		    // Change img
		    var img = document.getElementById(image.id + "_img");
		    img.src= "<?php echo asset('boostpanel_assets/img/tiers/'); ?>" + selected + ".png";
		  }
		  
		}

		function getPriceSolo() {
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
		            document.getElementById('price').innerHTML = "$" + data;
		            document.getElementById("order_link").innerHTML='<?php echo App\Router\Router::url('paypal_payment'); ?>?custom=Division Boost|' + queue + '|' + duo + '|' + data + '|USD|' + server + '|' + current_rank + '|' + current_rank_division + '|0-20|' + desired_rank + '|' + desired_rank_division + '|0';
		          }
		        }
		    });
		}

		function getPricePlacement() {
			var e = document.getElementById("queue_placement");
            var queue = e.options[e.selectedIndex].value;
            var e = document.getElementById("server_placement");
            var server = e.options[e.selectedIndex].value;
            var e = document.getElementById("current_rank_placement");
            var current_rank = e.options[e.selectedIndex].value;
            var e = document.getElementById("number_of_games");
            var wins = e.options[e.selectedIndex].value;
            var duo = document.getElementById('duo_placement').checked;
            
            if (duo === true) {
            	duo = 1;
            } else {
            	duo = 0;
            }

            current_rank_price = current_rank;

            var dataString = 'type=placement&current_rank=' + current_rank_price + "&server=" + server + "&isDuo=" + duo + "&wins_number=" + wins;

		    $.ajax({
		      type: 'POST',
		      data: dataString,
		      url: '<?php echo App\Router\Router::url('getPrice'); ?>',
		      success: function (data) {
		          if(data == 0)
		          {
		            document.getElementById('price').innerHTML = "This boost is not possible.";
		          }else{
		            document.getElementById('price').innerHTML = "$" + data;
		            document.getElementById("order_link").innerHTML='<?php echo App\Router\Router::url('paypal_payment'); ?>?custom=Placement Matches|' + queue + '|' + duo + '|' + data + '|USD|' + server + '|' + current_rank + '|' + '|0-20|' + '|' + '|' + wins;
		          }
		        }
		    });
		}

		function getPriceWin() {
			var e = document.getElementById("queue_win");
            var queue = e.options[e.selectedIndex].value;
            var e = document.getElementById("server_win");
            var server = e.options[e.selectedIndex].value;
            var e = document.getElementById("current_rank_win");
            var current_rank = e.options[e.selectedIndex].value;
            var e = document.getElementById("current_rank_division_win");
            var current_rank_division = e.options[e.selectedIndex].value;
            var e = document.getElementById("number_of_games_win");
            var wins = e.options[e.selectedIndex].value;
            var duo = document.getElementById('duo_win').checked;
            
            if (duo === true) {
            	duo = 1;
            } else {
            	duo = 0;
            }

            current_rank_price = current_rank + ' ' + current_rank_division;

            if (current_rank === "Master" || current_rank === "Challenger") {
            	current_rank_price = current_rank;
            }
            if (current_rank === "Unranked") {
            	current_rank_price = current_rank;
            }

            var dataString = 'type=win&current_rank=' + current_rank_price + "&server=" + server + "&isDuo=" + duo + "&wins_number=" + wins;

		    $.ajax({
		      type: 'POST',
		      data: dataString,
		      url: '<?php echo App\Router\Router::url('getPrice'); ?>',
		      success: function (data) {
		          if(data == 0)
		          {
		            document.getElementById('price').innerHTML = "This boost is not possible.";
		          }else{
		            document.getElementById('price').innerHTML = "$" + data;
		            document.getElementById("order_link").innerHTML='<?php echo App\Router\Router::url('paypal_payment'); ?>?custom=Net Wins|' + queue + '|' + duo + '|' + data + '|USD|' + server + '|' + current_rank + '|' + current_rank_division + '|0-20|' + '|' + '|' + wins;
		          }
		        }
		    });
		}

		$( document ).ready(function() {
		    getPriceSolo();
		});

        //Initialize Select2 Elements
        $('.select2').select2()
	</script>
    <script type='text/javascript' data-cfasync='false'>window.purechatApi = { l: [], t: [], on: function () { this.l.push(arguments); } }; (function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({c: '0c16e816-4dde-41ce-b314-5147fd52f1f7', f: true }); done = true; } }; })();</script>
</body>
</html>