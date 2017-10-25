<div class="container-fluid-md">
	<form id="requestAddForm" action="action/add_request.php" name="form-tambah-pengguna"  enctype='multipart/form-data' method="POST" class="form-horizontal form-bordered" role="form">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-button-colors pull-left">
							<h1 style="padding-top:10px;" class="panel-title">Add Request</h1>
						</div>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="control-label col-sm-3">Title</label>
					<div class="controls col-sm-6">
						<input type="text" name="title" class="form-control required" title="Title" placeholder="Insert Title">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Unit</label>
					<div class="controls col-sm-6">
						<input type="text" name="unit" class="form-control required" title="Unit" placeholder="Insert Unit">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Kebutuhan</label>
					<div class="controls col-sm-6">
						<input type="number" name="kebutuhan" class="form-control required" title="Kebutuhan" placeholder="Insert Kebutuhan">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Saldo Gudang</label>
					<div class="controls col-sm-6">
						<input type="number" name="saldo_gudang" class="form-control required" title="Saldo Gudang" placeholder="Insert Saldo Gudang">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Purchase Request</label>
					<div class="controls col-sm-6">
						<input type="text" name="purchase_request" class="form-control" title="Purchase Request" placeholder="Insert Purchase Request">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Tanggal Dibutuhkan</label>
					<div class="controls col-sm-6">
						<input type="text" name="due_date" placeholder="Tanggal Dibutuhkan" class="form-control required" title="Field Required"  data-rel="datepicker"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Divisi</label>
					<?php $divisi = $db->divisi(); ?>
					<div class="col-sm-6">
						<select name="divisi_id" class="form-control form-chosen" data-placeholder="Choose Divisi...">
						<?php foreach ($divisi as $div){ ?>
							<option value="<?php echo $div['id']; ?>"><?php echo $div['name']; ?></option>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Remark</label>
					<div class="controls col-sm-6">
						<textarea name="remark" class="form-control required" rows="4" title="Remark" placeholder="Insert Remark/Description"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Photo Barang (Optional)</label>
					<div class="controls col-sm-6">
						<!--<input type="file" name="imagesRequest" id="imagesRequest" class="images" accept="">-->
						<input type="file" name="imagesRequest" id="imagesRequest">
						<!--
						<a href="javascript:void(0);" data-id="1" class="ImgUpload btn btn-info" data-style="primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Click to Upload Photo!">
							<i class="fa fa-image"></i>
						</a>
						-->
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
						<button type="reset" class="btn btn-primary">Reset</button>
					</div>
				</div>
				<div id="" class="modalUpload modal fade in" data-backdrop="static">
					<div class="modal-dialog">
						<div id="" class="modal-content">
							<div class="modal-body">
								<div class="modal-title">
									<ul class="nav nav-pills" id="ImgTab">
										<li class="active">
										</li>
									</ul>
								</div>
								<div id="" class="content tab-content">
									<div class="uploadContainer" id="uploadContainer">
										<form method="post" name="multiple_upload_form" class="multiple_upload_form" enctype="multipart/form-data" action="action/upload_images.php">
											<label>Choose Image</label>
											<input type="file" name="images[]" class="images" multiple >
										</form>
									</div>
									<div class="gallery" id="images_preview" style="margin-top:20px;"></div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary close-modal">Done</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>