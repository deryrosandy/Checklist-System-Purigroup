<?php

if(!isset($_SESSION)){
    session_start();
}
	include '../core/init.php';
	include '../core/helper/myHelper.php';
	include 'alert/alert.php';

	$first_name=ucwords($_POST['first_name']);
	$last_name=ucwords($_POST['last_name']);
	$username=$_POST['username'];
	$password=md5($_POST['password']);
	$email=$_POST['email'];
	$gol_pengguna=$_POST['gol-pengguna'];
	$branch_id=$_POST['branch_id'];
	$divisi=$_POST['divisi_id'];
	$phone_number=$_POST['phone_number'];
	
	$nHari = 6;
	$time_now = date("Y-m-d H:i:s");
	$date = mktime(date("H"), date("i"), date("s"), date("m") ,date("d") + $nHari , date("Y") );
	
	$end_date = date("Y-m-d H:i:s",$date);
	
	$active = (int)(!empty($_POST['user-status'])) ? 1: 0; 
	
	$user_exist = $db->users()->where("username", $username)->fetch();
	
	if($user_exist){
		echo "<button id='btnShowAlert' style='display:none;'></button>
			<script type='text/javascript'>
				sweetAlert({
					title: 'Error!',
					text: 'Username Sudah Digunakan!',
					type: 'error'
				},
				function(){
					window.location.href = '../add-user.php';
				});
			</script>";
		exit();
	}else{
		$users = $db->users()->insert(array(
			"username" => $username,
			"first_name" => $first_name,
			"last_name" => $last_name,
			"password" => $password,
			"email" => $email,
			"user_type" => $gol_pengguna,
			"branch_id" => $branch_id,
			"divisi_id" => $divisi,
			"phone_number" => $phone_number,
			"active" => $active,
			"created_at" => $time_now,
			"active_start" => $time_now,
			"active_end" => $end_date
		));
			
		$users->update();
	}
		
	header ('Location: ../users.php');
	
?>