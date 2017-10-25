<?php
	session_start();
	
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}
		
	include 'core/init.php';

	$nHari = 6;
	$time_now = date("Y-m-d H:i:s");
	$date = mktime(date("H"), date("i"), date("s"), date("m") ,date("d") + $nHari , date("Y") );
	
	$end_date = date("Y-m-d H:i:s",$date);
	
	$id_user = $_SESSION['id'];
	
	
	$user = $db->users[$id_user];
	
	if (($user['user_type']) != 'manager pengganti' || ($user['user_type']) != 'administrator') {
		$data = array(
			"id" => $id_user,
			"active_start" => $time_now,
			"active_end" => $end_date
		);
		
		$result = $user->update($data);
	}
	
	session_destroy();
	
	unset($_SESSION["id"]);
	unset($_SESSION["username"]);
	
	$url = "index.php";
	
	if(isset($_GET["session_expired"])) {
		$url .= "?session_expired=" . $_GET["session_expired"];
	}
	
	header("Location:$url");
	
?>
