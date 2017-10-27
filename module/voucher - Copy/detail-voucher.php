<?php
	$id_req = $_GET['id'];
	
	$request = $db->request()
				->Where("id", $id_req)
				->fetch();
				
	define ('PATH', realpath(dirname('upload/')));
?>

<div class="container-fluid-md">
	<form id="requestAddForm" action="action/update_request.php" name="form-tambah-pengguna" method="POST" class="form-horizontal form-bordered" role="form">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-button-colors pull-left">
							<h1 style="padding-top:10px;" class="panel-title">Detail Request</h1>
						</div>
					</div>
				</div>
			</div>
			
			<div class="container-fluid-md">
				<div class="row">
					<div class="col-md-7 col-lg-8">
						<br/>
						<ul class="request-nav nav nav-tabs nav-dark">
							<li disabled><a href="javascript:void(0);" class="text-no-decoration">#<?php echo $request['noreq']; ?></a></li>
							<li class="<?php echo (($_GET['act'] == 'detail') ? 'active':''); ?>"><a href="#tab1-1"><strong>Detail</strong></a></li>
							<li class="<?php echo (($_GET['act'] == 'history') ? 'active':''); ?>"><a href="content.php?module=request&act=history&id=<?php echo $request['id']; ?>"><strong>History</strong></a></li>
							<li class="<?php echo (($_GET['act'] == 'message') ? 'active':''); ?>"><a href="content.php?module=request&act=message&id=<?php echo $request['id']; ?>"><strong>Message</strong></a></li>
							<?php /* <li class="pull-right"><a href="report/print-request.php?id=<?php echo $request['id']; ?>" target="_blank"><strong><i class="fa fa-print">  Print PDF</i></strong></a></li> */ ?>
						</ul>
						<div class="request-content tab-content">
							<div class="tab-pane tab-pane-table active">
								<div class="panel-profile-details">
									<div class="panel-body">
										<div class="row">
											<div class="col-sm-6 profile-details">
												<h4 class="semi-bold"><?php echo $request['title']; ?></h4>
												<p>Pengirim : <?php echo $request->users['first_name']; ?> - <?php echo $request->branch['name']; ?></p>
												<p>Dikirim Pada : <?php echo tgl_indo($request['created_at']); ?></p>
											</div>
											<div class="col-sm-6">
												<h3 class="pull-right">No. #<?php echo $request['noreq']; ?></h3>
											</div>
										</div>
									</div>
									<div class="panel-body">
										<div class="row">
											<div class="col-sm-5">
												<dl>
													<dt>Unit</dt>
													<dd><?php echo $request['unit']; ?></dd>
												</dl>
												<dl class="margin-sm-bottom">
													<dt>Kebutuhan</dt>
													<dd><?php echo $request['kebutuhan']; ?></dd>
												</dl>
												<dl class="margin-sm-bottom">
													<dt>Divisi</dt>
													<dd><?php echo $request->divisi['name']; ?></dd>
												</dl>
												<dl class="margin-sm-bottom">
													<dt>Tanggal Dibutuhkan</dt>
													<dd><?php echo tgl_indo($request['due_date']); ?></dd>
												</dl>
											</div>
											<div class="col-sm-7">
												<dl>
													<dt>Saldo Gudang</dt>
													<dd><?php echo $request['saldo_gudang']; ?></dd>
												</dl>
												<dl class="margin-sm-bottom">
													<dt>Puchase Request</dt>
													<dd><?php echo $request['purchase_request']; ?></dd>
												</dl>
												<dl class="margin-sm-bottom">
													<dt>Outlet</dt>
													<dd><?php echo $request->branch['name']; ?></dd>
												</dl>
											</div>
											<div class="col-sm-12">
												<dl class="margin-sm-bottom">
													<dt>Remark / Description </dt>
												</dl>
												<dl class="mail-body well">
													<p><?php echo $request['remark']; ?></p>
												</dl>
											</div>
											
											<div class="col-sm-12">
												<dl class="margin-sm-bottom">
													<dt>Photo </dt>
												</dl>
												<dl class="col-sm-12">
													
													<?php $targetDir = "/"; ?>
													<?php if ($request['photo'] != null){ ?>
														<a href="<?php echo $request['photo']; ?>" target="_blank">
															<img class="img img-responsive pull-left" width="200" src="<?php echo $request['photo']; ?>"/>
														</a>
													<?php }else{ ?>
														<p>-</p>
													<?php } ?>
												</dl>
											</div>
											
											<div class="col-sm-12">
												<dl class="margin-sm-bottom">
													<dt>Attachment </dt>
												</dl>
												<dl class="col-sm-12">
													
													<?php $targetDir = "/"; ?>
													<?php if ($request['attachment'] != null){ ?>
														<a href="<?php echo $request['attachment']; ?>" target="_blank">
															<img class="img img-responsive pull-left" width="200" src="<?php echo $request['attachment']; ?>"/>
														</a>
													<?php }else{ ?>
														<p>-</p>
													<?php } ?>
												</dl>
											</div>
											<div class="col-sm-5">
												<dl>
													<dt>Status</dt>
													<dd class="label <?php echo status_request($request['status']); ?>"><?php echo $request['status']; ?></dd>
												</dl>
											</div>
											<div class="col-sm-12">
												<hr/>
													<?php if($user_type == 'staff adm'){ ?>
														<div class="">
														<?php 
																
																$aprove_purchasing = $db->request_approval()
																					->where("request_id",$request['id'])
																					->where("users_id", ($db->users()->select("id")->where("user_type", "purchasing")))
																					->order("created_at DESC");
																
																?>
																<?php
																$request_btb = $db->request_received()
																					->where("request_id",$request['id'])
																					->where("users_id", ($db->users()->select("id")->where("user_type", "staff adm")))
																					->order("created_at DESC");
																$received = $request_btb->fetch();
																
																?>
																<?php if ((count($request_btb) < 1) && (count($aprove_purchasing) > 0)){ ?>
																	<button type="button" class="btn btn-md btn-danger" data-id="<?php echo $request['id']; ?>" data-toggle="modal" data-target="#responseRequestStaff">Request Confirmation</button>
																<?php } ?>
														</div>
													<?php } ?>
													
													<?php if($user_type != 'staff adm'){ ?>
														<div class="pull-left">
														<?php if($user_type == 'purchasing'){ ?>
															<?php 
																
																$aprove_purchasing = $db->request_approval()
																					->where("request_id",$request['id'])
																					->where("users_id", ($db->users()->select("id")->where("user_type", "purchasing")))
																					->order("created_at DESC");																
																?>
																<?php
																$aprove_dirut = $db->request_approval()
																					->where("request_id",$request['id'])
																					->where("users_id", ($db->users()->select("id")->where("user_type", "direksi")))
																					->order("created_at DESC");
																					?>
																<?php if ((count($aprove_purchasing) < 1) && (count($aprove_dirut) > 0)){ ?>
																	<button type="button" class="btn btn-md btn-danger" data-id="<?php echo $request['id']; ?>" data-toggle="modal" data-target="#responseRequestPcs">Response This Request</button>																	
																<?php } ?>
																
														<?php }elseif($user_type == 'manager'){ ?>
															<?php $aprove_manager = $db->request_approval()
																				->where("request_id",$request['id'])
																				->where("users_id", ($db->users()->select("id")->where("user_type", "manager")))
																				->order("created_at DESC");																
																?>
																<?php if(count($aprove_manager) == null){ ?>
																	<button type="button" class="btn btn-md btn-danger" data-id="<?php echo $request['id']; ?>" data-toggle="modal" data-target="#responseRequest">Response This Request</button>
															<?php } ?>
														<?php }elseif($user_type == 'manager divisi'){ ?>
															<?php $aprove_manager_div = $db->request_approval()
																				->where("request_id",$request['id'])
																				->where("users_id", ($db->users()->select("id")->where("user_type", "manager divisi")))
																				->order("created_at DESC");																
																?>
																<?php if(count($aprove_manager_div) == null){ ?>
																	<button type="button" class="btn btn-md btn-danger" data-id="<?php echo $request['id']; ?>" data-toggle="modal" data-target="#responseRequest">Response This Request</button>
															<?php } ?>
														<?php }elseif($user_type == 'direksi'){ ?>
															<?php $aprove_direksi = $db->request_approval()
																				->where("request_id",$request['id'])
																				->where("users_id", ($db->users()->select("id")->where("user_type", "direksi")))
																				->order("created_at DESC");																
																?>
																<?php if(count($aprove_direksi) == null){ ?>
																	<button type="button" class="btn btn-md btn-danger" data-id="<?php echo $request['id']; ?>" data-toggle="modal" data-target="#responseRequest">Response This Request</button>
															<?php } ?>
														<?php } ?>
														
														</div>
													<?php } ?>
													
													<?php
														$request_btb = $db->request_received()
																			->where("request_id",$request['id'])
																			->where("users_id", ($db->users()->select("id")->where("user_type", "staff adm")))
																			->order("created_at DESC");
														$received = $request_btb->fetch();
													?>
													
													<?php if(count($request_btb) > 0){ ?>
													
														<div class="col-sm-6">
															<dl class="margin-sm-bottom float-left">
																<dt>Received At :</dt>
																<h3 class="border-o"><?php echo tgl_indo($received['date_received']); ?></h3>
															</dl>
														</div>
														<div class="col-md-6">
															<dl class="margin-sm-bottom float-right">
																<dt>BTB Number :</dt>
																<h3 class="border-o"><?php echo $received['btb_number']; ?></h3>
															</dl>
														</div>
														
													<?php } ?>
													
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
	</form>
	<!-- Popup for response request -->
	<div id="responseRequest" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Response For Request No. #<?php echo $request['noreq']; ?></h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Action</label>
								<div class="row">
									<div class="col-md-4">
										<select style="height:36px;" name="approved" class="form-control form-select2" data-placeholder="Choose Action...">
											<option value="">- Choose One -</option>
											<option value="Approve">Approve</option>
											<option value="Reject">Reject</option>
											<option value="Pending">Pending</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Description</label>
								<textarea name="description" rows="3" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
								
								<?php if($user_type != 'direksi'){ ?>
									<input type="submit" class="submit_response btn btn-md btn-primary" value="Sumbit">
								<?php } ?>
								
								<?php if($user_type == 'direksi'){ ?>
									<input type="submit" class="btn btn-md btn-primary openmodalconfrim" data-toggle="modal" data-target="#konfirmreqapp" value="Sumbit"/>
								<?php } ?>
								
								<button type="button" class="close-modal btn btn-danger" data-dismiss="modal">Cancel</button>
								
							</div>
							<div class="success-status"></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="close-modal btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Popup for response request -->
	<div id="responseRequestPcs" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Response For Request No. #<?php echo $request['noreq']; ?></h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Action</label>
								<div class="row">
									<div class="col-md-4">
										<select style="height:36px;" name="pobtb" class="form-control form-select2" data-placeholder="Choose Action...">
											<option value="">- Choose One -</option>
											<option value="PO">Purchase Order</option>
											<option value="BTB">BTB</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>No. PO / BTB</label>
								<input name="nopobtb" type="text" class="form-control" />
							</div>
							<div class="form-group">
								<label>Description</label>
								<textarea name="descriptionpcs" rows="3" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<input type="submit" class="submit_response btn btn-md btn-primary" value="Sumbit">
								<input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
								<button type="button" class="close-modal btn btn-danger" data-dismiss="modal">Cancel</button>
							</div>
							<div class="success-status"></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="close-modal btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Popup for response request Staff Adm-->
	<div id="responseRequestStaff" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Request No. #<?php echo $request['noreq']; ?></h4>
					<h5 class="modal-title">Insert BTB number if the request has received</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>BTB Number</label>
								<?php $btb_number 	= 'BTB' . strtoupper($user->branch['code']) . date('y') . date('m') . nobtb(); ?>
								<label readonly class="form-control"><?php echo $btb_number; ?></label>
								<input type="hidden" readonly value="<?php echo $btb_number; ?>" name="nobtb" class="form-control" >
							</div>
							<div class="form-group">
								<label>No. Pol / Kendaraan (Optional)</label>
								<input type="text" name="no_kendara" placeholder="Insert No. Pol / Kendaraan" class="form-control required" title="Field Required"/>
							</div>
							<div class="form-group">
								<label>No. Surat Jlan Supplier (Optional)</label>
								<input type="text" name="no_supplier" placeholder="Insert No. Surat Jalan" class="form-control required" title="Field Required"/>
							</div>
							<div class="form-group">
								<label>Received from</label>
								<input type="text" name="sent_by" placeholder="Insert Sender" class="form-control required" title="Field Required"/>
							</div>
							<div class="form-group">
								<label>Date</label>
								<input type="text" name="btbdate" placeholder="Insert Date" class="form-control required" title="Field Required"  data-rel="datepicker"/>
							</div>
							<div class="form-group">
								<label>Description</label>
								<textarea name="descriptionstaff" placeholder="Insert Description" rows="3" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<input type="submit" class="submit_response btn btn-md btn-primary" value="Sumbit">
								<input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
								<button type="button" class="close-modal btn btn-danger" data-dismiss="modal">Cancel</button>
							</div>
							<div class="success-status"></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="close-modal btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Popup for response request -->
	<div id="konfirmreqapp" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Insert Password to Confirm</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Password</label>
								<input name="password" type="password" class="form-control" />
							</div>
							<div class="form-group">
								<input type="submit" class="submit_response btn btn-md btn-primary" value="Sumbit">
							</div>
							<div class="success-status-dir"></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="close-modal btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
						
</div>