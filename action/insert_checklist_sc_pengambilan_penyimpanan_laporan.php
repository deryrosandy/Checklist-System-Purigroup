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

			$item_area_id 		= $_POST['id'];
			$ambil_jam 			= $_POST['sc_pengambilan_jam'];
			$ambil_oleh			= $_POST['sc_pengambilan_diambil_oleh'];
			$ambil_saksi1 		= $_POST['sc_pengambilan_saksi1'];
			$ambil_saksi2 		= $_POST['sc_pengambilan_saksi2'];
			$simpan_jam 		= $_POST['sc_penyimpanan_jam'];
			$simpan_oleh 		= $_POST['sc_penyimpanan_diambil_oleh'];
			$simpan_saksi1 		= $_POST['sc_penyimpanan_saksi1'];
			$simpan_saksi2 		= $_POST['sc_penyimpanan_saksi2'];
			$laporan_situasi1 	= $_POST['sc_laporan_situasi_keterangan1'];

			$user_id 	= $_SESSION['id'];
			$divisi 	= $_SESSION['divisi_id'];
			$branch 	= $_SESSION['branch_id'];

			$date_now	= date('Y-m-d');
			$time_now 	= date('Y-m-d H:i:s');

			$cek_row = $db->kegiatan_security()
					->select("id, Convert(created_at, Date) As tanggal")
					->where("Convert(created_at, Date)", $date_now);

			if (count($cek_row) > 0){

				$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-danger"><div class="danger">Data Checklist Sudah Ada</div></div>'));
				
				die($output);

			}else{
			
				$insert_checklist = $db->kegiatan_security()->insert(array(
					"ambil_jam"			=> $ambil_jam,
					"ambil_oleh"		=> $ambil_oleh,
					"ambil_saksi1"		=> $ambil_saksi1,
					"ambil_saksi2"		=> $ambil_saksi2,
					"simpan_jam"		=> $simpan_jam,
					"simpan_oleh"		=> $simpan_oleh,
					"simpan_saksi1"		=> $simpan_saksi1,
					"simpan_saksi2"		=> $simpan_saksi2,
					"laporan_situasi1"	=> $laporan_situasi1,
					"branch_id" 		=> $branch,
					"item_area_id" 		=> $item_area_id,
					"user_id" 			=> $user_id,
					"created_at" 		=> $time_now,
				));
				
				$insert_checklist->update();
				
				$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-success"><div class="danger">Data Berhasil Di Simpan</div></div>'));
				
				die($output);
			}
		}
	}
?>