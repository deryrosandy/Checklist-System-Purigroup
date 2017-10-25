<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}else{
		include 'core/init.php';
		include 'core/helper/myHelper.php';
		
		$branch = $db->branch()
			->where("id", $_SESSION['branch_id'])->fetch();
		$date_now	= date('Y-m-d');
			
		$allarea = $db->item_area()
			->where("divisi_id", 2)
			->order('id ASC');
		
		$body = 'checklist';
		
		$user = $db->users()
				->where("id", $_SESSION['id'])->fetch();
		
		$dt = new DateTime();
		$today = $dt->format('Y-m-d');
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
        <link rel="stylesheet" href="dist/css/plugins/jquery-select2.min.css">
        <link rel="stylesheet" href="dist/css/plugins/jquery-dataTables.min.css">
		<link rel="stylesheet" href="dist/assets/plugins/jquery-icheck/skins/all.css">
        <link rel="stylesheet" href="dist/css/plugins/jquery-icheck.min.css">
		<link rel="stylesheet" href="dist/css/plugins/ekko-lightbox.min.css">
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
						<li class=""><a href="javascript:void(0);">Checklist ME</a></li>
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
								<li <?php if($body == 'lihat_checklist'){echo 'active';}?>><a href="checklist-me.php"><strong>Input Checklist</a></strong></li>
								<li class="active"><a href="javascript:void(0);"><strong>Lihat Checklist</a></strong></li>
							</ul>
							<div class="tab-content content-area">
								<div class="panel panel-info">
									<div class="panel-heading">
										<h3 class="panel-title">Data Checklist ME</h3>
									</div>
								</div>
								<div class="clearfix"></div>
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

													<!-- GENSET MINGGUAN (HOUR METER GENSET) -->
													<?php if($item_area_id == 14){ ?>
														<?php $meter_genset = $db->hour_meter_genset()->where("item_area_id", $item_area_id)->where("branch_id", $branch['id'])->fetch(); ?>
														<div class="row" id="cek_meter_genset">
															<div class="col-lg-12" style="">
																<label class="controls col-lg-12" for=""><b><u>Hour Meter Ganset</u></b></label>
															</div>
															<div class="col-lg-12" style="">
																<label class="controls col-lg-2" for=""><b>Tanggal  :</b></label>
																<label class="controls col-lg-3">
																	<?php
																		if ($meter_genset['date_hour'] !== '1970-01-01') {
																			echo tgl_indo($meter_genset['date_hour']);
																		}
																		elseif ($meter_genset['date_hour'] == '1970-01-01') {
																			echo ' - ';
																		}
																	?>
																</label>
															</div>
															<div class="col-sm-12 form-group" style="">
																<div class="controls col-lg-4" width="">
																</div>
															</div>
															<div class="col-lg-12" style="">
																<label class="controls col-lg-6" for=""><b>Hour Meter Awal (Sebelum Pemanasan)</b></label>
																<label class="controls col-lg-6" for=""><b>Hour Meter Akhir (Setelah Pemanasan)</b></label>
															</div>
															<div class="col-sm-12 form-group" style="">
																<div class="controls col-lg-6" width="">
																	<label class="controls col-lg-12"><?php echo $meter_genset['start_hour_meter']; ?></label>
																</div>
																<div class="controls col-lg-6" width="">
																	<label class="controls col-lg-12"><?php echo $meter_genset['after_hour_meter']; ?></label>
																</div>
															</div>
														</div>
													<?php } ?>

													<?php $no = 1; ?>
													
													<?php foreach ($items as $item){ ?>
													<?php
														$all_item_checklist = $db->item_checklist()
															->where("item_id", $item['id'])
															->where("branch_id", $branch['id'])
															->where("CONVERT(checked_at, date)", $today);
														
														$item_checklist = $db->item_checklist()
															->where("item_id", $item['id'])
															->where("CONVERT(checked_at, date)", $today)
															->fetch();
														
														$count_checklist = count($all_item_checklist);
														
														$status 	=  	($count_checklist > 0 ? $item_checklist['item_status_id'] : '');
														$fungsi		= 	($count_checklist > 0 ? $item_checklist->item_fungsi['name'] : '');
														$keterangan =   ($count_checklist > 0 ? $item_checklist['description'] : '');
													?>
													
														<div class="panel panel-default item-sub">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a href="#collapse<?php echo $item['id']; ?>" data-parent="#accordion" data-toggle="collapse">
																		<b><?php echo $item['item_name']; ?></b>
																	</a>
																</h4>
															</div>
															<div class="panel-collapse collapse" id="collapse<?php echo $item['id']; ?>" style="height: 0px;">
																<div class="panel-body">
																	<div class="row">
																	
																	<?php if($count_checklist > 0 ){ ?>
																		<?php if ($user['user_type'] != 'operator'){ ?>
																			<div id="" class="table-responsive form_approve">
																				<!-- VICKY SHOWER (HARIAN) -->																									
																				<?php if($item_area_id == 11) { ?>
																					<table class="table table-striped">
																						<thead>
																							<tr class="panel-heading">
																								<th>Pressure</th>
																								<th>Kondisi</th>
																								<th>Fungsi</th>
																								<th>Keterangan</th>
																								<th>Status</th>
																								<th>Action</th>
																							</tr>
																						</thead>
																						<tbody>
																							<tr class="odd gradeX">
																								<td>
																									<?php echo ucfirst($item_checklist['pressure']); ?>
																								</td>
																								<td>
																									<label name="kondisi"><?php echo ucfirst($item_checklist->item_status['name']); ?></label>
																								</td>
																								
																								<td class="center">
																									<label name="fungsi"><?php echo ucfirst($item_checklist->item_fungsi['name']); ?></label>
																								</td>
																								<td>
																									<label name="keterangan"><?php echo $keterangan; ?></label>
																								</td>
																								<td class="center">
																									<?php if($item_checklist['status_approve'] == '0'){ ?>
																										<label style="margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-danger">Not Yet</label>
																									<?php }else{ ?>
																										<label style="margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-success">Approved</label>
																									<?php } ?>
																								</td>
																								<td class="btn-group">
																									<a id="" href="javascript:void(0);" data-id="<?php echo $item_checklist['id']; ?>" class="btn btn-warning submit_confirm">Approve</a>
																								</td>
																							</tr>
																						</tbody>
																					</table>
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Photo</b></label>
																							<hr/>
																						</div>
																						<div class="col-lg-12">
																							<?php
																								$item_images = $db->item_image()
																									->where("branch_id", $branch['id'])
																									->where("item_id", $item['id'])
																									->where("CONVERT(created, date)", $today);

																								if(count($item_images) > 0){
																									foreach($item_images as $image){
																							?>
																								<a href="<?php echo '/checklist/' . $image['image_source']; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="col-sm-4" style="margintop: 15px; margin-bottom:15px;">
																									<img src="<?php echo '/checklist/' . $image['image_source']; ?>" class="img-responsive">
																								</a>
																							<?php
																									}
																								}
																								else{
																							?>
																								<div class="col-lg-12">
																									<thead>
																										<tr>
																											<td colspan="5" style="text-align: center; background-color: #eff3f4;">   - Photo Belum Tersedia</td>
																										</tr>
																									</thead>
																								</div>
																							<?php } ?>
																						</div>
																					</div>
																					<?php
																						$all_comments = $db->comments()
																							->where("item_checklist_id", $item_checklist['id']);
																					?>
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Catatan / Koreksi</b></label>
																							<hr/>
																						</div>
																						<div class="col-lg-11 comment_area" style="">
																							<?php foreach ($all_comments as $comm){ ?>
																								<div class="col-lg-12">
																									<span class="mail-date pull-right">
																										<?php echo tgl_indo_short($comm["created"]); ?>
																									</span>
																									<h4 class="text-primary"><?php echo $comm->users['first_name']; ?>  :</h4>
																									<blockquote>
																										<p><?php echo $comm['description']; ?></p>
																									</blockquote>
																								</div>
																							<?php } ?>
																						</div>
																						<div class="col-sm-11 form-group" style="">
																							<div class="controls col-lg-12" width="">
																								<textarea style="resize: vertical;" name="comments" id="comments" class="form-control" rows="3" placeholder="Tulis Catatan / Koreksi"></textarea>
																							</div>
																						</div>
																						<div class="col-sm-12 form-group" style="">	
																							<div class="controls col-lg-8" width="">
																								<button data-id="<?php echo $item_checklist['id']; ?>"  class="btn btn-primary btn_submit_comments">Submit</button>
																							</div>
																						</div>
																					</div>
																					<div class="col-lg-12">
																						<div class="row">
																							<div class="col-lg-12 success-status">
																							</div>
																						</div>
																					</div>
																				<?php } ?>
																				
																				<!-- PANEL BULANAN -->
																				<?php if($item_area_id == 12) { ?>
																					<div class="table-responsive form_in_ll form_in_me_panel">
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Tegangan</b></label>
																							</div>
																							<div class="col-sm-12 form-group" style="">
																								<div class="controls">
																									<div class="col-sm-12">
																										<div class="row">
																											<div class="controls col-lg-4">
																												<input type="text" name="tegangan_r" placeholder="R" value="<?php echo ucfirst($item_checklist['tegangan_r']); ?>" class="form-control">
																											</div>
																											<div class="controls col-lg-4" width="">
																												<input type="text" name="tegangan_s" placeholder="S" value="<?php echo ucfirst($item_checklist['tegangan_s']); ?>" class="form-control">
																											</div>
																											<div class="controls col-lg-4" width="">
																												<input type="text" name="tegangan_t" placeholder="T" value="<?php echo ucfirst($item_checklist['tegangan_t']); ?>" class="form-control">
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
																												<input type="text" name="arus_r" placeholder="R" value="<?php echo ucfirst($item_checklist['arus_r']); ?>" class="form-control"> 
																											</div>
																											<div class="controls col-lg-4" width="">
																												<input type="text" name="arus_s" placeholder="S"  value="<?php echo ucfirst($item_checklist['arus_s']); ?>" class="form-control">
																											</div>
																											<div class="controls col-lg-4" width="">
																												<input type="text" name="arus_t" placeholder="T"  value="<?php echo ucfirst($item_checklist['arus_t']); ?>" class="form-control">
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
																									<div class="col-sm-12">
																										<div class="row">
																											<div class="controls col-lg-2" width="">
																												<div class="radio">
																													<label>
																														<input type="radio" <?php echo ($item_checklist['item_status_id']==3) ? 'checked':''; ?> name="kondisi" value="3" class="icheck square-blue">  Bersih
																													</label>
																												</div>
																											</div>
																											<div class="controls col-lg-2" width="">
																												<div class="radio">
																													<label>
																														<input type="radio" <?php echo ($item_checklist['item_status_id']==4) ? 'checked':''; ?>  name="kondisi" value="4" class="icheck square-blue">
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
																							<div class="col-sm-12 form-group" style="">
																								<div class="controls row">
																									<div class="col-sm-12">
																										<div class="row">
																											<div class="controls col-lg-2" width="">
																												<div class="radio">
																													<label>
																														<input type="checkbox" <?php echo ($item_checklist['koneksi']==1) ? 'checked':''; ?>  name="koneksi" value="1" class="icheck square-blue">
																														 Koneksi
																													</label>
																												</div>
																											</div>
																											<div class="controls col-lg-2" width="">
																												<div class="radio">
																													<label>
																														<input type="checkbox" <?php echo ($item_checklist['wiring']==1) ? 'checked':''; ?>  name="wiring" value="1" class="icheck square-blue">
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
																							<div class="col-lg-12 form-group" style="">
																								<label class="controls col-lg-12" for=""><b>Fungsi</b></label>
																							</div>
																							<div class="col-sm-12 form-group" style="">
																								<div class="controls row">
																									<div class="col-sm-12">
																										<div class="row">
																											<div class="controls col-lg-2" width="">
																												<div class="radio">
																													<label>
																														<input type="radio" <?php echo ($item_checklist['item_fungsi_id']==1) ? 'checked':''; ?> name="fungsi" value="1" class="icheck square-blue">  Baik
																													</label>
																												</div>
																											</div>
																											<div class="controls col-lg-2" width="">
																												<div class="radio">
																													<label>
																														<input type="radio" <?php echo ($item_checklist['item_fungsi_id']==2) ? 'checked':''; ?>  name="fungsi" value="2" class="icheck square-blue">
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
																									<textarea name="keterangan" id="keterangan" class="form-control" rows="4" placeholder="Keterangan"><?php echo ucfirst($item_checklist["description"]); ?></textarea>
																								</div>
																							</div>
																							<div class="col-sm-12 form-group" style="">
																								<hr/>
																							</div>
																						</div>
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Photo</b></label>
																								<hr/>
																							</div>
																							<div class="col-lg-12">
																								<?php
																									$item_images = $db->item_image()
																										->where("item_id", $item['id'])
																										->where("CONVERT(created, date)", $today);
																								
																									if(count($item_images) > 0){
																										foreach($item_images as $image){
																								?>
																									<a href="<?php echo '/checklist/' . $image['image_source']; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="col-sm-4" style="margintop: 15px; margin-bottom:15px;">
																										<img src="<?php echo '/checklist/' . $image['image_source']; ?>" class="img-responsive">
																									</a>
																								<?php
																										}
																									}
																									else{
																								?>
																									<div class="col-lg-12">
																										<thead>
																											<tr>
																												<td colspan="5" style="text-align: center; background-color: #eff3f4;">   - Photo Belum Tersedia</td>
																											</tr>
																										</thead>
																									</div>
																								<?php } ?>
																							</div>
																						</div>
																						<hr/>
																						<?php
																							$all_comments = $db->comments()
																								->where("item_checklist_id", $item_checklist['id']);
																						?>
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Catatan / Koreksi</b></label>
																								<hr/>
																							</div>
																							<div class="col-lg-12 comment_area" style="">													
																								<?php foreach ($all_comments as $comm){ ?>
																									<div class="col-lg-12">
																										<span class="mail-date pull-right">
																											<?php echo tgl_indo_short($comm["created"]); ?>
																										</span>
																										<h4 class="text-primary"><?php echo $comm->users['first_name']; ?>  :</h4>
																										<blockquote>
																											<p><?php echo $comm['description']; ?></p>
																										</blockquote>
																									</div>
																								<?php } ?>
																							</div>
																							<div class="col-sm-11 form-group" style="">
																								<div class="controls col-lg-12" width="">
																									<textarea style="resize: vertical;" name="comments" id="comments" class="form-control" rows="3" placeholder="Tulis Catatan / Koreksi"></textarea>
																								</div>
																							</div>
																							<div class="col-sm-12 form-group" style="">	
																								<div class="controls col-lg-8" width="">
																									<button data-id="<?php echo $item_checklist['id']; ?>"  class="btn btn-primary btn_submit_comments">Submit</button>
																								</div>
																							</div>
																						</div>
																						<hr/>
																						<div class="row">
																							<div class="col-sm-12 btn-group">
																								<label class="controls col-lg-12" for=""><b>Status</b></label>
																							</div>
																							<div class="col-sm-12 btn-group">
																								<div class="controls col-lg-2" width="">
																									<?php if($item_checklist['status_approve'] == '0'){ ?>
																										<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-danger">Not Yet</label>
																									<?php }else{ ?>
																										<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-warning">Approved</label>
																									<?php } ?>
																								</div>
																							</div>
																						</div>
																						<hr/>
																						<div class="row">
																							<div class="col-sm-12 form-group" style="">	
																								<div class="controls col-lg-8" width="">
																									<a href="#collapse<?php echo $item['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Closed</a>
																									<a id="" href="javascript:void(0);" data-id="<?php echo $item_checklist['id']; ?>" class="btn btn-warning submit_confirm">Approve</a>
																								</div>
																							</div>
																							<div class="col-lg-12">
																								<div class="col-lg-12 success-status">

																								</div>
																							</div>
																						</div>
																					</div>
																				<?php } ?>
																				
																				<?php if($item_area_id == 13){ ?>
																					<div class="table-responsive">
																						<table data-sortable class="form_approve table table-hover table-bordered table-striped">
																							<thead>
																								<tr>
																									<th rowspan="2" style="text-align:center;vertical-align: middle;">No</th>
																									<th rowspan="2" style="text-align:center;vertical-align: middle;">Code AC</th>
																									<th colspan="2" style="text-align:center;">Sebelum</th>
																									<th colspan="2" style="text-align:center;">Sesudah</th>
																									<th rowspan="2" style="text-align:center;vertical-align: middle;">Keterangan</th>
																								</tr>
																								<tr>
																									<th style="text-align:center;">Ampere</th>
																									<th style="text-align:center;">Psi</th>
																									<th style="text-align:center;">Ampere</th>
																									<th style="text-align:center;">Psi</th>
																								</tr>
																							</thead>
																							<tbody>
																								<?php
																									$no= 1;
																									$id_item = $item['id'];
																									$items_ac = $db->checklist_ac()
																												->where("item_id", $id_item)
																												->where("CONVERT(checked_at, date)", $today);
																								?>
																								<?php foreach($items_ac as $ac){ ?>
																								<tr>
																									<td><?php echo $no; ?></td>
																									<td><?php echo $ac['code']; ?></td>
																									<td><?php echo $ac['ampere_before']; ?></td>
																									<td><?php echo $ac['psi_before']; ?></td>
																									<td><?php echo $ac['ampere_after']; ?></td>
																									<td><?php echo $ac['psi_after']; ?></td>
																									<td><?php echo ucfirst($ac['description']); ?></td>
																									<?php $no++; ?>
																								</tr>
																								<?php } ?>
																							</tbody>
																						</table>
																						<hr/>
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Photo</b></label>
																								<hr/>
																							</div>
																							<div class="col-lg-12">
																								<?php
																									$item_images = $db->item_image()
																										->where("item_id", $item['id'])
																										->where("CONVERT(created, date)", $today);

																									if(count($item_images) > 0){
																										foreach($item_images as $image){
																								?>
																									<a href="<?php echo '/checklist/' . $image['image_source']; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="col-sm-4" style="margintop: 15px; margin-bottom:15px;">
																										<img src="<?php echo '/checklist/' . $image['image_source']; ?>" class="img-responsive">
																									</a>
																								<?php
																										}
																									}
																									else{
																								?>
																									<div class="col-lg-12">
																										<thead>
																											<tr>
																												<td colspan="5" style="text-align: center; background-color: #eff3f4;">   - Photo Belum Tersedia</td>
																											</tr>
																										</thead>
																									</div>
																								<?php } ?>
																							</div>
																						</div>
																						<hr/>
																						<?php
																							$all_comments = $db->comments()
																								->where("item_checklist_id", $item_checklist['id']);
																						?>
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Catatan / Koreksi</b></label>
																								<hr/>
																							</div>
																							<div class="col-lg-12 comment_area" style="">													
																								<?php foreach ($all_comments as $comm){ ?>
																									<div class="col-lg-12">
																										<span class="mail-date pull-right">
																											<?php echo tgl_indo_short($comm["created"]); ?>
																										</span>
																										<h4 class="text-primary"><?php echo $comm->users['first_name']; ?>  :</h4>
																										<blockquote>
																											<p><?php echo $comm['description']; ?></p>
																										</blockquote>
																									</div>
																								<?php } ?>
																							</div>
																							<div class="col-sm-11 form-group" style="">
																								<div class="controls col-lg-12" width="">
																									<textarea style="resize: vertical;" name="comments" id="comments" class="form-control" rows="3" placeholder="Tulis Catatan / Koreksi"></textarea>
																								</div>
																							</div>
																							<div class="col-sm-12 form-group" style="">	
																								<div class="controls col-lg-8" width="">
																									<button data-id="<?php echo $item_checklist['id']; ?>"  class="btn btn-primary btn_submit_comments">Submit</button>
																								</div>
																							</div>
																						</div>
																						<hr/>
																						<div class="row">
																							<div class="col-sm-12 btn-group">
																								<label class="controls col-lg-12" for=""><b>Status</b></label>
																							</div>
																							<div class="col-sm-12 btn-group">
																								<div class="controls col-lg-2" width="">
																									<?php if($item_checklist['status_approve'] == '0'){ ?>
																										<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-danger">Not Yet</label>
																									<?php }else{ ?>
																										<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-warning">Approved</label>
																									<?php } ?>
																								</div>
																							</div>
																						</div>
																						<hr/>
																						<div class="row">
																							<div class="col-sm-12 form-group" style="">	
																								<div class="controls col-lg-8" width="">
																									<a href="#collapse<?php echo $item['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Closed</a>
																									<a id="" href="javascript:void(0);" data-id="<?php echo $item_checklist['id']; ?>" class="btn btn-warning submit_confirm">Approve</a>
																								</div>
																							</div>
																							<div class="col-lg-12">
																								<div class="col-lg-12 success-status">

																								</div>
																							</div>
																						</div>
																					</div>
																				<?php } ?>
																				
																				<!-- Jika Area Checklist Genset -->
																				<?php if($item_area_id == 14){ ?>
																					<div class="table-responsive form_in_ll form_in_me_genset">
																						<?php if(($item['id'] == 150) || ($item['id'] == 151) || ($item['id'] == 152)){ ?>
																							<div class="row">
																								<div class="col-sm-12 form-" style="">
																									<div class="controls">
																										<div class="col-sm-12">
																											<div class="row">
																												<div class="controls col-lg-6" width="">
																													<label name="ampr" placeholder="AMPR" class="form-control">AMPR = <?php echo $item_checklist['ampr']; ?></label> 
																												</div>
																												<div class="controls col-lg-6" width="">
																													<label name="volt" placeholder="Volt" class="form-control">Volt = <?php echo $item_checklist['volt']; ?></label>
																												</div>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																						<?php }else{ ?>
																							<div class="row">
																								<div class="col-lg-8" style="">
																									<label class="controls col-lg-12" for=""><b>Keterangan</b></label>
																								</div>
																								<div class="col-sm-12 form-group" style="">
																									<div class="controls col-lg-12" width="">
																										<textarea name="keterangan" id="keterangan" disabled class="form-control" rows="3" placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
																									</div>
																								</div>
																							</div>
																						<?php } ?>
																						<hr/>
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Photo</b></label>
																								<hr/>
																							</div>
																							<div class="col-lg-12">
																								<?php
																									$item_images = $db->item_image()
																										->where("item_id", $item['id'])
																										->where("CONVERT(created, date)", $today);

																									if(count($item_images) > 0){
																										foreach($item_images as $image){
																								?>
																									<a href="<?php echo '/checklist/' . $image['image_source']; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="col-sm-4" style="margintop: 15px; margin-bottom:15px;">
																										<img src="<?php echo '/checklist/' . $image['image_source']; ?>" class="img-responsive">
																									</a>
																								<?php
																										}
																									}
																									else{
																								?>
																									<div class="col-lg-12">
																										<thead>
																											<tr>
																												<td colspan="5" style="text-align: center; background-color: #eff3f4;">   - Photo Belum Tersedia</td>
																											</tr>
																										</thead>
																									</div>
																								<?php } ?>
																							</div>
																						</div>
																						<?php 
																							$all_comments = $db->comments()
																								->where("item_checklist_id", $item_checklist['id']);
																						?>
																						<hr/>
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Catatan / Koreksi</b></label>
																								<hr/>
																							</div>
																							<div class="col-lg-11 comment_area" style="">
																								<?php foreach ($all_comments as $comm){ ?>
																									<div class="col-lg-12">
																										<span class="mail-date pull-right">
																											<?php echo tgl_indo_short($comm["created"]); ?>
																										</span>
																										<h4 class="text-primary"><?php echo $comm->users['first_name']; ?>  :</h4>
																										<blockquote>
																											<p><?php echo $comm['description']; ?></p>
																										</blockquote>
																									</div>
																								<?php } ?>
																							</div>
																							<div class="col-sm-11 form-group" style="">
																								<div class="controls col-lg-12" width="">
																									<textarea style="resize: vertical;" name="comments" id="comments" class="form-control" rows="3" placeholder="Tulis Catatan / Koreksi"></textarea>
																								</div>
																							</div>
																							<div class="col-sm-12 form-group" style="">	
																								<div class="controls col-lg-8" width="">
																									<button data-id="<?php echo $item_checklist['id']; ?>"  class="btn btn-primary btn_submit_comments">Submit</button>
																								</div>
																							</div>
																						</div>
																						<hr/>
																					</div>
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Status</b></label>
																						</div>
																						<div class="col-sm-12 form-group">
																							<div class="controls col-lg-6">
																								<div class="row">
																									<div class="col-sm-4 form-group" style="">
																										<?php if($item_checklist['status_approve'] == '0'){ ?>
																											<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-danger">Not Yet</label>
																										<?php }else{ ?>
																											<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-warning">Approved</label>
																										<?php } ?>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="row">
																						<div class="col-sm-12 form-group">
																							<div class="controls col-lg-6">
																								<a href="#collapse<?php echo $item['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Closed</a>
																								<a id="" href="javascript:void(0);" data-id="<?php echo $item_checklist['id']; ?>" class="btn btn-warning submit_confirm_me_ac">Approve</a>
																							</div>
																						</div>
																					</div>
																					<div class="col-lg-12">
																						<div class="row">
																							<div class="col-lg-12 success-status">
																							</div>
																						</div>
																					</div>
																				<?php } ?>
																				
																				<!-- Jika Area Checklist Pest Control -->
																				<?php if($item_area_id == 15){ ?>
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
																														<input type="checkbox" disabled <?php echo ($item_checklist['spraying']== 1) ? 'checked':''; ?> name="spraying" value="1" class="icheck square-blue "> 
																														Spraying
																													</label>
																												</div>
																											</div>
																											<div class="controls col-lg-3" width="">
																												<div class="checkbox">
																													<label>
																														<input type="checkbox" <?php echo ($item_checklist['batting']== 1) ? 'checked':''; ?> disabled name="batting" value="1" class="icheck square-blue">
																														Batting
																													</label>
																												</div>
																											</div>
																											<div class="controls col-lg-3" width="">
																												<div class="checkbox">
																													<label>
																														<input type="checkbox" <?php echo ($item_checklist['dusting']== 1) ? 'checked':''; ?> disabled name="dusting" value="1" class="icheck square-blue">
																														Dusting
																													</label>
																												</div>
																											</div>
																											<div class="controls col-lg-3" width="">
																												<div class="checkbox">
																													<label>
																														<input type="checkbox" <?php echo ($item_checklist['controling']== 1) ? 'checked':''; ?> disabled name="controling" value="1" class="icheck square-blue">
																														Controling
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
																								<div class="controls col-lg-11" width="">
																									<textarea name="keterangan" disabled id="keterangan" class="form-control" rows="3" placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
																								</div>
																							</div>
																						</div>
																						<?php
																							$all_comments = $db->comments()
																								->where("item_checklist_id", $item_checklist['id']);
																						?>
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Catatan / Koreksi</b></label>
																								<hr/>
																							</div>
																							<div class="col-lg-11 comment_area" style="">													
																								<?php foreach ($all_comments as $comm){ ?>
																									<div class="col-lg-12">
																										<span class="mail-date pull-right">
																											<?php echo tgl_indo_short($comm["created"]); ?>
																										</span>
																										<h4 class="text-primary"><?php echo $comm->users['first_name']; ?>  :</h4>
																										<blockquote>
																											<p><?php echo $comm['description']; ?></p>
																										</blockquote>
																									</div>
																								<?php } ?>
																							</div>
																							<div class="col-sm-11 form-group" style="">
																								<div class="controls col-lg-12" width="">
																									<textarea style="resize: vertical;" name="comments" id="comments" class="form-control" rows="3" placeholder="Tulis Catatan / Koreksi"></textarea>
																								</div>
																							</div>
																							<div class="col-sm-12 form-group" style="">	
																								<div class="controls col-lg-8" width="">
																									<button data-id="<?php echo $item_checklist['id']; ?>"  class="btn btn-primary btn_submit_comments">Submit</button>
																								</div>
																							</div>
																						</div>
																						<hr/>
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Photo</b></label>
																								<hr/>
																							</div>
																							<div class="col-lg-12">
																								<?php
																									$item_images = $db->item_image()
																										->where("item_id", $item['id'])
																										->where("CONVERT(created, date)", $today);

																									if(count($item_images) > 0){
																										foreach($item_images as $image){
																								?>
																								<a href="<?php echo '/checklist/' . $image['image_source']; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="col-sm-4" style="margintop: 15px; margin-bottom:15px;">
																									<img src="<?php echo '/checklist/' . $image['image_source']; ?>" class="img-responsive">
																								</a>
																								<?php
																										}
																									}
																									else{
																								?>
																								<div class="col-lg-12">
																									<thead>
																										<tr>
																											<td colspan="5" style="text-align: center; background-color: #eff3f4;">   - Photo Belum Tersedia</td>
																										</tr>
																									</thead>
																								</div>
																								<?php } ?>
																							</div>
																						</div>
																						<hr/>
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Status</b></label>
																							</div>
																							<div class="col-sm-12 form-group">
																								<div class="controls col-lg-6">
																									<div class="row">
																										<div class="col-sm-4 form-group" style="">
																											<?php if($item_checklist['status_approve'] == '0'){ ?>
																												<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-danger">Not Yet</label>
																											<?php }else{ ?>
																												<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-warning">Approved</label>
																											<?php } ?>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																						<div class="row">
																							<div class="col-sm-12 form-group">
																								<div class="controls col-lg-6">
																									<a href="#collapse<?php echo $item['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Closed</a>
																									<a id="" href="javascript:void(0);" data-id="<?php echo $item_checklist['id']; ?>" class="btn btn-primary submit_confirm_me_ac">Approve</a>
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
																				<?php } ?>
																				
																				<!-- Jika Area Checklist Fasilitas -->
																				<?php if($item_area_id == 16){ ?>
																					<?php if(($item['id'] != 322) && ($item['id'] != 323) && ($item['id'] != 324)){ ?>
																						<div class="table-responsive form_in_ll form_in_me_fas">																																										
																							<div class="row">
																								<?php 
																									$cekrow = $db->checklist_me_fas()
																												->where("check_hour_id", 1)
																												->where("Convert(checked_at, Date)", $date_now)
																												->where("item_id", $item['id'])
																												->where("branch_id", $branch['id']);
																									$var11 = $db->checklist_me_fas()
																												->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																												->where("check_hour_id", 1)
																												->where("branch_id", $branch['id'])
																												->where("item_id", $item['id'])
																												->where("Convert(checked_at, Date)", $date_now)
																												->fetch();																				
																								?>
																								<div class="col-lg-6" style="">
																									<div class="row">
																										<div class="col-lg-12" style="">
																											<label class="controls col-lg-12" for=""><b>Jam 11.00</b></label>
																										</div>
																										<div class="col-sm-12 form-group" style="">
																											<div class="controls col-lg-12" width="">
																												<label name="var11" id="11" class="form-control"><?php echo $var11['description']; ?></label>
																											</div>
																										</div>
																									</div>
																								</div>
																								<?php
																									$cekrow = $db->checklist_me_fas()
																												->where("check_hour_id", 2)
																												->where("Convert(checked_at, Date)", $date_now)
																												->where("item_id", $item['id'])
																												->where("branch_id", $branch['id']);
																									$var12 = $db->checklist_me_fas()
																												->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																												->where("check_hour_id", 2)
																												->where("branch_id", $branch['id'])
																												->where("item_id", $item['id'])
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
																												<label name="var11" id="11" class="form-control"><?php echo $var12['description']; ?></label>
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
																												->where("item_id", $item['id'])
																												->where("branch_id", $branch['id']);
																									$var14 = $db->checklist_me_fas()
																												->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																												->where("check_hour_id", 3)
																												->where("Convert(checked_at, Date)", $date_now)
																												->where("item_id", $item['id'])
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
																												<label name="var11" id="11" class="form-control"><?php echo $var14['description']; ?></label>
																											</div>
																										</div>
																									</div>
																								</div>
																								<?php
																									$cekrow = $db->checklist_me_fas()
																												->where("check_hour_id", 4)
																												->where("Convert(checked_at, Date)", $date_now)
																												->where("item_id", $item['id'])
																												->where("branch_id", $branch['id']);

																									$var16 = $db->checklist_me_fas()
																												->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																												->where("check_hour_id", 4)
																												->where("item_id", $item['id'])
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
																												<label name="var11" id="11" class="form-control"><?php echo $var16['description']; ?></label>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																							<hr/>
																							<div class="row">
																								<?php
																									$cekrow = $db->checklist_me_fas()
																												->where("check_hour_id", 5)
																												->where("Convert(checked_at, Date)", $date_now)
																												->where("item_id", $item['id'])
																												->where("branch_id", $branch['id']);
																									$var18 = $db->checklist_me_fas()
																												->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																												->where("check_hour_id", 5)
																												->where("Convert(checked_at, Date)", $date_now)
																												->where("item_id", $item['id'])
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
																												<label name="var11" id="11" class="form-control"><?php echo $var18['description']; ?></label>
																											</div>
																										</div>
																									</div>
																								</div>
																								<?php
																									$cekrow = $db->checklist_me_fas()
																												->where("check_hour_id", 6)
																												->where("Convert(checked_at, Date)", $date_now)
																												->where("item_id", $item['id'])
																												->where("branch_id", $branch['id']);
																									$var20 = $db->checklist_me_fas()
																												->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																												->where("check_hour_id", 6)
																												->where("Convert(checked_at, Date)", $date_now)
																												->where("item_id", $item['id'])
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
																												<label name="var11" id="11" class="form-control"><?php echo $var20['description']; ?></label>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																							<hr/>
																							<div class="row">
																								<?php
																									$cekrow = $db->checklist_me_fas()
																												->where("check_hour_id", 7)
																												->where("Convert(checked_at, Date)", $date_now)
																												->where("item_id", $item['id'])
																												->where("branch_id", $branch['id']);
																									$var22 = $db->checklist_me_fas()
																												->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																												->where("check_hour_id", 7)
																												->where("Convert(checked_at, Date)", $date_now)
																												->where("item_id", $item['id'])
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
																												<label name="var11" id="11" class="form-control"><?php echo $var22['description']; ?></label>
																											</div>
																										</div>
																									</div>
																								</div>
																								<?php
																									$cekrow = $db->checklist_me_fas()
																												->where("check_hour_id", 8)
																												->where("Convert(checked_at, Date)", $date_now)
																												->where("item_id", $item['id'])
																												->where("branch_id", $branch['id']);
																									$var23 = $db->checklist_me_fas()
																												->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																												->where("check_hour_id", 8)
																												->where("Convert(checked_at, Date)", $date_now)
																												->where("item_id", $item['id'])
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
																												<label name="var11" id="11" class="form-control"><?php echo $var23['description']; ?></label>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																							<hr/>
																							<?php 
																								$all_comments = $db->comments()
																									->where("item_checklist_id", $item_checklist['id']);
																							?>
																							<div class="row">
																								<div class="col-lg-12" style="">
																									<label class="controls col-lg-12" for=""><b>Catatan / Koreksi</b></label>
																									<hr/>
																								</div>
																								<div class="col-lg-11 comment_area" style="">													
																									<?php foreach ($all_comments as $comm){ ?>
																										<div class="col-lg-12">
																											<span class="mail-date pull-right">
																												<?php echo tgl_indo_short($comm["created"]); ?>
																											</span>
																											<h4 class="text-primary"><?php echo $comm->users['first_name']; ?>  :</h4>
																											<blockquote>
																												<p><?php echo $comm['description']; ?></p>
																											</blockquote>
																										</div>
																									<?php } ?>
																								</div>
																								<div class="col-sm-11 form-group" style="">
																									<div class="controls col-lg-12" width="">
																										<textarea style="resize: vertical;" name="comments" id="comments" class="form-control" rows="3" placeholder="Tulis Catatan / Koreksi"></textarea>
																									</div>
																								</div>
																								<div class="col-sm-12 form-group" style="">	
																									<div class="controls col-lg-8" width="">
																										<button data-id="<?php echo $item_checklist['id']; ?>"  class="btn btn-primary btn_submit_comments">Submit</button>
																									</div>
																								</div>
																							</div>
																							<hr/>
																							<div class="row">
																								<div class="col-lg-12" style="">
																									<label class="controls col-lg-12" for=""><b>Photo</b></label>
																									<hr/>
																								</div>
																								<div class="col-lg-12">
																									<?php
																										$item_images = $db->item_image()
																											->where("item_id", $item['id'])
																											->where("CONVERT(created, date)", $today);

																										if(count($item_images) > 0){
																											foreach($item_images as $image){
																									?>
																									<a href="<?php echo '/checklist/' . $image['image_source']; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="col-sm-4" style="margintop: 15px; margin-bottom:15px;">
																										<img src="<?php echo '/checklist/' . $image['image_source']; ?>" class="img-responsive">
																									</a>
																									<?php
																											}
																										}
																										else{
																									?>
																									<div class="col-lg-12">
																										<thead>
																											<tr>
																												<td colspan="5" style="text-align: center; background-color: #eff3f4;">   - Photo Belum Tersedia</td>
																											</tr>
																										</thead>
																									</div>
																									<?php } ?>
																								</div>
																							</div>
																							<hr/>
																							<div class="row">
																								<div class="col-lg-12" style="">
																									<label class="controls col-lg-12" for=""><b>Status</b></label>
																								</div>
																								<div class="col-sm-12 form-group">
																									<div class="controls col-lg-6">
																										<div class="row">
																											<div class="col-sm-4 form-group" style="">
																												<?php if($item_checklist['status_approve'] == '0'){ ?>
																													<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-danger">Not Yet</label>
																												<?php }else{ ?>
																													<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-warning">Approved</label>
																												<?php } ?>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																							<div class="row">
																								<div class="col-sm-12 form-group">
																									<div class="controls col-lg-6">
																										<a href="#collapse<?php echo $item['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Closed</a>
																										<a id="" href="javascript:void(0);" data-id="<?php echo $item_checklist['id']; ?>" class="btn btn-primary submit_confirm_me_ac">Approve</a>
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
																					<?php }else{ ?>
																						<div class="table-responsive form_in_ll form_in_me_fas">
																							<div class="row">
																								<div class="col-lg-12" style="">
																									<div class="row">
																										<div class="col-lg-12" style="">
																											<label class="controls col-lg-12" for=""><b>Jam 11.00</b></label>
																										</div>
																										<div class="col-sm-12 form-group" style="">
																											<div class="controls row">
																												<?php 
																													$cekrow = $db->checklist_me_fas()
																															->where("check_hour_id", 1)
																															->where("Convert(checked_at, Date)", $date_now)
																															->where("item_id", $item['id'])
																															->where("branch_id", $branch['id']);

																													$var11 = $db->checklist_me_fas()
																															->select("id, check_hour_id, cl, ph, description, item_id, Convert(checked_at, Date) As tanggal")
																															->where("check_hour_id", 1)
																															->where("branch_id", $branch['id'])
																															->where("item_id", $item['id'])
																															->where("Convert(checked_at, Date)", $date_now)
																															->fetch();
																												?>																						
																												<div class="col-sm-12">
																													<div class="col-lg-8">
																														<div class="row">
																															<div class="controls col-lg-6" width="">
																																<label class="form-control">
																																	PH = <?php echo ucfirst($var11['ph']); ?>
																																</label>
																															</div>
																															<div class="controls col-lg-6" width="">
																																<label class="form-control">
																																	CL = <?php echo ucfirst($var11['cl']); ?>
																																</label>
																															</div>
																														</div>
																													</div>
																													<div class="controls col-lg-4" width="">
																														<label class="form-control">
																															<?php echo ucfirst($var11['description']); ?>
																														</label>
																													</div>
																												</div>
																											</div>																						
																										</div>																						
																									</div>																						
																								</div>																						
																								<?php
																									$cekrow = $db->checklist_me_fas()
																												->where("check_hour_id", 8)
																												->where("Convert(checked_at, Date)", $date_now)
																												->where("branch_id", $branch['id']);

																									$var23 = $db->checklist_me_fas()
																												->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																												->where("check_hour_id", 8)
																												->where("branch_id", $branch['id'])
																												->where("Convert(checked_at, Date)", $date_now)
																												->fetch();
																								?>
																								<div class="col-lg-12" style="">
																									<div class="row">
																										<div class="col-lg-12" style="">
																											<label class="controls col-lg-12" for=""><b>Jam 11.00</b></label>
																										</div>
																										<div class="col-sm-12 form-group" style="">
																											<div class="controls row">
																												<?php 
																													$cekrow = $db->checklist_me_fas()
																															->where("check_hour_id", 8)
																															->where("Convert(checked_at, Date)", $date_now)
																															->where("item_id", $item['id'])
																															->where("branch_id", $branch['id']);

																													$var23 = $db->checklist_me_fas()
																															->select("id, check_hour_id, cl, ph, description, item_id, Convert(checked_at, Date) As tanggal")
																															->where("check_hour_id", 8)
																															->where("branch_id", $branch['id'])
																															->where("item_id", $item['id'])
																															->where("Convert(checked_at, Date)", $date_now)
																															->fetch();
																												?>																						
																												<div class="col-sm-12">
																													<div class="col-lg-8">
																														<div class="row">
																															<div class="controls col-lg-6" width="">
																																<label class="form-control">
																																	PH = <?php echo ucfirst($var23['ph']); ?>
																																</label>
																															</div>
																															<div class="controls col-lg-6" width="">
																																<label class="form-control">
																																	CL = <?php echo ucfirst($var23['cl']); ?>
																																</label>
																															</div>
																														</div>
																													</div>
																													<div class="controls col-lg-4" width="">
																														<label class="form-control">
																															<?php echo ucfirst($var23['description']); ?>
																														</label>
																													</div>
																												</div>
																											</div>																						
																										</div>																						
																									</div>																						
																								</div>		
																							</div>
																							<?php 
																								$all_comments = $db->comments()
																									->where("item_checklist_id", $item_checklist['id']);
																							?>
																							<div class="row">
																								<div class="col-lg-12" style="">
																									<label class="controls col-lg-12" for=""><b>Catatan / Koreksi</b></label>
																									<hr/>
																								</div>
																								<div class="col-lg-11 comment_area" style="">													
																									<?php foreach ($all_comments as $comm){?>
																										<div class="col-lg-12">
																											<span class="mail-date pull-right">
																												<?php echo tgl_indo_short($comm["created"]); ?>
																											</span>
																											<h4 class="text-primary"><?php echo $comm->users['first_name']; ?>  :</h4>
																											<blockquote>
																												<p><?php echo $comm['description']; ?></p>
																											</blockquote>
																										</div>
																									<?php } ?>
																								</div>
																								<div class="col-sm-11 form-group" style="">
																									<div class="controls col-lg-12" width="">
																										<textarea style="resize: vertical;" name="comments" id="comments" class="form-control" rows="3" placeholder="Tulis Catatan / Koreksi"></textarea>
																									</div>
																								</div>
																								<div class="col-sm-12 form-group" style="">	
																									<div class="controls col-lg-8" width="">
																										<button data-id="<?php echo $item_checklist['id']; ?>"  class="btn btn-primary btn_submit_comments">Submit</button>
																									</div>
																								</div>
																							</div>
																							<hr/>
																							<div class="row">
																								<div class="col-lg-12" style="">
																									<label class="controls col-lg-12" for=""><b>Photo</b></label>
																									<hr/>
																								</div>
																								<div class="col-lg-12">
																									<?php
																										$item_images = $db->item_image()
																											->where("item_id", $item['id'])
																											->where("CONVERT(created, date)", $today);

																										if(count($item_images) > 0){
																											foreach($item_images as $image){
																									?>
																									<a href="<?php echo '/checklist/' . $image['image_source']; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="col-sm-4" style="margintop: 15px; margin-bottom:15px;">
																										<img src="<?php echo '/checklist/' . $image['image_source']; ?>" class="img-responsive">
																									</a>
																									<?php
																											}
																										}
																										else{
																									?>
																									<div class="col-lg-12">
																										<thead>
																											<tr>
																												<td colspan="5" style="text-align: center; background-color: #eff3f4;">   - Photo Belum Tersedia</td>
																											</tr>
																										</thead>
																									</div>
																									<?php } ?>
																								</div>
																							</div>
																							<hr/>
																							<div class="row">
																								<div class="col-lg-12" style="">
																									<label class="controls col-lg-12" for=""><b>Status</b></label>
																								</div>
																								<div class="col-sm-12 form-group">
																									<div class="controls col-lg-6">
																										<div class="row">
																											<div class="col-sm-4 form-group" style="">
																												<?php if($item_checklist['status_approve'] == '0'){ ?>
																													<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-danger">Not Yet</label>
																												<?php }else{ ?>
																													<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-warning">Approved</label>
																												<?php } ?>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																							<div class="row">
																								<div class="col-sm-12 form-group">
																									<div class="controls col-lg-6">
																										<a href="#collapse<?php echo $item['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Closed</a>
																										<a id="" href="javascript:void(0);" data-id="<?php echo $item_checklist['id']; ?>" class="btn btn-primary submit_confirm_me_ac">Approve</a>
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
																					<?php } ?>
																				<?php } ?>
																			</div>
																		<?php }else{ ?>
																			<!-- Jika User Operator -->
																			<div id="" class="table-responsive form_approve">
																				<?php if($item_area_id == 11) { ?>
																					<table class="table table-striped">
																						<thead>
																							<tr class="panel-heading">
																								<th>Pressure</th>
																								<th>Kondisi</th>
																								<th>Fungsi</th>
																								<th>Keterangan</th>
																								<th>Status</th>
																							</tr>
																						</thead>
																						<tbody>
																							<tr class="odd gradeX">
																								<td>
																									<?php echo ucfirst($item_checklist['pressure']); ?>
																								</td>
																								<td>
																									<label name="kondisi"><?php echo ucfirst($item_checklist->item_status['name']); ?></label>
																								</td>
																								
																								<td class="center">
																									<label name="fungsi"><?php echo ucfirst($item_checklist->item_fungsi['name']); ?></label>
																								</td>
																								<td>
																									<label name="keterangan"><?php echo $keterangan; ?></label>
																								</td>
																								<td class="btn-group">
																									<?php if($item_checklist['status_approve'] == '0'){ ?>
																										<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-danger">Not Yet</label>
																									<?php }else{ ?>
																										<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-warning">Approved</label>
																									<?php } ?>
																								</td>
																							</tr>
																						</tbody>
																					</table>
																					<?php
																						$all_comments = $db->comments()
																									->where("item_checklist_id", $item_checklist['id']);
																					?>
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Photo</b></label>
																							<hr/>
																						</div>
																						<div class="col-lg-12">
																						<?php
																							$item_images = $db->item_image()
																								->where("item_id", $item['id'])
																								->where("CONVERT(created, date)", $today);

																							if(count($item_images) > 0){
																								foreach($item_images as $image){
																						?>
																							<a href="<?php echo '/checklist/' . $image['image_source']; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="col-sm-4" style="margintop: 15px; margin-bottom:15px;">
																								<img src="<?php echo '/checklist/' . $image['image_source']; ?>" class="img-responsive">
																							</a>
																						<?php
																								}
																							}else{
																						?>
																							<div class="col-lg-12">
																								<thead>
																									<tr>
																										<td colspan="5" style="text-align: center; background-color: #eff3f4;">   - Photo Belum Tersedia</td>
																									</tr>
																								</thead>
																							</div>
																						<?php } ?>
																						</div>
																					</div>
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Catatan / Koreksi</b></label>
																							<hr/>
																						</div>
																						<div class="col-lg-11 comment_area" style="">													
																							<?php foreach ($all_comments as $comm){ ?>
																								<div class="col-lg-12">
																									<span class="mail-date pull-right">
																										<?php echo tgl_indo_short($comm["created"]); ?>
																									</span>
																									<h4 class="text-primary"><?php echo $comm->users['first_name']; ?>  :</h4>
																									<blockquote>
																										<p><?php echo $comm['description']; ?></p>
																									</blockquote>
																								</div>
																							<?php } ?>
																						</div>
																						<div class="col-sm-11 form-group" style="">
																							<div class="controls col-lg-12" width="">
																								<textarea style="resize: vertical;" name="comments" id="comments" class="form-control" rows="3" placeholder="Tulis Catatan / Koreksi"></textarea>
																							</div>
																						</div>
																						<div class="col-sm-12 form-group" style="">	
																							<div class="controls col-lg-8" width="">
																								<button data-id="<?php echo $item_checklist['id']; ?>"  class="btn btn-primary btn_submit_comments">Submit</button>
																							</div>
																						</div>
																					</div>
																				<?php } ?>
																				
																				<?php if($item_area_id == 12) { ?>
																					<div class="table-responsive form_in_ll form_in_me_panel">
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Tegangan</b></label>
																							</div>
																							<div class="col-sm-12 form-group" style="">
																								<div class="controls">
																									<div class="col-sm-12">
																										<div class="row">
																											<div class="controls col-lg-4">
																												<label class="controls"><b>&nbsp;&nbsp;R</b></label>
																												<label type="text" name="tegangan_r" placeholder="R" class="form-control"><?php echo ucfirst($item_checklist['tegangan_r']); ?></label>
																											</div>
																											<div class="controls col-lg-4" width="">
																												<label class="controls"><b>&nbsp;&nbsp;S</b></label>
																												<label type="text" name="tegangan_s" placeholder="S" class="form-control"><?php echo ucfirst($item_checklist['tegangan_s']); ?></label>
																											</div>
																											<div class="controls col-lg-4" width="">
																												<label class="controls"><b>&nbsp;&nbsp;T</b></label>
																												<label type="text" name="tegangan_t" placeholder="T" class="form-control"><?php echo ucfirst($item_checklist['tegangan_t']); ?></label>
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
																												<label class="controls"><b>&nbsp;&nbsp;T</b></label>
																												<label type="text" name="arus_r" placeholder="R" class="form-control"><?php echo ucfirst($item_checklist['arus_r']); ?></label>
																											</div>
																											<div class="controls col-lg-4" width="">
																												<label class="controls"><b>&nbsp;&nbsp;S</b></label>
																												<label type="text" name="arus_s" placeholder="S" class="form-control"><?php echo ucfirst($item_checklist['arus_s']); ?></label>
																											</div>
																											<div class="controls col-lg-4" width="">
																												<label class="controls"><b>&nbsp;&nbsp;T</b></label>
																												<label type="text" name="arus_t" placeholder="T" class="form-control"><?php echo ucfirst($item_checklist['arus_t']); ?></label>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																						<hr/>
																						<div class="row">
																							<div class="col-sm-12 form-" style="">
																								<div class="controls">
																									<div class="col-sm-12">
																										<div class="row">
																											<div class="controls col-lg-3" width="">
																												<label class="controls"><b>&nbsp;&nbsp;Kondisi</b></label>
																												<label type="text" class="form-control"><?php echo ucfirst($item_checklist->item_status['name']) ?></label>
																											</div>
																											<div class="controls col-lg-3" width="">
																												<label class="controls"><b>&nbsp;&nbsp;Koneksi</b></label>
																												<label type="text" class="form-control pull-left"><?php echo ucfirst($item_checklist['koneksi']); ?></label>
																											</div>
																											<div class="controls col-lg-3" width="">
																												<label class="controls"><b>&nbsp;&nbsp;Wiring</b></label>
																												<label type="text" class="form-control pull-left"><?php echo ucfirst($item_checklist['wiring']); ?></label>
																											</div>
																											<div class="controls col-lg-3" width="">
																												<label class="controls"><b>&nbsp;&nbsp;Fungsi</b></label>
																												<label type="text" class="form-control pull-left"><?php echo ucfirst($item_checklist->item_fungsi['name']); ?></label>
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
																									<textarea name="keterangan" id="keterangan" class="form-control" rows="4" placeholder="Keterangan"><?php echo ucfirst($item_checklist["description"]); ?></textarea>
																								</div>
																							</div>
																							<div class="col-sm-12 btn-group">
																								<label class="controls col-lg-12" for=""><b>Status</b></label>
																							</div>
																							<div class="col-sm-12 btn-group">
																								<div class="controls col-lg-2" width="">
																									<?php if($item_checklist['status_approve'] == '0'){ ?>
																										<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-danger">Not Yet</label>
																									<?php }else{ ?>
																										<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-warning">Approved</label>
																									<?php } ?>
																								</div>
																							</div>
																							<div class="col-sm-12 form-group" style="">
																								<hr/>
																							</div>
																						</div>
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Photo</b></label>
																								<hr/>
																							</div>
																							<div class="col-lg-12">
																								<?php
																									$item_images = $db->item_image()
																										->where("item_id", $item['id'])
																										->where("CONVERT(created, date)", $today);

																									if(count($item_images) > 0){
																										foreach($item_images as $image){
																								?>
																								<a href="<?php echo '/checklist/' . $image['image_source']; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="col-sm-4" style="margintop: 15px; margin-bottom:15px;">
																									<img src="<?php echo '/checklist/' . $image['image_source']; ?>" class="img-responsive">
																								</a>
																								<?php
																										}
																									}else{
																								?>
																								<div class="col-lg-12">
																									<thead>
																										<tr>
																											<td colspan="5" style="text-align: center; background-color: #eff3f4;">   - Photo Belum Tersedia</td>
																										</tr>
																									</thead>
																								</div>
																								<?php } ?>
																							</div>
																						</div>
																						<?php
																							$all_comments = $db->comments()
																								->where("item_checklist_id", $item_checklist['id']);
																						?>
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Catatan / Koreksi</b></label>
																								<hr/>
																							</div>
																							<div class="col-lg-11 comment_area" style="">													
																								<?php foreach ($all_comments as $comm){ ?>
																									<div class="col-lg-12">
																										<span class="mail-date pull-right">
																											<?php echo tgl_indo_short($comm["created"]); ?>
																										</span>
																										<h4 class="text-primary"><?php echo $comm->users['first_name']; ?>  :</h4>
																										<blockquote>
																											<p><?php echo $comm['description']; ?></p>
																										</blockquote>
																									</div>
																								<?php } ?>
																							</div>
																							<div class="col-sm-11 form-group" style="">
																								<div class="controls col-lg-12" width="">
																									<textarea style="resize: vertical;" name="comments" id="comments" class="form-control" rows="3" placeholder="Tulis Catatan / Koreksi"></textarea>
																								</div>
																							</div>
																							<div class="col-sm-12 form-group" style="">	
																								<div class="controls col-lg-8" width="">
																									<button data-id="<?php echo $item_checklist['id']; ?>"  class="btn btn-primary btn_submit_comments">Submit</button>
																								</div>
																							</div>
																						</div>
																					</div>
																				<?php } ?>
																				
																				<?php if($item_area_id == 13){ ?>
																					<div class="table-responsive">
																						<table data-sortable class="form_approve table table-hover table-bordered table-striped">
																							<thead>
																								<tr>
																									<th rowspan="2" style="text-align:center;vertical-align: middle;">No</th>
																									<th rowspan="2" style="text-align:center;vertical-align: middle;">Code AC</th>
																									<th colspan="2" style="text-align:center;">Sebelum</th>
																									<th colspan="2" style="text-align:center;">Sesudah</th>
																									<th rowspan="2" style="text-align:center;vertical-align: middle;">Keterangan</th>
																								</tr>
																								<tr>
																									<th style="text-align:center;">Ampere</th>
																									<th style="text-align:center;">Psi</th>
																									<th style="text-align:center;">Ampere</th>
																									<th style="text-align:center;">Psi</th>
																								</tr>
																							</thead>
																							<tbody>
																								<?php
																									$no= 1;
																									$id_item = $item['id'];
																									$items_ac = $db->checklist_ac()
																												->where("item_id", $id_item);
																								?>
																								<?php foreach($items_ac as $ac){ ?>
																								<tr>
																									<td><?php echo $no; ?></td>
																									<td><?php echo $ac['code']; ?></td>
																									<td><?php echo $ac['ampere_before']; ?></td>
																									<td><?php echo $ac['psi_before']; ?></td>
																									<td><?php echo $ac['ampere_after']; ?></td>
																									<td><?php echo $ac['psi_after']; ?></td>
																									<td><?php echo ucfirst($ac['description']); ?></td>
																									<?php $no++; ?>
																								</tr>
																								<?php } ?>
																							</tbody>
																						</table>
																						<hr/>
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Photo</b></label>
																								<hr/>
																							</div>
																							<div class="col-lg-12">
																								<?php
																									$item_images = $db->item_image()
																										->where("item_id", $item['id'])
																										->where("CONVERT(created, date)", $today);

																									if(count($item_images) > 0){
																										foreach($item_images as $image){
																								?>
																								<a href="<?php echo '/checklist/' . $image['image_source']; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="col-sm-4" style="margintop: 15px; margin-bottom:15px;">
																									<img src="<?php echo '/checklist/' . $image['image_source']; ?>" class="img-responsive">
																								</a>
																								<?php
																										}
																									}
																									else{
																								?>
																								<div class="col-lg-12">
																									<thead>
																										<tr>
																											<td colspan="5" style="text-align: center; background-color: #eff3f4;">   - Photo Belum Tersedia</td>
																										</tr>
																									</thead>
																								</div>
																								<?php } ?>
																							</div>
																						</div>
																						<hr/>
																						<?php 
																							$all_comments = $db->comments()
																								->where("item_checklist_id", $item_checklist['id']);
																						?>
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Catatan / Koreksi</b></label>
																								<hr/>
																							</div>
																							<div class="col-lg-12 comment_area" style="">													
																								<?php foreach ($all_comments as $comm){ ?>
																									<div class="col-lg-12">
																										<span class="mail-date pull-right">
																											<?php echo tgl_indo_short($comm["created"]); ?>
																										</span>
																										<h4 class="text-primary"><?php echo $comm->users['first_name']; ?>  :</h4>
																										<blockquote>
																											<p><?php echo $comm['description']; ?></p>
																										</blockquote>
																									</div>
																								<?php } ?>
																							</div>
																							<div class="col-sm-11 form-group" style="">
																								<div class="controls col-lg-12" width="">
																									<textarea style="resize: vertical;" name="comments" id="comments" class="form-control" rows="3" placeholder="Tulis Catatan / Koreksi"></textarea>
																								</div>
																							</div>
																							<div class="col-sm-12 form-group" style="">	
																								<div class="controls col-lg-8" width="">
																									<button data-id="<?php echo $item_checklist['id']; ?>"  class="btn btn-primary btn_submit_comments">Submit</button>
																								</div>
																							</div>
																						</div>
																					<hr/>
																					<div class="row">
																						<div class="col-sm-12 btn-group">
																							<label class="controls col-lg-12" for=""><b>Status</b></label>
																						</div>
																						<div class="col-sm-12 btn-group">
																							<div class="controls col-lg-2" width="">
																								<?php if($item_checklist['status_approve'] == '0'){ ?>
																									<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-danger">Not Yet</label>
																								<?php }else{ ?>
																									<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-warning">Approved</label>
																								<?php } ?>
																							</div>
																						</div>
																					</div>

																					<hr/>

																					<div class="row">
																						<div class="col-sm-12 form-group" style="">	
																							<div class="controls col-lg-8" width="">
																								<a href="#collapse<?php echo $item['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Closed</a>
																							</div>
																						</div>
																						<div class="col-lg-12">
																							<div class="col-lg-12 success-status">

																							</div>
																						</div>
																					</div>
																				
																				</div>
																						
																				<?php } ?>
																				
																				<!-- Jika Area Checklist Genset -->
																				<?php if($item_area_id == 14){ ?>
																						<div class="table-responsive form_in_ll form_in_me_genset">
																							
																							<?php if(($item['id'] == 150) || ($item['id'] == 151) || ($item['id'] == 152)){ ?>
																					
																								<div class="row">
																									<div class="col-sm-12 form-" style="">
																										<div class="controls">
																											<div class="col-sm-12">
																												<div class="row">
																													<div class="controls col-lg-6" width="">
																														<label name="ampr" placeholder="AMPR" class="form-control"><?php echo $item_checklist['ampr']; ?></label> 
																													</div>
																													<div class="controls col-lg-6" width="">
																														<label name="volt" placeholder="Volt" class="form-control"><?php echo $item_checklist['volt']; ?></label>
																													</div>
																												</div>
																											</div>
																										</div>
																									</div>
																								</div>
																							
																							<?php }else{ ?>
																							
																								<div class="row">
																									<div class="col-lg-8" style="">
																										<label class="controls col-lg-12" for=""><b>Keterangan</b></label>
																									</div>
																									<div class="col-lg-4" style="">
																										<label class="controls col-lg-12" for=""><b>Status</b></label>
																									</div>
																									<div class="col-sm-12 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<label class="form-control" rows="3" placeholder="Keterangan"><?php echo $keterangan; ?></label>
																										</div>
																									</div>
																								</div>
																							
																							<?php } ?>
																								
																								<hr/>
																								
																								<div class="row">
																									<div class="col-sm-12 btn-group">
																										<label class="controls col-lg-12" for=""><b>Status</b></label>
																									</div>
																									<div class="col-sm-12 btn-group">
																										<div class="controls col-lg-2" width="">
																											<?php if($item_checklist['status_approve'] == '0'){ ?>
																												<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-danger">Not Yet</label>
																											<?php }else{ ?>
																												<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-warning">Approved</label>
																											<?php } ?>
																										</div>
																									</div>

																									<div class="col-sm-12 form-group" style="">
																										<hr/>
																									</div>
																								</div>
																								
																								<div class="row">
																									<div class="col-lg-12" style="">
																										<label class="controls col-lg-12" for=""><b>Photo</b></label>
																										<hr/>
																									</div>
																									<div class="col-lg-12">
																									<?php
																										$item_images = $db->item_image()
																											->where("item_id", $item['id'])
																											->where("CONVERT(created, date)", $today);

																										if(count($item_images) > 0){
																											foreach($item_images as $image){ ?>
																												<a href="<?php echo '/checklist/' . $image['image_source']; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="col-sm-4" style="margintop: 15px; margin-bottom:15px;">
																													<img src="<?php echo '/checklist/' . $image['image_source']; ?>" class="img-responsive">
																												</a>
																											<?php } ?>
																										<?php }else{ ?>
																										<div class="col-lg-12">
																											<thead>
																												<tr>
																													<td colspan="5" style="text-align: center; background-color: #eff3f4;">   - Photo Belum Tersedia</td>
																												</tr>
																											</thead>
																										</div>
																										<?php } ?>
																									</div>
																								</div>
																								<?php 

																									$all_comments = $db->comments()
																										->where("item_checklist_id", $item_checklist['id']);

																								?>
																								<hr/>
																								
																								<div class="row">
																									<div class="col-lg-12" style="">
																										<label class="controls col-lg-12" for=""><b>Catatan / Koreksi</b></label>
																										<hr/>
																									</div>

																									<div class="col-lg-11 comment_area" style="">													
																										<?php foreach ($all_comments as $comm){ ?>
																												<div class="col-lg-12">
																													<span class="mail-date pull-right">
																														<?php echo tgl_indo_short($comm["created"]); ?>
																													</span>
																													<h4 class="text-primary"><?php echo $comm->users['first_name']; ?>  :</h4>
																													<blockquote>
																														<p><?php echo $comm['description']; ?></p>
																													</blockquote>
																												</div>
																										<?php } ?>
																									</div>
																									<div class="col-sm-11 form-group" style="">
																										<div class="controls col-lg-12" width="">
																											<textarea style="resize: vertical;" name="comments" id="comments" class="form-control" rows="3" placeholder="Tulis Catatan / Koreksi"></textarea>
																										</div>
																									</div>
																									<div class="col-sm-12 form-group" style="">	
																										<div class="controls col-lg-8" width="">
																											<button data-id="<?php echo $item_checklist['id']; ?>"  class="btn btn-primary btn_submit_comments">Submit</button>
																										</div>
																									</div>
																								</div>
																								
																								<hr/>
																								
																								<div class="row">
																									<div class="col-sm-12 form-group">
																										<div class="controls col-lg-6">
																											<a href="#collapse<?php echo $item['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Closed</a>
																										</div>
																									</div>
																								</div>
																							
																						</div>
																				<?php } ?>
																				
																				<!-- Jika Area Checklist Pest Control -->
																				<?php if($item_area_id == 15){ ?>

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
																														<input type="checkbox" disabled <?php echo ($item_checklist['spraying']== 1) ? 'checked':''; ?> name="spraying" value="1" class="icheck square-blue "> 
																														Spraying
																													</label>
																												</div>
																											</div>
																											<div class="controls col-lg-3" width="">
																												<div class="checkbox">
																													<label>
																														<input type="checkbox" <?php echo ($item_checklist['batting']== 1) ? 'checked':''; ?> disabled name="batting" value="1" class="icheck square-blue">
																														Batting
																													</label>
																												</div>
																											</div>
																											<div class="controls col-lg-3" width="">
																												<div class="checkbox">
																													<label>
																														<input type="checkbox" <?php echo ($item_checklist['dusting']== 1) ? 'checked':''; ?> disabled name="dusting" value="1" class="icheck square-blue">
																														Dusting
																													</label>
																												</div>
																											</div>
																											<div class="controls col-lg-3" width="">
																												<div class="checkbox">
																													<label>
																														<input type="checkbox" <?php echo ($item_checklist['controling']== 1) ? 'checked':''; ?> disabled name="controling" value="1" class="icheck square-blue">
																														Controling
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
																								<div class="controls col-lg-11" width="">
																									<textarea name="keterangan" disabled id="keterangan" class="form-control" rows="3" placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
																								</div>
																							</div>
																						</div>
																						
																						<?php 
																				
																						$all_comments = $db->comments()
																							->where("item_checklist_id", $item_checklist['id']);

																						?>

																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Catatan / Koreksi</b></label>
																								<hr/>
																							</div>

																							<div class="col-lg-11 comment_area" style="">													
																								<?php foreach ($all_comments as $comm){ ?>
																										<div class="col-lg-12">
																											<span class="mail-date pull-right">
																												<?php echo tgl_indo_short($comm["created"]); ?>
																											</span>
																											<h4 class="text-primary"><?php echo $comm->users['first_name']; ?>  :</h4>
																											<blockquote>
																												<p><?php echo $comm['description']; ?></p>
																											</blockquote>
																										</div>
																								<?php } ?>
																							</div>
																							<div class="col-sm-11 form-group" style="">
																								<div class="controls col-lg-12" width="">
																									<textarea style="resize: vertical;" name="comments" id="comments" class="form-control" rows="3" placeholder="Tulis Catatan / Koreksi"></textarea>
																								</div>
																							</div>
																							<div class="col-sm-12 form-group" style="">	
																								<div class="controls col-lg-8" width="">
																									<button data-id="<?php echo $item_checklist['id']; ?>"  class="btn btn-primary btn_submit_comments">Submit</button>
																								</div>
																							</div>
																						</div>
																						
																						<hr/>
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Photo</b></label>
																								<hr/>
																							</div>
																							<div class="col-lg-12">
																								<?php
																									$item_images = $db->item_image()
																										->where("item_id", $item['id'])
																										->where("CONVERT(created, date)", $today);

																									if(count($item_images) > 0){
																										foreach($item_images as $image){ ?>
																											<a href="<?php echo '/checklist/' . $image['image_source']; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="col-sm-4" style="margintop: 15px; margin-bottom:15px;">
																												<img src="<?php echo '/checklist/' . $image['image_source']; ?>" class="img-responsive">
																											</a>
																										<?php } ?>
																									<?php }else{ ?>
																									<div class="col-lg-12">
																										<thead>
																											<tr>
																												<td colspan="5" style="text-align: center; background-color: #eff3f4;">   - Photo Belum Tersedia</td>
																											</tr>
																										</thead>
																									</div>
																								<?php } ?>
																							</div>
																						</div>

																						<hr/>
																						
																						<div class="row">
																							<div class="col-lg-12" style="">
																								<label class="controls col-lg-12" for=""><b>Status</b></label>
																							</div>
																							<div class="col-sm-12 form-group">
																								<div class="controls col-lg-6">
																									<div class="row">
																										<div class="col-sm-4 form-group" style="">
																											<?php if($item_checklist['status_approve'] == '0'){ ?>
																												<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-danger">Not Yet</label>
																											<?php }else{ ?>
																												<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-warning">Approved</label>
																											<?php } ?>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																						
																						<div class="row">
																							<div class="col-sm-12 form-group">
																								<div class="controls col-lg-6">
																									<a href="#collapse<?php echo $item['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Closed</a>
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

																				<?php } ?>
																				
																				<!-- Jika Ceklist Area Fasilitas -->
																				<?php if($item_area_id == 16){ ?>																				
																				
																					<?php if(($item['id'] != 322) && ($item['id'] != 323) && ($item['id'] != 324)){ ?>
																		
																						<div class="table-responsive form_in_ll form_in_me_fas">																																										
																					<div class="row">
																					<?php 
																						$cekrow = $db->checklist_me_fas()
																									->where("check_hour_id", 1)
																									->where("Convert(checked_at, Date)", $date_now)
																									->where("item_id", $item['id'])
																									->where("branch_id", $branch['id']);
																						$var11 = $db->checklist_me_fas()
																									->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																									->where("check_hour_id", 1)
																									->where("branch_id", $branch['id'])
																									->where("item_id", $item['id'])
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
																									<label name="var11" id="11" class="form-control"><?php echo $var11['description']; ?></label>
																								</div>
																							</div>
																							<!--</form>-->
																						</div>
																					</div>
																					<?php
																						$cekrow = $db->checklist_me_fas()
																									->where("check_hour_id", 2)
																									->where("Convert(checked_at, Date)", $date_now)
																									->where("item_id", $item['id'])
																									->where("branch_id", $branch['id']);
																						$var12 = $db->checklist_me_fas()
																									->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																									->where("check_hour_id", 2)
																									->where("branch_id", $branch['id'])
																									->where("item_id", $item['id'])
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
																									<label name="var11" id="11" class="form-control"><?php echo $var12['description']; ?></label>
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
																									->where("item_id", $item['id'])
																									->where("branch_id", $branch['id']);
																						$var14 = $db->checklist_me_fas()
																									->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																									->where("check_hour_id", 3)
																									->where("Convert(checked_at, Date)", $date_now)
																									->where("item_id", $item['id'])
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
																									<label name="var11" id="11" class="form-control"><?php echo $var14['description']; ?></label>
																								</div>
																							</div>
																							<!--</form>-->
																						</div>
																					</div>
																					<?php
																						$cekrow = $db->checklist_me_fas()
																									->where("check_hour_id", 4)
																									->where("Convert(checked_at, Date)", $date_now)
																									->where("item_id", $item['id'])
																									->where("branch_id", $branch['id']);
																						
																						$var16 = $db->checklist_me_fas()
																									->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																									->where("check_hour_id", 4)
																									->where("item_id", $item['id'])
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
																									<label name="var11" id="11" class="form-control"><?php echo $var16['description']; ?></label>
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
																									->where("item_id", $item['id'])
																									->where("branch_id", $branch['id']);
																						$var18 = $db->checklist_me_fas()
																									->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																									->where("check_hour_id", 5)
																									->where("Convert(checked_at, Date)", $date_now)
																									->where("item_id", $item['id'])
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
																									<label name="var11" id="11" class="form-control"><?php echo $var18['description']; ?></label>
																								</div>
																							</div>
																							<!--</form>-->
																						</div>
																					</div>
																					<?php
																						$cekrow = $db->checklist_me_fas()
																									->where("check_hour_id", 6)
																									->where("Convert(checked_at, Date)", $date_now)
																									->where("item_id", $item['id'])
																									->where("branch_id", $branch['id']);
																						$var20 = $db->checklist_me_fas()
																									->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																									->where("check_hour_id", 6)
																									->where("Convert(checked_at, Date)", $date_now)
																									->where("item_id", $item['id'])
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
																									<label name="var11" id="11" class="form-control"><?php echo $var20['description']; ?></label>
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
																									->where("item_id", $item['id'])
																									->where("branch_id", $branch['id']);
																						$var22 = $db->checklist_me_fas()
																									->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																									->where("check_hour_id", 7)
																									->where("Convert(checked_at, Date)", $date_now)
																									->where("item_id", $item['id'])
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
																									<label name="var11" id="11" class="form-control"><?php echo $var22['description']; ?></label>
																								</div>
																							</div>
																							<!--</form>-->
																						</div>
																					</div>
																					<?php
																						$cekrow = $db->checklist_me_fas()
																									->where("check_hour_id", 8)
																									->where("Convert(checked_at, Date)", $date_now)
																									->where("item_id", $item['id'])
																									->where("branch_id", $branch['id']);
																						$var23 = $db->checklist_me_fas()
																									->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																									->where("check_hour_id", 8)
																									->where("Convert(checked_at, Date)", $date_now)
																									->where("item_id", $item['id'])
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
																									<label name="var11" id="11" class="form-control"><?php echo $var23['description']; ?></label>
																								</div>
																							</div>
																							<!--</form>-->
																						</div>
																					</div>
																				</div>
																				
																				<hr/>

																				<?php 

																					$all_comments = $db->comments()
																						->where("item_checklist_id", $item_checklist['id']);

																					?>

																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Catatan / Koreksi</b></label>
																							<hr/>
																						</div>

																						<div class="col-lg-11 comment_area" style="">													
																							<?php foreach ($all_comments as $comm){ ?>
																									<div class="col-lg-12">
																										<span class="mail-date pull-right">
																											<?php echo tgl_indo_short($comm["created"]); ?>
																										</span>
																										<h4 class="text-primary"><?php echo $comm->users['first_name']; ?>  :</h4>
																										<blockquote>
																											<p><?php echo $comm['description']; ?></p>
																										</blockquote>
																									</div>
																							<?php } ?>
																						</div>
																						<div class="col-sm-11 form-group" style="">
																							<div class="controls col-lg-12" width="">
																								<textarea style="resize: vertical;" name="comments" id="comments" class="form-control" rows="3" placeholder="Tulis Catatan / Koreksi"></textarea>
																							</div>
																						</div>
																						<div class="col-sm-12 form-group" style="">	
																							<div class="controls col-lg-8" width="">
																								<button data-id="<?php echo $item_checklist['id']; ?>"  class="btn btn-primary btn_submit_comments">Submit</button>
																							</div>
																						</div>
																					</div>

																					<hr/>
																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Photo</b></label>
																							<hr/>
																						</div>
																						<div class="col-lg-12">
																							<?php
																								$item_images = $db->item_image()
																									->where("item_id", $item['id'])
																									->where("CONVERT(created, date)", $today);

																								if(count($item_images) > 0){
																									foreach($item_images as $image){ ?>
																										<a href="<?php echo '/checklist/' . $image['image_source']; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="col-sm-4" style="margintop: 15px; margin-bottom:15px;">
																											<img src="<?php echo '/checklist/' . $image['image_source']; ?>" class="img-responsive">
																										</a>
																									<?php } ?>
																								<?php }else{ ?>
																								<div class="col-lg-12">
																									<thead>
																										<tr>
																											<td colspan="5" style="text-align: center; background-color: #eff3f4;">   - Photo Belum Tersedia</td>
																										</tr>
																									</thead>
																								</div>
																							<?php } ?>
																						</div>
																					</div>

																					<hr/>

																					<div class="row">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b>Status</b></label>
																						</div>
																						<div class="col-sm-12 form-group">
																							<div class="controls col-lg-6">
																								<div class="row">
																									<div class="col-sm-4 form-group" style="">
																										<?php if($item_checklist['status_approve'] == '0'){ ?>
																											<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-danger">Not Yet</label>
																										<?php }else{ ?>
																											<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-warning">Approved</label>
																										<?php } ?>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>

																					<div class="row">
																						<div class="col-sm-12 form-group">
																							<div class="controls col-lg-6">
																								<a href="#collapse<?php echo $item['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Closed</a>
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
																
																					<?php }else{ ?>
																		
																						<div class="table-responsive form_in_ll form_in_me_fas">																																										
																							<div class="row">
																							<?php 
																								$cekrow = $db->checklist_me_fas()
																											->where("check_hour_id", 1)
																											->where("Convert(checked_at, Date)", $date_now)
																											->where("item_id", $item['id'])
																											->where("branch_id", $branch['id']);
																								
																								$var11 = $db->checklist_me_fas()
																											->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																											->where("check_hour_id", 1)
																											->where("branch_id", $branch['id'])
																											->where("item_id", $item['id'])
																											->where("Convert(checked_at, Date)", $date_now)
																											->fetch();
																							?>
																								<div class="col-lg-6" style="">
																									<div class="row">
																										<div class="col-lg-12" style="">
																											<label class="controls col-lg-12" for=""><b>Jam 23.00</b></label>
																										</div>
																										<div class="col-sm-12 form-group" style="">
																											<div class="controls col-lg-12" width="">
																												<label name="var11" id="11" class="form-control"><?php echo $var11['description']; ?></label>
																											</div>
																										</div>
																										<!--</form>-->
																									</div>
																								</div>
																								<?php
																									$cekrow = $db->checklist_me_fas()
																												->where("check_hour_id", 8)
																												->where("Convert(checked_at, Date)", $date_now)
																												->where("branch_id", $branch['id']);

																									$var23 = $db->checklist_me_fas()
																												->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
																												->where("check_hour_id", 8)
																												->where("branch_id", $branch['id'])
																												->where("Convert(checked_at, Date)", $date_now)
																												->fetch();
																								?>
																								<div class="col-lg-6" style="">
																									<div class="row">
																										<div class="col-lg-12" style="">
																											<label class="controls col-lg-12" for=""><b>Jam 23.00</b></label>
																										</div>
																										<div class="col-sm-12 form-group" style="">
																											<div class="controls col-lg-12" width="">
																												<label name="var11" id="11" class="form-control"><?php echo $var23['description']; ?></label>
																											</div>
																										</div>
																										<!--</form>-->
																									</div>
																								</div>
																							</div>
																							<?php 

																								$all_comments = $db->comments()
																									->where("item_checklist_id", $item_checklist['id']);

																							?>

																							<div class="row">
																								<div class="col-lg-12" style="">
																									<label class="controls col-lg-12" for=""><b>Catatan / Koreksi</b></label>
																									<hr/>
																								</div>

																								<div class="col-lg-11 comment_area" style="">													
																									<?php foreach ($all_comments as $comm){ ?>
																											<div class="col-lg-12">
																												<span class="mail-date pull-right">
																													<?php echo tgl_indo_short($comm["created"]); ?>
																												</span>
																												<h4 class="text-primary"><?php echo $comm->users['first_name']; ?>  :</h4>
																												<blockquote>
																													<p><?php echo $comm['description']; ?></p>
																												</blockquote>
																											</div>
																									<?php } ?>
																								</div>
																								<div class="col-sm-11 form-group" style="">
																									<div class="controls col-lg-12" width="">
																										<textarea style="resize: vertical;" name="comments" id="comments" class="form-control" rows="3" placeholder="Tulis Catatan / Koreksi"></textarea>
																									</div>
																								</div>
																								<div class="col-sm-12 form-group" style="">	
																									<div class="controls col-lg-8" width="">
																										<button data-id="<?php echo $item_checklist['id']; ?>"  class="btn btn-primary btn_submit_comments">Submit</button>
																									</div>
																								</div>
																							</div>

																							<hr/>
																							<div class="row">
																								<div class="col-lg-12" style="">
																									<label class="controls col-lg-12" for=""><b>Photo</b></label>
																									<hr/>
																								</div>
																								<div class="col-lg-12">
																									<?php
																										$item_images = $db->item_image()
																											->where("item_id", $item['id'])
																											->where("CONVERT(created, date)", $today);

																										//var_dump ($item['id']);
																										if(count($item_images) > 0){
																											foreach($item_images as $image){ ?>
																												<a href="<?php echo '/checklist/' . $image['image_source']; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="col-sm-4" style="margintop: 15px; margin-bottom:15px;">
																													<img src="<?php echo '/checklist/' . $image['image_source']; ?>" class="img-responsive">
																												</a>
																											<?php } ?>
																										<?php }else{ ?>
																										<div class="col-lg-12">
																											<thead>
																												<tr>
																													<td colspan="5" style="text-align: center; background-color: #eff3f4;">   - Photo Belum Tersedia</td>
																												</tr>
																											</thead>
																										</div>
																									<?php } ?>
																								</div>
																							</div>

																							<hr/>

																							<div class="row">
																								<div class="col-lg-12" style="">
																									<label class="controls col-lg-12" for=""><b>Status</b></label>
																								</div>
																								<div class="col-sm-12 form-group">
																									<div class="controls col-lg-6">
																										<div class="row">
																											<div class="col-sm-4 form-group" style="">
																												<?php if($item_checklist['status_approve'] == '0'){ ?>
																													<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-danger">Not Yet</label>
																												<?php }else{ ?>
																													<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-warning">Approved</label>
																												<?php } ?>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>

																							<div class="row">
																								<div class="col-sm-12 form-group">
																									<div class="controls col-lg-6">
																										<a href="#collapse<?php echo $item['id']; ?>" data-parent="#accordion" data-toggle="collapse" onClick="" class="btn btn-default">Closed</a>
																									</div>
																								</div>
																							</div>

																						</div>
																				
																					<?php } ?>
																			
																				<?php } ?>
																				
																			</div>
																			
																			<?php } ?>
																			
																		<?php }else{ ?>
																			
																			<div id="" class="table-responsive form_approve">
																				<table class="table table-striped">
																					<thead>
																						<tr>
																							<td colspan="5" style="text-align: center; background-color: #eff3f4;">Belum ada data hari ini yang masuk</td>
																						</tr>
																					</thead>
																				</table>
																			</div>
																			
																		<?php } ?>
																			
																	</div>
																</div>
															</div>
														</div>
														<?php $no++; ?>
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
		<script src="dist/js/ekko-lightbox.min.js"></script>
		<script src="demo/js/demo.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".form_approve").on("click", ".submit_confirm_me_ac", function(){ 
					
					var parentObj = $(this).closest('.item-sub');
					
					var id 				= parentObj.find('.submit_confirm_me_ac').attr('data-id');
					//var kondisi			= parentObj.find('select[name="kondisi"]').val();
					//var fungsi 			= parentObj.find('select[name="fungsi"]').val();
					//var keterangan	 	= parentObj.find('label[name="keterangan"]').val();
									
					var proceed = true;
					
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id
						};
						//Ajax post data to server
						$.post('action/confirm_checklist_me_ac.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ //load json data from server and output message     
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = '<div class="success">'+response.text+'</div>';
							}
							//$(".alert-success").hide().html(output).slideDown();
							parentObj.find(".success-status").hide().html(output).slideDown();
						}, 'json');
					}
				});
				
				//reset previously set border colors and hide all message on .keyup()
				$("#contact_form  input[required=true], #contact_form textarea[required=true]").keyup(function() { 
					$(this).css('border-color',''); 
					$("#result").slideUp();
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".form_approve").on("click", ".submit_confirm", function(){ 
					
					var parentObj = $(this).closest('.item-sub');
					
					var id 				= parentObj.find('.submit_confirm').attr('data-id');
					var kondisi			= parentObj.find('label[name="kondisi"]').val();
					var fungsi 			= parentObj.find('label[name="fungsi"]').val();
					var keterangan	 	= parentObj.find('label[name="keterangan"]').val();
									
					var proceed = true;
					
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id,kondisi,fungsi,keterangan
						};
						//Ajax post data to server
						$.post('action/confirm_checklist_me.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ //load json data from server and output message     
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = '<div class="success">'+response.text+'</div>';
							}
							//$(".alert-success").hide().html(output).slideDown();
							parentObj.find(".success-status").hide().html(output).slideDown();
						}, 'json');
					}
				});
				
				//reset previously set border colors and hide all message on .keyup()
				$("#contact_form  input[required=true], #contact_form textarea[required=true]").keyup(function() { 
					$(this).css('border-color',''); 
					$("#result").slideUp();
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".form_approve").on("click", ".submit_update", function(){ 
					
					var parentObj = $(this).closest('.item-sub');
					
					var id 				= parentObj.find('.submit_update').attr('data-id');
					var tegangan_r		= parentObj.find('input[name="tegangan_r"]').val();
					var tegangan_s		= parentObj.find('input[name="tegangan_s"]').val();
					var tegangan_t		= parentObj.find('input[name="tegangan_t"]').val();
					var arus_r			= parentObj.find('input[name="arus_r"]').val();
					var arus_s			= parentObj.find('input[name="arus_s"]').val();
					var arus_t			= parentObj.find('input[name="arus_t"]').val();
					var koneksi			= parentObj.find('input[name="koneksi"]').val();
					var wiring			= parentObj.find('input[name="wiring"]').val();
					var fungsi 			= parentObj.find('input[name="fungsi"]:checked').val();
					var kondisi 		= parentObj.find('input[name="kondisi"]:checked').val();
					var keterangan	 	= parentObj.find('label[name="keterangan"]').val();
									
					var proceed = true;
					
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id,tegangan_r,tegangan_s,tegangan_t,arus_r,arus_s,arus_t,koneksi,wiring,kondisi,fungsi,keterangan
						};
						//Ajax post data to server
						$.post('action/update_checklist_me.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ //load json data from server and output message     
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = '<div class="success">'+response.text+'</div>';
							}
							//$(".alert-success").hide().html(output).slideDown();
							parentObj.find(".success-status").hide().html(output).slideDown();
						}, 'json');
					}
				});
				
				//reset previously set border colors and hide all message on .keyup()
				$("#contact_form  input[required=true], #contact_form textarea[required=true]").keyup(function() { 
					$(this).css('border-color',''); 
					$("#result").slideUp();
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".form_approve").on("click", ".btn_submit_comments", function(){ 
					
					var parentObj = $(this).closest('.item-sub');
					
					var id_item 		= parentObj.find('.btn_submit_comments').attr('data-id');
					var comments		= parentObj.find('textarea[name="comments"]').val();
					//var id_user 		= parentObj.find('select[name="fungsi"]').val();
					//console.log(id);
					//console.log(comments);
					
					if(id_item && comments){
						$.ajax
							({
							  type: 'post',
							  url: 'action/post_comments.php',
							  data:{
								 comments:comments,
								 id:id_item
							  },
							success: function (response){
									console.log(response);
									$(".comment_area").append(response);
									parentObj.find('textarea[name="comments"]').val("");
						  
							}
						});
					}
			  
					return false;
				});
			});
		</script>
		<script type="text/javascript">
            $(document).ready(function ($) {
                // delegate calls to data-toggle="lightbox"
                $(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function(event) {
                    event.preventDefault();
                    return $(this).ekkoLightbox({
                        onShown: function() {
                            if (window.console) {
                                return console.log('dor');
                            }
                        },
						onNavigate: function(direction, itemIndex) {
                            if (window.console) {
                                return console.log('Navigating '+direction+'. Current item: '+itemIndex);
                            }
						}
                    });
                });
			});
		</script>
    </body>
</html>
<?php } ?>