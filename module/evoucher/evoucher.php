<?php
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}else{
		if($_SESSION['user_type'] == 'staff adm' || $_SESSION['user_type'] == 'manager'){
			$voucher = $db->request()
						->where("branch_id", $_SESSION['branch_id'])
						->order("created_at DESC");
		}elseif($_SESSION['user_type'] == 'manager divisi'){
			$voucher = $db->request()
						->where("id",($db->request_approval()->select("request_id")->where("users_id", $db->users()->select("id")->where("user_type", "manager"))))
						->order("created_at DESC");
		}elseif($_SESSION['user_type'] == 'purchasing'){
			$voucher = $db->request()
						->where("id",($db->request_approval()->select("request_id")->where("users_id", $db->users()->select("id")->where("user_type", "manager divisi"))))
						->order("created_at DESC");
		}elseif($_GET['page'] == 'history-transaction'){
			if($_SESSION['user_type']=='kasir'){
				$voucher = $db->voucher_history()
							->where("branch_id", $_SESSION['branch_id'])
							->where("users_id", $_SESSION['id'])
							->order("created_at DESC");
			}elseif($_SESSION['user_type']=='manager'){
				$voucher = $db->voucher_history()
							->where("branch_id", $_SESSION['branch_id'])
							->order("created_at DESC");
			}else{
				$voucher = $db->voucher_history()
							->order("created_at DESC");
			}
		}elseif($_GET['page'] == 'history-penjualan'){
			//var_dump($_SESSION); die();
			if($_SESSION['user_type']=='kasir'){
				$voucher = $db->voucher_penjualan()
							->where("branch_id", $_SESSION['branch_id'])
							->where("users_id", $_SESSION['id'])
							->order("created_at DESC");
							
			}elseif($_SESSION['user_type']=='manager'){
				$voucher = $db->voucher_penjualan()
							->where("branch_id", $_SESSION['branch_id'])
							->order("created_at DESC");
			}else{
				$voucher = $db->voucher_penjualan()
							->order("created_at DESC");
			}
			//var_dump($voucher); die();
		}else{
			$voucher = $db->voucher()
						->order("created_at DESC");
		}
		include 'alert/alert.php';
		
		$body = 'voucher';
?>

<!doctype html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html> <!--<![endif]-->
<head>
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Office System Purigroup</title>
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
		<link rel="stylesheet" href="dist/assets/plugins/datatables-print/css/dataTables.bootstrap.min.css">
		<link rel="stylesheet" href="dist/assets/plugins/datatables-print/css/buttons.bootstrap.min.css">
		
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
						<li class="active"><a href="javascript:;">Voucher</a></li>
					</ol>
				</div>
				<div class="page-heading page-heading-md">
					<h3 class="pull-left">Management Voucher</h3>
					<!--
					<div class="col-button-colors pull-right">
						<a href="dashboard.php" class="btn btn-primary">Back</a>
					</div>
					-->
					<div class="clearfix"></div>
				</div>
				
				<?php if(@$_GET['act']=='add'){ ?>
				
					<?php include('add-evoucher.php'); ?>
				
				<?php }elseif(@$_GET['act']=='category'){ ?>
				
					<?php include('category.php'); ?>
					
				<?php }elseif(@$_GET['act']=='history'){ ?>
				
					<?php include('history-evoucher.php'); ?>
					
				<?php }elseif(@$_GET['act']=='add-category'){ ?>
				
					<?php include('add-category.php'); ?>
					
				<?php }elseif(@$_GET['act']=='edit-category'){ ?>
				
					<?php include('edit-category.php'); ?>
					
				<?php }elseif(@$_GET['act']=='edit'){ ?>
					
					<?php include('edit-evoucher.php'); ?>
				
				<?php }elseif(@$_GET['act']=='transaksi'){ ?>
				
					<?php include('transaksi.php'); ?>
				
				<?php }elseif(@$_GET['act']=='penjualan'){ ?>
					
					<?php include('penjualan.php'); ?>
					
				<?php }elseif(@$_GET['act']=='voucher_ajax'){ ?>
					
					<?php include('voucher_ajax.php'); ?>
				
				<?php }else{ ?>
				
				<div class="container-fluid-md">
					<div class="panel panel-default">
					
						<div class="panel-heading">
							<div class="row">
								<div class="col-lg-12">
									<div class="col-button-colors pull-left">
										<h1 style="padding-top:10px;" class="panel-title">List eVoucher</h1>
									</div>
									<div class="col-button-colors pull-right">
										<?php if($_SESSION['user_type'] == 'markom'){ ?>
											<a href="content.php?module=voucher&act=add" style="margin-bottom: 0px;" class="btn btn-primary"><i class="fa fa-plus"></i> Add Voucher</a>
											<button data-toggle="modal" data-target="#modalUpload" style="margin-bottom: 0px;" class="btn btn-primary"><i class="fa fa-upload"></i> Import From Excel</button>
											<a href="upload/kantor pusat/list_voucher.xlsx" style="margin-bottom: 0px;" class="btn btn-primary"><i class="fa fa-download"></i> Download Template</a>
										<?php } ?>
									</div>
									<!-- Modal -->
									<div id="modalUpload" class="modal fade" role="dialog">
										<div class="modal-dialog">

											<!-- Modal content-->
											<div class="modal-content">
											  <div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Import From Excel File</h4>
											  </div>
											  <div class="modal-body">
												<p>Some text in the modal.</p>
												<div class="row">
													<div class="col-lg-12">
														<form class="well" action="action/import_xls.php" method="post" enctype="multipart/form-data">
															<div class="form-group">
																<label for="file">Select Excel file to import data</label>
																<input type="file" name="file_xls" size="40">
																<!--<p class="help-block">Only Allow Excell File.</p>-->
															</div>
															<button type="submit" class="btn btn-lg btn-primary" value="Upload">Submit</button>
															&nbsp;
															<input type="hidden" id="file_xls" value="" name="file_xls" />
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
							</div>
						</div>
						
						<div class="panel-body">
							<div class="table-responsive">
								<!--<table id="list_evoucher" class="table table-responsive table-hover table-striped" cellspacing="0" width="100%">-->
								<table id="list_evoucher" class="display row-border nowrap table-striped responsive-utilities jambo_table" cellspacing="0" width="100%">
									<thead>
										<tr>
											<!--<th><input type="checkbox" name="select_all" value="1" id="select-all-row"></th>-->
											<th>Kode Voucher</th>
											<th>Barcode</th>
											<th>Nominal</th>
											<th>Tgl Aktif</th>
											<th>Expire</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
									<?php /*
									<tbody>
									<?php $n=1; ?>
									<?php foreach ($voucher as $vc){ ?>
										<tr class="odd gradeX">
											<td><input type="checkbox" id="id_req[]" name="id_req[]" value="<?php echo $vc['id']; ?>"></td>
											<td><?php echo $n; ?></td>
											<td><?php echo strtoupper($vc['code']); ?></td>
											<td><?php echo strtoupper($vc['barcode']); ?></td>
											<td><?php echo number_format($vc['nominal'],0,",","."); ?></td>
											<td><?php echo tgl_indo($vc['active_date']); ?></td>
											<td><?php echo tgl_indo($vc['expire_date']); ?></td>
											
											<?php if($vc['branch_id']==0){ ?>
												<td class="center">All Outlet</td>
											<?php }else{ ?>
												<td class="center"><?php echo $vc->branch['name']; ?></td>
											<?php } ?>
											
											<td><?php echo $vc->voucher_category['name']; ?></td>
											
											<?php if($vc['status']=='ACTIVE'){ ?>
												<td><span style="padding: 3px 5px;" class="label label-sm label-success"><?php echo $vc['status']; ?></span></td>
											<?php }elseif($vc['status']=='TERPAKAI'){ ?>
												<td><span style="padding: 3px 5px;" class="label label-sm label-danger"><?php echo $vc['status']; ?></span></td>
											<?php }else{ ?>
												<td><span style="padding: 3px 5px;" class="label label-sm label-warning"><?php echo $vc['status']; ?></span></td>
											<?php } ?>
											<td class="btn-group btn-group-box">
												<table>
													<tr>
														<td valign="top">
															<a href="content.php?module=voucher&act=edit&id=<?php echo $vc['id']; ?>" style="margin-right:3px;" class="btn btn-sm btn-info">Edit</a>
														</td>
														<td>
															<form method="post" action="action/delete_voucher.php?id=<?php echo $vc['id']; ?>" id="itemhapus<?php echo $vc['id']; ?>">
																<i class="fa fa-trash"></i><input type="submit" class="btn btn-sm btn-danger" value="Delete">
															</form>
															<script type="text/javascript">
																document.querySelector('#itemhapus<?php echo $vc['id']; ?>').addEventListener('submit', function(e) {
																	var form = this;
																	e.preventDefault();
																	swal({
																		title: "Apa Anda Yakin?",
																		type: "warning",
																		showCancelButton: true,
																		confirmButtonColor: '#DD6B55',
																		cancelButtonText: "Batal",
																		confirmButtonText: 'Yakin',
																		closeOnConfirm: false,
																		closeOnCancel: false
																	},
																	function(isConfirm) {
																		if (isConfirm) {
																			form.submit();
																		}
																		else {
																			swal("Batal", "", "error");
																		}
																	});
																});
															</script>
														</td>
													</tr>
												</table>
											</td>
										</tr>

										<?php $n++; ?>
									<?php } ?>

									</tbody>
									*/ ?>
								</table>
							
							</div>
						</div>
					</div>
				</div>
				
				<?php } ?>
				
            </div>
			
        </div>
		
		<?php include ('_footer.php'); ?>
		
		<script src="dist/assets/libs/jquery/jquery.min.js"></script>
        <script src="dist/assets/plugins/datatables-print/js/jquery.dataTables.min.js"></script>
        <script src="dist/assets/bs3/js/bootstrap.min.js"></script>
        <script src="dist/assets/plugins/jquery-navgoco/jquery.navgoco.js"></script>
        <script src="dist/js/main.js"></script>

        <!--[if lt IE 9]>
        <script src="dist/assets/plugins/flot/excanvas.min.js"></script>
        <![endif]-->
        <script src="dist/assets/plugins/jquery-sparkline/jquery.sparkline.js"></script>
        <script src="demo/js/demo.js"></script>

        <script src="dist/assets/plugins/jquery-select2/select2.min.js"></script>
		<script src="dist/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
		<script src="dist/assets/plugins/jquery-chosen/chosen.jquery.min.js"></script>
		<script src="dist/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="dist/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
		<!-- For Button Print -->
        <script src="dist/assets/plugins/datatables-print/js/dataTables.bootstrap.min.js"></script>
		<script src="dist/assets/plugins/datatables-print/js/dataTables.buttons.min.js"></script>
		<script src="dist/assets/plugins/datatables-print/js/buttons.bootstrap.min.js"></script>
		<script src="dist/assets/plugins/datatables-print/js/jszip.min.js"></script>
		<script src="dist/assets/plugins/datatables-print/js/pdfmake.min.js"></script>
		<script src="dist/assets/plugins/datatables-print/js/vfs_fonts.js"></script>
		<script src="dist/assets/plugins/datatables-print/js/buttons.html5.min.js"></script>
		<script src="dist/assets/plugins/datatables-print/js/buttons.print.min.js"></script>
		<script src="dist/assets/plugins/datatables-print/js/buttons.colVis.min.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function() {
				$("#AddVoucherInput").validate();
			})
		</script>
		
		<script type="text/javascript">
			$(document).ready(function() {
				var table = $('#list_evoucher').DataTable( {
					"processing": true,
					"serverSide": true,
					"ajax": {
						url: 'action/get_evoucher.php',
						type: 'POST',
                        error: function(){  // error handling
							$(".employee-grid-error").html("");
							$("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							$("#employee-grid_processing").css("display","none");
							
						}
					},
					"createdRow": function ( row, data, index ) {
						$(row).addClass('gradeX');
					},
            
					"lengthChange": false,
					"columnDefs": [
						{
							columns: [0,1,2,3,4,5,6],
							visible: false,
						},
						{
							targets: "_all",
							className: "dt-center"
						}
					],
					"lengthMenu": [5, 10, 50, 100],
                    "pageLength": 50,
                    "scrollX": true,
                    dom: 'Bfrtip',
					
					buttons: [
						{
						extend: 'print',
						orientation: 'portrait ',
						pageSize: 'A4',
						title: 'Daftar Voucher',
						exportOptions: {
							columns: [0,1,2,3,4,5,6]
						},
						customize: function ( win ) {
							$(win.document.body)
								.css( 'font-size', '10pt' )
								.prepend(
									//'<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
								);

							$(win.document.body).find( 'table' )
								.addClass( 'compact' )
								.css( 'font-size', 'inherit' );
							
							$(win.document.body).find('table thead tr th')
								.addClass('compact')
								.css('text-align', 'center');
							$(win.document.body).find('table tr')
								.addClass('compact')
								.css('text-align', 'center');
							$(win.document.body).find('table tbody tr td:first-child')
								.addClass('compact')
								.css('text-align', 'center')
								.css('width', '30px');
						},
					},
					{
						extend: 'pdfHtml5',
						text: 'Export selected',
						footer: true,
						exportOptions: {
							columns: [0,1,2,3,4,5,6],
							modifier: {
                                    selected: true
                                },
							rows: { selected: true }
						},
						orientation: 'portrait ',
						pageSize: 'A4',
						title: 'Daftar Voucher',
					},
					{
						extend: 'excel',
						footer: false,
						exportOptions: {
							columns: [0,1,2,3,4,5,6],
						},
						pageSize: 'A4',
						title: 'Daftar Voucher',
					},
					{
						extend: 'colvis',
						footer: false,
						exportOptions: {
							columns: [0,1,2,3,4,5,6],
						},
						pageSize: 'A4',
						title: 'Daftar Voucher',
					}],
					select: {
                    	style : "multi"
                    }
				});
				
				$(document.body).find('tr td').css('padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px soli');
				table.buttons().container()
					.appendTo( '#list_voucher_wrapper .col-sm-6:eq(0)' );
					
				// Event listener to the two range filtering inputs to redraw on input
				$('#min, #max').keyup( function() {
					table.draw();
				});
			});
			
			/* Custom filtering function which will search data in column four between two values */
			$.fn.dataTable.ext.search.push(
				function( settings, data, dataIndex ) {
					var min = parseInt( $('#min').val(), 10 );
					var max = parseInt( $('#max').val(), 10 );
					var date = parseFloat(data[5]) || 0; // use data for the date column
					if ( ( isNaN( min ) && isNaN( max ) ) ||
						 ( isNaN( min ) && date <= max ) ||
						 ( min <= date   && isNaN( max ) ) ||
						 ( min <= date   && date <= max ) )
					{
						return true;
					}
					return false;
				}
			);
			
		</script>
		
		<!--
		<script type="text/javascript">
			$(document).ready(function() {
				var table = $('#list_voucher').DataTable( {
					lengthChange: false,
					'columnDefs': [
						{
							columns: [0,1,2,3,4,5,6,7],
							visible: false,
						},
						{
							targets: "_all",
							className: "dt-center"
						}
					],
					"lengthMenu": [5, 10, 50, 100],
                    "pageLength": 50,
                    "scrollX": true,
                    dom: 'Bfrtip',
					
					buttons: [
						{
						extend: 'print',
						orientation: 'portrait ',
						pageSize: 'A4',
						title: 'Daftar Voucher',
						exportOptions: {
							columns: [0,1,2,3,4,5,6,7]
						},
						customize: function ( win ) {
							$(win.document.body)
								.css( 'font-size', '10pt' )
								.prepend(
									//'<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
								);

							$(win.document.body).find( 'table' )
								.addClass( 'compact' )
								.css( 'font-size', 'inherit' );
							
							$(win.document.body).find('table thead tr th')
								.addClass('compact')
								.css('text-align', 'center');
							$(win.document.body).find('table tr')
								.addClass('compact')
								.css('text-align', 'center');
							$(win.document.body).find('table tbody tr td:first-child')
								.addClass('compact')
								.css('text-align', 'center')
								.css('width', '30px');
						},
					},
					{
						extend: 'pdfHtml5',
						text: 'Export selected',
						footer: true,
						exportOptions: {
							columns: [0,1,2,3,4,5,6,7],
							modifier: {
                                    selected: true
                                },
							rows: { selected: true }
						},
						orientation: 'portrait ',
						pageSize: 'A4',
						title: 'Daftar Voucher',
					},
					{
						extend: 'excel',
						footer: false,
						exportOptions: {
							columns: [0,1,2,3,4,5,6,7],
						},
						pageSize: 'A4',
						title: 'Daftar Voucher',
					},
					{
						extend: 'colvis',
						footer: false,
						exportOptions: {
							columns: [0,1,2,3,4,5,6,7],
						},
						pageSize: 'A4',
						title: 'Daftar Voucher',
					}],
					select: {
                    	style : "multi"
                    }
				});
				
				table.buttons().container()
					.appendTo( '#list_voucher_wrapper .col-sm-6:eq(0)' );
					
				// Event listener to the two range filtering inputs to redraw on input
				$('#min, #max').keyup( function() {
					table.draw();
				});
			});
			
			/* Custom filtering function which will search data in column four between two values */
			$.fn.dataTable.ext.search.push(
				function( settings, data, dataIndex ) {
					var min = parseInt( $('#min').val(), 10 );
					var max = parseInt( $('#max').val(), 10 );
					var date = parseFloat(data[5]) || 0; // use data for the date column
					if ( ( isNaN( min ) && isNaN( max ) ) ||
						 ( isNaN( min ) && date <= max ) ||
						 ( min <= date   && isNaN( max ) ) ||
						 ( min <= date   && date <= max ) )
					{
						return true;
					}
					return false;
				}
			);
			
		</script>
		-->
		
		<script type="text/javascript">
			$(document).ready(function() {
				var table = $('#list_history_voucher').DataTable( {
					lengthChange: false,
					'columnDefs': [
						{
							columns: [0,1,2,3,4,5,6,7,8],
							visible: false,
						},
						{
							targets: "_all",
							className: "dt-center"
						}
					],
					"lengthMenu": [5, 10, 50, 100],
                    "pageLength": 50,
                    "scrollX": true,
                    dom: 'Bfrtip',
					
					buttons: [
						{
						extend: 'print',
						orientation: 'portrait ',
						pageSize: 'A4',
						title: 'Daftar Voucher',
						exportOptions: {
							columns: [0,1,2,3,4,5,6,7,8]
						},
						customize: function ( win ) {
							$(win.document.body)
								.css( 'font-size', '10pt' )
								.prepend(
									//'<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
								);

							$(win.document.body).find( 'table' )
								.addClass( 'compact' )
								.css( 'font-size', 'inherit' );
							
							$(win.document.body).find('table thead tr th')
								.addClass('compact')
								.css('text-align', 'center');
							$(win.document.body).find('table tr')
								.addClass('compact')
								.css('text-align', 'center');
							$(win.document.body).find('table tbody tr td:first-child')
								.addClass('compact')
								.css('text-align', 'center')
								.css('width', '30px');
						},
					},
					{
						extend: 'pdfHtml5',
						text: 'Export selected',
						footer: true,
						exportOptions: {
							columns: [0,1,2,3,4,5,6,7,8],
							modifier: {
                                    selected: true
                                },
							rows: { selected: true }
						},
						orientation: 'portrait ',
						pageSize: 'A4',
						title: 'Daftar Voucher',
					},
					{
						extend: 'excel',
						footer: false,
						exportOptions: {
							columns: [0,1,2,3,4,5,6,7,8],
						},
						pageSize: 'A4',
						title: 'Daftar Voucher',
					}],
					select: {
                    	style : "multi"
                    }
				});
				
				table.buttons().container()
					.appendTo( '#list_history_voucher_wrapper .col-sm-6:eq(0)' );
					
				// Event listener to the two range filtering inputs to redraw on input
				$('#min, #max').keyup( function() {
					table.draw();
				});
			});
			
			/* Custom filtering function which will search data in column four between two values */
			$.fn.dataTable.ext.search.push(
				function( settings, data, dataIndex ) {
					var min = parseInt( $('#min').val(), 10 );
					var max = parseInt( $('#max').val(), 10 );
					var date = parseFloat(data[5]) || 0; // use data for the date column
					if ( ( isNaN( min ) && isNaN( max ) ) ||
						 ( isNaN( min ) && date <= max ) ||
						 ( min <= date   && isNaN( max ) ) ||
						 ( min <= date   && date <= max ) )
					{
						return true;
					}
					return false;
				}
			);
			
		</script>	
		
    </body>
</html>

<?php } ?>