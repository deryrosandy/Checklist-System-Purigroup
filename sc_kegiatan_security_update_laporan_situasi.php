<?php
	include 'assets/alert/alert.php';
	$connect = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');

	$id = $_POST['id'];

	if ($_GET['id'] == '2') {
		$laporan_situasi2 = $_POST['laporan_situasi2'];
		if (empty($laporan_situasi2)) {
			echo "<button id='btnShowAlert' style='display:none;'></button>
				<script type='text/javascript'>
					sweetAlert({
						title: 'Error!',
						text: 'Pastikan Field Laporan Situasi Tidak Kosong!',
						type: 'error'
					},
					function () {
						window.location.href = 'lihat-checklist-sc.php';
					});
				</script>";
			exit();
		}

		$query1 = mysqli_query($connect,"UPDATE kegiatan_security SET laporan_situasi2 = '$laporan_situasi2' WHERE id = '$id'");
		echo "<button id='btnShowAlert' style='display:none;'></button>
			<script type='text/javascript'>
				sweetAlert({
					title: 'Sukses!',
					text: 'Berhasil Tambah Data Laporan Situasi!',
					type: 'success'
				},
				function () {
					window.location.href = 'lihat-checklist-sc.php';
				});
			</script>";
		exit();
	}
	elseif ($_GET['id'] == '3') {
		$laporan_situasi3 = $_POST['laporan_situasi3'];
		if (empty($laporan_situasi3)) {
			echo "<button id='btnShowAlert' style='display:none;'></button>
				<script type='text/javascript'>
					sweetAlert({
						title: 'Error!',
						text: 'Pastikan Field Laporan Situasi Tidak Kosong!',
						type: 'error'
					},
					function () {
						window.location.href = 'lihat-checklist-sc.php';
					});
				</script>";
			exit();
		}

		$query2 = mysqli_query($connect,"UPDATE kegiatan_security SET laporan_situasi3 = '$laporan_situasi3' WHERE id = '$id'");
		echo "<button id='btnShowAlert' style='display:none;'></button>
			<script type='text/javascript'>
				sweetAlert({
					title: 'Sukses!',
					text: 'Berhasil Tambah Data Laporan Situasi!',
					type: 'success'
				},
				function () {
					window.location.href = 'lihat-checklist-sc.php';
				});
			</script>";
		exit();
	}
	elseif ($_GET['id'] == '4') {
		$laporan_situasi4 = $_POST['laporan_situasi4'];
		if (empty($laporan_situasi4)) {
			echo "<button id='btnShowAlert' style='display:none;'></button>
				<script type='text/javascript'>
					sweetAlert({
						title: 'Error!',
						text: 'Pastikan Field Laporan Situasi Tidak Kosong!',
						type: 'error'
					},
					function () {
						window.location.href = 'lihat-checklist-sc.php';
					});
				</script>";
			exit();
		}

		$query3 = mysqli_query($connect,"UPDATE kegiatan_security SET laporan_situasi4 = '$laporan_situasi4' WHERE id = '$id'");
		echo "<button id='btnShowAlert' style='display:none;'></button>
			<script type='text/javascript'>
				sweetAlert({
					title: 'Sukses!',
					text: 'Berhasil Tambah Data Laporan Situasi!',
					type: 'success'
				},
				function () {
					window.location.href = 'lihat-checklist-sc.php';
				});
			</script>";
		exit();
	}
	elseif ($_GET['id'] == '5') {
		$laporan_situasi5 = $_POST['laporan_situasi5'];
		if (empty($laporan_situasi5)) {
			echo "<button id='btnShowAlert' style='display:none;'></button>
				<script type='text/javascript'>
					sweetAlert({
						title: 'Error!',
						text: 'Pastikan Field Laporan Situasi Tidak Kosong!',
						type: 'error'
					},
					function () {
						window.location.href = 'lihat-checklist-sc.php';
					});
				</script>";
			exit();
		}

		$query4 = mysqli_query($connect,"UPDATE kegiatan_security SET laporan_situasi5 = '$laporan_situasi5' WHERE id = '$id'");
		echo "<button id='btnShowAlert' style='display:none;'></button>
			<script type='text/javascript'>
				sweetAlert({
					title: 'Sukses!',
					text: 'Berhasil Tambah Data Laporan Situasi!',
					type: 'success'
				},
				function () {
					window.location.href = 'lihat-checklist-sc.php';
				});
			</script>";
		exit();
	}
	elseif ($_GET['id'] == '6') {
		$laporan_situasi6 = $_POST['laporan_situasi6'];
		if (empty($laporan_situasi6)) {
			echo "<button id='btnShowAlert' style='display:none;'></button>
				<script type='text/javascript'>
					sweetAlert({
						title: 'Error!',
						text: 'Pastikan Field Laporan Situasi Tidak Kosong!',
						type: 'error'
					},
					function () {
						window.location.href = 'lihat-checklist-sc.php';
					});
				</script>";
			exit();
		}

		$query5 = mysqli_query($connect,"UPDATE kegiatan_security SET laporan_situasi6 = '$laporan_situasi6' WHERE id = '$id'");
		echo "<button id='btnShowAlert' style='display:none;'></button>
			<script type='text/javascript'>
				sweetAlert({
					title: 'Sukses!',
					text: 'Berhasil Tambah Data Laporan Situasi!',
					type: 'success'
				},
				function () {
					window.location.href = 'lihat-checklist-sc.php';
				});
			</script>";
		exit();
	}
	elseif ($_GET['id'] == '7') {
		$laporan_situasi7 = $_POST['laporan_situasi7'];
		if (empty($laporan_situasi7)) {
			echo "<button id='btnShowAlert' style='display:none;'></button>
				<script type='text/javascript'>
					sweetAlert({
						title: 'Error!',
						text: 'Pastikan Field Laporan Situasi Tidak Kosong!',
						type: 'error'
					},
					function () {
						window.location.href = 'lihat-checklist-sc.php';
					});
				</script>";
			exit();
		}

		$query6 = mysqli_query($connect,"UPDATE kegiatan_security SET laporan_situasi7 = '$laporan_situasi7' WHERE id = '$id'");
		echo "<button id='btnShowAlert' style='display:none;'></button>
			<script type='text/javascript'>
				sweetAlert({
					title: 'Sukses!',
					text: 'Berhasil Tambah Data Laporan Situasi!',
					type: 'success'
				},
				function () {
					window.location.href = 'lihat-checklist-sc.php';
				});
			</script>";
		exit();
	}
?>