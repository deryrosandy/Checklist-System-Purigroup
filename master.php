<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}else{
		include 'core/init.php';
		include 'core/helper/myHelper.php';
		/*
		function status($user_type) {
			
			$user = array("Tidak Aktif","Aktif");
			
			$result = $user[$user_type];
			
			return($result);
		}
		*/
		
		if (!empty($_GET['module'])){
			$module = $_GET['module'];
		}else{
			$module= 'item';
		};
		
		//var_dump ($module);
		
		
		$items = $db->item();
		$item_area  = $db->item_area();
		$branch = $db->branch();
		$divisi = $db->divisi();
		$users = $db->users();
		
		$body = 'master';
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
		<link rel="stylesheet" href="dist/css/plugins/bootstrap-switch.min.css">
		
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
						<li class="active"><a href="javascript:;">Master</a></li>
					</ol>
				</div>
				<div class="page-heading page-heading-md">
					<h3 class="pull-left">Master Data</h3>
					<div class="col-button-colors pull-right">
						<a href="dashboard.php" class="btn btn-primary">Back</a>
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="container-fluid-md">
					<div class="row">
						<div class="col-lg-11">
							<ul class="nav nav-pills">
								<li class="<?php echo $module == 'item' ? 'active' : ''; ?>"><a data-toggle="" href="master.php?module=item"><strong>ITEM</a></strong></li>
								<li class="<?php echo $module == 'item-area' ? 'active' : ''; ?>"><a data-toggle="" href="master.php?module=item-area"><strong>ITEM AREA</a></strong></li>					
								<li class="<?php echo $module == 'divisi' ? 'active' : ''; ?>"><a data-toggle="" href="master.php?module=divisi"><strong>DIVISION</a></strong></li>					
								<li class="<?php echo $module == 'branch' ? 'active' : ''; ?>"><a data-toggle="" href="master.php?module=branch"><strong>BRANCH</a></strong></li>
							</ul>
							<?php //var_dump ($_GET['module']); die();?>

							<?php switch($module){
								case "item":
							?>
							<div class="tab-content panel panel-default">
								<div class="row">
								<div class="panel-heading">
									<div class="row">
										<div class="col-lg-12">
											<div class="col-button-colors pull-left">
												<h1 style="padding-top:10px;" class="panel-title">List Item</h1>
											</div>
											<div class="col-button-colors pull-right">
												<a href="javascript:void(0);" style="margin-bottom: 0px;" class="btn btn-primary">Add New</a>
											</div>
										</div>
									</div>
								</div>
								<div class="panel-body">

									<h6>&nbsp;</h6>
									<table id="table-basic" class="table table-item table-striped">
										<thead>
											<tr>
												<th class="no" style="width:30px">No.</th>
												<th class="name">Name</th>
												<th class="area">Area</th>
												<th class="division">Division</th>
												<th class="branch">Branch</th>
												<?php if($user_type == 'administrator'){ ?>
												<th class="action">Action</th>
												<?php } ?>
											</tr>
										</thead>
										<tbody>
										<?php $no = 1; ?>
										
										<?php foreach ($items as $item){ ?>
											<tr class="odd gradeX">
												<td><?php echo $no; ?></td>
												<td><?php echo ucfirst($item["item_name"]); ?></td>
												<td><?php echo ucfirst($item->item_area["name"]); ?></td>
												<td><?php echo strtoupper($item->divisi['name']); ?></td>
												<td><?php echo ucfirst($item->branch['name']); ?></td>
												<?php if($user_type == 'administrator'){ ?>
												<td class="btn-group">
													<?php /*
													<a href="edit-item.php?id=<?php echo $item['id']; ?>" class="btn btn-warning">Edit</a>
													<a href="delete-item.php?id=<?php echo $item['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to Delete ?');">Delete</a>
													*/ ?>
													<a href="javascript:void(0);" class="btn btn-warning">Edit</a>
													<a href="javascript:void(0);" class="btn btn-danger" onclick="return confirm('Are you sure you want to Delete ?');">Delete</a>
												</td>
												<?php } ?>
											</tr>
										<?php $no++ ?>
										<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
							</div>
							<?php break; ?>
							<?php 	case "item-area": ?>
							<div class="col-lg-10 col-md-12">
								<div class="tab-content panel panel-default">
									<div class="panel-heading">
										<div class="row">
											<div class="col-lg-12">
												<div class="col-button-colors pull-left">
													<h1 style="padding-top:10px;" class="panel-title">List Item Area</h1>
												</div>
												<div class="col-button-colors pull-right">
													<a href="javascript:void(0);" style="margin-bottom: 0px;" class="btn btn-primary">Add New</a>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-body">
										<table id="table-basic" class="table table-item table-striped">
											<thead>
												<tr>
													<th class="no" style="width:30px">No.</th>
													<th style="width:250px;" class="name">Name</th>
													<th class="branch">Branch</th>
													<?php if($user_type == 'administrator'){ ?>
													<th style="width:200px;" class="action">Action</th>
													<?php } ?>
												</tr>
											</thead>
											<tbody>
											<?php $no = 1; ?>
											
											<?php foreach ($item_area as $area){ ?>
												<tr class="odd gradeX">
													<td><?php echo $no; ?></td>
													<td><?php echo ucfirst($area["name"]); ?></td>
													<td><?php echo ucfirst($area->branch['name']); ?></td>
													<?php if($user_type == 'administrator'){ ?>
													<td class="btn-group">
														<?php /*
														<a href="edit-item.php?id=<?php echo $item['id']; ?>" class="btn btn-warning">Edit</a>
														<a href="delete-item.php?id=<?php echo $item['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to Delete ?');">Delete</a>
														*/ ?>
														<a href="javascript:void(0);" class="btn btn-warning">Edit</a>
														<a href="javascript:void(0);" class="btn btn-danger" onclick="return confirm('Are you sure you want to Delete ?');">Delete</a>
													</td>
													<?php } ?>
												</tr>
											<?php $no++ ?>
											<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<?php break; ?>
							<?php 	case "divisi": ?>	
							<div class="col-lg-10 col-md-12">
								<div class="tab-content panel panel-default">
									<div class="panel-heading">
										<div class="row">
											<div class="col-lg-12">
												<div class="col-button-colors pull-left">
													<h1 style="padding-top:10px;" class="panel-title">List Divisi</h1>
												</div>
												<div class="col-button-colors pull-right">
													<a href="javascript:void(0);" style="margin-bottom: 0px;" class="btn btn-primary">Add New</a>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-body">
										<table id="table-basic" class="table table-item table-striped">
											<thead>
												<tr>
													<th class="no" style="width:30px">No.</th>
													<th style="width:300px;" class="name">Code</th>
													<th class="branch">Name</th>
													<?php if($user_type == 'administrator'){ ?>
													<th style="width:200px;" class="action">Action</th>
													<?php } ?>
												</tr>
											</thead>
											<tbody>
											<?php $no = 1; ?>
											
											<?php foreach ($divisi as $div){ ?>
												<tr class="odd gradeX">
													<td><?php echo $no; ?></td>
													<td><?php echo strtolower($div["code"]); ?></td>
													<td><?php echo strtoupper($div['name']); ?></td>
													<?php if($user_type == 'administrator'){ ?>
													<td class="btn-group">
														<?php /*
														<a href="edit-item.php?id=<?php echo $item['id']; ?>" class="btn btn-warning">Edit</a>
														<a href="delete-item.php?id=<?php echo $item['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to Delete ?');">Delete</a>
														*/ ?>
														<a href="javascript:void(0);" class="btn btn-warning">Edit</a>
														<a href="javascript:void(0);" class="btn btn-danger" onclick="return confirm('Are you sure you want to Delete ?');">Delete</a>
													</td>
													<?php } ?>
												</tr>
											<?php $no++ ?>
											<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<?php break; ?>
							<?php 	case "branch": ?>				
							<div class="tab-content panel panel-default">
								<div class="panel-heading">
									<div class="row">
										<div class="col-lg-12">
											<div class="col-button-colors pull-left">
												<h1 style="padding-top:10px;" class="panel-title">List Branch</h1>
											</div>
											<div class="col-button-colors pull-right">
												<a href="javascript:void(0);" style="margin-bottom: 0px;" class="btn btn-primary">Add New</a>
											</div>
										</div>
									</div>
								</div>
								<div class="panel-body">
									<table id="table-basic" class="table table-item table-striped">
										<thead>
											<tr>
												<th class="no" style="width:30px">No.</th>
												<th style="width:250px;" class="name">Name</th>
												<th style="width:200px;" class="branch">Address</th>
												<th style="width:170px;" class="branch">City</th>
												<th style="width:170px;" class="branch">Phone Number</th>
												<?php if($user_type == 'administrator'){ ?>
												<th style="width:170px;" class="action">Action</th>
												<?php } ?>
											</tr>
										</thead>
										<tbody>
										<?php $no = 1; ?>
										
										<?php foreach ($branch as $brch){ ?>
											<tr class="odd gradeX">
												<td><?php echo $no; ?></td>
												<td><?php echo strtoupper($brch["name"]); ?></td>
												<td><?php echo lcfirst($brch["address"]); ?></td>
												<td><?php echo ucfirst($brch['city']); ?></td>
												<td><?php echo ucfirst($brch['phone_number']); ?></td>
												<?php if($user_type == 'administrator'){ ?>
												<td class="btn-group">
													<?php /*
													<a href="edit-item.php?id=<?php echo $item['id']; ?>" class="btn btn-warning">Edit</a>
													<a href="delete-item.php?id=<?php echo $item['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to Delete ?');">Delete</a>
													*/ ?>
													<a href="javascript:void(0);" class="btn btn-warning">Edit</a>
													<a href="javascript:void(0);" class="btn btn-danger" onclick="return confirm('Are you sure you want to Delete ?');">Delete</a>
												</td>
												<?php } ?>
											</tr>
										<?php $no++ ?>
										<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
							<?php break; ?>
							<?php default: ?>
								<div class="tab-content panel panel-default">
									<div class="panel-body">
										<table id="table-basic" class="table table-item table-striped">
											<thead>
												<tr>
													<th class="no" style="width:30px">No.</th>
													<th class="name">Name</th>
													<th class="area">Area</th>
													<th class="division">Division</th>
													<th class="branch">Branch</th>
													<?php if($user_type == 'administrator'){ ?>
													<th class="action">Action</th>
													<?php } ?>
												</tr>
											</thead>
											<tbody>
											<?php $no = 1; ?>
											
											<?php foreach ($items as $item){ ?>
												<tr class="odd gradeX">
													<td><?php echo $no; ?></td>
													<td><?php echo ucfirst($item["item_name"]); ?></td>
													<td><?php echo ucfirst($item->item_area["name"]); ?></td>
													<td><?php echo strtoupper($item->divisi['name']); ?></td>
													<td><?php echo ucfirst($item->branch['name']); ?></td>
													<?php if($user_type == 'administrator'){ ?>
													<td class="btn-group">
														<a href="edit-item.php?id=<?php echo $item['id']; ?>" class="btn btn-warning">Edit</a>
														<a href="delete-item.php?id=<?php echo $item['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to Delete ?');">Delete</a>
													</td>
													<?php } ?>
												</tr>
											<?php $no++ ?>
											<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							<?php } ?>
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
		<script src="dist/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>		 
        <script src="demo/js/tables-data-tables.js"></script>
    </body>
</html>

<?php } ?>