<?php

	$vcrcategory = $db->voucher_category()
				->Order("created_at ASC");
?>

				
<div class="col-lg-8 col-md-10">
	<div class="tab-content panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-button-colors pull-left">
						<h1 style="padding-top:10px;" class="panel-title">List All Category Voucher</h1>
					</div>
					<div class="col-button-colors pull-right">
						<a href="content.php?module=voucher&act=add-category" style="margin-bottom: 0px;" class="btn btn-primary"><i class="fa fa-plus"></i> Add Category</a>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-body">
			<table id="table-basic" class="table table-item table-striped">
				<thead>
					<tr>
						<th class="no" style="width:30px">No.</th>
						<th style="" class="name">Name</th>
						<th class="">Description</th>
						<th style="" class="">Action</th>
					</tr>
				</thead>
				<tbody>
				<?php $no = 1; ?>
				
				<?php foreach ($vcrcategory as $cat){ ?>
					<tr class="odd gradeX">
						<td><?php echo $no; ?></td>
						<td><?php echo strtoupper($cat["name"]); ?></td>
						<td><?php echo ucfirst($cat['description']); ?></td>
						<td class="btn-group btn-group-box">
							<table>
								<tr>
									<td valign="top">
										<a href="content.php?module=voucher&act=edit-category&id=<?php echo $cat['id']; ?>" style="margin-right:3px;" class="btn btn-sm btn-info">Edit</a>
									</td>
									<td>
										<form method="post" action="action/delete_voucher_category.php?id=<?php echo $cat['id']; ?>" id="itemhapus<?php echo $vc['id']; ?>">
											<input type="submit" class="btn btn-sm btn-danger" value="Delete">
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
				<?php $no++ ?>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
