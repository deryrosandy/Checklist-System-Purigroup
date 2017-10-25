<?php
function jenis_kel($jenis) {
	
	$jenis_kelamin = array("Perempuan", "Laki-laki");
	
	$result = $jenis_kelamin[$jenis];
	
	return($result);
}

function status($user_type) {
				
	$user = array("Tidak Aktif","Aktif");
	
	$result = $user[$user_type];
	
	return($result);
}

function color_req_status($request_id) {
	switch ($request_id){
		case "Approve":
			return "success";
			break;
		case "Reject":
			return "danger";
			break;
		case "Pending":
			return "warning";
			break;
	}
}

function icon_req_status($request_id) {
	switch ($request_id){
		case "Approve":
			return "glyphicon-ok";
			break;
		case "Reject":
			return "glyphicon-remove";
			break;
		case "Pending":
			return "glyphicon-pause";
			break;
	}
}

function status_item($status_id) {
				
	$status = array("11","BAGUS","RUSAK");
	
	$result = $status[$status_id];
	
	return($result);
}

function kondisi_item($kondisi_id) {
				
	$kondisi = array("","","","Bersih","Kotor");
	
	$result = $kondisi[$kondisi_id];
	
	return($result);
}

function fungsi_item($fungsi_id) {
				
	$fungsi = array("Baik","Rusak");
	
	$result = $fungsi[$fungsi_id];
	
	return($result);
}

function isLoginSessionExpired() {
	$login_session_duration = 1; 
	$current_time = time(); 
	if(isset($_SESSION['loggedin_time']) and isset($_SESSION["id"])){  
		if(((time() - $_SESSION['loggedin_time']) > $login_session_duration)){ 
			return true; 
		} 
	}
	return false;
}
/*
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
*/

function anti_injection($data){
  $filter = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
  return $filter;
}

function tgl_indo($tgl){
		$tanggal = substr($tgl,8,2);
		$bulan = getBulan(substr($tgl,5,2));
		$tahun = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;		 
}

function getBulan($bln){
	switch ($bln){
		case 1: 
			return "Januari";
			break;
		case 2:
			return "Februari";
			break;
		case 3:
			return "Maret";
			break;
		case 4:
			return "April";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Juni";
			break;
		case 7:
			return "Juli";
			break;
		case 8:
			return "Agustus";
			break;
		case 9:
			return "September";
			break;
		case 10:
			return "Oktober";
			break;
		case 11:
			return "November";
			break;
		case 12:
			return "Desember";
			break;
	}
} 

function tgl_indo2($tgl){
		$tanggal = substr($tgl,8,2);
		$bulan = getBulan2(substr($tgl,5,2));
		$tahun = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;		 
}

function jam_indo($tgl){
		$tanggal = substr($tgl,8,2);
		$bulan = getBulan2(substr($tgl,5,2));
		$tahun = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;		 
}

function getHour($hour){
	$jam = substr($hour,10,6);
	return $jam;	
}

function getBulan2($bln){
	switch ($bln){
		case 1: 
			return "Jan";
			break;
		case 2:
			return "Feb";
			break;
		case 3:
			return "Mar";
			break;
		case 4:
			return "Apr";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Jun";
			break;
		case 7:
			return "Jul";
			break;
		case 8:
			return "Agus";
			break;
		case 9:
			return "Sep";
			break;
		case 10:
			return "Okt";
			break;
		case 11:
			return "Nov";
			break;
		case 12:
			return "Des";
			break;
	}
} 

function status_request($status){
	switch ($status){
		case "Done":
			return "label-success";
			break;
		case "On Process":
			return "label-warning";
			break;
		case "Cancel":
			return "label-danger";
			break;
		case 'Assigned':
			return 'label-primary';
			break;
	}
}

function tgl_indo_short($tgl){
	$hour = substr($tgl,10,3);
	$minute = substr($tgl,14,2);
	return $hour.':'.$minute;	
}

function tgl_short($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = substr($tgl,5,2);
	$tahun = substr($tgl,0,4);
	return $tanggal .''. $bulan . '' . $tahun;	
}
function tgl_short_slash($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = substr($tgl,5,2);
	$tahun = substr($tgl,0,4);
	return $bulan .'/'. $tanggal . '/' . $tahun;	
}
function create_path_bulan($path){
	if(!is_dir($path)){
		
		mkdir($path, 0755);
	}
	
	return $path;
}
function create_path_year($path){
	if(!is_dir($path)){
		
		mkdir($path, 0755);
	}
	
	return $path;
}

function status_confirm($status){
	switch ($status){
		case "0": 
			return "label-danger";
			break;
		case "1":
			return "label-warning";
			break;
	}
}

function noreq(){
	
	include '/../connect/database.php';
	
	$datanoreq = $db->request()
					->select("SUBSTR(MAX(noreq),-5) as noreq")
					->fetch();
	
	// bila data kosong
	if($datanoreq['noreq']==''){ 
		$reqid = "0001";
	}else {
		$noreqid = $datanoreq['noreq'];
		$noreqid++;
		if($noreqid < 10) $reqid = "0000".$noreqid; // nilai kurang dari 10
		elseif($noreqid < 100) $reqid = "000".$noreqid; // nilai kurang dari 100													
		elseif($noreqid < 1000) $reqid = "00".$noreqid; // nilai kurang dari 1000
		elseif($noreqid < 10000) $reqid = "0".$noreqid; // nilai kurang dari 10000
		else $reqid = $noreqid; // lebih dari 100000
	}
	
	return $reqid;
}

function nobtb(){
	
	include '/../connect/database.php';
	
	$datanobtb = $db->request_received()
					->select("SUBSTR(MAX(btb_number),-5) as btb_number")
					->fetch();
	
	// bila data kosong
	if($datanobtb['btb_number']==''){ 
		$btbid = "0001";
	}else {
		$nobtbid = $datanobtb['btb_number'];
		$nobtbid++;
		if($nobtbid < 10) $btbid = "0000".$nobtbid; // nilai kurang dari 10
		elseif($nobtbid < 100) $btbid = "000".$nobtbid; // nilai kurang dari 100													
		elseif($nobtbid < 1000) $btbid = "00".$nobtbid; // nilai kurang dari 1000
		elseif($nobtbid < 10000) $btbid = "0".$nobtbid; // nilai kurang dari 10000
		else $btbid = $nobtbid; // lebih dari 100000
	}
	
	return $btbid;
}


$body = '';
$active = '';

?>