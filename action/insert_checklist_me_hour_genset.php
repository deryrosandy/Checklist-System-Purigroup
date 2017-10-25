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
		
		$item_area_id 		= $_POST['id'];
		$date_hour			=  date('Y-m-d', strtotime($_POST['date_hour']));
		$start_hour_meter 	= $_POST['hour_meter_awal'];
		$after_hour_meter 	= $_POST['hour_meter_akhir'];
		
		$user_id 	= $_SESSION['id'];
		$divisi 	= $_SESSION['divisi_id'];
		$branch 	= $_SESSION['branch_id'];
				
		$date_now	= date('Y-m-d');
		$time_now 	=  date('Y-m-d H:i:s');
			
		$insert_checklist = $db->hour_meter_genset()->insert(array(
			"date_hour" => $date_hour,
			"start_hour_meter" => $start_hour_meter,
			"after_hour_meter" => $after_hour_meter,
			"branch_id" => $branch,
			"item_area_id" => $item_area_id,
			"user_id" => $user_id,
			"created_at" => $time_now,
		));
		
		$insert_checklist->update();
		
		$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-success"><div class="danger">Data Berhasil Di Simpan</div></div>'));
		
		die($output);
	}
}
?>