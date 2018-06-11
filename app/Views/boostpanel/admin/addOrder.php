<?php $view = new App\Library\Template\Template('boostpanel.layouts.app', [
	'title' 	 => 'Add an order',
	'page_title' => 'Add an order'
	]); ?>

<?php $view->start('content'); ?>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-default">
				<div class="box-header with-border">
		  			<h3 class="box-title">Add</h3>
		  		</div>
		  		<div class="box-body">
		  			<small>You need to create a user first (if you don't have one already), then you have to choose a user, then you can
		  			create your order.<br>
		  			(User created here, will receive an email with the login and password)</small>
		  			<div class="row" style="margin-top: 30px">

		  				<!-- Create an user -->
		  				<div class="col-md-4">
		  					<?php

			  				$user = new App\Library\FormBuilder\FormBootstrap('post_add_user_order');
								$user->add('text', 'username', true, 'Username :', ['placeholder' => 'Username'])
									->required()
									->keepValue()
									  ->add('email', 'email', true, 'Email :', ['placeholder' => 'Email'])
									  	->required()
									  	->keepValue()
									  ->add('text', 'password', true, 'Password : ', ['placeholder' => 'Password', 'value' => randomPassword()])
									  	->required()
									  	->keepValue()
									  ->submit('Create User', ['class' => 'btn btn-primary']);
								$user->createForm();

		  					?>
		  				</div>
		  				<!-- End Create an User -->

		  				<!-- Create an order -->
		  				<div class="col-md-4 text-center">
		  					<form action="<?php echo App\Router\Router::url('post_add_order'); ?>" method="POST" id="add_order_form">
		  						<div class="form-group">
		  							<label for="select_user">Select an user</label>
									<select name="order_selected_user" id="select_user" class="form-control select2">
										<option disabled selected></option>
										<?php
					                  	if (isset($users) && !empty($users)) {
					                  		foreach ($users as $user) {
					                  			$option = "<option value='";
					                  			$option .= $user['id'] . "'>";
					                  			$option .= ucfirst($user['username']) . "</option>";
					                  			echo $option;
					                  		}
					                  	}
					                  ?>
									</select>
		  						</div>

								<div id="order-block" style="display: none;">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Order type</label>
												<select name="order_type" class="form-control" id="order_type" onchange="getOrderDetailsForm()">
													<option disabled selected></option>
													<option value="Division Boost">Division Boost</option>
													<option value="Net Wins">Net Wins</option>
													<option value="Placement Matches">Placement Matches</option>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Order queue</label>
												<select name="order_queue" class="form-control">
													<option value="Solo/Duo">Solo/Duo</option>
													<option value="Flex (5v5)">Flex (5v5)</option>
													<option value="Flex (3v3)">Flex (3v3)</option>
												</select>
											</div>
										</div>
									</div> <!-- /.row -->
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label>Solo / Duo Boost ?</label>
												<select name="order_duo" class="form-control">
													<option value="Solo Boost">Solo Boost</option>
													<option value="Duo Boost">Duo Boost</option>
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Price</label>
												<input type="number" step="0.01" min="0" id="order_price" name="order_price" class="form-control" placeholder="24.78" required>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Currency</label>
												<input type="text" max="10" id="order_currency" name="order_currency" class="form-control" required>
											</div>
										</div>
									</div><!-- /.row -->
								</div>
		  				</div>
		  				<!-- End Create an order -->

		  				<!-- Create order details -->
		  				<div class="col-md-4 text-center">
		  					<div id="order_division_boost" style="display: none;">
		  						<div class="row">
		  							<div class="col-md-6">
		  								<div class="form-group">
		  									<label>Start league</label>
		  									<select name="order_details_start_league" class="form-control">
		  										<option value="Bronze">Bronze</option>
		  										<option value="Silver">Silver</option>
		  										<option value="Gold">Gold</option>
		  										<option value="Platinum">Platinum</option>
		  										<option value="Diamond">Diamond</option>
		  										<option value="Master">Master</option>
		  										<option value="Challenger">Challenger</option>
		  									</select>
		  								</div>
		  							</div>
		  							<div class="col-md-6">
		  								<div class="form-group">
		  									<label>Desired League</label>
		  									<select name="order_details_desired_league" class="form-control">
		  										<option value="Bronze">Bronze</option>
		  										<option value="Silver" selected>Silver</option>
		  										<option value="Gold">Gold</option>
		  										<option value="Platinum">Platinum</option>
		  										<option value="Diamond">Diamond</option>
		  										<option value="Master">Master</option>
		  										<option value="Challenger">Challenger</option>
		  									</select>
		  								</div>
		  							</div>
		  						</div> <!-- /.row -->
		  						<div class="row">
		  							<div class="col-md-6">
		  								<div class="form-group">
		  									<label>Start division</label>
		  									<select name="order_details_start_division" class="form-control">
		  										<option value="V">V</option>
		  										<option value="IV">IV</option>
		  										<option value="III">III</option>
		  										<option value="II">II</option>
		  										<option value="I">I</option>
		  									</select>
		  								</div>
		  							</div>
		  							<div class="col-md-6">
		  								<div class="form-group">
		  									<label>Start division</label>
		  									<select name="order_details_desired_division" class="form-control">
		  										<option value="V">V</option>
		  										<option value="IV">IV</option>
		  										<option value="III">III</option>
		  										<option value="II">II</option>
		  										<option value="I">I</option>
		  									</select>
		  								</div>
		  							</div>
		  						</div><!-- /.row -->
		  						<div class="row">
		  							<div class="col-md-6">
		  								<div class="form-group">
		  									<label>Start League Points</label>
		  									<select name="order_details_start_league_points" class="form-control">
		  										<option value="0-20">0-20</option>
		  										<option value="21-40">21-40</option>
		  										<option value="41-60">41-60</option>
		  										<option value="61-80">61-80</option>
		  										<option value="81-99">81-99</option>
		  										<option value="100">100</option>
		  									</select>
		  								</div>
		  							</div>
		  						</div>
		  						<button type="submit" class="btn btn-block btn-flat btn-primary">Create</button>
		  					</div>

		  					<div id="order_net_wins" style="display: none;">
		  						<div class="row">
		  							<div class="col-md-6">
		  								<div class="form-group">
		  									<label>Start league</label>
		  									<select name="order_details_net_wins_start_league" class="form-control">
		  										<option value="Bronze">Bronze</option>
		  										<option value="Silver">Silver</option>
		  										<option value="Gold">Gold</option>
		  										<option value="Platinum">Platinum</option>
		  										<option value="Diamond">Diamond</option>
		  										<option value="Master">Master</option>
		  										<option value="Challenger">Challenger</option>
		  									</select>
		  								</div>
		  							</div>
		  							<div class="col-md-6">
		  								<div class="form-group">
		  									<label>Amount of games</label>
		  									<input type="number" name="order_details_net_wins_amount_of_games" class="form-control" min="0">
		  								</div>
		  							</div>
		  						</div> <!-- /.row -->
		  						<div class="row">
		  							<div class="col-md-6">
		  								<div class="form-group">
		  									<label>Start division</label>
		  									<select name="order_details_net_wins_start_division" class="form-control">
		  										<option value="V">V</option>
		  										<option value="IV">IV</option>
		  										<option value="III">III</option>
		  										<option value="II">II</option>
		  										<option value="I">I</option>
		  									</select>
		  								</div>
		  							</div>
		  						</div><!-- /.row -->
		  						<div class="row">
		  							<div class="col-md-6">
		  								<div class="form-group">
		  									<label>Start League Points</label>
		  									<select name="order_details_net_wins_start_league_points" class="form-control">
		  										<option value="0-20">0-20</option>
		  										<option value="21-40">21-40</option>
		  										<option value="41-60">41-60</option>
		  										<option value="61-80">61-80</option>
		  										<option value="81-99">81-99</option>
		  										<option value="100">100</option>
		  									</select>
		  								</div>
		  							</div>
		  						</div>
		  						<button type="submit" class="btn btn-block btn-flat btn-primary">Create</button>
							</div>

							<div id="order_placement_matches" style="display: none;">
								<div class="form-group">
									<label>Amount of games</label>
									<select name="order_details_placement_amount_of_games" class="form-control">
										<?php for ($i = 1 ; $i <= 10 ; $i++) {
											?>
											<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
											<?php
										}
										?>
									</select>
								</div>
								<button type="submit" class="btn btn-block btn-flat btn-primary">Create</button>
							</div>
		  					</form>
		  				</div>
		  				<!-- End create order details -->

		  			</div> <!-- /.row -->
		  		</div>
			</div>
		</div>
	</div>

<?php $view->stop(); ?>

<?php $view->start('script'); ?>
	<script type="text/javascript">
		//Initialize Select2 Elements
    	$('.select2').select2();
    	$('.select2').on("select2:selecting", function(e) {
    		getOrderForm();
    	});

    	// Tooltip on inputs
    	$('#order_price').tooltip({'trigger':'focus', 'title':'You can use decimal number, use a "." between numbers.'});
    	$('#order_currency').tooltip({'trigger':'focus', 'title':'As currency, you can set it with letters like "EUR", "USD" ; or with the symbol : "€", "$", your choice.'});

		function getOrderForm() {
			$('#order-block').css('display','block');
			document.getElementById('add_order_form').reset();
			$('#order_division_boost').css('display','none');
			$('#order_net_wins').css('display','none');
			$('#order_placement_matches').css('display','none');
		}

		function getOrderDetailsForm() {
			var select = document.getElementById('order_type');
			var selected_option = select.options[select.selectedIndex].text;
			if (selected_option === "Division Boost") {
				$('#order_division_boost').css('display', 'block');
				$('#order_net_wins').css('display','none');
				$('#order_placement_matches').css('display','none');
			} else if (selected_option === "Net Wins") {
				$('#order_net_wins').css('display','block');
				$('#order_placement_matches').css('display','none');
				$('#order_division_boost').css('display','none');
			} else if (selected_option === "Placement Matches") {
				$('#order_placement_matches').css('display','block');
				$('#order_division_boost').css('display','none');
				$('#order_net_wins').css('display','none');
			}
		}

	</script>
<?php $view->stop(); ?>

<?php echo $view->render(); ?>