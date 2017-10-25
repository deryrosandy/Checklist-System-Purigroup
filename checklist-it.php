<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
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
			->where("divisi_id", 1)
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
        <link rel="stylesheet" href="dist/assets/plugins/dropzone/dropzone.css">
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
						<li class=""><a href="javascript:;">Checklist IT</a></li>
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
								<li <?php if($body == 'lihat_checklist'){echo 'active';}?>><a href="lihat-checklist-it.php"><strong>Lihat Checklist</a></strong></li>
							</ul>
							<div class="tab-content">
								<div class="panel panel-info">
									<div class="panel-heading">
										<h3 class="panel-title">Input Checklist</h3>
									</div>
								</div>
								<div class="widget-content">
									<div class="data-table-toolbar">
										<div class="row">
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-6">
														<!--
														<form role="form">
														<input type="text" class="form-control" placeholder="Search...">
														</form>
														-->
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="row">
													
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-12 content-area">
										<div class="row">
											<div class="col-sm-2">
												<ul class="list-group nav nav-pills nav-stacked">
													<br/>
													<div class="panel-warning">
														<div class="panel-heading">
															<h3 class="panel-title"><center><b>AREA</center></b></h3>
														</div>
													</div>
													<?php
													$no = 1;
													$active;
													foreach ($allarea as $area){
													?>
													<li class="list-group-item <?php echo ($no==1) ? 'active':''; ?>" style="padding: 0;">
														<a data-toggle="tab" href="#tabarea-<?php echo $area['id']; ?>" style="font-size: 14px;font-weight:600">
															<?php echo strtoupper($area["name"]); ?>
														</a>
													</li>
													<?php
														$no++;
													}
													?>
												</ul>
											</div>
											<div class="col-sm-10">
												<div class="tab-content">
												<?php
													$notab = 1;
													foreach ($allarea as $area){
													
														$item_area_id = $area['id'];
														$items = $db->item()
															->where("item_area_id", $item_area_id);
												?>
													<div id="tabarea-<?php echo $area['id']; ?>" class="tab-pane <?php echo ($notab==1) ? 'active':''; ?>">
														<div class="table-responsive">
															<table data-sortable class="table table-responsive table-hover table-striped" id="form-confirm">
																<thead>
																	<tr>
																		<th rowspan='2'>No</th>
																		<th style="width:200px;">NAMA</th>
																		<th>STATUS</th>
																		<th>KETERANGAN</th>
																		<th style="width:30px;">PHOTO</th>
																		<th style="width:30px;">ACTION</th>
																	</tr>
																</thead>
																
																<tbody>
																	<?php
																	$no=1;
																	foreach ($items as $item){
																	?>
																		<!--<form action="action/insert_checklist.php" method="POST" role="form" class="">-->
																		
																			<tr class="item-sub">
																				<td><?php echo $no; ?></td>
																				<td><?php echo ucwords($item['item_name']); ?></td>
																				<td>
																					<!--<input name="onoffswitch" value="1" class="boot-switch" type="checkbox" data="1" checked="checked" data-on-color="primary" data-off-color="danger">-->
																					<div class="btn-group btn-toggle" data-toggle="buttons">
																						<label class="btn-status btn btn-primary active">
																						  <input type="radio" name="status" value="1"> Bagus
																						</label>
																						<label class="btn-status btn btn-primary">
																						  <input type="radio" name="status" value="2"> Rusak
																						</label>
																					</div>
																				</td>
																				<td><input style="width: 100%;" type="text" name="keterangan" /></td>
																				<td style="text-align:center;">
																					<a href="javascript:void(0);" data-id="<?php echo $item['id']; ?>" class="ImgUpload btn btn-info" data-style="primary"  data-toggle="tooltip" data-placement="bottom" title="Click to Upload Photo!">
																						<i class="fa fa-image"></i>
																					</a>
																				</td>
																				<td style="text-align:center;">
																					<a href="javascript:void(0);" data-id="<?php echo $item['id']; ?>" class="SubmitChecklist btn btn-md btn-warning" data-style="primary"  data-toggle="tooltip" data-placement="bottom" title="Save Data">
																						Submit
																					</a>
																				</td>
																				<?php 
																					$data = $item['id'];
																					//var_dump ($data);
																				?>
																					<input type="hidden" name="id[]" value="<?php echo $item['id']; ?>"/>
																					<td class="form_in_it">
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
																					</td>
																			</tr>
																			<?php
																			$no++;
																			}
																			?>
																		<!--</form>-->
																</tbody>
															</table>
															<div class="col-md-12">
																<div class="row">
																	<div class="col-lg-12">
																		<div class="row">
																			<div class="col-lg-12 success-status">
																				
																			</div>
																		</div>
																	</div>
																	<?php /*
																	<div class="col-md-12">
																		<div class="row pull-left">
																		</div>
																		<div class="btn-action pull-right">
																			<button type="submit" name="submit" class="btn btn-primary">Simpan</button>
																			<!--<a class="btn btn-primary btn-sm">Simpan</a>-->
																			<br/>
																			<br/>
																		</div>
																	</div>
																	*/ ?>
																</div>
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
		<script src="dist/assets/plugins/dropzone/dropzone.js"></script>
		<!-- Script For Modal Image Upload -->
		<script type="text/javascript">
			$(document).on('click', '.ImgUpload', function() {
				
				var parentObj = $(this).closest('.item-sub');
				
				$(parentObj.find(".modalUpload")).modal('show');
			});
			
			$(document).ready(function(){
				
				$(".form_in_it").on("change", ".images", function(){ 
				
				var parentObj = $(this).closest('.item-sub');
				
				var id = parentObj.find('.id_item').val();
				
				var targetid = parentObj.find("#images_preview"+id);	
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
							 console.log ('dor');
						}
					}).submit();
				});
			});
			
			$(document).on('click', '.close-modal', function() {
				var parentObj = $(this).closest('.item-sub');
				var id = parentObj.find('.id_item').val();
				
				$(parentObj.find(".modalUpload")).modal('hide');
				$("#images_preview"+id).val('');
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on("click", ".SubmitChecklist", function(){ 
					
					var parentObj = $(this).closest('.item-sub');
					
					var id 				= parentObj.find('.SubmitChecklist').attr('data-id');
					var status			= parentObj.find('.active > input[name="status"]').val();
					var keterangan		= parentObj.find('input[name="keterangan"]').val();
	
					var proceed = true;
					var statusresult = $(".success-status").hide();
					
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id,status,keterangan
						};
						//Ajax post data to server
						$.post('action/insert_checklist_it.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ //load json data from server and output message     
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = '<div class="success">'+response.text+'</div>';
							}
							
							$(statusresult).html(output).slideDown();
							//parentObj.find(".success-status").hide().html(output).slideDown();
							
						}, 'json');
					}
				});
			});
		</script>
    </body>
</html>
<?php } ?>