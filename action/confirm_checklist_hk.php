<?php
if(!isset($_SESSION)){
    session_start();
	
	include '../core/init.php';
	$user_id 	= $_SESSION['id'];
	//var_dump ($user_id);
	
	if($_POST){
		//check if its an ajax request, exit if not
		
		if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
			
			$output = json_encode(array( //create JSON data
				'type'=>'error', 
				'text' => 'Sorry Request must be Ajax POST'
			));
			die($output); //exit script outputting json data
		}
			
			$id_checklist 	= $_POST['id'];
			/*
			$status 		= $_POST['status'];
			$kondisi 		= $_POST['kondisi'];
			
			$fungsi	 		= $_POST['fungsi'];
			
			$keterangan 	= $_POST['keterangan'];
			*/
			
			$user_id 		= $_SESSION['id'];
			$date_now		= date('Y-m-d');
			$time_now 		=  date('Y-m-d H:i:s');
			
			$checklist = $db->item_checklist[$id_checklist];
					
			if ($checklist) {
				
				$data = array(
					"id" => $id_checklist,
					/*
					"item_status_id" => $status,
					"item_kondisi_id" => $kondisi,
					"item_fungsi_id" => $fungsi,
					*/
					"status_approve" => '1',
					"user_approve" => $user_id,
					"time_approve" => $time_now,
				);
				
				$result = $checklist->update($data);
				
			}

			$output = json_encode(array('type'=>'message', 'text' => ' Data Berhasil Di Simpan'));
			
			die($output);
			
	}
}

?>