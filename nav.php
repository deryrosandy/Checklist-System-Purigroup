<?php
	
	$user_type = $_SESSION['user_type'];
	
?>

 <div class="sidebar-profile">
	<div class="profile-body">
		<h4>Welcome, <?php echo ucfirst($_SESSION['firstname']); ?></h4>
		<br/>
	</div>
</div>

<nav>
	<h5 class="sidebar-header">Navigation</h5>
	<ul class="nav nav-pills nav-stacked">
		<!--<li class="nav active open">-->
		<li class="nav <?php if($body == 'home'){echo 'active';}?>">
			<a href="index.php" title="Dashboards">
				<i class="fa fa-lg fa-fw fa-home"></i> Dashboards
			</a>
		</li>
		<?php /*
		<li class="nav <?php if($body == 'item'){echo 'active';}?>">
			<a href="item.php" title="item">
				<i class="fa fa-lg fa-fw fa-tags"></i> Item<!--<span class="label label-warning pull-right">31</span>-->
			</a>
		</li>
		*/ ?>
		<?php if($user_type == 'administrator' || $user_type == 'manager' || $user_type == 'leader' || $user_type =='operator' || $user_type =='manager pengganti' || $user_type =='operator'){ ?>
		
		<li class="nav <?php if($body == 'checklist'){echo 'active';}?>">
			<a href="content.php?module=checklist" title="Create New">
				<i class="fa fa-lg fa-fw fa-pencil-square-o"></i> Checklist
			</a>
		</li>
		
		<?php } ?>
		
		<?php if($user_type == 'kasir' || $user_type == 'administrator' || $user_type == 'markom' || $user_type == 'direksi' || $user_type == 'manager'){ ?>
		
		<li class="nav <?php if($body == 'voucher' && @$_GET['act']=='penjualan'){echo 'active';}?>">
			<a href="content.php?module=voucher&act=penjualan&page=penjualan-baru" title="Penjualan Voucher">
				<i class="fa fa-lg fa-fw fa-shopping-cart"></i> Penjualan Voucher
			</a>
		</li>
		
		<li class="nav <?php if($body == 'voucher' && @$_GET['act']=='transaksi'){echo 'active';}?>">
			<a href="content.php?module=voucher&act=transaksi&page=new-transaction" title="Transaksi Voucher">
				<i class="fa fa-lg fa-fw fa-file-text-o"></i> Transaksi Voucher
			</a>
		</li>
		
		<?php } ?>
		
		<?php if($user_type != 'markom' && $user_type != 'kasir') { ?>
		<li class="nav <?php if($body == 'request'){echo 'active';}?>">
			<a href="content.php?module=request" title="List request">
				<i class="fa fa-lg fa-fw fa-list-alt"></i> Request
			</a>
		</li>
		<?php } ?>
		
		<?php if($user_type == 'administrator' && $user_type != 'operator' && $user_type != 'markom' || $user_type == 'manager divisi' || $user_type == 'manager' || $user_type == 'direksi') { ?>
		<li class="nav <?php if($body == 'report'){echo 'active';}?>">
			<a href="report.php?div=it" title="Report">
				<i class="fa fa-lg fa-fw fa-print"></i> Report Checklist
			</a>
		</li>
		<?php } ?>
		
		<?php if($user_type == 'direksi' || $user_type == 'markom') { ?>
		
		<li class="nav-dropdown <?php if($body == 'voucher'){echo 'active';}?>">
			<a href="#" title="Maps">
				<i class="fa fa-lg fa-fw fa-file-text"></i> Management Voucher
			</a>
			<ul class="nav-sub">
				<li>
					<a href="content.php?module=voucher" title="Data Voucher Fisik">
						<i class="fa fa-lg fa-fw fa-file-text-o"></i> Data Voucher Fisik
					</a>
				</li>
				<li>
					<a href="content.php?module=evoucher&page=list" title="Data Voucher Elektrik">
						<i class="fa fa-lg fa-fw fa-file-text-o"></i> Data Voucher Elektrik
					</a>
				</li>
				<li>
					<a href="content.php?module=voucher&act=category" title="Voucher">
						<i class="fa fa-lg fa-fw fa-tag"></i> Voucher Category
					</a>
				</li>
			</ul>
		</li>
		
		<?php } ?>
		
		<li class="nav <?php if($body == 'change-password'){echo 'active';}?>">
			<a href="change-password.php" title="Change Password">
				<i class="fa fa-lg fa-fw fa-key"></i> Change Password
			</a>
		</li>
		
		<?php if($user_type == 'administrator'){ ?>
		<li class="nav <?php if($body == 'users'){echo 'active';}?>">
			<a href="users.php" title="Users">
				<i class="fa fa-lg fa-fw fa-user"></i> Users
			</a>
		</li>
		<?php } ?>		
		
		<?php if($user_type != 'operator' && $user_type != 'kasir' && $user_type !='leader' && $user_type !='staff adm' && $user_type !='purchasing'){ ?>
		<li class="nav <?php if($body == 'master'){echo 'active';}?>">
			<a href="content.php?module=master" title="master">
				<i class="fa fa-lg fa-fw fa-gears"></i> Master
			</a>
		</li>
		<?php } ?>
		
	</ul>
	<!--
	<h5 class="sidebar-header">Labels</h5>
	<ul class="nav nav-pills nav-stacked">
		<li>
			<a href="javascript:;">
				<i class="fa fa-fw fa-circle text-danger"></i>
				Important Tasks
			</a>
		</li>
		<li>
			<a href="javascript:;">
				<i class="fa fa-fw fa-circle text-success"></i>
				Support
			</a>
		</li>
		<li>
			<a href="javascript:;">
				<i class="fa fa-fw fa-circle text-info"></i>
				Quotes
			</a>
		</li>
	</ul>
	-->
	<!--
	<h5 class="sidebar-header">Summary</h5>
	
	<ul class="sidebar-summary">
		<li>
			<div class="mini-chart mini-chart-block">
				<div class="chart-details">
					<div class="chart-name">Total Sales</div>
					<div class="chart-value">$261,885</div>
				</div>
				<div id="mini-chart-sidebar-1" class="chart pull-right"></div>
			</div>
		</li>
		<li>
			<div class="mini-chart mini-chart-block">
				<div class="chart-details">
					<div class="chart-name">Total Customers</div>
					<div class="chart-value">12,491</div>
				</div>
				<div id="mini-chart-sidebar-2" class="chart pull-right"></div>
			</div>
		</li>
		<li>
			<div class="mini-chart mini-chart-block">
				<div class="chart-details">
					<div class="chart-name">Traffic</div>
					<div class="chart-value">945,013</div>
				</div>
				<div id="mini-chart-sidebar-3" class="chart pull-right"></div>
			</div>
		</li>
	</ul>
	-->
</nav>