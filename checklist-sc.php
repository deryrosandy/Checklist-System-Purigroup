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
			->where("divisi_id", 5)
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
						<li class=""><a href="javascript:;">Checklist SC</a></li>
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
								<li <?php if($body == 'lihat_checklist'){echo 'active';}?>><a href="lihat-checklist-sc.php"><strong>Lihat Checklist</a></strong></li>
							</ul>
							<div class="tab-content">
								<div class="panel panel-info">
									<div class="panel-heading">
										<h3 class="panel-title">Input Checklist SC</h3>
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
													<h3 class="panel-title">Kegiatan</h3>
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
													
													<!-- BODY CHECKING -->
													<?php if($item_area_id == 30){ ?>
														<div class="row" id="body_checking">
															<div class="col-lg-12" style="">
																<label class="controls col-lg-6 required" for=""><b><h4>Nama</h4></b></label>
															</div>
															<div class="col-sm-12 form-group" style="">
																<div class="controls col-lg-6" width="">
																	<input type="text" name="nama" class="form-control required" title="Field Required">
																</div>
															</div>
															<div class="col-lg-12" style="">
																<label class="controls col-lg-6 required" for=""><b><h4>Jabatan</h4></b></label>
															</div>
															<div class="col-sm-12 form-group" style="">
																<div class="controls col-lg-6" width="">
																	<input type="text" name="jabatan" class="form-control required" title="Field Required">
																</div>
															</div>
															<div class="col-lg-12" style="">
																<label class="controls col-lg-6 required" for=""><b><h4>Jam Masuk</h4></b></label>
															</div>
															<div class="col-sm-12 form-group" style="">
																<div class="controls col-lg-6" width="">
																	<input type="time" name="jam_masuk" class="form-control required" title="Field Required">
																</div>
															</div>
															<div class="col-lg-12" style="">
																<label class="controls col-lg-6 required" for=""><b><h4>Keterangan</h4></b></label>
															</div>
															<div class="col-sm-12 form-group" style="">
																<div class="controls col-lg-6" width="">
																	<textarea name="keterangan" id="keterangan" rows="4" class="form-control required" title="Field Required"></textarea>
																</div>
															</div>
															<div class="col-sm-12 form-group" style="">
																<br/>
																<div class="col-lg-12">
																	<div class="btn-action pull-left">
																		<button type="submit" onClick="" id="submit_btn_body_checking" name="submit" data-id="<?php echo $item_area_id; ?>" onClick="" class="btn btn-primary submit_checklist">Simpan</button>
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

													<!-- KENDARAAN -->
													<?php if($item_area_id == 34){ ?>
														<div class="row" id="kendaraan">
															<div class="col-lg-12" style="">
																<label class="controls col-lg-12" for=""><b><u>Checklist Kendaraan</u></b></label>
															</div>
															<div class="col-lg-12" style="">
																<label class="controls col-lg-6 required" for=""><b><h4>Plat Nomor</h4></b></label>
															</div>
															<div class="col-sm-12 form-group" style="">
																<div class="controls col-lg-6" width="">
																	<input type="text" name="sc_kendaraan_plat_kendaraan" class="form-control required" title="Field Required">
																</div>
															</div>
															<div class="col-lg-12" style="">
																<label class="controls col-lg-6 required" for=""><b><h4>Jenis Kendaraan</h4></b></label>
															</div>
															<div class="col-sm-12 form-group" style="">
																<div class="controls col-lg-6" width="">
																	<input type="text" name="sc_kendaraan_jenis_kendaraan" class="form-control required" title="Field Required">
																</div>
															</div>
															<div class="col-lg-12" style="">
																<label class="controls col-lg-6 required" for=""><b><h4>Kondisi</h4></b></label>
															</div>
															<div class="col-lg-12" style="">
																<div class="controls col-lg-2" width="">
																	<div class="radio">
																		<label style="padding-left: 0;">
																			<input type="radio" value="1" name="sc_kendaraan_kondisi" class="icheck square-blue" />
																			Baik
																		</label>
																	</div>
																</div>
																<div class="controls col-lg-2" width="">
																	<div class="radio">
																		<label style="padding-left: 0;">
																			<input type="radio" value="0" name="sc_kendaraan_kondisi" class="icheck square-blue" />
																			Rusak
																		</label>
																	</div>
																</div>
															</div>
															<div class="col-lg-12" style="">
																<label class="controls col-lg-6 required" for=""><b><h4>Keterangan</h4></b></label>
															</div>
															<div class="col-sm-12 form-group" style="">
																<div class="controls col-lg-6" width="">
																	<textarea name="sc_kendaraan_keterangan" id="keterangan" rows="4" class="form-control required" title="Field Required"></textarea>
																</div>
															</div>

															<div class="col-sm-12 form-group" style="">
																<br/>
																<div class="col-lg-12">
																	<div class="btn-action pull-left">
																		<button type="submit" onClick="" id="submit_btn_kendaraan" name="submit" data-id="<?php echo $item_area_id; ?>" onClick="" class="btn btn-primary submit_kendaraan">Simpan</button>
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

													<!-- KEGIATAN SECURITY (HARIAN) -->
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
																			<table width="100%">
																				<tr>
																					<td valign="top">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b><u>Pengambilan Uang Di brankas</u></b></label>
																						</div>
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-6 required" for=""><b><h4>Jam</h4></b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-6" width="">
																								<input type="time" name="sc_pengambilan_jam" class="form-control required" title="Field Required">
																							</div>
																						</div>
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-6 required" for=""><b><h4>Diambil Oleh</h4></b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-6" width="">
																								<input type="text" name="sc_pengambilan_diambil_oleh" class="form-control required" title="Field Required">
																							</div>
																						</div>
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-6 required" for=""><b><h4>Saksi</h4></b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-6" width="">
																								<input type="text" name="sc_pengambilan_saksi1" class="form-control required" title="Field Required" placeholder="Saksi 1">
																							</div>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-6" width="">
																								<input type="text" name="sc_pengambilan_saksi2" class="form-control required" title="Field Required" placeholder="Saksi 2">
																							</div>
																						</div>
																					</td>
																					<td valign="top">
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b><u>Penyimpanan Uang Di brankas</u></b></label>
																						</div>
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-6 required" for=""><b><h4>Jam</h4></b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-6" width="">
																								<input type="time" name="sc_penyimpanan_jam" class="form-control required" title="Field Required">
																							</div>
																						</div>
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-6 required" for=""><b><h4>Diambil Oleh</h4></b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-6" width="">
																								<input type="text" name="sc_penyimpanan_diambil_oleh" class="form-control required" title="Field Required">
																							</div>
																						</div>
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-6 required" for=""><b><h4>Saksi</h4></b></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-6" width="">
																								<input type="text" name="sc_penyimpanan_saksi1" class="form-control required" title="Field Required" placeholder="Saksi 1">
																							</div>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-6" width="">
																								<input type="text" name="sc_penyimpanan_saksi2" class="form-control required" title="Field Required" placeholder="Saksi 2">
																							</div>
																						</div>
																					</td>
																				</tr>
																				<tr>
																					<td colspan="2">
																						<br><br><br>
																						<div class="col-lg-12" style="">
																							<label class="controls col-lg-12" for=""><b><u>Laporan Situasi</u></b> <font class="text-warning">(Laporan situasi dapat ditambah pada menu Lihat Checklist)</font></label>
																						</div>
																						<div class="col-sm-12 form-group" style="">
																							<div class="controls col-lg-12" width="">
																								<input type="text" name="sc_laporan_situasi_keterangan1" class="form-control" autocomplete="OFF">
																							</div>
																						</div>
																					</td>
																				</tr>
																			</table>
																			<div class="col-sm-12 form-group" style="">
																				<br/>
																				<div class="col-lg-12">
																					<div class="btn-action pull-left">
																						<button type="submit" onClick="" id="submit_btn_pengambilan_penyimpanan_laporan" name="submit" data-id="<?php echo $item_area_id; ?>" onClick="" class="btn btn-primary submit_pengambilan_penyimpanan_laporan">Simpan</button>
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
																	</div>
																</div>
															</div>
														</div>
													<?php } ?>

													<!-- LAPORAN SITUASI -->
													<?php if($item_area_id == 35){ ?>
														<div class="row" id="laporan_situasi">
															<div class="col-lg-12" style="">
																<label class="controls col-lg-12 required" for=""><b><h4>Pada hari ini dilaporkan situasi dan kondisi pengamanan dilokasi dalam keadaan:</h4></b></label>
															</div>
															<div class="col-sm-12 form-group" style="">
																<div class="controls col-lg-12" width="">
																	<input type="text" name="sc_ls_keadaan" class="form-control required" title="Field Required">
																</div>
															</div>
															<div class="col-lg-12" style="">
																<br><br>
																<label class="controls col-lg-12" for=""><b><u>Kondisi Personil - Shift Pagi</u></b></label>
															</div>
															<table width="100%">
																<tr>
																	<td valign="top" width="40%">
																		<table>
																			<tr>
																				<td>
																					<div class="col-lg-12" style="">
																						<label class="controls col-lg-12 required" for=""><b><h4>Jumlah</h4></b></label>
																					</div>
																					<div class="col-sm-12 form-group" style="">
																						<div class="controls col-lg-12" width="">
																							<input type="number" name="sc_ls_pagi_jumlah" class="form-control required" title="Field Required">
																						</div>
																					</div>
																					<div class="col-lg-12" style="">
																						<label class="controls col-lg-12 required" for=""><b><h4>Hadir</h4></b></label>
																					</div>
																					<div class="col-sm-12 form-group" style="">
																						<div class="controls col-lg-12" width="">
																							<input type="number" name="sc_ls_pagi_hadir" class="form-control required" title="Field Required">
																						</div>
																					</div>
																					<div class="col-lg-12" style="">
																						<label class="controls col-lg-12 required" for=""><b><h4>Tidak Hadir</h4></b></label>
																					</div>
																					<div class="col-sm-12 form-group" style="">
																						<div class="controls col-lg-12" width="">
																							<input type="number" name="sc_ls_pagi_tidak_hadir" class="form-control required" title="Field Required">
																						</div>
																					</div>
																					<div class="col-lg-12" style="">
																						<label class="controls col-lg-12 required" for=""><b><h4>Backup</h4></b></label>
																					</div>
																					<div class="col-sm-12 form-group" style="">
																						<div class="controls col-lg-12" width="">
																							<input type="number" name="sc_ls_pagi_backup" class="form-control required" title="Field Required">
																						</div>
																					</div>
																				</td>
																			</tr>
																		</table>
																	</td>
																	<td valign="top" width="60%">
																		<table>
																			<tr>
																				<td width="80%">
																					<?php
																						for ($i=1; $i < 6; $i++) {
																					?>
																					<div class="col-sm-12 form-group" style="">
																						<div class="controls col-lg-8" width="">
																							<input type="text" name="<?php echo 'sc_ls_pagi_nama'.$i; ?>" class="form-control required" title="Field Required" placeholder="Nama Personil Yang Tidak Hadir">
																						</div>
																					</div>
																					<div class="col-sm-12 form-group" style="">
																						<div class="controls col-lg-3" width="">
																							<div class="radio">
																								<label>
																									<input type="radio" value="1" name="<?php echo 'sc_ls_pagi_keterangan'.$i; ?>" class="icheck square-blue" />
																									S
																								</label>
																							</div>
																						</div>
																						<div class="controls col-lg-3" width="">
																							<div class="radio">
																								<label>
																									<input type="radio" value="2" name="<?php echo 'sc_ls_pagi_keterangan'.$i; ?>" class="icheck square-blue" />
																									I
																								</label>
																							</div>
																						</div>
																						<div class="controls col-lg-3" width="">
																							<div class="radio">
																								<label>
																									<input type="radio" value="3" name="<?php echo 'sc_ls_pagi_keterangan'.$i; ?>" class="icheck square-blue" />
																									A
																								</label>
																							</div>
																						</div>
																					</div>
																					<?php } ?>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
															<div class="col-lg-12" style="">
																<br><br>
																<label class="controls col-lg-12" for=""><b><u>Kondisi Personil - Shift Siang</u></b></label>
															</div>
															<table width="100%">
																<tr>
																	<td valign="top" width="40%">
																		<table>
																			<tr>
																				<td>
																					<div class="col-lg-12" style="">
																						<label class="controls col-lg-12 required" for=""><b><h4>Jumlah</h4></b></label>
																					</div>
																					<div class="col-sm-12 form-group" style="">
																						<div class="controls col-lg-12" width="">
																							<input type="number" name="sc_ls_siang_jumlah" class="form-control required" title="Field Required">
																						</div>
																					</div>
																					<div class="col-lg-12" style="">
																						<label class="controls col-lg-12 required" for=""><b><h4>Hadir</h4></b></label>
																					</div>
																					<div class="col-sm-12 form-group" style="">
																						<div class="controls col-lg-12" width="">
																							<input type="number" name="sc_ls_siang_hadir" class="form-control required" title="Field Required">
																						</div>
																					</div>
																					<div class="col-lg-12" style="">
																						<label class="controls col-lg-12 required" for=""><b><h4>Tidak Hadir</h4></b></label>
																					</div>
																					<div class="col-sm-12 form-group" style="">
																						<div class="controls col-lg-12" width="">
																							<input type="number" name="sc_ls_siang_tidak_hadir" class="form-control required" title="Field Required">
																						</div>
																					</div>
																					<div class="col-lg-12" style="">
																						<label class="controls col-lg-12 required" for=""><b><h4>Backup</h4></b></label>
																					</div>
																					<div class="col-sm-12 form-group" style="">
																						<div class="controls col-lg-12" width="">
																							<input type="number" name="sc_ls_siang_backup" class="form-control required" title="Field Required">
																						</div>
																					</div>
																				</td>
																			</tr>
																		</table>
																	</td>
																	<td valign="top" width="60%">
																		<table>
																			<tr>
																				<td width="80%">
																					<?php
																						for ($i=1; $i < 6; $i++) {
																					?>
																					<div class="col-sm-12 form-group" style="">
																						<div class="controls col-lg-8" width="">
																							<input type="text" name="<?php echo 'sc_ls_siang_nama'.$i; ?>" class="form-control required" title="Field Required" placeholder="Nama Personil Yang Tidak Hadir">
																						</div>
																					</div>
																					<div class="col-sm-12 form-group" style="">
																						<div class="controls col-lg-3" width="">
																							<div class="radio">
																								<label>
																									<input type="radio" value="1" name="<?php echo 'sc_ls_siang_keterangan'.$i; ?>" class="icheck square-blue" />
																									S
																								</label>
																							</div>
																						</div>
																						<div class="controls col-lg-3" width="">
																							<div class="radio">
																								<label>
																									<input type="radio" value="2" name="<?php echo 'sc_ls_siang_keterangan'.$i; ?>" class="icheck square-blue" />
																									I
																								</label>
																							</div>
																						</div>
																						<div class="controls col-lg-3" width="">
																							<div class="radio">
																								<label>
																									<input type="radio" value="3" name="<?php echo 'sc_ls_siang_keterangan'.$i; ?>" class="icheck square-blue" />
																									A
																								</label>
																							</div>
																						</div>
																					</div>
																					<?php } ?>

																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
															<div class="col-lg-12" style="">
																<br><br>
																<label class="controls col-lg-12" for=""><b><u>Kondisi Personil - Shift Malam</u></b></label>
															</div>
															<table width="100%">
																<tr>
																	<td valign="top" width="40%">
																		<table>
																			<tr>
																				<td>
																					<div class="col-lg-12" style="">
																						<label class="controls col-lg-12 required" for=""><b><h4>Jumlah</h4></b></label>
																					</div>
																					<div class="col-sm-12 form-group" style="">
																						<div class="controls col-lg-12" width="">
																							<input type="number" name="sc_ls_malam_jumlah" class="form-control required" title="Field Required">
																						</div>
																					</div>
																					<div class="col-lg-12" style="">
																						<label class="controls col-lg-12 required" for=""><b><h4>Hadir</h4></b></label>
																					</div>
																					<div class="col-sm-12 form-group" style="">
																						<div class="controls col-lg-12" width="">
																							<input type="number" name="sc_ls_malam_hadir" class="form-control required" title="Field Required">
																						</div>
																					</div>
																					<div class="col-lg-12" style="">
																						<label class="controls col-lg-12 required" for=""><b><h4>Tidak Hadir</h4></b></label>
																					</div>
																					<div class="col-sm-12 form-group" style="">
																						<div class="controls col-lg-12" width="">
																							<input type="number" name="sc_ls_malam_tidak_hadir" class="form-control required" title="Field Required">
																						</div>
																					</div>
																					<div class="col-lg-12" style="">
																						<label class="controls col-lg-12 required" for=""><b><h4>Backup</h4></b></label>
																					</div>
																					<div class="col-sm-12 form-group" style="">
																						<div class="controls col-lg-12" width="">
																							<input type="number" name="sc_ls_malam_backup" class="form-control required" title="Field Required">
																						</div>
																					</div>
																				</td>
																			</tr>
																		</table>
																	</td>
																	<td valign="top" width="60%">
																		<table>
																			<tr>
																				<td width="80%">
																					
																					<?php
																						for ($i=1; $i < 6; $i++) {
																					?>
																					<div class="col-sm-12 form-group" style="">
																						<div class="controls col-lg-8" width="">
																							<input type="text" name="<?php echo 'sc_ls_malam_nama'.$i; ?>" class="form-control required" title="Field Required" placeholder="Nama Personil Yang Tidak Hadir">
																						</div>
																					</div>
																					<div class="col-sm-12 form-group" style="">
																						<div class="controls col-lg-3" width="">
																							<div class="radio">
																								<label>
																									<input type="radio" value="1" name="<?php echo 'sc_ls_malam_keterangan'.$i; ?>" class="icheck square-blue" />
																									S
																								</label>
																							</div>
																						</div>
																						<div class="controls col-lg-3" width="">
																							<div class="radio">
																								<label>
																									<input type="radio" value="2" name="<?php echo 'sc_ls_malam_keterangan'.$i; ?>" class="icheck square-blue" />
																									I
																								</label>
																							</div>
																						</div>
																						<div class="controls col-lg-3" width="">
																							<div class="radio">
																								<label>
																									<input type="radio" value="3" name="<?php echo 'sc_ls_malam_keterangan'.$i; ?>" class="icheck square-blue" />
																									A
																								</label>
																							</div>
																						</div>
																					</div>
																					<?php } ?>

																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
															<table>
																<tr>
																	<td width="40%" valign="top">
																		<div class="col-lg-12" style="">
																			<label class="controls col-lg-12 required" for=""><b><h4>Lembur</h4></b></label>
																		</div>
																		<div class="col-sm-12 form-group" style="">
																			<div class="controls col-lg-6" width="">
																				<input type="number" name="sc_ls_lembur_jumlah" class="form-control required" title="Field Required">
																			</div>
																		</div>
																	</td>
																	<td width="60%">
																		<div class="col-lg-12" style="">
																			<label class="controls col-lg-12 required" for=""><b><h4></h4></b></label>
																		</div>
																		<div class="col-sm-12 form-group" style="">
																			<div class="controls col-lg-10" width="">
																				<textarea name="sc_ls_lembur_keterangan" class="form-control required" placeholder="Keterangan Lembur" rows="4"></textarea>
																			</div>
																		</div>
																	</td>
																</tr>
															</table>
															<div class="col-lg-12" style="">
																<br><br>
																<label class="controls col-lg-12" for=""><b><u>Kondisi Materiil</u></b></label>
															</div>
															<table>
																<tr>
																	<td width="40%" valign="top">
																		<div class="col-sm-12 form-group" style="">
																			<?php
																				for ($i=1; $i < 6; $i++) {
																			?>
																			<div class="controls col-lg-12" width="">
																				<input type="text" name="<?php echo 'sc_ls_materiil_kondisi'.$i; ?>" class="form-control required" title="Field Required" placeholder="Kondisi Materiil">
																			</div>
																			<?php } ?>
																		</div>
																	</td>
																	<td width="60%" valign="top">
																		<div class="col-sm-12 form-group" style="">
																			<div class="controls col-lg-10" width="">
																				<textarea name="sc_ls_materiil_keterangan" class="form-control required" placeholder="Keterangan Kondisi Materiil" rows="4"></textarea>
																			</div>
																		</div>
																	</td>
																</tr>
															</table>
															<div class="col-lg-12" style="">
																<br><br>
																<label class="controls col-lg-12" for=""><b><u>Aktivitas</u></b></label>
															</div>
															<table>
																<tr>
																	<td valign="top">
																		<div class="col-sm-8 form-group" style="">
																			<?php
																				for ($i=1; $i < 6; $i++) {
																			?>
																			<div class="controls col-lg-12" width="">
																				<input type="text" name="<?php echo 'sc_ls_aktivitas'.$i; ?>" class="form-control required" title="Field Required" placeholder="Aktivitas">
																			</div>
																			<?php } ?>
																		</div>
																	</td>
																</tr>
															</table>
															<div class="col-sm-12 form-group" style="">
																<br/>
																<div class="col-lg-12">
																	<div class="btn-action pull-left">
																		<button type="submit" onClick="" id="submit_btn_laporan_situasi" name="submit" data-id="<?php echo $item_area_id; ?>" onClick="" class="btn btn-primary submit_laporan_situasi">Simpan</button>
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
													<?php foreach ($items as $item){ ?>
														<div class="accordion" id="myAccordion">
															<div class="panel panel-default item-sub">
																<div class="panel-heading">
																	<h4 class="panel-title">
																		<a href="#collapse<?php echo $item['id']; ?>" data-parent="#myAccordion" data-toggle="collapse">
																			<b><?php echo $item['item_name']; ?></b>
																		</a>
																	</h4>
																</div>
																<div class="panel-collapse collapse" id="collapse<?php echo $item['id']; ?>">
																	<div class="panel-body">
																		<div class="row">
																			<!-- Kegiatan Security (Harian) -->
																			<?php if($item_area_id == 36){ ?>
																				<div class="table-responsive form_in_ll form_in_sc_kegiatan">
																					<table class="table">
																						<tbody>
																							<tr style="width:80%;">
																								<td class="col-lg-1"><b>Status (Opening)</b></td>
																								<td colspan="" class="" border="0" width="">
																									<div class="controls col-lg-2" width="">
																										<div class="radio">
																											<label style="padding-left: 0;">
																												<input type="radio" value="2" name="bc_opening_status" class="icheck square-blue" />
																												On
																											</label>
																										</div>
																									</div>
																									<div class="controls col-lg-2" width="">
																										<div class="radio">
																											<label style="padding-left: 0;">
																												<input type="radio" value="1" name="bc_opening_status" class="icheck square-blue" />
																												Off
																											</label>
																										</div>
																									</div>
																								</td>
																							</tr>
																						</tbody>
																						
																						<tbody>
																							<tr style="width:80%;">
																								<td colspan="" width="%"><b>Keterangan (Opening)</b></td>
																								<td>
																									<input type="text" name="bc_opening_keterangan" id="bc_opening_keterangan" class="form-control">
																								</td>
																							</tr>
																						</tbody>
																					</table>
																					<table class="table">
																						<tbody>
																							<tr style="width:80%;">
																								<td class="col-lg-1"><b>Status (Closing)</b></td>
																								<td colspan="" class="" border="0" width="">
																									<div class="controls col-lg-2" width="">
																										<div class="radio">
																											<label style="padding-left: 0;">
																												<input type="radio" value="2" name="bc_closing_status" class="icheck square-blue" />
																												On
																											</label>
																										</div>
																									</div>
																									<div class="controls col-lg-2" width="">
																										<div class="radio">
																											<label style="padding-left: 0;">
																												<input type="radio" value="1" name="bc_closing_status" class="icheck square-blue" />
																												Off
																											</label>
																										</div>
																									</div>
																								</td>
																							</tr>
																						</tbody>
																						
																						<tbody>
																							<tr style="width:80%;">
																								<td colspan="" width="%"><b>Keterangan (Closing)</b></td>
																								<td>
																									<input type="text" name="bc_closing_keterangan" id="bc_closing_keterangan" class="form-control">
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
																								<a href="javascript:void(0);" data-id="<?php echo $item['id']; ?>" class="ImgUpload btn btn-primary" data-style="primary"  data-toggle="tooltip" data-placement="right" title="Click to Upload Photo!"><i class="fa fa-image"></i></a>
																							</div>
																						</div>
																					</div>
																					<hr/>
																					<div class="col-lg-12">
																						<div class="row">
																							<div class="btn-action pull-right">
																								<input type="hidden" name="id" value="<?php echo $item["id"]; ?>" data-id="<?php echo $item["id"]; ?>" />
																								<button type="submit" onClick="" id="submit_btn_hk" name="submit" data-id="<?php echo $item["id"]; ?>" onClick="" class="btn btn-primary submit_checklist">Simpan</button>
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

		<!-- BODY CHECKING -->
		<script type="text/javascript">
			$(document).ready(function(){
				$("#body_checking").on("click", ".submit_checklist", function(){
					var id 			= $('#submit_btn_body_checking').attr('data-id');
					var nama	 	= $('input[name="nama"]').val();
					var jabatan	 	= $('input[name="jabatan"]').val();
					var jam_masuk	= $('input[name="jam_masuk"]').val();
					var keterangan	= $('textarea[name="keterangan"]').val();
										
					var proceed = true;				

					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id,nama,jabatan,jam_masuk,keterangan										
						};
						
						//Ajax post data to server
						$.post('action/insert_checklist_sc_body_checking.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ 
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = response.text;
							}
							$("#body_checking .success-status").hide().html(output).slideDown();
						}, 'json');
					}
				});
			});
		</script>

		<!-- KENDARAAN -->
		<script type="text/javascript">
			$(document).ready(function(){
				$("#kendaraan").on("click", ".submit_kendaraan", function(){
					var id 					= $('#submit_btn_kendaraan').attr('data-id');
					var plat_kendaraan		= $('input[name="sc_kendaraan_plat_kendaraan"]').val();
					var jenis_kendaraan		= $('input[name="sc_kendaraan_jenis_kendaraan"]').val();
					var kondisi_kendaraan	= $('input[name="sc_kendaraan_kondisi"]:checked').val();
					var keterangan			= $('textarea[name="sc_kendaraan_keterangan"]').val();
										
					var proceed = true;				

					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id,plat_kendaraan,jenis_kendaraan,kondisi_kendaraan,keterangan
						};
						
						//Ajax post data to server
						$.post('action/insert_checklist_sc_kendaraan.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ 
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = response.text;
							}
							$("#kendaraan .success-status").hide().html(output).slideDown();
						}, 'json');
					}
				});
			});
		</script>

		<!-- KEGIATAN SECURITY (HARIAN) -->
		<script type="text/javascript">
			$(document).ready(function(){
				$(".form_in_sc_kegiatan").on("click", ".submit_checklist", function(){ 
					
					var parentObj = $(this).closest('.item-sub');
					
					var id 				= parentObj.find('.submit_checklist').attr('data-id');
					var bc_opening_status 	= parentObj.find('input[name="bc_opening_status"]:checked').val();
					var bc_opening_keterangan 	= parentObj.find('input[name="bc_opening_keterangan"]').val();
					var bc_closing_status 	= parentObj.find('input[name="bc_closing_status"]:checked').val();
					var bc_closing_keterangan 	= parentObj.find('input[name="bc_closing_keterangan"]').val();
					
					var proceed = true;

					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id,bc_opening_status,bc_opening_keterangan,bc_closing_status,bc_closing_keterangan									
						};
						
						//Ajax post data to server
						$.post('action/insert_checklist_sc_kegiatan.php', post_data, function(response){ 
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

		<!-- PENGAMBILAN|PENYIMPANAN UANG DI BRANKAS - LAPORAN SITUASI -->
		<script type="text/javascript">
			$(document).ready(function(){
				$("#pengambilan_penyimpanan_laporan").on("click", ".submit_pengambilan_penyimpanan_laporan", function(){
					var id 								= $('#submit_btn_pengambilan_penyimpanan_laporan').attr('data-id');
					var sc_pengambilan_jam 				= $('input[name="sc_pengambilan_jam"]').val();
					var sc_pengambilan_diambil_oleh 	= $('input[name="sc_pengambilan_diambil_oleh"]').val();
					var sc_pengambilan_saksi1 			= $('input[name="sc_pengambilan_saksi1"]').val();
					var sc_pengambilan_saksi2 			= $('input[name="sc_pengambilan_saksi2"]').val();
					var sc_penyimpanan_jam				= $('input[name="sc_penyimpanan_jam"]').val();
					var sc_penyimpanan_diambil_oleh		= $('input[name="sc_penyimpanan_diambil_oleh"]').val();
					var sc_penyimpanan_saksi1			= $('input[name="sc_penyimpanan_saksi1"]').val();
					var sc_penyimpanan_saksi2			= $('input[name="sc_penyimpanan_saksi2"]').val();
					var sc_laporan_situasi_keterangan1	= $('input[name="sc_laporan_situasi_keterangan1"]').val();
					
					var proceed = true;

					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id,sc_pengambilan_jam,sc_pengambilan_diambil_oleh,sc_pengambilan_saksi1,sc_pengambilan_saksi2,
							sc_penyimpanan_jam,sc_penyimpanan_diambil_oleh,sc_penyimpanan_saksi1,sc_penyimpanan_saksi2,
							sc_laporan_situasi_keterangan1
						};
						
						//Ajax post data to server
						$.post('action/insert_checklist_sc_pengambilan_penyimpanan_laporan.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ 
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = response.text;
							}
							$("#pengambilan_penyimpanan_laporan .success-status").hide().html(output).slideDown();
						}, 'json');
					}
				});
			});
		</script>

		<!-- LAPORAN SITUASI -->
		<script type="text/javascript">
			$(document).ready(function(){
				$("#laporan_situasi").on("click", ".submit_laporan_situasi", function(){
					var id 							= $('#submit_btn_laporan_situasi').attr('data-id');
					var sc_ls_keadaan				= $('input[name="sc_ls_keadaan"]').val();
					
					var sc_ls_pagi_jumlah			= $('input[name="sc_ls_pagi_jumlah"]').val();
					var sc_ls_pagi_hadir			= $('input[name="sc_ls_pagi_hadir"]').val();
					var sc_ls_pagi_tidak_hadir		= $('input[name="sc_ls_pagi_tidak_hadir"]').val();
					var sc_ls_pagi_backup			= $('input[name="sc_ls_pagi_backup"]').val();
					var sc_ls_pagi_nama1			= $('input[name="sc_ls_pagi_nama1"]').val();
					var sc_ls_pagi_nama2			= $('input[name="sc_ls_pagi_nama2"]').val();
					var sc_ls_pagi_nama3			= $('input[name="sc_ls_pagi_nama3"]').val();
					var sc_ls_pagi_nama4			= $('input[name="sc_ls_pagi_nama4"]').val();
					var sc_ls_pagi_nama5			= $('input[name="sc_ls_pagi_nama5"]').val();
					var sc_ls_pagi_keterangan1		= $('input[name="sc_ls_pagi_keterangan1"]:checked').val();
					var sc_ls_pagi_keterangan3		= $('input[name="sc_ls_pagi_keterangan3"]:checked').val();
					var sc_ls_pagi_keterangan2		= $('input[name="sc_ls_pagi_keterangan2"]:checked').val();
					var sc_ls_pagi_keterangan4		= $('input[name="sc_ls_pagi_keterangan4"]:checked').val();
					var sc_ls_pagi_keterangan5		= $('input[name="sc_ls_pagi_keterangan5"]:checked').val();

					var sc_ls_siang_jumlah			= $('input[name="sc_ls_siang_jumlah"]').val();
					var sc_ls_siang_hadir			= $('input[name="sc_ls_siang_hadir"]').val();
					var sc_ls_siang_tidak_hadir		= $('input[name="sc_ls_siang_tidak_hadir"]').val();
					var sc_ls_siang_backup			= $('input[name="sc_ls_siang_backup"]').val();
					var sc_ls_siang_nama1			= $('input[name="sc_ls_siang_nama1"]').val();
					var sc_ls_siang_nama2			= $('input[name="sc_ls_siang_nama2"]').val();
					var sc_ls_siang_nama3			= $('input[name="sc_ls_siang_nama3"]').val();
					var sc_ls_siang_nama4			= $('input[name="sc_ls_siang_nama4"]').val();
					var sc_ls_siang_nama5			= $('input[name="sc_ls_siang_nama5"]').val();
					var sc_ls_siang_keterangan1		= $('input[name="sc_ls_siang_keterangan1"]:checked').val();
					var sc_ls_siang_keterangan2		= $('input[name="sc_ls_siang_keterangan2"]:checked').val();
					var sc_ls_siang_keterangan3		= $('input[name="sc_ls_siang_keterangan3"]:checked').val();
					var sc_ls_siang_keterangan4		= $('input[name="sc_ls_siang_keterangan4"]:checked').val();
					var sc_ls_siang_keterangan5		= $('input[name="sc_ls_siang_keterangan5"]:checked').val();

					var sc_ls_malam_jumlah			= $('input[name="sc_ls_malam_jumlah"]').val();
					var sc_ls_malam_hadir			= $('input[name="sc_ls_malam_hadir"]').val();
					var sc_ls_malam_tidak_hadir		= $('input[name="sc_ls_malam_tidak_hadir"]').val();
					var sc_ls_malam_backup			= $('input[name="sc_ls_malam_backup"]').val();
					var sc_ls_malam_nama1			= $('input[name="sc_ls_malam_nama1"]').val();
					var sc_ls_malam_nama2			= $('input[name="sc_ls_malam_nama2"]').val();
					var sc_ls_malam_nama3			= $('input[name="sc_ls_malam_nama3"]').val();
					var sc_ls_malam_nama4			= $('input[name="sc_ls_malam_nama4"]').val();
					var sc_ls_malam_nama5			= $('input[name="sc_ls_malam_nama5"]').val();
					var sc_ls_malam_keterangan1		= $('input[name="sc_ls_malam_keterangan1"]:checked').val();
					var sc_ls_malam_keterangan2		= $('input[name="sc_ls_malam_keterangan2"]:checked').val();
					var sc_ls_malam_keterangan3		= $('input[name="sc_ls_malam_keterangan3"]:checked').val();
					var sc_ls_malam_keterangan4		= $('input[name="sc_ls_malam_keterangan4"]:checked').val();
					var sc_ls_malam_keterangan5		= $('input[name="sc_ls_malam_keterangan5"]:checked').val();

					var sc_ls_lembur_jumlah			= $('input[name="sc_ls_lembur_jumlah"]').val();
					var sc_ls_lembur_keterangan		= $('textarea[name="sc_ls_lembur_keterangan"]').val();

					var sc_ls_materiil_kondisi1		= $('input[name="sc_ls_materiil_kondisi1"]').val();
					var sc_ls_materiil_kondisi2		= $('input[name="sc_ls_materiil_kondisi2"]').val();
					var sc_ls_materiil_kondisi3		= $('input[name="sc_ls_materiil_kondisi3"]').val();
					var sc_ls_materiil_kondisi4		= $('input[name="sc_ls_materiil_kondisi4"]').val();
					var sc_ls_materiil_kondisi5		= $('input[name="sc_ls_materiil_kondisi5"]').val();
					var sc_ls_materiil_keterangan	= $('textarea[name="sc_ls_materiil_keterangan"]').val();

					var sc_ls_aktivitas1			= $('input[name="sc_ls_aktivitas1"]').val();
					var sc_ls_aktivitas2			= $('input[name="sc_ls_aktivitas2"]').val();
					var sc_ls_aktivitas3			= $('input[name="sc_ls_aktivitas3"]').val();
					var sc_ls_aktivitas4			= $('input[name="sc_ls_aktivitas4"]').val();
					var sc_ls_aktivitas5			= $('input[name="sc_ls_aktivitas5"]').val();
										
					var proceed = true;				

					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id,sc_ls_keadaan,sc_ls_pagi_jumlah,sc_ls_pagi_hadir,sc_ls_pagi_tidak_hadir,sc_ls_pagi_backup,sc_ls_pagi_nama1,
							sc_ls_pagi_nama2,sc_ls_pagi_nama3,sc_ls_pagi_nama4,sc_ls_pagi_nama5,sc_ls_pagi_keterangan1,sc_ls_pagi_keterangan2,
							sc_ls_pagi_keterangan3,sc_ls_pagi_keterangan4,sc_ls_pagi_keterangan5,sc_ls_siang_jumlah,sc_ls_siang_hadir,
							sc_ls_siang_tidak_hadir,sc_ls_siang_backup,sc_ls_siang_nama1,sc_ls_siang_nama2,sc_ls_siang_nama3,sc_ls_siang_nama4,
							sc_ls_siang_nama5,sc_ls_siang_keterangan1,sc_ls_siang_keterangan2,sc_ls_siang_keterangan3,sc_ls_siang_keterangan4,
							sc_ls_siang_keterangan5,sc_ls_malam_jumlah,sc_ls_malam_hadir,sc_ls_malam_tidak_hadir,sc_ls_malam_backup,sc_ls_malam_nama1,
							sc_ls_malam_nama2,sc_ls_malam_nama3,sc_ls_malam_nama4,sc_ls_malam_nama5,sc_ls_malam_keterangan1,sc_ls_malam_keterangan2,
							sc_ls_malam_keterangan3,sc_ls_malam_keterangan4,sc_ls_malam_keterangan5,sc_ls_lembur_jumlah,sc_ls_lembur_keterangan,
							sc_ls_materiil_kondisi1,sc_ls_materiil_kondisi2,sc_ls_materiil_kondisi3,sc_ls_materiil_kondisi4,sc_ls_materiil_kondisi5,
							sc_ls_materiil_keterangan,sc_ls_aktivitas1,sc_ls_aktivitas2,sc_ls_aktivitas3,sc_ls_aktivitas4,sc_ls_aktivitas5
						};
						
						//Ajax post data to server
						$.post('action/insert_checklist_sc_laporan_situasi.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ 
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = response.text;
							}
							$("#laporan_situasi .success-status").hide().html(output).slideDown();
						}, 'json');
					}
				});
			});
		</script>

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