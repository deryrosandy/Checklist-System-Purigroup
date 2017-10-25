<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}else{
		include 'core/init.php';
		include 'core/helper/myHelper.php';
		
		$branch = $db->branch()
			->where("id", $_SESSION['branch_id'])->fetch();
		
		$user = $db->users()
			->where("id", $_SESSION['id'])->fetch();
		
		$allarea = $db->item_area()
			->where("divisi_id", 4)
			->order('id ASC');
		$dt = new DateTime();
		$today = $dt->format('Y-m-d');
		
		$body = 'checklist';
?>

<!doctype html>
<html>
	<head>
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
		<link rel="stylesheet" href="dist/css/plugins/bootstrap-switch.min.css">
		<link rel="stylesheet" href="dist/css/plugins/jquery-chosen.min.css">
        <link rel="stylesheet" href="dist/css/plugins/jquery-select2.min.css">
        <link rel="stylesheet" href="dist/css/plugins/jquery-dataTables.min.css">
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
						<li class=""><a href="javascript:;">Checklist F&B</a></li>
						<li class="active"><a href="javascript:;">-</a></li>
					</ol>
				</div>
				<div class="page-heading page-heading-md">
					<h3 class="pull-left">Outlet : <?php echo ucwords($branch["name"]); ?></h3>
					<div class="col-button-colors pull-right">
						<a href="checklist.php" class="btn btn-primary">Kembali</a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="container-fluid-md">
					<div class="row">
						<div class="col-md-12">
							<ul class="nav nav-pills">
								<?php if ($user['user_type'] != 'manager'){ ?>
									<li <?php if($body == 'lihat_checklist'){echo 'active';}?>><a href="checklist-f&b.php"><strong>Input Checklist</a></strong></li>
								<?php } ?>
								<li class="active"><a href="javascript:void(0);"><strong>Lihat Checklist</a></strong></li>
							</ul>
							<div class="tab-content">
								<div class="panel panel-info">
									<div class="panel-heading">
										<h3 class="panel-title">Data Checklist F&B</h3>
									</div>
								</div>
								<div class="widget-content">
									<div class="content-left col-sm-3">
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
									<div class="main-content col-sm-9">
										<div class="row">
											<div class="tab-content">
												<?php
													$notab = 1;
													foreach ($allarea as $area){

													$item_area_id = $area['id'];
													//var_dump ($item_area_id);
													$items = $db->item()
														->where("item_area_id", $item_area_id);
												?>
													<div id="tabarea-<?php echo $area['id']; ?>" class="tab-pane <?php echo ($notab==1) ? 'active':''; ?>">
														<div class="row">
															<?php if($area['id'] == 29){ ?>
																<div class="title panel panel-info">
																	<div class="panel-heading">
																		<h3 class="panel-title">Wasteges</h3>
																	</div>
																</div>
																<div id="accordion2" class="panel-group">
																	<?php
																		$connect29 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																		$date_now = date('Y-m-d');
																		$query29 = mysqli_query($connect29,"SELECT * FROM checklist_buffet_wasteges WHERE CONVERT(checked_at, date) = '$date_now'");
																		while($data29 = mysqli_fetch_array($query29,MYSQLI_ASSOC)){
																	?>
																	<div class="panel panel-default item-sub">
																		<div class="panel-heading">
																			<h4 class="panel-title">
																				<?php
																					$query29_1 = mysqli_query($connect29,"SELECT * FROM item_wasteges WHERE id = '".$data29['item_wasteges_id']."'");
																					$data29_1 = mysqli_fetch_array($query29_1,MYSQLI_ASSOC);
																				?>
																				<a href="#collapse<?php echo $data29_1["id"]; ?>" data-parent="#accordion2" data-toggle="collapse">
																					<b><?php echo $data29_1['name']; ?></b>
																				</a>
																			</h4>
																		</div>
																		<div class="panel-collapse collapse" id="collapse<?php echo $data29_1["id"]; ?>" style="height: 0px;">
																			<div class="panel-body">
																				<div class="row">
																					<div class="table-responsive form_in_hk">
																						<table data-sortable class="table table-responsive table-hover table-striped" id="form-confirm">
																							<thead>
																								<tr>
																									<th>Description</th>
																									<th>Comment</th>
																								</tr>
																							</thead>
																							<tbody>
																								<tr>
																									<td><input style="width: 100%;" class="form-control" type="text" name="description" value="<?php echo $data29['description']; ?>" disabled></td>
																									<td><input style="width: 100%;" class="form-control" type="text" name="comment" value="<?php echo $data29['comment']; ?>" disabled></td>
																								</tr>
																							</tbody>
																						</table>
																						<div class="col-lg-12">
																							<div class="row">
																								<div class="col-lg-12 success-status">
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<?php } ?>
																</div>
															<?php } ?>

															<?php if($item_area_id == 29){ ?>
																<div class="title panel panel-info">
																	<div class="panel-heading">
																		<h3 class="panel-title">Item</h3>
																	</div>
																</div>
																<div class="panel-group" id="accordion3">
																	<?php
																		$connect29_2 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																		$date_now = date('Y-m-d');
																		$query29_2 = mysqli_query($connect29_2,"SELECT DISTINCT item_id FROM checklist_buffet WHERE CONVERT(checked_at, date) = '$date_now'");
																		while($data29_2 = mysqli_fetch_array($query29_2,MYSQLI_ASSOC)){
																	?>
																	<div class="panel panel-default item-sub">
																		<div class="panel-heading">
																			<h4 class="panel-title">
																				<?php
																					$query29_3 = mysqli_query($connect29_2,"SELECT * FROM item WHERE id = '".$data29_2['item_id']."'");
																					$data29_3 = mysqli_fetch_array($query29_3,MYSQLI_ASSOC);
																				?>
																				<a href="#collapse<?php echo $data29_3["id"]; ?>" data-parent="#accordion3" data-toggle="collapse">
																					<b><?php echo $data29_3['item_name']; ?></b>
																				</a>
																			</h4>
																		</div>
																		<div class="panel-collapse collapse" id="collapse<?php echo $data29_3["id"]; ?>" style="height: 0px;">
																			<div class="panel-body">
																				<div class="row">
																					<div class="table-responsive form_in_hk">
																						<div class="row">
																							<div class="col-md-12">
																								<ul class="nav nav-tabs nav-justified">
																									<?php
																										$checktime = $db->checktime_buffet();
																										$notab = 1;
																										foreach ($checktime as $ctime){
																									?>
																										<li class="<?php echo ($notab==1) ? 'active':''; ?>"><a data-toggle="tab" href="#control<?php echo $data29_3['id'] . '-' . $ctime["id"]; ?>"><b><?php echo $ctime['name']; ?></b></a></li>
																									<?php $notab++; ?>
																									<?php } ?>
																								</ul>
																								<div class="tab-content">
																									<?php $notab = 1; ?>
																									<?php  foreach ($checktime as $ctime){ ?>
																										<div id="control<?php echo $data29_3['id'] . '-' . $ctime["id"]; ?>" class="tab-pane <?php echo ($notab==1) ? 'active':''; ?>">
																											<div clas="row">
																												<div class="table-responsive form_in_hk">
																													<table class="table">
																														<thead>
																															<tr>
																																<td class="bg-warning" colspan="5" width="100%"><b><?php echo $ctime['description']; ?></b></td>
																															</tr>
																														</thead>
																														<thead>
																															<tr>
																																<th>Status</th>
																																<th>Presentasi</th>
																																<th>Taste</th>
																																<th>Keterangan</th>
																															</tr>
																														</thead>
																														<tbody>
																															<tr>
																																<?php
																																	$date_now = date('Y-m-d');
																																	$connect29_4 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																																	$query29_4 = mysqli_query($connect29_4,"SELECT * FROM checklist_buffet WHERE CONVERT(checked_at, date) = '$date_now' AND checktime_buffet_id = '".$ctime["id"]."'");
																																	$data29_4 = mysqli_fetch_array($query29_4,MYSQLI_ASSOC);
																																?>
																																<td>
																																	<?php
																																		if ($data29_4['ready'] == '1') {
																																			echo "Ada";
																																		}
																																		elseif ($data29_4['ready'] == '0') {
																																			echo "Tidak Ada";
																																		}
																																	?>
																																</td>
																																<td>
																																	<?php
																																		if ($data29_4['presentasi'] == '1') {
																																			echo "Baik";
																																		}
																																		elseif ($data29_4['presentasi'] == '0') {
																																			echo "Kurang";
																																		}
																																	?>
																																</td>
																																<td>
																																	<?php
																																		if ($data29_4['taste'] == '1') {
																																			echo "Baik";
																																		}
																																		elseif ($data29_4['taste'] == '0') {
																																			echo "Kurang";
																																		}
																																	?>
																																</td>
																																<td><?php echo ucfirst($data29_4['description']); ?></td>
																															</tr>
																														</tbody>
																													</table>
																												</div>
																											</div>
																										</div>
																									<?php $notab++; ?>
																									<?php } ?>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																<?php } ?>
																</div>
															<?php } ?>

															<?php if($item_area_id == 26){ ?>
																<div class="title panel panel-info">
																	<div class="panel-heading">
																		<h3 class="panel-title">Item</h3>
																	</div>
																</div>
																<div class="panel-group" id="accordion4">
																<?php
																	$connect26 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																	$date_now = date('Y-m-d');
																	$query26 = mysqli_query($connect26,"SELECT DISTINCT c.item_id AS c_item_id FROM item_checklist c, item i WHERE CONVERT(c.checked_at, date) = '$date_now' AND i.item_area_id = '26' AND i.id = c.item_id");
																	while($data26 = mysqli_fetch_array($query26,MYSQLI_ASSOC)){
																?>
																	<div class="panel panel-default item-sub">
																		<div class="panel-heading">
																			<h4 class="panel-title">
																				<?php
																					$query26_1 = mysqli_query($connect26,"SELECT * FROM item WHERE id = '".$data26['c_item_id']."'");
																					$data26_1 = mysqli_fetch_array($query26_1,MYSQLI_ASSOC);
																				?>
																				<a href="#collapse<?php echo $data26_1["id"]; ?>" data-parent="#accordion4" data-toggle="collapse">
																					<b><?php echo $data26_1['item_name']; ?></b>
																				</a>
																			</h4>
																		</div>
																		<div class="panel-collapse collapse" id="collapse<?php echo $data26_1["id"]; ?>" style="height: 0px;">
																			<div class="panel-body">
																				<div class="row">
																					<div class="table-responsive form_in_hk">
																						<table class="table">
																							<thead>
																								<tr>
																									<th>Kondisi</th>
																									<th>Status</th>
																									<th>Fungsi</th>
																									<th>Keterangan</th>
																								</tr>
																							</thead>
																							<tbody>
																								<?php
																									$date_now = date('Y-m-d');
																									$connect26_3 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																									$query26_3 = mysqli_query($connect26_3,"SELECT * FROM item_checklist WHERE CONVERT(checked_at, date) = '$date_now' AND item_id = '".$data26_1["id"]."'");
																									$data26_3 = mysqli_fetch_array($query26_3,MYSQLI_ASSOC);
																								?>
																								<tr>
																									<td>
																										<?php
																											if ($data26_3['item_kondisi_id'] == '1') {
																												echo "Bersih";
																											}
																											elseif ($data26_3['item_kondisi_id'] == '2') {
																												echo "Kotor";
																											}
																										?>
																									</td>
																									<td>
																										<?php
																											if ($data26_3['item_status_id'] == '3') {
																												echo "Lengkap";
																											}
																											elseif ($data26_3['item_status_id'] == '4') {
																												echo "Tidak Lengkap";
																											}
																										?>
																									</td>
																									<td>
																										<?php
																											if ($data26_3['item_fungsi_id'] == '1') {
																												echo "Baik";
																											}
																											elseif ($data26_3['item_fungsi_id'] == '2') {
																												echo "Rusak";
																											}
																										?>
																									</td>
																									<td><?php echo ucfirst($data26_3['description']); ?></td>
																								</tr>
																							<tbody>
																						</table>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																<?php } ?>
																</div>
															<?php } ?>

															<?php if($item_area_id == 27){ ?>
																<div class="title panel panel-info">
																	<div class="panel-heading">
																		<h3 class="panel-title">Item</h3>
																	</div>
																</div>
																<div class="panel-group" id="accordion4">
																<?php
																	$connect27 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																	$date_now = date('Y-m-d');
																	$query27 = mysqli_query($connect27,"SELECT DISTINCT c.item_id AS c_item_id FROM item_checklist c, item i WHERE CONVERT(c.checked_at, date) = '$date_now' AND i.item_area_id = '27' AND i.id = c.item_id");
																	while($data27 = mysqli_fetch_array($query27,MYSQLI_ASSOC)){
																?>
																	<div class="panel panel-default item-sub">
																		<div class="panel-heading">
																			<h4 class="panel-title">
																				<?php
																					$query27_1 = mysqli_query($connect27,"SELECT * FROM item WHERE id = '".$data27['c_item_id']."'");
																					$data27_1 = mysqli_fetch_array($query27_1,MYSQLI_ASSOC);
																				?>
																				<a href="#collapse<?php echo $data27_1["id"]; ?>" data-parent="#accordion4" data-toggle="collapse">
																					<b><?php echo $data27_1['item_name']; ?></b>
																				</a>
																			</h4>
																		</div>
																		<div class="panel-collapse collapse" id="collapse<?php echo $data27_1["id"]; ?>" style="height: 0px;">
																			<div class="panel-body">
																				<div class="row">
																					<div class="table-responsive form_in_hk">
																						<table class="table">
																							<thead>
																								<tr>
																									<th>Kondisi</th>
																									<th>Status</th>
																									<th>Fungsi</th>
																									<th>Keterangan</th>
																								</tr>
																							</thead>
																							<tbody>
																								<?php
																									$date_now = date('Y-m-d');
																									$connect27_3 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																									$query27_3 = mysqli_query($connect27_3,"SELECT * FROM item_checklist WHERE CONVERT(checked_at, date) = '$date_now' AND item_id = '".$data27_1["id"]."'");
																									$data27_3 = mysqli_fetch_array($query27_3,MYSQLI_ASSOC);
																								?>
																								<tr>
																									<td>
																										<?php
																											if ($data27_3['item_kondisi_id'] == '1') {
																												echo "Bersih";
																											}
																											elseif ($data27_3['item_kondisi_id'] == '2') {
																												echo "Kotor";
																											}
																										?>
																									</td>
																									<td>
																										<?php
																											if ($data27_3['item_status_id'] == '3') {
																												echo "Lengkap";
																											}
																											elseif ($data27_3['item_status_id'] == '4') {
																												echo "Tidak Lengkap";
																											}
																										?>
																									</td>
																									<td>
																										<?php
																											if ($data27_3['item_fungsi_id'] == '1') {
																												echo "Baik";
																											}
																											elseif ($data27_3['item_fungsi_id'] == '2') {
																												echo "Rusak";
																											}
																										?>
																									</td>
																									<td><?php echo ucfirst($data27_3['description']); ?></td>
																								</tr>
																							<tbody>
																						</table>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																<?php } ?>
																</div>
															<?php } ?>

															<?php if($item_area_id == 28){ ?>
																<div class="title panel panel-info">
																	<div class="panel-heading">
																		<h3 class="panel-title">Item</h3>
																	</div>
																</div>
																<div class="panel-group" id="accordion4">
																<?php
																	$connect28 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																	$date_now = date('Y-m-d');
																	$query28 = mysqli_query($connect28,"SELECT DISTINCT c.item_id AS c_item_id FROM item_checklist c, item i WHERE CONVERT(c.checked_at, date) = '$date_now' AND i.item_area_id = '28' AND i.id = c.item_id");
																	while($data28 = mysqli_fetch_array($query28,MYSQLI_ASSOC)){
																?>
																	<div class="panel panel-default item-sub">
																		<div class="panel-heading">
																			<h4 class="panel-title">
																				<?php
																					$query28_1 = mysqli_query($connect28,"SELECT * FROM item WHERE id = '".$data26['c_item_id']."'");
																					$data28_1 = mysqli_fetch_array($query28_1,MYSQLI_ASSOC);
																				?>
																				<a href="#collapse<?php echo $data28_1["id"]; ?>" data-parent="#accordion4" data-toggle="collapse">
																					<b><?php echo $data28_1['item_name']; ?></b>
																				</a>
																			</h4>
																		</div>
																		<div class="panel-collapse collapse" id="collapse<?php echo $data28_1["id"]; ?>" style="height: 0px;">
																			<div class="panel-body">
																				<div class="row">
																					<div class="table-responsive form_in_hk">
																						<table class="table">
																							<thead>
																								<tr>
																									<th>Kondisi</th>
																									<th>Status</th>
																									<th>Fungsi</th>
																									<th>Keterangan</th>
																								</tr>
																							</thead>
																							<tbody>
																								<?php
																									$date_now = date('Y-m-d');
																									$connect28_3 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																									$query28_3 = mysqli_query($connect28_3,"SELECT * FROM item_checklist WHERE CONVERT(checked_at, date) = '$date_now' AND item_id = '".$data28_1["id"]."'");
																									$data28_3 = mysqli_fetch_array($query28_3,MYSQLI_ASSOC);
																								?>
																								<tr>
																									<td>
																										<?php
																											if ($data28_3['item_kondisi_id'] == '1') {
																												echo "Bersih";
																											}
																											elseif ($data28_3['item_kondisi_id'] == '2') {
																												echo "Kotor";
																											}
																										?>
																									</td>
																									<td>
																										<?php
																											if ($data28_3['item_status_id'] == '3') {
																												echo "Lengkap";
																											}
																											elseif ($data28_3['item_status_id'] == '4') {
																												echo "Tidak Lengkap";
																											}
																										?>
																									</td>
																									<td>
																										<?php
																											if ($data28_3['item_fungsi_id'] == '1') {
																												echo "Baik";
																											}
																											elseif ($data28_3['item_fungsi_id'] == '2') {
																												echo "Rusak";
																											}
																										?>
																									</td>
																									<td><?php echo ucfirst($data28_3['description']); ?></td>
																								</tr>
																							<tbody>
																						</table>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																<?php } ?>
																</div>
															<?php } ?>
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
        </div>
		
		<?php include ('_footer.php'); ?>
		
		
        <script src="dist/assets/libs/jquery/jquery.min.js"></script>
        <script src="dist/assets/libs/jquery/jquery.form.js"></script>
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
		<script src="dist/assets/plugins/jquery-chosen/chosen.jquery.min.js"></script>
        <script src="dist/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
		<script src="dist/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="demo/js/tables-data-tables.js"></script>
		<script src="demo/js/demo.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".form_in_hk").on("click", ".submit_checklist_hk", function(){ 
					
					var parentObj = $(this).closest('.item-sub');
					
					var id 				= parentObj.find('#submit_btn_hk').attr('data-id');
					var kondisi			= parentObj.find('input[name="kondisi"]:checked').val();
					var status			= parentObj.find('input[name="status"]:checked').val();
					var fungsi 			= parentObj.find('input[name="fungsi"]:checked').val();
					var keterangan	 	= parentObj.find('textarea[name="keterangan"]').val();

					var proceed = true;
					var statusresult = parentObj.find(".success-status").hide();
					
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id,kondisi,status,fungsi,keterangan
						};
						
						//Ajax post data to server
						$.post('action/insert_checklist_hk.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ 
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = response.text;
							}
							
							$(statusresult).html(output).slideDown();
							
						}, 'json');
					}
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".form_in_hk").on("click", ".submit_checklist_buffet", function(){ 
					
					 var parentObj = $(this).closest('.item-sub .tab-pane');
					
					var id 				= parentObj.find('#submit_btn_hk').attr('data-id');
					var idcek 			= parentObj.find('#submit_btn_hk').attr('data-header');
					var status			= parentObj.find('input[name="status"]:checked').val();
					var presentasi		= parentObj.find('input[name="presentasi"]:checked').val();
					var taste 			= parentObj.find('input[name="taste"]:checked').val();
					var keterangan	 	= parentObj.find('textarea[name="keterangan"]').val();

					var proceed = true;
					var statusresult = parentObj.find(".success-status").hide();
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id,idcek,status,presentasi,taste,keterangan
						};
						
						//Ajax post data to server
						$.post('action/insert_checklist_buffet.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ 
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = response.text;
							}
							
							parentObj.find(".success-status").hide().html(output).slideDown();
							//$(statusresult).html(output).slideDown();
							
						}, 'json');
					}
				});
			});
		</script>
		<!-- Script For Modal Image Upload -->
		<script type="text/javascript">
			$(document).on('click', '.ImgUpload', function() {
				$(".modalUpload").modal('show');
			});
			
			$(document).ready(function(){
				$(".form_in_hk").on("change", ".images", function(){ 
				
			//$(document).on('change', '.images', function(){
				
				var parentObj = $(this).closest('.item-sub');
				
				var id = parentObj.find('.ImgUpload').attr('data-id');
				
				$(parentObj.find('.multiple_upload_form')).ajaxForm({
					
						//display the uploaded images
						data: id,
						target:'#images_preview'+id,
						success: function(response){
							 
						},
						beforeSubmit:function(e){
							$('.uploading').show();
						},
						success:function(e){
							$('.uploading').hide();
						},
						error:function(e){
						}
					}).submit();
				});
			});
			
			$(document).on('click', '.close-modal', function() {
				var parentObj = $(this).closest('.item-sub');
				var id = parentObj.find('.id_item').val();
				
				$(".modalUpload").modal('hide');
				$("#images_preview"+id).val('');
			});
			
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on("click", ".SubmitChecklist", function(){ 
					
					var parentObj = $(this).closest('.item-sub');
					
					var id 				= parentObj.find('.SubmitChecklist').attr('data-id');
					var description		= parentObj.find('input[name="description"]').val();
					var comment			= parentObj.find('input[name="comment"]').val();
	
					var proceed = true;
					var statusresult = $(".success-status").hide();
					
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id,description,comment
						};
						//Ajax post data to server
						$.post('action/insert_checklist_wasteges.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ //load json data from server and output message     
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = '<div class="success">'+response.text+'</div>';
							}
							
							parentObj.find(".success-status").hide().html(output).slideDown();
							//$(statusresult).html(output).slideDown();
							//parentObj.find(".success-status").hide().html(output).slideDown();
							
						}, 'json');
					}
				});
			});
		</script>
    </body>
</html>
<?php } ?>