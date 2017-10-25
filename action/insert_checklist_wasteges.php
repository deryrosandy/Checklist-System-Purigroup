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
			
			$id_item		= $_POST['id'];
			$description 	= $_POST['description'];
			$comment		= $_POST['comment'];
			$user_id 		= $_SESSION['id'];
			$date_now		= date('Y-m-d');
			$time_now 		=  date('Y-m-d H:i:s');
			
			$divisi 	= $_SESSION['divisi_id'];
			$branch 	= $_SESSION['branch_id'];
			
			$cek_row = $db->checklist_buffet_wasteges()
				->select("id, item_wasteges_id, Convert(checked_at, Date) As tanggal")
				->where("item_wasteges_id", $id_item)
				->where("Convert(checked_at, Date)", $date_now);
		
			if (count($cek_row) > 0){
				
				$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-danger"><div class="danger">Data Checklist Sudah Ada</div></div>'));
				
				die($output);
				
			}else{
				
				$insert_checklist = $db->checklist_buffet_wasteges()->insert(array(
					"item_wasteges_id" => $id_item,
					"description" => $description,
					"comment" => $comment,
					"branch_id" => $branch,
					"description" => $description,
					"checked_at" => $time_now,
					"user_id" => $user_id
				));
				
			$insert_checklist->checklist_buffet_wasteges();

			$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-success"><div class="success">Data Berhasil Di Simpan</div></div>'));
			
			die($output);
		}
	}
}

?>