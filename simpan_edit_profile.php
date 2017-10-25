<?php
if(!isset($_SESSION)){
    session_start();
	
	include 'core/init.php';
	include 'assets/alert/alert.php';
	$connect = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
	
	$first_name=ucwords($_POST['first_name']);
	$last_name=ucwords($_POST['last_name']);
	$username=$_POST['username'];
	$username_lama=$_POST['username_lama'];
	$email=$_POST['email'];
	$email_lama=$_POST['email_lama'];
	$phone_number=$_POST['phone_number'];

	if ($username !== $username_lama) {
		$query1 = mysqli_query($connect,"SELECT * FROM users WHERE username = '$username'");
		$jumlah1 = mysqli_num_rows($query1);
		if ($jumlah1 > 0) {
			echo "<button id='btnShowAlert' style='display:none;'></button>
				<script type='text/javascript'>
					sweetAlert({
						title: 'Error!',
						text: 'Username Sudah Terdaftar Pada Sistem!',
						type: 'error'
					},
					function () {
						window.location.href = 'edit-profile.php';
					});
				</script>";
			exit();
		}
	}

	if ($email !== $email_lama) {
		$query2 = mysqli_query($connect,"SELECT * FROM users WHERE email = '$email'");
		$jumlah2 = mysqli_num_rows($query2);
		if ($jumlah2 > 0) {
			echo "<button id='btnShowAlert' style='display:none;'></button>
				<script type='text/javascript'>
					sweetAlert({
						title: 'Error!',
						text: 'Email Sudah Terdaftar Pada Sistem!',
						type: 'error'
					},
					function () {
						window.location.href = 'edit-profile.php';
					});
				</script>";
			exit();
		}
	}
	
	//var_dump ($divisi);
	//die();
	
	$id_user = $_POST['id'];
	$active = (int)(!empty($_POST['user-status'])) ? 1: 0; 
	
	$user = $db->users[$id_user];
	
	if ($user) {
		$data = array(
			"id" => $id_user,
			"username" => $username,
			"first_name" => $first_name,
			"last_name" => $last_name,
			"email" => $email,
			"phone_number" => $phone_number
		);
		if(!empty($_POST['password'])){
			
			$userpass = $db->users[$id_user];
			$userpass['password'] = $password;
			$userpass->update();
		
		}
		
		$result = $user->update($data);
	}
	
	echo "<button id='btnShowAlert' style='display:none;'></button>
		<script type='text/javascript'>
			sweetAlert({
				title: 'Sukses!',
				text: 'Berhasil Ubah Data Profil!',
				type: 'success'
			},
			function () {
				window.location.href = 'edit-profile.php';
			});
		</script>";
	exit();
}
?>