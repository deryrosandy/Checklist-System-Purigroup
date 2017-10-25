<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}else{
		include 'core/init.php';
		include 'core/helper/myHelper.php';
		
		$date_now	= date('Y-m-d');
		
		$branch = $db->branch()
			->where("id", $_SESSION['branch_id'])->fetch();
		
		$allarea = $db->item_area()
			//->where("branch_id", $branch['id'])
			->where("divisi_id", 2)
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
        <link rel="stylesheet" href="dist/css/plugins/jquery-select2.min.css">
        <link rel="stylesheet" href="dist/css/plugins/jquery-dataTables.min.css">
        <link rel="stylesheet" href="dist/assets/plugins/jquery-icheck/skins/all.css">
        <link rel="stylesheet" href="dist/css/plugins/jquery-icheck.min.css">

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
						<li class=""><a href="javascript:;">Checklist ME</a></li>
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
								<li <?php if($body == 'lihat_checklist'){echo 'active';}?>><a href="lihat-checklist-me.php"><strong>Lihat Checklist</a></strong></li>
							</ul>
							<div class="tab-content">
								<div class="panel panel-info">
									<div class="panel-heading">
										<h3 class="panel-title">Input Checklist ME</h3>
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
											<li class="<?php echo ($no==1) ? 'active':''; ?>"><a data-toggle="tab" href="#tabarea-<?php echo $area['id']; ?>"><?php echo ucwords($area["name"]); ?></a></li>
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
													<h3 class="panel-title">Peralatan / Tindakan</h3>
												</div>
											</div>
										
										<?php
											$notab = 1;
											foreach ($allarea as $area){
											
												$item_area_id = $area['id'];
												//var_dump ($item_area_id);
												$items = $db->item()
													->where("item_area_id", $item_area_id);
										?>
											<div id="tabarea-<?php echo $area['id']; ?>" class="tab-pane <?php echo ($notab==1) ? 'active':''; ?>">
												<div id="accordion" class="panel-group">
													<div class="row">

														<!-- GENSET MINGGUAN (HOUR METER GENSET) -->
														<?php if($item_area_id == 14){ ?>
															<div class="row" id="cek_meter_genset">
																<div class="col-lg-12" style="">
																	<label class="controls col-lg-12" for=""><b><u>Hour meter Genset</u></b></label>
																</div>
																<div class="col-lg-12" style="">
																	<label class="controls col-lg-6 required" for=""><b><h4>Tanggal</h4></b></label>
																</div>
																<div class="col-sm-12 form-group" style="">
																	<div class="controls col-lg-4" width="">
																		<input type="text" name="date_hour" placeholder="Date" class="form-control required" title="Field Required"  data-rel="datepicker"/>
																	</div>
																</div>
																<div class="col-lg-12" style="">
																	<label class="controls col-lg-12" for=""><b><h4>Hour Meter Awal (Sebelum Pemanasan)</h4></b></label>
																	<div class="controls col-lg-6" width="">
																		<input type="text" name="hour_meter_akhir" class="form-control pull-left required" placeholder="" />
																	</div>
																</div>
																<div class="col-sm-12" style="">
																	<label class="controls col-lg-12" for=""><b><h4>Hour Meter Akhir (Setelah Pemanasan)</h4></b></label>
																	<div class="controls col-lg-6" width="">
																		<input class="form-control pull-left required" type="text" name="hour_meter_awal" placeholder="" />
																	</div>
																</div>
																<div class="col-sm-12 form-group" style="">
																	<br/>
																	<div class="col-lg-12">
																		<div class="btn-action pull-left">
																			<button type="submit" onClick="" id="submit_btn_mgenset" name="submit" data-id="<?php echo $item_area_id; ?>" onClick="" class="btn btn-primary submit_checklist">Simpan</button>
																			<!--<button type="reset" id="" name="reset" class="btn btn-warning">Reset</button>-->
																			<br/>
																		</div>
																		<br/>
																		<br/>
																		<br/>
																	</div>
																	
																	<div class="col-lg-12">
																		<div class="row">
																			<div class="col-lg-12 success-status">
																				
																			</div>
																		</div>
																	</div>
																	
																</div>
															</div>
														<?php } ?>

														<?php $no = 1; ?>

														<!-- SERVICE AC -->
														<?php if($item_area_id == 13){ ?>
															<div class="accordion" id="myAccordion1">
															<?php
																$connect1 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																$query1 = mysqli_query($connect1,"SELECT * FROM item WHERE item_area_id = '13'");
																while($data1 = mysqli_fetch_array($query1)){
															?>
																<div class="panel panel-default item-sub">
																	<div class="panel-heading">
																		<h4 class="panel-title">
																			<a href="#collapse<?php echo $data1['id']; ?>" data-parent="#myAccordion1" data-toggle="collapse">
																				<b><?php echo $data1['item_name']; ?></b>
																			</a>
																		</h4>
																	</div>
																	<div class="panel-collapse collapse" id="collapse<?php echo $data1['id']; ?>">
																		<div class="panel-body">
																			<div class="row">
																				<div class="table-responsive form_in_ll form_in_me_ac">
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Code AC</b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-8" width="">
																								<input class="form-control pull-left" type="text" name="code_ac" placeholder="Insert Code AC" />
																							</div>
																						</div>
																					</div>
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Sebelum</b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-4" width="">
																								<input class="form-control pull-left" type="text" name="ampere_before" placeholder="Ampere" />
																							</div>
																							<div class="controls col-lg-4" width="">
																								<input type="text" name="psi_before" class="form-control pull-left" placeholder="Psi" />
																							</div>
																						</div>
																					</div>
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Sesudah</b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-4" width="">
																								<input class="form-control pull-left" type="text" name="ampere_after" placeholder="Ampere" />
																							</div>
																							<div class="controls col-lg-4" width="">
																								<input type="text" name="psi_after" class="form-control pull-left" placeholder="Psi" />
																							</div>
																						</div>
																					</div>
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Keterangan</b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-12" width="">
																								<textarea name="keterangan" id="keterangan" class="form-control" rows="4" placeholder="Keterangan"></textarea>
																							</div>
																						</div>
																					</div>
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Insert Photo (Optional)</b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-6" width="">
																								<a href="javascript:void(0);" data-id="<?php echo $data1['id']; ?>" class="ImgUpload btn btn-primary" data-style="primary"  data-toggle="tooltip" data-placement="right" title="Click to Upload Photo!"><i class="fa fa-image"></i></a>
																							</div>
																						</div>
																					</div>
																					<div class="col-lg-12">
																						<div class="row">
																							<div class="btn-action pull-right">
																								<input type="hidden" name="id" value="<?php echo $data1["id"]; ?>" data-id="<?php echo $data1["id"]; ?>" />
																								<a href="#collapse<?php echo $data1['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Closed</a>
																								<button type="submit" onClick="" id="" name="submit" data-id="<?php echo $data1["id"]; ?>" onClick="" class="btn btn-warning add_new">Add New</button>
																								<button type="submit" onClick="" id="submit_btn_hk" name="submit" data-id="<?php echo $data1["id"]; ?>" onClick="" class="btn btn-primary submit_checklist">Simpan</button>
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
																							<input type="hidden" class="id_item" value="<?php echo $data1['id']; ?>"/>
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

														<!-- VICKY SHOWER (HARIAN) -->
														<?php if($item_area_id == 11){ ?>
															<div class="accordion" id="myAccordion2">
															<?php
																$connect2 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																$query2 = mysqli_query($connect2,"SELECT * FROM item WHERE item_area_id = '11'");
																while($data2 = mysqli_fetch_array($query2)){
															?>
																<div class="panel panel-default item-sub">
																	<div class="panel-heading">
																		<h4 class="panel-title">
																			<a href="#collapse<?php echo $data2['id']; ?>" data-parent="#myAccordion2" data-toggle="collapse">
																				<b><?php echo $data2['item_name']; ?></b>
																			</a>
																		</h4>
																	</div>
																	<div class="panel-collapse collapse" id="collapse<?php echo $data2['id']; ?>">
																		<div class="panel-body">
																			<div class="row">
																				<div class="table-responsive form_in_ll form_in_me_shower">
																					<table class="table">
																						<?php if(($data2['id'] != 131) && ($data2['id'] != 132) && ($data2['id'] != 133) && ($data2['id'] != 134) && ($data2['id'] != 135) && ($data2['id'] != 136) && ($data2['id'] != 137) && ($data2['id'] != 138)) { ?>
																							<tbody>
																								<tr style="width:80%;">
																									<td width=""><b>Pressure</b></td>
																									<td width="">
																										<input type="text" name="pressure" class="form-control">
																									</td>
																								</tr>
																							</tbody>
																						<?php } ?>
																						<tbody>
																							<tr style="width:80%;">
																								<td class="col-lg-1"><b>Kondisi</b></td>
																								<td colspan="" class="" border="0" width="">
																									<div class="controls col-lg-2" width="">
																										<div class="radio">
																											<label style="padding-left: 0;">
																												<input type="radio" value="3" name="kondisi" class="icheck square-blue" />
																												Bersih
																											</label>
																										</div>
																									</div>
																									<div class="controls col-lg-2" width="">
																										<div class="radio">
																											<label style="padding-left: 0;">
																												<input type="radio" value="4" name="kondisi" class="icheck square-blue" />
																												Kotor
																											</label>
																										</div>
																									</div>
																								</td>
																							</tr>
																						</tbody>
																						<tbody>
																							<tr style="width:80%;">
																								<td class="col-lg-1"><b>Fungsi</b></td>
																								<td width="">
																									<div class="controls col-lg-2" width="">
																										<div class="radio">
																											<label style="padding-left: 0;">
																												<input type="radio" value="1" name="fungsi" class="icheck square-blue"/>
																												Baik
																											</label>
																										</div>
																									</div>
																									<div class="controls col-lg-2" width="">
																										<div class="radio">
																											<label style="padding-left: 0;">
																												<input type="radio" value="2" name="fungsi" class="icheck square-blue"/>
																												Rusak
																											</label>
																										</div>
																									</div>
																								</td>
																							</tr>
																						</tbody>
																						<tbody>
																							<tr style="width:80%;">
																								<td colspan="" width="%"><b>Keterangan</b></td>
																								<td>
																									<textarea name="keterangan" id="keterangan" class="form-control" rows="4" placeholder=""></textarea>
																								</td>
																							</tr>
																						</tbody>
																					</table>
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Insert Photo (Optional)</b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-6" width="">
																								<a href="javascript:void(0);" data-id="<?php echo $data2['id']; ?>" class="ImgUpload btn btn-primary" data-style="primary"  data-toggle="tooltip" data-placement="right" title="Click to Upload Photo!"><i class="fa fa-image"></i></a>
																							</div>
																						</div>
																					</div>
																					<hr/>
																					<div class="col-lg-12">
																						<div class="row">
																							<div class="btn-action pull-right">
																								<input type="hidden" name="id" value="<?php echo $data2["id"]; ?>" data-id="<?php echo $data2["id"]; ?>" />
																								<a href="#collapse<?php echo $data2['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Closed</a>
																								<button type="submit" onClick="" id="submit_btn_hk" name="submit" data-id="<?php echo $data2["id"]; ?>" onClick="" class="btn btn-primary submit_checklist">Simpan</button>
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
																												<input type="hidden" name="image_form_submit" value="<?php echo $item['id']; ?>"/>
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
																							<input type="hidden" class="id_item" value="<?php echo $item['id']; ?>"/>
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

														<!-- PANEL BULANAN -->
														<?php if($item_area_id == 12){ ?>
															<div class="accordion" id="myAccordion3">
															<?php
																$connect3 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																$query3 = mysqli_query($connect3,"SELECT * FROM item WHERE item_area_id = '12'");
																while($data3 = mysqli_fetch_array($query3)){
															?>
																<div class="panel panel-default item-sub">
																	<div class="panel-heading">
																		<h4 class="panel-title">
																			<a href="#collapse<?php echo $data3['id']; ?>" data-parent="#myAccordion3" data-toggle="collapse">
																				<b><?php echo $data3['item_name']; ?></b>
																			</a>
																		</h4>
																	</div>
																	<div class="panel-collapse collapse" id="collapse<?php echo $data3['id']; ?>">
																		<div class="panel-body">
																			<div class="row">
																				<div class="table-responsive form_in_ll form_in_me_panel">
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Tegangan</b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls">
																								<div class="col-sm-12">
																									<div class="row">
																										<div class="controls col-lg-4" width="">
																											<input type="text" name="tegangan_r" placeholder="R" class="form-control">
																										</div>
																										<div class="controls col-lg-4" width="">
																											<input type="text" name="tegangan_s" placeholder="S" class="form-control">
																										</div>
																										<div class="controls col-lg-4" width="">
																											<input type="text" name="tegangan_t" placeholder="T" class="form-control">
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<hr/>
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Arus</b></label>
																						</div>
																						<div class="col-sm-12 form-" style="">
																							<div class="controls">
																								<div class="col-sm-12">
																									<div class="row">
																										<div class="controls col-lg-4" width="">
																											<input type="text" name="arus_r" placeholder="R" class="form-control"> 
																										</div>
																										<div class="controls col-lg-4" width="">
																											<input type="text" name="arus_s" placeholder="S" class="form-control">
																										</div>
																										<div class="controls col-lg-4" width="">
																											<input type="text" name="arus_t" placeholder="T" class="form-control">
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<hr/>
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Kondisi</b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls row">
																								<div class="col-sm-8">
																									<div class="row">
																										<div class="controls col-lg-3" width="">
																											<div class="checkbox">
																												<label>
																													<input type="checkbox" name="koneksi" value="1" class="icheck square-blue "> 
																													Koneksi
																												</label>
																											</div>
																										</div>
																										<div class="controls col-lg-3" width="">
																											<div class="checkbox">
																												<label>
																													<input type="checkbox" name="wiring" value="1" class="icheck square-blue "> 
																													Wiring
																												</label>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<hr/>
																					<div class="row">	
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls row">
																								<div class="col-sm-12">
																									<div class="row">
																										<div class="controls col-lg-2" width="">
																											<div class="radio">
																												<label>
																													<input type="radio" name="kondisi" value="3" class="icheck square-blue">  Bersih
																												</label>
																											</div>
																										</div>
																										<div class="controls col-lg-2" width="">
																											<div class="radio">
																												<label>
																													<input type="radio" name="kondisi" value="4" class="icheck square-blue">
																													  Kotor
																												</label>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<hr/>
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Fungsi</b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls row">
																								<div class="col-sm-12">
																									<div class="row">
																										<div class="controls col-lg-2" width="">
																											<div class="radio">
																												<label>
																													<input type="radio" name="fungsi" value="1" class="icheck square-blue">  Baik
																												</label>
																											</div>
																										</div>
																										<div class="controls col-lg-2" width="">
																											<div class="radio">
																												<label>
																													<input type="radio" name="fungsi" value="2" class="icheck square-blue">
																													  Rusak
																												</label>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<hr/>																			
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Keterangan</b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-12" width="">
																								<textarea name="keterangan" id="keterangan" class="form-control" rows="4" placeholder="Keterangan"></textarea>
																							</div>
																						</div>
																					</div>
																					<hr/>
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Insert Photo (Optional)</b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-6" width="">
																								<a href="javascript:void(0);" data-id="<?php echo $data3['id']; ?>" class="ImgUpload btn btn-primary" data-style="primary"  data-toggle="tooltip" data-placement="right" title="Click to Upload Photo!"><i class="fa fa-image"></i></a>
																							</div>
																						</div>
																					</div>
																					<hr/>
																					<div class="row">
																						<div class="col-lg-12">
																							<div class="col-lg-12">
																								<h5><b>NOTE :</b></h6>
																								<h5 style="text-align: justify;">- Pengecekan dilakukan setiap tanggal 1 diawal bulan.</h5>
																								<h5 style="text-align: justify;">- Pengecekan arus dan tegangan sesuai eksisting dilakukan penuh hati-hati.</h5>
																								<h5 style="text-align: justify;">- Pengerjaan kebersihan menggunakan blower dan harus kondisi kosong/tanpa arus.</h5>
																							</div>
																						</div>
																					</div>
																					<hr/>
																					<div class="col-lg-12">
																						<div class="row">
																							<div class="btn-action pull-right">
																								<input type="hidden" name="id" value="<?php echo $data3["id"]; ?>" data-id="<?php echo $data3["id"]; ?>" />
																								<a href="#collapse<?php echo $data3['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Closed</a>
																								<button type="submit" onClick="" id="submit_btn_hk" name="submit" data-id="<?php echo $data3["id"]; ?>" onClick="" class="btn btn-primary submit_checklist">Simpan</button>
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
																							<input type="hidden" class="id_item" value="<?php echo $data3['id']; ?>"/>
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

														<!-- GENSET MINGGUAN -->
														<?php if($item_area_id == 14){ ?>
															<div class="accordion" id="myAccordion4">
															<?php
																$connect4 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																$query4 = mysqli_query($connect4,"SELECT * FROM item WHERE item_area_id = '14'");
																while($data4 = mysqli_fetch_array($query4)){
															?>
																<div class="panel panel-default item-sub">
																	<div class="panel-heading">
																		<h4 class="panel-title">
																			<a href="#collapse<?php echo $data4['id']; ?>" data-parent="#myAccordion4" data-toggle="collapse">
																				<b><?php echo $data4['item_name']; ?></b>
																			</a>
																		</h4>
																	</div>
																	<div class="panel-collapse collapse" id="collapse<?php echo $data4['id']; ?>">
																		<div class="panel-body">
																			<div class="row">
																				<div class="table-responsive form_in_ll form_in_me_genset">
																					<?php if(($data4['id'] == 150) || ($data4['id'] == 151) || ($data4['id'] == 152)){ ?>
																						<div class="row">
																							<div class="col-sm-12 form-" style="">
																								<div class="controls">
																									<div class="col-sm-12">
																										<div class="row">
																											<div class="controls col-lg-6" width="">
																												<input type="text" name="ampr" placeholder="AMPR" class="form-control"> 
																											</div>
																											<div class="controls col-lg-6" width="">
																												<input type="text" name="volt" placeholder="Volt" class="form-control">
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																					<?php }else{ ?>
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Keterangan</b></label>
																							</div>
																							<div class="col-sm-12 form-group" style="">
																								<div class="controls col-lg-12" width="">
																									<textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Keterangan"></textarea>
																								</div>
																							</div>
																						</div>
																					<?php } ?>
																					<hr/>
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Insert Photo (Optional)</b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-6" width="">
																								<a href="javascript:void(0);" data-id="<?php echo $data4['id']; ?>" class="ImgUpload btn btn-primary" data-style="primary"  data-toggle="tooltip" data-placement="right" title="Click to Upload Photo!"><i class="fa fa-image"></i></a>
																							</div>
																						</div>
																					</div>
																					<hr/>
																					<div class="col-lg-12">
																						<div class="row">
																							<div class="btn-action pull-right">
																								<input type="hidden" name="id" value="<?php echo $data4["id"]; ?>" data-id="<?php echo $data4["id"]; ?>" />
																								<a href="#collapse<?php echo $data4['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Closed</a>
																								<button type="submit" onClick="" id="submit_btn_hk" name="submit" data-id="<?php echo $data4["id"]; ?>" onClick="" class="btn btn-primary submit_checklist">Simpan</button>
																								<!--<a class="btn btn-primary btn-sm">Simpan</a>-->
																								<br/>
																								<br/>
																							</div>
																						</div>
																					</div>
																					<div class="col-lg-12">
																						<div class="row">
																							<div class="col-lg-12 success-status">
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
																							<input type="hidden" class="id_item" value="<?php echo $data4['id']; ?>"/>
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

														<!-- PELAKSANAAN PEST CONTROL (MINGGUAN) -->
														<?php if($item_area_id == 15){ ?>
															<div class="accordion" id="myAccordion5">
															<?php
																$connect5 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																$query5 = mysqli_query($connect5,"SELECT * FROM item WHERE item_area_id = '15'");
																while($data5 = mysqli_fetch_array($query5)){
															?>
																<div class="panel panel-default item-sub">
																	<div class="panel-heading">
																		<h4 class="panel-title">
																			<a href="#collapse<?php echo $data5['id']; ?>" data-parent="#myAccordion5" data-toggle="collapse">
																				<b><?php echo $data5['item_name']; ?></b>
																			</a>
																		</h4>
																	</div>
																	<div class="panel-collapse collapse" id="collapse<?php echo $data5['id']; ?>">
																		<div class="panel-body">
																			<div class="row">
																				<div class="table-responsive form_in_ll form_in_me_pest">
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Pola / Tindakan</b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls row">
																								<div class="col-sm-12">
																									<div class="row">
																										<div class="controls col-lg-3" width="">
																											<div class="checkbox">
																												<label>
																													<input type="checkbox" name="spraying" value="1" class="icheck square-blue "> 
																													Spraying
																												</label>
																											</div>
																										</div>
																										<div class="controls col-lg-3" width="">
																											<div class="checkbox">
																												<label>
																													<input type="checkbox" name="batting" value="1" class="icheck square-blue">
																													Batting
																												</label>
																											</div>
																										</div>
																										<div class="controls col-lg-3" width="">
																											<div class="checkbox">
																												<label>
																													<input type="checkbox" name="dusting" value="1" class="icheck square-blue">
																													Dusting
																												</label>
																											</div>
																										</div>
																										<div class="controls col-lg-3" width="">
																											<div class="checkbox">
																												<label>
																													<input type="checkbox" name="controling" value="1" class="icheck square-blue">
																													Controling
																												</label>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>																															
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Keterangan</b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-12" width="">
																								<textarea name="keterangan" id="keterangan" class="form-control" rows="4" placeholder="Keterangan"></textarea>
																							</div>
																						</div>
																					</div>
																					<hr/>
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Insert Photo (Optional)</b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-6" width="">
																								<a href="javascript:void(0);" data-id="<?php echo $data5['id']; ?>" class="ImgUpload btn btn-primary" data-style="primary"  data-toggle="tooltip" data-placement="right" title="Click to Upload Photo!"><i class="fa fa-image"></i></a>
																							</div>
																						</div>
																					</div>
																					<hr/>
																					<div class="row">
																						<div class="col-lg-12">
																							<div class="col-lg-12">
																								<h5><b>NOTE :</b></h6>
																								<h5 style="text-align: justify;"><b>Spraying :</b><br/>Pengendalian populasi serangga dengan cara penyemprotan/spraying dengan alat Hand Sprayer & Spray Can ditujukan pada lokasi/tempat yang diperkirakan sebagai sarang atau kegiatan hama/serangga.</h5>
																								<h5 style="text-align: justify;"><b>Batting :</b><br/>Pemberian umpan beracun pda tempat-tempat tertentu seperti kapur racun & gel untuk mengendalikan lalat, kecoa dan semut.</h5>
																								<h5 style="text-align: justify;"><b>Dusting :</b><br/>Penaburan serbuk di area yang terindikasi, guna mengantisipasi terutama semut, ular dll.</h5>
																								<h5 style="text-align: justify;"><b>Controling (Rodent Control) :</b><br/>Tindakan atau kegiatan guna menekan populasi hama tikus dengan memberi umpan "Anti</h5>
																							</div>
																						</div>
																					</div>
																					<hr/>
																					<div class="col-lg-12">
																						<div class="row">
																							<div class="btn-action pull-right">
																								<input type="hidden" name="id" value="<?php echo $data5["id"]; ?>" data-id="<?php echo $data5["id"]; ?>" />
																								<a href="#collapse<?php echo $data5['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Closed</a>
																								<button type="submit" onClick="" id="submit_btn_hk" name="submit" data-id="<?php echo $data5["id"]; ?>" onClick="" class="btn btn-primary submit_checklist">Simpan</button>
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
																												<input type="hidden" name="image_form_submit" value="<?php echo $data5['id']; ?>"/>
																												<label>Choose Image</label>
																												<input type="file" name="images[]" class="images" multiple >
																												<div class="uploading hidden-up">
																													<label>&nbsp;</label>
																													<img src="assets/img/uploading.gif" alt="uploading......"/>
																												</div>
																											</form>
																										</div>
																										<div class="gallery" id="images_preview<?php echo $data5['id']; ?>" style="margin-top:20px;"></div>
																									</div>
																								</div>
																								<div class="modal-footer">
																									<button type="button" class="btn btn-primary close-modal">Done</button>
																								</div>
																							</div>
																							<input type="hidden" class="id_item" value="<?php echo $data5['id']; ?>"/>
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

														<!-- FASILITAS  -->
														<?php if($item_area_id == 16){ ?>
															<div class="accordion" id="myAccordion6">
															<?php
																$connect6 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																$query6 = mysqli_query($connect5,"SELECT * FROM item WHERE item_area_id = '16'");
																while($data6 = mysqli_fetch_array($query6)){
															?>
																<div class="panel panel-default item-sub">
																	<div class="panel-heading">
																		<h4 class="panel-title">
																			<a href="#collapse<?php echo $data6['id']; ?>" data-parent="#myAccordion6" data-toggle="collapse">
																				<b><?php echo $data6['item_name']; ?></b>
																			</a>
																		</h4>
																	</div>
																	<div class="panel-collapse collapse" id="collapse<?php echo $data6['id']; ?>">
																		<div class="panel-body">
																			<div class="row">
																				<?php if(($data6['id'] != 322) && ($data6['id'] != 323) && ($data6['id'] != 324)){ ?>
																					<div class="table-responsive form_in_ll form_in_me_fas">																																										
																						<div class="row">
																							<?php 
																								$cekrow = $db->checklist_me_fas()
																											->where("check_hour_id", 1)
																											->where("item_id", $data6['id'])
																											->where("Convert(checked_at, Date)", $date_now)
																											->where("branch_id", $branch['id']);
																								$var11 = $db->checklist_me_fas()
																											->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																											->where("check_hour_id", 1)
																											->where("item_id", $data6['id'])
																											->where("branch_id", $branch['id'])
																											->where("Convert(checked_at, Date)", $date_now)
																											->fetch();
																							?>
																							<div class="col-lg-6" style="">
																								<div class="row">
																									<!--<form action="" method="POST" role="form">-->
																									<div class="col-lg-12" style="">
																										<label class="controls col-lg-12" for=""><b>Jam 11.00</b></label>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<?php if(count($cekrow) > 0){ ?>
																											<input type="text" disabled name="var11" id="11" class="form-control" value="<?php echo $var11['description']; ?>"/>
																											<?php }else{ ?>
																												<input type="text"  name="var11" id="11" class="form-control" placeholder="Input value"/>
																											<?php } ?>
																										</div>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<?php if(count($cekrow) > 0){ ?>
																												<button disabled type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist11">Simpan</button>
																											<?php }else{ ?>
																												<button type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist11">Simpan</button>
																											<?php } ?>
																										</div> 
																									</div>
																									<!--</form>-->
																								</div>
																							</div>
																							<?php
																								$cekrow = $db->checklist_me_fas()
																											->where("check_hour_id", 2)
																											->where("item_id", $data6['id'])
																											->where("Convert(checked_at, Date)", $date_now)
																											->where("branch_id", $branch['id']);
																								$var12 = $db->checklist_me_fas()
																											->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																											->where("check_hour_id", 2)
																											->where("item_id", $data6['id'])
																											->where("branch_id", $branch['id'])
																											->where("Convert(checked_at, Date)", $date_now)
																											->fetch();
																							?>
																							<div class="col-lg-6" style="">
																								<div class="row">
																									<div class="col-lg-12" style="">
																										<label class="controls col-lg-12" for=""><b>Jam 12.00</b></label>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<?php if(count($cekrow) > 0){ ?>
																												<input type="text" disabled name="var12" id="12" class="form-control" value="<?php echo $var12['description']; ?>"/>
																											<?php }else{ ?>
																												<input type="text"  name="var12" id="12" class="form-control" placeholder="Input value"/>
																											<?php } ?>
																										</div>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<?php if(count($cekrow) > 0){ ?>
																												<button disabled type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist12">Simpan</button>
																											<?php }else{ ?>
																												<button type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist12">Simpan</button>
																											<?php } ?>
																										</div> 
																									</div>
																								</div>
																							</div>
																						</div>
																						<hr/>
																						<div class="row">
																							<?php 
																								$cekrow = $db->checklist_me_fas()
																											->where("check_hour_id", 3)
																											->where("Convert(checked_at, Date)", $date_now)
																											->where("branch_id", $branch['id']);
																								$var14 = $db->checklist_me_fas()
																											->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																											->where("check_hour_id", 3)
																											->where("item_id", $data6['id'])
																											->where("Convert(checked_at, Date)", $date_now)
																											->where("branch_id", $branch['id'])
																											->fetch();
																							?>
																							<div class="col-lg-6" style="">
																								<div class="row">
																									<div class="col-lg-12" style="">
																										<label class="controls col-lg-12" for=""><b>Jam 14.00</b></label>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<?php if(count($cekrow) > 0){ ?>
																												<input type="text" disabled name="var14" id="14" class="form-control" value="<?php echo $var14['description']; ?>"/>
																											<?php }else{ ?>
																												<input type="text"  name="var14" id="14" class="form-control" placeholder="Input value"/>
																											<?php } ?>
																										</div>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<?php if(count($cekrow) > 0){ ?>
																												<button disabled type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist14">Simpan</button>
																											<?php }else{ ?>
																												<button type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist14">Simpan</button>
																											<?php } ?>
																										</div> 
																									</div>
																									<!--</form>-->
																								</div>
																							</div>
																							<?php
																								$cekrow = $db->checklist_me_fas()
																											->where("check_hour_id", 4)
																											->where("item_id", $data6['id'])
																											->where("Convert(checked_at, Date)", $date_now)
																											->where("branch_id", $branch['id']);
																								
																								$var16 = $db->checklist_me_fas()
																											->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																											->where("check_hour_id", 4)
																											->where("item_id", $data6['id'])
																											->where("Convert(checked_at, Date)", $date_now)
																											->where("branch_id", $branch['id'])
																											->fetch();
																							?>
																							<div class="col-lg-6" style="">
																								<div class="row">
																									<div class="col-lg-12" style="">
																										<label class="controls col-lg-12" for=""><b>Jam 16.00</b></label>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<?php if(count($cekrow) > 0){ ?>
																											<input type="text" disabled name="var16" id="16" class="form-control" value="<?php echo $var16['description']; ?>"/>
																											<?php }else{ ?>
																												<input type="text"  name="var16" id="16" class="form-control" placeholder="Input value"/>
																											<?php } ?>
																										</div>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<?php if(count($cekrow) > 0){ ?>
																												<button disabled type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist16">Simpan</button>
																											<?php }else{ ?>
																												<button type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist16">Simpan</button>
																											<?php } ?>
																										</div> 
																									</div>
																									<!--</form>-->
																								</div>
																							</div>
																						</div>
																						<hr/>
																						<div class="row">
																							<?php
																								$cekrow = $db->checklist_me_fas()
																											->where("check_hour_id", 5)
																											->where("Convert(checked_at, Date)", $date_now)
																											->where("item_id", $data6['id'])
																											->where("branch_id", $branch['id']);
																								$var18 = $db->checklist_me_fas()
																											->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																											->where("check_hour_id", 5)
																											->where("item_id", $data6['id'])
																											->where("Convert(checked_at, Date)", $date_now)
																											->where("branch_id", $branch['id'])
																											->fetch();
																							?>
																							<div class="col-lg-6" style="">
																								<div class="row">
																									<div class="col-lg-12" style="">
																										<label class="controls col-lg-12" for=""><b>Jam 18.00</b></label>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<?php if(count($cekrow) > 0){ ?>
																												<input type="text" disabled name="var18" id="18" class="form-control" value="<?php echo $var18['description']; ?>"/>
																											<?php }else{ ?>
																												<input type="text"  name="var18" id="18" class="form-control" placeholder="Input value"/>
																											<?php } ?>
																										</div>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<?php if(count($cekrow) > 0){ ?>
																												<button disabled type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist18">Simpan</button>
																											<?php }else{ ?>
																												<button type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist18">Simpan</button>
																											<?php } ?>
																										</div> 
																									</div>
																									<!--</form>-->
																								</div>
																							</div>
																							<?php
																								$cekrow = $db->checklist_me_fas()
																											->where("check_hour_id", 6)
																											->where("Convert(checked_at, Date)", $date_now)
																											->where("item_id", $data6['id'])
																											->where("branch_id", $branch['id']);
																								$var20 = $db->checklist_me_fas()
																											->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																											->where("check_hour_id", 6)
																											->where("item_id", $data6['id'])
																											->where("Convert(checked_at, Date)", $date_now)
																											->where("branch_id", $branch['id'])
																											->fetch();
																							?>
																							<div class="col-lg-6" style="">
																								<div class="row">
																									<div class="col-lg-12" style="">
																										<label class="controls col-lg-12" for=""><b>Jam 20.00</b></label>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<?php if(count($cekrow) > 0){ ?>
																												<input type="text" disabled name="var20" id="20" class="form-control" value="<?php echo $var20['description']; ?>"/>
																											<?php }else{ ?>
																												<input type="text"  name="var20" id="20" class="form-control" placeholder="Input value"/>
																											<?php } ?>
																										</div>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<?php if(count($cekrow) > 0){ ?>
																												<button disabled type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist20">Simpan</button>
																											<?php }else{ ?>
																												<button type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist20">Simpan</button>
																											<?php } ?>
																										</div> 
																									</div>
																									<!--</form>-->
																								</div>
																							</div>
																						</div>
																						<hr/>
																						<div class="row">
																							<?php
																								$cekrow = $db->checklist_me_fas()
																											->where("check_hour_id", 7)
																											->where("Convert(checked_at, Date)", $date_now)
																											->where("item_id", $data6['id'])
																											->where("branch_id", $branch['id']);
																								$var22 = $db->checklist_me_fas()
																											->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																											->where("check_hour_id", 7)
																											->where("item_id", $data6['id'])
																											->where("Convert(checked_at, Date)", $date_now)
																											->where("branch_id", $branch['id'])
																											->fetch();
																							?>
																							<div class="col-lg-6" style="">
																								<div class="row">
																									<div class="col-lg-12" style="">
																										<label class="controls col-lg-12" for=""><b>Jam 22.00</b></label>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<?php if(count($cekrow) > 0){ ?>
																											<input type="text" disabled name="var22" id="22" class="form-control" value="<?php echo $var22['description']; ?>"/>
																											<?php }else{ ?>
																												<input type="text"  name="var22" id="22" class="form-control" placeholder="Input value"/>
																											<?php } ?>
																										</div>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<?php if(count($cekrow) > 0){ ?>
																												<button disabled type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist22">Simpan</button>
																											<?php }else{ ?>
																												<button type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist22">Simpan</button>
																											<?php } ?>
																										</div> 
																									</div>
																									<!--</form>-->
																								</div>
																							</div>
																							<?php
																								$cekrow = $db->checklist_me_fas()
																											->where("check_hour_id", 8)
																											->where("Convert(checked_at, Date)", $date_now)
																											->where("item_id", $data6['id'])
																											->where("branch_id", $branch['id']);
																								$var23 = $db->checklist_me_fas()
																											->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																											->where("check_hour_id", 8)
																											->where("item_id", $data6['id'])
																											->where("Convert(checked_at, Date)", $date_now)
																											->where("branch_id", $branch['id'])
																											->fetch();
																							?>
																							<div class="col-lg-6" style="">
																								<div class="row">
																									<div class="col-lg-12" style="">
																										<label class="controls col-lg-12" for=""><b>Jam 23.00</b></label>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<?php if(count($cekrow) > 0){ ?>
																											<input type="text" disabled name="var23" id="23" class="form-control" value="<?php echo $var23['description']; ?>"/>
																											<?php }else{ ?>
																												<input type="text"  name="var23" id="23" class="form-control" placeholder="Input value"/>
																											<?php } ?>
																										</div>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<?php if(count($cekrow) > 0){ ?>
																												<button disabled type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist23">Simpan</button>
																											<?php }else{ ?>
																												<button type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist23">Simpan</button>
																											<?php } ?>
																										</div> 
																									</div>
																									<!--</form>-->
																								</div>
																							</div>
																						</div>
																						<hr/>
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Insert Photo (Optional)</b></label>
																							</div>
																							<div class="col-sm-12 form-group" style="">
																								<div class="controls col-lg-6" width="">
																									<a href="javascript:void(0);" data-id="<?php echo $data6['id']; ?>" class="ImgUpload btn btn-primary" data-style="primary"  data-toggle="tooltip" data-placement="right" title="Click to Upload Photo!"><i class="fa fa-image"></i></a>
																								</div>
																							</div>
																						</div>
																						<hr/>
																						<div class="col-lg-12">
																							<div class="row">
																								<div class="btn-action pull-right">
																									<input type="hidden" name="id" value="<?php echo $data6["id"]; ?>" data-id="<?php echo $data6["id"]; ?>" />
																									<a href="#collapse<?php echo $data6['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Close</a>
																									<?php /* <button type="submit" onClick="" id="submit_btn_hk" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary submit_checklist">Simpan</button> */ ?>
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
																													<input type="hidden" name="image_form_submit" value="<?php echo $data6['id']; ?>"/>
																													<label>Choose Image</label>
																													<input type="file" name="images[]" class="images" multiple >
																													<div class="uploading hidden-up">
																														<label>&nbsp;</label>
																														<img src="assets/img/uploading.gif" alt="uploading......"/>
																													</div>
																												</form>
																											</div>
																											<div class="gallery" id="images_preview<?php echo $data6['id']; ?>" style="margin-top:20px;"></div>
																										</div>
																									</div>
																									<div class="modal-footer">
																										<button type="button" class="btn btn-primary close-modal">Done</button>
																									</div>
																								</div>
																								<input type="hidden" class="id_item" value="<?php echo $data6['id']; ?>"/>
																							</div>
																						</div>
																						<div class="col-lg-12">
																							<div class="row">
																								<div class="col-lg-12 success-status">
																								</div>
																							</div>
																						</div>
																					</div>
																				<?php }else{ ?>
																					<div class="table-responsive form_in_ll form_in_me_fas">																																										
																						<div class="row">
																							<?php 
																								$cekrow = $db->checklist_me_fas()
																											->where("check_hour_id", 1)
																											->where("Convert(checked_at, Date)", $date_now)
																											->where("item_id", $data6['id'])
																											->where("branch_id", $branch['id']);
																								
																								$var11 = $db->checklist_me_fas()
																											->select("id, check_hour_id, ph, cl, description, item_id, Convert(checked_at, Date) As tanggal")
																											->where("check_hour_id", 1)
																											->where("branch_id", $branch['id'])
																											->where("item_id", $data6['id'])
																											->where("Convert(checked_at, Date)", $date_now)
																											->fetch();
																							?>
																							<div class="col-lg-12" style="">
																								<div class="row">
																									<!--<form action="" method="POST" role="form">-->
																									<div class="col-lg-12" style="">
																										<label class="controls col-lg-12" for=""><b>Jam 11.00</b></label>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls row">
																											<?php if(count($cekrow) > 0){ ?>
																												<div class="col-sm-12">
																													<div class="col-lg-8">
																														<div class="row">
																															<div class="controls col-lg-6" width="">
																																<input disabled class="form-control pull-left" type="text" name="ph" placeholder="PH" value="<?php echo $var11['ph']; ?>" />
																															</div>
																															<div class="controls col-lg-6" width="">
																																<input disabled type="text" name="cl" class="form-control pull-left" placeholder="CL" value="<?php echo $var11['cl']; ?>"/>
																															</div>
																														</div>
																													</div>
																													<div class="controls col-lg-4" width="">
																														<label class="form-control">
																															<?php echo ucfirst($var11['description']); ?>
																														</label>
																													</div>
																												</div>
																											<?php }else{ ?>
																												<div class="col-sm-12">
																													<div class="col-lg-8">
																														<div class="row">
																															<div class="controls col-lg-6" width="">
																																<input class="form-control pull-left" type="text" name="ph_1" placeholder="PH" />
																															</div>
																															<div class="controls col-lg-6" width="">
																																<input type="text" name="cl_1" class="form-control pull-left" placeholder="CL" />
																															</div>
																														</div>
																													</div>
																													<div class="controls col-lg-2" width="">
																														<div class="radio">
																															<label>
																																<input type="radio" name="var11_1" value="jernih" class="icheck square-blue"> Jernih
																															</label>
																														</div>
																													</div>
																													<div class="controls col-lg-2" width="">
																														<div class="radio">
																															<label>
																																<input type="radio" name="var11_1" value="keruh" class="icheck square-blue"> Keruh
																															</label>
																														</div>
																													</div>
																												</div>
																											<?php } ?>
																										</div>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<?php if(count($cekrow) > 0){ ?>
																												<button disabled type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist11_1">Simpan</button>
																											<?php }else{ ?>
																												<button type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist11_1">Simpan</button>
																											<?php } ?>
																										</div> 
																									</div>
																									<!--</form>-->
																								</div>
																							</div>
																							<?php
																								$cekrow = $db->checklist_me_fas()
																											->where("check_hour_id", 8)
																											->where("Convert(checked_at, Date)", $date_now)
																											->where("item_id", $data6['id'])
																											->where("branch_id", $branch['id']);
																								
																								$var23 = $db->checklist_me_fas()
																											->select("id, check_hour_id, ph, cl, description, item_id, Convert(checked_at, Date) As tanggal")
																											->where("check_hour_id", 8)
																											->where("branch_id", $branch['id'])
																											->where("item_id", $data6['id'])
																											->where("Convert(checked_at, Date)", $date_now)
																											->fetch();
																							?>	
																							<div class="col-lg-12" style="">
																								<hr/>
																								<div class="row">
																									<div class="col-lg-12" style="">
																										<label class="controls col-lg-12" for=""><b>Jam 23.00</b></label>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls row">
																											<?php if(count($cekrow) > 0){ ?>
																												<div class="col-sm-12">
																													<div class="col-lg-8">
																														<div class="row">
																															<div class="controls col-lg-6" width="">
																																<input disabled class="form-control pull-left" type="text" name="ph" placeholder="PH" value="<?php echo $var23['ph']; ?>" />
																															</div>
																															<div class="controls col-lg-6" width="">
																																<input disabled type="text" name="cl" class="form-control pull-left" placeholder="CL" value="<?php echo $var23['cl']; ?>"/>
																															</div>
																														</div>
																													</div>
																													<div class="controls col-lg-4" width="">
																														<label class="form-control">
																															<?php echo ucfirst($var23['description']); ?>
																														</label>
																													</div>
																												</div>
																											<?php }else{ ?>
																												<div class="col-sm-12">
																													<div class="col-lg-8">
																													<div class="row">
																														<div class="controls col-lg-6" width="">
																															<input class="form-control pull-left" type="text" name="ph_2" placeholder="PH" />
																														</div>
																														<div class="controls col-lg-6" width="">
																															<input type="text" name="cl_2" class="form-control pull-left" placeholder="CL" />
																														</div>
																													</div>
																												</div>
																													<div class="controls col-lg-2" width="">
																														<div class="radio">
																															<label>
																																<input type="radio" name="var23_2" value="jernih" class="icheck square-blue"> Jernih
																															</label>
																														</div>
																													</div>
																													<div class="controls col-lg-2" width="">
																														<div class="radio">
																															<label>
																																<input type="radio" name="var23_2" value="keruh" class="icheck square-blue"> Keruh
																															</label>
																														</div>
																													</div>
																												</div>
																											<?php } ?>
																										</div>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<?php if(count($cekrow) > 0){ ?>
																												<button disabled type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist23_2">Simpan</button>
																											<?php }else{ ?>
																												<button type="submit" onClick="" id="" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary btn-mini submit_checklist23_2">Simpan</button>
																											<?php } ?>
																										</div> 
																									</div>
																								</div>
																							</div>
																							<div class="col-lg-12">
																								<hr/>
																								<div class="row">
																									<div class="col-lg-12" style="">
																										<label class="controls col-lg-12" for=""><b>Insert Photo (Optional)</b></label>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-6" width="">
																											<a href="javascript:void(0);" data-id="<?php echo $data6['id']; ?>" class="ImgUpload btn btn-primary" data-style="primary"  data-toggle="tooltip" data-placement="right" title="Click to Upload Photo!"><i class="fa fa-image"></i></a>
																										</div>
																									</div>
																								</div>
																								<hr/>
																								<div class="col-lg-12">
																									<div class="row">
																										<div class="btn-action pull-right">
																											<input type="hidden" name="id" value="<?php echo $data6["id"]; ?>" data-id="<?php echo $data6["id"]; ?>" />
																											<a href="#collapse<?php echo $data6['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Close</a>
																											<?php /* <button type="submit" onClick="" id="submit_btn_hk" name="submit" data-id="<?php echo $data6["id"]; ?>" onClick="" class="btn btn-primary submit_checklist">Simpan</button> */ ?>
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
																															<input type="hidden" name="image_form_submit" value="<?php echo $data6['id']; ?>"/>
																															<label>Choose Image</label>
																															<input type="file" name="images[]" class="images" multiple >
																															<div class="uploading hidden-up">
																																<label>&nbsp;</label>
																																<img src="assets/img/uploading.gif" alt="uploading......"/>
																															</div>
																														</form>
																													</div>
																													<div class="gallery" id="images_preview<?php echo $data6['id']; ?>" style="margin-top:20px;"></div>
																												</div>
																											</div>
																											<div class="modal-footer">
																												<button type="button" class="btn btn-primary close-modal">Done</button>
																											</div>
																										</div>
																										<input type="hidden" class="id_item" value="<?php echo $data6['id']; ?>"/>
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
																				<?php } ?>
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
		<script src="dist/assets/plugins/jquery-icheck/icheck.min.js"></script>
        <script src="dist/js/icheck.js"></script>
		<script src="demo/js/demo.js"></script>
		<script src="demo/js/me_fasilitas.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".form_in_me_ac").on("click", ".submit_checklist", function(){ 
					
					var parentObj = $(this).closest('.item-sub');
					
					var id 				= parentObj.find('#submit_btn_hk').attr('data-id');
					var ampere_before 	= parentObj.find('input[name="ampere_before"]').val();
					var psi_before 		= parentObj.find('input[name="psi_before"]').val();
					var ampere_after 	= parentObj.find('input[name="ampere_after"]').val();
					var psi_after 		= parentObj.find('input[name="psi_after"]').val();
					var code_ac		 	= parentObj.find('input[name="code_ac"]').val();
					var keterangan	 	= parentObj.find('textarea[name="keterangan"]').val();
					
					var proceed = true;
					
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id,ampere_before,psi_before,code_ac,ampere_after,psi_after,keterangan										
						};
						
						//Ajax post data to server
						$.post('action/insert_checklist_me_ac.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ 
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = response.text;
							}
							parentObj.find(".success-status").hide().html(output).slideDown();
							parentObj.find(".add_new").show();
						}, 'json');
					}
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
//				//var parentObj = $(this).closest('.item-sub');
				$(".add_new").hide();
				
				$(".form_in_me_ac").on("click", ".add_new", function(){ 
					
					var parentObj = $(this).closest('.item-sub');
					
					parentObj.find('input[name="ampere_before"]').val("");
					parentObj.find('input[name="psi_before"]').val("");
					parentObj.find('input[name="ampere_after"]').val("");
					parentObj.find('input[name="psi_after"]').val("");
					parentObj.find('input[name="code_ac"]').val("");
					parentObj.find('textarea[name="keterangan"]').val("");
					
					parentObj.find(".success-status").hide();
					
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".form_in_me_panel").on("click", ".submit_checklist", function(){ 
					
					var parentObj = $(this).closest('.item-sub');
					
					var id 				= parentObj.find('#submit_btn_hk').attr('data-id');
					var tegangan_r 		= parentObj.find('input[name="tegangan_r"]').val();
					var tegangan_s 		= parentObj.find('input[name="tegangan_s"]').val();
					var tegangan_t 		= parentObj.find('input[name="tegangan_t"]').val();
					var arus_r 			= parentObj.find('input[name="arus_r"]').val();
					var arus_s 			= parentObj.find('input[name="arus_s"]').val();
					var arus_t 			= parentObj.find('input[name="arus_t"]').val();
					var koneksi 		= parentObj.find('input[name="koneksi"]:checked').val();
					var wiring 			= parentObj.find('input[name="wiring"]:checked').val();
					var kondisi 		= parentObj.find('input[name="kondisi"]').val();
					var fungsi 			= parentObj.find('input[name="fungsi"]').val();
					var keterangan	 	= parentObj.find('textarea[name="keterangan"]').val();
										
					var proceed = true;
					
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id,tegangan_r,tegangan_s,tegangan_t,arus_r,arus_s,arus_t,koneksi,wiring,kondisi,fungsi,keterangan										
						};
						
						//Ajax post data to server
						$.post('action/insert_checklist_me_panel.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ 
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = response.text;
							}
							parentObj.find(".success-status").hide().html(output).slideDown();
						}, 'json');
					}
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".form_in_me_pest").on("click", ".submit_checklist", function(){ 
					
					var parentObj = $(this).closest('.item-sub');
					
					var id 				= parentObj.find('#submit_btn_hk').attr('data-id');
					var spraying 		= parentObj.find('input[name="spraying"]:checked').val();
					var batting 		= parentObj.find('input[name="batting"]:checked').val();
					var dusting 		= parentObj.find('input[name="dusting"]:checked').val();
					var controling 		= parentObj.find('input[name="controling"]:checked').val();
					var keterangan	 	= parentObj.find('textarea[name="keterangan"]').val();
										
					var proceed = true;
					
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id,spraying,batting,dusting,controling,keterangan										
						};
						
						//Ajax post data to server
						$.post('action/insert_checklist_me_pest.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ 
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = response.text;
							}
							parentObj.find(".success-status").hide().html(output).slideDown();
						}, 'json');
					}
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".form_in_me_shower").on("click", ".submit_checklist", function(){ 

					var parentObj = $(this).closest('.item-sub');

					var id 				= parentObj.find('#submit_btn_hk').attr('data-id');
					var pressure 		= parentObj.find('input[name="pressure"]').val();
					var kondisi			= parentObj.find('input[name="kondisi"]:checked').val();
					var fungsi 			= parentObj.find('input[name="fungsi"]:checked').val();
					var keterangan	 	= parentObj.find('textarea[name="keterangan"]').val();

					var proceed = true;
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id,pressure,kondisi,fungsi,keterangan
						};

						//Ajax post data to server
						$.post('action/insert_checklist_me.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ 
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = response.text;
							}
							parentObj.find(".success-status").hide().html(output).slideDown();
						}, 'json');
					}
				});
			});
		</script>
		<!-- Submit Meter genset -->
		<script type="text/javascript">
			$(document).ready(function(){
				$("#cek_meter_genset").on("click", ".submit_checklist", function(){ 
					//console.log('dor');
					var id 					= $('#submit_btn_mgenset').attr('data-id');
					var date_hour	 		= $('input[name="date_hour"]').val();
					var hour_meter_awal	 	= $('input[name="hour_meter_awal"]').val();
					var hour_meter_akhir	= $('input[name="hour_meter_akhir"]').val();
										
					var proceed = true;
					
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id,date_hour,hour_meter_awal,hour_meter_akhir										
						};
						
						//Ajax post data to server
						$.post('action/insert_checklist_me_hour_genset.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ 
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = response.text;
							}
							$("#cek_meter_genset .success-status").hide().html(output).slideDown();
						}, 'json');
					}
				});
			});
		</script>
		<script type="text/javascript">
			//Insert Checklist Genset
			$(document).ready(function(){
				$(".form_in_me_genset").on("click", ".submit_checklist", function(){ 
					
					var parentObj = $(this).closest('.item-sub');
					var id 				= parentObj.find('#submit_btn_hk').attr('data-id');
					var keterangan	 	= parentObj.find('textarea[name="keterangan"]').val();
					var ampr			= parentObj.find('input[name="ampr"]').val();
					var volt			= parentObj.find('input[name="volt"]').val();
										
					var proceed = true;
					
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id,keterangan, ampr, volt										
						};
						
						//Ajax post data to server
						$.post('action/insert_checklist_me_genset.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ 
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = response.text;
							}
							parentObj.find(".success-status").hide().html(output).slideDown();
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
				$(".form_in_ll").on("change", ".images", function(){ 
				
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