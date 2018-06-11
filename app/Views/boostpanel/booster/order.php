<?php $view = new App\Library\Template\Template('boostpanel.layouts.app', [
	'title' 	 => 'Order details',
	'page_title' => 'Order <small>active order</small>'
	]); ?>


<?php $view->start('content'); ?>
	<div class="row">
		
		<!-- Start Order details -->
		<div class="col-md-2">
			<div class="box box-info">
				<div class="box-header with-border">
			  		<h4 class="box-title">Order details</h4>
          		</div>
          		<div class="box-body">
          			<?php if(isset($order) && !empty($order)) {
          				$_SESSION['order_id'] = $order['id'];
          				?>
					<p><b>Order ID : </b> <?php echo $order['id']; ?></p>
          			<p><b>Server : </b> <?php echo $order['server']; ?></p>
          			<p><b>Task : </b> <br><?php if (!strpos($order['type'], 'Coaching')): ?>
                            <span class="boost-box orange"><?php echo $order['queue']; ?> queue</span>
                            <span class="boost-box <?php echo $order['duo'] ? 'red' : 'blue'; ?>"><?php displayDescriptionSpan($order); ?></span>
                        <?php else: ?>
                            <span class="boost-box orange">Coaching</span>
                        <?php endif; ?>
                        <?php displayDescription($order); ?>
          			<p><b>Cashout : </b> <?php echo calcPrice($order['price'], App\Repository\BoosterRepository::getInstance()->getPercentage($_SESSION['user']['id'])); ?> <?php echo $order['currency']; ?></p>
                        <a href="<?php echo App\Router\Router::url('finished_order', ['order_id' => $order['id']]); ?>" onclick="return confirm('Are you soure you\'ve finished this order ?');" class="btn btn-info">Finished</a>
                        <a href="<?php echo App\Router\Router::url('drop_order', ['order_id' => $order['id']]); ?>" onclick="return confirm('Are you soure you want to drop this order ?');" class="btn btn-danger">Drop</a>
          				<?php
          			} else {
          				?>
						Unknown Error.
          				<?php
          			}
          			?>
          		</div>
          	</div>

          	<?php if (!$order['duo']) {
          		?>
          		<div class="box box-danger">
	          		<div class="box-header with-border">
	          			<h4 class="box-title">Customer Account</h4>
	          		</div>
	          		<div class="box-body">
	          			<p><b>Account username : </b> <?php echo $order['account_name']; ?></p>
	          			<p><b>Account password : </b> <?php echo $order['account_password']; ?></p>
                        <p><b>Summoner name : </b> <?php echo $order['summoner_name']; ?></p>
                        <p><b>OP.GG : </b> <a target="_blank" href="<?php echo App\Repository\OrderRepository::getInstance()->getCustomerOPGG($order['id']); ?>">Customer OPGG</a></p>
	          		</div>
	          	</div>
	         <?php
          		}
          	?>

          	<div class="box box-warning">
				<div class="box-header with-border">
			  		<h4 class="box-title">Customer Notes</h4>
          		</div>
          		<div class="box-body">
          			<?php echo $order['notes_to_booster']; ?>
          		</div>
          	</div>

          	<div class="box box-warning">
				<div class="box-header with-border">
			  		<h4 class="box-title">Prefered Positions</h4>
          		</div>
          		<div class="box-body">
          			<?php if(isset($prefered_positions) && !empty($prefered_positions)) {
          				foreach ($prefered_positions as $position) {
          					echo $position['position_name'] . ", ";
          				}
          			}
          			?>
          		</div>
          	</div>

          	<div class="box box-warning">
				<div class="box-header with-border">
			  		<h4 class="box-title">Perefered Champions</h4>
          		</div>
          		<div class="box-body">
          			<?php if(isset($prefered_champions) && !empty($prefered_champions)) {
          				foreach ($prefered_champions as $champion) {
          					echo $champion['champion_name'] . ", ";
          				}
          			}
          			?>
          		</div>
          	</div>
       </div>
		<!-- End Order details -->

		<!-- Start Current Order -->
		<div class="col-md-7">
			<div class="box box-danger">
				<div class="box-header with-border">
			  		<h4 class="box-title">Current Order</h4>
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
											<img src="<?php echo asset("boostpanel_assets/img/tiers/" . $order_details['current_league'] . ".png"); ?>" alt="<?php echo $order_details['current_league']; ?>" class="boostpanel-tier-img">
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
												<img src="<?php echo asset("boostpanel_assets/img/tiers/" . $order_details['start_league'] . ".png"); ?>" alt="<?php echo $order_details['start_league']; ?>" class="boostpanel-tier-img">
												<h4 class="current-order-detail-league"><?php echo $order_details['start_league']; ?></h4>
												<h5 class="current-order-detail-division">Division <?php echo $order_details['start_division']; ?></h5>
												<p class="current-order-detail-league-points">League Points</p>
												<p class="current-order-detail-league-points-number"><?php echo $order_details['start_league_points']; ?></p>
											</div>
											<div class="col-md-4">
												<h3 class="current-order-detail-title">Current</h3>
												<img src="<?php echo asset("boostpanel_assets/img/tiers/" . $order_details['current_league'] . ".png"); ?>" alt="<?php echo $order_details['current_league']; ?>" class="boostpanel-tier-img">
												<h4 class="current-order-detail-league"><?php echo $order_details['current_league']; ?></h4>
												<h5 class="current-order-detail-division">Division <?php echo $order_details['current_division']; ?></h5>
												<p class="current-order-detail-league-points">League Points</p>
												<p class="current-order-detail-league-points-number"><?php echo $order_details['current_league_points']; ?></p>
											</div>
											<div class="col-md-4">
												<h3 class="current-order-detail-title">Desired</h3>
												<img src="<?php echo asset("boostpanel_assets/img/tiers/" . $order_details['desired_league'] . ".png"); ?>" alt="<?php echo $order_details['desired_league']; ?>" class="boostpanel-tier-img">
												<h4 class="current-order-detail-league"><?php echo $order_details['desired_league']; ?></h4>
												<h5 class="current-order-detail-division">Division <?php echo $order_details['desired_division']; ?></h5>
											</div>										
	  									<?php
	  								} else {
	  									echo '<h4>Error getting details of the order.</h4>';
	  								}
	  							} else if (strpos($order['type'], 'Coaching')) {
                                    $order_details = App\Repository\OrderRepository::getInstance()->getOrderDetails($order['id'], $order['type']);
                                    if (isset($order_details) && !empty($order_details)) {
                                        ?>
                                        <h3 class="current-order-detail-title">Current</h3>
                                        <img src="<?php echo asset("boostpanel_assets/img/tiers/" . $order_details['start_league'] . ".png"); ?>" alt="<?php echo $order_details['start_league']; ?>" class="boostpanel-tier-img">
                                        <h4 class="current-order-detail-league"><?php echo $order_details['start_league']; ?></h4>
                                        <h5 class="current-order-detail-division">Division <?php echo $order_details['start_division']; ?></h5>
                                        <?php
                                    } else {
                                        echo '<h4>Error getting details of the order.</h4>';
                                    }
                                }
	  						} else {
	  							echo '<h4>No current order.</h4>';
	  						}
	  					?>
          			</div> <!-- /.row -->
          		</div>
          	</div>
       </div>
		<!-- End Current Order -->

		<!-- Start LiveChat -->
		<div class="col-md-3">
			<div class="box box-primary direct-chat direct-chat-primary">
	            <div class="box-header with-border">
	              <h3 class="box-title">LiveChat</h3>
	            </div>
	            <div class="box-body" style="height: 500px;">
	            	<div class="direct-chat-messages" id="direct-chat-messages-id" style="height: 500px;">
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
		<!-- End LiveChat -->
		
	</div> <!-- /.row -->

<?php $view->stop(); ?>

<?php $view->start('script'); ?>
	<script type="text/javascript">
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
    </script>
<?php $view->stop(); ?>

<?php echo $view->render(); ?>