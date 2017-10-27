<?php 
	if (!empty(@$_GET['page'])){
		$page = @$_GET['page'];
	}else{
		$page= 'aktivasi-evoucher';
	};
	
	include 'alert/alert.php';
    
    $id_voucher = $_GET['id'];
	$voucher = $db->voucher()
        ->where("id", $id_voucher)
        ->fetch();
?>

<div class="container-fluid-md">
	<div class="row">
		<div class="col-lg-11">
			
			<ul class="nav nav-pills">
				<li class="<?php echo $page == 'aktivasi-evoucher' ? 'active' : ''; ?>"><a data-toggle="" href="content.php?module=evoucher&act=aktivasi&id=<?php echo $id_voucher; ?>"><strong>AKTIVASI EVOUCHER</strong></a></li>
				<li class="<?php echo $page == 'history-aktivasi' ? 'active' : ''; ?>"><a data-toggle="" href="content.php?module=evoucher&act=aktivasi&page=history-aktivasi"><strong>HISTORY AKTIVASI</strong></a></li>
                <li class="pull-right"><a href="content.php?module=evoucher" class="btn btn-primary "><i class="fa fa-mail-reply"></i> List eVoucher</a></li>
			</ul>
			
			<?php if($page=="aktivasi-evoucher"){ ?>				
				<div class="tab-content panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-button-colors pull-left">
                                    <h1 style="padding-top:10px;" class="panel-title">Detail Aktivasi & Generate Voucher</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default" style="background-color: #f9f9f9;">
                                    
                                    <div id="detail-info-voucher">
                                         <?php 
                                            generateVoucher($voucher['barcode']);
                                            
                                        ?>
                                        <div class="panel-body">
                                            <div class="col-md-5 col-sm-5 text-center pull-right">
                                                <img alt="image" class="img img-responsive img-thumbnail img-profile" src="<?php echo getVoucherJpg($voucher['barcode']); ?>" style="width: 100%;" />
                                            </div>
                                            <div class="col-sm-7 profile-details">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-sm-12">
                                                                <h4>KODE BARCODE</h4>
                                                                <h2><?php echo $voucher['barcode']; ?></h2>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <?php /*
                                                            <label class="control-label col-sm-12">
                                                                <h4>KODE BARCODE</h4>
                                                                <h2><?php echo $voucher['barcode']; ?></h2>
                                                            </label>
                                                            */ ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-sm-12">
                                                                <h4>NILAI POINT</h4>
                                                                <h2><?php echo $voucher['nominal']; ?></h2>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-sm-12">
                                                                <h4>OUTLET</h4>
                                                                <h2><?php echo ($voucher['branch_id']=='0' ? 'All Outlet' : $voucher->branch['name']); ?></h2>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-sm-12">
                                                                <h4>STATUS</h4>
                                                                <?php if($voucher['status']=='ACTIVE'){ ?>
                                                                    <h2><label class="label label-success"><?php echo $voucher['status']; ?></label></h2>
                                                                <?php }elseif($voucher['status']=='NON ACTIVE'){ ?>
                                                                    <h2><label class="label label-info"><?php echo $voucher['status']; ?></label></h2>
                                                                <?php }elseif($voucher['status']=='TERPAKAI'){ ?>
                                                                    <h2><label class="label label-danger"><?php echo $voucher['status']; ?></label></h2>
                                                                <?php }elseif($voucher['status']=='EXPIRE'){ ?>
                                                                    <h2><label class="label label-warning"><?php echo $voucher['status']; ?></label></h2>
                                                                <?php } ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>																	
                                        
                                        <?php if($voucher['status']=='NON ACTIVE'){ ?>
                                        
                                            <div class="panel-body">

                                                <form id="AddVoucherInput" action="action/proses_aktivasi_evoucher.php" method="POST" role="form" class="">

                                                    <input type="hidden" value="<?php echo $voucher['id']; ?>" name="voucher_id" class="form-control required" />
                                                    <input type="hidden" value="<?php echo $voucher['barcode']; ?>" name="barcode" class="form-control required" />

                                                    <input type="hidden" value="<?php echo $voucher['branch_id']; ?>" name="branch_id" class="form-control required" />

                                                    <fieldset>
                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <div class="alert alert-info">
                                                                    <strong>Masukkan Data Customer</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row input-voucher text-center">
                                                                    <div class="col-md-6" style="margin-bottom: 10px;">
                                                                        <input type="text" name="customer_name" class="input-lg form-control required" title="Customer Name" placeholder="Customer Name">
                                                                    </div>
                                                                    <div class="col-md-6 no-padding">
                                                                        <input type="email" name="customer_email" class="input-lg form-control required" title="Email Address" placeholder="Email Address">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="row text-center">
                                                                    <div class="col-md-12">
                                                                        <button type="submit" title="Aktivasi" class="input-lg btn btn-lg btn-danger form-control"><strong>Aktivasi</strong></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </form>
                                            </div>
                                        <?php } ?>
                                        
                                        <?php if($voucher['status']=='ACTIVE'){ ?>
                                            
                                            <div class="panel-body">                                                
                                                <a href="//110.50.85.26:82/checklist/assets/generate_voucher/<?php echo str_replace(' ', '', $voucher['barcode']); ?>.jpg" title="Download eVoucher" class="btn btn-primary" download><strong><i class="fa fa-download"></i> eVoucher</strong></a>
                                               <?php /* <a href="//110.50.85.26:82/checklist/assets/generate_voucher/<?php echo str_replace(' ', '', $voucher['barcode']); ?>.jpg" title="Download eVoucher" class="btn btn-primary" download><strong><i class="fa fa-download"></i> eVoucher</strong></a>*/ ?>
                                            </div>
                                        
                                        <?php } ?>
                                    </div>

                                </div>	
                            </div>
                        </div>
                    </div>
                </div>
			<?php } ?>
						
			<?php if($page=="history-aktivasi"){ ?>				
				<div class="tab-content panel panel-default">
					<div class="panel-heading">
						<div class="row">
							<div class="col-lg-12">
								<div class="col-button-colors pull-left">
									<h1 style="padding-top:10px;" class="panel-title">History Transaksi Voucher</h1>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default" style="background-color: #f9f9f9;">
									
									<div class="panel-body">
										<div class="table-responsive">

											<table data-sortable id="list_history_voucher" class="table table-responsive table-hover table-striped" width="100%">
												<thead>
													<tr>
														<th><input type="checkbox" name="select_all" value="1" id="select-all-row"></th>
														<th>No.</th>
														<th>Kode Voucher</th>
														<th>Nominal Point</th>														
														<th>Customer</th>
														<th>Jam</th>
														<th>Tanggal</th>
														<th>Outlet</th>
														<th>Kasir</th>
													</tr>
												</thead>
												<tbody>
												<?php $n=1; ?>
												<?php foreach ($voucher as $vc){ ?>
													<tr class="odd gradeX">
														<td><input type="checkbox" id="id_req[]" name="id_req[]" value="<?php echo $vc['id']; ?>"></td>
														<td><?php echo $n; ?></td>
														<td><?php echo strtoupper($vc->voucher['code']); ?></td>
														<td><?php echo number_format($vc->voucher['nominal'],0,",","."); ?></td>
														<td><?php echo strtoupper($vc['customer_name']); ?></td>
														<td><?php echo strtoupper(getHour($vc['created_at'])); ?></td>
														<td><?php echo strtoupper(tgl_indo($vc['created_at'])); ?></td>
														<?php if($vc['branch_id'] == 0){ ?>
															<td><?php echo ucwords('All Aoutlet'); ?></td>
														<?php }else {?>
															<td><?php echo ucwords($vc->branch['name']); ?></td>
														<?php } ?>
														<td><?php echo ucwords($vc->users['first_name']); ?></td>
													</tr>

													<?php $n++; ?>
												<?php } ?>

												</tbody>
												
											</table>
										
										</div>
									</div>
								
								</div>	
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
						
			<?php if($page=="info-voucher"){ ?>				
								
				<?php 
					$key = strtoupper($_POST['key_input']);
					
					$voucher = $db->voucher()
								->where("code LIKE '$key'")
								->or("barcode LIKE '$key'")
								->fetch();
					$data_v_penj = $db->voucher_penjualan()
											->where("voucher_id", $voucher['id']);
											
					$v_penjualan = $db->voucher_penjualan()
											->where("voucher_id", $voucher['id'])
											->fetch();
								
					$data_voucher = $db->voucher()
								->where("code LIKE '$key'")
								->or("barcode LIKE '$key'");
					
					if(count($data_voucher) < 1){
						echo "<button id='btnShowAlert' style='display:none;'></button>
							<script type='text/javascript'>
								sweetAlert({
									title: 'Error!',
									text: 'Kode Voucher Tidak Ditemukan!',
									type: 'error'
								},
								function () {
									window.location.href = 'content.php?module=voucher&act=transaksi&page=new-transaction';
								});
							</script>";
						exit();
					}
				?>

			<div class="tab-content panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-button-colors pull-left">
								<h1 style="padding-top:10px;" class="panel-title">Detail Informasi Voucher</h1>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default" style="background-color: #f9f9f9;">
								
								<?php if(@$_POST){ ?> 
	
								<div id="detail-info-voucher">
									
									<div class="panel-body">
										<div class="col-md-3 col-sm-3 text-center">
											<?php if($voucher['voucher_type']=='ELEKTRIK'): ?>
												<img alt="image" class="img img-profile" src="assets/img/evoucher-icon.png" style="width: 100%;" />
											<?php else: ?>	
												<img alt="image" class="img img-profile" src="assets/img/voucher-icon.png" style="width: 100%;" />
											<?php endif; ?>
										</div>
										<div class="col-sm-9 profile-details">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="control-label col-sm-12">
															<h4>KODE BARCODE</h4>
															<h2><?php echo $voucher['barcode']; ?></h2>
														</label>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<?php /*
														<label class="control-label col-sm-12">
															<h4>KODE BARCODE</h4>
															<h2><?php echo $voucher['barcode']; ?></h2>
														</label>
														*/ ?>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="control-label col-sm-12">
															<h4>NILAI POINT</h4>
															<h2><?php echo $voucher['nominal']; ?></h2>
														</label>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="control-label col-sm-12">
															<h4>EXPIRE DATE</h4>
															<h2><?php echo ($voucher['expire_date']==null) ? '-': tgl_indo($voucher['expire_date']); ?></h2>
														</label>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="control-label col-sm-12">
															<h4>OUTLET</h4>
															<h2><?php echo ($voucher['branch_id']=='0' ? 'All Outlet' : $voucher->branch['name']); ?></h2>
														</label>
													</div>
												</div>
												<?php if(count($data_v_penj)>0){ ?>
													<div class="col-sm-6">
														<div class="form-group">
															<label class="control-label col-sm-12">
																<h4>OUTLET PEMBELIAN VOUCHER</h4>
																<h2><?php echo (count($data_v_penj)>0 ? ($v_penjualan['branch_id']==0 ? 'Kantor Pusat' : $v_penjualan->branch['name']) : '-'); ?></h2>
															</label>
														</div>
													</div>
												<?php } ?>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="control-label col-sm-12">
															<h4>STATUS</h4>
															<?php if($voucher['status']=='ACTIVE'){ ?>
																<h2><label class="label label-success"><?php echo $voucher['status']; ?></label></h2>
															<?php }elseif($voucher['status']=='NON ACTIVE'){ ?>
																<h2><label class="label label-info"><?php echo $voucher['status']; ?></label></h2>
															<?php }elseif($voucher['status']=='TERPAKAI'){ ?>
																<h2><label class="label label-danger"><?php echo $voucher['status']; ?></label></h2>
															<?php }elseif($voucher['status']=='EXPIRE'){ ?>
																<h2><label class="label label-warning"><?php echo $voucher['status']; ?></label></h2>
															<?php } ?>
														</label>
													</div>
												</div>
											</div>
										</div>
									</div>																	
									
									<?php if($voucher['status']=='ACTIVE' && $voucher['branch_id']=='0'){ ?>
									
										<div class="panel-body">
										
											<form id="AddVoucherInput" action="action/proses_voucher.php" method="POST" role="form" class="">
												
												<input type="hidden" value="<?php echo $voucher['id']; ?>" name="voucher_id" class="form-control required" />
												<input type="hidden" value="<?php echo $voucher['voucher_type']; ?>" name="voucher_type"/>
												<input type="hidden" value="<?php echo $voucher['barcode']; ?>" name="barcode"/>
												<input type="hidden" value="<?php echo $voucher['nominal']; ?>" name="nominal"/>
												<input type="hidden" value="<?php echo $voucher['branch_id']; ?>" name="branch_id" class="form-control required" />
												
												<fieldset>
													<div class="form-group row">
														<div class="col-md-4">
															<div class="row input-voucher text-center">
																<div class="col-md-12">
																	<input type="text" name="customer_name" class="input-lg form-control required" title="Insert Customer Name" placeholder="Insert Customer Name">
																</div>
															</div>
														</div>
														<div class="col-md-3">
															<div class="row">
																<div class="col-md-12">
																	<div class="row">
																		<button type="submit" class="btn btn-lg btn-primary">GUNAKAN VOUCHER</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</fieldset>
											</form>
											
										</div>
									
									<?php }elseif($voucher['status']=='ACTIVE' && $voucher['branch_id']==$_SESSION['branch_id']){ ?>
									
										<div class="panel-body">
										
											<form id="AddVoucherInput" action="action/proses_voucher.php" method="POST" role="form" class="">
												
												<input type="hidden" value="<?php echo $voucher['id']; ?>" name="voucher_id" class="form-control required" />
												
												<input type="hidden" value="<?php echo $voucher['branch_id']; ?>" name="branch_id" class="form-control required" />
												
												<fieldset>
													<div class="form-group row">
														<div class="col-md-4">
															<div class="row input-voucher text-center">
																<div class="col-md-12">
																	<input type="text" name="customer_name" class="input-lg form-control required" title="Insert Customer Name" placeholder="Insert Customer Name">
																</div>
															</div>
														</div>
														<div class="col-md-3">
															<div class="row text-center">
																<div class="col-md-12" style="padding-left: 0;">
																	<button type="submit" class="btn btn-lg btn-primary form-control">GUNAKAN VOUCHER</button>
																</div>
															</div>
														</div>
													</div>
												</fieldset>
											</form>
											
										</div>
									
									<?php }else{ ?>
									
										<div class="panel-body">
											
											<fieldset>
												<div class="form-group row">
													<div class="col-md-12">
														<div class="row input-voucher text-left">
															<div class="col-md-12">
																<h1 class="btn btn-lg btn-danger">Voucher Tidak Dapat Digunakan!</h1>
															</div>
														</div>
													</div>
												</div>
											</fieldset>
											
										</div>
									
									<?php } ?>
									
								</div>
								
							<?php } ?>
								
							</div>	
						</div>
					</div>
				</div>
			</div>
			
			<?php } ?>
			
			<?php if($page=="print-transaction"){ ?>				
								
			<?php } ?>
			
		</div>
	</div>
</div>
