<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION['password'])) {
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
			->where("divisi_id", 3)
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
						<li class=""><a href="javascript:;">Checklist HK</a></li>
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
								<li <?php if($body == 'lihat_checklist'){echo 'active';}?>><a href="lihat-checklist-hk.php"><strong>Lihat Checklist</a></strong></li>
							</ul>
							<div class="tab-content">
								<div class="panel panel-info">
									<div class="panel-heading">
										<h3 class="panel-title">Input Checklist House Keeping</h3>
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
										<div class="tab-content">
											<div class="title panel panel-info">
												<div class="panel-heading">
													<h3 class="panel-title">Equipment & Task</h3>
												</div>
											</div>
										<?php
											$notab = 1;
											foreach ($allarea as $area){
												$item_area_id = $area['id'];
												$items = $db->item()
													->where("item_area_id", $item_area_id);
										?>
											<div id="tabarea-<?php echo $area['id']; ?>" class="tab-pane <?php echo ($notab==1) ? 'active':''; ?>">
												<div id="accordion" class="panel-group">
													<div class="row">

														<!-- SUB. SEKSI LOKER -->
														<?php if($item_area_id == 7){ ?>
															<div class="accordion" id="myAccordion1">
															<?php
																$connect1 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																$query1 = mysqli_query($connect1,"SELECT * FROM item WHERE item_area_id = '7'");
																while($data1 = mysqli_fetch_array($query1)){
															?>
																<div class="panel panel-default item-sub">
																	<div class="panel-heading">
																		<h4 class="panel-title">
																			<a href="#collapse<?php echo $data1["id"]; ?>" data-parent="#myAccordion1" data-toggle="collapse">
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

														<!-- SUB. SEKSI ROOM -->
														<?php if($item_area_id == 8){ ?>
															<div class="accordion" id="myAccordion2">
															<?php
																$connect2 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																$query2 = mysqli_query($connect2,"SELECT * FROM item WHERE item_area_id = '8'");
																while($data2 = mysqli_fetch_array($query2)){
															?>
																<div class="panel panel-default item-sub">
																	<div class="panel-heading">
																		<h4 class="panel-title">
																			<a href="#collapse<?php echo $data2["id"]; ?>" data-parent="#myAccordion2" data-toggle="collapse">
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

														<!-- SUB. SEKSI COUNTER HANDUK -->
														<?php if($item_area_id == 9){ ?>
															<div class="accordion" id="myAccordion3">
															<?php
																$connect3 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																$query3 = mysqli_query($connect3,"SELECT * FROM item WHERE item_area_id = '9'");
																while($data3 = mysqli_fetch_array($query3)){
															?>
																<div class="panel panel-default item-sub">
																	<div class="panel-heading">
																		<h4 class="panel-title">
																			<a href="#collapse<?php echo $data3["id"]; ?>" data-parent="#myAccordion3" data-toggle="collapse">
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

														<!-- SUB. SEKSI LAUNDRY -->
														<?php if($item_area_id == 10){ ?>
															<div class="accordion" id="myAccordion4">
															<?php
																$connect4 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																$query4 = mysqli_query($connect4,"SELECT * FROM item WHERE item_area_id = '10'");
																while($data4 = mysqli_fetch_array($query4)){
															?>
																<div class="panel panel-default item-sub">
																	<div class="panel-heading">
																		<h4 class="panel-title">
																			<a href="#collapse<?php echo $data4["id"]; ?>" data-parent="#myAccordion4" data-toggle="collapse">
																				<b><?php echo $data4['item_name']; ?></b>
																			</a>
																		</h4>
																	</div>
																	<div class="panel-collapse collapse" id="collapse<?php echo $data4["id"]; ?>" style="height: 0px;">
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
																									<a href="javascript:void(0);" data-id="<?php echo $data4['id']; ?>" class="ImgUpload btn btn-primary" data-style="primary"  data-toggle="tooltip" data-placement="bottom" title="Click to Upload Photo!"><i class="fa fa-image"></i></a>
																								</td>
																							</tr>
																						</tbody>
																					</table>
																					<div class="col-lg-12">
																						<div class="row">
																							<div class="btn-action pull-right">
																								<input type="hidden" name="id" value="<?php echo $data4["id"]; ?>" data-id="<?php echo $data4["id"]; ?>" />
																								<a href="#collapse<?php echo $data4['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Cancel</a>
																								<button type="submit" onClick="" id="submit_btn_hk" name="submit" data-id="<?php echo $data4["id"]; ?>" onClick="" class="btn btn-primary submit_checklist_hk">Simpan</button>
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
																												<input type="hidden" name="image_form_submit" value="<?php echo $data4['id']; ?>"/>
																												<label>Choose Image</label>
																												<input type="file" name="images[]" class="images" multiple >
																												<div class="uploading hidden-up">
																													<label>&nbsp;</label>
																													<img src="assets/img/uploading.gif" alt="uploading......"/>
																												</div>
																											</form>
																										</div>
																										<div class="gallery" id="images_preview<?php echo $data4['id']; ?>" style="margin-top:20px;"></div>
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
				console.log(id);
				
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
    </body>
</html>
<?php } ?>