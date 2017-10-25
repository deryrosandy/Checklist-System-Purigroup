<?php

if(!isset($_SESSION)){
	
    session_start();

	include 'core/init.php';
	include 'core/helper/myHelper.php';	 

	$user = $db->users()->where("username", $_SESSION['username'])->fetch();
	
	$pass = $_SESSION['password'];
	
	$body = 'change-password';
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
        <link rel="stylesheet" href="demo/css/style.css">
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
    <h2 class="pull-left">Change Password</h2>
	<div class="col-button-colors pull-right">
		<a href="dashboard.php" class="btn btn-primary">Back</a>
	</div>
	<div class="clearfix"></div>
</div>

<form action="change_password.php" name="form-tambah-pengguna" method="POST" class="form-horizontal form-bordered" role="form">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Change Password</h4>

        </div>
        <div class="panel-body">

			<div class="form-group">
				<label class="control-label col-sm-3">Old Password</label>

				<div class="controls col-sm-6">
					<input type="password" id="old_password" name="old_password" class="form-control required" title="Insert Old Password" placeholder="Insert Old Password" required>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-3">New Password</label>

				<div class="controls col-sm-6">
					<input type="password" id="new_password" name="new_password" class="form-control required" title="Password Not Match" placeholder="Insert New Password" required>
				</div>
			</div>
					
			<div class="form-group">
				<label class="control-label col-sm-3">Retype Password Again</label>

				<div class="controls col-sm-6">
					<input type="password" id="confirm_new_password" equalTo="#new_password" name="confirm_new_password" class="form-control required" value="" placeholder="Insert New Password Again" required>
				</div>
			</div>
					
			<div class="form-group">
				<div class="controls col-sm-6 col-sm-offset-2">
					<button type="submit" class="btn btn-primary">Submit</button>&nbsp;&nbsp;&nbsp;
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
		<script src="dist/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function () {
				//validate
				$("form").validate({
					messages: {
						old_password: {
							required: "Enter your current password"
						},
						new_password: {
							required: "Enter a new password"
						},
						confirm_new_password: {
							required: "Enter the new password again",
							equalTo: "Make sure to retype the new password correctly"
						}
					}
				});
			});
		</script>


    </body>
</html>

<?php } ?>