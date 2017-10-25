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
			"user_type" => 'manager pengganti',
			"branch_id" => 0,
			"divisi_id" => 0,
			"phone_number" => $phone_number,
			"active" => 1,
			"created_at" => $time_now
		));
			
		$users->update();
		
		$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-success"><div class="danger">Data Berhasil Di Simpan</div></div>'));
		
		die($output);
	}
		
	//header ('Location: ../users.php');
	
?>