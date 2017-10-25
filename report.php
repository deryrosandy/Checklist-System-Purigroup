<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}else{
		include 'core/init.php';
		include 'core/helper/myHelper.php';
		
		$items = $db->item();
		$users = $db->users();
		
		$userid = $_SESSION['id'];
		$divisiid = $_SESSION['divisi_id'];
		$branch_id = $_SESSION['branch_id'];
		
		$user = $db->users("id", $userid)->fetch();
		$branch = $db->branch("id", $branch_id)->fetch();
		//var_dump ($branch);
		$divisi = $db->divisi("id", $divisiid)->fetch();
		
		$body = 'report';
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
		<link rel="stylesheet" href="dist/css/plugins/jquery-chosen.min.css">
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
					<h3 class="pull-left">Report Checklist</h3>
					<div class="col-button-colors pull-right">
						<a href="dashboard.php" class="btn btn-primary">Back</a>
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="container-fluid-md">
					<div class="row">
						<div class="col-lg-11">
							<ul class="nav nav-pills">
								<li class="<?php echo (($_GET['div']=='it') ? 'active' : ''); ?>"><a data-toggle="" href="?div=it"><strong>DIVISI IT</a></strong></li>
								<li class="<?php echo (($_GET['div']=='me') ? 'active' : ''); ?>"><a data-toggle="" href="?div=me"><strong>DIVISI ME</a></strong></li>					
								<li class="<?php echo (($_GET['div']=='hk') ? 'active' : ''); ?>"><a data-toggle="" href="?div=hk"><strong>DIVISI HK</a></strong></li>
								<li class="<?php echo (($_GET['div']=='fb') ? 'active' : ''); ?>"><a data-toggle="" href="?div=fb"><strong>DIVISI F&B</a></strong></li>
								<li class="<?php echo (($_GET['div']=='sc') ? 'active' : ''); ?>"><a data-toggle="" href="?div=sc"><strong>DIVISI SC</a></strong></li>
							</ul>
							<div class="tab-content">
								<div class="panel panel-info">
									<div class="panel-heading">
										<h3 class="panel-title">Report Checklist</h3>
									</div>
								</div>
								
								<?php  ($_GET['div']=='it') ? $action = 'report/report-checklist-it.php' : ''; ?>
								<?php  ($_GET['div']=='me') ? $action = 'report/report-checklist-me.php' : ''; ?>
								<?php  ($_GET['div']=='hk') ? $action = 'report/report-checklist-hk.php' : ''; ?>
								<?php  ($_GET['div']=='fb') ? $action = 'report/report-checklist-f&b.php' : ''; ?>
								<?php  ($_GET['div']=='sc') ? $action = 'report/report-checklist-sc.php' : ''; ?>
								
								<form method="POST" id="print_report" action="<?php echo $action; ?>" target="_blank" role="form" class="form-horizontal form-bordered">
									
									<?php if($_GET['div']=='it'){ ?>
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="form-group">
													<label class="control-label col-sm-2"><b>Date</b></label>

													<div class="controls col-sm-4">
														<input type="text" name="from_date" placeholder="Select Date" class="form-control required" title="Field Required"  data-rel="datepicker"/>
													</div>
												</div>
												<!--
												<div class="form-group">
													<label class="control-label col-sm-2"><b>To</b></label>

													<div class="controls col-sm-4">
														<input type="text" name="to_date" placeholder="To Date" class="form-control required" title="Field Required"  data-rel="datepicker"/>
													</div>
												</div>
												-->
												<div class="form-group">
													<div class="controls col-sm-6 col-sm-offset-2">
														<a href="javascript:document.getElementById('print_report').submit()" id="submit_print" target="_blank" class="btn btn-info">
															<i class="fa fa-print"></i> Print
														</a>
														<button type="reset" class="btn btn-default">Cancel</button>
													</div>
												</div>
											</div>
										</div>
									<?php } ?>
									
									<?php if($_GET['div']=='me'){ ?>
										<?php 
										$area = $db->item_area()
													//->where("branch_id", $branch)
													->where("divisi_id", '2');
										?>
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="form-group">
													<label class="control-label col-sm-2"><b>Date</b></label>

													<div class="controls col-sm-4">
														<input type="text" name="from_date" placeholder="Select Date" class="form-control required" title="Field Required"  data-rel="datepicker"/>
													</div>
												</div>
												<!--
												<div class="form-group">
													<label class="control-label col-sm-2"><b>To</b></label>

													<div class="controls col-sm-4">
														<input type="text" name="to_date" placeholder="To Date" class="form-control required" title="Field Required"  data-rel="datepicker"/>
													</div>
												</div>
												-->
												<div class="form-group">
													<label class="control-label col-sm-2"><b>Sub Area</b></label>

													<div class="col-lg-3">
														<select class="form-control form-chosen" name="sub-area" data-placeholder="Choose a Sub Area...">
															<option value=""></option>
															<?php foreach ($area as $ar){ ?>
																<option value="<?php echo $ar['id']; ?>"><?php echo $ar['name'];?></option>
															<?php } ?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<div class="controls col-sm-6 col-sm-offset-2">
														<a href="javascript:document.getElementById('print_report').submit()" id="submit_print" target="_blank" class="btn btn-info">
															<i class="fa fa-print"></i> Print
														</a>
														<button type="reset" class="btn btn-default">Cancel</button>
													</div>
												</div>
											</div>
										</div>
									<?php } ?>
									
									<?php if($_GET['div']=='hk'){ ?>
										<?php 
										$area = $db->item_area()
													//->where("branch_id", $branch)
													->where("divisi_id", '3');
										?>
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="form-group">
													<label class="control-label col-sm-2"><b>Date</b></label>

													<div class="controls col-sm-4">
														<input type="text" name="from_date" placeholder="Select Date" class="form-control required" title="Field Required"  data-rel="datepicker"/>
													</div>
												</div>
												<!--
												<div class="form-group">
													<label class="control-label col-sm-2"><b>To</b></label>

													<div class="controls col-sm-4">
														<input type="text" name="to_date" placeholder="To Date" class="form-control required" title="Field Required"  data-rel="datepicker"/>
													</div>
												</div>
												-->
												<div class="form-group">
													<label class="control-label col-sm-2"><b>Sub Area</b></label>

													<div class="col-lg-3">
														<select class="form-control form-chosen" name="sub-area" data-placeholder="Choose a Sub Area...">
															<option value=""></option>
															<?php foreach ($area as $ar){ ?>
																<option value="<?php echo $ar['id']; ?>"><?php echo $ar['name'];?></option>
															<?php } ?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<div class="controls col-sm-6 col-sm-offset-2">
														<a href="javascript:document.getElementById('print_report').submit()" id="submit_print" target="_blank" class="btn btn-info">
															<i class="fa fa-print"></i> Print
														</a>
														<button type="reset" class="btn btn-default">Cancel</button>
													</div>
												</div>
											</div>
										</div>
									<?php } ?>

									<?php if($_GET['div']=='fb'){ ?>
										<?php 
										$area = $db->item_area()
													//->where("branch_id", $branch)
													->where("divisi_id", '4');
										?>
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="form-group">
													<label class="control-label col-sm-2"><b>Date</b></label>

													<div class="controls col-sm-4">
														<input type="text" name="from_date" placeholder="Select Date" class="form-control required" title="Field Required"  data-rel="datepicker"/>
													</div>
												</div>
												<!--
												<div class="form-group">
													<label class="control-label col-sm-2"><b>To</b></label>

													<div class="controls col-sm-4">
														<input type="text" name="to_date" placeholder="To Date" class="form-control required" title="Field Required"  data-rel="datepicker"/>
													</div>
												</div>
												-->
												<div class="form-group">
													<label class="control-label col-sm-2"><b>Sub Area</b></label>

													<div class="col-lg-3">
														<select class="form-control form-chosen" name="sub-area" data-placeholder="Choose a Sub Area...">
															<option value=""></option>
															<?php foreach ($area as $ar){ ?>
																<option value="<?php echo $ar['id']; ?>"><?php echo $ar['name'];?></option>
															<?php } ?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<div class="controls col-sm-6 col-sm-offset-2">
														<a href="javascript:document.getElementById('print_report').submit()" id="submit_print" target="_blank" class="btn btn-info">
															<i class="fa fa-print"></i> Print
														</a>
														<button type="reset" class="btn btn-default">Cancel</button>
													</div>
												</div>
											</div>
										</div>
									<?php } ?>


									<?php if($_GET['div']=='sc'){ ?>
										<?php 
										$area = $db->item_area()
													//->where("branch_id", $branch)
													->where("divisi_id", '5');
										?>
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="form-group">
													<label class="control-label col-sm-2"><b>Date</b></label>

													<div class="controls col-sm-4">
														<input type="text" name="from_date" placeholder="Select Date" class="form-control required" title="Field Required"  data-rel="datepicker"/>
													</div>
												</div>
												<!--
												<div class="form-group">
													<label class="control-label col-sm-2"><b>To</b></label>

													<div class="controls col-sm-4">
														<input type="text" name="to_date" placeholder="To Date" class="form-control required" title="Field Required"  data-rel="datepicker"/>
													</div>
												</div>
												-->
												<div class="form-group">
													<label class="control-label col-sm-2"><b>Sub Area</b></label>

													<div class="col-lg-3">
														<select class="form-control form-chosen" name="sub-area" data-placeholder="Choose a Sub Area...">
															<option value=""></option>
															<?php foreach ($area as $ar){ ?>
																<option value="<?php echo $ar['id']; ?>"><?php echo $ar['name'];?></option>
															<?php } ?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<div class="controls col-sm-6 col-sm-offset-2">
														<a href="javascript:document.getElementById('print_report').submit()" id="submit_print" target="_blank" class="btn btn-info">
															<i class="fa fa-print"></i> Print
														</a>
														<button type="reset" class="btn btn-default">Cancel</button>
													</div>
												</div>
											</div>
										</div>
									<?php } ?>
									
								</form>
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
		<script src="dist/assets/plugins/jquery-chosen/chosen.jquery.min.js"></script>
		<script src="dist/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
		<script src="dist/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="demo/js/tables-data-tables.js"></script>
		<script src="dist/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$("#print_report").validate();
			})
		</script>
    </body>
</html>

<?php } ?>