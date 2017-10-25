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
		
		$csv_file = $_FILES['file_csv']['tmp_name'];
		
		if (($handle = fopen($csv_file, "r")) !== FALSE) {
		   fgetcsv($handle);   
		   while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($data);
				for ($c=0; $c < $num; $c++) {
				  $col[$c] = $data[$c];
				}

				$barcode 				= $col[1];
				$code 					= $col[2];
				$branch_id 				= $col[3];
				$voucher_category_id 	= $col[4];
				$nominal 				= $col[5];
				
				$year 			= '20' . substr($col[6], -2);
				$month 			= substr($col[6], -5, 2);
				$date 			= substr($col[6], -8, 2);
				
				$yearexp 		= '20' . substr($col[7], -2);
				$monthexp 		= substr($col[7], -5, 2);
				$dateexp 		= substr($col[7], -8, 2);
				
				$active_date = date('Y-m-d', strtotime($year . '/' . $month . '/' . $date));
				$expire_date = date('Y-m-d', strtotime($yearexp . '/' . $monthexp . '/' . $dateexp));
				
				$users_id 				= $_SESSION['id'];
				$created_at 			= date('Y-m-d H:i:s');
				
				$insert_voucher = $db->voucher()->insert(array(
					"code" => $code,
					"barcode" => $barcode,
					"voucher_category_id" => $voucher_category_id,
					"nominal" => $nominal,
					"active_date" => $active_date,
					"expire_date" => $expire_date,
					"branch_id" => $branch_id,
					"users_id" => $users_id,
					"created_at" => $created_at
				));
				
				$insert_voucher->voucher();
			}
			
			fclose($handle);	
		
		}
		
		echo "<button id='btnShowAlert' style='display:none;'></button>
			<script type='text/javascript'>
			sweetAlert({
					title: 'Sukses!',
					text: 'Berhasil!',
					type: 'success'
				},
				function () {
					window.location.href = '../content.php?module=voucher';
				});
			</script>";
		exit();	
	}
?>