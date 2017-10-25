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
			$status 		= $_POST['approved'];
			$description	= $_POST['description'];
			$id_user 		= $_SESSION['id'];
			$time_now 		=  date('Y-m-d H:i:s');
			
			//var_dump($request_id,$status,$description,$id_user);
			
			$insert_approval = $db->request_approval()->insert(array(
				"request_id" => $request_id,
				"users_id" => $id_user,
				"created_at" => $time_now,
				"status" => $status,
				"description" => $description
			));
			
			$insert_approval->update();
			
			$request = $db->request[$request_id];
			
			if ($request){
				$data = array("status" => "On Process");
				
				$result = $request->update($data);
			}
			
			
			
			$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-success"><div class="danger">Berhasil!</div></div>'));
			die($output);
		}
	}
?>