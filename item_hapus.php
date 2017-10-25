<?php
	include 'assets/alert/alert.php';

	$connect = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
	$id = $_GET['id'];

	$query1 = mysqli_query($connect,"DELETE FROM item WHERE id = '$id'");
	echo "<button id='btnShowAlert' style='display:none;'></button>
		<script type='text/javascript'>
			sweetAlert({
				title: 'Sukses!',
				text: 'Berhasil Hapus Item!',
				type: 'success'
			},
			function () {
				window.location.href = 'content.php?module=master&page=item';
			});
		</script>";
	exit();
?>