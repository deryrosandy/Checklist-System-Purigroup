<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}else{
		include 'core/init.php';
		include 'core/helper/myHelper.php';
		
		$users = $db->users();
		
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

        <link rel="stylesheet" href="dist/css/plugins/jquery-select2.min.css">
        <link rel="stylesheet" href="dist/css/plugins/jquery-dataTables.min.css">
        <!--[if lt IE 9]>
        <script src="dist/assets/libs/html5shiv/html5shiv.min.js"></script>
        <script src="dist/assets/libs/respond/respond.min.js"></script>
        <![endif]-->

    </head>
    <body class="">
		
		<?php include '_header.php'; ?>
		
        <div class="page-wrapper">
            <aside class="sidebar sidebar-default">
				
				<?php include('nav.php'); ?>
			
			</aside>

            <div class="page-content">
                <div class="page-subheading page-subheading-md">
    <ol class="breadcrumb">
        <li><a href="javascript:;">Dashboard</a></li>
        <li class="active"><a href="javascript:;">Users</a></li>
    </ol>
</div>
<div class="page-heading page-heading-md">
    <h2 class="pull-left">Users</h2>
	<div class="col-button-colors pull-right">
		<a href="dashboard.php" class="btn btn-primary">Back</a>
	</div>
	<div class="clearfix"></div>
</div>

<div class="container-fluid-md">
    <div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-button-colors pull-left">
						<h1 style="padding-top:10px;" class="panel-title">List Users</h1>
					</div>
					<div class="col-button-colors pull-right">
						<a href="add-user.php" style="margin-bottom: 0px;" class="btn btn-primary">Add New</a>
					</div>
				</div>
			</div>
		</div>
        <div class="panel-body">
			<div class="table-responsive">
				<table data-sortable id="table-basic" class="table table-responsive table-hover table-striped">
					<thead>
						<tr>
							<th>No.</th>
							<th>Name</th>
							<th>Username</th>
							<th>Email</th>
							<th>Status</th>
							<th>User Type</th>
							<th>Branch</th>
							 <th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php $n=1; ?>
					<?php foreach ($users as $user){ ?>
							<tr class="odd gradeX">
								<td><?php echo $n; ?></td>
								<td><?php echo ucfirst($user['first_name']); ?></td>
								<td><?php echo $user['username']; ?></td>
								<td class="center"><?php echo $user['email']; ?></td>
								<td><?php echo status($user['active']); ?></td>
								<td><?php echo $user['user_type']; ?></td>
								<td><?php echo $user->branch["name"]; ?></td>
								<td class="btn-group btn-group-box">
									<a class="btn btn-primary">Modify</a>
									<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									</a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="edit-user.php?id=<?php echo $user['id']; ?>">Edit</a></li>
										<li><a href="delete-user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to Delete ?');">Delete</a></li>
									</ul>
								</td>
							</tr>

						<?php $n++; ?>
					<?php } ?>

					</tbody>
				</table>
			</div>
        </div>
    </div>
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
		<script src="dist/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
		<script src="dist/assets/plugins/jquery-chosen/chosen.jquery.min.js"></script>
		<script src="dist/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="demo/js/tables-data-tables.js"></script>
    </body>
</html>

<?php } ?>