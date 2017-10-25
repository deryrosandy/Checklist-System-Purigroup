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
	<div class="form-horizontal form-bordered" role="form">
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
										<div class="row">
											<div class="col-lg-12" style="">
												<label class="controls col-lg-12" for=""><b>&nbsp;</b></label>
												<hr/>
											</div>
											
											<?php 
												$message = $db->message_request()
															->where("request_id", $request['id']);
											?>
											
											<div class="col-lg-11 comment_area" style="">													
												<?php foreach ($message as $msg){ ?>
														<div class="col-lg-12">
															<span class="mail-date pull-right">
																<?php echo tgl_indo_short($msg["created"]); ?>
															</span>
															<h4 class="text-primary"><?php echo $msg->users['first_name']; ?>  :</h4>
															<blockquote>
																<p><?php echo $msg['description']; ?></p>
															</blockquote>
														</div>
												<?php } ?>
											</div>
											<div class="col-sm-11 form-group" style="">
												<div class="controls col-lg-12" width="">
													<textarea style="resize: vertical;" name="message-description" id="" class="form-control" rows="3" placeholder="Enter Message"></textarea>
												</div>
											</div>
											<div class="col-sm-12 form-group" style="">	
												<div class="controls col-lg-8" width="">
													<button data-id="<?php echo $request['id']; ?>"  class="btn btn-primary btn_submit_comments">Submit</button>
												</div>
											</div>
										</div>
																			
									</div>		
									<div class="col-sm-12 profile-details" style="margin-bottom: 20px;">
										<hr/>
									</div>						
								</div>						
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>
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
									<input type="submit" id="sentBtn" class="btn btn-md btn-primary" value="Sumbit">
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