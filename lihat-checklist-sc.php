<?php
	$today = date('Y-m-d');
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}
	else{
		include 'core/init.php';
		include 'core/helper/myHelper.php';
		
		$branch = $db->branch()
			->where("id", $_SESSION['branch_id'])->fetch();
		$date_now	= date('Y-m-d');
			
		$allarea = $db->item_area()
			->where("divisi_id", 5)
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
		<link rel="stylesheet" href="dist/css/plugins/jquery-chosen.min.css">
        <style type="text/css">
		    .modal.modal-wide .modal-dialog {
		  		width: 90%;
			}
		</style>
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
						<li class=""><a href="javascript:void(0);">Checklist SC</a></li>
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
								<li <?php if($body == 'lihat_checklist'){echo 'active';}?>><a href="checklist-sc.php"><strong>Input Checklist</a></strong></li>
								<li class="active"><a href="javascript:void(0);"><strong>Lihat Checklist</a></strong></li>
							</ul>
							<div class="tab-content content-area">
								<div class="panel panel-info">
									<div class="panel-heading">
										<h3 class="panel-title">Data Checklist SC</h3>
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
													<h3 class="panel-title">Kegiatan</h3>
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

														<!-- BODY CHECKING -->
														<?php if($item_area_id == 30){ ?>
															<div class="table-responsive">
																<table data-sortable id="table-basic" class="table table-responsive table-hover table-striped">
																	<thead>
																		<tr>
																			<th>No</th>
																			<th>Nama</th>
																			<th>Jabatan</th>
																			<th>Jam Masuk</th>
																			<th>Jam Keluar</th>
																			<th>Keterangan</th>
																			<th>Pilihan</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php 
																			$tanggal_sekarang = date('Y-m-d');
																			$body_checking = $db->body_checking()
																				->where("branch_id", $_SESSION['branch_id'])
																				->where("jam_masuk_created LIKE ?", $tanggal_sekarang.'%');
																		
																			$no=0;
																			if (!empty($body_checking)) {
																				foreach ($body_checking as $body_check){
																				$no++;
																		?>
																		<tr>
																			<td><?php echo $no; ?></td>
																			<td><?php echo $body_check['nama']; ?></td>
																			<td><?php echo $body_check['jabatan']; ?></td>
																			<td><?php echo date("H:i", strtotime($body_check['jam_masuk'])); ?></td>
																			<td>
																				<?php
																					if ($body_check['jam_keluar'] !== '00:00:00') {
																						echo date("H:i", strtotime($body_check['jam_keluar']));
																					}
																					else{
																						echo '-';
																					}
																				?>
																			</td>
																			<td><?php echo ucfirst($body_check['keterangan']); ?></td>
																			<?php
																				if ($body_check['jam_keluar'] == '00:00:00') {
																			?>
																			<td>
																				<a href="#" data-toggle="modal" data-target="#updateJamKeluar<?php $body_check['id']; ?>">
																					<button class="btn btn-md btn-warning">Update Jam Keluar</button>
																				</a>
																				<div class="modal fade" id="updateJamKeluar<?php $body_check['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																					<div class="modal-dialog" role="document">
																						<div class="modal-content">
																							<div class="modal-body">
																								<form method="post" action="sc_body_checking_update_jam_keluar.php">
																									<div class="form-group">
																										<label>Jam Keluar</label>
																										<input type="hidden" name="id" value="<?php echo $body_check['id']; ?>">
																										<input type="time" name="jam_keluar" class="form-control" required autocomplete="OFF">
																									</div>
																									<br><br>
																									<div class="form-group">
																										<input type="submit" class="btn btn-md btn-primary" value="Update">
																										<input type="reset" class="btn btn-md btn-warning" value="Reset">
																									</div>
																								</form>
																							</div>
																							<div class="modal-footer">
																								<button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
																							</div>
																						</div>
																					</div>
																				</div>
																			</td>
																			<?php
																				}
																				else{
																			?>
																			<td>&nbsp;</td>
																			<?php }?>
																		</tr>
																		<?php
																				}
																			}
																		?>
																	</tbody>
																</table>
															</div>
														<?php } ?>

														<!-- KENDARAAN -->
														<?php if($item_area_id == 34){ ?>
															<div class="table-responsive">
																<table class="table table-responsive table-hover table-striped">
																	<thead>
																		<tr>
																			<th>No</th>
																			<th>Plat Nomor</th>
																			<th>Jenis Kendaraan</th>
																			<th>Kondisi Kendaraan</th>
																			<th>Keterangan</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php 
																			$tanggal_sekarang = date('Y-m-d');
																			$sc_kendaraan = $db->sc_kendaraan()
																				->where("branch_id", $_SESSION['branch_id'])
																				->where("created_at LIKE ?", $tanggal_sekarang.'%');
																		
																			$no=0;
																			if (!empty($sc_kendaraan)) {
																				foreach ($sc_kendaraan as $sc_k){
																					$no++;
																		?>
																		<tr>
																			<td><?php echo $no; ?></td>
																			<td><?php echo ucfirst($sc_k['plat_kendaraan']); ?></td>
																			<td><?php echo ucfirst($sc_k['jenis_kendaraan']); ?></td>
																			<td>
																				<?php
																					if ($sc_k['kondisi_kendaraan'] == '1') {
																						echo 'BAIK';
																					}
																					if ($sc_k['kondisi_kendaraan'] == '0') {
																						echo 'RUSAK';
																					}
																				?>
																			</td>
																			<td><?php echo ucfirst($sc_k['keterangan']); ?></td>
																		</tr>
																		<?php
																				}
																			}
																		?>
																	</tbody>
																</table>
															</div>
														<?php } ?>

														<!-- LAPORAN SITUASI -->
														<?php if($item_area_id == 35){ ?>
															<div class="table-responsive">
																<table class="table table-responsive table-hover table-striped">
																	<?php 
																		$tanggal_sekarang = date('Y-m-d');
																		$sc_laporan_situasi = $db->sc_laporan_situasi()
																			->where("branch_id", $_SESSION['branch_id'])
																			->where("created_at LIKE ?", $tanggal_sekarang.'%');

																		if (!empty($sc_laporan_situasi)) {
																			foreach ($sc_laporan_situasi as $sc_ls){
																	?>
																	<tr>
																		<td>
																			Pada hari ini dilaporkan situasi dan kondisi pengamanan di lokasi dalam keadaan:
																			<br>
																			<strong><?php echo ucfirst($sc_ls['keadaan']); ?></strong>
																			<br><br>
																			<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModalScLaporanSituasi">
																				Click Me For Detail !
																			</button>
																			<div class="modal modal-wide fade" id="myModalScLaporanSituasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  																	<div class="modal-dialog" role="document">
			    																	<div class="modal-content">
			      																		<div class="modal-header">
			        																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          																			<span aria-hidden="true">&times;</span>
			        																		</button>
			        																		<h4 class="modal-title" id="myModalLabel">Checklist Security - Laporan Situasi</h4>
			      																		</div>
			      																		<div class="modal-body">
			      																			<table>
			      																				<tr>
			      																					<td colspan="3">
			      																						Pada hari ini dilaporkan situasi dan kondisi pengamanan di lokasi dalam keadaan : 
			      																						<br>
			      																						<strong><?php echo ucfirst($sc_ls['keadaan']); ?></strong>
			      																					</td>
			      																				</tr>
			      																				<tr>
			      																					<td colspan="3">&nbsp;</td>
			      																				</tr>
			      																				<tr>
			      																					<td colspan="3"><strong>Kondisi Personil</strong></td>
			      																				</tr>
			      																				<tr>
			      																					<td colspan="3">
			      																						<table>
			      																							<tr>
			      																								<td width="100%">
						      																						<div class="container">
						      																							<div class="panel-group" id="accordion1">

						      																								<!-- PAGI -->
						      																								<div class="panel panel-default item-sub">
						      																									<div class="panel-heading">
						      																										<h4 class="panel-title">
						      																											<a data-toggle="collapse" data-parent="#accordion1" href="#shift_pagi">Shift Pagi</a>
						      																										</h4>
						      																									</div>
						      																									<div id="shift_pagi" class="panel-collapse collapse">
						      																										<div class="panel-body">
						      																											<table>
						      																												<tr>
						      																													<td>Jumlah</td>
						      																													<td>&nbsp;:&nbsp;</td>
						      																													<td><?php echo $sc_ls['pagi_jumlah'].' Personil';?></td>
						      																												</tr>
						      																												<tr>
						      																													<td>Hadir</td>
						      																													<td>&nbsp;:&nbsp;</td>
						      																													<td><?php echo $sc_ls['pagi_hadir'].' Personil';?></td>
						      																												</tr>
						      																												<tr>
						      																													<td>Tidak Hadir</td>
						      																													<td>&nbsp;:&nbsp;</td>
						      																													<td><?php echo $sc_ls['pagi_tidak_hadir'].' Personil';?></td>
						      																												</tr>
						      																												<tr>
						      																													<td>Backup</td>
						      																													<td>&nbsp;:&nbsp;</td>
						      																													<td><?php echo $sc_ls['pagi_backup'].' Personil';?></td>
						      																												</tr>
						      																												<tr>
						      																													<td>&nbsp;</td>
						      																												</tr>
						      																												<tr>
						      																													<td colspan="3">Keterangan Tidak Hadir: </td>
						      																												</tr>
						      																												<tr>
						      																													<td>
						      																														<div class="table-responsive">
																																						<table class="table table-responsive table-hover table-striped" width="30%">
																																							<thead>
								      																															<tr>
								      																																<th>Nama</th>
								      																																<th>Keterangan</th>
								      																															</tr>
								      																														</thead>
								      																														<tbody>
								      																															<?php
								      																																$connect = mysqli_connect("localhost", "root", "ilovejkt48", "checklist_system_db");
								      																																$tanggal_sekarang = date('Y-m-d');
								      																																$query1 = mysqli_query($connect,"SELECT * FROM sc_laporan_situasi WHERE date(created_at) = '$tanggal_sekarang'");
								      																																$data1 = mysqli_fetch_array($query1,MYSQLI_ASSOC);

								      																																for ($i=0; $i < 6; $i++) {
								      																																	if (!empty($data1['pagi_nama'.$i])) {
								      																															?>
								      																																		<tr>
								      																																			<td><?php echo ucfirst($data1['pagi_nama'.$i]); ?></td>
											      																																<td>
											      																																	<?php
											      																																		if ($data1['pagi_keterangan'.$i] == 1) {
											      																																			echo 'Sakit';
											      																																		}
											      																																		elseif ($data1['pagi_keterangan'.$i] == 2) {
											      																																			echo 'Izin';
											      																																		}
											      																																		elseif ($data1['pagi_keterangan'.$i] == 3) {
											      																																			echo 'Alpha';
											      																																		}
											      																																	?>
											      																																</td>
								      																																		</tr>
								      																															<?php
								      																																	}
								      																																}
								      																															?>
								      																														</tbody>
						      																															</table>
						      																														</div>
						      																													</td>
						      																												</tr>
						      																											</table>
						      																										</div>
						      																									</div>
						      																								</div>

						      																								<!-- SIANG -->
						      																								<div class="panel panel-default item-sub">
						      																									<div class="panel-heading">
						      																										<h4 class="panel-title">
						      																											<a data-toggle="collapse" data-parent="#accordion1" href="#shift_siang">Shift Siang</a>
						      																										</h4>
						      																									</div>
						      																									<div id="shift_siang" class="panel-collapse collapse">
						      																										<div class="panel-body">
						      																											<table>
						      																												<tr>
						      																													<td>Jumlah</td>
						      																													<td>&nbsp;:&nbsp;</td>
						      																													<td><?php echo $sc_ls['siang_jumlah'].' Personil';?></td>
						      																												</tr>
						      																												<tr>
						      																													<td>Hadir</td>
						      																													<td>&nbsp;:&nbsp;</td>
						      																													<td><?php echo $sc_ls['siang_hadir'].' Personil';?></td>
						      																												</tr>
						      																												<tr>
						      																													<td>Tidak Hadir</td>
						      																													<td>&nbsp;:&nbsp;</td>
						      																													<td><?php echo $sc_ls['siang_tidak_hadir'].' Personil';?></td>
						      																												</tr>
						      																												<tr>
						      																													<td>Backup</td>
						      																													<td>&nbsp;:&nbsp;</td>
						      																													<td><?php echo $sc_ls['siang_backup'].' Personil';?></td>
						      																												</tr>
						      																												<tr>
						      																													<td>&nbsp;</td>
						      																												</tr>
						      																												<tr>
						      																													<td colspan="3">Keterangan Tidak Hadir: </td>
						      																												</tr>
						      																												<tr>
						      																													<td>
						      																														<div class="table-responsive">
																																						<table class="table table-responsive table-hover table-striped" width="30%">
																																							<thead>
								      																															<tr>
								      																																<th>Nama</th>
								      																																<th>Keterangan</th>
								      																															</tr>
								      																														</thead>
								      																														<tbody>
								      																															<?php
								      																																$connect = mysqli_connect("localhost", "root", "ilovejkt48", "checklist_system_db");
								      																																$tanggal_sekarang = date('Y-m-d');
								      																																$query1 = mysqli_query($connect,"SELECT * FROM sc_laporan_situasi WHERE date(created_at) = '$tanggal_sekarang'");
								      																																$data1 = mysqli_fetch_array($query1,MYSQLI_ASSOC);

								      																																for ($i=0; $i < 6; $i++) {
								      																																	if (!empty($data1['siang_nama'.$i])) {
								      																															?>
								      																																		<tr>
								      																																			<td><?php echo ucfirst($data1['siang_nama'.$i]); ?></td>
											      																																<td>
											      																																	<?php
											      																																		if ($data1['siang_keterangan'.$i] == 1) {
											      																																			echo 'Sakit';
											      																																		}
											      																																		elseif ($data1['siang_keterangan'.$i] == 2) {
											      																																			echo 'Izin';
											      																																		}
											      																																		elseif ($data1['siang_keterangan'.$i] == 3) {
											      																																			echo 'Alpha';
											      																																		}
											      																																	?>
											      																																</td>
								      																																		</tr>
								      																															<?php
								      																																	}
								      																																}
								      																															?>
								      																														</tbody>
						      																															</table>
						      																														</div>
						      																													</td>
						      																												</tr>
						      																											</table>
						      																										</div>
						      																									</div>
						      																								</div>

						      																								<!-- MALAM -->
						      																								<div class="panel panel-default item-sub">
						      																									<div class="panel-heading">
						      																										<h4 class="panel-title">
						      																											<a data-toggle="collapse" data-parent="#accordion1" href="#shift_malam">Shift Malam</a>
						      																										</h4>
						      																									</div>
						      																									<div id="shift_malam" class="panel-collapse collapse">
						      																										<div class="panel-body">
						      																											<table>
						      																												<tr>
						      																													<td>Jumlah</td>
						      																													<td>&nbsp;:&nbsp;</td>
						      																													<td><?php echo $sc_ls['malam_jumlah'].' Personil';?></td>
						      																												</tr>
						      																												<tr>
						      																													<td>Hadir</td>
						      																													<td>&nbsp;:&nbsp;</td>
						      																													<td><?php echo $sc_ls['malam_hadir'].' Personil';?></td>
						      																												</tr>
						      																												<tr>
						      																													<td>Tidak Hadir</td>
						      																													<td>&nbsp;:&nbsp;</td>
						      																													<td><?php echo $sc_ls['malam_tidak_hadir'].' Personil';?></td>
						      																												</tr>
						      																												<tr>
						      																													<td>Backup</td>
						      																													<td>&nbsp;:&nbsp;</td>
						      																													<td><?php echo $sc_ls['malam_backup'].' Personil';?></td>
						      																												</tr>
						      																												<tr>
						      																													<td>&nbsp;</td>
						      																												</tr>
						      																												<tr>
						      																													<td colspan="3">Keterangan Tidak Hadir: </td>
						      																												</tr>
						      																												<tr>
						      																													<td>
						      																														<div class="table-responsive">
																																						<table class="table table-responsive table-hover table-striped" width="30%">
																																							<thead>
								     																															<tr>
								     																																<th>Nama</th>
								      																																<th>Keterangan</th>
								      																															</tr>
								      																														</thead>
								      																														<tbody>
								      																															<?php
								      																																$connect = mysqli_connect("localhost", "root", "ilovejkt48", "checklist_system_db");
								      																																$tanggal_sekarang = date('Y-m-d');
								      																																$query1 = mysqli_query($connect,"SELECT * FROM sc_laporan_situasi WHERE date(created_at) = '$tanggal_sekarang'");
								      																																$data1 = mysqli_fetch_array($query1,MYSQLI_ASSOC);

								      																																for ($i=0; $i < 6; $i++) {
								      																																	if (!empty($data1['malam_nama'.$i])) {
								      																															?>
								      																																		<tr>
								      																																			<td><?php echo ucfirst($data1['malam_nama'.$i]); ?></td>
											      																																<td>
											      																																	<?php
											      																																		if ($data1['malam_keterangan'.$i] == 1) {
											      																																			echo 'Sakit';
											      																																		}
											      																																		elseif ($data1['malam_keterangan'.$i] == 2) {
											      																																			echo 'Izin';
											      																																		}
											      																																		elseif ($data1['malam_keterangan'.$i] == 3) {
											      																																			echo 'Alpha';
											      																																		}
											      																																	?>
											      																																</td>
								      																																		</tr>
								      																															<?php
								      																																	}
								      																																}
								      																															?>
								      																														</tbody>
						      																															</table>
						      																														</div>
						      																													</td>
						      																												</tr>
						      																											</table>
						      																										</div>
						      																									</div>
						      																								</div>

							      																						</div>
							      																					</div>
							      																				</td>
							      																			</tr>
							      																		</table>
			      																					</td>
			      																				</tr>
			      																				<tr>
			      																					<td>
			      																						<table>
			      																							<tr>
						      																					<td>Jumlah Lembur</td>
						      																					<td align="left">&nbsp;:&nbsp;</td>
						      																					<td align="left"><?php echo $data1['lembur_jumlah']; ?></td>
						      																				</tr>
						      																				<tr>
						      																					<td>Keterangan Lembur</td>
						      																					<td align="left">&nbsp;:&nbsp;</td>
						      																					<td align="left"><?php echo $data1['lembur_keterangan']; ?></td>
						      																				</tr>
			      																						</table>
			      																					</td>
			      																				</tr>
			      																				<tr>
			      																					<td>&nbsp;</td>
			      																				</tr>
			      																				<tr>
			      																					<td>
			      																						<table>
			      																							<tr>
			      																								<td colspan="3"><strong>Kondisi Materiil</strong></td>
			      																							</tr>
			      																							<tr>
			      																								<td colspan="3">
			      																									<div class="table-responsive">
			      																										<table class="table table-responsive table-hover table-striped" width="30%">
			      																											<thead>
			      																												<tr>
			      																													<th>Kondisi</th>
			      																												</tr>
			      																											</thead>
			      																											<tbody>
					      																										<?php
					      																											for ($a=0; $a < 6; $a++) {
					      																												if (!empty($data1['materiil_kondisi'.$a])) {
					      																										?>
					      																													<tr>
					      																														<td><?php echo ucfirst($data1['materiil_kondisi'.$a]); ?></td>
					      																													</tr>
					      																										<?php
					      																												}
					      																											}
					      																										?>
					      																									</tbody>
					      																								</table>
					      																							</div>
			      																								</td>
			      																							</tr>
			      																							<tr>
			      																								<td>Keterangan</td>
			      																								<td>&nbsp;:&nbsp;</td>
			      																								<td><?php echo $data1['materiil_keterangan']; ?></td>
			      																							</tr>
			      																						</table>
			      																					</td>
			      																				</tr>
			      																				<tr>
			      																					<td>&nbsp;</td>
			      																				</tr>
			      																				<tr>
			      																					<td>
			      																						<table>
			      																							<tr>
			      																								<td><strong>Aktivitas</strong></td>
			      																							</tr>
			      																							<tr>
			      																								<td>
			      																									<div class="table-responsive">
			      																										<table class="table table-responsive table-hover table-striped" width="30%">
			      																											<thead>
			      																												<tr>
			      																													<th>Aktivitas</th>
			      																												</tr>
			      																											</thead>
			      																											<tbody>
					      																										<?php
					      																											for ($b=0; $b < 6; $b++) {
					      																												if (!empty($data1['aktivitas'.$b])) {
					      																										?>
					      																													<tr>
					      																														<td><?php echo ucfirst($data1['aktivitas'.$b]); ?></td>
					      																													</tr>
					      																										<?php
					      																												}
					      																											}
					      																										?>
					      																									</tbody>
					      																								</table>
					      																							</div>
			      																								</td>
			      																							</tr>
			      																						</table>
			      																					</td>
			      																				</tr>
			      																			</table>
			      																		</div>
			      																		<div class="modal-footer">
			        																		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			      																		</div>
			    																	</div>
			  																	</div>
																			</div>
																		</td>
																	</tr>
																	<?php
																			}
																		}
																	?>
																</table>
															</div>
														<?php } ?>
														
														<?php $no = 1; ?>
														<!-- PENGAMBILAN UANG DIBRANKAS | PENYIMPANAN UANG DIBRANKAS | LAPORAN SITUASI -->
														<?php if($item_area_id == 36){ ?>
															<div class="panel panel-default item-sub">
																<div class="panel-heading">
																	<h4 class="panel-title">
																		<a href="#collapsePengambilanPenyimpananLaporan" data-parent="#accordion" data-toggle="collapse">
																			<b>Pengambilan - Penyimpanan Uang Dibrankas - Laporan Situasi</b>
																		</a>
																	</h4>
																</div>
																<div class="panel-collapse collapse" id="collapsePengambilanPenyimpananLaporan">
																	<div class="panel-body">
																		<div class="row">
																			<div id="pengambilan_penyimpanan_laporan">
																				<div class="table-responsive">
																					<?php
																						$$tanggal_sekarang = date('Y-m-d');
																						$connect36 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																						$query36 = mysqli_query($connect36,"SELECT * FROM kegiatan_security WHERE CONVERT(created_at, date) = '$tanggal_sekarang' AND branch_id = '".$_SESSION['branch_id']."'");
																						$jumlah36 = mysqli_num_rows($query36);
																						if ($jumlah36 > 0) {
																					?>
																					<table class="table table-responsive table-hover table-striped">
																						<thead>
																							<tr>
																								<td colspan="3" align="center"><strong>Pengambilan Uang Dibrangkas</strong></td>
																							</tr>
																							<tr>
																								<th>Jam</th>
																								<th>Diambil Oleh</th>
																								<th>Saksi</th>
																							</tr>
																						</thead>
																						<tbody>
																							<?php
																								$kegiatan_security = $db->kegiatan_security()
																									->where("branch_id", $_SESSION['branch_id'])
																									->where("created_at LIKE ?", $tanggal_sekarang.'%');
																							
																								$no=0;
																								if (!empty($kegiatan_security)) {
																									foreach ($kegiatan_security as $k_s){
																									$no++;
																							?>
																							<tr>
																								<td><?php echo date("H:i", strtotime($k_s['ambil_jam'])); ?></td>
																								<td><?php echo $k_s['ambil_oleh']; ?></td>
																								<td><?php echo $k_s['ambil_saksi1']; ?><br><?php echo $k_s['ambil_saksi2']; ?></td>
																							</tr>
																							<?php
																									}
																								}
																							?>
																						</tbody>
																					</table>
																					<table class="table table-responsive table-hover table-striped">
																						<thead>
																							<tr>
																								<td colspan="3" align="center"><strong>Penyimpanan Uang Dibrangkas</strong></td>
																							</tr>
																							<tr>
																								<th>Jam</th>
																								<th>Disimpan Oleh</th>
																								<th>Saksi</th>
																							</tr>
																						</thead>
																						<tbody>
																							<?php																							
																								$no=0;
																								if (!empty($kegiatan_security)) {
																									foreach ($kegiatan_security as $k_s){
																									$no++;
																							?>
																							<tr>
																								<td><?php echo date("H:i", strtotime($k_s['simpan_jam'])); ?></td>
																								<td><?php echo $k_s['simpan_oleh']; ?></td>
																								<td><?php echo $k_s['simpan_saksi1']; ?><br><?php echo $k_s['simpan_saksi2']; ?></td>
																							</tr>
																							<?php
																									}
																								}
																							?>
																						</tbody>
																					</table>
																					<table class="table table-responsive table-hover table-striped">
																						<thead>
																							<tr>
																								<td colspan="3" align="center"><strong>Laporan Situasi</strong></td>
																							</tr>
																						</thead>
																						<tbody>
																							<?php 
																								$no=0;
																								if (!empty($kegiatan_security)) {
																									foreach ($kegiatan_security as $k_s){
																									$no++;
																							?>
																							<tr>
																								<td>1. <?php echo $k_s['laporan_situasi1']; ?></td>
																							</tr>
																							<tr>
																								<?php
																									if ($k_s['laporan_situasi2'] == '') {
																								?>
																								<td>
																									2. 
																									<a href="#" data-toggle="modal" data-target="#updateLaporanSituasi2">
																										<button class="btn btn-sm btn-info">INSERT LAPORAN SITUASI - 2</button>
																									</a>
																									<div class="modal fade" id="updateLaporanSituasi2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																										<div class="modal-dialog" role="document">
																											<div class="modal-content">
																												<div class="modal-body">
																													<form method="post" action="sc_kegiatan_security_update_laporan_situasi.php?id=2">
																														<div class="row">
																															<div class="col-md-12">
																																<div class="form-group">
																																	<label>Laporan Situasi - 2</label>
																																	<input type="hidden" name="id" value="<?php echo $k_s['id']; ?>">
																																	<input type="text" name="laporan_situasi2" class="form-control" required autocomplete="OFF">
																																</div>
																																<br><br>
																																<div class="form-group">
																																	<input type="submit" class="btn btn-md btn-primary" value="Update">
																																	<input type="reset" class="btn btn-md btn-warning" value="Reset">
																																</div>
																															</div>
																														</div>
																													</form>
																												</div>
																												<div class="modal-footer">
																													<button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
																												</div>
																											</div>
																										</div>
																									</div>
																								</td>
																								<?php
																									}
																									else{
																								?>
																								<td>2. <?php echo $k_s['laporan_situasi2']; ?></td>
																								<?php } ?>
																							</tr>
																							<tr>
																								<?php
																									if ($k_s['laporan_situasi3'] == '') {
																								?>
																								<td>
																									3. 
																									<a href="#" data-toggle="modal" data-target="#updateLaporanSituasi3">
																										<button class="btn btn-sm btn-info">INSERT LAPORAN SITUASI - 3</button>
																									</a>
																									<div class="modal fade" id="updateLaporanSituasi3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																										<div class="modal-dialog" role="document">
																											<div class="modal-content">
																												<div class="modal-body">
																													<form method="post" action="sc_kegiatan_security_update_laporan_situasi.php?id=3">
																														<div class="row">
																															<div class="col-md-12">
																																<div class="form-group">
																																	<label>Laporan Situasi - 3</label>
																																	<input type="hidden" name="id" value="<?php echo $k_s['id']; ?>">
																																	<input type="text" name="laporan_situasi3" class="form-control" required autocomplete="OFF">
																																</div>
																																<br><br>
																																<div class="form-group">
																																	<input type="submit" class="btn btn-md btn-primary" value="Update">
																																	<input type="reset" class="btn btn-md btn-warning" value="Reset">
																																</div>
																															</div>
																														</div>
																													</form>
																												</div>
																												<div class="modal-footer">
																													<button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
																												</div>
																											</div>
																										</div>
																									</div>
																								</td>
																								<?php
																									}
																									else{
																								?>
																								<td>3. <?php echo $k_s['laporan_situasi3']; ?></td>
																								<?php } ?>
																							</tr>
																							<tr>
																								<?php
																									if ($k_s['laporan_situasi4'] == '') {
																								?>
																								<td>
																									4. 
																									<a href="#" data-toggle="modal" data-target="#updateLaporanSituasi4">
																										<button class="btn btn-sm btn-info">INSERT LAPORAN SITUASI - 4</button>
																									</a>
																									<div class="modal fade" id="updateLaporanSituasi4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																										<div class="modal-dialog" role="document">
																											<div class="modal-content">
																												<div class="modal-body">
																													<form method="post" action="sc_kegiatan_security_update_laporan_situasi.php?id=4">
																														<div class="row">
																															<div class="col-md-12">
																																<div class="form-group">
																																	<label>Laporan Situasi - 4</label>
																																	<input type="hidden" name="id" value="<?php echo $k_s['id']; ?>">
																																	<input type="text" name="laporan_situasi4" class="form-control" required autocomplete="OFF">
																																</div>
																																<br><br>
																																<div class="form-group">
																																	<input type="submit" class="btn btn-md btn-primary" value="Update">
																																	<input type="reset" class="btn btn-md btn-warning" value="Reset">
																																</div>
																															</div>
																														</div>
																													</form>
																												</div>
																												<div class="modal-footer">
																													<button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
																												</div>
																											</div>
																										</div>
																									</div>
																								</td>
																								<?php
																									}
																									else{
																								?>
																								<td>4. <?php echo $k_s['laporan_situasi4']; ?></td>
																								<?php } ?>
																							</tr>
																							<tr>
																								<?php
																									if ($k_s['laporan_situasi5'] == '') {
																								?>
																								<td>
																									5. 
																									<a href="#" data-toggle="modal" data-target="#updateLaporanSituasi5">
																										<button class="btn btn-sm btn-info">INSERT LAPORAN SITUASI - 5</button>
																									</a>
																									<div class="modal fade" id="updateLaporanSituasi5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																										<div class="modal-dialog" role="document">
																											<div class="modal-content">
																												<div class="modal-body">
																													<form method="post" action="sc_kegiatan_security_update_laporan_situasi.php?id=5">
																														<div class="row">
																															<div class="col-md-12">
																																<div class="form-group">
																																	<label>Laporan Situasi - 5</label>
																																	<input type="hidden" name="id" value="<?php echo $k_s['id']; ?>">
																																	<input type="text" name="laporan_situasi5" class="form-control" required autocomplete="OFF">
																																</div>
																																<br><br>
																																<div class="form-group">
																																	<input type="submit" class="btn btn-md btn-primary" value="Update">
																																	<input type="reset" class="btn btn-md btn-warning" value="Reset">
																																</div>
																															</div>
																														</div>
																													</form>
																												</div>
																												<div class="modal-footer">
																													<button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
																												</div>
																											</div>
																										</div>
																									</div>
																								</td>
																								<?php
																									}
																									else{
																								?>
																								<td>5. <?php echo $k_s['laporan_situasi5']; ?></td>
																								<?php } ?>
																							</tr>
																							<tr>
																								<?php
																									if ($k_s['laporan_situasi6'] == '') {
																								?>
																								<td>
																									6. 
																									<a href="#" data-toggle="modal" data-target="#updateLaporanSituasi6">
																										<button class="btn btn-sm btn-info">INSERT LAPORAN SITUASI - 6</button>
																									</a>
																									<div class="modal fade" id="updateLaporanSituasi6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																										<div class="modal-dialog" role="document">
																											<div class="modal-content">
																												<div class="modal-body">
																													<form method="post" action="sc_kegiatan_security_update_laporan_situasi.php?id=6">
																														<div class="row">
																															<div class="col-md-12">
																																<div class="form-group">
																																	<label>Laporan Situasi - 6</label>
																																	<input type="hidden" name="id" value="<?php echo $k_s['id']; ?>">
																																	<input type="text" name="laporan_situasi6" class="form-control" required autocomplete="OFF">
																																</div>
																																<br><br>
																																<div class="form-group">
																																	<input type="submit" class="btn btn-md btn-primary" value="Update">
																																	<input type="reset" class="btn btn-md btn-warning" value="Reset">
																																</div>
																															</div>
																														</div>
																													</form>
																												</div>
																												<div class="modal-footer">
																													<button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
																												</div>
																											</div>
																										</div>
																									</div>
																								</td>
																								<?php
																									}
																									else{
																								?>
																								<td>6. <?php echo $k_s['laporan_situasi6']; ?></td>
																								<?php } ?>
																							</tr>
																							<tr>
																								<?php
																									if ($k_s['laporan_situasi7'] == '') {
																								?>
																								<td>
																									7. 
																									<a href="#" data-toggle="modal" data-target="#updateLaporanSituasi7">
																										<button class="btn btn-sm btn-info">INSERT LAPORAN SITUASI - 7</button>
																									</a>
																									<div class="modal fade" id="updateLaporanSituasi7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																										<div class="modal-dialog" role="document">
																											<div class="modal-content">
																												<div class="modal-body">
																													<form method="post" action="sc_kegiatan_security_update_laporan_situasi.php?id=7">
																														<div class="row">
																															<div class="col-md-12">
																																<div class="form-group">
																																	<label>Laporan Situasi - 7</label>
																																	<input type="hidden" name="id" value="<?php echo $k_s['id']; ?>">
																																	<input type="text" name="laporan_situasi7" class="form-control" required autocomplete="OFF">
																																</div>
																																<br><br>
																																<div class="form-group">
																																	<input type="submit" class="btn btn-md btn-primary" value="Update">
																																	<input type="reset" class="btn btn-md btn-warning" value="Reset">
																																</div>
																															</div>
																														</div>
																													</form>
																												</div>
																												<div class="modal-footer">
																													<button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
																												</div>
																											</div>
																										</div>
																									</div>
																								</td>
																								<?php
																									}
																									else{
																								?>
																								<td>7. <?php echo $k_s['laporan_situasi7']; ?></td>
																								<?php } ?>
																							</tr>
																							<?php
																									}
																								}
																							?>
																						</tbody>
																					</table>
																					<?php
																						}
																						else{
																					?>
																					<table class="table">
																						<thead>
																							<tr>
																								<td colspan="5" style="text-align: center; background-color: #eff3f4;">Belum ada data hari ini yang masuk</td>
																							</tr>
																						</thead>
																					</table>
																					<?php
																						}
																					?>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														<?php } ?>

														<!-- KEGIATAN SECURITY (HARIAN) -->
														<?php if($item_area_id == 36){ ?>
															<div class="accordion" id="myAccordion">
															<?php
																$connect1 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																$query1 = mysqli_query($connect1,"SELECT * FROM item WHERE item_area_id = '36'");
																while($data1 = mysqli_fetch_array($query1)){
															?>
																<div class="panel panel-default item-sub">
																	<div class="panel-heading">
																		<h4 class="panel-title">
																			<a href="#collapse<?php echo $data1['id']; ?>" data-parent="#myAccordion" data-toggle="collapse">
																				<b><?php echo $data1['item_name']; ?></b>
																			</a>
																		</h4>
																	</div>
																	<div class="panel-collapse collapse" id="collapse<?php echo $data1['id']; ?>">
																		<div class="panel-body">
																			<div class="row">
																				<div class="table-responsive form_approve">
																					<?php
																						$date_now = date('Y-m-d');
																						$connect13 = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
																						$query13 = mysqli_query($connect13,"SELECT * FROM item_checklist WHERE CONVERT(checked_at, date) = '$date_now' AND item_id = '".$data1['id']."' AND branch_id = '$branch'");
																						$jumlah13 = mysqli_num_rows($query13);
																						$data13 = mysqli_fetch_array($query13,MYSQLI_ASSOC);
																						if ($jumlah13 > 0) {
																					?>
																					<table data-sortable class="form_approve table table-hover table-bordered table-striped">
																						<thead>
																							<tr class="panel-heading">
																								<th>Status (Opening)</th>
																								<th>Keterangan (Opening)</th>
																								<th>Status (Closing)</th>
																								<th>Keterangan (Closing)</th>
																								<th>Status</th>
																								<?php
																									if($data13['status_approve'] == '0' && $_SESSION['user_type'] != 'operator'){
																								?>
																									<th>Action</th>
																								<?php } ?>
																							</tr>
																						</thead>
																						<tbody>
																							<tr class="odd gradeX">
																								<td>
																									<label name="bc_opening_status">
																										<?php
																											if ($data13['bc_opening_status'] == 2) {
																												echo "On";
																											}
																											elseif ($data13['bc_opening_status'] == 1) {
																												echo "Off";
																											}
																										?>
																									</label>
																								</td>
																								<td class="center">
																									<label name="bc_opening_keterangan"><?php echo ucfirst($data13['bc_opening_keterangan']); ?></label>
																								</td>
																								<td>
																									<label name="bc_opening_status">
																										<?php
																											if ($data13['bc_closing_status'] == 2) {
																												echo "On";
																											}
																											elseif ($data13['bc_closing_status'] == 1) {
																												echo "Off";
																											}
																										?>
																									</label>
																								</td>
																								<td class="center">
																									<label name="bc_opening_keterangan"><?php echo ucfirst($data13['bc_closing_keterangan']); ?></label>
																								</td>
																								<td class="center btn_confirm">
																									<?php
																										if($data13['status_approve'] == '0'){
																									?>
																										<label style="margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-danger">Not Yet</label>
																									<?php
																										}
																										else{
																									?>
																										<label style="margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-success">Approved</label>
																									<?php } ?>
																								</td>
																								<?php if($data13['status_approve'] == '0' && $_SESSION['user_type'] != 'operator'){ ?>
																								<td class="center">
																									<a id="" href="javascript:void(0);" data-id="<?php echo $data13['id']; ?>" class="btn btn-warning submit_confirm">Approve</a>
																								</td>
																								<?php } ?>
																							</tr>
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
																									->where("item_id", $data13['item_id'])
																									->where("branch_id", $_SESSION['branch_id'])
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
																							->where("item_checklist_id", $data13['id'])
																							->where("CONVERT(created, date)", $today);
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
																								<button data-id="<?php echo $data13['id']; ?>"  class="btn btn-primary btn_submit_comments">Submit</button>
																							</div>
																						</div>
																					</div>
																					<hr/>
																					<?php
																						}
																						else{
																					?>
																					<table class="table">
																						<thead>
																							<tr>
																								<td colspan="5" style="text-align: center; background-color: #eff3f4;">Belum ada data hari ini yang masuk</td>
																							</tr>
																						</thead>
																					</table>
																					<?php
																						}
																					?>
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
            $(document).ready(function ($) {
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

		<script type="text/javascript">
			$(document).ready(function(){
				$(".form_approve").on("click", ".submit_confirm", function(){
					var parentObj = $(this).closest('.item-sub');
					var id 		  = parentObj.find('.submit_confirm').attr('data-id');
					var proceed = true;

					post_data = {
						id
					};
					$.post('action/confirm_checklist_sc_bc.php', post_data, function(response){
						if(response.type == 'error'){
							output = '<div class="error">'+response.text+'</div>';
							console.log ('error');
						}else{
							output = '<div class="success">'+response.text+'</div>';
						}
						$(".alert-success").hide().html(output).slideDown();
					}, 'json');

					var $this = $(this);
					if ($this.hasClass("submit_confirm")){
						$this.removeClass("btn-warning");
						$this.addClass("btn-success");
					}
				});
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

    </body>
</html>
<?php } ?>