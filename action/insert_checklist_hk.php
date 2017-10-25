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
			
		$id_item 	= $_POST['id'];
		$kondisi 	= $_POST['kondisi'];
		$status 	= $_POST['status'];
		$fungsi	 	= $_POST['fungsi'];
		$keterangan = $_POST['keterangan'];
		$user_id 	= $_SESSION['id'];
		$item 		= $db->item()->where("id", $id_item)->fetch();
		$divisi_id = $item['divisi_id'];
		$branch_id 	= $_SESSION['branch_id'];
		$date_now	= date('Y-m-d');
		$time_now 	=  date('Y-m-d H:i:s');
		
		$cek_row = $db->item_checklist()
				->select("id, item_id, Convert(checked_at, Date) As tanggal")
				->where("item_id", $id_item)
				->where("branch_id", $branch_id)
				->where("Convert(checked_at, Date)", $date_now);
		
		if (count($cek_row) > 0){
			
			$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-danger"><div class="danger">Data Checklist Sudah Ada</div></div>'));
			
			die($output);
			
		}else{
		
			$insert_checklist = $db->item_checklist()->insert(array(
				"item_id" => $id_item,
				"item_status_id" => $kondisi,
				"item_kondisi_id" => $status,
				"checked_at" => $time_now,
				"divisi_id" => $divisi_id,
				"branch_id" => $branch_id,
				"user_id" => $user_id,
				"description" => $keterangan,
				"item_fungsi_id" => $fungsi,
			));
			
			$insert_checklist->update();
			
			$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-success"><div class="danger">Data Berhasil Di SImpan</div></div>'));
			
			die($output);
		}
	}
	
	//$insert_checklist->item_checklist();
}
?>