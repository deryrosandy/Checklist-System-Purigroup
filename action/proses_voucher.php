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
		$voucher_type 	= $_POST['voucher_type'];
		$nominal 		= $_POST['nominal'];
		$branch_id 		= $_SESSION['branch_id'];
		$users_id 		= $_SESSION['id'];
		$created_at = date('Y-m-d H:i:s');
		//var_dump($voucher_type); die();
		$insert_vcr_history = $db->voucher_history()->insert(array(
			"customer_name" => $customer_name,
			"voucher_id"	=> $voucher_id,
			"branch_id" 	=> $branch_id,
			"users_id" 		=> $users_id,
			"created_at" 	=> $created_at
		));
		
		$insert_vcr_history->voucher_history();
		
		$voucher = $db->voucher[$voucher_id];
		
		if ($voucher){
			
			$data = array(
					"status" => 'TERPAKAI'
				);
		}
		
		$result = $voucher->update($data);
			
		if($result){
			
			if($voucher_type=='ELEKTRIK'):
			
				echo "<html>
						<head>
						 <title>JavaScript Popup Example 3</title>
						</head>
						<script type='text/javascript'>
						function poponload()
						{
							var popup = window.open('about:blank", "_blank');
							popup.location = '../print-payment-voucher.php?&voucher_id=$voucher_id&customer_name=$customer_name';
						}
						</script>
						<body onload='javascript: poponload()'>
						</body>
					</html>";
				exit();
			
			else:
			
				echo "<button id='btnShowAlert' style='display:none;'></button>
						<script type='text/javascript'>
						sweetAlert({
								title: 'Sukses!',
								text: 'Voucher Berhasil Di Gunakan!',
								type: 'success'
							},
							function () {
								window.location.href = '../content.php?module=voucher&act=transaksi&page=history-transaction';
							});
						</script>";
				exit(); 
			
			endif;
		}
	}
?>