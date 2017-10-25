<?php
session_start();

include '../core/init.php';
include '../core/helper/myHelper.php';
include 'alert/alert.php';

	$username	= anti_injection($_POST['username']);
	$password	= anti_injection(md5($_POST['password']));
	/*
	function isLoginSessionExpired() {
		$login_session_duration = 1; 
		$current_time = time(); 
		if(isset($_SESSION['start']) and isset($_SESSION["id"])){  
			if(((time() - $_SESSION['start']) > $login_session_duration)){ 
				return true; 
			} 
		}
		return false;
	}
	*/
	//$username	= strtolower($_POST['username']);
	//$password	= md5($_POST['password']);
	$time_now =  date('Y-m-d H:i:s');
	$date_end =  date('Y-m-d');
	$cekdate = "active_end >= '".$date_end."'";
	
	$user = $db->users()
			->where("username", $username)
			//->where("password", $password)
			//->where($cekdate)
			->where("active", 1)
			->fetch();
	
	if($username != $user['username']){
		echo "<button id='btnShowAlert' style='display:none;'></button>
			<script type='text/javascript'>
				sweetAlert({
					title: 'Error!',
					text: 'Username Salah!',
					type: 'error'
				},
				function () {
					window.location.href = '../login.php';
				});
			</script>";
		exit();
		
	}elseif($password != $user['password']){
		
		echo "<button id='btnShowAlert' style='display:none;'></button>
			<script type='text/javascript'>
				sweetAlert({
					title: 'Error!',
					text: 'Password Salah!',
					type: 'error'
				},
				function () {
					window.location.href = '../login.php';
				});
			</script>";
		exit();
		
	}elseif(($user['user_type'] == 'operator' || $user['user_type'] == 'manager') && ($user['active_end'] <= $date_end)){
		
		echo "<button id='btnShowAlert' style='display:none;'></button>
			<script type='text/javascript'>
				sweetAlert({
					title: 'Error!',
					text: 'Akun Expired, Harap Hubungi Administrator!',
					type: 'error'
				},
				function () {
					window.location.href = '../login.php';
				});
			</script>";
		exit();
	
	}else{
		$_SESSION['username']  	= $user['username'];
		$_SESSION['firstname']	= $user['first_name'];
		$_SESSION['password']   = $user['password'];
		$_SESSION['id']	  		= $user['id'];
		$_SESSION['user_type']	= $user['user_type'];
		$_SESSION['branch_id']	= $user['branch_id'];
		$_SESSION['divisi_id']	= $user['divisi_id'];
		
		$id_user = $_SESSION['id'];
		
		$_SESSION['start'] = time();
		// Ending a session in 30 minutes from the starting time.
        $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
		
		$userid = $db->users[$id_user];
		
		if ($userid) {
			$data = array("id" => $id_user, "last_login" => $time_now);
		
			$result = $userid->update($data);
		}
		
		if(isset($_SESSION["id"])){
			if(!isLoginSessionExpired()) {
				header("Location:../dashboard.php");
			}else{
				header("Location:logout.php?session_expired=1");
			}
		}
		
		if($user['user_type']=='kasir'){
			header('Location: ../content.php?module=voucher&act=transaksi&page=new-transaction');
		}else{
			header('Location: ../dashboard.php');
		}	
	}
?>