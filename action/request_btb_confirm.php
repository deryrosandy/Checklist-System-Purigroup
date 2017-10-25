<?php
if(!isset($_SESSION)){
    session_start();
	
	include '../core/init.php';
	include '../core/helper/myHelper.php';
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
			
			$branch = $db->branch()
					->where("id", $_SESSION['branch_id'])
					->fetch();
			$user = $db->users()
					->where("id", $_SESSION['id'])
					->fetch();
					
			$request_id 	= $_POST['request_id'];
			
			$nobtb	 		= $_POST['nobtb'];
			$sent_by		= $_POST['received_from'];
			$no_supplier	= $_POST['no_supplier'];
			$no_kendara		= $_POST['no_kendara'];
			$description	= $_POST['description'];
			$id_user 		= $_SESSION['id'];
			$date_received	= date('Y-m-d', strtotime($_POST['btbdate']));
			$btb_number 	= 'BTB' . strtoupper($user->branch['code']) . date('y') . date('m') . nobtb();
			
			$time_now 		=  date('Y-m-d H:i:s');
			
			$user_staff = $db->users()
				->where("id", $id_user)
				->where("user_type", "staff adm")
				->fetch();
			
			$insert_received = $db->request_received()->insert(array(
				"request_id" => $request_id,
				"users_id" => $id_user,
				"btb_number" => $btb_number,
				"date_received" => $date_received,
				"sent_by" => $sent_by,
				"no_kendara" => $no_kendara,
				"no_supplier" => $no_supplier,
				"created_at" => $time_now,
				"description" => $description
			));
			
			$insert_received->update();
			
			
			$request = $db->request[$request_id];
			if ($request){
				$data = array(
					"status" => "Done"
				);
			
				$result = $request->update($data);
			}
			
			
			$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-success"><div class="danger">Success!</div></div>'));
			die($output);	
		}
	}
?>