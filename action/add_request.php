<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])){
		header('location:login.php');
	}else{
		include '../core/init.php';
		include '../core/helper/myHelper.php';
		define ('PATH', realpath(dirname('../upload/')));
	
		$branch = $db->branch()
					->where("id", $_SESSION['branch_id'])
					->fetch();
		$user = $db->users()
					->where("id", $_SESSION['id'])
					->fetch();
		
		$title = ucwords($_POST['title']);
		$unit = $_POST['unit'];
		$kebutuhan = $_POST['kebutuhan'];
		$saldo_gudang = $_POST['saldo_gudang'];
		$purchase_request = $_POST['purchase_request'];
		$due_date = date('Y-m-d', strtotime($_POST['due_date']));
		$remark = ucfirst($_POST['remark']);
		
		$branch_id = $_SESSION['branch_id'];
		$divisi_id = $_POST['divisi_id'];
		$users_id = $_SESSION['id'];
		$created_at = date('Y-m-d H:i:s');
		
		$no_request = 'IRS' . strtoupper($user->branch['code']) . date('y') . date('m') . noreq();
			
		$targetDir 			= "upload/" . strtolower($branch['name'] . "/request/");
		$target_image 		= $targetDir . basename($_FILES['imagesRequest']['name']);
		$target_image_scan 	= $targetDir . basename($_FILES['imagesScan']['name']);
		
		$tmp_name 			= $_FILES['imagesRequest']['tmp_name'];
		$tmp_name_scan 		= $_FILES['imagesScan']['tmp_name'];
		$uploadOk 			= 1;
		$imageFileType 		= pathinfo($target_image,PATHINFO_EXTENSION);
		$imageScanFileType 	= pathinfo($target_image_scan,PATHINFO_EXTENSION);
		//Check Image
		
		if ($_FILES['imagesRequest']['name'] == '') {
			$insert_request = $db->request()->insert(array(
				"title" => $title,
				"unit" => $unit,
				"kebutuhan" => $kebutuhan,
				"noreq" => $no_request,
				"saldo_gudang" => $saldo_gudang,
				"purchase_request" => $purchase_request,
				"remark" => $remark,
				"due_date" => $due_date,
				"branch_id" => $branch_id,
				"photo" => null,
				"attachment" => $target_image_scan,
				"divisi_id" => $divisi_id,
				"users_id" => $users_id,
				"created_at" => $created_at
			));
		}elseif($_FILES['imagesScan']['name'] == ''){
			$insert_request = $db->request()->insert(array(
				"title" => $title,
				"unit" => $unit,
				"kebutuhan" => $kebutuhan,
				"noreq" => $no_request,
				"saldo_gudang" => $saldo_gudang,
				"purchase_request" => $purchase_request,
				"remark" => $remark,
				"due_date" => $due_date,
				"branch_id" => $branch_id,
				"photo" => $target_image,
				"attachment" => null,
				"divisi_id" => $divisi_id,
				"users_id" => $users_id,
				"created_at" => $created_at
			));
		}elseif(($_FILES['imagesScan']['name'] == '') && ($_FILES['imagesRequest']['name'] == '')){
			$insert_request = $db->request()->insert(array(
				"title" => $title,
				"unit" => $unit,
				"kebutuhan" => $kebutuhan,
				"noreq" => $no_request,
				"saldo_gudang" => $saldo_gudang,
				"purchase_request" => $purchase_request,
				"remark" => $remark,
				"due_date" => $due_date,
				"branch_id" => $branch_id,
				"photo" => null,
				"attachment" => null,
				"divisi_id" => $divisi_id,
				"users_id" => $users_id,
				"created_at" => $created_at
			));
		}else{
			$insert_request = $db->request()->insert(array(
				"title" => $title,
				"unit" => $unit,
				"kebutuhan" => $kebutuhan,
				"noreq" => $no_request,
				"saldo_gudang" => $saldo_gudang,
				"purchase_request" => $purchase_request,
				"remark" => $remark,
				"due_date" => $due_date,
				"branch_id" => $branch_id,
				"photo" => $target_image,
				"attachment" => $target_image_scan,
				"divisi_id" => $divisi_id,
				"users_id" => $users_id,
				"created_at" => $created_at
			));
		}
		
			
		$insert_request->request();
		
		move_uploaded_file($tmp_name, PATH . '/' . $target_image);
		move_uploaded_file($tmp_name_scan, PATH . '/' . $target_image_scan);
			
		header ('Location: ../content.php?module=request');	
	}
?>