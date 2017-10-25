<?php
if(!isset($_SESSION)){
    
	session_start();
	
	include '../core/init.php';
	include '../core/helper/myHelper.php';
	
	//$action = $_POST["action"];
	
	$id = $_POST["id"];
	$time_now =  date('Y-m-d H:i:s');
	$status = $_POST['kondisi'];
	
	$item_checklist = $db->item_checklist[$id];
	
	if ($item_checklist){
		$data = array(
			"id" => $id,
			"item_status" => '1',
			"status_approve" => '1',
			"time_approve" => $time_now
		);
		
		$result = $item_checklist->update($data);
	}
	
	//$item_checklist = $db->item_checklist[$id];

	header ('Location: ../lihat-checklist-it.php');
}
?>