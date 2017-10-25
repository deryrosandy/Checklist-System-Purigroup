<?php
if(!isset($_SESSION)){
    session_start();
	
	include '../core/init.php';
	$user_id 	= $_SESSION['id'];
	
	if($_POST){
		//check if its an ajax request, exit if not
		
			if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
				
				$output = json_encode(array( //create JSON data
					'type'=>'error', 
					'text' => 'Sorry Request must be Ajax POST'
				));
				die($output); //exit script outputting json data
			}
			
			$request_id 	= $_POST['request_id'];
			$nopobtb 		= $_POST['nopobtb'];
			$pobtb 			= $_POST['pobtb'];
			$description	= $_POST['description'];
			$id_user 		= $_SESSION['id'];
			$time_now 		=  date('Y-m-d H:i:s');
			$user_pcs = $db->users()
				->where("id", $id_user)
				->where("user_type", "purchasing")
				->fetch();
			
			$insert_approval = $db->request_approval()->insert(array(
				"request_id" => $request_id,
				"users_id" => $id_user,
				"created_at" => $time_now,
				"status" => 'Approve',
				"description" => $description
			));
			
			$insert_approval->update();
			
			$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-success"><div class="danger">Berhasil!</div></div>'));
			die($output);	
		}
	}
?>