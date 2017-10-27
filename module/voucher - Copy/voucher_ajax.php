<div class="container-fluid-md">
	<div class="panel panel-default">
	
		<div class="panel-heading">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-button-colors pull-left">
						<h1 style="padding-top:10px;" class="panel-title">List Voucher</h1>
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
				<div class="col-sm-2 pull-right">
					<select id="status_voucher" name="status_voucher" class="form-control form-chosen" data-placeholder="Choose Outlet...">
						<option value="active">Active</option>
						<option value="terpakai">Terpakai</option>
						<option value="expire">Expire</option>
					</select>
				</div>
				<!--<table id="list_voucher" class="table table-responsive table-hover table-striped" cellspacing="0" width="100%">-->
				<table id="list_voucher" class="display row-border nowrap table-striped responsive-utilities jambo_table" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Kode Voucher</th>
							<th>Barcode</th>
							<th>Nominal</th>
							<th>Tgl Aktif</th>
							<th>Expire</th>
							<th>Outlet</th>
							<th>Kategori</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			
			</div>
		</div>
	</div>
</div>