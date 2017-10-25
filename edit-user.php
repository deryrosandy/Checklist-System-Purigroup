<?php

if(!isset($_SESSION)){
    session_start();

	include 'core/init.php';
	include 'core/helper/myHelper.php';	 

	$id = $_GET['id'];

	$user_edit = $db->users()->where("id", $id)->fetch();
	
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
        <title>Checklist System Purigroup</title>
        <meta name="description" content="Checklist System">
        <meta name="viewport" content="width=device-width">
        <link rel="shortcut icon" href="assets/img/puri.png">
        <link rel="stylesheet" href="dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="dist/css/veneto-admin.min.css">
        <link rel="stylesheet" href="demo/css/style.css">
        <link rel="stylesheet" href="dist/assets/font-awesome/css/font-awesome.css">
		<link rel="stylesheet" href="dist/css/plugins/jquery-chosen.min.css">
        <link rel="stylesheet" href="dist/css/plugins/jquery-select2.min.css">
		<script src="dist/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
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
						<li class="active"><a href="javascript:;">Edit User</a></li>
					</ol>
				</div>
				<div class="page-heading page-heading-md">
					<h2 class="pull-left">Edit User</h2>
					<div class="col-button-colors pull-right">
						<a href="users.php" class="btn btn-primary">Back</a>
					</div>
					<div class="clearfix"></div>
				</div>

				<form action="save_edit_user.php" name="form-tambah-pengguna" method="POST" class="form-horizontal form-bordered" role="form">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Edit User</h4>
						</div>
						<div class="panel-body">

							<div class="form-group">
								<label class="control-label col-sm-3">Username</label>

								<div class="controls col-sm-6">
									<input type="text" name="username" class="form-control" value="<?php echo $user_edit['username']; ?>">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3">First Name</label>

								<div class="controls col-sm-6">
									<input type="text" name="first_name" class="form-control" value="<?php echo $user_edit['first_name']; ?>">
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-3">Last Name</label>

								<div class="controls col-sm-6">
									<input type="text" name="last_name" class="form-control" value="<?php echo $user_edit['last_name']; ?>">
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-3">Password</label>

								<div class="controls col-sm-6">
									<input type="password" name="password" class="form-control" value="" placeholder="Keep blank if password not change">
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-3">Email</label>

								<div class="controls col-sm-6">
									<input type="email" name="email" class="form-control" value="<?php echo $user_edit['email']; ?>">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3">User Type</label>
								
								<div class="col-sm-6">
									<select name="gol-pengguna" class="form-control form-chosen" data-placeholder="Choose User Level...">
										<option <?php echo ($user_edit['user_type'] == 'administrator') ? 'selected' : ''; ?> value="administrator">Administrator</option>
										<option <?php echo ($user_edit['user_type'] == 'manager') ? 'selected' : ''; ?> value="manager">Manager</option>
										<option <?php echo ($user_edit['user_type'] == 'leader') ? 'selected' : ''; ?> value="leader">Leader</option>
										<option <?php echo ($user_edit['user_type'] == 'operator') ? 'selected' : ''; ?> value="operator">Operator</option>
										<option <?php echo ($user_edit['user_type'] == 'kasir') ? 'selected' : ''; ?> value="kasir">Kasir</option>
										<option <?php echo ($user_edit['user_type'] == 'manager pengganti') ? 'selected' : ''; ?> value="manager pengganti">Manager Pengganti</option>
										<option	<?php echo ($user_edit['user_type'] == 'manager divisi') ? 'selected' : ''; ?> value="manager divisi">Manager Divisi</option>
										<option	<?php echo ($user_edit['user_type'] == 'purchasing') ? 'selected' : ''; ?> value="purchasing">Purchasing</option>
										<option	<?php echo ($user_edit['user_type'] == 'staff adm') ? 'selected' : ''; ?> value="staff adm">Staff ADM</option>
										<option	<?php echo ($user_edit['user_type'] == 'markom') ? 'selected' : ''; ?> value="markom">Markom</option>
										<option	<?php echo ($user_edit['user_type'] == 'direksi') ? 'selected' : ''; ?> value="direksi">Direksi</option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-3">Divisi</label>
								<?php $divisi = $db->divisi(); ?>
								<div class="col-sm-6">
									<select name="divisi_id" class="form-control form-chosen" data-placeholder="Choose User Level...">
										<option <?php echo ($user_edit['divisi_id'] == '0') ? 'selected' : ''; ?> value="0">- ALL - </option>
									<?php foreach ($divisi as $div){ ?>
										<option <?php echo ($user_edit['divisi_id'] == $div['id']) ? 'selected' : ''; ?> value="<?php echo $div['id']; ?>"><?php echo $div['name']; ?></option>
									<?php } ?>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-3">Branch</label>
								<?php $branch = $db->branch(); ?>
								<div class="col-sm-6">
									<select name="branch_id" class="form-control form-chosen" data-placeholder="Choose User Level...">
										<?php foreach ($branch as $brc){ ?>
											<option <?php echo ($user_edit['branch_id'] == $brc['id']) ? 'selected' : ''; ?> value="<?php echo $brc['id']; ?>"><?php echo $brc['name']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3">Phone Number</label>

								<div class="controls col-sm-6">
									<input type="text" name="phone_number" class="form-control" value="<?php echo $user_edit['phone_number']; ?>">
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-3">Active</label>
								
								<div class="controls col-sm-6">
									<input name="user-status" value="1" checked class="boot-switch2" type="checkbox" data-on-color="warning" data-off-color="danger">
								</div>
							
							</div>
						
							<div class="form-group">
								<div class="controls col-sm-6 col-sm-offset-2">
									<button type="submit" class="btn btn-primary">Update</button>&nbsp;&nbsp;&nbsp;
									<input type="hidden" name="id" value="<?php echo $user_edit['id']; ?>"/>
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
		<script src="dist/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
		<script src="dist/assets/plugins/jquery-chosen/chosen.jquery.min.js"></script>
		<script src="dist/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="demo/js/tables-data-tables.js"></script>
    </body>
</html>
<?php } ?>