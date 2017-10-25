<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}else{
		
		include 'core/init.php';
		include 'core/helper/myHelper.php';
		include 'assets/alert/alert.php';
	
		$user = $db->user_login("id", $_SESSION['id'])->fetch();
		$body = 'home';
		$connect = mysqli_connect('localhost','root','','checklist_system_db');


		if ($_POST) {
			$item_name = $_POST['item_name'];
			$divisi_id = $_POST['divisi_id'];
			$item_area_id = $_POST['area_id'];
			$branch_id = $_POST['branch_id'];
			$tanggal = date('Y-m-d').' '.date('H:i:s');

			if (empty($item_name) || empty($divisi_id) || empty($item_area_id) || empty($branch_id)) {
				echo "<button id='btnShowAlert' style='display:none;'></button>
					<script type='text/javascript'>
						sweetAlert({
							title: 'Error!',
							text: 'Pastikan Tidak Ada Field Yang Kosong!',
							type: 'error'
						},
						function () {
							window.location.href = 'item_tambah.php';
						});
					</script>";
				exit();
			}

			$query3 = mysqli_query($connect,"SELECT * FROM item WHERE item_name = '$item_name' AND divisi_id = '$divisi_id' AND item_area_id = '$item_area_id' AND branch_id = '$branch_id'");
			$jumlah3 = mysqli_num_rows($query3);
			if ($jumlah3 > 0) {
				echo "<button id='btnShowAlert' style='display:none;'></button>
					<script type='text/javascript'>
						sweetAlert({
							title: 'Error!',
							text: 'Data Telah Terdaftar Pada Sistem!',
							type: 'error'
						},
						function () {
							window.location.href = 'item_tambah.php';
						});
					</script>";
				exit();
			}

			$query4 = mysqli_query($connect,"INSERT INTO item (item_name, item_area_id, divisi_id, branch_id, created_at, updated_at) VALUES ('$item_name','$item_area_id','$divisi_id','$branch_id','$tanggal','$tanggal')");
			echo "<button id='btnShowAlert' style='display:none;'></button>
				<script type='text/javascript'>
					sweetAlert({
						title: 'Sukses!',
						text: 'Berhasil Tambah Item!',
						type: 'success'
					},
					function () {
						window.location.href = 'content.php?module=master&page=item';
					});
				</script>";
			exit();
		}
?>
<!doctype html>
<!--[if gt IE 9]><!--> <html> <!--<![endif]-->
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Checklist System Purigroup</title>
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
        <script type="text/javascript" src="jquery_combo.js"></script>
        <script type='text/javascript'>
			var htmlobjek;
			$(document).ready(function() {
				$("#divisi_id").change(function(){
					var divisi_id = $("#divisi_id").val();
					$.ajax({
						type: "POST",
						dataType: "html",
						url: "item_tambah_pilih_area.php",
						data: "divisi_id="+divisi_id,
						cache: false,
						success: function(msg){
							$("#area_id").html(msg);
						}
					});
				});
			});
		</script>
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
						<li class="active"><a href="javascript:;">Master</a></li>
						<li class="active"><a href="javascript:;">Item</a></li>
					</ol>
				</div>
				<div class="page-heading page-heading-md">
					<h3 class="pull-left">Config Master</h3>
					<div class="col-button-colors pull-right">
						<a href="dashboard.php" class="btn btn-primary">Back</a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="container-fluid-md">
					<div class="row">
						<div class="col-lg-11">
							<ul class="nav nav-pills">
								<div class="col-lg-12 col-md-12">
									<div class="tab-content panel panel-default">
										<div class="panel-heading">
											<div class="row">
												<div class="col-lg-12">
													<div class="col-button-colors pull-left">
														<h1 style="padding-top:10px;" class="panel-title">Tambah Item</h1>
													</div>
												</div>
											</div>
										</div>
										<div class="panel-body table-responsive">
											<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
												<div class="form-group">
													<label>Name</label>
													<input type="text" name="item_name" class="form-control" required autocomplete="OFF">
												</div>
												<div class="form-group">
													<label>Divisi</label>
													<select class="form-control" name="divisi_id" id="divisi_id" data-placeholder="Pilih divisi . . .">
														<option value="">-PILIH-</option>
														<?php
															$query1 = mysqli_query($connect,"SELECT * FROM divisi ORDER BY name");
															while($data1 = mysqli_fetch_array($query1,MYSQLI_ASSOC)){
														?>
															<option value="<?php echo $data1['id']; ?>"><?php echo $data1['name'];?></option>
														<?php } ?>
													</select>
												</div>
												<div class="form-group">
													<label>Area</label>
													<select class="form-control" name="area_id" id="area_id" data-placeholder="Pilih area . . .">
														<option value="">-PILIH-</option>
													</select>
												</div>
												<div class="form-group">
													<label>Branch</label>
													<select class="form-control" name="branch_id" data-placeholder="Pilih branch . . .">
														<option value="">-PILIH-</option>
														<?php
															$query2 = mysqli_query($connect,"SELECT id, name FROM branch ORDER BY name ASC");
															while($data2 = mysqli_fetch_array($query2,MYSQLI_ASSOC)){
														?>
														<option value="<?php echo $data2['id']; ?>"><?php echo $data2['name']; ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="form-group">
													<input type="submit" class="btn btn-md btn-primary" value="Submit">
													<input type="reset" class="btn btn-md btn-danger" value="Reset">
												</div>
											</form>
										</div>
									</div>
								</div>
							</ul>
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
        <script src="dist/assets/plugins/jquery-sparkline/jquery.sparkline.js"></script>
        <script src="demo/js/demo.js"></script>
		<script src="dist/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
        <script src="dist/assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
		<script src="dist/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="dist/assets/plugins/jquery-chosen/chosen.jquery.min.js"></script>
    </body>
</html>
	<?php } ?>