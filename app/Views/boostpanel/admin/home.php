<?php $view = new App\Library\Template\Template('boostpanel.layouts.app', [
	'title' 	 => 'Dashboard',
	'page_title' => 'Dashboard'
	]); ?>

<?php $view->start('content'); ?>
	
	<div class="row">
		<!-- Boosters -->
		<div class="col-md-12">
			<div class="box box-danger collapsed-box">
					<div class="box-header with-border">
		  				<h3 class="box-title">Boosters</h3>
		  				<div class="box-tools pull-right">
		  					<span data-toggle="tooltip" title="<?php echo sizeof($boosters) . " booster(s)"; ?>" class="badge bg-red"><?php echo sizeof($boosters); ?></span>
		                	<button type="button" class="btn btn-box-tool" data-widget="collapse">
		                		<i class="fa fa-plus"></i>
		                	</button>
	              		</div>
		  			</div>
		  			<div class="box-body">
		  				<small>Tips : You can change a booster percentage by clicking on the number of his percentage and modify it.</small><br>
		  				<a href="<?php echo App\Router\Router::url('show_add_booster'); ?>" class="btn btn-primary" style="margin-bottom: 30px;">Add a booster</a>
		  				<table id="boosters_table" class="table table-bordered table-striped nowrap" style="width: 100%;">
		  					<thead>
		  						<tr>
		  							<th>Username</th>
		  							<th>Percentage</th>
		  							<th>Booster since</th>
		  							<th>Assigned order(s)</th>
		  							<th>Finished order(s)</th>
		  							<th></th>
		  						</tr>
		  					</thead>
		  					<tbody>
		  						<?php 
		  							if(isset($boosters) && !empty($boosters)) {
		  								foreach($boosters as $booster) {
		  									?>
												<tr>
													<td><?php echo ucfirst($booster['username']); ?></td>
													<td><span class="booster_percentage" id="<?php echo $booster['id']; ?>"><?php echo $booster['percentage']; ?></span> %</td>
													<td><?php echo date('F, Y', strtotime($booster['created_at'])); ?></td>
													<td>
                                                        <?php $assigned_orders = \App\Repository\AdminRepository::getInstance()->getBoosterOrderOf('assigned', $booster['id']); ?>
                                                        <?php echo $assigned_orders['count']; ?>
                                                    </td>
													<td>
                                                        <?php $finished_orderss = \App\Repository\AdminRepository::getInstance()->getBoosterOrderOf('finished', $booster['id']); ?>
                                                        <?php echo $finished_orderss['count']; ?>
                                                    </td>
													<td class="text-center">
                                                        <a href="<?php echo App\Router\Router::url('booster_edit', ['id' => $booster['id']]); ?>" class="btn btn-xs btn-primary">Edit</a>
														<a href="<?php echo App\Router\Router::url('booster_delete', ['id' => $booster['id']]); ?>" class="btn btn-xs btn-danger">Delete</a>
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
		</div>
		<!-- End Boosters -->

	</div><!-- /.row -->

	<div class="row">

		<!-- Running Orders -->
		<div class="col-md-6">
			<div class="box box-success">
				<div class="box-header with-border">
		  			<h3 class="box-title">Running Orders</h3>
		  			<div class="box-tools pull-right">
		  				<span data-toggle="tooltip" title="<?php echo sizeof($running_orders) . " running order(s)"; ?>" class="badge bg-green"><?php echo sizeof($running_orders); ?></span>
		  			</div>
		  		</div>
		  		<div class="box-body">
					<table id="running_orders_table" class="table table-bordered table-striped nowrap" style="width: 100%;">
		  					<thead>
		  						<tr>
		  							<th>ID</th>
		  							<th>Booster</th>
		  							<th>Description</th>
		  							<th>Price</th>
                                    <th>My earning</th>
                                    <th>Server</th>
		  							<th>Purchase Date</th>
		  							<th></th>
		  						</tr>
		  					</thead>
		  					<tbody>
		  						<?php
		  							if(isset($running_orders) && !empty($running_orders)) {
		  								foreach($running_orders as $running_order) {
		  									?>
												<tr>
													<td><?php echo $running_order['id']; ?></td>
													<td><?php echo $running_order['username']; ?></td>
													<td>
                                                        <?php if (!strpos($running_order['type'], 'Coaching')): ?>
                                                            <span class="boost-box orange"><?php echo $running_order['queue']; ?> queue</span>
                                                            <span class="boost-box <?php echo $running_order['duo'] ? 'red' : 'blue'; ?>"><?php displayDescriptionSpan($running_order); ?></span>
                                                        <?php else: ?>
                                                            <span class="boost-box orange">Coaching</span>
                                                        <?php endif; ?>
                                                        <?php displayDescription($running_order); ?>
													</td>
													<td><?php echo $running_order['price'] . " " . $running_order['currency']; ?></td>
                                                    <td><?php if ($running_order['booster_price']): ?>
                                                            <?php echo $running_order['price'] - $running_order['booster_price']; ?>
                                                        <?php else: ?>
                                                            <?php echo $running_order['price'] - calcPrice($running_order['price'], $running_order['percentage'], true); ?>
                                                        <?php endif; ?>
                                                        <?php echo $running_order['currency']; ?></td>
                                                    <td><?php echo $running_order['server']; ?></td>
                                                    <td><?php echo date('d/m/Y h:i:s', strtotime($running_order['created_at'])); ?></td>
													<td>
                                                        <a href="<?php echo App\Router\Router::url('order', ['order_id' => $running_order['id']]); ?>" target="_blank" class="btn btn-xs btn-primary">See</a>
														<a href="" data-id="<?php echo $running_order['id']; ?>" data-toggle="modal" data-target="#modal-assign-booster" class="btn btn-xs btn-info">Re-assign to a booster</a>
														<a href="<?php echo App\Router\Router::url('drop_order', ['order_id' => $running_order['id']]); ?>" class="btn btn-xs btn-danger">Drop this order</a>
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
		</div>
		<!-- End Running Orders -->	
		
		<!-- Pending Orders -->
		<div class="col-md-6">
			<div class="box box-info">
				<div class="box-header with-border">
		  			<h3 class="box-title">Pending Orders</h3>
		  			<div class="box-tools pull-right">
		  				<span data-toggle="tooltip" title="<?php echo sizeof($pending_orders) . " pending order(s)"; ?>" class="badge bg-blue"><?php echo sizeof($pending_orders); ?></span>
		  			</div>
		  		</div>
		  		<div class="box-body">
		  			<a href="<?php echo App\Router\Router::url('show_add_order'); ?>" class="btn btn-success" style="margin-bottom: 30px;">Add an order</a>
					<table id="pending_orders_table" class="table table-bordered table-striped nowrap" style="width: 100%;">
		  					<thead>
		  						<tr>
		  							<th>ID</th>
		  							<th>Description</th>
		  							<th>Price</th>
                                    <th>Server</th>
		  							<th>Purchase Date</th>
		  							<th></th>
		  						</tr>
		  					</thead>
		  					<tbody>
		  						<?php
		  							if(isset($pending_orders) && !empty($pending_orders)) {
		  								foreach($pending_orders as $pending_order) {
		  									?>
												<tr>
													<td><?php echo $pending_order['id']; ?></td>
													<td>
														<?php if (!strpos($pending_order['type'], 'Coaching')): ?>
														    <span class="boost-box orange"><?php echo $pending_order['queue']; ?> queue</span>
                                                            <span class="boost-box <?php echo $pending_order['duo'] ? 'red' : 'blue'; ?>"><?php displayDescriptionSpan($pending_order); ?></span>
                                                        <?php else: ?>
                                                            <span class="boost-box orange">Coaching</span>
                                                        <?php endif; ?>
														<?php displayDescription($pending_order); ?>
													</td>
													<td><?php echo $pending_order['price'] . " " . $pending_order['currency']; ?></td>
                                                    <td><?php echo $pending_order['server']; ?></td>
                                                    <td><?php echo date('d/m/Y h:i:s', strtotime($pending_order['created_at'])); ?></td>
													<td>
														<a href="" data-id="<?php echo $pending_order['id']; ?>" data-toggle="modal" data-target="#modal-assign-booster" class="btn btn-xs btn-info">Assign to a booster</a>
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
		</div>
		<!-- End Pending Orders -->
	</div><!-- /.row -->

    <div class="row">

        <!-- Finished Orders -->
        <div class="col-xs-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Finished Orders</h3>
                    <div class="box-tools pull-right">
                        <span data-toggle="tooltip" title="<?php echo sizeof($finished_orders) . " finished order(s)"; ?>" class="badge bg-red"><?php echo sizeof($finished_orders); ?></span>
                    </div>
                </div>
                <div class="box-body">
                    <table id="finished_orders_table" class="table table-bordered table-striped nowrap" style="width: 100%;">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Description</th>
                            <th>Customer OPGG</th>
                            <th>Purchase Date</th>
                            <th>Finished at</th>
                            <th>Booster <br>Paypal</th>
                            <th>Booster Price</th>
                            <th>My earning</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(isset($finished_orders) && is_array($finished_orders) && sizeof($finished_orders) > 0 && !empty($finished_orders)) {
                            foreach($finished_orders as $finished_order) {
                                ?>
                                <tr>
                                    <td><?php echo $finished_order['id']; ?></td>
                                    <td>
                                        <?php if (!strpos($finished_order['type'], 'Coaching')): ?>
                                            <span class="boost-box orange"><?php echo $finished_order['queue']; ?> queue</span>
                                            <span class="boost-box <?php echo $finished_order['duo'] ? 'red' : 'blue'; ?>"><?php displayDescriptionSpan($finished_order); ?></span>
                                        <?php else: ?>
                                            <span class="boost-box orange">Coaching</span>
                                        <?php endif; ?>
                                        <?php displayDescription($finished_order); ?>
                                    </td>
                                    <td><a target="_blank" href="<?php echo App\Repository\OrderRepository::getInstance()->getCustomerOPGG($finished_order['id']); ?>">Customer OPGG</a></td>
                                    <td><?php echo date('d/m/Y h:i:s', strtotime($finished_order['created_at'])); ?></td>
                                    <td><?php echo date('d/m/Y h:i:s', strtotime($finished_order['finished_at'])); ?></td>
                                    <td><?php echo ucfirst($finished_order['username']); ?> <br /><?php if($finished_order['paypal']) { echo $finished_order['paypal']; }else { echo 'PAYPAL NOT SET'; } ?></td>
                                    <td><?php calcPrice($finished_order['price'], $finished_order['percentage']); ?> <?php echo $finished_order['currency']; ?></td>
                                    <td>
                                        <?php if ($finished_order['booster_price']): ?>
                                            <?php echo $finished_order['price'] - $finished_order['booster_price']; ?>
                                        <?php else: ?>
                                            <?php echo $finished_order['price'] - calcPrice($finished_order['price'], $finished_order['percentage'], true); ?>
                                        <?php endif; ?>
                                        <?php echo $finished_order['currency']; ?>
                                    </td>
                                    <td style="white-space: pre-line;">
                                        <a href="<?php echo App\Router\Router::url('paid_booster', ['order_id' => $finished_order['id']]); ?>" class="btn btn-xs btn-success">I paid the booster</a>
                                        <a href="<?php echo App\Router\Router::url('drop_order', ['order_id' => $finished_order['id']]); ?>" class="btn btn-xs btn-danger">Drop this order</a>
                                        <a href="" data-id="<?php echo $finished_order['id']; ?>" data-toggle="modal" data-target="#modal-assign-booster" class="btn btn-xs btn-info">Re-assign to a booster</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th style="text-align:right" colspan="6" rowspan="1">Total of displayed lines : <br> Total overall :</th>
                            <th rowspan="1" colspan="1"></th>
                            <th rowspan="1" colspan="1"></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Finished Orders -->

    </div><!-- /.row -->

    <div class="row">

        <!-- Finished Orders -->
        <div class="col-xs-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Paid Orders</h3>
                    <div class="box-tools pull-right">
                        <span data-toggle="tooltip" title="<?php echo sizeof($paid_orders) . " paid order(s)"; ?>" class="badge bg-orange"><?php echo sizeof($paid_orders); ?></span>
                    </div>
                </div>
                <div class="box-body">
                    <table id="paid_orders_table" class="table table-bordered table-striped nowrap" style="width: 100%;">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Description</th>
                            <th>Customer OPGG</th>
                            <th>Purchase Date</th>
                            <th>Finished at</th>
                            <th>Booster <br> Paypal</th>
                            <th>Booster Price</th>
                            <th>My earning</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(isset($paid_orders) && !empty($paid_orders)) {
                            foreach($paid_orders as $paid_order) {
                                ?>
                                <tr>
                                    <td><?php echo $paid_order['id']; ?></td>
                                    <td>
                                        <?php if (!strpos($paid_order['type'], 'Coaching')): ?>
                                            <span class="boost-box orange"><?php echo $paid_order['queue']; ?> queue</span>
                                            <span class="boost-box <?php echo $paid_order['duo'] ? 'red' : 'blue'; ?>"><?php displayDescriptionSpan($paid_order); ?></span>
                                        <?php else: ?>
                                            <span class="boost-box orange">Coaching</span>
                                        <?php endif; ?>
                                        <?php displayDescription($paid_order); ?>
                                    </td>
                                    <td><a target="_blank" href="<?php echo App\Repository\OrderRepository::getInstance()->getCustomerOPGG($paid_order['id']); ?>">Customer OPGG</a></td>
                                    <td><?php echo date('d/m/Y h:i:s', strtotime($paid_order['created_at'])); ?></td>
                                    <td><?php echo date('d/m/Y h:i:s', strtotime($paid_order['finished_at'])); ?></td>
                                    <td><?php echo ucfirst($paid_order['username']); ?> <br /> <?php if($paid_order['paypal']) { echo $paid_order['paypal']; }else { echo 'PAYPAL NOT SET'; } ?></td>
                                    <td>
                                        <?php if ($paid_order['booster_price']): ?>
                                            <?php echo $paid_order['booster_price']; ?>
                                        <?php else: ?>
                                            <?php calcPrice($paid_order['price'], $paid_order['percentage']); ?>
                                        <?php endif; ?>
                                        <?php echo $paid_order['currency']; ?>
                                    </td>
                                    <td>
                                        <?php if ($paid_order['booster_price']): ?>
                                            <?php echo $paid_order['price'] - $paid_order['booster_price']; ?>
                                        <?php else: ?>
                                            <?php echo $paid_order['price'] - calcPrice($paid_order['price'], $paid_order['percentage'], true); ?>
                                        <?php endif; ?>
                                        <?php echo $paid_order['currency']; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                            <tfoot>
                                <tr>
                                    <th style="text-align:right" colspan="6" rowspan="1">Total of displayed lines : <br> Total overall :</th>
                                    <th rowspan="1" colspan="1"></th>
                                    <th rowspan="1" colspan="1"></th>
                                </tr>
                            </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Finished Orders -->

    </div><!-- /.row -->
	
	<!-- Modal Assign to a booster -->
	<div class="modal fade" id="modal-assign-booster" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="modal-title"></h4>
              </div>
              <div class="modal-body text-center">
                <form id="assign_form" action="<?php echo App\Router\Router::url('assign_order'); ?>" method="POST">
                	<div class="form-group">
                		<label>Order ID</label>
                		<input type="text" class="form-control" name="order_id" id="input_order_id" readonly>
                	</div>
                	<div class="form-group">
                		<label>Booster</label>
                		<select name="order_booster" class="form-control select2" style="width: 100%;">
                			<?php if(isset($boosters) && !empty($boosters)) {
                				foreach($boosters as $booster) {
                					$option = "<option value='";
                					$option .= $booster['id'] . "'>";
                					$option .= ucfirst($booster['username']) . "</option>";
                					echo $option;
                				}
                			}
                			?>
                		</select>
                	</div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="assign_button">Assign</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
	<!-- End Modal assign to a booster -->
<?php $view->stop(); ?>

<?php $view->start('script'); ?>
	<script type="text/javascript">
		//Initialize Select2 Elements
    	$('.select2').select2()

		$('#boosters_table').DataTable({
			responsive: true
		});

		$('#pending_orders_table').DataTable({
			responsive: true
		});

        $('#finished_orders_table').DataTable({
            //responsive: true
            "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
                var nCells = nRow.getElementsByTagName('th');

                var booster_total = 0;
                var earning_total = 0;
                for ( var i=0 ; i<aaData.length ; i++ )
                {
                    booster_total += parseFloat(aaData[i][6].replace(/[^\d.-]/g, ''));
                    earning_total += parseFloat(aaData[i][7].replace(/[^\d.-]/g, ''));
                }

                var booster = 0;
                var earning = 0;
                for ( var i=iStart ; i<iEnd ; i++ )
                {
                    booster += parseFloat(aaData[aiDisplay[i]][6].replace(/[^\d.-]/g, ''));
                    earning += parseFloat(aaData[aiDisplay[i]][7].replace(/[^\d.-]/g, ''));
                }

                nCells[1].innerHTML = '$' + Math.round(parseFloat(booster) * 100) / 100 + '<br />' + '$' + Math.round(parseFloat(booster_total) * 100) / 100;
                nCells[2].innerHTML = '$' + Math.round(parseFloat(earning) * 100) / 100 + '<br />' + '$' + Math.round(parseFloat(earning_total) * 100) / 100;
            }
        });

        $('#paid_orders_table').DataTable({
            //responsive: true,
            "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
                var nCells = nRow.getElementsByTagName('th');

                var booster_total = 0;
                var earning_total = 0;
                for ( var i=0 ; i<aaData.length ; i++ )
                {
                    booster_total += parseFloat(aaData[i][6].replace(/[^\d.-]/g, ''));
                    earning_total += parseFloat(aaData[i][7].replace(/[^\d.-]/g, ''));
                }

                var booster = 0;
                var earning = 0;
                for ( var i=iStart ; i<iEnd ; i++ )
                {
                    booster += parseFloat(aaData[aiDisplay[i]][6].replace(/[^\d.-]/g, ''));
                    earning += parseFloat(aaData[aiDisplay[i]][7].replace(/[^\d.-]/g, ''));
                }

                nCells[1].innerHTML = '$' + Math.round(parseFloat(booster) * 100) / 100 + '<br />' + '$' + Math.round(parseFloat(booster_total) * 100) / 100;
                nCells[2].innerHTML = '$' + Math.round(parseFloat(earning) * 100) / 100 + '<br />' + '$' + Math.round(parseFloat(earning_total) * 100) / 100;
            }
        });

		// Change percentage with a click
		$('#boosters_table').on('click', '.booster_percentage', function () {
			var $el = $(this);
			var $id = $(this).attr('id');

			var $input = $('<input type="number" min="0" max="100" />').val($el.text());
			$el.replaceWith($input);

			// Save into database
			function save() {
				if ($input.val() >= 0 && $input.val() <= 100) {
					var $span = $('<span class="booster_percentage" />').text($input.val());
					$input.replaceWith($span);

					// Save into database
					$.ajax({
						url: '<?php echo App\Router\Router::url('post_change_percentage'); ?>',
						method: "POST",
						data: {id: $id, percentage: $input.val()}
					});
				}
			};

			$input.keypress(function(e) {
				if (e.which == 13) {
					save();
				}
			});

			$input.one('blur', save).focus();
		});

		$('#running_orders_table').DataTable({
			responsive: true
		});

		$('[data-toggle="tooltip"]').tooltip()

		$('#modal-assign-booster').on('show.bs.modal', function(e) {
		  var order_id = $(e.relatedTarget).data('id');
		  document.getElementById('modal-title').innerHTML = "Assign to a booster : " + order_id;
		  $("#input_order_id").val(order_id);
		});

		$('#assign_button').on('click', function() {
			document.getElementById('assign_form').submit();
		});
	</script>
<?php $view->stop(); ?>


<?php echo $view->render(); ?>