<?php
	$id_req = $_GET['id'];
	
	$request = $db->request()
				->Where("id", $id_req)
				->fetch();
	
	$users = $db->users();
					
	$approval_all = $db->request_approval();
						
	$approval = $db->request_approval()
				->Where("request_id", $id_req)
				->Order("created_at ASC");

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
							<li class="<?php echo (($_GET['act'] == 'detail') ? 'active':''); ?>"><a href="content.php?module=request&act=detail&id=<?php echo $request['id']; ?>"><strong>Detail</strong></a></li>
							<li class="<?php echo (($_GET['act'] == 'history') ? 'active':''); ?>"><a href="content.php?module=request&act=history&id=<?php echo $request['id']; ?>"><strong>History</strong></a></li>
							<li class="<?php echo (($_GET['act'] == 'message') ? 'active':''); ?>"><a href="content.php?module=request&act=message&id=<?php echo $request['id']; ?>"><strong>Message</strong></a></li>
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
									<div class="panel-body response-item">
										<ul class="timeline">
											
											<li>
												<div class="timeline-badge primary"><i class="glyphicon glyphicon-pencil"></i></div>
												<div class="timeline-panel">
													<div class="timeline-heading">
														<h4 class="timeline-title"><?php echo $request->users['first_name']; ?> - <?php echo ucwords($request->users['user_type']); ?></h4>
														<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?php echo tgl_indo($request['created_at']); ?>   <?php echo getHour($request['created_at']); ?> WIB</small></p>
													</div>
													<div class="timeline-body">
														<p><?php echo $aprv['description']; ?> </p>
													</div>
												</div>
											</li>
											
											<?php $n = 0; ?>
											<?php foreach ($approval as $aprv){ ?>
												<?php if($n % 2 == 0){ ?>
												
													<li class="timeline-inverted">
														<div class="timeline-badge <?php echo color_req_status($aprv['status']); ?>"><i class="glyphicon <?php echo icon_req_status($aprv['status']); ?>"></i></div>
														<div class="timeline-panel">
															<div class="timeline-heading">
																<h4 class="timeline-title"><?php echo $aprv->users['first_name']; ?> - <?php echo ucwords($aprv->users['user_type']); ?></h4>
																<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?php echo tgl_indo($aprv['created_at']); ?>   <?php echo getHour($aprv['created_at']); ?> WIB</small></p>
															</div>
															<div class="timeline-body">
																<p><?php echo $aprv['description']; ?> </p>
															</div>
														</div>
													</li>

												<?php }else{ ?>
											
													<li>
														<div class="timeline-badge <?php echo color_req_status($aprv['status']); ?>"><i class="glyphicon <?php echo icon_req_status($aprv['status']); ?>"></i></div>
														<div class="timeline-panel">
															<div class="timeline-heading">
																<h4 class="timeline-title"><?php echo $aprv->users['first_name']; ?> - <?php echo ucwords($aprv->users['user_type']); ?></h4>
																<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?php echo tgl_indo($aprv['created_at']); ?>   <?php echo getHour($aprv['created_at']); ?> WIB</small></p>
															</div>
															<div class="timeline-body">
																<p><?php echo $aprv['description']; ?> </p>
															</div>
														</div>
													</li>
												
												<?php } ?>
												<?php $n++; ?>
											<?php } ?>
											
											<h2>&nbsp;</h2>
											
											<?php if($request['pobtb'] != null) { ?>
												<div class="col-sm-6 col-sm-offset-3">
													<div class="panel panel-metric panel-metric-sm">
														<div class="panel-body panel-body-primary">
															<div class="metric-content metric-icon" style="min-height:auto;height: auto;">
																<div class="value" style="font-size: 22px;position:relative;padding:15px 10px;margin:0 auto;text-align:center;">
																	NO. <?php echo $request['pobtb']; ?> : <?php echo $request['nopobtb']; ?>
																</div>
															</div>
														</div>
													</div>
												</div>
											<?php } ?>
										</ul>
									</div>		
									<div class="col-sm-12 profile-details" style="margin-bottom: 20px;">
										<hr/>
										<ul class="timeline-footer">
											<li>
												<div class="timeline-footer-item">
													<div class="timeline-badge primary"><i class="glyphicon glyphicon-pencil"></i></div>
													<div class="timeline-info"><span><strong>&nbsp;&nbsp;= Created</strong></span></div>
												</div>
											</li>
											<li>
												<div class="timeline-footer-item">
													<div class="timeline-badge success"><i class="glyphicon glyphicon-ok"></i></div>
													<div class="timeline-info"><span><strong>&nbsp;&nbsp;= Approved</strong></span></div>
												</div>
											</li>
											<li>
												<div class="timeline-footer-item">
													<div class="timeline-badge warning"><i class="glyphicon glyphicon-pause"></i></div>
													<div class="timeline-info"><span><strong>&nbsp;&nbsp;= Pending</strong></span></div>
												</div>
											</li>
											<li>
												<div class="timeline-footer-item">
													<div class="timeline-badge danger"><i class="glyphicon glyphicon-remove"></i></div>
													<div class="timeline-info"><span><strong>&nbsp;&nbsp;= Rejected</strong></span></div>
												</div>
											</li>
										</ul>
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
					<h4 class="modal-title">Response For Request No. #IRS000<?php echo $request['id']; ?></h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<form method="post" action="action/request_approval.php" enctype="multipart/form-data">
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
									<input type="submit" class="btn btn-md btn-primary" value="Sumbit">
									<input type="reset" class="btn btn-md btn-danger" value="Reset">
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
						
</div>