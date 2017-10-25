<?php
	session_start();
	
	if (empty($_SESSION['username']) AND empty($_SESSION[password])){
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
		
		$dt = new DateTime();
		$today = $dt->format('Y-m-d');
		
		$body = 'checklist';
		
		$active = 'lihat_checklist';
													
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
		<link rel="stylesheet" href="dist/css/plugins/ekko-lightbox.min.css">
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
							<?php if ($user['user_type'] != 'manager'){ ?>
								<li class=""><a href="checklist-it.php"><strong>Input Checklist</a></strong></li>
							<?php } ?>
								<li class="<?php if($active == 'lihat_checklist'){echo 'active';}?>" ><a href="javascript:void(0);"><strong>Lihat Checklist</a></strong></li>
							</ul>
							<div class="tab-content">
								<div class="panel panel-info">
									<div class="panel-heading">
										<h3 class="panel-title">Data Checklist IT</h3>
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
														//var_dump ($item_area_id);
														//$items = $db->item()
															//->where("item_area_id", $item_area_id);
														/*
														$checklist = $db->item_checklist();
														
														foreach ($checklist as $itemc) {
															echo "<tr>";
															echo "<td>" . $book["title"] . "</td>";
															echo "<td>" . $book["author"] . "</td>";
															// book_category table joins book and category
															$categories = array();
															foreach ($itemc->item_id() as $itemck){
																$categories[] = $itemck->item_area["name"];
															}
															echo "<td>" . join(", ", $itemck) . "</td>";
															echo "</tr>";
														}
														*/
												?>
													<div id="tabarea-<?php echo $area['id']; ?>" class="tab-pane <?php echo ($notab==1) ? 'active':''; ?>" style="font-size: 14px;font-weight:600">
														<div class="table-responsive">
															<table data-sortable class="form_approve table table-hover table-striped">
																<thead>
																	<tr>
																		<th style="">No</th>
																		<th style="">NAMA</th>
																		<th style="">KONDISI</th>
																		<th style="">STATUS</th>
																		<th style="">PHOTO</th>
																		<th style="">KETERANGAN</th>
																		<?php if ($user['user_type'] == 'manager'){ ?>
																		<th style="width: 100px;">ACTION</th>
																		<th style="width: 0;"></th>
																		<?php } ?>
																	</tr>
																</thead>
																
																<tbody>
																	<?php
																	$no=1;
																		
																		$area_id = $area['id'];
																		$branch_id = $branch['id'];
																		
																		
																		$items = $db->item()
																			->where("item_area_id", $area_id);
																			//->where("branch_id", $branch['id']);
																																				
																		$itm = array();
																		
																		foreach($items as $item){
																			$i = $item['id'];
																			$itm[] = $i;
																		}
																		
																		//var_dump ($itm);
																		$datenow =  date('d/m/y');
																		
																		//echo '<h2>' . $branch_id . '</h2>';
																		
																		$date = strtotime($datenow);
																				
																		$sql = "SELECT a.id, a.item_id, a.item_status_id, a.item_id, a.description, a.status_approve, b.item_area_id, b.item_name
																				FROM item_checklist a
																				INNER JOIN item b
																				ON a.Item_id = b.id
																				WHERE DATE(a.checked_at) = CURDATE() 
																						AND b.item_area_id='$area_id' AND a.branch_id='$branch_id'
																				ORDER BY a.id";
																		
																		$con = mysqli_connect("localhost","root","ilovejkt48","checklist_system_db");
																		
																		$data = mysqli_query($con,$sql);
																		//var_dump($sql);
																		
																		if(mysqli_num_rows($data) > 0){
																		
																		//while($checklist = $data->fetch_object()){
																		while($checklist = mysqli_fetch_assoc($data)){
																		
																		//var_dump ($checklist['id']);
																			
																	?>
																	<form action="action/confirm_checklist.php" method="POST" role="form">
																																		
																		<tr id="<?php echo $checklist['id']; ?>" class="edit_checklist view_checklist">
																			<td><?php echo $no; ?></td>
																			<td><?php echo ucwords($checklist['item_name']); ?></td>
																			<td>
																				<!--<input name="onoffswitch" value="1" class="boot-switch" type="checkbox" data="1" checked="checked" data-on-color="primary" data-off-color="danger">-->
																				<div class="btn-group btn-toggle" data-toggle="buttons">
																					<?php /*
																					<label class="btn-status btn btn-primary active">
																					  <input type="radio" checked name="status[<?php echo $item['id']; ?>]" value="1"> Bagus
																					</label>
																					*/ ?>
																					<?php if ($user['user_type'] == 'manager'){ ?>
																						<label class="label <?php echo ($checklist['item_status_id']==1) ? 'label-success':'label-warning'; ?>">
																							<?php echo ($checklist['item_status_id'] == 1) ? 'Bagus':'Rusak'; ?>
																						</label>
																						<?php /*
																						<select name="confirm_status" id="confirm_status<?php echo $checklist["id"]; ?>" class="form-control form-select2" title="">
																							<option <?php echo ($checklist['item_status_id'] == 1) ? 'selected' : ''; ?> value="1">Bagus</option>
																							<option <?php echo ($checklist['item_status_id'] == 2) ? 'selected' : ''; ?> value="2">Rusak</option>
																						</select>
																						*/ ?>
																					<?php }else{ ?>
																						<label class="label <?php echo ($checklist['item_status_id']==1) ? 'label-success':'label-warning'; ?>">
																							<?php echo ($checklist['item_status_id'] == 1) ? 'Bagus':'Rusak'; ?>
																						</label>
																					<?php } ?>
																				</div>
																			</td>
																			
																			<?php if($checklist['status_approve'] == 1){ ?>
																				<td><label class="label label-info label-md">Approved</label></td>
																			<?php }else{ ?>
																				<td><label class="label label-danger label-md">Not Yet</label></td>
																			<?php } ?>
																			<td style="text-align:center;">
																				<a href="javascript:void(0);" data-id="<?php echo $checklist['id']; ?>" class="viewImg btn btn-info" data-style="primary"  data-toggle="tooltip" data-placement="bottom" title="Click to View Photo!">
																					<i class="fa fa-image"></i>
																				</a>
																			</td>
																			<td><?php echo ucwords($checklist['description']); ?></td>
																				<input type="hidden" data-val="<?php echo $checklist['id']; ?>" class="idchecklist" name="id[]" value="<?php echo $checklist['id']; ?>"/>
																			<?php if ($user['user_type'] == 'manager'){ ?>
																			<!--<td><span data-id="<?php echo $checklist['id']; ?>" onClick="saveConfirm('edit',<?php //echo $checklist['id']; ?>)" class="btncek btn btn-primary">Confirm</span></td>-->
																			<td><span data-id="<?php echo $checklist['id']; ?>" onClick="" class="btncek btn btn-primary">Approve</span>
																			<span data-id="<?php echo $checklist['id']; ?>" onClick="" class="success-status"></span></td>
																			<?php } ?>
																			
																			<td width="0px" class="form_in_it">
																				<div id="" class="modalView modal fade in" data-backdrop="static">
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
																										<div class="panel panel-info">
																											<div class="panel-heading">
																												<h3 class="panel-title">Photo Checklist IT</h3>
																											</div>
																										</div>
																										<div class="gallery" id="images_preview<?php echo $item['id']; ?>" style="margin-top:20px;">
																											<?php
																												$item_images = $db->item_image()
																													->where("item_id", $checklist['item_id'])
																													->where("CONVERT(created, date)", $today);
																												
																												if(count($item_images) > 0){
																													foreach($item_images as $image){ ?>
																														<a href="<?php echo '/checklist/' . $image['image_source']; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="col-sm-4" style="margintop: 15px; margin-bottom:15px;">
																															<img src="<?php echo '/checklist/' . $image['image_source']; ?>" class="img-responsive">
																														</a>
																													<?php } ?>
																												<?php }else{ ?>
																												<div class="col-lg-12">
																													<label class="label label-warning">- Photo Belum Tersedia</label>
																												</div>
																											<?php } ?>
																										</div>
																									</div>
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
																			<td></td>
																		</tr>
																		<?php
																		$no++;
																		}
																		?>
																		<?php if ($user['user_type'] != 'operator' && $user['user_type'] != 'administrator'){ ?>
																			<div class="col-md-12">
																				<div class="row">
																					<div class="col-md-12">
																						<div class="row pull-left">
																							<h3>Data Checklist Hari Ini</h3>
																						</div>
																						<div class="btn-action pull-right">
																							<button type="submit" name="submit" class="btn btn-primary">Approve All</button>
																							<br/>
																							<br/>
																							<!--<a class="btn btn-primary btn-sm">Simpan</a>-->
																						</div>
																						<br/>
																						<br/>
																						<br/>
																					</div>	
																				</div>
																			</div>
																		<?php }else{ ?>
																			<div class="col-md-12">
																				<div class="row">
																					<div class="col-md-12">
																						<div class="row pull-left">
																							<h3>Data Checklist Hari Ini</h3>
																						</div>
																						<div class="btn-action pull-right">
																						<br/>
																						<br/>
																						</div>
																						<br/>
																						<br/>
																						<br/>
																					</div>	
																				</div>
																			</div>
																		<?php } ?>
																	</form>
																	<?php }else{ ?>
																		
																	<form action="action/confirm_checklist.php" method="POST" role="form">
																		<tr>
																			<td colspan="7" style="text-align: center; background-color: #eff3f4;">Belum ada data hari ini yang masuk</td>
																		</tr>
																	</form>
																	<?php } ?>
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
		<script src="dist/js/ekko-lightbox.min.js"></script>
		<script src="demo/js/tables-data-tables.js"></script>
		
		<script type="text/javascript">
			function saveConfirm(id){
				$(".edit_checklist .btncek").click(function(){
					var id= $(id).val();
					var kondisi=$("#confirm_status<?php echo $checklist["id"]; ?>"+id).val();
					var dataString = 'id='+ id +'&status='+kondisi;
					console.log('dor');
				
					$.ajax({
					type: "POST",
						url: "action/single_confirm_checklist.php",
						data: dataString,
						cache: false,
						dataType: 'json',
						success: function(data){
							
							}
						});
				});
			};
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".form_approve").on("click", ".btncek", function(){ 
					
					var parentObj = $(this).closest('.edit_checklist');
					
					var id 				= parentObj.find('.btncek').attr('data-id');
					var status			= parentObj.find('select[name="confirm_status"]').val();
					/*var 
					fungsi 			= parentObj.find('select[name="fungsi"]').val();
					var keterangan	 	= parentObj.find('label[name="keterangan"]').val();
					*/			
					var proceed = true;
					
					if(proceed){
						//get input field values data to be sent to server
						post_data = {
							id,status
						};
						//Ajax post data to server
						$.post('action/confirm_checklist_it.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ //load json data from server and output message     
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
								output = '<h2 class="success alert-block alert-success btn btn-sm">'+response.text+'<button data-dismiss="alert" style="color: #000;margin-top: -10px;margin-right: -7px;font-size: 25px;" class="close" type="button">×</button></h2>';
							}
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
			$(document).on('click', '.viewImg', function() {
				
				var parentObj = $(this).closest('.view_checklist');
				
				$(parentObj.find(".modalView")).modal('show');
			});
			
			$(document).on('click', '.close-modal', function() {
				var parentObj = $(this).closest('.view_checklist');
				var id = parentObj.find('.id_item').val();
				
				$(".modalView").modal('hide');
				$("#images_preview"+id).val('');
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
		<script src="demo/js/demo.js"></script>
			
    </body>
</html>
<?php } ?>