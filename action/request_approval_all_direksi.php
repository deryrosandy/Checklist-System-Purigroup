<?php
			
if(!isset($_SESSION)){
    session_start();
	
	include '../core/init.php';
	$user_id 	= $_SESSION['id'];
	
	
	$tableData = stripcslashes($_POST['pTableData']);
	$password = md5($_POST['password']);
	$description = $_POST['description'];
	$approved = $_POST['approved'];

	// Decode the JSON array
	$tableData = json_decode($tableData,TRUE);

	$id_req = $tableData;
	
	$id_user 		= $_SESSION['id'];
	$time_now 		= date('Y-m-d H:i:s');
	
	$count = count($id_req);
	
	$user_dir = $db->users()
				->where("id", $id_user)
				->where("user_type", "direksi")
				->fetch();
			
			if ($password == $user_dir['password']){
				
				for ($i=0; $i<$count; $i++){
					if(($tableData[$i]['id_req']) != null){
						$insert_approval = $db->request_approval()->insert(array(
							"request_id" => $tableData[$i]['id_req'],
							"users_id" => $id_user,
							"created_at" => $time_now,
							"status" => $approved,
							"description" => $description
						));
						
						$insert_approval->update();
				
					}
				}
				
				$output = '<div class="alert alert-success"><div class="danger">Berhasil!</div></div>';
				die($output);
				
			}else{
				
				$output = '<div class="alert alert-danger"><div class="danger">Password Salah!</div></div>';
				die($output);
			
			}
			
		/*
		if($_POST){
		//check if its an ajax request, exit if not
		
		if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
			
			$output = json_encode(array( //create JSON data
				'type'=>'error', 
				'text' => 'Sorry Request must be Ajax POST'
			));
			die($output); //exit script outputting json data
		}
			
			$id_req = $_POST[id_req];
			$count = count($id_req);
	
			$password 		= md5($_POST['password']);
			$request_id 	= $_POST['request_id'];
			$status 		= $_POST['approved'];
			$description	= $_POST['description'];
			$id_user 		= $_SESSION['id'];
			$time_now 		=  date('Y-m-d H:i:s');
			
			var_dump($password, $id_req,$count); die();
			
			$user_dir = $db->users()
				->where("id", $id_user)
				->where("user_type", "direksi")
				->fetch();
			
			if ($password == $user_dir['password']){
				
				for ($i=0; $i<$count; $i++){
				
					$insert_approval = $db->request_approval()->insert(array(
						"request_id" => $id_req[$i],
						"users_id" => $id_user,
						"created_at" => $time_now,
						"status" => $status
					));
					
					$insert_approval->update();
				
				}
				
				$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-success"><div class="danger">Berhasil!</div></div>'));
				die($output);
				
			}else{
				
				$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-danger"><div class="danger">Password Salah!</div></div>'));
				die($output);
			
			}
		}
		*/
	}
?>