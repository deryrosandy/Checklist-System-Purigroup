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
		
		$name 			= ucwords($_POST['name']);
		$description 	= ucwords($_POST['description']);
		
		$cat_voucher = $db->voucher_category[$id];
		
		if ($cat_voucher){
			
			$data = array(
					"name" => $name,
					"description" => $description,
				);
		}
		
		$result = $cat_voucher->update($data);
		
		echo "<button id='btnShowAlert' style='display:none;'></button>
				<script type='text/javascript'>
				sweetAlert({
						title: 'Sukses!',
						text: 'Category Berhasil Di Edit!',
						type: 'success'
					},
					function () {
						window.location.href = '../content.php?module=voucher&act=category';
					});
				</script>";
		exit();	
	}
?>