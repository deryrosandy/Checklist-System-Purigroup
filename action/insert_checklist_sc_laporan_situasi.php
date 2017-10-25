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

		if(empty($_POST['sc_ls_pagi_keterangan1'])){
			$pagi_keterangan1 = 0;
		}else{
			$pagi_keterangan1 = $_POST['sc_ls_pagi_keterangan1'];
		}
		if(empty($_POST['sc_ls_pagi_keterangan2'])){
			$pagi_keterangan2 = 0;
		}else{
			$pagi_keterangan2 = $_POST['sc_ls_pagi_keterangan2'];
		}
		if(empty($_POST['sc_ls_pagi_keterangan3'])){
			$pagi_keterangan3 = 0;
		}else{
			$pagi_keterangan3 = $_POST['sc_ls_pagi_keterangan3'];
		}
		if(empty($_POST['sc_ls_pagi_keterangan4'])){
			$pagi_keterangan4 = 0;
		}else{
			$pagi_keterangan4 = $_POST['sc_ls_pagi_keterangan4'];
		}
		if(empty($_POST['sc_ls_pagi_keterangan5'])){
			$pagi_keterangan5 = 0;
		}else{
			$pagi_keterangan5 = $_POST['sc_ls_pagi_keterangan5'];
		}

		if(empty($_POST['sc_ls_siang_keterangan1'])){
			$siang_keterangan1 = 0;
		}else{
			$siang_keterangan1 = $_POST['sc_ls_siang_keterangan1'];
		}
		if(empty($_POST['sc_ls_siang_keterangan2'])){
			$siang_keterangan2 = 0;
		}else{
			$siang_keterangan2 = $_POST['sc_ls_siang_keterangan2'];
		}
		if(empty($_POST['sc_ls_siang_keterangan3'])){
			$siang_keterangan3 = 0;
		}else{
			$siang_keterangan3 = $_POST['sc_ls_siang_keterangan3'];
		}
		if(empty($_POST['sc_ls_siang_keterangan4'])){
			$siang_keterangan4 = 0;
		}else{
			$siang_keterangan4 = $_POST['sc_ls_siang_keterangan4'];
		}
		if(empty($_POST['sc_ls_siang_keterangan5'])){
			$siang_keterangan5 = 0;
		}else{
			$siang_keterangan5 = $_POST['sc_ls_siang_keterangan5'];
		}

		if(empty($_POST['sc_ls_malam_keterangan1'])){
			$malam_keterangan1 = 0;
		}else{
			$malam_keterangan1 = $_POST['sc_ls_malam_keterangan1'];
		}
		if(empty($_POST['sc_ls_malam_keterangan2'])){
			$malam_keterangan2 = 0;
		}else{
			$malam_keterangan2 = $_POST['sc_ls_malam_keterangan2'];
		}
		if(empty($_POST['sc_ls_malam_keterangan3'])){
			$malam_keterangan3 = 0;
		}else{
			$malam_keterangan3 = $_POST['sc_ls_malam_keterangan3'];
		}
		if(empty($_POST['sc_ls_malam_keterangan4'])){
			$malam_keterangan4 = 0;
		}else{
			$malam_keterangan4 = $_POST['sc_ls_malam_keterangan4'];
		}
		if(empty($_POST['sc_ls_malam_keterangan5'])){
			$malam_keterangan5 = 0;
		}else{
			$malam_keterangan5 = $_POST['sc_ls_malam_keterangan5'];
		}

		$item_area_id 			= $_POST['id'];
		$keadaan				= $_POST['sc_ls_keadaan'];
		$pagi_jumlah			= $_POST['sc_ls_pagi_jumlah'];
		$pagi_hadir				= $_POST['sc_ls_pagi_hadir'];
		$pagi_tidak_hadir		= $_POST['sc_ls_pagi_tidak_hadir'];
		$pagi_backup			= $_POST['sc_ls_pagi_backup'];
		$pagi_nama1				= $_POST['sc_ls_pagi_nama1'];
		$pagi_nama2				= $_POST['sc_ls_pagi_nama2'];
		$pagi_nama3				= $_POST['sc_ls_pagi_nama3'];
		$pagi_nama4				= $_POST['sc_ls_pagi_nama4'];
		$pagi_nama5				= $_POST['sc_ls_pagi_nama5'];
		$siang_jumlah			= $_POST['sc_ls_siang_jumlah'];
		$siang_hadir			= $_POST['sc_ls_siang_hadir'];
		$siang_tidak_hadir		= $_POST['sc_ls_siang_tidak_hadir'];
		$siang_backup			= $_POST['sc_ls_siang_backup'];
		$siang_nama1			= $_POST['sc_ls_siang_nama1'];
		$siang_nama2			= $_POST['sc_ls_siang_nama2'];
		$siang_nama3			= $_POST['sc_ls_siang_nama3'];
		$siang_nama4			= $_POST['sc_ls_siang_nama4'];
		$siang_nama5			= $_POST['sc_ls_siang_nama5'];
		$malam_jumlah			= $_POST['sc_ls_malam_jumlah'];
		$malam_hadir			= $_POST['sc_ls_malam_hadir'];
		$malam_tidak_hadir		= $_POST['sc_ls_malam_tidak_hadir'];
		$malam_backup			= $_POST['sc_ls_malam_backup'];
		$malam_nama1			= $_POST['sc_ls_malam_nama1'];
		$malam_nama2			= $_POST['sc_ls_malam_nama2'];
		$malam_nama3			= $_POST['sc_ls_malam_nama3'];
		$malam_nama4			= $_POST['sc_ls_malam_nama4'];
		$malam_nama5			= $_POST['sc_ls_malam_nama5'];
		$lembur_jumlah			= $_POST['sc_ls_lembur_jumlah'];
		$lembur_keterangan		= $_POST['sc_ls_lembur_keterangan'];
		$materiil_kondisi1		= $_POST['sc_ls_materiil_kondisi1'];
		$materiil_kondisi2		= $_POST['sc_ls_materiil_kondisi2'];
		$materiil_kondisi3		= $_POST['sc_ls_materiil_kondisi3'];
		$materiil_kondisi4		= $_POST['sc_ls_materiil_kondisi4'];
		$materiil_kondisi5		= $_POST['sc_ls_materiil_kondisi5'];
		$materiil_keterangan	= $_POST['sc_ls_materiil_keterangan'];
		$aktivitas1				= $_POST['sc_ls_aktivitas1'];
		$aktivitas2				= $_POST['sc_ls_aktivitas2'];
		$aktivitas3				= $_POST['sc_ls_aktivitas3'];
		$aktivitas4				= $_POST['sc_ls_aktivitas4'];
		$aktivitas5				= $_POST['sc_ls_aktivitas5'];
				
		$user_id 	= $_SESSION['id'];
		$divisi 	= $_SESSION['divisi_id'];
		$branch 	= $_SESSION['branch_id'];

		$date_now	= date('Y-m-d');
		$time_now 	= date('Y-m-d H:i:s');

		$cek_row = $db->sc_laporan_situasi()
				->select("id, Convert(created_at, Date) As tanggal")
				->where("Convert(created_at, Date)", $date_now);

		if (count($cek_row) > 0){

			$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-danger"><div class="danger">Data Checklist Sudah Ada</div></div>'));
			
			die($output);

		}else{
		
			$laporan_situasi = $db->sc_laporan_situasi()->insert(array(
				"keadaan" 			=> $keadaan,
				"pagi_jumlah" 		=> $pagi_jumlah,
				"pagi_hadir" 		=> $pagi_hadir,
				"pagi_tidak_hadir" 	=> $pagi_tidak_hadir,
				"pagi_backup" 		=> $pagi_backup,
				"pagi_nama1" 		=> $pagi_nama1,
				"pagi_nama2" 		=> $pagi_nama2,
				"pagi_nama3" 		=> $pagi_nama3,
				"pagi_nama4" 		=> $pagi_nama4,
				"pagi_nama5" 		=> $pagi_nama5,
				"pagi_keterangan1" 	=> $pagi_keterangan1,
				"pagi_keterangan2" 	=> $pagi_keterangan2,
				"pagi_keterangan3" 	=> $pagi_keterangan3,
				"pagi_keterangan4" 	=> $pagi_keterangan4,
				"pagi_keterangan5" 	=> $pagi_keterangan5,
				"siang_jumlah" 		=> $siang_jumlah,
				"siang_hadir" 		=> $siang_hadir,
				"siang_tidak_hadir" => $siang_tidak_hadir,
				"siang_backup" 		=> $siang_backup,
				"siang_nama1" 		=> $siang_nama1,
				"siang_nama2" 		=> $siang_nama2,
				"siang_nama3" 		=> $siang_nama3,
				"siang_nama4" 		=> $siang_nama4,
				"siang_nama5" 		=> $siang_nama5,
				"siang_keterangan1" => $siang_keterangan1,
				"siang_keterangan2" => $siang_keterangan2,
				"siang_keterangan3" => $siang_keterangan3,
				"siang_keterangan4" => $siang_keterangan4,
				"siang_keterangan5" => $siang_keterangan5,
				"malam_jumlah" 		=> $malam_jumlah,
				"malam_hadir" 		=> $malam_hadir,
				"malam_tidak_hadir" => $malam_tidak_hadir,
				"malam_backup" 		=> $malam_backup,
				"malam_nama1" 		=> $malam_nama1,
				"malam_nama2" 		=> $malam_nama2,
				"malam_nama3" 		=> $malam_nama3,
				"malam_nama4" 		=> $malam_nama4,
				"malam_nama5" 		=> $malam_nama5,
				"malam_keterangan1" => $malam_keterangan1,
				"malam_keterangan2" => $malam_keterangan2,
				"malam_keterangan3" => $malam_keterangan3,
				"malam_keterangan4" => $malam_keterangan4,
				"malam_keterangan5" => $malam_keterangan5,
				"lembur_jumlah" 	=> $lembur_jumlah,
				"lembur_keterangan" => $lembur_keterangan,
				"materiil_kondisi1" => $materiil_kondisi1,
				"materiil_kondisi2" => $materiil_kondisi2,
				"materiil_kondisi3" => $materiil_kondisi3,
				"materiil_kondisi4" => $materiil_kondisi4,
				"materiil_kondisi5" => $materiil_kondisi5,
				"aktivitas1" 		=> $aktivitas1,
				"aktivitas2" 		=> $aktivitas2,
				"aktivitas3" 		=> $aktivitas3,
				"aktivitas4" 		=> $aktivitas4,
				"aktivitas5" 		=> $aktivitas5,
				"branch_id" 		=> $branch,
				"item_area_id" 		=> $item_area_id,
				"user_id" 			=> $user_id,
				"created_at" 		=> $time_now,
			));
			
			$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-success"><div class="danger">Data Berhasil Di Simpan</div></div>'));
			
			die($output);
		}
	}
	
	//$insert_checklist->item_checklist();
}
?>