<?php
	$connect = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
	$query = mysqli_query($connect,"SELECT * FROM item_area WHERE divisi_id ='".$_POST['divisi_id']."'");

	echo "<option value=''></option>";
		while($data = mysqli_fetch_array($query,MYSQLI_ASSOC)){
		echo "<option value='$data[id]'>$data[name]</option>";
	}
?>