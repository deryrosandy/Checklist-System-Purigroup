<?php
session_start();

include 'core/init.php';
include 'core/helper/myHelper.php';

	//$username	= anti_injection($_POST['username']);
	//$password	= anti_injection(md5($_POST['password']));

	$username	= $_POST['username'];
	$password	= md5($_POST['password']);

	$user = $db->users()->where("username", $username)
			->where("password", $password)
			->where("active", 1);
		
	if($value = $user->fetch()){
	
		$_SESSION['username']  	= $value['username'];
		$_SESSION['firstname']	= $value['firstname'];
		$_SESSION['password']   = $value['password'];
		$_SESSION['id']	  		= $value['id'];
		$_SESSION['user_type']	= $value['user_type'];
		$_SESSION['branch_id']	= $value['branch_id'];
		$_SESSION['divisi_id']	= $value['divisi_id'];
		
		header('Location: dashboard.php');
	}else{
		header('Location: index.php');
	}
?>