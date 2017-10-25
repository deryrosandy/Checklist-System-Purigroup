<?php
	$id_req = $_GET['id'];
	
	$request = $db->request()
				->Where("id", $id_req)
				->fetch();
				
?>

<div class="container-fluid-md">
	<form id="requestAddForm" action="action/update_request.php" name="form-tambah-pengguna"  enctype='multipart/form-data' method="POST" class="form-horizontal form-bordered" role="form">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-button-colors pull-left">
							<h1 style="padding-top:10px;" class="panel-title">Edit Request</h1>
						</div>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="control-label col-sm-3">Title</label>
					<div class="controls col-sm-6">
						<input type="text" name="title" value="<?php echo $request['title']; ?>" class="form-control required" title="Title" placeholder="Insert Title">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Unit</label>
					<div class="controls col-sm-6">
						<input type="text" name="unit" value="<?php echo $request['unit']; ?>" class="form-control required" title="Unit" placeholder="Insert Unit">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Kebutuhan</label>
					<div class="controls col-sm-6">
						<input type="number" name="kebutuhan" value="<?php echo $request['kebutuhan']; ?>" class="form-control required" title="Kebutuhan" placeholder="Insert Kebutuhan">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Saldo Gudang</label>
					<div class="controls col-sm-6">
						<input type="number"  value="<?php echo $request['saldo_gudang']; ?>" name="saldo_gudang" class="form-control required" title="Saldo Gudang" placeholder="Insert Saldo Gudang">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Purchase Request</label>
					<div class="controls col-sm-6">
						<input type="text" name="purchase_request" value="<?php echo $request['purchase_request']; ?>" class="form-control required" title="Purchase Request" placeholder="Insert Purchase Request">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Tanggal Dibutuhkan</label>
					<div class="controls col-sm-6">
						<input type="text" value="<?php echo tgl_short_slash($request["due_date"]); ?>" name="due_date" placeholder="Tanggal Dibutuhkan" class="form-control required" title="Field Required"  data-rel="datepicker"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Divisi</label>
					<?php $divisi = $db->divisi(); ?>
					<div class="col-sm-6">
						<select name="divisi_id" class="form-control form-chosen" data-placeholder="Choose User Level...">
						<?php foreach ($divisi as $div){ ?>
							<option <?php echo ($div['id'] == $request['divisi_id']) ? 'selected' : ''; ?> value="<?php echo $div['id']; ?>"><?php echo $div['name']; ?></option>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Remark</label>
					<div class="controls col-sm-6">
						<textarea name="remark" class="form-control required" rows="4" title="Remark" placeholder="Insert Remark/Description"><?php echo ucfirst($request['remark']); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Insert Photo (Optional)</label>
					<div class="controls col-sm-6">
						<input type="file" name="imagesRequest" id="imagesRequest">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Photo Scan Penawaran (Optional)</label>
					<div class="controls col-sm-6">
						<!--<input type="file" name="imagesRequest" id="imagesRequest" class="images" accept="">-->
						<input type="file" name="imagesScan" id="imagesScan">
					</div>
				</div>
				<div class="form-group">
					<div class="controls col-sm-6 col-sm-offset-2">
						<button type="submit" class="btn btn-primary">Submit</button>&nbsp;&nbsp;&nbsp;
						<input type="hidden" name="id" value="<?php echo $request['id']; ?>"/>
						<a href="content.php?module=request" class="btn btn-primary">Cancel</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>