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
			->where("branch_id", $branch['id'])
			->where("divisi_id", 1)
			->order('name DESC');
		
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
        <title>Checklist System &middot; </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="shortcut icon" href="assets/img/favicon.ico">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="stylesheet" href="dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="dist/css/veneto-admin.min.css">
        <link rel="stylesheet" href="demo/css/style.css">
        <link rel="stylesheet" href="demo/css/style-responsive.css">
        <link rel="stylesheet" href="dist/assets/font-awesome/css/font-awesome.css">
		<link rel="stylesheet" href="dist/css/plugins/bootstrap-switch.min.css">

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
								<div class="col-md-12 transparent">
									<h3>Input Checklist</h3>
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
											<div class="col-sm-3">
												<ul class="nav nav-pills nav-stacked">
													<?php
													$no = 1;
													$active;
													foreach ($allarea as $area){
													?>
													<li class="<?php echo ($no==1) ? 'active':''; ?>"><a data-toggle="tab" href="#tabarea-<?php echo $area['id']; ?>"><?php echo strtoupper($area["name"]); ?></a></li>
													<?php
														$no++;
													}
													?>
												</ul>
											</div>
											<div class="col-sm-9">
												<div class="tab-content">
												<?php
													$notab = 1;
													foreach ($allarea as $area){
													
														$item_area_id = $area['id'];
														//var_dump ($item_area_id);
														$items = $db->item()
															->where("item_area_id", $item_area_id);
														//var_dump ($item_area_id);
														//die();
												?>
													<div id="tabarea-<?php echo $area['id']; ?>" class="tab-pane <?php echo ($notab==1) ? 'active':''; ?>">
														<div class="table-responsive">
															<table data-sortable class="table table-hover table-striped" id="form-confirm">
																<thead>
																	<tr>
																		<th rowspan='2'>No</th>
																		<th style="width:200px;">NAMA</th>
																		<th>STATUS</th>
																		<th>KETERANGAN</th>
																		<th style="width:30px;">PHOTO</th>
																	</tr>
																</thead>
																
																<tbody>
																	<?php
																	$no=1;
																	foreach ($items as $item){
																	?>
																	<form action="action/insert_checklist.php" method="POST" role="form">
																	
																		<tr class="item-sub">
																			<td><?php echo $no; ?></td>
																			<td><?php echo ucwords($item['item_name']); ?></td>
																			<td>
																				<!--<input name="onoffswitch" value="1" class="boot-switch" type="checkbox" data="1" checked="checked" data-on-color="primary" data-off-color="danger">-->
																				<div class="btn-group btn-toggle" data-toggle="buttons">
																					<label class="btn-status btn btn-primary active">
																					  <input type="radio" checked name="status[<?php echo $item['id']; ?>]" value="1"> Bagus
																					</label>
																					<label class="btn-status btn btn-primary">
																					  <input type="radio" name="status[<?php echo $item['id']; ?>]" value="2"> Rusak
																					</label>
																				</div>
																			</td>
																			<td><input style="width: 100%;" type="text" name="keterangan[]" /></td>
																			<td style="text-align:center;">
																				<a href="javascript:void(0);" data-id="<?php echo $item['id']; ?>" class="ImgUpload btn btn-primary" data-style="primary"  data-toggle="tooltip" data-placement="bottom" title="Click to Upload Photo!">
																					<i class="fa fa-image"></i>
																				</a>
																			</td>
																			<?php 
																				$data = $item['id'];
																				//var_dump ($data);
																			?>
																			<input type="hidden" name="id[]" value="<?php echo $item['id']; ?>"/>
																		</tr>
																		<?php
																		$no++;
																		}
																		?>
																		<div class="col-md-12">
																			<div class="row">
																				<div class="col-md-12">
																					<div class="row pull-left">
																						<h3>Input Checklist Hari Ini</h3>
																					</div>
																					<div class="btn-action pull-right">
																						<button type="submit" name="submit" class="btn btn-primary">Simpan</button>
																						<!--<a class="btn btn-primary btn-sm">Simpan</a>-->
																						<br/>
																						<br/>
																					</div>
																				</div>
																			</div>
																		</div>
																		
																	</form>
																</tbody>
															</table>
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
		
			<div id="modalUpload" class="modal fade in" data-backdrop="static">
				<div class="modal-dialog">
					<div id="" class="modal-content">
						<div class="modal-body">
							<div class="modal-title">
								<ul class="nav nav-pills" id="ImgTab">
									<li class="active">
										<button type="submit" id="btnImg" class="btn btn-success btnImg">
											<i class="fa fa-plus"></i>Add Image
										</button>
									</li>
								</ul>
							</div>
							<div class="col-lg-5">
								<!-- The global file processing state -->
								<span class="fileupload-process">
								  <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
									  <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
								  </div>
								</span>
							</div>
							<div id='content' class="tab-content">
								<div id="uploadContainer">
									<form action="" method="post" enctype="multipart/form-data">
										<div class="tab-pane" id="preview">
											<div id="template" class="file-row col-lg-12">
												<!-- This is used as the file preview template -->
												<div class="" style="float:left;">
													<span class="preview"><img style="padding: 10px 0;" data-dz-thumbnail /></span>
												</div>
												
												<div class="preview-area col-lg-4">
													<p class="size" data-dz-size></p>
													<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
														<div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
													</div>
												</div>
												<div class="preview-area">
													<button class="btn btn-primary start">
														<i class="glyphicon glyphicon-upload"></i>
														<span>Start</span>
													</button>
													<button data-dz-remove class="btn btn-warning cancel">
														<i class="glyphicon glyphicon-ban-circle"></i>
														<span>Cancel</span>
													</button>
													<button data-dz-remove class="btn btn-danger delete">
														<i class="glyphicon glyphicon-trash"></i>
														<span>Delete</span>
													</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary close-modal">Done</button>
						</div>
					</div>
				</div>
			</div>
		
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
        <script src="dist/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
		<script src="demo/js/tables-data-tables.js"></script>
		<script src="demo/js/demo.js"></script>
		<script src="dist/assets/plugins/dropzone/dropzone.js"></script>
		<!-- Script For Modal Image Upload -->
		<script type="text/javascript">
			$(document).on('click', '.ImgUpload', function() {
				$("#modalUpload").modal('show');
			});
				
			var previewNode = document.querySelector("#preview");
			
			previewNode.id = "";
			
			var previewTemplate = previewNode.parentNode.innerHTML;
				previewNode.parentNode.removeChild(previewNode);
			
			var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
				url: "action/upload_images.php", // Set the url
				thumbnailWidth: 100,
				thumbnailHeight: 100,
				parallelUploads: 20,
				previewTemplate: previewTemplate,
				autoQueue: false, // Make sure the files aren't queued until manually added
				previewsContainer: "#uploadContainer", // Define the container to display the previews
				clickable: "#btnImg" // Define the element that should be used as click trigger to select files.
			});
			
			myDropzone.on("addedfile", function(file) {
			  // Hookup the start button
				file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
			});
			
			// Update the total progress bar
			myDropzone.on("totaluploadprogress", function(progress) {
				document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
			});
			
			myDropzone.on("sending", function(file) {
			  // Show the total progress bar when upload starts
			  document.querySelector("#total-progress").style.opacity = "1";
			  // And disable the start button
			  file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
			});
			
			// Hide the total progress bar when nothing's uploading anymore
			myDropzone.on("queuecomplete", function(progress) {
				document.querySelector("#total-progress").style.opacity = "0";
			});
			/*
			// Setup the buttons for all transfers
			// The "add files" button doesn't need to be setup because the config
			// `clickable` has already been specified.
			document.querySelector(".start").onclick = function() {
				myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
			};
			document.querySelector(".cancel").onclick = function() {
				myDropzone.removeAllFiles(true);
			};
			*/
			/*
			myDropzone.on("complete", function(file) {
				myDropzone.removeFile(file);
			});
			*/
			$(document).on('click', '.close-modal', function() {
				$("#modalUpload").modal('hide');
				
				myDropzone.removeAllFiles(true);
				
			});
			
		</script>
    </body>
</html>
<?php } ?>