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
			//->where("branch_id", $branch['id'])
			->where("divisi_id", 4)
			->order('id ASC');
		
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
								<li class="active"><a href="javascript:void(0);"><strong>Input Checklist</a></strong></li>
								<li <?php if($body == 'lihat_checklist'){echo 'active';}?>><a href="lihat-checklist-f&b.php"><strong>Lihat Checklist</a></strong></li>
							</ul>
							<div class="tab-content">
								<div class="panel panel-info">
									<div class="panel-heading">
										<h3 class="panel-title">Input Checklist F&B</h3>
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
																		<?php $wasteges = $db->item_wasteges(); ?>
																		<?php $no = 1; ?>
																		<?php foreach ($wasteges as $was){ ?>
																			<div class="panel panel-default item-sub">
																				<div class="panel-heading">
																					<h4 class="panel-title">
																						<a href="#collapse<?php echo $was["id"]; ?>" data-parent="#accordion2" data-toggle="collapse">
																							<b><?php echo $was['name']; ?></b>
																						</a>
																					</h4>
																				</div>
																				<div class="panel-collapse collapse" id="collapse<?php echo $was["id"]; ?>" style="height: 0px;">
																					<div class="panel-body">
																						<div class="row">

																							<div class="table-responsive form_in_hk">
																								<table data-sortable class="table table-responsive table-hover table-striped" id="form-confirm">
																									<thead>
																										<tr>
																											<th>Description</th>
																											<th>Comment</th>
																											<th style="width:30px;">ACTION</th>
																										</tr>
																									</thead>
																									<tbody>
																										<tr>
																											<td><input style="width: 100%;" class="form-control" type="text" name="description" /></td>
																											<td><input style="width: 100%;" class="form-control" type="text" name="comment" /></td>
																											<td style="text-align:center;">
																												<a href="javascript:void(0);" data-id="<?php echo $was['id']; ?>" class="SubmitChecklist btn btn-md btn-warning" data-style="primary"  data-toggle="tooltip" data-placement="bottom" title="Save Data">
																													Submit
																												</a>
																											</td>
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
																	<?php foreach ($items as $item){ ?>
																		<div class="panel panel-default item-sub">
																			<div class="panel-heading">
																				<h4 class="panel-title">
																					<a href="#collapse<?php echo $item["id"]; ?>" data-parent="#accordion3" data-toggle="collapse">
																						<b><?php echo $item['item_name']; ?></b>
																					</a>
																				</h4>
																			</div>
																			<div class="panel-collapse collapse" id="collapse<?php echo $item["id"]; ?>" style="height: 0px;">
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
																											<li class="<?php echo ($notab==1) ? 'active':''; ?>"><a data-toggle="tab" href="#control<?php echo $item['id'] . '-' . $ctime["id"]; ?>"><b><?php echo $ctime['name']; ?></b></a></li>
																										<?php $notab++; ?>
																										<?php } ?>
																									</ul>
																									<div class="tab-content">
																										<?php $notab = 1; ?>
																										<?php  foreach ($checktime as $ctime){ ?>

																											<div id="control<?php echo $item['id'] . '-' . $ctime["id"]; ?>" class="tab-pane <?php echo ($notab==1) ? 'active':''; ?>">
																												<div clas="row">
																													<div class="table-responsive form_in_hk">

																														<table class="table">
																															<thead>
																																<tr>
																																	<td class="bg-warning" colspan="5" width="100%"><b><?php echo $ctime['description']; ?></td>
																																</tr>
																															</thead>
																															<thead>
																																<tr>
																																	<td colspan="5" width="100%"><b>STATUS</b></td>
																																</tr>
																															</thead>

																															<tbody>
																																<tr style="width:50%;">
																																	<td width="5%">
																																		<div class="radio">
																																			<label>
																																				<input type="radio" value="1" name="status" class="icheck square">
																																				Ada
																																			</label>
																																		</div>
																																		<div class="radio">
																																			<label>
																																				<input type="radio" value="0" name="status" class="icheck square" >
																																				Tidak Ada
																																			</label>
																																		</div>
																																	</td>
																																</tr>
																															</tbody>

																															<thead>
																																<tr>
																																	<td colspan="5" width="100%"><b>PRESENTASI</b></td>
																																</tr>
																															</thead>

																															<tbody>
																																<tr style="width:50%;">
																																	<td width="5%">
																																		<div class="radio">
																																			<label>
																																				<input type="radio" value="1" name="presentasi" class="icheck square">
																																				Baik
																																			</label>
																																		</div>
																																		<div class="radio">
																																			<label>
																																				<input type="radio" value="0" name="presentasi" class="icheck square" >
																																				Kurang
																																			</label>
																																		</div>
																																	</td>
																																</tr>
																															</tbody>

																															<thead>
																																<tr>
																																	<td colspan="5" width="100%"><b>TASTE</b></td>
																																</tr>
																															</thead>

																															<tbody>
																																<tr style="width:50%;">
																																	<td width="5%">
																																		<div class="radio">
																																			<label>
																																				<input type="radio" value="1" name="taste" class="icheck square">
																																				Baik
																																			</label>
																																		</div>
																																		<div class="radio">
																																			<label>
																																				<input type="radio" value="0" name="taste" class="icheck square" >
																																				Kurang
																																			</label>
																																		</div>
																																	</td>
																																</tr>
																															</tbody>

																															<thead>
																																<tr>
																																	<td colspan="5" width="100%"><b>KETERANGAN</b></td>
																																</tr>
																															</thead>

																															<tbody>
																																<tr style="width:50%;">
																																	<td width="5%">
																																		<textarea name="keterangan" id="keterangan" class="form-control" rows="4" placeholder=""></textarea>
																																	</td>
																																</tr>
																															</tbody>
																															<thead>
																																<tr>
																																	<td colspan="5" width="100%"><b>Insert Photo </b>(Optional)</td>
																																</tr>
																															</thead>

																															<tbody>
																																<tr style="width:50%;">
																																	<td width="5%">
																																		<a href="javascript:void(0);" data-id="<?php echo $item['id']; ?>" data-header="<?php echo $ctime["id"]; ?>" class="ImgUpload btn btn-primary" data-style="primary"  data-toggle="tooltip" data-placement="bottom" title="Click to Upload Photo!"><i class="fa fa-image"></i></a>
																																	</td>
																																</tr>
																															</tbody>

																														</table>
																													</div>

																													<div class="col-md-12">
																														<div class="row">
																															<div class="btn-action pull-right">
																																<input type="hidden" name="id" value="<?php echo $item["id"]; ?>" data-id="<?php echo $item["id"]; ?>" />
																																<a href="#collapse<?php echo $item['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Cancel</a>
																																<button type="submit" onClick="" id="submit_btn_hk" name="submit" data-id="<?php echo $item["id"]; ?>" data-header="<?php echo $ctime["id"]; ?>" onClick="" class="btn btn-primary submit_checklist_buffet">Simpan</button>
																																<!--<a class="btn btn-primary btn-sm">Simpan</a>-->
																																<br/>
																																<br/>
																															</div>
																														</div>
																													</div>

																													<div id="" class="modalUpload modal fade in" data-backdrop="static">
																														<div class="modal-dialog">
																															<div id="" class="modal-content">
																																<div class="modal-body">
																																	<div class="modal-title">
																																		<ul class="nav nav-pills" id="ImgTab">
																																			<li class="active">
																																			</li>
																																		</ul>
																																	</div>

																																	<div id="" class="content tab-content">
																																		<div class="uploadContainer" id="uploadContainer">
																																			<form method="post" name="multiple_upload_form" class="multiple_upload_form" enctype="multipart/form-data" action="action/upload_image_buffet.php">
																																				<input type="hidden" name="image_form_submit" value="<?php echo $item['id']; ?>"/>
																																				<input type="hidden" name="ctime" value="<?php echo $ctime['id']; ?>"/>
																																				<label>Choose Image</label>
																																				<input type="file" name="images[]" class="images" multiple >
																																				<div class="uploading hidden-up">
																																					<label>&nbsp;</label>
																																					<img src="assets/img/uploading.gif" alt="uploading......"/>
																																				</div>
																																			</form>
																																		</div>
																																		<div class="gallery" id="images_preview<?php echo $item['id']; ?>" style="margin-top:20px;"></div>
																																	</div>

																																</div>
																																<div class="modal-footer">
																																	<button type="button" class="btn btn-primary close-modal">Done</button>
																																</div>
																															</div>
																														</div>
																													</div>


																													<div class="col-lg-12">
																														<div class="row">
																															<div class="col-lg-12 success-status">

																															</div>
																														</div>
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
																		$connect1 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																		$query1 = mysqli_query($connect1,"SELECT * FROM item WHERE item_area_id = '26'");
																		while($data1 = mysqli_fetch_array($query1,MYSQLI_ASSOC)){
																	?>
																		<div class="panel panel-default item-sub">
																			<div class="panel-heading">
																				<h4 class="panel-title">
																					<a href="#collapse<?php echo $data1["id"]; ?>" data-parent="#accordion4" data-toggle="collapse">
																						<b><?php echo $data1['item_name']; ?></b>
																					</a>
																				</h4>
																			</div>
																			<div class="panel-collapse collapse" id="collapse<?php echo $data1["id"]; ?>" style="height: 0px;">
																				<div class="panel-body">
																					<div class="row">
																						<div class="table-responsive form_in_hk">
																								<table class="table">
																									<thead>
																										<tr>
																											<td colspan="5" width="100%"><b>KONDISI</b></td>
																										</tr>
																									</thead>
																									<tbody>
																										<tr style="width:50%;">
																											<td width="5%">
																												<div class="radio">
																													<label>
																														<input type="radio" value="3" name="kondisi" class="icheck square">
																														Bersih
																													</label>
																												</div>
																												<div class="radio">
																													<label>
																														<input type="radio" value="4" name="kondisi" class="icheck square" >
																														Kotor
																													</label>
																												</div>
																											</td>
																										</tr>
																									</tbody>
																									<thead>
																										<tr>
																											<td colspan="5" width="100%"><b>STATUS</b></td>
																										</tr>
																									</thead>
																									<tbody>
																										<tr style="width:50%;">
																											<td width="5%">
																												<div class="radio">
																													<label>
																														<input type="radio" value="1" name="status" class="icheck square">
																														Lengkap
																													</label>
																												</div>
																												<div class="radio">
																													<label>
																														<input type="radio" value="2" name="status" class="icheck square" >
																														Tidak Lengkap
																													</label>
																												</div>
																											</td>
																										</tr>
																									</tbody>
																									<thead>
																										<tr>
																											<td colspan="5" width="100%"><b>FUNGSI</b></td>
																										</tr>
																									</thead>
																									<tbody>
																										<tr style="width:50%;">
																											<td colspan="5" width="100%">
																												<div class="radio">
																													<label>
																														<input type="radio" value="1" name="fungsi" class="icheck square">
																														Baik
																													</label>
																												</div>
																												<div class="radio">
																													<label>
																														<input type="radio" value="2" name="fungsi" class="icheck square">
																														Rusak
																													</label>
																												</div>
																											</td>
																										</tr>
																									</tbody>
																									<thead>
																										<tr>
																											<td colspan="5" width="100%"><b>KETERANGAN</b></td>
																										</tr>
																									</thead>
																									<tbody>
																										<tr style="width:50%;">
																											<td width="5%">
																												<textarea name="keterangan" id="keterangan" class="form-control" rows="4" placeholder=""></textarea>
																											</td>
																										</tr>
																									</tbody>
																									<thead>
																										<tr>
																											<td colspan="5" width="100%"><b>Insert Photo </b>(Optional)</td>
																										</tr>
																									</thead>
																									<tbody>
																										<tr style="width:50%;">
																											<td width="5%">
																												<a href="javascript:void(0);" data-id="<?php echo $data1['id']; ?>" class="ImgUpload btn btn-primary" data-style="primary"  data-toggle="tooltip" data-placement="bottom" title="Click to Upload Photo!"><i class="fa fa-image"></i></a>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																								<div class="col-lg-12">
																									<div class="row">
																										<div class="btn-action pull-right">
																											<input type="hidden" name="id" value="<?php echo $data1["id"]; ?>" data-id="<?php echo $data1["id"]; ?>" />
																											<a href="#collapse<?php echo $data1['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Cancel</a>
																											<button type="submit" onClick="" id="submit_btn_hk" name="submit" data-id="<?php echo $data1["id"]; ?>" onClick="" class="btn btn-primary submit_checklist_hk">Simpan</button>
																											<br/>
																											<br/>
																										</div>
																									</div>
																								</div>
																								<div id="" class="modalUpload modal fade in" data-backdrop="static">
																									<div class="modal-dialog">
																										<div id="" class="modal-content">
																											<div class="modal-body">
																												<div class="modal-title">
																													<ul class="nav nav-pills" id="ImgTab">
																														<li class="active">
																														</li>
																													</ul>
																												</div>
																												<div id="" class="content tab-content">
																													<div class="uploadContainer" id="uploadContainer">
																														<form method="post" name="multiple_upload_form" class="multiple_upload_form" enctype="multipart/form-data" action="action/upload_images.php">
																															<input type="hidden" name="image_form_submit" value="<?php echo $data1['id']; ?>"/>
																															<label>Choose Image</label>
																															<input type="file" name="images[]" class="images" multiple >
																															<div class="uploading hidden-up">
																																<label>&nbsp;</label>
																																<img src="assets/img/uploading.gif" alt="uploading......"/>
																															</div>
																														</form>
																													</div>
																													<div class="gallery" id="images_preview<?php echo $data1['id']; ?>" style="margin-top:20px;"></div>
																												</div>
																											</div>
																											<div class="modal-footer">
																												<button type="button" class="btn btn-primary close-modal">Done</button>
																											</div>
																										</div>
																									</div>
																								</div>
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

																<?php if($item_area_id == 27){ ?>
																	<div class="title panel panel-info">
																		<div class="panel-heading">
																			<h3 class="panel-title">Item</h3>
																		</div>
																	</div>
																	<div class="panel-group" id="accordion4">
																	<?php
																		$connect2 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																		$query2 = mysqli_query($connect2,"SELECT * FROM item WHERE item_area_id = '27'");
																		while($data2 = mysqli_fetch_array($query2,MYSQLI_ASSOC)){
																	?>
																		<div class="panel panel-default item-sub">
																			<div class="panel-heading">
																				<h4 class="panel-title">
																					<a href="#collapse<?php echo $data2["id"]; ?>" data-parent="#accordion4" data-toggle="collapse">
																						<b><?php echo $data2['item_name']; ?></b>
																					</a>
																				</h4>
																			</div>
																			<div class="panel-collapse collapse" id="collapse<?php echo $data2["id"]; ?>" style="height: 0px;">
																				<div class="panel-body">
																					<div class="row">
																						<div class="table-responsive form_in_hk">
																								<table class="table">
																									<thead>
																										<tr>
																											<td colspan="5" width="100%"><b>KONDISI</b></td>
																										</tr>
																									</thead>
																									<tbody>
																										<tr style="width:50%;">
																											<td width="5%">
																												<div class="radio">
																													<label>
																														<input type="radio" value="3" name="kondisi" class="icheck square">
																														Bersih
																													</label>
																												</div>
																												<div class="radio">
																													<label>
																														<input type="radio" value="4" name="kondisi" class="icheck square" >
																														Kotor
																													</label>
																												</div>
																											</td>
																										</tr>
																									</tbody>
																									<thead>
																										<tr>
																											<td colspan="5" width="100%"><b>STATUS</b></td>
																										</tr>
																									</thead>
																									<tbody>
																										<tr style="width:50%;">
																											<td width="5%">
																												<div class="radio">
																													<label>
																														<input type="radio" value="1" name="status" class="icheck square">
																														Lengkap
																													</label>
																												</div>
																												<div class="radio">
																													<label>
																														<input type="radio" value="2" name="status" class="icheck square" >
																														Tidak Lengkap
																													</label>
																												</div>
																											</td>
																										</tr>
																									</tbody>
																									<thead>
																										<tr>
																											<td colspan="5" width="100%"><b>FUNGSI</b></td>
																										</tr>
																									</thead>
																									<tbody>
																										<tr style="width:50%;">
																											<td colspan="5" width="100%">
																												<div class="radio">
																													<label>
																														<input type="radio" value="1" name="fungsi" class="icheck square">
																														Baik
																													</label>
																												</div>
																												<div class="radio">
																													<label>
																														<input type="radio" value="2" name="fungsi" class="icheck square">
																														Rusak
																													</label>
																												</div>
																											</td>
																										</tr>
																									</tbody>
																									<thead>
																										<tr>
																											<td colspan="5" width="100%"><b>KETERANGAN</b></td>
																										</tr>
																									</thead>
																									<tbody>
																										<tr style="width:50%;">
																											<td width="5%">
																												<textarea name="keterangan" id="keterangan" class="form-control" rows="4" placeholder=""></textarea>
																											</td>
																										</tr>
																									</tbody>
																									<thead>
																										<tr>
																											<td colspan="5" width="100%"><b>Insert Photo </b>(Optional)</td>
																										</tr>
																									</thead>
																									<tbody>
																										<tr style="width:50%;">
																											<td width="5%">
																												<a href="javascript:void(0);" data-id="<?php echo $data2['id']; ?>" class="ImgUpload btn btn-primary" data-style="primary"  data-toggle="tooltip" data-placement="bottom" title="Click to Upload Photo!"><i class="fa fa-image"></i></a>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																								<div class="col-lg-12">
																									<div class="row">
																										<div class="btn-action pull-right">
																											<input type="hidden" name="id" value="<?php echo $data2["id"]; ?>" data-id="<?php echo $data2["id"]; ?>" />
																											<a href="#collapse<?php echo $data2['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Cancel</a>
																											<button type="submit" onClick="" id="submit_btn_hk" name="submit" data-id="<?php echo $data2["id"]; ?>" onClick="" class="btn btn-primary submit_checklist_hk">Simpan</button>
																											<br/>
																											<br/>
																										</div>
																									</div>
																								</div>
																								<div id="" class="modalUpload modal fade in" data-backdrop="static">
																									<div class="modal-dialog">
																										<div id="" class="modal-content">
																											<div class="modal-body">
																												<div class="modal-title">
																													<ul class="nav nav-pills" id="ImgTab">
																														<li class="active">
																														</li>
																													</ul>
																												</div>
																												<div id="" class="content tab-content">
																													<div class="uploadContainer" id="uploadContainer">
																														<form method="post" name="multiple_upload_form" class="multiple_upload_form" enctype="multipart/form-data" action="action/upload_images.php">
																															<input type="hidden" name="image_form_submit" value="<?php echo $data2['id']; ?>"/>
																															<label>Choose Image</label>
																															<input type="file" name="images[]" class="images" multiple >
																															<div class="uploading hidden-up">
																																<label>&nbsp;</label>
																																<img src="assets/img/uploading.gif" alt="uploading......"/>
																															</div>
																														</form>
																													</div>
																													<div class="gallery" id="images_preview<?php echo $data2['id']; ?>" style="margin-top:20px;"></div>
																												</div>
																											</div>
																											<div class="modal-footer">
																												<button type="button" class="btn btn-primary close-modal">Done</button>
																											</div>
																										</div>
																									</div>
																								</div>
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

																<?php if($item_area_id == 28){ ?>
																	<div class="title panel panel-info">
																		<div class="panel-heading">
																			<h3 class="panel-title">Item</h3>
																		</div>
																	</div>
																	<div class="panel-group" id="accordion4">
																	<?php
																		$connect3 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																		$query3 = mysqli_query($connect3,"SELECT * FROM item WHERE item_area_id = '28'");
																		while($data3 = mysqli_fetch_array($query3,MYSQLI_ASSOC)){
																	?>
																		<div class="panel panel-default item-sub">
																			<div class="panel-heading">
																				<h4 class="panel-title">
																					<a href="#collapse<?php echo $data3["id"]; ?>" data-parent="#accordion4" data-toggle="collapse">
																						<b><?php echo $data3['item_name']; ?></b>
																					</a>
																				</h4>
																			</div>
																			<div class="panel-collapse collapse" id="collapse<?php echo $data3["id"]; ?>" style="height: 0px;">
																				<div class="panel-body">
																					<div class="row">
																						<div class="table-responsive form_in_hk">
																								<table class="table">
																									<thead>
																										<tr>
																											<td colspan="5" width="100%"><b>KONDISI</b></td>
																										</tr>
																									</thead>
																									<tbody>
																										<tr style="width:50%;">
																											<td width="5%">
																												<div class="radio">
																													<label>
																														<input type="radio" value="3" name="kondisi" class="icheck square">
																														Bersih
																													</label>
																												</div>
																												<div class="radio">
																													<label>
																														<input type="radio" value="4" name="kondisi" class="icheck square" >
																														Kotor
																													</label>
																												</div>
																											</td>
																										</tr>
																									</tbody>
																									<thead>
																										<tr>
																											<td colspan="5" width="100%"><b>STATUS</b></td>
																										</tr>
																									</thead>
																									<tbody>
																										<tr style="width:50%;">
																											<td width="5%">
																												<div class="radio">
																													<label>
																														<input type="radio" value="1" name="status" class="icheck square">
																														Lengkap
																													</label>
																												</div>
																												<div class="radio">
																													<label>
																														<input type="radio" value="2" name="status" class="icheck square" >
																														Tidak Lengkap
																													</label>
																												</div>
																											</td>
																										</tr>
																									</tbody>
																									<thead>
																										<tr>
																											<td colspan="5" width="100%"><b>FUNGSI</b></td>
																										</tr>
																									</thead>
																									<tbody>
																										<tr style="width:50%;">
																											<td colspan="5" width="100%">
																												<div class="radio">
																													<label>
																														<input type="radio" value="1" name="fungsi" class="icheck square">
																														Baik
																													</label>
																												</div>
																												<div class="radio">
																													<label>
																														<input type="radio" value="2" name="fungsi" class="icheck square">
																														Rusak
																													</label>
																												</div>
																											</td>
																										</tr>
																									</tbody>
																									<thead>
																										<tr>
																											<td colspan="5" width="100%"><b>KETERANGAN</b></td>
																										</tr>
																									</thead>
																									<tbody>
																										<tr style="width:50%;">
																											<td width="5%">
																												<textarea name="keterangan" id="keterangan" class="form-control" rows="4" placeholder=""></textarea>
																											</td>
																										</tr>
																									</tbody>
																									<thead>
																										<tr>
																											<td colspan="5" width="100%"><b>Insert Photo </b>(Optional)</td>
																										</tr>
																									</thead>
																									<tbody>
																										<tr style="width:50%;">
																											<td width="5%">
																												<a href="javascript:void(0);" data-id="<?php echo $data3['id']; ?>" class="ImgUpload btn btn-primary" data-style="primary"  data-toggle="tooltip" data-placement="bottom" title="Click to Upload Photo!"><i class="fa fa-image"></i></a>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																								<div class="col-lg-12">
																									<div class="row">
																										<div class="btn-action pull-right">
																											<input type="hidden" name="id" value="<?php echo $data3["id"]; ?>" data-id="<?php echo $data3["id"]; ?>" />
																											<a href="#collapse<?php echo $data3['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Cancel</a>
																											<button type="submit" onClick="" id="submit_btn_hk" name="submit" data-id="<?php echo $data3["id"]; ?>" onClick="" class="btn btn-primary submit_checklist_hk">Simpan</button>
																											<br/>
																											<br/>
																										</div>
																									</div>
																								</div>
																								<div id="" class="modalUpload modal fade in" data-backdrop="static">
																									<div class="modal-dialog">
																										<div id="" class="modal-content">
																											<div class="modal-body">
																												<div class="modal-title">
																													<ul class="nav nav-pills" id="ImgTab">
																														<li class="active">
																														</li>
																													</ul>
																												</div>
																												<div id="" class="content tab-content">
																													<div class="uploadContainer" id="uploadContainer">
																														<form method="post" name="multiple_upload_form" class="multiple_upload_form" enctype="multipart/form-data" action="action/upload_images.php">
																															<input type="hidden" name="image_form_submit" value="<?php echo $data3['id']; ?>"/>
																															<label>Choose Image</label>
																															<input type="file" name="images[]" class="images" multiple >
																															<div class="uploading hidden-up">
																																<label>&nbsp;</label>
																																<img src="assets/img/uploading.gif" alt="uploading......"/>
																															</div>
																														</form>
																													</div>
																													<div class="gallery" id="images_preview<?php echo $data3['id']; ?>" style="margin-top:20px;"></div>
																												</div>
																											</div>
																											<div class="modal-footer">
																												<button type="button" class="btn btn-primary close-modal">Done</button>
																											</div>
																										</div>
																									</div>
																								</div>
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