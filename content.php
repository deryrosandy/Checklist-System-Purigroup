<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}else{
		include 'core/init.php';
		include 'core/helper/myHelper.php';
		

		if($_GET['module']=='master'){
			include('module/' . $_GET['module'] . '/' . $_GET['module'] . '.php');
		}
		if($_GET['module']=='checklist'){
			include('module/' . $_GET['module'] . '/' . $_GET['module'] . '.php');
		}
		if($_GET['module']=='request'){
			include('module/' . $_GET['module'] . '/' . $_GET['module'] . '.php');
		}
		if($_GET['module']=='voucher'){
			include('module/' . $_GET['module'] . '/' . $_GET['module'] . '.php');
		}
		if($_GET['module']=='evoucher'){
			include('module/' . $_GET['module'] . '/' . $_GET['module'] . '.php');
		}
	}
?>