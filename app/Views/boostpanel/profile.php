<?php $view = new App\Library\Template\Template('boostpanel.layouts.app', [
	'title' 	 => 'Your Profile',
	'page_title' => 'Manage your profile'
	]); ?>


<?php $view->start('content'); ?>

		<form action="<?php echo App\Router\Router::url('profile.post'); ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
			<div class="form-group">
				<label>Your avatar</label>
				<input type="file" name="avatar" class="form-control">
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<label>Edit your E-mail</label>
					<input type="email" name="email" class="form-control">
				</div>
				<div class="form-group col-md-6">
					<label>Edit your password</label>
					<input type="password" name="password" class="form-control">
				</div>
			</div>
			<?php if ($type === "booster") {
					?>
					<div class="form-group">
						<label>Edit your Paypal Email</label>
						<input type="email" name="paypal" class="form-control" value="<?php if(isset($paypal) && !empty($paypal)) { echo $paypal; } ?>">
					</div>
                    <div class="form-group">
                        <label>Server(s) you play on</label>
                        <select name="servers_played[]" class="form-control select2" multiple="multiple" data-placeholder="Select server(s)">
                            <?php foreach (\App\Config::SERVERS as $server) {
                                $option = "<option value='";
                                $option .= $server . "' ";

                                if (App\Repository\BoosterRepository::getInstance()->playOnServer($server)) {
                                    $option .= "selected>";
                                } else {
                                    $option .= ">";
                                }

                                $option .= $server . "</option>";
                                echo $option;
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="coach">
                            <input type="hidden" name="before_coach" value="<?php if(isset($coach) && !empty($coach)) { echo 1; } else { echo 0; } ?>">
                            <input type="checkbox" class="form-control" name="coach" id="coach" <?php if(isset($coach) && !empty($coach)) { echo "checked"; } ?>>
                            See coach orders ?
                        </label>
                    </div>
				<?php
				}
				?>
			<button type="submit" class="btn btn-primary">Update my profile</button>
		</form>

		<?php
			if ($type === "booster") {
				?>
						<div class="box box-info" style="margin-top: 50px;">
							<div class="box-header with-border">
						  		<h4 class="box-title">Payment History</h4>
			          		</div>
			          		<div class="box-body">
			          			<table id="payment_history" class="table table-bordered table-striped nowrap" style="width: 100%;">
				  					<thead>
				  						<tr>
				  							<th>Order ID</th>
				  							<th>Service</th>
				  							<th>Finished At</th>
				  							<th>Amount</th>
				  							<th>Status</th>
				  						</tr>
				  					</thead>
				  					<tbody>
				  						<?php if(isset($finished_orders) && !empty($finished_orders)) {
				  							foreach($finished_orders as $finished_order) {
				  								?>
													<tr>
														<td><?php echo $finished_order['id']; ?></td>
														<td>
															<span class="boost-box orange"><?php echo $finished_order['queue']; ?> queue</span>
															<span class="boost-box <?php echo $finished_order['duo'] ? 'red' : 'blue'; ?>">
																<?php displayDescriptionSpan($finished_order); ?>
															</span>
															<?php displayDescription($finished_order); ?>
														</td>
														<td><?php echo date('d/m/Y h:i:s', strtotime($finished_order['finished_at'])); ?></td>
														<td><?php echo calcPrice($finished_order['price'], App\Repository\BoosterRepository::getInstance()->getPercentage($_SESSION['user']['id'])); ?> <?php echo $finished_order['currency']; ?></td>
														<td>
															<?php if($finished_order['status'] === 2) {
																echo 'Not payed yet.';
															} else if ($finished_order['status'] === 3) {
																echo 'Paid';
															}
															?>
														</td>
													</tr>
				  								<?php
				  							}
				  						}
				  						?>
				  					</tbody>
		  						</table>
			          		</div>
			          	</div>
				<?php
			}
		?>

<?php $view->stop(); ?>

<?php $view->start('script'); ?>
	<script type="text/javascript">
		$('#payment_history').DataTable({
			responsive: true
		});
        //Initialize Select2 Elements
        $('.select2').select2();
	</script>
<?php $view->stop(); ?>

<?php echo $view->render(); ?>