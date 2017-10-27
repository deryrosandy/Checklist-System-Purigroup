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
				
					<?php include('transaksi_evoucher.php'); ?>
				
				<?php }elseif(@$_GET['act']=='penjualan'){ ?>
					
					<?php include('penjualan_evoucher.php'); ?>
					
				<?php }elseif(@$_GET['act']=='aktivasi'){ ?>
					
					<?php include('aktivasi_evoucher.php'); ?>
				
				<?php }else{ ?>
				
                <?php 
                    if (!empty(@$_GET['page'])){
                        $page = @$_GET['page'];
                    }else{
                        $page= 'aktivasi-evoucher';
                    };

                    include 'alert/alert.php';

                    $id_voucher = $_GET['id'];
                    $voucher = $db->voucher()
                        ->where("id", $id_voucher)
                        ->fetch();
                ?>

                <div class="container-fluid-md">
                    <div class="row">
                        <div class="col-lg-12">

                            <ul class="nav nav-pills">
                                <li class="<?php echo $page == 'list' ? 'active' : ''; ?>"><a data-toggle="" href="content.php?module=evoucher&page=list"><strong>LIST EVOUCHER</strong></a></li>
                                <li class="<?php echo $page == 'history-aktivasi' ? 'active' : ''; ?>"><a data-toggle="" href="content.php?module=evoucher&act=aktivasi&page=history-aktivasi"><strong>HISTORY AKTIVASI</strong></a></li>
                            </ul>

                            <?php if($page=="list"){ ?>				
                                <div class="tab-content panel panel-default">
                                    
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
                                                <table id="list_evoucher" class="display row-border nowrap table table-striped responsive-utilities jambo_table" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <!--<th><input type="checkbox" name="select_all" value="1" id="select-all-row"></th>-->
                                                            <th>Code</th>
                                                            <th>Barcode</th>
                                                            <th>Nominal</th>
                                                            <th>Active Date</th>
                                                            <th>Expire</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if($page=="history-aktivasi"){ ?>				
                                <div class="tab-content panel panel-default">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-button-colors pull-left">
                                                    <h1 style="padding-top:10px;" class="panel-title">History Transaksi Voucher</h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default" style="background-color: #f9f9f9;">

                                                    <div class="panel-body">
                                                        <div class="table-responsive">

                                                            <table data-sortable id="list_history_voucher" class="table table-responsive table-hover table-striped" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox" name="select_all" value="1" id="select-all-row"></th>
                                                                        <th>No.</th>
                                                                        <th>Kode Voucher</th>
                                                                        <th>Nominal Point</th>														
                                                                        <th>Customer</th>
                                                                        <th>Jam</th>
                                                                        <th>Tanggal</th>
                                                                        <th>Outlet</th>
                                                                        <th>Kasir</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php $n=1; ?>
                                                                <?php foreach ($voucher as $vc){ ?>
                                                                    <tr class="odd gradeX">
                                                                        <td><input type="checkbox" id="id_req[]" name="id_req[]" value="<?php echo $vc['id']; ?>"></td>
                                                                        <td><?php echo $n; ?></td>
                                                                        <td><?php echo strtoupper($vc->voucher['code']); ?></td>
                                                                        <td><?php echo number_format($vc->voucher['nominal'],0,",","."); ?></td>
                                                                        <td><?php echo strtoupper($vc['customer_name']); ?></td>
                                                                        <td><?php echo strtoupper(getHour($vc['created_at'])); ?></td>
                                                                        <td><?php echo strtoupper(tgl_indo($vc['created_at'])); ?></td>
                                                                        <?php if($vc['branch_id'] == 0){ ?>
                                                                            <td><?php echo ucwords('All Aoutlet'); ?></td>
                                                                        <?php }else {?>
                                                                            <td><?php echo ucwords($vc->branch['name']); ?></td>
                                                                        <?php } ?>
                                                                        <td><?php echo ucwords($vc->users['first_name']); ?></td>
                                                                    </tr>

                                                                    <?php $n++; ?>
                                                                <?php } ?>

                                                                </tbody>

                                                            </table>

                                                        </div>
                                                    </div>

                                                </div>	
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if($page=="info-voucher"){ ?>				

                                <?php 
                                    $key = strtoupper($_POST['key_input']);

                                    $voucher = $db->voucher()
                                                ->where("code LIKE '$key'")
                                                ->or("barcode LIKE '$key'")
                                                ->fetch();
                                    $data_v_penj = $db->voucher_penjualan()
                                                            ->where("voucher_id", $voucher['id']);

                                    $v_penjualan = $db->voucher_penjualan()
                                                            ->where("voucher_id", $voucher['id'])
                                                            ->fetch();

                                    $data_voucher = $db->voucher()
                                                ->where("code LIKE '$key'")
                                                ->or("barcode LIKE '$key'");

                                    if(count($data_voucher) < 1){
                                        echo "<button id='btnShowAlert' style='display:none;'></button>
                                            <script type='text/javascript'>
                                                sweetAlert({
                                                    title: 'Error!',
                                                    text: 'Kode Voucher Tidak Ditemukan!',
                                                    type: 'error'
                                                },
                                                function () {
                                                    window.location.href = 'content.php?module=voucher&act=transaksi&page=new-transaction';
                                                });
                                            </script>";
                                        exit();
                                    }
                                ?>

                            <div class="tab-content panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-button-colors pull-left">
                                                <h1 style="padding-top:10px;" class="panel-title">Detail Informasi Voucher</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default" style="background-color: #f9f9f9;">

                                                <?php if(@$_POST){ ?> 

                                                <div id="detail-info-voucher">

                                                    <div class="panel-body">
                                                        <div class="col-md-3 col-sm-3 text-center">
                                                            <?php if($voucher['voucher_type']=='ELEKTRIK'): ?>
                                                                <img alt="image" class="img img-profile" src="assets/img/evoucher-icon.png" style="width: 100%;" />
                                                            <?php else: ?>	
                                                                <img alt="image" class="img img-profile" src="assets/img/voucher-icon.png" style="width: 100%;" />
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="col-sm-9 profile-details">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-sm-12">
                                                                            <h4>KODE BARCODE</h4>
                                                                            <h2><?php echo $voucher['barcode']; ?></h2>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <?php /*
                                                                        <label class="control-label col-sm-12">
                                                                            <h4>KODE BARCODE</h4>
                                                                            <h2><?php echo $voucher['barcode']; ?></h2>
                                                                        </label>
                                                                        */ ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-sm-12">
                                                                            <h4>NILAI POINT</h4>
                                                                            <h2><?php echo $voucher['nominal']; ?></h2>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-sm-12">
                                                                            <h4>EXPIRE DATE</h4>
                                                                            <h2><?php echo ($voucher['expire_date']==null) ? '-': tgl_indo($voucher['expire_date']); ?></h2>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-sm-12">
                                                                            <h4>OUTLET</h4>
                                                                            <h2><?php echo ($voucher['branch_id']=='0' ? 'All Outlet' : $voucher->branch['name']); ?></h2>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <?php if(count($data_v_penj)>0){ ?>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-sm-12">
                                                                                <h4>OUTLET PEMBELIAN VOUCHER</h4>
                                                                                <h2><?php echo (count($data_v_penj)>0 ? ($v_penjualan['branch_id']==0 ? 'Kantor Pusat' : $v_penjualan->branch['name']) : '-'); ?></h2>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-sm-12">
                                                                            <h4>STATUS</h4>
                                                                            <?php if($voucher['status']=='ACTIVE'){ ?>
                                                                                <h2><label class="label label-success"><?php echo $voucher['status']; ?></label></h2>
                                                                            <?php }elseif($voucher['status']=='NON ACTIVE'){ ?>
                                                                                <h2><label class="label label-info"><?php echo $voucher['status']; ?></label></h2>
                                                                            <?php }elseif($voucher['status']=='TERPAKAI'){ ?>
                                                                                <h2><label class="label label-danger"><?php echo $voucher['status']; ?></label></h2>
                                                                            <?php }elseif($voucher['status']=='EXPIRE'){ ?>
                                                                                <h2><label class="label label-warning"><?php echo $voucher['status']; ?></label></h2>
                                                                            <?php } ?>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>																	

                                                    <?php if($voucher['status']=='ACTIVE' && $voucher['branch_id']=='0'){ ?>

                                                        <div class="panel-body">

                                                            <form id="AddVoucherInput" action="action/proses_voucher.php" method="POST" role="form" class="">

                                                                <input type="hidden" value="<?php echo $voucher['id']; ?>" name="voucher_id" class="form-control required" />
                                                                <input type="hidden" value="<?php echo $voucher['voucher_type']; ?>" name="voucher_type"/>
                                                                <input type="hidden" value="<?php echo $voucher['barcode']; ?>" name="barcode"/>
                                                                <input type="hidden" value="<?php echo $voucher['nominal']; ?>" name="nominal"/>
                                                                <input type="hidden" value="<?php echo $voucher['branch_id']; ?>" name="branch_id" class="form-control required" />

                                                                <fieldset>
                                                                    <div class="form-group row">
                                                                        <div class="col-md-4">
                                                                            <div class="row input-voucher text-center">
                                                                                <div class="col-md-12">
                                                                                    <input type="text" name="customer_name" class="input-lg form-control required" title="Insert Customer Name" placeholder="Insert Customer Name">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="row">
                                                                                        <button type="submit" class="btn btn-lg btn-primary">GUNAKAN VOUCHER</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                            </form>

                                                        </div>

                                                    <?php }elseif($voucher['status']=='ACTIVE' && $voucher['branch_id']==$_SESSION['branch_id']){ ?>

                                                        <div class="panel-body">

                                                            <form id="AddVoucherInput" action="action/proses_voucher.php" method="POST" role="form" class="">

                                                                <input type="hidden" value="<?php echo $voucher['id']; ?>" name="voucher_id" class="form-control required" />

                                                                <input type="hidden" value="<?php echo $voucher['branch_id']; ?>" name="branch_id" class="form-control required" />

                                                                <fieldset>
                                                                    <div class="form-group row">
                                                                        <div class="col-md-4">
                                                                            <div class="row input-voucher text-center">
                                                                                <div class="col-md-12">
                                                                                    <input type="text" name="customer_name" class="input-lg form-control required" title="Insert Customer Name" placeholder="Insert Customer Name">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="row text-center">
                                                                                <div class="col-md-12" style="padding-left: 0;">
                                                                                    <button type="submit" class="btn btn-lg btn-primary form-control">GUNAKAN VOUCHER</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                            </form>

                                                        </div>

                                                    <?php }else{ ?>

                                                        <div class="panel-body">

                                                            <fieldset>
                                                                <div class="form-group row">
                                                                    <div class="col-md-12">
                                                                        <div class="row input-voucher text-left">
                                                                            <div class="col-md-12">
                                                                                <h1 class="btn btn-lg btn-danger">Voucher Tidak Dapat Digunakan!</h1>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </fieldset>

                                                        </div>

                                                    <?php } ?>

                                                </div>

                                            <?php } ?>

                                            </div>	
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } ?>

                            <?php if($page=="print-transaction"){ ?>				

                            <?php } ?>

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
							columns: [0,1,2,3,4,5],
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
							columns: [0,1,2,3,4,5]
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
							columns: [0,1,2,3,4,5],
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
							columns: [0,1,2,3,4,5],
						},
						pageSize: 'A4',
						title: 'Daftar Voucher',
					},
					{
						extend: 'colvis',
						footer: false,
						exportOptions: {
							columns: [0,1,2,3,4,5],
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