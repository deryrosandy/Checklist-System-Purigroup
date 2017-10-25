<?php

	if(!isset($_SESSION)){
	session_start();

	include 'core/init.php';
	include 'core/helper/myHelper.php';	 

	$id = $_GET['id'];

	//var_dump($id);
	$user = $db->users()->where("id", $id)->fetch();
	$delete = $user->delete();
	if($delete){
		header("Location: users.php");			
	}
}
?>