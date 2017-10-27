<?php
	$id_vc = $_GET['id'];
	
	$voucher = $db->voucher()
				->Where("id", $id_vc)
				->fetch();
				
?>

<div class="container-fluid-md">
	<form id="requestAddForm" action="action/update_evoucher.php" name="form-tambah-pengguna"  enctype='multipart/form-data' method="POST" class="form-horizontal form-bordered" role="form">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-button-colors pull-left">
							<h1 style="padding-top:10px;" class="panel-title">Edit Voucher</h1>
						</div>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="control-label col-sm-3">Code Voucher</label>
					<div class="controls col-sm-6">
						<input type="text" value="<?php echo $voucher['code']; ?>" name="code" class="form-control required" title="Code Voucher" placeholder="Insert Code Voucher">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Barcode</label>
					<div class="controls col-sm-6">
						<input type="text" value="<?php echo $voucher['barcode']; ?>" name="barcode" class="form-control required" title="Barcode" placeholder="Scan Barcode">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Outlet</label>
					<?php $branch = $db->branch(); ?>
					<div class="col-sm-6">
						<select name="branch_id" class="form-control form-chosen" data-placeholder="Choose Outlet...">
						<option>- Choose Outlet -</option>
						<option value="0">All Outlet</option>
						<?php foreach ($branch as $brc){ ?>
							<option <?php echo ($brc['id'] == $voucher['branch_id']) ? 'selected' : ''; ?> value="<?php echo $brc['id']; ?>"><?php echo $brc['name']; ?></option>
						<?php } ?>
						
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Category</label>
					<?php $voucher_category = $db->voucher_category(); ?>
					<div class="col-sm-6">
						<select name="voucher_category_id" class="form-control form-chosen" data-placeholder="Choose Category...">
						<?php foreach ($voucher_category as $vccat){ ?>
							<option <?php echo ($vccat['id'] == $voucher['voucher_category_id']) ? 'selected' : ''; ?> value="<?php echo $vccat['id']; ?>"><?php echo $vccat['name']; ?></option>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Nominal</label>
					<div class="controls col-sm-6">
						<input type="number" value="<?php echo $voucher['nominal']; ?>" name="nominal" class="form-control required" title="Nominal" placeholder="Insert Nominal">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Tanggal Aktif</label>
					<div class="controls col-sm-6">
						<input type="text" value="<?php echo tgl_short_slash($voucher["active_date"]); ?>" name="active_date" placeholder="Tanggal Aktif Voucher" class="form-control required" title="Tanggal Aktif Voucher"  data-rel="datepicker"/>						
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Tanggal Expire</label>
					<div class="controls col-sm-6">
						<input type="text" name="expire_date"  value="<?php echo tgl_short_slash($voucher["expire_date"]); ?>"  placeholder="Tanggal Aktif Expire" class="form-control required" title="Tanggal Expire Voucher"  data-rel="datepicker"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Status</label>
					
					<div class="controls col-sm-6" style="margin-top: 8px;">
						<select name="status" class="form-control form-chosen" data-placeholder="Choose Category...">						
							<option <?php echo ($voucher['status']=='ACTIVE') ? 'selected' : ''; ?> value="ACTIVE">ACTIVE</option>
							<option <?php echo ($voucher['status']=='EXPIRED') ? 'selected' : ''; ?> value="ACTIVE">EXPIRED</option>
							<option <?php echo ($voucher['status']=='TERPAKAI') ? 'selected' : ''; ?> value="ACTIVE">TERPAKAI</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="controls col-sm-6 col-sm-offset-2">
						<input type="hidden" name="id" value="<?php echo $voucher['id']; ?>"/>
						<button type="submit" class="btn btn-primary">Submit</button>&nbsp;&nbsp;&nbsp;
						<a href="content.php?module=evoucher&page=list" class="btn btn-danger">Cancel</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>