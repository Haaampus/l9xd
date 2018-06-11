<?php $view = new App\Library\Template\Template('boostpanel.layouts.app', [
	'title' 	 => 'Dashboard',
	'page_title' => 'Dashboard'
	]); ?>


<?php $view->start('content'); ?>
	<div class="row">

		<!-- Start Your orders -->
		<div class="col-md-6">
			<div class="box box-danger">
				<div class="box-header with-border">
			  		<h4 class="box-title">Your orders</h4>
          		</div>
          		<div class="box-body table-responsive no-padding">
          			<table class="table table-hover">
          				<tbody>
          					<tr>
          						<th>ID</th>
          						<th>Server</th>
          						<th>Description</th>
          						<th>Purchase Date</th>
          						<th>Cashout</th>
          						<th></th>
          					</tr>
          					<?php 

          					if (isset($orders) && !empty($orders)) {
          						foreach ($orders as $order) {
          							?>
									<tr>
										<td><?php echo $order['id']; ?></td>
										<td><?php echo $order['server']; ?></td>
										<td>
                                            <?php if (!strpos($order['type'], 'Coaching')): ?>
                                                <span class="boost-box orange"><?php echo $order['queue']; ?> queue</span>
                                                <span class="boost-box <?php echo $order['duo'] ? 'red' : 'blue'; ?>"><?php displayDescriptionSpan($order); ?></span>
                                            <?php else: ?>
                                                <span class="boost-box orange">Coaching</span>
                                            <?php endif; ?>
                                            <?php displayDescription($order); ?>
										</td>
										<td><?php echo date('d/m/Y h:i:s', strtotime($order['created_at'])); ?></td>
										<td><?php echo calcPrice($order['price'], App\Repository\BoosterRepository::getInstance()->getPercentage($_SESSION['user']['id'])); ?> <?php echo $order['currency']; ?></td>
                                        <td><a href="<?php echo App\Router\Router::url('order', ['order_id' => $order['id']]); ?>" class="btn btn-sm btn-danger">Go!</a></td>
									</tr>
          							<?php
          						}
          					} else {
          						?>
									<tbody>
										<tr>
											<td colspan="6" class="text-center">No data availables in table</td>
										</tr>
									</tbody>
          						<?php
          					}

          					?>
          				</tbody>
          			</table>
          		</div>
			</div>
		</div>
		<!-- End Your Orders -->


		<!-- Start Available orders -->
		<div class="col-md-6">
			<div class="box box-info">
				<div class="box-header with-border">
			  		<h4 class="box-title">Available orders</h4>
          		</div>
          		<div class="box-body table-responsive no-padding">
          			<table class="table table-hover">
          				<tbody>
          					<tr>
          						<th>ID</th>
          						<th>Server</th>
          						<th>Description</th>
          						<th>Purchase Date</th>
          						<th>Cashout</th>
                                <th>Prefered Role(s)</th>
                                <th>Prefered Champion(s)</th>
          						<th></th>
          					</tr>
          					<?php 

          					if (isset($available_orders) && !empty($available_orders)) {
          						foreach ($available_orders as $available_order) {
          							?>
									<tr>
										<td><?php echo $available_order['id']; ?></td>
										<td><?php echo $available_order['server']; ?></td>
										<td>
                                            <?php if (!strpos($available_order['type'], 'Coaching')): ?>
                                                <span class="boost-box orange"><?php echo $available_order['queue']; ?> queue</span>
                                                <span class="boost-box <?php echo $available_order['duo'] ? 'red' : 'blue'; ?>"><?php displayDescriptionSpan($available_order); ?></span>
                                            <?php else: ?>
                                                <span class="boost-box orange">Coaching</span>
                                            <?php endif; ?>
                                            <?php displayDescription($available_order); ?>
										</td>
										<td><?php echo date('d/m/Y h:i:s', strtotime($available_order['created_at'])); ?></td>
										<td><?php echo calcPrice($available_order['price'], App\Repository\BoosterRepository::getInstance()->getPercentage($_SESSION['user']['id'])); ?> <?php echo $available_order['currency']; ?></td>
                                        <td>
                                            <?php $prefered_positions = \App\Repository\BoosterRepository::getInstance()->getPreferedPositions($available_order['users_id']); ?>
                                            <?php if(isset($prefered_positions) && !empty($prefered_positions)) {
                                                foreach ($prefered_positions as $position) {
                                                    echo $position['position_name'] . ", ";
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php $prefered_champions = \App\Repository\BoosterRepository::getInstance()->getPreferedChampions($available_order['users_id']); ?>
                                            <?php if(isset($prefered_champions) && !empty($prefered_champions)) {
                                                foreach ($prefered_champions as $champion) {
                                                    echo $champion['champion_name'] . ", ";
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><a href="<?php echo App\Router\Router::url('apply_to_order', ['order_id' => $available_order['id']]); ?>" class="btn btn-sm btn-info">Apply</a></td>
									</tr>
          							<?php
          						}
          					} else {
          						?>
									<tbody>
										<tr>
											<td colspan="6" class="text-center">No data availables in table</td>
										</tr>
									</tbody>
          						<?php
          					}

          					?>
          				</tbody>
          			</table>
          		</div>
			</div>
		</div>
		<!-- End Available orders -->

	</div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h4 class="box-title">Team Rules</h4>
                </div>
                <div class="box-body table-responsive no-padding" style="height: 420px; overflow: auto;">
                   <div class="container">
                       <p>Elite Boosters: Top Boosters , High WR , High Rank , Fast Order Completion ,</p>

                       <p>Tier 1: Verified Challenger</p>

                       <p>Tier 2: Verified Master 150+ LP CURRENT</p>

                       <p>Tier 2X: Verified past Master 150+LP Currently Above D1 but Under Master 150 LP.</p>

                       <p>Qualified: Qualified to see our Booster Chat , Orders , Claim Orders , Coach worthy.</p>

                       <p>Contributors: People who have donated to self-promote.</p>

                       <p>Girls Have Cooties: Girls , they don't have a big role on the server.</p>

                       <p>Friends: Friends of Danny/Admin , they can talk in #BoosterChat that is it.</p>

                       <p>Account Booster: Stocking D5 Accounts for potential future sale.</p>

                       <p>Trial Booster: Working on Stocking D5 Accounts until they are able to join a "Tier"</p>





                       <p>As a booster for Kattboost, you must abide every single one of these agreements. All must be followed and if any are broken under any circumstances, there will be consequences. (Listed Below)</p>



                       <p>You are not allowed to live stream games played on any of the customers accounts.
                           You must be able to speak English fluently and be able to have a microphone to talk through Discord or Skype whenever.
                           You are not allowed to spend any RP/IP on the customers account without their consent.
                           You are limited to one order at a time, two may be allowed if it is a boost with another booster on the same server or near the same divisions.
                           You are to follow instructions given by upper management at any time.
                           You are not to chat or talk with any of the customers friends without their consent.
                           Orders claimed by you must be able to come out with at least a 70% win rate. If you can't guarantee that, don't take the boost.
                           OFFLINE MODE is not required, but able to be used upon request.
                           You are able to use VPN at anytime during the boost. It is not a must , but if the customer does want VPN , you shall do as per request. (There was a ban wave a while ago about VPN usage, that's why it is not a must now).
                           Any fishy business done by you could end up in resulting as a deduction to pay.</p>

                       <p>Read More Below...</p>

                       <p>HOW TO CLAIM AN ORDER:</p>

                       <p>1. Login to our site with your user and password.
                           2. Check dashboard for active orders.
                           3. Click Apply to Claim order.</p>


                       <p>STARTING ON JUNE 1 , 2018:
                           General Rules:</p>

                       <p>1) Any action against KATTBOOST.COM will cause punishment.</p>

                       <p>2) Every team member need to refrain from:</p>

                       <p>actions which may interfere our services

                           actions that could violate the privacy of customers, boosters , and administrators

                           actions violating the good name and reputation of KATTBOOST

                           Admins reserve the rights to move team members rights based on the performance and state of the booster.</p>

                      <p> PENALTIES - WHAT YOU NEED TO MEMORIZE AND KEEP IN MIND AT ALL TIME AND HOW MUCH IT WILL COST YOU:</p>
                       <ul>
                           <li>- Being rude to the customer $20-KICK</li>

                           <li>- Not maintaining a 70% WR or higher on the SOLO Boost (If you can't do it , don't claim the order)$10-KICK</li>

                           <li>- Not messaging the customer about their order being claimed $5</li>

                           <li>- Not starting order within 60 minutes (you must play at least 3 games the day you claim) $10</li>

                           <li>- Leaking statistics and systems. $1000-KICK</li>

                           <li>- Using any sort of scripts, cheats, hacks $50-KICK</li>

                           <li>- Revealing yourself as a booster when working $50-KICK</li>

                           <li>- Breaking Summoner Rules $15-KICK</li>

                           <li>- Sharing any private contact while working $200-KICK</li>

                           <li>- Private Boosting a customer that asks for it $400-KICK</li>

                           <li>- Using Automatic Scripts to claim orders $20</li>

                           <li>- Wasting time on an order that has been in-progress for an over excessive amount of time $100-KICK</li>

                           <li>- Freezing / Pausing order without customer ackowledgment $50-KICK</li>

                           <li>- Not reporting something against KATTBOOST's ToS $200-KICK</li>

                           <li>- Not contacting admin when a problem occurs $30-KICK</li>

                           <li>- If a customer does not like you, and says you underperformed, a test viewing will occur. If admin decide you did not indeed play well : $5-KICK</li>

                           <li>- Getting an account banned due to breaking Summoner Code - $150-KICK</li>

                           <li>- When you claim an order you get deducted $5. After the order is complete, that amount goes back to 0. Like it never happened. This prevents false claiming for boosters.</li>
                       </ul>



                       <p>Administrators have the right to change any of above regulations and they do not need to give any reasons for such a change. If a change of rules and ToS occurs, a notification will go out to every team member.

                           Becoming one of our team members is equal to accepting the rules above. Breaking any rule , or not respecting any of the above rules will result in a punishment (fine or kick).</p>

                       <p>PAYMENTS:</p>
                       <p>Pay Day = Friday every week or every 3 days. (Time is usually around ~3PM EST and afterwards)

                           70% Payout to every team member that has contributed / done a boost or coach session during that week.

                           Payments will be the EXACT amount that is recorded down by admin (we have track) minus any penalty fee that you have received.

                           Payments will be sent through PAYPAL ONLY

                           Payments will be sent through FRIENDS AND FAMILY

                           Payments will have a fee deduction from Paypal if you do not live in Canada. ( This means that if you are to receive $10 and we send through friends and family, with a fee of $2.25 - You will receive $7.75).</p>

                       <p>CHAT RULES:
                           Greet the customer!</p>

                       <p>Be polite, your attitude is an important aspect for bringing customers back and showing off the reputation of KATTBOOST.COM.

                           Do not write to a customer about problems, he will not solve them, he or she will worry more instead, contact an admin instead!

                           Keep chatting professional and minimal.

                           Do not spam the customer or show any unprofessionalism.

                           Chatting is allowed when working , do not break the summoners code. DO NOT TALK IN ALL CHAT.
                       </p>
                       <p>By joining our team, you accept our Team Terms of Service.</p>
                   </div>
                </div>
            </div>
        </div>
    </div>
<?php $view->stop(); ?>

<?php $view->start('script'); ?>
	<script type="text/javascript">
        const newOrder = new Audio("http://uploads.twitchalerts.com/sound-defaults/magic-coins.ogg");

        <?php $hasServers = sizeof(\App\Repository\BoosterRepository::getInstance()->getServers()); ?>

        // Si le booster n'a pas de serveur entré, on cherche dans toutes les commandes
        // Sinon, on compte seulement les commandes avec ses serveurs
        <?php if ($hasServers > 0 && \App\Repository\BoosterRepository::getInstance()->seeCoachOrder()): ?>
            var precedent_available_orders = <?php echo \App\Repository\OrderRepository::getInstance()->countOrders("true"); ?>;
            var ajaxUrl = "<?php echo App\Router\Router::url('countOrders', ['servers' => 'true']); ?>";
        <?php elseif($hasServers > 0 && !\App\Repository\BoosterRepository::getInstance()->seeCoachOrder()): ?>
            var precedent_available_orders = <?php echo \App\Repository\OrderRepository::getInstance()->countOrders("true"); ?>;
            var ajaxUrl = "<?php echo App\Router\Router::url('countOrders', ['servers' => 'true']); ?>";
        <?php elseif($hasServers == 0 && \App\Repository\BoosterRepository::getInstance()->seeCoachOrder()): ?>
            var precedent_available_orders = <?php echo \App\Repository\OrderRepository::getInstance()->countOrders("false"); ?>;
            var ajaxUrl = "<?php echo App\Router\Router::url('countOrders', ['servers' => 'false']); ?>";
        <?php elseif($hasServers == 0 && \App\Repository\BoosterRepository::getInstance()->seeCoachOrder()): ?>
            var precedent_available_orders = <?php echo \App\Repository\OrderRepository::getInstance()->countOrders("false"); ?>;
            var ajaxUrl = "<?php echo App\Router\Router::url('countOrders', ['servers' => 'false']); ?>";
        <?php else: ?>
            var precedent_available_orders = <?php echo \App\Repository\OrderRepository::getInstance()->countOrders("false"); ?>;
            var ajaxUrl = "<?php echo App\Router\Router::url('countOrders', ['servers' => 'false']); ?>";
        <?php endif; ?>

        function notifyOrderChange() {
            $.ajax({
                type: 'GET',
                url: ajaxUrl,
                success: function(data, XHR)
                {
                    if (parseInt(data) !== parseInt(precedent_available_orders)) {
                        newOrder.play();
                        newOrder.onended = function () {
                            window.location.reload()
                        }
                    }
                },
                complete: function() {
                    // Schedule the next request when the current one's complete
                    setTimeout(notifyOrderChange, 2500);
                },
                error: function(xhr, status, error) {
                    console.info(xhr);
                    console.info(status);
                    console.info(error);
                }
            });
        }

        notifyOrderChange();
	</script>
<?php $view->stop(); ?>

<?php echo $view->render(); ?>