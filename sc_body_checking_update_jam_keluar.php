<?php
	include 'assets/alert/alert.php';
	date_default_timezone_set('Asia/Jakarta');

	$connect = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');

	$id = $_POST['id'];
	$jam_keluar = $_POST['jam_keluar'];
	$jam_keluar_created =  date('Y-m-d H:i:s');

	if (empty($jam_keluar)) {
		echo "<button id='btnShowAlert' style='display:none;'></button>
			<script type='text/javascript'>
				sweetAlert({
					title: 'Error!',
					text: 'Pastikan Field Jam Keluar Tidak Kosong!',
					type: 'error'
				},
				function () {
					window.location.href = 'lihat-checklist-sc.php';
				});
			</script>";
		exit();
	}

	$query1 = mysqli_query($connect,"UPDATE body_checking SET jam_keluar = '$jam_keluar', jam_keluar_created = '$jam_keluar_created' WHERE id = '$id'");
	echo "<button id='btnShowAlert' style='display:none;'></button>
		<script type='text/javascript'>
			sweetAlert({
				title: 'Sukses!',
				text: 'Berhasil Update Data Jam Keluar!',
				type: 'success'
			},
			function () {
				window.location.href = 'lihat-checklist-sc.php';
			});
		</script>";
	exit();
?>