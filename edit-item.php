<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}else{
		include 'core/init.php';
		include 'core/helper/myHelper.php';
		
		$id = $_GET['id'];
		
		$item = $db->item()->where("id", $id)->fetch();
		$all_item_area = $db->item_area();
		$all_divisi = $db->divisi();
		$all_branch = $db->branch();
		
		$item_area = $db->item_area()->where("id", $item['item_area_id'])->fetch();
		$divisi = $db->divisi()->where("id", $item['divisi_id'])->fetch();
		$branch = $db->branch()->where("id", $item['branch_id'])->fetch();
		
		$user = $db->users()->where("id", $_SESSION['id'])->fetch();
		
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
								<li class="active"><a data-toggle="tab" href="#"><strong>ITEM</a></strong></li>
								<li><a data-toggle="tab" href="#"><strong>BRANCH</a></strong></li>
								<li><a data-toggle="tab" href="#"><strong>ITEM AREA</a></strong></li>
							</ul>
							<div class="tab-content">
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
										
										</tbody>
									</table>
								</div>
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
        <script src="demo/js/tables-data-tables.js"></script>
    </body>
</html>

<?php } ?>