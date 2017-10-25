<?php
if(!isset($_SESSION)){
    session_start();
	
	include '../core/init.php';
	$user_id 	= $_SESSION['id'];
	
	if($_POST){
		//check if its an ajax request, exit if not
		
		if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
			
			$output = json_encode(array( //create JSON data
				'type'=>'error', 
				'text' => 'Sorry Request must be Ajax POST'
			));
			die($output); //exit script outputting json data
		}

		$id_item 				= $_POST['id'];
		$bc_opening_status 		= $_POST['bc_opening_status'];
		$bc_opening_keterangan 	= $_POST['bc_opening_keterangan'];
		$bc_closing_status		= $_POST['bc_closing_status'];
		$bc_closing_keterangan	= $_POST['bc_closing_keterangan'];
				
		$user_id 	= $_SESSION['id'];
		$divisi 	= $_SESSION['divisi_id'];
		$branch 	= $_SESSION['branch_id'];

		$date_now	= date('Y-m-d');
		$time_now 	= date('Y-m-d H:i:s');

		$cek_row = $db->item_checklist()
				->select("id, item_id, Convert(checked_at, Date) As tanggal")
				->where("item_id", $_POST['id'])
				->where("Convert(checked_at, Date)", $date_now);

		if (count($cek_row) > 0){

			$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-danger"><div class="danger">Data Checklist Sudah Ada</div></div>'));
			
			die($output);

		}else{
		
			$insert_checklist = $db->item_checklist()->insert(array(
				"item_id" 					=> $id_item,
				"checked_at" 				=> $time_now,
				"divisi_id" 				=> '5',
				"branch_id" 				=> $branch,
				"user_id" 					=> $user_id,
				"bc_opening_status" 		=> $bc_opening_status,
				"bc_opening_keterangan" 	=> $bc_opening_keterangan,
				"bc_closing_status" 		=> $bc_closing_status,
				"bc_closing_keterangan" 	=> $bc_closing_keterangan
			));
			
			$insert_checklist->update();
			
			$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-success"><div class="danger">Data Berhasil Di Simpan</div></div>'));
			
			die($output);
		}
	}
	
	//$insert_checklist->item_checklist();
}
?>