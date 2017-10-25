<?php

if(!isset($_SESSION)){
    session_start();
}
	include '../core/init.php';

	$first_name=ucwords($_POST['first_name']);
	$last_name=ucwords($_POST['last_name']);
	$username=$_POST['username'];
	$password=md5($_POST['password']);
	$email=$_POST['email'];
	$gol_pengguna=$_POST['gol-pengguna'];
	$branch_id=$_POST['branch_id'];
	$divisi=$_POST['divisi_id'];
	$phone_number=$_POST['phone_number'];
	
	
	$time_now =  date('Y-m-d H:i:s');
	
	$active = (int)(!empty($_POST['user-status'])) ? 1: 0; 
	
	$user_reg = $db->users()->fetch();
	
	if($user_reg['username'] == $username){
		echo "Username yang anda masukkan sudah terdaftar";
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
			"created_at" => $time_now
		));
			
		$users->update();
	}
		
	header ('Location: ../users.php');
	
?>