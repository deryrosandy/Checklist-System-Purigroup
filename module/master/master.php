<?php		
		if (!empty($_GET['page'])){
			$page = $_GET['page'];
		}else{
			$page= 'mutasi-user';
		};
		
		$divisi_id = $_SESSION['divisi_id'];
		$branch_id = $_SESSION['branch_id'];
		
		$user = $db->users()
			->where("id", $_SESSION['id'])->fetch();
		
		if($user['user_type'] == 'administrator'){
			$items = $db->item();
		}else{
			$items = $db->item()
						->where("branch_id", $branch_id);
		}
		$item_area  = $db->item_area()
						->where("branch_id", $branch_id);
						
		//var_dump (count($branch_id));
		//die();
						
		$branch = $db->branch();
		$divisi = $db->divisi();
		$manager_p = $db->users()
						->where("user_type", "manager pengganti");
		
		$body = 'master';

		include 'alert/alert.php';
?>

<!doctype html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html> <!--<![endif]-->
<head>
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Checklist System</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <!--<link rel="shortcut icon" href="/favicon.ico">-->
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
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
					<h3 class="pull-left">Config Master</h3>
					<div class="col-button-colors pull-right">
						<a href="dashboard.php" class="btn btn-primary">Back</a>
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="container-fluid-md">
					<div class="row">
						<div class="col-lg-11">
							<ul class="nav nav-pills">
								<?php if(($user_type == 'administrator') || ($user_type == 'manager')){ ?>
									<li class="<?php echo $page == 'mutasi-user' ? 'active' : ''; ?>"><a data-toggle="" href="content.php?module=master&page=mutasi-user"><strong>MANAGER PENGGANTI</a></strong></li>
								<?php } ?>
								<?php if($user_type == 'administrator'){ ?>
									<li class="<?php echo $page == 'item' ? 'active' : ''; ?>"><a data-toggle="" href="content.php?module=master&page=item"><strong>ITEM</a></strong></li>					
									<li class="<?php echo $page == 'branch' ? 'active' : ''; ?>"><a data-toggle="" href="content.php?module=master&page=branch"><strong>BRANCH</a></strong></li>
								<?PHP } ?>
							</ul>
							<?php if($page=="mutasi-user"){ ?>				
							<div class="tab-content panel panel-default">
								<div class="panel-heading">
									<div class="row">
										<div class="col-lg-12">
											<div class="col-button-colors pull-left">
												<h1 style="padding-top:10px;" class="panel-title">Manager Pengganti</h1>
											</div>
										</div>
									</div>
								</div>
								<div class="panel-body">
									<div class="row">
									<div class="col-lg-12">
										<div class="panel panel-default" style="background-color: #f9f9f9;">
											<div class="panel-heading">
												<div class="row">
													<div class="col-lg-12">
														<div class="col-button-colors pull-left">
															<h4 class="panel-title">Manager Pengganti Sementara</h4>
															<p>*Pilih nama Manager pengganti, lalu tentukan periode.</p>
														</div>
														<!--
														<div class="col-button-colors pull-right" style="margin-top: 7px;">
															<a href="component/modal/modal-add-user.php"  data-toggle="modal" data-target="#AddUserM" style="margin-bottom: 0px;" class="btn btn-primary">Add New User</a>
														</div>
														-->
													</div>
												</div>
											</div>
											
											<!-- Modal -->
											<div class="modal fade" id="AddUserM" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
													</div> <!-- /.modal-content -->
												</div> <!-- /.modal-dialog -->
											</div> <!-- /.modal -->
										
											<div class="panel-body">
												<form id="AddManagerP" action="module/master/set_manager_pengganti.php" method="POST" role="form" class="">
													<fieldset>
														<div class="form-group">
															<div class="col-lg-4 col-md-4">
																<h4>Select User</h4>
																<select name="id_user" class="form-control form-chosen" data-placeholder="Choose User...">
																	<option value=""></option>
																	<?php foreach($manager_p as $mp){ ?>
																		<option class="required" value="<?php echo $mp['id']; ?>"><?php echo $mp['first_name'] . " " . $mp['last_name']; ?></option>
																	<?php } ?>
																</select>
															</div>
															<div class="col-md-4 col-sm-6 col-lg-2">
																<h4>Start Date</h4>
																<input name="start_date" type="text" class="form-control required" data-rel="datepicker">
															</div>
															<div class="col-md-4 col-sm-6 col-lg-2">
																<h4>End Date</h4>
																<input name="end_date" type="text" class="form-control required" data-rel="datepicker">
															</div>
															<div class="col-md-4">
																<h4>&nbsp;</h4>
																<button type="submit" class="btn btn-primary form-control">Save</button>
															</div>
														</div>
													</fieldset>
													<fieldset>
														&nbsp;
													</fieldset>
												</form>
											</div>	
										</div>	
									</div>
									</div>
									<form id="AddManagerP" action="module/master/set_nonactive_manager_pengganti.php" method="POST" role="form" class="">
										
									<div class="panel-body table-responsive">
										<table data-sortable id="" class="table table-item table-striped">
											<thead>
												<tr>
													<th class="no" style="width:30px">No.</th>
													<th class="name">Name</th>
													<th class="branch">Branch</th>
													<th class="start_date">Start Date</th>
													<th class="end_date">End Date</th>
													<?php if(($user_type == 'administrator') || ($user_type == 'manager')){ ?>
													<th class="action">Action</th>
													<?php } ?>
												</tr>
											</thead>
											<tbody>
											<?php $no = 1; ?>
											
											<?php $date_now =  date('Y-m-d'); ?>
											
											<?php $cekdate = "active_end >= '".$date_now."'"; ?>
											<?php $manager_p_act = $db->users
																	->where("user_type", "manager pengganti")
																	->where($cekdate)
																	->where("active", 1);
											?>
											<?php if(count($manager_p_act) > 0){ ?>
												<?php foreach ($manager_p_act as $mp){ ?>
													<tr class="odd gradeX">
														<td><?php echo $no; ?></td>
														<td><?php echo ucfirst($mp["first_name"] . ' ' . $mp["last_name"]); ?></td>
														<td><?php echo ucfirst($mp->branch["name"]); ?></td>
														<td><?php echo tgl_indo($mp['active_start']); ?></td>
														<td><?php echo tgl_indo($mp['active_end']); ?></td>
														<?php if(($user_type == 'administrator') || ($user_type == 'manager')){ ?>
														<td class="btn-group btn-group-box">
															<?php /*
															<a href="edit-item.php?id=<?php echo $item['id']; ?>" class="btn btn-warning">Edit</a>
															<a href="delete-item.php?id=<?php echo $item['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to Delete ?');">Delete</a>
															*/ ?>
															<input type="hidden" name="id_user" value="<?php echo $mp['id']; ?>" />
															<button type="submit" class="btn btn-danger" style="border-radius: 4px;">Set Non Active</button>
														</td>
														<?php } ?>
													</tr>
												<?php $no++ ?>
												<?php } ?>
											<?php }else{ ?>
												<tr class="odd gradeX">
													<td colspan="6" align="center">Belum Ada Manager Pengganti yang Aktif</td>
												</tr>
											<?php } ?>
											</tbody>
										</table>
									</div>
									</form>
									<br/>
									<br/>
									<br/>
									<br/>
								</div>
							</div>
							<?php } ?>
							
							<!-- For Modul Item -->
							<?php if($page=="item"){ ?>
							<div class="col-lg-12 col-md-12">
								<div class="tab-content panel panel-default">
									<div class="panel-heading">
										<div class="row">
											<div class="col-lg-12">
												<div class="col-button-colors pull-left">
													<h1 style="padding-top:10px;" class="panel-title">List Item</h1>
												</div>
												<div class="col-button-colors pull-right">
													<a href="item_tambah.php" style="margin-bottom: 0px;" class="btn btn-primary">Add New</a>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-body table-responsive">
										<table data-sortable id="table-basic" class="table table-hover table-item table-striped">
											<thead>
												<tr>
													<th class="no" style="width:30px">No.</th>
													<th class="name">Name</th>
													<th class="area" style="width:20%;">Area</th>
													<th class="division">Divisi</th>
													<th class="branch">Branch</th>
													<?php if(($user_type == 'administrator') || ($user_type == 'manager')){ ?>
													<th class="">Action</th>
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
													<?php if(($user_type == 'administrator') || ($user_type == 'manager')){ ?>
													<td class="btn-group-box">
														<?php /*
														<a href="edit-item.php?id=<?php echo $item['id']; ?>" class="btn btn-warning">Edit</a>
														<a href="delete-item.php?id=<?php echo $item['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to Delete ?');">Delete</a>
														*/ ?>
														<table>
															<tr>
																<td valign="top">
																	<a href="javascript:void(0);" class="btn btn-warning">Edit</a>
																</td>
																<td>
																	<form method="post" action="item_hapus.php?id=<?php echo $item['id']; ?>" id="itemhapus<?php echo $item['id']; ?>">
																		<input type="submit" class="btn btn-md btn-danger" value="Delete">
																	</form>
																	<script type="text/javascript">
																		document.querySelector('#itemhapus<?php echo $item['id']; ?>').addEventListener('submit', function(e) {
																			var form = this;
																			e.preventDefault();
																			swal({
																				title: "Apa Anda Yakin?",
																				type: "warning",
																				showCancelButton: true,
																				confirmButtonColor: '#DD6B55',
																				cancelButtonText: "Batal",
																				confirmButtonText: 'Yakin',
																				closeOnConfirm: false,
																				closeOnCancel: false
																			},
																			function(isConfirm) {
																				if (isConfirm) {
																					form.submit();
																				}
																				else {
																					swal("Batal", "", "error");
																				}
																			});
																		});
																	</script>
																</td>
															</tr>
														</table>
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
							<?php }?>
							
							<!-- For Module Item Area -->
							<?php if($page=="item-area"){ ?>
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
									<div class="panel-body table-responsive">
										<table data-sortable id="table-basic" class="table table-hover table-item table-striped">
											<thead>
												<tr>
													<th class="no" style="width:30px">No.</th>
													<th style="width:250px;" class="name">Name</th>
													<th class="branch">Branch</th>
													<?php if(($user_type == 'administrator') || ($user_type == 'manager')){ ?>
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
													<?php if(($user_type == 'administrator') || ($user_type == 'manager')){ ?>
													<td class="btn-group btn-group-box">
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
							<?php } ?>
							
							<!-- For Module Divisi -->
							<?php if($page=="divisi"){ ?>
							<div class="col-lg-8 col-md-10">
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
													<th style="" class="name">Code</th>
													<th class="">Name</th>
													<?php if(($user_type == 'administrator') || ($user_type == 'manager')){ ?>
													<th style="" class="">Action</th>
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
													<?php if(($user_type == 'administrator') || ($user_type == 'manager')){ ?>
													<td class="btn-group btn-group-box">
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
							<?php } ?>
							
							<!-- For Module Branch -->
							<?php if($page=="branch"){ ?>
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
												<?php if(($user_type == 'administrator') || ($user_type == 'manager')){ ?>
												<th style="width:170px;" class="action">Action</th>
												<?php } ?>
											</tr>
										</thead>
										<tbody>
										<?php $no = 1; ?>
										
										<?php foreach ($branch as $brch){ ?>
											<tr class="odd gradeX">
												<td><?php echo $no; ?></td>
												<td><?php echo ($brch["name"]); ?></td>
												<td><?php echo lcfirst($brch["address"]); ?></td>
												<td><?php echo ucfirst($brch['city']); ?></td>
												<td><?php echo ucfirst($brch['phone_number']); ?></td>
												<?php if(($user_type == 'administrator') || ($user_type == 'manager')){ ?>
												<td class="btn-group btn-group-box">
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
		<script src="dist/assets/plugins/jquery-chosen/chosen.jquery.min.js"></script>
		<script src="dist/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
		<script src="dist/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="demo/js/tables-data-tables.js"></script>
		<script src="dist/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$("#AddManagerP").validate();
			})
		</script>
    </body>
</html>