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
					
		$id = $_POST['id'];
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
		
		$targetDir 			= "upload/" . strtolower($branch['name'] . "/request/");
		$target_image 		= $targetDir . basename($_FILES['imagesRequest']['name']);
		$target_image_scan 	= $targetDir . basename($_FILES['imagesScan']['name']);
		
		$tmp_name = $_FILES['imagesRequest']['tmp_name'];
		$tmp_name_scan = $_FILES['imagesScan']['tmp_name'];
		$uploadOk = 1;
		$imageFileType = pathinfo($target_image,PATHINFO_EXTENSION);
		$imageScanFileType = pathinfo($target_image_scan,PATHINFO_EXTENSION);
		//Check Image
		
		$request = $db->request[$id];
		
		if ($request){
			
			if ($_FILES['imagesRequest']['name'] == '') {
				$data = array(
						"title" => $title,
						"unit" => $unit,
						"kebutuhan" => $kebutuhan,
						"saldo_gudang" => $saldo_gudang,
						"purchase_request" => $purchase_request,
						"remark" => $remark,
						"due_date" => $due_date,
						"divisi_id" => $divisi_id,
						"users_id" => $users_id,
						"attachment" => $target_image_scan
					);
				}else{
					$data = array(
						"title" => $title,
						"unit" => $unit,
						"kebutuhan" => $kebutuhan,
						"saldo_gudang" => $saldo_gudang,
						"purchase_request" => $purchase_request,
						"remark" => $remark,
						"due_date" => $due_date,
						"divisi_id" => $divisi_id,
						"users_id" => $users_id,
						"photo" => $target_image,
						"attachment" => $target_image_scan,
					);
				}
				
				$result = $request->update($data);
				move_uploaded_file($tmp_name, PATH . '/' . $target_image);
				move_uploaded_file($tmp_name_scan, PATH . '/' . $target_image_scan);
				//var_dump(move_uploaded_file($tmp_name, PATH . $target_image));
				//die();
		}
		
		header ('Location: ../content.php?module=request');
	}
?>