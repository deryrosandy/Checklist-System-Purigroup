<?php
if(!isset($_SESSION)){
    session_start();
	
	include '../core/init.php';

	if(isset($_POST['submit'])){
		$time_now =  date('Y-m-d H:i:s');
		$user_id = $_SESSION['id'];
		$id = $_POST['id'];
		
		for($i=0;$i<count($id);$i++){
			$id_checklist = $id[$i];
			//$status = $_POST['status'][$id_item];
			//$keterangan = $_POST['keterangan'][$i];
			$confirm_all = $db->item_checklist()->insert_update(
				array("id" => $id_checklist),
				array("time_approve" => $time_now),
				array("status_approve" => '1')
			);
			var_dump ($confirm_all);
		}
	}
	//die();
	header ('Location: ../lihat-checklist-it.php');
}
?>