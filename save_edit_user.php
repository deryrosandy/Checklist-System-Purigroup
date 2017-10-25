<?php
if(!isset($_SESSION)){
	
    session_start();
	include 'core/init.php';
	
	$first_name=ucwords($_POST['first_name']);
	$last_name=ucwords($_POST['last_name']);
	$username=$_POST['username'];
	$password=md5($_POST['password']);
	$email=$_POST['email'];
	$gol_pengguna=$_POST['gol-pengguna'];
	$branch_id=$_POST['branch_id'];
	$divisi=$_POST['divisi_id'];
	$phone_number=$_POST['phone_number'];
	
	//var_dump ($divisi);
	//die();
	
	$id_user = $_POST['id'];
	$active = (int)(!empty($_POST['user-status'])) ? 1: 0; 
	$time_now 		=  date('Y-m-d H:i:s');
	$user = $db->users[$id_user];
	$nHari = 6;
	$time_now = date("Y-m-d H:i:s");
	$date = mktime(date("H"), date("i"), date("s"), date("m") ,date("d") + $nHari , date("Y") );
	
	$end_date = date("Y-m-d H:i:s",$date);
	
	if ($user) {
		$data = array(
			"id" => $id_user,
			"username" => $username,
			"first_name" => $first_name,
			"last_name" => $last_name,
			"email" => $email,
			"user_type" => $gol_pengguna,
			"branch_id" => $branch_id,
			"divisi_id" => $divisi,
			"phone_number" => $phone_number,
			"updated_at" => $time_now,
			"active_start" => $time_now,
			"active_end" => $end_date,
			"active" => $active
		);
		if(!empty($_POST['password'])){
			$userpass = $db->users[$id_user];
			$userpass['password'] = $password;
			$userpass->update();
		}
		$result = $user->update($data);
	}
	
	header ('Location: users.php');
}
?>