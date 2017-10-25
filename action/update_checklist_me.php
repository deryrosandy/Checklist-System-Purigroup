<?php
if(!isset($_SESSION)){
    session_start();
	
	include '../core/init.php';
	$user_id 	= $_SESSION['id'];
	
	$tegangan_r = $_POST['tegangan_r'];
	$tegangan_s = $_POST['tegangan_s'];
	$tegangan_t = $_POST['tegangan_t'];
	$arus_r		= $_POST['arus_r'];
	$arus_s		= $_POST['arus_s'];
	$arus_t		= $_POST['arus_t'];
	$kondisi	= $_POST['kondisi'];
	$fungsi		= $_POST['fungsi'];
	$koneksi	= $_POST['koneksi'];
	$wiring		= $_POST['wiring'];
	$keterangan = $_POST['$keterangan'];

	$id_checklist 	= $_POST['id'];
	$user_id 		= $_SESSION['id'];
	$date_now		= date('Y-m-d');
	$time_now 		=  date('Y-m-d H:i:s');

	if($_POST){
		//check if its an ajax request, exit if not
		
		if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
			
			$output = json_encode(array( //create JSON data
				'type'=>'error', 
				'text' => 'Sorry Request must be Ajax POST'
			));
			die($output); //exit script outputting json data
		}
		
		$checklist = $db->item_checklist[$id_checklist];
				
		if ($checklist) {
							
			$data = array(
				"id" => $id_checklist,
				"item_status_id" => $kondisi,
				"item_fungsi_id" => $fungsi,
				"tegangan_r" => $tegangan_r,
				"tegangan_s" => $tegangan_s,
				"tegangan_t" => $tegangan_t,
				"arus_r" => $arus_r,
				"arus_s" => $arus_s,
				"arus_t" => $arus_t,
				"koneksi" => $koneksi,
				"wiring" => $wiring,
				"last_update" => $time_now
			);
			
			$result = $checklist->update($data);
			
		}

		$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-success"><div class="danger">Update Berhasil</div></div>'));
		
		die($output);
	}
}

?>