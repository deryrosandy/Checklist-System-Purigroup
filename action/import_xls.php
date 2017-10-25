<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])){
		header('location:login.php');
	}else{
		include '../core/init.php';
		include '../core/PHPExcel/PHPExcel.php';		
		include '../core/helper/myHelper.php';		
		include 'alert/alert.php';		
	
		$branch = $db->branch()
					->where("id", $_SESSION['branch_id'])
					->fetch();
		$user = $db->users()
					->where("id", $_SESSION['id'])
					->fetch();
		
		//$csv_file = $_FILES['file_csv']['tmp_name'];
		$xls_file = $_FILES['file_xls']['tmp_name'];
		
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load($xls_file); // Load file excel yang tadi diupload ke folder tmp
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		
		$numrow = 1;
		foreach($sheet as $row){
			$barcode 				= $row['A'];
			$code 					= $row['B'];
			$branch_id 				= $row['C'];
			$voucher_category_id 	= $row['D'];
			$nominal 				= $row['E'];
			
			$year 			= '20' . substr($row['F'], -2);
			$month 			= substr($row['F'], -5, 2);
			$date 			= substr($row['F'], -8, 2);
			
			$yearexp 		= '20' . substr($row['G'], -2);
			$monthexp 		= substr($row['G'], -5, 2);
			$dateexp 		= substr($row['G'], -8, 2);
			
			$active_date = date('Y-m-d', strtotime($year . '/' . $month . '/' . $date));
			$expire_date = date('Y-m-d', strtotime($yearexp . '/' . $monthexp . '/' . $dateexp));
			
			$users_id 				= $_SESSION['id'];
			$created_at 			= date('Y-m-d H:i:s');
			
			
			if($numrow > 1){
				//echo($active_date); die();
				$insert_voucher = $db->voucher()->insert(array(
					"code" => strval($code),
					"barcode" => strval($barcode),
					"voucher_category_id" => $voucher_category_id,
					"nominal" => strval($nominal),
					"active_date" => $active_date,
					"expire_date" => $expire_date,
					"branch_id" => $branch_id,
					"users_id" => $users_id,
					"created_at" => $created_at
				));
				
				$insert_voucher->voucher();
			}
			$numrow++;
			
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