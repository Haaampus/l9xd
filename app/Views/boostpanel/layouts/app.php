<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo App\Config::WEBSITE_NAME . " - " . $this->title; ?></title>
    <link rel="icon" href="<?php echo asset('website_assets/img/favicon.ico'); ?>" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo asset('boostpanel_assets/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo asset('boostpanel_assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css'); ?>">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.3/css/fixedHeader.bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo asset('boostpanel_assets/bower_components/font-awesome/css/font-awesome.min.css'); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo asset('boostpanel_assets/bower_components/Ionicons/css/ionicons.min.css'); ?>">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo asset('boostpanel_assets/bower_components/select2/dist/css/select2.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo asset('boostpanel_assets/dist/css/AdminLTE.min.css'); ?>">
   <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo asset('boostpanel_assets/plugins/iCheck/square/blue.css'); ?>">
  <!-- Toastr -->
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <!-- App -->
  <link rel="stylesheet" type="text/css" href="<?php echo asset('boostpanel_assets/app.css'); ?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo asset('boostpanel_assets/dist/css/skins/skin-blue.min.css'); ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue layout-top-nav">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- header -->
  <?php require_once('header.php'); ?>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $this->page_title; ?>
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
      <?php echo $this->content; ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; 2018 <?php echo App\Config::URL; ?></strong> All rights
    reserved.
  </footer>

      
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo asset('boostpanel_assets/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<!-- SlimScroll -->
<script src="<?php echo asset('boostpanel_assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js'); ?>"></script>
<!-- FastClick -->
<script src="<?php echo asset('boostpanel_assets/bower_components/fastclick/lib/fastclick.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo asset('boostpanel_assets/dist/js/adminlte.min.js'); ?>"></script>
<!-- iCheck -->
<script src="<?php echo asset('boostpanel_assets/plugins/iCheck/icheck.min.js'); ?>"></script>
<!-- Toastr -->
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<!-- DataTables -->
<script src="<?php echo asset('boostpanel_assets/bower_components/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo asset('boostpanel_assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'); ?>"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.3/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js"></script>
<!-- Select2 -->
<script src="<?php echo asset('boostpanel_assets/bower_components/select2/dist/js/select2.full.min.js'); ?>"></script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })

  <?php if (App\Library\Session\Flash::exist('success')) { ?>
    toastr.success('<?php echo App\Library\Session\Flash::get('success'); ?>');
  <?php } else if (App\Library\Session\Flash::exist('error')) { ?>
    toastr.error('<?php echo App\Library\Session\Flash::get('error'); ?>');
  <?php } ?>

   $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
<?php echo $this->script; ?>
</body>
</html>
