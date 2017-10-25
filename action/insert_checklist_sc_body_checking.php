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
		
		$item_area_id 	= $_POST['id'];
		$nama 			= $_POST['nama'];
		$jabatan	 	= $_POST['jabatan'];
		$jam_masuk 		= $_POST['jam_masuk'];
		$jam_keluar 	= $_POST['jam_keluar'];
		$no_surat 		= $_POST['no_surat'];
		$keterangan 	= $_POST['keterangan'];

		$user_id 	= $_SESSION['id'];
		$divisi 	= $_SESSION['divisi_id'];
		$branch 	= $_SESSION['branch_id'];
				
		$date_now	= date('Y-m-d');
		$time_now 	=  date('Y-m-d H:i:s');
			
		$insert_checklist = $db->body_checking()->insert(array(
			"nama" => $nama,
			"jabatan" => $jabatan,
			"jam_masuk" => $jam_masuk,
			"jam_keluar" => $jam_keluar,
			"no_surat" => $no_surat,
			"keterangan" => $keterangan,
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