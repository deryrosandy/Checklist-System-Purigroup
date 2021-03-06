<div class="container-fluid-md">
	<form id="requestAddForm" action="action/add_voucher.php" name="form-tambah-pengguna"  enctype='multipart/form-data' method="POST" class="form-horizontal form-bordered" role="form">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-button-colors pull-left">
							<h1 style="padding-top:10px;" class="panel-title">Add Voucher</h1>
						</div>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="control-label col-sm-3">Code Voucher</label>
					<div class="controls col-sm-6">
						<input type="text" name="code" class="form-control required" title="Code Voucher" placeholder="Insert Code Voucher">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Barcode</label>
					<div class="controls col-sm-6">
						<input type="text" name="barcode" class="form-control required" title="Barcode" placeholder="Scan Barcode">
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
							<option value="<?php echo $brc['id']; ?>"><?php echo $brc['name']; ?></option>
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
							<option value="<?php echo $vccat['id']; ?>"><?php echo $vccat['name']; ?></option>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Nilai Point</label>
					<div class="controls col-sm-6">
						<input type="number" name="nominal" class="form-control required" title="Nominal" placeholder="Insert Nominal">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Tanggal Aktif</label>
					<div class="controls col-sm-6">
						<input type="text" name="active_date" placeholder="Tanggal Aktif Voucher" class="form-control required" title="Tanggal Aktif Voucher"  data-rel="datepicker"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Tanggal Expire</label>
					<div class="controls col-sm-6">
						<input type="text" name="expire_date" placeholder="Tanggal Aktif Expire" class="form-control required" title="Tanggal Expire Voucher"  data-rel="datepicker"/>
					</div>
				</div>
				<div class="form-group">
					<div class="controls col-sm-6 col-sm-offset-2">
						<button type="submit" class="btn btn-primary">Submit</button>&nbsp;&nbsp;&nbsp;
						<a href="content.php?module=voucher" class="btn btn-danger">Cancel</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>