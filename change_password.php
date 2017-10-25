<?php

	if(!isset($_SESSION)){
		session_start();

	include 'core/init.php';
	include 'core/helper/myHelper.php';
	include 'assets/alert/alert.php';	 

	$id_user = $_POST['id'];
	$old_password = md5($_POST['old_password']);
	
	$login = $db->users()->where("password", $old_password)
						->where("id", $id_user)
						->fetch();

	$body = 'change-password';

	$op = $_POST['old_password'];
	$np = $_POST['new_password'];
	$cnp = $_POST['confirm_new_password'];

	if (empty($op) || empty($np) || empty($cnp)) {
		echo "<button id='btnShowAlert' style='display:none;'></button>
			<script type='text/javascript'>
				sweetAlert({
					title: 'Error!',
					text: 'Pastikan Tidak Ada Field Yang Kosong!',
					type: 'error'
				},
				function () {
					window.location.href = 'change-password.php';
				});
			</script>";
		exit();
	}

	if ($np !== $cnp) {
		echo "<button id='btnShowAlert' style='display:none;'></button>
			<script type='text/javascript'>
				sweetAlert({
					title: 'Error!',
					text: 'New Password & Retype Password Again Harus Sama!',
					type: 'error'
				},
				function () {
					window.location.href = 'change-password.php';
				});
			</script>";
		exit();
	}
?>

<!doctype html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html> <!--<![endif]-->
	<head>
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Checklist System Purigroup</title>
        <meta name="description" content="Checklist System">
        <meta name="viewport" content="width=device-width">
        <link rel="shortcut icon" href="assets/img/puri.png">
        <link rel="stylesheet" href="dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="dist/css/veneto-admin.min.css">
        <link rel="stylesheet" href="demo/css/demo.css">
        <link rel="stylesheet" href="dist/assets/font-awesome/css/font-awesome.css">

        <link rel="stylesheet" href="dist/css/plugins/jquery-select2.min.css">
        <link rel="stylesheet" href="dist/css/plugins/jquery-dataTables.min.css">
        <!--[if lt IE 9]>
        <script src="dist/assets/libs/html5shiv/html5shiv.min.js"></script>
        <script src="dist/assets/libs/respond/respond.min.js"></script>
        <![endif]-->

    </head>
    <body class="">
       
	   <?php include ('_header.php'); ?>
	   
        <div class="page-wrapper">
            <aside class="sidebar sidebar-default">
				
				<?php include('nav.php'); ?>
			
			</aside>

            <div class="page-content">
                <div class="page-subheading page-subheading-md">
					<ol class="breadcrumb">
						<li><a href="javascript:;">Dashboard</a></li>
						<li class="active"><a href="javascript:;">Change Password</a></li>
					</ol>
				</div>
				<div class="page-heading page-heading-md">
					<h2 class="pull-left">Ganti Password</h2>
					<div class="col-button-colors pull-right">
						<a href="dashboard.php" class="btn btn-primary">Kembali</a>
					</div>
					<div class="clearfix"></div>
				</div>

				<div action="" name="form-tambah-pengguna" method="POST" class="form-horizontal form-bordered" role="form">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Ganti Password</h4>
						</div>
						<div class="panel-body">
							<div class="col-sm-8 col-sm-offset-2">
							<?php
								if($login){
									$new_password = $_POST['new_password'];
									//var_dump ($new_password);
										$login['password'] = md5($new_password);
										$login->update();
								?>			
										<span class="control-label label label-warning">Password Berhasil Di Ganti</span>
							<?php }else{ ?>
										<span class="control-label label label-danger">Ganti Password Gagal</span>
							<?php } ?>
							</div>
							<div class="controls col-sm-8 col-sm-offset-2" style="margin-top: 20px;">
								<a href="dashboard.php" class="btn btn-primary">Kembali</a>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
        <script src="dist/assets/libs/jquery/jquery.min.js"></script>
        <script src="dist/assets/bs3/js/bootstrap.min.js"></script>
        <script src="dist/assets/plugins/jquery-navgoco/jquery.navgoco.js"></script>
        <script src="dist/js/main.js"></script>

        <!--[if lt IE 9]>
        <script src="dist/assets/plugins/flot/excanvas.min.js"></script>
        <![endif]-->
        <script src="dist/assets/plugins/jquery-sparkline/jquery.sparkline.js"></script>
        <script src="demo/js/demo.js"></script>

        <script src="dist/assets/plugins/jquery-datatables/js/jquery.dataTables.js"></script>
        <script src="dist/assets/plugins/jquery-datatables/js/dataTables.tableTools.js"></script>
        <script src="dist/assets/plugins/jquery-datatables/js/dataTables.bootstrap.js"></script>
        <script src="dist/assets/plugins/jquery-select2/select2.min.js"></script>
        <script src="demo/js/tables-data-tables.js"></script>
		<script src="dist/assets/plugins/jquery-validation/jquery.validate.min.js"></script>

    </body>
</html>

<?php } ?>
