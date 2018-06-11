<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo App\Config::WEBSITE_NAME; ?> - Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="boostpanel_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="boostpanel_assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="boostpanel_assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="boostpanel_assets/dist/css/AdminLTE.min.css">
   <!-- Toastr -->
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
      <a href="<?php echo App\Router\Router::url('home'); ?>">
          <img src="<?php echo asset('website_assets/img/logo.png'); ?>" style="max-width: 140px; height: auto" alt="L9 ELO BOOSTING LOGO">
      </a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
	
	<!-- Error message -->
	<?php 
		if (App\Library\Session\Flash::exist('login')) { ?>
			<div class="callout callout-danger">
				<p><?php echo App\Library\Session\Flash::get('login'); ?></p>
			</div>
	<?php					
		} 
	?>
	<!-- /Error message -->

	<!-- Form -->
	<?php 
  
		$login = new App\Library\FormBuilder\FormBootstrap('login.post');
			$login->add('text', 'username', true, 'Username :', ['placeholder' => 'Username'])->required()->autofocus()->keepValue()
				  ->add('password', 'password', true, 'Password : ', ['placeholder' => 'Password'])->required()
				  ->submit('Sign in', ['class' => 'btn btn-primary btn-block btn-flat']);
			$login->createForm();

	?>
	<!-- /form -->

	<!-- <br>
    <a href="#">I forgot my password</a><br>
    <a href="#" class="text-center">Register a new membership</a> -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="boostpanel_assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="boostpanel_assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Toastr -->
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript">
    <?php if (App\Library\Session\Flash::exist('success')) { ?>
    toastr.success('<?php echo App\Library\Session\Flash::get('success'); ?>');
    <?php } else if (App\Library\Session\Flash::exist('error')) { ?>
      toastr.error('<?php echo App\Library\Session\Flash::get('error'); ?>');
    <?php } ?>
</script>
</body>
</html>
