<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}else{
		include 'core/init.php';
		include 'core/helper/myHelper.php';
		
		$allarea = $db->item_area()
			->order('name DESC');
		
		$body = 'add-checklist';
		
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
       
	   <?php include ('_header.php'); ?>
	   
        <div class="page-wrapper">
            <aside class="sidebar sidebar-default">
				
				<?php include('nav.php'); ?>
			
			</aside>

            <div class="page-content">
                <div class="page-subheading page-subheading-md">
					<ol class="breadcrumb">
						<li><a href="javascript:;">Dashboard</a></li>
						<li class=""><a href="javascript:;">Tambah Checklist IT</a></li>
						<li class="active"><a href="javascript:;">-</a></li>
					</ol>
				</div>
				<div class="page-heading page-heading-md">
					<h2 class="pull-left">Tambah Data</h2>
					<div class="col-button-colors pull-right">
						<a href="dashboard.php" class="btn btn-primary">Kembali</a>
					</div>
					<div class="clearfix"></div>
				</div>
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><strong>Data</strong> Checklist IT</h2>
							</div>
							<div class="widget-content">
								<div class="data-table-toolbar">
									<div class="row">
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-6">
													<!--
													<form role="form">
													<input type="text" class="form-control" placeholder="Search...">
													</form>
													-->
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="row">
												
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-12 content-area">
									<div class="row">
										<div class="col-sm-3">
											<ul class="nav nav-pills nav-stacked">
												<?php
												$no = 1;
												$active;
												foreach ($allarea as $area){
												?>
												<li class="<?php echo ($no==1) ? 'active':''; ?>"><a data-toggle="tab" href="#tabarea-<?php echo $area['id']; ?>"><?php echo strtoupper($area["name"]); ?></a></li>
												<?php
													$no++;
												}
												?>
											</ul>
										</div>
										<div class="col-sm-9">
											<div class="tab-content">
											<?php
												$notab = 1;
												foreach ($allarea as $area){
												
													$item_area_id = $area['id'];
													//var_dump ($item_area_id);
													$items = $db->item()
														->where("item_area_id", $item_area_id);
													//var_dump ($item);
													//die();
											?>
												<div id="tabarea-<?php echo $area['id']; ?>" class="tab-pane <?php echo ($notab==1) ? 'active':''; ?>">
													<div class="table-responsive">
														<table data-sortable class="table table-hover table-striped">
															<thead>
																<tr>
																	<th rowspan='2'>No</th>
																	<th style="width:200px;">NAMA</th>
																	<th>STATUS</th>
																	<th colspan='2'>KETERANGAN</th>
																</tr>
															</thead>
															
															<tbody>
																<?php
																$no=1;
																foreach ($items as $item){
																?>
																<form action="insert_checklist.php" method="POST" role="form">
																
																<tr>
																	<td><?php echo $no; ?></td>
																	<td><strong><?php echo ucwords($item['item_name']); ?></strong></td>
																	<td>
																		<!--<input name="onoffswitch" value="1" class="boot-switch" type="checkbox" data="1" checked="checked" data-on-color="primary" data-off-color="danger">-->
																		<div class="btn-group btn-toggle" data-toggle="buttons">
																			<label class="btn-status btn btn-primary active">
																			  <input type="radio" checked name="status[<?php echo $item['id']; ?>]" value="1"> Bagus
																			</label>
																			<label class="btn-status btn btn-primary">
																			  <input type="radio" name="status[<?php echo $item['id']; ?>]" value="0"> Rusak
																			</label>
																		</div>
																	</td>
																	<td><input type="text" name="keterangan[]" /></td>
																	
																	<?php 
																		$data = $item['id'];
																		//var_dump ($data);
																	?>
																	<input type="hidden" name="id[]" value="<?php echo $item['id']; ?>"/>
																</tr>
																<?php
																$no++;
																}
																?>
																<div class="row">
																	<div class="col-md-12">
																		<div class="btn-action pull-right">
																			<button type="submit" name="submit" class="btn btn-primary">Simpan</button>
																			<!--<a class="btn btn-primary btn-sm">Simpan</a>-->
																		</div>
																	</div>
																</div>
																
																</form>
															</tbody>
														</table>
													</div>												
												</div>
												<?php 
												$notab++;
												}
												
												?>
											</div>
										</div>
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
       
        <script src="dist/assets/plugins/jquery-datatables/js/jquery.dataTables.js"></script>
        <script src="dist/assets/plugins/jquery-datatables/js/dataTables.tableTools.js"></script>
        <script src="dist/assets/plugins/jquery-datatables/js/dataTables.bootstrap.js"></script>
        <script src="dist/assets/plugins/jquery-select2/select2.min.js"></script>
        <script src="dist/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
		<script src="demo/js/tables-data-tables.js"></script>
		<script src="demo/js/demo.js"></script>
    </body>
</html>
<?php } ?>