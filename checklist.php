<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}else{
		
		include 'core/init.php';
		include 'core/helper/myHelper.php';
	
		$user = $db->users("id", $_SESSION['id'])->fetch();
		
		$body = 'checklist';
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
        <link rel="stylesheet" href="demo/css/style-responsive.css">
        <link rel="stylesheet" href="dist/assets/font-awesome/css/font-awesome.css">

        <link rel="stylesheet" href="dist/assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css"/>
        <link rel="stylesheet" href="dist/css/plugins/rickshaw.min.css">
        <link rel="stylesheet" href="dist/css/plugins/morris.min.css">

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
						<li class=""><a href="javascript:;">Dashboard</a></li>
						<li class="active"><a href="javascript:;">Checklist</a></li>
					</ol>
				</div>
				
				<div class="page-heading page-heading-md">
					<h3 class="pull-left">Silahkan Pilih Divisi</h3>
					<div class="clearfix"></div>
				</div>
				<div class="container-fluid-md">
					<div class="row">
						<?php switch ($user->divisi['code']){
							case "it":
						?>
						<div class="col-xs-6 col-sm-3 col-md-4 col-lg-3">
							<div class="panel panel-metric panel-metric-sm">
								<div class="panel-body panel-body-primary">
								
								   <div class="metric-dashboard metric-content metric-icon link-more">
										<div class="inner">
										
										</div>
										<div class="icon">
											<i class="fa fa-globe"></i>
										</div>
										<a href="checklist-it.php" class="">
											<h1 class="divisi-title">IT</h1>
										</a>
									</div>
									
								</div>
							</div>
						</div>
						<?php 	break;
							case "me":
						?>
						<div class="col-xs-6 col-sm-3 col-md-4 col-lg-3">
							<div class="panel panel-metric panel-metric-sm">
								<div class="panel-body panel-body-success">
								
								   <div class="metric-dashboard metric-content metric-icon link-more">
										<div class="inner">
										
										</div>
										<div class="icon">
											<i class="fa fa-shield"></i>
										</div>
										<a href="checklist-me.php" class="">
											<h1 class="divisi-title">ME</h1>
										</a>
									</div>
									
								</div>
							</div>
						</div>
						<?php 	break;
							case "hk":
						?>					
						<div class="col-xs-6 col-sm-3 col-md-4 col-lg-3">
							<div class="panel panel-metric panel-metric-sm">
								<div class="panel-body panel-body-danger">
								
									<div class="metric-dashboard metric-content metric-icon link-more">
										<div class="inner">
										
										</div>
										<div class="icon">
											<i class="fa fa-h-square"></i>
										</div>
										<a href="checklist-hk.php" class="">
											<h1 class="divisi-title">HK</h1>
										</a>
									</div>
									
								</div>
							</div>
						</div>
						<?php 	break;
							case "hk":
						?>
						<div class="col-xs-6 col-sm-3 col-md-4 col-lg-3">
							<div class="panel panel-metric panel-metric-sm">
								<div class="panel-body panel-body-warning">
								
								   <div class="metric-dashboard metric-content metric-icon link-more">
										<div class="inner">
										
										</div>
										<div class="icon">
											<i class="fa fa-spoon"></i>
										</div>
										<a href="javascript:void(0);" class="">
											<h1 class="divisi-title">FB</h1>
										</a>
									</div>
									
								</div>
							</div>
						</div>
						<?php default: ?>
							<div class="col-xs-6 col-sm-3 col-md-4 col-lg-3">
								<div class="panel panel-metric panel-metric-sm">
									<div class="panel-body panel-body-primary">
									
									   <div class="metric-dashboard metric-content metric-icon link-more">
											<div class="inner">
											
											</div>
											<div class="icon">
												<i class="fa fa-globe"></i>
											</div>
											<?php if ($user['user_type'] == 'manager'){ ?>
												<a href="lihat-checklist-it.php" class="">
											<?php }else{ ?>
												<a href="checklist-it.php" class="">
											<?php } ?>
												<h1 class="divisi-title">IT</h1>
											</a>
										</div>
										
									</div>
								</div>
							</div>
							
							<div class="col-xs-6 col-sm-3 col-md-4 col-lg-3">
								<div class="panel panel-metric panel-metric-sm">
									<div class="panel-body panel-body-success">
									
									   <div class="metric-dashboard metric-content metric-icon link-more">
											<div class="inner">
											
											</div>
											<div class="icon">
												<i class="fa fa-shield"></i>
											</div>
											<?php if ($user['user_type'] == 'manager'){ ?>
												<a href="lihat-checklist-me.php" class="">
											<?php }else{ ?>
												<a href="checklist-me.php" class="">
											<?php } ?>
												<h1 class="divisi-title">ME</h1>
											</a>
										</div>
										
									</div>
								</div>
							</div>
							
							<div class="col-xs-6 col-sm-3 col-md-4 col-lg-3">
								<div class="panel panel-metric panel-metric-sm">
									<div class="panel-body panel-body-danger">
									
										<div class="metric-dashboard metric-content metric-icon link-more">
											<div class="inner">
											
											</div>
											<div class="icon">
												<i class="fa fa-h-square"></i>
											</div>
											<?php if ($user['user_type'] == 'manager'){ ?>
											<a href="lihat-checklist-hk.php" class="">
											<?php }else{ ?>
												<a href="checklist-hk.php" class="">
											<?php } ?>
												<h1 class="divisi-title">HK</h1>
											</a>
										</div>
										
									</div>
								</div>
							</div>
							
							<div class="col-xs-6 col-sm-3 col-md-4 col-lg-3">
								<div class="panel panel-metric panel-metric-sm">
									<div class="panel-body panel-body-warning">
									
									   <div class="metric-dashboard metric-content metric-icon link-more">
											<div class="inner">
											
											</div>
											<div class="icon">
												<i class="fa fa-spoon"></i>
											</div>
											<?php if ($user['user_type'] == 'manager'){ ?>
												<a href="javascript:void(0);" class="">
											<?php }else{ ?>
												<a href="javascript:void(0);" class="">
											<?php } ?>
												<h1 class="divisi-title">F&B</h1>
											</a>
										</div>
										
									</div>
								</div>
							</div>
							
						<?php } ?>
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

        <script src="dist/assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="dist/assets/plugins/jquery-jvectormap/maps/world_mill_en.js"></script>

        <!--[if gte IE 9]>-->
        <script src="dist/assets/plugins/rickshaw/js/vendor/d3.v3.js"></script>
        <script src="dist/assets/plugins/rickshaw/rickshaw.min.js"></script>
        <!--<![endif]-->

        <script src="dist/assets/plugins/flot/jquery.flot.js"></script>
        <script src="dist/assets/plugins/flot/jquery.flot.resize.js"></script>
        <script src="dist/assets/plugins/raphael/raphael-min.js"></script>
        <script src="dist/assets/plugins/morris/morris.min.js"></script>
        <script src="demo/js/dashboard.js"></script>



    </body>
</html>
	<?php } ?>