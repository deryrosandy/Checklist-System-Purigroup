<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])){
		header('location:login.php');
	}else{
		include '../core/init.php';
		include '../core/helper/myHelper.php';
		include 'alert/alert.php';
	
		$branch = $db->branch()
					->where("id", $_SESSION['branch_id'])
					->fetch();
		$user = $db->users()
					->where("id", $_SESSION['id'])
					->fetch();
		
		$id = $_POST['id'];
		
		$code 					= strtoupper($_POST['code']);
		$barcode 				= strtoupper($_POST['barcode']);
		$branch_id 				= $_POST['branch_id'];
		$voucher_category_id 	= $_POST['voucher_category_id'];
		$nominal 				= $_POST['nominal'];
		
		$active_date = date('Y-m-d', strtotime($_POST['active_date']));
		$expire_date = date('Y-m-d', strtotime($_POST['expire_date']));
		
		$users_id = $_SESSION['id'];
		$created_at = date('Y-m-d H:i:s');
		
		$voucher = $db->voucher[$id];
		
		if ($voucher){
			
			$data = array(
					"code" => $code,
					"barcode" => $barcode,
					"voucher_category_id" => $voucher_category_id,
					"nominal" => $nominal,
					"active_date" => $active_date,
					"expire_date" => $expire_date,
					"branch_id" => $branch_id,
					"users_id" => $users_id,
				);
		}
		
		$result = $voucher->update($data);
		
		echo "<button id='btnShowAlert' style='display:none;'></button>
				<script type='text/javascript'>
				sweetAlert({
						title: 'Sukses!',
						text: 'Voucher Berhasil Di Edit!',
						type: 'success'
					},
					function () {
						window.location.href = '../content.php?module=voucher';
					});
				</script>";
		exit();	
	}
?>