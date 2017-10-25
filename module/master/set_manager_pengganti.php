<?php
if(!isset($_SESSION)){
    session_start();
	
	include '../../core/init.php';
	
	$user_id 	= $_SESSION['id'];
	
	if($_POST){
			
			$id_userm = $_POST['id_user'];
			$start_date = date('Y-m-d', strtotime($_POST['start_date']));
			$end_date = date('Y-m-d', strtotime($_POST['end_date']));
			$branch = $_SESSION['branch_id'];
			
			$date_now		= date('Y-m-d');
			$time_now 		=  date('Y-m-d H:i:s');
			
			$users = $db->users[$id_userm];
	
			if ($users){
				$data = array(
					"id" => $id_userm,
					"branch_id" => $branch,
					"active_start" => $start_date,
					"active_end" => $end_date,
					"active" => "1"
				);
		
				$result = $users->update($data);
			}
			
			header('Location: ../../content.php?module=master&page=mutasi-user');
	}
}
?>