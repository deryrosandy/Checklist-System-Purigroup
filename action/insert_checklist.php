<?php
if(!isset($_SESSION)){
    session_start();
	
	include '../core/init.php';
	
	if(isset($_POST['submit'])){
		$time_now =  date('Y-m-d H:i:s');
		$user_id = $_SESSION['id'];
		$date_now = date('Y-m-d');
		
		$cek_row = $db->item_checklist()
				->select("id, item_id, Convert(checked_at, Date) As tanggal")
				->where("item_id", $_POST['id'])
				->where("Convert(checked_at, Date)", $date_now);
		
		if (count($cek_row) > 0){
			
			//$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-danger"><div class="danger">Data Checklist Sudah Ada</div></div>'));
			
			//die($output);
			
		}else{
		
			for($i=0;$i<count($_POST['id']);$i++){
				$id_item = $_POST['id'][$i];
				$status = $_POST['status'][$id_item];
				$keterangan = $_POST['keterangan'][$i];
		
				$insert_checklist = $db->item_checklist()->insert(array(
					"item_id" => $id_item,
					"item_status_id" => $status,
					"description" => $keterangan,
					"checked_at" => $time_now,
					"user_id" => $user_id
				));
				
				$insert_checklist->item_checklist();
			
			}
		}
	}
	
	header ('Location: ../checklist-it.php');
}
?>