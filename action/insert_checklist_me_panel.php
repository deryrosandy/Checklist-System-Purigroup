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
		
		$id_item 		= $_POST['id'];
		$tegangan_r 	= $_POST['tegangan_r'];
		$tegangan_s 	= $_POST['tegangan_s'];
		$tegangan_t 	= $_POST['tegangan_t'];
		$arus_r		 	= $_POST['arus_r'];
		$arus_s		 	= $_POST['arus_s'];
		$arus_t		 	= $_POST['arus_t'];
		$kondisi		= $_POST['kondisi'];
		$fungsi			= $_POST['fungsi'];
		$keterangan 	= $_POST['keterangan'];
		
		if(isset($_POST['koneksi'])){
			$koneksi = $_POST['koneksi'];
		}else{
			$koneksi = null;
		}
		
		if(isset($_POST['wiring'])){
			$wiring = $_POST['wiring'];
		}else{
			$wiring = null;
		}
		
		$user_id 	= $_SESSION['id'];
		$divisi 	= $_SESSION['divisi_id'];
		$branch 	= $_SESSION['branch_id'];
		
		$date_now	= date('Y-m-d');
		$time_now 	=  date('Y-m-d H:i:s');
		
		$cek_row = $db->item_checklist()
				->select("id, item_id, Convert(checked_at, Date) As tanggal")
				->where("item_id", $_POST['id'])
				->where("branch_id", $branch)
				->where("Convert(checked_at, Date)", $date_now);
		
		echo $cek_row;
		//die();
		
		if (count($cek_row) > 0){
			
			$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-danger"><div class="danger">Data Checklist Sudah Ada</div></div>'));
			
			die($output);
			
		}else{
			
			$insert_checklist = $db->item_checklist()->insert(["item_id" => $id_item,
				"tegangan_r" => $tegangan_r,
				"tegangan_s" => $tegangan_s,
				"tegangan_t" => $tegangan_t,
				"arus_r" => $arus_r,
				"arus_s" => $arus_s,
				"arus_t" => $arus_t,
				"koneksi" => $koneksi,
				"item_status_id" => $kondisi,
				"item_fungsi_id" => $fungsi,
				"wiring" => $wiring,
				"checked_at" => $time_now,
				"divisi_id" => '2',
				"branch_id" => $branch,
				"user_id" => $user_id,
				"description" => $keterangan
				]);
			
			$insert_checklist->update();
			//$insert_checklist->item_checklist();
			
			$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-success"><div class="danger">Data Berhasil Di Simpan</div></div>'));
			
			die($output);
		}
	}
	
	//$insert_checklist->item_checklist();
}
?>