<?php
	$id_cat = $_GET['id'];
	
	$cat = $db->voucher_category()
				->Where("id", $id_cat)
				->fetch();
				
?>

<div class="col-lg-8 col-md-10">
	<div class="tab-content panel panel-default">
		<form id="requestAddForm" action="action/update_voucher_category.php" name="form-tambah-pengguna"  enctype='multipart/form-data' method="POST" class="form-horizontal form-bordered" role="form">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-button-colors pull-left">
								<h1 style="padding-top:10px;" class="panel-title">Edit Voucher Category</h1>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="control-label col-sm-3">Name</label>
						<div class="controls col-sm-6">
							<input type="text" value="<?php echo $cat['name']; ?>" name="name" class="form-control required" title="Name" placeholder="Insert Name">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3">Description</label>
						<div class="controls col-sm-6">
							<textarea name="description" class="form-control required" title="Description" rows="2" placeholder="Insert Description"><?php echo $cat['description']; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="controls col-sm-6 col-sm-offset-2">
							<input type="hidden" value="<?php echo $cat['id']; ?>" name="id" class="form-control required" title="Name" placeholder="Insert Name">
							<button type="submit" class="btn btn-primary">Submit</button>&nbsp;&nbsp;&nbsp;
							<a href="content.php?module=voucher&act=category" class="btn btn-danger">Cancel</a>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>