<?php
	
if(!isset($_SESSION)){
	session_start();

	include '../core/init.php';
	include '../core/helper/myHelper.php';	 
	include 'alert/alert.php';
	
	$id = $_GET['id'];

	$voucher = $db->voucher()->where("id", $id)->fetch();
	$delete = $voucher->delete();
	
	if($delete){
		echo "<button id='btnShowAlert' style='display:none;'></button>
				<script type='text/javascript'>
				sweetAlert({
						title: 'Sukses!',
						text: 'Voucher Berhasil Di Hapus!',
						type: 'success'
					},
					function () {
						window.location.href = '../content.php?module=voucher';
					});
				</script>";
		exit();		
	}
}
	
?>