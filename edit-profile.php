<?php
if(!isset($_SESSION)){
    session_start();

include 'core/init.php';
include 'core/helper/myHelper.php';	 

$user = $db->user_login()->where("id", $_SESSION['id'])->fetch();

?>

<!doctype html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> 

<html> <!--<![endif]-->
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
						<li><a href="javascript:;">Profile</a></li>
						<li class="active"><a href="javascript:;">Edit</a></li>
					</ol>
				</div>
				<div class="page-heading page-heading-md">
					<h2 class="pull-left">Edit Profile</h2>
					<div class="col-button-colors pull-right">
						<a href="dashboard.php" class="btn btn-primary">Back</a>
					</div>
					<div class="clearfix"></div>
				</div>

				<form action="simpan_edit_profile.php" name="form-tambah-pengguna" method="POST" class="form-horizontal form-bordered" role="form">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Edit Profile</h4>

						</div>
						<div class="panel-body">

							<div class="form-group">
								<label class="control-label col-sm-3">First Name</label>

								<div class="controls col-sm-6">
									<input type="text" name="first_name" class="form-control" value="<?php echo $user['first_name']; ?>">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3">Last Name</label>

								<div class="controls col-sm-6">
									<input type="text" name="last_name" class="form-control" value="<?php echo $user['last_name']; ?>">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3">Username</label>

								<div class="controls col-sm-6">
									<input type="text" name="username" class="form-control" value="<?php echo $user['username']; ?>">
									<input type="hidden" name="username_lama" class="form-control" value="<?php echo $user['username']; ?>">
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-3">Email</label>

								<div class="controls col-sm-6">
									<input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>">
									<input type="hidden" name="email_lama" class="form-control" value="<?php echo $user['email']; ?>">
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-3">Nomer Telepon</label>

								<div class="controls col-sm-6">
									<input type="number" name="phone_number" class="form-control" value="<?php echo $user['phone_number']; ?>">
								</div>
							</div>
						
							<div class="form-group">
								<div class="controls col-sm-6 col-sm-offset-2">
									<button type="submit" class="btn btn-primary">Update</button>&nbsp;&nbsp;&nbsp;
									<input type="hidden" name="id" value="<?php echo $user['id']; ?>"/> 
									<button type="reset" class="btn btn-primary">Reset</button>
								</div>
							</div>
							
						</div>
					</div>
				</form>

            </div>
        </div>
		
		<?php include ('_footer.php'); ?>
		
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
    </body>
</html>

<?php } ?>