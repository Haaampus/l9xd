<?php $view = new App\Library\Template\Template('boostpanel.layouts.app', [
	'title' 	 => 'Add a booster',
	'page_title' => 'Add a booster'
	]); ?>

<?php $view->start('content'); ?>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-default">
				<div class="box-header with-border">
		  			<h3 class="box-title">Add</h3>
		  		</div>
		  		<div class="box-body">
		  			<small>You have to create a user, then you can add this user to the booster group. 
		  				<br>You can add several users to booster group at once.
		  				<br>By default, boosters have 50% percentage, and they have to set their paypal Email on their account.
		  				<br>An email will be send to the user with his password (if you create an user)</small>
		  			<div class="row" style="margin-top: 30px;">
		  				<div class="col-md-6">
		  					<?php

			  				$user = new App\Library\FormBuilder\FormBootstrap('post_add_user');
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
		  				<div class="col-md-6">
		  					<form action="<?php echo App\Router\Router::url('post_add_booster'); ?>" method="POST">
		  						<div class="form-group">
									<label>Add to booster</label>
					                <select class="form-control select2" name="add_to_booster[]" multiple="multiple" data-placeholder="Select users"
					                        style="width: 100%;">
					                  <?php
					                  	if (isset($users) && !empty($users)) {
					                  		foreach ($users as $user) {
					                  			$option = "<option value='";
					                  			$option .= $user['username'] . "'>";
					                  			$option .= ucfirst($user['username']) . "</option>";
					                  			echo $option;
					                  		}
					                  	}
					                  ?>
					                </select>
								</div>
								<button type="submit" class="btn btn-primary">Add to booster</button>
		  					</form>
		  				</div>
		  			</div> <!-- /.row -->
		  		</div>
			</div>
		</div>
	</div>

<?php $view->stop(); ?>

<?php $view->start('script'); ?>
	<script type="text/javascript">
		//Initialize Select2 Elements
    	$('.select2').select2()
	</script>
<?php $view->stop(); ?>

<?php echo $view->render(); ?>