<?php
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}else{
		if($_SESSION['user_type'] == 'staff adm' || $_SESSION['user_type'] == 'manager'){
			$request = $db->request()
						->where("branch_id", $_SESSION['branch_id'])
						->order("created_at DESC");
		}elseif($_SESSION['user_type'] == 'manager divisi'){
			$request = $db->request()
						->where("id",($db->request_approval()->select("request_id")->where("users_id", $db->users()->select("id")->where("user_type", "manager"))))
						->order("created_at DESC");
		}elseif($_SESSION['user_type'] == 'purchasing'){
			$request = $db->request()
						->where("id",($db->request_approval()->select("request_id")->where("users_id", $db->users()->select("id")->where("user_type", "manager divisi"))))
						->order("created_at DESC");
		}elseif($_SESSION['user_type'] == 'direksi'){
			$request = $db->request()
						->where("id",($db->request_approval()->select("request_id")->where("users_id", $db->users()->select("id")->where("user_type", "manager divisi"))))
						->order("created_at DESC");
		}else{
			$request = $db->request()
						->order("created_at DESC");
		}
		
		$body = 'request';
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
        <link rel="stylesheet" href="demo/css/style-timeline.css">
        <link rel="stylesheet" href="demo/css/style.css">
        <link rel="stylesheet" href="dist/assets/font-awesome/css/font-awesome.css">
		<link rel="stylesheet" href="dist/css/plugins/jquery-chosen.min.css">
        <link rel="stylesheet" href="dist/css/plugins/jquery-select2.min.css">
        <link rel="stylesheet" href="dist/css/plugins/jquery-dataTables.min.css">
        <!--[if lt IE 9]>
        <script src="dist/assets/libs/html5shiv/html5shiv.min.js"></script>
        <script src="dist/assets/libs/respond/respond.min.js"></script>
        <![endif]-->

    </head>
    <body class="">
		
		<?php include '_header.php'; ?>
		
        <div class="page-wrapper">
            <aside class="sidebar sidebar-default">
				
				<?php include('nav.php'); ?>
			
			</aside>

            <div class="page-content">
                <div class="page-subheading page-subheading-md">
					<ol class="breadcrumb">
						<li><a href="javascript:;">Dashboard</a></li>
						<li class="active"><a href="javascript:;">Request</a></li>
					</ol>
				</div>
				<div class="page-heading page-heading-md">
					<h2 class="pull-left">Request</h2>
					<!--
					<div class="col-button-colors pull-right">
						<a href="dashboard.php" class="btn btn-primary">Back</a>
					</div>
					-->
					<div class="clearfix"></div>
				</div>
				
				<?php if(@$_GET['act']=='add'){ ?>
				
					<?php include('add-request.php'); ?>
				
				<?php }elseif(@$_GET['act']=='detail'){ ?>
				
					<?php include('detail-request.php'); ?>
					
				<?php }elseif(@$_GET['act']=='history'){ ?>
				
					<?php include('history-request.php'); ?>
					
				<?php }elseif(@$_GET['act']=='message'){ ?>
				
					<?php include('message-request.php'); ?>
					
				<?php }elseif(@$_GET['act']=='print'){ ?>
				
					<?php include('print-request.php'); ?>
					
				<?php }elseif(@$_GET['act']=='edit'){ ?>
					
					<?php include('edit-request.php'); ?>
				
				<?php }else{ ?>
				
				<div class="container-fluid-md">
					<div class="panel panel-default">
					
						<div class="panel-heading">
							<div class="row">
								<div class="col-lg-12">
									<div class="col-button-colors pull-left">
										<h1 style="padding-top:10px;" class="panel-title">List All Request</h1>
									</div>
									<div class="col-button-colors pull-right">
										<?php if($_SESSION['user_type'] == 'staff adm'){ ?>
											<a href="content.php?module=request&act=add" style="margin-bottom: 0px;" class="btn btn-primary">Add New Request</a>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
						
						<div class="panel-body">
							<div class="table-responsive">

						<!--<form id="requestAddForm" action="action/request_approval_all_direksi.php" name="form-tambah-pengguna"  enctype='multipart/form-data' method="POST" class="form-horizontal form-bordered" role="form">-->
								<table data-sortable id="table-basic" class="table table-responsive table-hover table-striped">
									<thead>
										<tr>
											<th><input type="checkbox" name="select_all" value="1" id="select-all-row"></th>
											<th>No.</th>
											<th>Title</th>
											<th>IRS Number</th>
											<th>Date</th>
											
											<?php $manager 		= ($_SESSION['user_type'] != 'manager'); ?>
											<?php $staff_adm 	= ($_SESSION['user_type'] != 'staff adm'); ?>
											<?php $purchasing 	= ($_SESSION['user_type'] != 'purchasing'); ?>
											<?php $manager_div	= ($_SESSION['user_type'] != 'manager divisi'); ?>
											
											<?php if($purchasing || $manager_div){ ?>
												<th>Outlet</th>
											<?php } ?>
											
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php $n=1; ?>
									<?php foreach ($request as $req){ ?>
											<tr class="odd gradeX">
												<td><input type="checkbox" id="id_req[]" name="id_req[]" value="<?php echo $req['id']; ?>"></td>
												<td><?php echo $n; ?></td>
												<td><?php echo ucfirst($req['title']); ?></td>
												<td><a href="content.php?module=request&act=detail&id=<?php echo $req['id']; ?>"><?php echo $req['noreq']; ?></a></td>
												<td><?php echo tgl_indo($req['created_at']); ?></td>
												
												<?php if($manager_div || $purchasing || $manager_div){ ?>
													<td class="center"><?php echo $req->branch['name']; ?></td>
												<?php } ?>
												
												<td><span class="label <?php echo status_request($req['status']); ?>"><?php echo $req['status']; ?></span></td>
												<td class="btn-group btn-group-box">
													<a href="content.php?module=request&act=detail&id=<?php echo $req['id']; ?>" class="btn btn-warning">Detail</a>
													<?php if($user_type == 'administrator' || $user_type == 'manager' || $user_type == 'staff adm'){ ?>														
														<a href="content.php?module=request&act=edit&id=<?php echo $req['id']; ?>" class="btn btn-info">Edit</a>
													<?php } ?>
												</td>
											</tr>

										<?php $n++; ?>
									<?php } ?>

									</tbody>
									
								</table>
								
							<?php if($_SESSION['user_type'] == 'direksi'){ ?>
								
								<div  class="row">
									<div class="col-md-5">
										<div id="accordion" class="panel-group">
											<div class="panel panel-default">
												<h4>Approve All Item Checked</h4>
												<div class="panel-heading" style="margin-bottom: 10px; background: none;">
													<button type="button" data-toggle="collapse" data-target="#collapseOne" class="btn btn-primary" name="submit_all_approve" id="submit_all_approv">Approve All</button>																									
												</div>
												<div class="collapse" id="collapseOne">
													<select style="height:36px;" name="approved" class="form-control form-select2" data-placeholder="Choose Action...">
														<option value="">- Choose One -</option>
														<option value="Approve">Approve</option>
														<option value="Reject">Reject</option>
														<option value="Pending">Pending</option>
													</select>
													<h4 class="thin">
														<textarea name="description" rows="4" class="form-control"></textarea>
													</h4>
													<input type="button" class="btn btn-md btn-primary submit_response" data-toggle="modal" data-target="#konfirmreqapprove_all" value="Sumbit"/>
													<button type="button" class="btn btn-danger" data-toggle="collapse" data-target="#collapseOne" id="submit_all_approv">Cancel</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								
							<?php } ?>
								
								<!-- Popup for response request -->
								<div id="konfirmreqapprove_all" class="modal fade" role="dialog">
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
								
						<!--</form>-->
							
							</div>
						</div>
					</div>
				</div>
				
				<?php } ?>
				
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
        <script src="demo/js/demo.js"></script>

        <script src="dist/assets/plugins/jquery-datatables/js/jquery.dataTables.js"></script>
        <script src="dist/assets/plugins/jquery-datatables/js/dataTables.tableTools.js"></script>
        <script src="dist/assets/plugins/jquery-datatables/js/dataTables.bootstrap.js"></script>
        <script src="dist/assets/plugins/jquery-select2/select2.min.js"></script>
		<script src="dist/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
		<script src="dist/assets/plugins/jquery-chosen/chosen.jquery.min.js"></script>
		<script src="dist/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="demo/js/tables-data-tables.js"></script>
		<script src="dist/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
			$("#requestAddForm").validate();
			})
		</script>
		
		<!-- Script For Modal Image Upload -->
		<script type="text/javascript">
			$(document).on('click', '.ImgUpload', function() {
				
				$(".modalUpload").modal('show');
			});
			
			$(document).ready(function(){
				
				$(".form_in_it").on("change", ".images", function(){	
					$('.multiple_upload_form').ajaxForm({
							data: id,
							target:'#images_preview',
							success: function(response){
								
							},
							beforeSubmit:function(e){
								$('.uploading').show();
							},
							success:function(e){
								$('.uploading').hide();
							}
						}).submit();
				});
			});
			
			$(document).on('click', '.close-modal', function() {				
				$(".modalUpload").modal('hide');
				$("#images_preview").val('');
			});
		</script>
		
		<script type="text/javascript">
			
			$('input[name="password"]').val("");
			
			$(document).ready(function(){
				$("#responseRequest").on("click", ".submit_response", function(){ 
					
					$(".success-status").hide();
					
					var request_id		= $('input[name="request_id"]').val();
					var approved	 	= $('select[name="approved"]').val();
					var description		= $('textarea[name="description"]').val();
										
					var proceed = true;
					
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							request_id,approved, description										
						};
						
						//Ajax post data to server
						$.post('action/request_approval.php', post_data, function(response){ 
							if(response.type == 'error'){ 
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = response.text;
							}
							$(".success-status").hide().html(output).slideDown();
						}, 'json');
					}
				});
			});
			
			$(document).ready(function(){
				$("#responseRequest").on("click", ".close-modal", function(){
					$('input[name="password"]').val("");
					$('select[name="approved"]').val("");
					$('textarea[name="description"]').val("");
					$(".success-status").hide();
				});
			});
		</script>
		
		<script type="text/javascript">
			
			$(document).ready(function(){
				$("#responseRequest").on("click", ".openmodalconfrim", function(){ 
					$(".success-status").hide();
					$('input[name="password"]').val("");
				});
			});
			
		</script>
		
		<script type="text/javascript">
		
			$('input[name="password"]').val("");
			
			$(document).ready(function(){
				$("#konfirmreqapp").on("click", ".submit_response", function(){ 
					
					$(".success-status").hide();
					
					var password		= $('input[name="password"]').val();
					var request_id		= $('input[name="request_id"]').val();
					var approved	 	= $('select[name="approved"]').val();
					var description		= $('textarea[name="description"]').val();
					
					var proceed = true;
					
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							password,request_id,approved, description										
						};
						
						//Ajax post data to server
						$.post('action/request_approval_direksi.php', post_data, function(response){ 
							
							if(response.type == 'error'){ 
								output = '<div class="error">'+response.text+'</div>';
							}else{
								output = response.text;
							}
							
							$(".success-status").hide().html(output).slideDown();
							
						}, 'json');
						
						$('#konfirmreqapp').modal('hide');
					}
				});
			});
			
			$(document).ready(function(){
				$("#responseRequest").on("click", ".close-modal", function(){
					$('input[name="request_id"]').val("");
					$('select[name="approved"]').val("");
					$('textarea[name="description"]').val("");
					$(".success-status").hide();
				});
			});
		</script>
		
		<script type="text/javascript">
		
			$('input[name="pobtb"]').val("");
			
			$(document).ready(function(){
				$("#responseRequestPcs").on("click", ".submit_response", function(){ 
					
					$(".success-status").hide();
					
					var nopobtb		= $('input[name="nopobtb"]').val();
					var request_id	= $('input[name="request_id"]').val();
					var pobtb	 	= $('select[name="pobtb"]').val();
					var description	= $('textarea[name="descriptionpcs"]').val();
					var proceed = true;
					
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							nopobtb,request_id,pobtb,description										
						};
						
						//Ajax post data to server
						$.post('action/request_pobtb_purchasing.php', post_data, function(response){ 
							
							if(response.type == 'error'){ 
								output = '<div class="error">'+response.text+'</div>';
							}else{
								output = response.text;
							}
							
							$(".success-status").hide().html(output).slideDown();
							
						}, 'json');
						
						//$('#responseRequestPcs').modal('hide');
					}
				});
			});
			
			$(document).ready(function(){
				$("#responseRequestPcs").on("click", ".close-modal", function(){
					$('input[name="request_id"]').val("");
					$('input[name="nopobtb"]').val("");
					$('select[name="pobtb"]').val("");
					$('textarea[name="descriptionpcs"]').val("");
					$(".success-status").hide();
				});
			});
			
		</script>
		
		<script type="text/javascript">
		
			$('input[name="nobtb"]').val("");
			
			$(document).ready(function(){
				$("#responseRequestStaff").on("click", ".submit_response", function(){ 
					
					$(".success-status").hide();
					
					var nobtb		= $('input[name="nobtb"]').val();
					var btbdate		= $('input[name="btbdate"]').val();
					var request_id	= $('input[name="request_id"]').val();
					var description	= $('textarea[name="descriptionstaff"]').val();
					var proceed = true;
					
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							btbdate,nobtb,request_id,description										
						};
						
						//Ajax post data to server
						$.post('action/request_btb_confirm.php', post_data, function(response){ 
							
							if(response.type == 'error'){ 
								output = '<div class="error">'+response.text+'</div>';
							}else{
								output = response.text;
							}
							
							$(".success-status").hide().html(output).slideDown();
							
						}, 'json');
						
						//$('#responseRequestPcs').modal('hide');
					}

				});
			});
			
			$(document).ready(function(){
				$("#responseRequestStaff").on("click", ".close-modal", function(){
					$('input[name="request_id"]').val("");
					$('input[name="nobtb"]').val("");
					$('input[name="btbdate"]').val("");
					$('textarea[name="descriptionstaff"]').val("");
					$(".success-status").hide();
				});
			});
			
		</script>
		<script type="text/javascript">
			
			$(document).ready(function(){
				$("#sentBtn").click(function(){ 
					
					$(".success-status").hide();
					
					var nopobtb		= $('input[name="nopobtb"]').val();
					var request_id	= $('input[name="request_id"]').val();
					var no_kendara	= $('input[name="no_kendara"]').val();
					var sent_by		= $('input[name="sent_by"]').val();
					var no_supplier	= $('input[name="no_supplier"]').val();
					var pobtb	 	= $('select[name="pobtb"]').val();
					var description	= $('textarea[name="descriptionpcs"]').val();
					var proceed = true;
					
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							nopobtb,request_id,pobtb,description										
						};
						
						//Ajax post data to server
						$.post('action/request_pobtb_purchasing.php', post_data, function(response){ 
							
							if(response.type == 'error'){ 
								output = '<div class="error">'+response.text+'</div>';
							}else{
								output = response.text;
							}
							
							$(".success-status").hide().html(output).slideDown();
							
						}, 'json');
						
						//$('#responseRequestPcs').modal('hide');
					}
				});
			});
			
			$(document).ready(function(){
				$("#responseRequestPcs").on("click", ".close-modal", function(){
					$('input[name="request_id"]').val("");
					$('input[name="nopobtb"]').val("");
					$('select[name="pobtb"]').val("");
					$('textarea[name="description"]').val("");
					$(".success-status").hide();
				});
			});
			
			$(document).ready(function(){
				$("#responseRequestStaff").on("click", ".close-modal", function(){
					$('input[name="request_id"]').val("");
					$('input[name="nobtb"]').val("");
					$('input[name="no_kendara"]').val("");
					$('input[name="no_supplier"]').val("");
					$('input[name="sent_by"]').val("");
					$('input[name="btbdate"]').val("");
					$('textarea[name="descriptionstaff"]').val("");
					$(".success-status").hide();
				});
			});
			
		</script>
		
		<script type="text/javascript">
			var TableData;
			
			TableData = storeTblValues()
			
			TableData = JSON.stringify(TableData);
			
			function storeTblValues(){
				
				var TableData = new Array();
				
				$('#table-basic tr').each(function(row, tr){
					TableData[row]={
						"id_req" : $(tr).find('input[type=checkbox]:checked').val()
					}    
				}); 
				
				TableData.shift();  // first row will be empty - so remove
				return TableData;
			
			}
		
			$(document).ready(function(){
				$("#konfirmreqapprove_all").on("click", ".submit_response", function(){ 
					
					$(".success-status").hide();
		
					var TableData;
					TableData = JSON.stringify(storeTblValues());
					
					console.log(TableData);
					
					var password	= $('input[name="password"]').val();
					var approved	= $('select[name="approved"]').val();
					var description	= $('textarea[name="description"]').val();
					
					$.ajax({
						type: "POST",
						url: "action/request_approval_all_direksi.php",
						data: {pTableData : TableData, password : password, approved : approved, description : description},
						success: function(response){
							$(".success-status-dir").hide().html(response).slideDown();
						}
					});
					
					/*
					var proceed = true;
					
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							password,id_req,approved, description										
						};
						
						//Ajax post data to server
						$.post('action/request_approval_all_direksi.php', post_data, function(response){ 
							
							if(response.type == 'error'){ 
								output = '<div class="error">'+response.text+'</div>';
							}else{
								output = response.text;
							}
							
							$(".success-status").hide().html(output).slideDown();
							
						}, 'json');
						
						$('#konfirmreqapprove_all').modal('hide');
					}
					*/
				});
			});
			
			$(document).ready(function(){
				$("#konfirmreqapprove_all").on("click", ".close-modal", function(){
					$('input[name="password"]').val("");
					$('select[name="approved"]').val("");
					$('textarea[name="description"]').val("");
					$(".success-status").hide();
					$(".collapse").removeClass("in");
					$(".success-status-dir").hide();
				});
			});
		</script>
		
    </body>
</html>

<?php } ?>