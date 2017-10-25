<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}else{
		include 'core/init.php';
		include 'core/helper/myHelper.php';
		
		$branch = $db->branch()
			->where("id", $_SESSION['branch_id'])->fetch();
		
		$divisi = $db->divisi()
			->where("id", $_SESSION['divisi_id'])->fetch();
		
		$allarea = $db->item_area()
			//->where("branch_id", $branch['id'])
			->where("divisi_id", 3)
			->order('id ASC');
		
		$body = 'checklist';
		
		$user = $db->users()
				->where("id", $_SESSION['id'])->fetch();
		
		$dt = new DateTime();
		$today = $dt->format('Y-m-d');
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
						<li class=""><a href="javascript:void(0);">Checklist HK</a></li>
						<li class="active"><a href="javascript:;">-</a></li>
					</ol>
				</div>
				<div class="page-heading page-heading-md">
				<?php if ($divisi != '0'){ ?>
					<h4 style="padding: 10px 0;" class="pull-left">Divisi : <?php echo ucwords($divisi["name"]); ?></h4>
				<?php } ?>
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
									<li <?php if($body == 'lihat_checklist'){echo 'active';}?>><a href="checklist-hk.php"><strong>Input Checklist</a></strong></li>
								<?php } ?>
								<li class="active"><a href="javascript:void(0);"><strong>Lihat Checklist</a></strong></li>
							</ul>
							<div class="tab-content content-area">
								<div class="panel panel-info">
									<div class="panel-heading">
										<h3 class="panel-title">Data Checklist House Keeping</h3>
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
											<li class="<?php echo ($no==1) ? 'active':''; ?>"><a data-toggle="tab" href="#tabarea-<?php echo $area['id']; ?>"><?php echo strtoupper($area["name"]); ?></a></li>
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
													<h3 class="panel-title">Equipment & Task</h3>
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
													
													<?php $no = 1; ?>
													
													<?php foreach ($items as $item){ ?>
													
													<?php
														$all_item_checklist = $db->item_checklist()
															->where("item_id", $item['id'])
															->where("branch_id", $branch['id'])
															->where("CONVERT(checked_at, date)", $today);
														
														$item_checklist = $db->item_checklist()
															->where("item_id", $item['id'])
															->where("branch_id", $branch['id'])
															->where("CONVERT(checked_at, date)", $today)
															->fetch();
														
														//echo count($all_item_checklist);
														
														$count_checklist = count($all_item_checklist);
														
														$status 	=  	($count_checklist > 0 ? $item_checklist['item_status_id'] : '');
														$kondisi 	=  	($count_checklist > 0 ? $item_checklist['item_kondisi_id'] : '');
														$fungsi		= 	($count_checklist > 0 ? $item_checklist->item_fungsi['name'] : '');
														$keterangan =   ($count_checklist > 0 ? $item_checklist['description'] : '');
														
													?>
													
														<div class="panel panel-default item-sub">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a href="#collapse<?php echo $item['id']; ?>" data-parent="#accordion" data-toggle="collapse">
																		<b><?php echo $item['item_name']; ?></b>
																	</a>
																</h4>
															</div>
															<div class="panel-collapse collapse" id="collapse<?php echo $item['id']; ?>" style="height: 0px;">
																<div class="panel-body">
																	<div class="row">
																	
																	<?php if($count_checklist > 0 ){ ?>
																	
																		<?php if ($user['user_type'] != 'operator'){ ?>
																		
																			<div id="" class="table-responsive form_approve">
																				<table class="table table-striped">
																					<thead>
																						<tr class="panel-heading">
																							<th>Status</th>
																							<th>Kondisi</th>
																							<th>Fungsi</th>
																							<th>Keterangan</th>
																							<?php if($user['user_type'] == 'leader'){ ?>
																								<th>Status</th>
																							<?php }else{ ?>
																								<th>Action</th>
																							<?php } ?>
																						</tr>
																					</thead>
																					<tbody>
																						<tr class="odd gradeX">
																							<td>
																								<?php echo ucfirst($item_checklist->item_status['name']); ?>
																							</td>
																							<td>
																								<?php echo ucfirst($item_checklist->item_kondisi['name']); ?>
																							</td>
																							
																							<td class="center">
																								<?php echo ucwords($item_checklist->item_fungsi['name']); ?>
																							</td>
																							<td>
																								<label name="keterangan"><?php echo $keterangan; ?></label>
																							</td>
																							<td class="btn-group btn_confirm">
																								<?php if($user['user_type'] == 'leader'){ ?>
																									<?php if($item_checklist['status_approve'] == '0'){ ?>
																										<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-danger">Not Yet</label>
																										<?php }else{ ?>
																											<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-warning">Confirm</label>
																										<?php } ?>
																									<?php }else{ ?>
																										<?php $sts_confirm = (($item_checklist['status_approve'] == 0 OR $item_checklist['status_approve'] == NULL) ? 'btn-warning' : 'btn-success'); ?>
																										<a id="" href="javascript:void(0);" data-id="<?php echo $item_checklist['id']; ?>" class="btn <?php echo $sts_confirm; ?> submit_confirm">Confirm</a>
																								<?php } ?>
																							</td>
																						</tr>
																					</tbody>
																				</table>
																				
																				<?php 
																				
																					$all_comments = $db->comments()
																								->where("item_checklist_id", $item_checklist['id']);
																				?>
																				
																				<div class="row">
																					<div class="col-lg-12" style="">
																						<label class="controls col-lg-12" for=""><b>Photo</b></label>
																						<hr/>
																					</div>
																					<div class="col-lg-12">
																					<?php
																						$item_images = $db->item_image()
																							->where("item_id", $item['id'])
																							->where("CONVERT(created, date)", $today);
																							
																						//var_dump ($item['id']);
																						if(count($item_images) > 0){
																							foreach($item_images as $image){ ?>
																								<a href="<?php echo '/checklist/' . $image['image_source']; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="col-sm-4" style="margintop: 15px; margin-bottom:15px;">
																									<img src="<?php echo '/checklist/' . $image['image_source']; ?>" class="img-responsive">
																								</a>
																							<?php } ?>
																						<?php }else{ ?>
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
																				
																				<div class="row">
																					<div class="col-lg-12" style="">
																						<label class="controls col-lg-12" for=""><b>Catatan / Koreksi</b></label>
																						<hr/>
																					</div>
																					
																					<div class="col-lg-11 comment_area" style="">													
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
																							<button data-id="<?php echo $item_checklist['id']; ?>"  class="btn btn-primary btn_submit_comments">Submit</button>
																						</div>
																					</div>
																				</div>
																			</div>
																			
																			<?php }else{ ?>
																			
																				<div id="" class="table-responsive form_approve">
																				<table style="margin-bottom: 0;" class="table table-striped">
																					<thead>
																						<tr class="panel-heading">
																							<th>Status</th>
																							<th>Kondisi</th>
																							<th>Fungsi</th>
																							<th>Keterangan</th>
																							<th>Status</th>
																						</tr>
																					</thead>
																					<tbody>
																						<tr class="odd gradeX">
																							<td>
																								<?php echo ucfirst($item_checklist->item_status['name']); ?>
																							</td>
																							<td>
																								<?php echo ucfirst($item_checklist->item_kondisi['name']); ?>
																							</td>
																							
																							<td class="center">
																								<?php echo ucwords($item_checklist->item_fungsi['name']); ?>
																							</td>
																							<td>
																								<label name="keterangan"><?php echo $keterangan; ?></label>
																							</td>
																							<td class="btn-group">
																								<?php if($item_checklist['status_approve'] == '0'){ ?>
																									<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-danger">Not Yet</label>
																								<?php }else{ ?>
																									<label style="display: block;margin: 5px 0;padding: 7px 10px;font-size: 85%;" class="label label-lg label-warning">Confirm</label>
																								<?php } ?>
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</div>
																			
																			<?php } ?>
																			
																		<?php }else{ ?>
																			
																			<div id="" class="table-responsive form_approve">
																				<table class="table table-striped">
																					<thead>
																						<tr>
																							<td colspan="5" style="text-align: center; background-color: #eff3f4;">Belum ada data hari ini yang masuk</td>
																						</tr>
																					</thead>
																				</table>
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
		<script src="demo/js/tables-data-tables.js"></script>
		<script src="dist/js/ekko-lightbox.min.js"></script>
		<script src="demo/js/demo.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".form_approve").on("click", ".submit_confirm", function(){ 
					
					var parentObj = $(this).closest('.item-sub');
					
					var id 				= parentObj.find('.submit_confirm').attr('data-id');
					var status			= parentObj.find('select[name="status"]').val();
					var kondisi			= parentObj.find('select[name="kondisi"]').val();
					var fungsi 			= parentObj.find('select[name="fungsi"]').val();
					//var keterangan	 	= parentObj.find('label[name="keterangan"]').val();
									
					var proceed = true;
					
					if(proceed){
						//get input field values data to be sent to server
						
						post_data = {
							id
						};
						//Ajax post data to server
						$.post('action/confirm_checklist_hk.php', post_data, function(response){ 
							//console.log('dor');
							if(response.type == 'error'){ //load json data from server and output message     
								output = '<div class="error">'+response.text+'</div>';
								console.log ('error');
							}else{
			
								output = '<div class="success">'+response.text+'</div>';
							}
							
							$(".alert-success").hide().html(output).slideDown();
						
						}, 'json');
					}
					
					var $this = $(this);

					if ($this.hasClass("submit_confirm")){
						$this.removeClass("btn-warning");
						$this.addClass("btn-success");
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
			$(document).ready(function(){
				$(".form_approve").on("click", ".btn_submit_comments", function(){ 
					
					var parentObj = $(this).closest('.item-sub');
					
					var id_item 		= parentObj.find('.btn_submit_comments').attr('data-id');
					var comments		= parentObj.find('textarea[name="comments"]').val();
					//var id_user 		= parentObj.find('select[name="fungsi"]').val();
					//console.log(id);
					//console.log(comments);
					
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
    </body>
</html>
<?php } ?>