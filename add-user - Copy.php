<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}else{
		include 'core/init.php';
		include 'core/helper/myHelper.php';
		
		$branch = $db->branch();
		
		$body = 'users';
?>
<!doctype html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html> <!--<![endif]-->
	<head>
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Checklist System&middot; Add User </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="shortcut icon" href="assets/img/favicon.ico">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="stylesheet" href="dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="dist/css/veneto-admin.min.css">
        <link rel="stylesheet" href="demo/css/style.css">
        <link rel="stylesheet" href="demo/css/style-responsive.css">
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
						<li><a href="javascript:;">Users</a></li>
						<li class="active"><a href="javascript:;">add user</a></li>
					</ol>
				</div>
				<div class="page-heading page-heading-md">
					<h2 class="pull-left">Users</h2>
					<div class="col-button-colors pull-right">
						<a href="users.php" class="btn btn-primary">Back</a>
					</div>
					<div class="clearfix"></div>
				</div>
				
				<div class="container-fluid-md">
					<form id="userAddForm" action="action/add_user.php" name="form-tambah-pengguna" method="POST" class="form-horizontal form-bordered" role="form">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="row">
									<div class="col-lg-12">
										<div class="col-button-colors pull-left">
											<h1 style="padding-top:10px;" class="panel-title">Add Users</h1>
										</div>
									</div>
								</div>
							</div>
							<div class="panel-body">

								<div class="form-group">
									<label class="control-label col-sm-3">Username</label>

									<div class="controls col-sm-6">
										<input type="text" name="username" class="form-control required" title="username" placeholder="Insert Username">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-sm-3">First Name</label>

									<div class="controls col-sm-6">
										<input type="text" name="first_name" class="form-control required"  title="first_name" placeholder="Insert First Name">
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3">Last Name</label>

									<div class="controls col-sm-6">
										<input type="text" name="last_name" class="form-control required"  title="last_name" placeholder="Insert Last Name">
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3">Email</label>

									<div class="controls col-sm-6">
										<input type="email" name="email" class="form-control" placeholder="Insert Email">
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3">Password</label>

									<div class="controls col-sm-6">
										<input type="password" id="password" name="password"  title="Password Lengkap Harus Di Isi" class="form-control required" placeholder="Insert Password">
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3">Password Again</label>

									<div class="controls col-sm-6">
										<input type="password" equalTo="#password" name="ulangi-password" class="form-control required"  title="Password Tidak Sama" placeholder="Insert Password Again">
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3">User Type</label>
									
									<div class="col-sm-6">
										<select name="gol-pengguna" class="form-control form-chosen required" data-placeholder="">
											<option value="">- Choose One -</option>
											<option value="administrator">Administrator</option>
											<option value="manager">Manager</option>
											<option value="leader">Leader</option>
											<option value="operator">Operator</option>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3">Divisi</label>
									<?php $divisi = $db->divisi(); ?>
									<div class="col-sm-6">
										<select name="divisi_id" class="form-control form-chosen" data-placeholder="Choose User Level...">
											<option value="0">- ALL - </option>
										<?php foreach ($divisi as $div){ ?>
											<option value="<?php echo $div['id']; ?>"><?php echo $div['name']; ?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3">Branch</label>
									
									<div class="col-sm-6">
										<select name="branch_id" class="form-control form-chosen required" data-placeholder="">
											<option value="">- Choose One -</option>
											<?php foreach ($branch as $b){ ?>
												<option value="<?php echo $b["id"]; ?>"><?php echo $b["name"]; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3">Phone Number</label>

									<div class="controls col-sm-6">
										<input type="text" name="phone_number" class="form-control" placeholder="Insert Phone Number">
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3">Active</label>
									
									<div class="controls col-sm-6">
										<input name="user-status" value="1" class="boot-switch" type="checkbox" data-on-color="warning" data-off-color="danger">
									</div>
								</div>
							
								<div class="form-group">
									<div class="controls col-sm-6 col-sm-offset-2">
										<button type="submit" class="btn btn-primary">Submit</button>&nbsp;&nbsp;&nbsp;
										<button type="reset" class="btn btn-primary">Reset</button>
									</div>
								</div>
								
							</div>
						</div>
					</form>
				</div>
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
			$(document).ready(function() {
				$("#userAddForm").validate();
			})
		</script>
    </body>
</html>

<?php } ?>