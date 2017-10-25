<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}
	else{
		include 'core/init.php';
		include 'core/helper/myHelper.php';
		$user = $db->user_login("id", $_SESSION['id'])->fetch();	
		$body = 'home';
?>
<!doctype html>

<html>
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Office System Purigroup</title>
        <meta name="description" content="Checklist System">
        <meta name="viewport" content="width=device-width">
        <link rel="shortcut icon" href="assets/img/puri.png">
        <link rel="stylesheet" href="dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="dist/css/veneto-admin.min.css">
        <link rel="stylesheet" href="demo/css/style.css">
        <link rel="stylesheet" href="dist/assets/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" href="dist/assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css"/>
        <link rel="stylesheet" href="dist/css/plugins/rickshaw.min.css">
        <link rel="stylesheet" href="dist/css/plugins/morris.min.css">
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
						<li class="active"><a href="javascript:;">Dashboard</a></li>
					</ol>
				</div>
				<div class="page-heading page-heading-md">
					<h4 class="pull-left">Welcome to Office System</h4>
					<div class="clearfix">
						<div class="pull-right">
							<?php if ($user_type != 'markom' && $user_type != 'kasir'): ?>
								<button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#tambahInternal">Tambah Internal Memo</button>
							<?php endif; ?>
						</div>
						
						<?php if ($user_type != 'markom' && $user_type != 'kasir'): ?>
						
						<div id="tambahInternal" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Internal Memo</h4>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-md-12">
												<form method="post" action="action/add_memo.php" enctype="multipart/form-data">
													<div class="form-group">
														<label>Name</label>
														<input type="text" name="name" class="form-control" required autocomplete="OFF">
													</div>
													<div class="form-group">
														<label>Description</label>
														<input type="text" name="description" class="form-control" required autocomplete="OFF">
													</div>
													<div class="form-group">
														<label>File</label>
														<input type="file" id="image_file" name="image_file[]" class="form-control" multiple>
													</div>
													<div class="form-group">
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
						
						<?php endif; ?>
						
					</div>
				</div>
				<div class="container-fluid-md">
					<div class="row">
						<?php
						$memos = $db->internal_memo()
								->order('created_at Desc')
								->limit(4);
						?>
						
						<?php foreach($memos as $memo){ ?>
						
						<?php if ($user_type != 'markom' && $user_type != 'kasir'): ?>
						
						<div class="col-md-3">
							<div class="list-group">
	  							<div class="list-group-item active">
	    							<h4 class="list-group-item-heading" style="height: 40px; line-height: 1.2;">
	    								<?php echo strtoupper($memo['name']); ?>
	    							</h4>
	    							<h5 class="list-group-item-heading">
	    								<?php echo '('.date("d-M-Y", strtotime($memo['created_at'])).')'; ?>
	    							</h5>
    								<button type="button" class="btn btn-md btn-warning" data-toggle="modal" data-target="#internalMemo<?php echo $memo['id'] ?>">Click For Detail</button>
	  							</div>
							</div>
						</div>
						
						<?php endif; ?>
						
						<?php if ($user_type != 'markom'): ?>
						
						<div id="internalMemo<?php echo $memo['id'] ?>" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title"><?php echo strtoupper($memo['name']).' ('.date("d-M-Y", strtotime($memo['created_at'])).')'; ?></h4>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-md-12">
												<p><b>Keterangan : </b><?php echo $memo['description']; ?></p>
												<?php
													$attachment = $db->attachment_internal_memo()
																	->where("internal_memo_id", $memo['id']);
													
													foreach($attachment as $attach){
														
														$ext = pathinfo($attach['file'], PATHINFO_EXTENSION);
														$gambar = array('jpg','png','gif','jpeg','JPG','PNG','GIF','JPEG');
														$document = array('pdf','PDF','doc','DOC','docx','DOCX','xls','XLS','xlsx','XLSX','ppt','PPT','pptx','PPTX');
														if (in_array($ext,$gambar)){
												?>
														<a href="<?php echo $attach['file']; ?>" target="_blank"><img src="<?php echo $attach['file']; ?>" width='200px' data-toggle="modal" data-target="#internalMemoImage<?php echo $attach['id'] ?>"></a>
												<?php
														}elseif (in_array($ext,$document)){
												?>
														<a href="<?php echo $attach['file']; ?>" target="_blank"><?php echo $attach['file']; ?></a>
												<?php
														}
													}
												?>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
						
						<?php endif; ?>
						
						<?php } ?>
					
					</div>
				</div>
			</div>
		</div>
		<?php include ('_footer.php'); ?>
		<script src="dist/assets/libs/jquery/jquery.min.js"></script>
        <script src="dist/assets/bs3/js/bootstrap.min.js"></script>
        <script src="dist/assets/plugins/jquery-navgoco/jquery.navgoco.js"></script>
        <script src="dist/js/main.js"></script>
        <script src="dist/assets/plugins/jquery-sparkline/jquery.sparkline.js"></script>
        <script src="demo/js/demo.js"></script>
		<script src="dist/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
        <script src="dist/assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
		<script src="dist/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="dist/assets/plugins/jquery-chosen/chosen.jquery.min.js"></script>
    </body>
</html>

<?php } ?>