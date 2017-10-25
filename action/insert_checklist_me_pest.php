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

		$id_item  = $_POST['id'];

		if(isset($_POST['spraying'])){
			$spraying = $_POST['spraying'];
		}else{
			$spraying = null;
		}
		if(isset($_POST['batting'])){
			$batting = $_POST['batting'];
		}else{
			$batting = null;
		} 
		if(isset($_POST['dusting'])){
			$dusting = $_POST['dusting'];
		}else{
			$dusting = null;
		} 
		if(isset($_POST['controling'])){
			$controling = $_POST['controling'];
		}else{
			$controling = null;
		} 
		
		$keterangan		= $_POST['keterangan'];
		$item = $db->item()->where("id", $id_item)->fetch();
		
		$user_id 	= $_SESSION['id'];
		$user		= $db->users()->where("id", $user_id)->fetch();
		$divisi 	= $item['divisi_id'];
		$branch 	= $user['branch_id'];
		
		$date_now	= date('Y-m-d');
		$time_now 	=  date('Y-m-d H:i:s');
		
		$cek_row = $db->item_checklist()
				->select("id, item_id, Convert(checked_at, Date) As tanggal")
				->where("item_id", $_POST['id'])
				->where("Convert(checked_at, Date)", $date_now);
		
		if (count($cek_row) > 0){
			
			$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-danger"><div class="danger">Data Checklist Sudah Ada</div></div>'));
			
			die($output);
			
		}else{
			
			$insert_checklist = $db->item_checklist()->insert(array(
				"item_id" => $id_item,
				"spraying" => $spraying,
				"batting" => $batting,
				"dusting" => $dusting,
				"controling" => $controling,
				"checked_at" => $time_now,
				"divisi_id" => '2',
				"branch_id" => $branch,
				"user_id" => $user_id,
				"description" => $keterangan
			));
			
			$insert_checklist->update();
			
			$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-success"><div class="danger">Data Berhasil Di Simpan</div></div>'));
			
			die($output);
		}
	}
}
?>