<?php 
	
	$match_history = [];

if ($api) {
	try {
		$summoner = $api->getSummonerByName(App\Repository\UserRepository::getInstance()->getUserDetail($_SESSION['user']['id'], 'summoner_name'));
	} catch (\Exception $e) {
		$summoner = null;
	}
	// Match history
	if (!empty($summoner)) {
		try {
			$matches = $api->getRecentMatchlistByAccount($summoner->accountId);

			// For every matches
			foreach ($matches as $match) {
				$a_match = $api->getMatch($match->gameId);

				if ($a_match->gameType === "MATCHED_GAME") {
					$gameCreation = date("d-M-Y H:i:s", substr($a_match->gameCreation, 0, 10));
					if ($gameCreation < $order['created_at']) {
						// Get the participant ID of the customer
						foreach ($a_match->participantIdentities as $participantIdentity) {
							if ($participantIdentity->player->currentAccountId === $summoner->accountId) {
								$participantId = $participantIdentity->participantId;
							}
						}

						// Get stats of the participant
						foreach ($a_match->participants as $participant) {
							if ($participant->participantId === $participantId) {
								$match_history[$match->gameId]['gameCreation'] = $gameCreation;
								$match_history[$match->gameId]['championId'] = $participant->championId;
								$match_history[$match->gameId]['spells']['spell1'] = $participant->spell1Id;
								$match_history[$match->gameId]['spells']['spell2'] = $participant->spell2Id;
								$match_history[$match->gameId]['win'] = $participant->stats->win;
								$match_history[$match->gameId]['kills'] = $participant->stats->kills;
								$match_history[$match->gameId]['deaths'] = $participant->stats->deaths;
								$match_history[$match->gameId]['assists'] = $participant->stats->assists;
								$match_history[$match->gameId]['goldEarned'] = $participant->stats->goldEarned;
								$match_history[$match->gameId]['totalMinionsKilled'] = $participant->stats->totalMinionsKilled;
								$match_history[$match->gameId]['items']['item0'] = $participant->stats->item0;
								$match_history[$match->gameId]['items']['item1'] = $participant->stats->item1;
								$match_history[$match->gameId]['items']['item2'] = $participant->stats->item2;
								$match_history[$match->gameId]['items']['item3'] = $participant->stats->item3;
								$match_history[$match->gameId]['items']['item4'] = $participant->stats->item4;
								$match_history[$match->gameId]['items']['item5'] = $participant->stats->item5;
								$match_history[$match->gameId]['items']['item6'] = $participant->stats->item6;
							}
						}
					}
				}
			}

		} catch (\Exception $e) {
			//die($e->getMessage());
		}
	}
}
?>

<?php $view = new App\Library\Template\Template('boostpanel.layouts.app', [
	'title' 	 => 'Dashboard',
	'page_title' => 'Dashboard'
	]); ?>

<?php $view->start('content'); ?>
	
	<div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-bag"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Order ID</span>
              <span class="info-box-number">
                  <?php $coachOrder = \App\Repository\UserRepository::getInstance()->getCoachOrder(); ?>
				<?php
					if (isset($order) && !empty($order)) {
						$_SESSION['order_id'] = $order['id'];
						echo $order['id'];
					} else if (!$coachOrder && !isset($order) && empty($order)) {
						echo 'No current order.';
					}
				?>
                  <?php if ($coachOrder): ?>
                    <small>You have a coach order, click <a href="<?php echo \App\Router\Router::url('customer.coachorder', ['coach_order' => $coachOrder['id']]); ?>">here</a> to view it.</small>
                  <?php endif; ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-ios-information-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Order Status</span>
              <span class="info-box-number">
              	<?php 
              		if (isset($order) && !empty($order)) {
						if ($order['status'] === 0) {
							echo 'Looking for booster.';
						} else if ($order['status'] === 1) {
							echo 'In progress.';
						}
					} else {
						echo 'No current order.';
					}
              	?>
              </span>
              <!-- <span>
              	<button class="btn btn-xs btn-primary">Pause Order</button>
              	<button class="btn btn-xs btn-primary">Spectate Match</button>
              </span> -->
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-earth"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Server</span>
              <span class="info-box-number"><?php echo App\Repository\UserRepository::getInstance()->getUserDetail($_SESSION['user']['id'], 'server'); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-person-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Summoner name</span>
              <span class="info-box-number"><?php echo App\Repository\UserRepository::getInstance()->getUserDetail($_SESSION['user']['id'], 'summoner_name'); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
		
	  <!-- Account & Order -->
	  <div class="row">
	  	<div class="col-xs-12">
		  	<div class="box box-primary collapsed-box">
			  	<div class="box-header with-border">
			  		<h4 class="box-title">Account & Order</h4>
			  		<div class="box-tools pull-right">
	                	<button type="button" class="btn btn-box-tool" data-widget="collapse">
	                		<i class="fa fa-plus"></i>
	                	</button>
              		</div>
          		</div>
			  	<div class="box-body">
			  		<form action="<?php echo App\Router\Router::url('account_order'); ?>" method="POST">

			  			<!-- FIRST ROW -->
			  			<div class="row">
			  				<div class="form-group col-md-3">
				  				<label>Account name</label>
				  				<input type="text" name="account_name" placeholder="If solo boost" class="form-control mt5" value="<?php echo App\Repository\UserRepository::getInstance()->getUserDetail($_SESSION['user']['id'], 'account_name'); ?>">
				  			</div>
				  			<div class="form-group col-md-3">
				  				<label>Summoner name</label>
				  				<input type="text" name="summoner_name" class="form-control mt5" value="<?php echo App\Repository\UserRepository::getInstance()->getUserDetail($_SESSION['user']['id'], 'summoner_name'); ?>">
				  			</div>
				  			<div class="form-group col-md-3">
				  				<label>Password</label>
				  				<input type="password" name="password" placeholder="If solo boost" class="form-control mt5" value="<?php echo App\Repository\UserRepository::getInstance()->getUserDetail($_SESSION['user']['id'], 'account_password'); ?>">
				  			</div>
				  			<div class="form-group col-md-3">
				  				<label>Server</label>
				  				<select name="server" class="form-control mt5">
				  					<?php if (!empty(App\Config::SERVERS)) {
				  						foreach (App\Config::SERVERS as $server) {
				  							$option = "<option value='$server'";
				  							if (App\Repository\UserRepository::getInstance()->getUserDetail($_SESSION['user']['id'], 'server') === $server) {
				  								$option .= 'selected';
				  							}
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
			  			</div>
			  			<!-- END FIRST ROW -->

						<!-- SECOND ROW -->
						<div class="row">
							<div class="form-group col-md-4">
								<label>Notes to Booster</label>
								<textarea name="notes_to_booster" class="form-control mt5" style="resize: none;"><?php echo App\Repository\UserRepository::getInstance()->getUserDetail($_SESSION['user']['id'], 'notes_to_booster'); ?></textarea>
							</div>
							<div class="form-group col-md-4">
								<label>Prefered Position</label>
								<div class="checkbox icheck">
									<label>
										<input type="checkbox" name="prefered_positions[top]" style="padding-bottom: 5px;" <?php 
											if (App\Repository\UserRepository::getInstance()->isPreferedPosition($_SESSION['user']['id'], 'top')) {
												echo 'checked';
											}
										 ?>> Top
									</label>
									<br>
									<label>
										<input type="checkbox" name="prefered_positions[jungle]" <?php 
											if (App\Repository\UserRepository::getInstance()->isPreferedPosition($_SESSION['user']['id'], 'jungle')) {
												echo 'checked';
											}
										 ?>> Jungle
									</label>
									<br>
									<label>
										<input type="checkbox" name="prefered_positions[mid]" <?php 
											if (App\Repository\UserRepository::getInstance()->isPreferedPosition($_SESSION['user']['id'], 'mid')) {
												echo 'checked';
											}
										 ?>> Mid
									</label>
									<br>
									<label>
										<input type="checkbox" name="prefered_positions[support]" <?php 
											if (App\Repository\UserRepository::getInstance()->isPreferedPosition($_SESSION['user']['id'], 'support')) {
												echo 'checked';
											}
										 ?>> Support
									</label>
									<br>
									<label>
										<input type="checkbox" name="prefered_positions[bot]" <?php 
											if (App\Repository\UserRepository::getInstance()->isPreferedPosition($_SESSION['user']['id'], 'bot')) {
												echo 'checked';
											}
										 ?>> Bot
									</label>
								</div>
							</div>
							<div class="form-group col-md-4">
								<label>Prefered Champions</label>
								<select class="form-control select2" name="prefered_champions[]" multiple="multiple" data-placeholder="Select champions"
					                        style="width: 100%;">
					                  <?php
					                  $champions = getAllChampions();
					                  	if (isset($champions) && !empty($champions)) {
					                  		foreach ($champions as $champion) {
					                  			$option = "<option value='";
					                  			$option .= $champion . "' ";

					                  			if (App\Repository\UserRepository::getInstance()->isPreferedChampion($_SESSION['user']['id'], $champion)) {
					                  				$option .= "selected>";
					                  			} else {
					                  				$option .= ">";
					                  			}

					                  			$option .= ucfirst($champion) . "</option>";
					                  			echo $option;
					                  		}
					                  	}
					                  ?>
					            </select>
							</div>
						</div>
						<!-- END SECOND ROW -->
						<button class="btn btn-primary btn-flat" type="submit">Save</button>
			  		</form>
			  	</div>
			</div>
		</div>
	  </div>
	  <!-- End account & order -->

	  <div class="row">

	  	<!-- Current Order -->
	  	<div class="col-md-8">
	  		<div class="box box-info">
	  			<div class="box-header with-border">
	  				<h3 class="box-title">Current Order</h3>
	  			</div>
	  			<div class="box-body">
	  				<div class="row text-center">
	  					<?php
	  						if (isset($order) && !empty($order)) {
	  							if ($order['type'] === "Net Wins" || $order['type'] === "Placement Matches") {
	  								$order_details = App\Repository\OrderRepository::getInstance()->getOrderDetails($order['id'], $order['type']);
	  								if (isset($order_details) && !empty($order_details)) {
	  									?>
	  										<h3 class="current-order-detail-title">Current</h3>
											<img src="boostpanel_assets/img/tiers/<?php echo $order_details['current_league'] . '.png'; ?>" alt="<?php echo $order_details['current_league']; ?>" class="boostpanel-tier-img">
											<h4 class="current-order-detail-league"><?php echo $order_details['current_league']; ?></h4>
											<h5 class="current-order-detail-division">Division <?php echo $order_details['current_division']; ?></h5>
											<p class="current-order-detail-league-points">Amount of games</p>
											<p class="current-order-detail-league-points-number"><?php echo $order_details['game_amount']; ?></p>
	  									<?php
	  								} else {
	  									echo '<h4>Error getting details of the order.</h4>';
	  								}
	  							} else if ($order['type'] === "Division Boost") {
	  								$order_details = App\Repository\OrderRepository::getInstance()->getOrderDetails($order['id'], $order['type']);
	  								if (isset($order_details) && !empty($order_details)) {
	  									?>
											<div class="col-md-4">
												<h3 class="current-order-detail-title">Start</h3>
												<img src="boostpanel_assets/img/tiers/<?php echo $order_details['start_league'] . '.png'; ?>" alt="<?php echo $order_details['start_league']; ?>" class="boostpanel-tier-img">
												<h4 class="current-order-detail-league"><?php echo $order_details['start_league']; ?></h4>
												<h5 class="current-order-detail-division">Division <?php echo $order_details['start_division']; ?></h5>
												<p class="current-order-detail-league-points">League Points</p>
												<p class="current-order-detail-league-points-number"><?php echo $order_details['start_league_points']; ?></p>
											</div>
											<div class="col-md-4">
												<h3 class="current-order-detail-title">Current</h3>
												<img src="boostpanel_assets/img/tiers/<?php echo $order_details['current_league'] . '.png'; ?>" alt="<?php echo $order_details['current_league']; ?>" class="boostpanel-tier-img">
												<h4 class="current-order-detail-league"><?php echo $order_details['current_league']; ?></h4>
												<h5 class="current-order-detail-division">Division <?php echo $order_details['current_division']; ?></h5>
												<p class="current-order-detail-league-points">League Points</p>
												<p class="current-order-detail-league-points-number"><?php echo $order_details['current_league_points']; ?></p>
											</div>
											<div class="col-md-4">
												<h3 class="current-order-detail-title">Desired</h3>
												<img src="boostpanel_assets/img/tiers/<?php echo $order_details['desired_league'] . '.png'; ?>" alt="<?php echo $order_details['desired_league']; ?>" class="boostpanel-tier-img">
												<h4 class="current-order-detail-league"><?php echo $order_details['desired_league']; ?></h4>
												<h5 class="current-order-detail-division">Division <?php echo $order_details['desired_division']; ?></h5>
											</div>										
	  									<?php
	  								} else {
	  									echo '<h4>Error getting details of the order.</h4>';
	  								}
	  							}
	  						} else {
	  							echo '<h4>No current order.</h4>';
	  						}
	  					?>
	  				</div><!-- /.row -->
	  			</div>
	  		</div>
	  	</div>
	  	<!-- End current order -->

	  	<!-- Live chat -->
	  	<div class="col-md-4">
	  		<div class="box box-primary direct-chat direct-chat-primary">
	            <div class="box-header with-border">
	              <h3 class="box-title">LiveChat</h3>
	            </div>
	            <div class="box-body">
	            	<div class="direct-chat-messages" id="direct-chat-messages-id">
						<div id="messages">
							
						</div>
		            </div>
	            </div>
	            <div class="box-footer">
	              <form id="chat" action="#" onSubmit="return false;">
						<div class="input-group">
							<input name="livechat_message" id="message" type="text" placeholder="Type Message ..." class="form-control">
							<span class="input-group-btn">
								<button name="livechat_send" type="submit" class="btn btn-primary btn-flat">Send</button>
							</span>
						</div>
					</form>
	            </div>
	        </div>
	  	</div>
	  	<!-- End Live chat -->

	  </div>

	  <!-- Match History -->
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-default">
					<div class="box-header with-border">
		  				<h3 class="box-title">Match History</h3>
		  			</div>
		  			<div class="box-body">
		  				<table id="match_history_table" class="table table-bordered table-striped">
		  					<thead>
		  						<tr>
		  							<th>Champion</th>
		  							<th class="text-center">Result</th>
		  							<th class="text-center">K/D/A</th>
		  							<th class="text-center">Gold</th>
		  							<th class="text-center">Minions</th>
		  							<th class="text-center">Items</th>
		  							<th class="text-center">Spells</th>
		  						</tr>
		  					</thead>
		  					<tbody>
		  						<?php
		  						try {
		  							if(isset($match_history) && !empty($match_history)) {
		  								foreach($match_history as $match) {
		  									?>
												<tr class="history-<?php echo $match['win'] ? 'win' : 'lose'; ?>">
													<td class="history-champion">
														<?php App\Library\DataDragonAPI\DataDragonAPI::initByCdn(); ?>
														<img src="<?php
														 try { 
														 	echo App\Library\DataDragonAPI\DataDragonAPI::getChampionIcon($api->getStaticChampion($match['championId'])->name); 
														 	}catch (\Exception $e) {

														 	}
														 	?>" alt="Icon Champion" class="match-history-champion">
													</td>
													<td class="history-result text-center">
														<h4><?php echo $match['win'] ? 'win' : 'loss'; ?></h4>
														<small><?php echo $match['gameCreation']; ?></small>
													</td>
						  							<td class="text-center"><?php echo $match['kills']." / ".$match['deaths']." / ".$match['assists']; ?></td>
						  							<td class="text-center"><?php echo $match['goldEarned']; ?></td>
						  							<td class="text-center"><?php echo $match['totalMinionsKilled']; ?></td>
						  							<td class="text-center">
						  							<?php
						  								if (isset($match['items']) && !empty($match['items'])) {
						  									foreach ($match['items'] as $item) {
						  										if ($item === 0) {
						  											?>
																	<img src="<?php echo asset('boostpanel_assets/img/item-empty.png'); ?>" class="match-history-item" alt="Item">
						  											<?php
						  										} else {
						  											?>
						  											<img src="<?php echo App\Library\DataDragonAPI\DataDragonAPI::getItemIcon($item); ?>" class="match-history-item" alt="Item">
						  											<?php
						  										}
						  									}
						  								}
						  							?></td>
						  							<td class="text-center">
						  							<?php
														if (isset($match['spells']) && !empty($match['spells'])) {
						  									foreach ($match['spells'] as $spell) {
						  										?>
																	<img src="<?php 
																	echo App\Library\DataDragonAPI\DataDragonAPI::getSpellIcon($api->getStaticSummonerSpell($spell)->name); ?>" class="match-history-item" alt="Spell">
						  										<?php
						  									}
						  								}
						  							?>
						  							</td>
												</tr>
		  									<?php
		  								}
		  							}
		  						} catch (\Exception $e) {
		  							die($e->getMessage());
		  						}
		  						?>
		  					</tbody>
		  				</table>
		  			</div>
				</div>
			</div>
		</div>
	  <!-- End Match History -->

<?php $view->stop(); ?>

<?php $view->start('script'); ?>
    <script type="text/javascript">
        <?php if (isset ($order)) : ?>
            const newMessage = new Audio("https://uploads.twitchalerts.com/sound-defaults/new-message-4.ogg");

                $(function(){
            $(document).on('submit','#chat', function(){
                var message = $.trim($("#message").val());
                document.getElementById('message').value = "";

                if(message != "")
                {
                    $.ajax({
                        type: 'POST',
                        data: '&message=' + message,
                        url: "<?php echo App\Router\Router::url('ChatPoster', ['id' => $order['id']]); ?>",
                        success: function(data)
                        {
                            getMessages(true);
                            $('#direct-chat-messages-id').stop().animate({
                                scrollTop: $("#direct-chat-messages-id")[0].scrollHeight
                            });
                        }
                    });
                }else{
                    alert("Enter a message");
                }
            });

                    //Check If Last Message Is In Focus
                    var checkFocus = function() {
                        var container = $('#direct-chat-messages-id');
                        var height = container.height();
                        var scrollHeight = container[0].scrollHeight;
                        var st = container.scrollTop();
                        var sum = scrollHeight - height - 32;
                        if(st >= sum) {
                            return true;
                        } else {
                            return false;
                        }
                    }

            function getMessages(no_sound = false){
                // Get the height of the div before getting messages
                var elem = $('#messages');
                var precedentHeight = elem.height();

                $.ajax({
                    type: 'GET',
                    url: "<?php echo App\Router\Router::url('ChatMessages', ['id' => $order['id']]); ?>",
                    success: function(data, XHR)
                    {
                        //alert(XHR);
                        if(checkFocus()) {
                            $('#messages').html( data );
                            $('#direct-chat-messages-id').stop().animate({
                                scrollTop: $("#direct-chat-messages-id")[0].scrollHeight
                            });
                        } else {
                            $('#messages').html( data );
                        }

                        // Get the height of the div after getting messages
                        var afterHeight = elem.height();

                        if (precedentHeight !== afterHeight && precedentHeight !== 0 && no_sound === false) {
                            newMessage.play();
                        }
                    },
                    complete: function() {
                      // Schedule the next request when the current one's complete
                      setTimeout(getMessages, 5000);
                    },
                    error: function(xhr, status, error) {
                        console.info(xhr);
                        console.info(status);
                        console.info(error);
                    }
                });

            }

            getMessages();
	});
        <?php endif; ?>
    </script>
	<script type="text/javascript">
		$('#match_history_table').DataTable({
			responsive: true
		});
		//Initialize Select2 Elements
    	$('.select2').select2();
	</script>
<?php $view->stop(); ?>

<?php echo $view->render(); ?>