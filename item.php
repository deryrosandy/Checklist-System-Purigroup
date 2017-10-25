<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}else{
		include 'core/init.php';
		include 'core/helper/myHelper.php';
	
		$user_type = $_SESSION['user_type'];

		$items = $db->item()
			->order('created DESC')
			;
		
		$body = 'item';
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
        <link rel="stylesheet" href="dist/assets/font-awesome/css/font-awesome.css">

        <link rel="stylesheet" href="dist/css/plugins/jquery-select2.min.css">
        <link rel="stylesheet" href="dist/css/plugins/jquery-dataTables.min.css">
        <!--[if lt IE 9]>
        <script src="dist/assets/libs/html5shiv/html5shiv.min.js"></script>
        <script src="dist/assets/libs/respond/respond.min.js"></script>
        <![endif]-->

    </head>
    <body id="item">
		<?php include ('_header.php'); ?>
	
        <div class="page-wrapper">
            <aside class="sidebar sidebar-default">
				
				<?php include('nav.php'); ?>
			
			</aside>

            <div class="page-content">
                <div class="page-subheading page-subheading-md">
    <ol class="breadcrumb">
        <li><a href="javascript:;">Dashboard</a></li>
        <li class="active"><a href="javascript:;">Item</a></li>
    </ol>
</div>
<div class="page-heading page-heading-md">
    <h2 class="pull-left">List Item</h2>
	<div class="col-button-colors pull-right">
		<a href="dashboard.php" class="btn btn-primary">Back</a>
	</div>
	<div class="clearfix"></div>
</div>

<form class="form-horizontal form-bordered" role="form">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">List Item</h4>
        </div>
		
		<div class="panel-body">
            <table id="table-basic" class="table table-item table-striped">
                <thead>
                    <tr>
                        <th class="no">No.</th>
                        <th class="name">Name</th>
                        <th class="part_number">Part Number</th>
						<?php if($user_type != 'super admin'){ ?>
							<th class="category">Category</th>
						<?php } ?>
                        <th class="price">Price</th>
                        <th class="weight">Weight</th>
                        <th class="stock">Stock</th>
						<?php if($user_type == 'super admin'){ ?>
                        <th class="action">Action</th>
						<?php } ?>
                    </tr>
                </thead>
                <tbody>
				<?php $no = 1; ?>
				
				<?php foreach ($items as $item){ ?>
                    <tr class="odd gradeX">
                        <td><?php echo $no; ?></td>
			            <td><?php echo ucfirst($item["item_name"]); ?></td>
                        <td><a href="item-detail.php?id=<?php echo $item['id']; ?>" class="link-detail" title="Detail"><?php echo ucfirst($item['item_number']); ?></a></td>
						<?php if($user_type != 'super admin'){ ?>
							<td><?php echo ucfirst($item->item_category["category_name"]); ?></td>
						<?php } ?>
						<td>IDR <?php echo number_format($item['item_sale'],0,'.','.'); ?></td>
                        <td><?php echo ucfirst($item['item_weight']); ?> KG</td>
                        <td><?php echo ucfirst($item['item_stock']); ?> Unit</td>
						<?php /*<td><?php echo ucfirst($i['item_status']); ?></td> */ ?>
                        <?php /*<td class="status"><h1 class="label <?php echo colour_status($status); ?>"><?php echo $m['status']; ?></h1></td> */ ?>
                        <?php if($user_type == 'super admin'){ ?>
						<td class="btn-group">
							<a href="edit-item.php?id=<?php echo $item['id']; ?>" class="btn btn-warning">Edit</a>
							<a href="delete-item.php?id=<?php echo $item['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to Delete ?');">Delete</a>
						</td>
						<?php } ?>
                    </tr>
				<?php $no++ ?>
				<?php } ?>
                </tbody>
            </table>
        </div>
		
	</div>
</form>

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
        <script src="demo/js/tables-data-tables.js"></script>



    </body>
</html>

<?php } ?>