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
		
		$name 			= ucwords($_POST['name']);
		$description 	= ucwords($_POST['description']);
		$created_at 	= date('Y-m-d H:i:s');
		
		$insert_cat = $db->voucher_category()->insert(array(
			"name" => $name,
			"description" => $description,
			"created_at" => $created_at
		));
		
		if ($insert_cat->voucher_category()){
			
			echo "<button id='btnShowAlert' style='display:none;'></button>
				<script type='text/javascript'>
				sweetAlert({
						title: 'Sukses!',
						text: 'Berhasil!',
						type: 'success'
					},
					function () {
						window.location.href = '../content.php?module=voucher&act=category';
					});
				</script>";
			exit();	
		}
	}
?>