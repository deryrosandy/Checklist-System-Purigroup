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
		
		$customer_name 	= ucwords($_POST['customer_name']);
		$voucher_id 	= $_POST['voucher_id'];
		$branch_id 		= $_SESSION['branch_id'];
		$users_id 		= $_SESSION['id'];
		$active_date = date('Y-m-d H:i:s');
		
		$expire_date = date('Y-m-d H:i:s', strtotime('+4 month'));
		
		$created_at = date('Y-m-d H:i:s');
		
		$insert_vcr_penjualan = $db->voucher_penjualan()->insert(array(
			"customer_name" => $customer_name,
			"voucher_id"	=> $voucher_id,
			"branch_id" 	=> $branch_id,
			"users_id" 		=> $users_id,
			"active_date" 	=> $active_date,
			"expire_date" 	=> $expire_date,
			"created_at" 	=> $created_at
		));
		
		$insert_vcr_penjualan->voucher_penjualan();
		
		$voucher = $db->voucher[$voucher_id];
		
		if ($voucher){
			
			$data1 = array(
					"status" => 'NON ACTIVE',
					"active_date" 	=> $active_date,
					"expire_date" 	=> $expire_date
				);
				
			$data = array(
					"status" => 'ACTIVE',
					"active_date" 	=> $active_date,
					"expire_date" 	=> $expire_date
				);
		}
		
		$result_after = $voucher->update($data1);
		$result = $voucher->update($data);
		
		if($result){
		
			echo "<button id='btnShowAlert' style='display:none;'></button>
					<script type='text/javascript'>
					sweetAlert({
							title: 'Sukses!',
							text: 'Voucher Berhasil Di Aktifkan!',
							type: 'success'
						},
						function () {
							window.location.href = '../content.php?module=voucher&act=penjualan&page=penjualan-baru';
						});
					</script>";
			exit();		
		}
	}
?>