<?php
if(!isset($_SESSION)){
    session_start();
	
	include '../core/init.php';
	$user_id 	= $_SESSION['id'];
	//var_dump ($user_id);
	
	if($_POST){
		//check if its an ajax request, exit if not
		
		if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
			
			$output = json_encode(array( //create JSON data
				'type'=>'error', 
				'text' => 'Sorry Request must be Ajax POST'
			));
			die($output); //exit script outputting json data
		}
		
	
		$id_item = $_POST['id'];
		
		if(isset($_POST['var11'])){
			$var11		= $_POST['var11'];
			$ph			= $_POST['ph'];
			$cl			= $_POST['cl'];
		}
		
		if(isset($_POST['var12'])){
			$var12 = $_POST['var12'];
		}
		
		if(isset($_POST['var14'])){
			$var14 = $_POST['var14'];
		}
		
		if(isset($_POST['var16'])){
			$var16 = $_POST['var16'];
		}
		
		if(isset($_POST['var18'])){
			$var18 = $_POST['var18'];
		}
		
		if(isset($_POST['var20'])){
			$var20 = $_POST['var20'];
		}
		
		if(isset($_POST['var22'])){
			$var22 = $_POST['var22'];
		}
		
		if(isset($_POST['var23'])){
			$var23		= $_POST['var23'];
			$ph			= $_POST['ph'];
			$cl			= $_POST['cl'];
		}
		if(isset($_POST['var11_1'])){
			$var11_1		= $_POST['var11_1'];
			$ph_1			= $_POST['ph_1'];
			$cl_1			= $_POST['cl_1'];
		}
		if(isset($_POST['var23_2'])){
			$var23_2		= $_POST['var23_2'];
			$ph_2			= $_POST['ph_2'];
			$cl_2			= $_POST['cl_2'];
		}
		
		$item = $db->item()->where("id", $id_item)->fetch();
		
		$user_id 	= $_SESSION['id'];
		$user = $db->users()->where("id", $user_id)->fetch();
		$divisi 	= $item['divisi_id'];
		
		$date_now	= date('Y-m-d');
		$time_now 	=  date('Y-m-d H:i:s');
		
		$cek_checklist = $db->item_checklist()
				->select("id, item_id, Convert(checked_at, Date) As tanggal")
				->where("item_id", $_POST['id'])
				->where("Convert(checked_at, Date)", $date_now);
			
		$cek_fas = $db->checklist_me_fas()
				->select("id, item_id, Convert(checked_at, Date) As tanggal")
				->where("item_id", $_POST['id'])
				->where("Convert(checked_at, Date)", $date_now);
		
		
		if (count($cek_checklist) > 0 ){
			
			if($var11){
				$ch_id = 1;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"ph" => $ph,
					"cl" => $cl,
					"branch_id" => $user['branch_id'],
					"description" => $var11,
					"user_id" => $user_id
			
				));
			}
			if($var12){
				$ch_id = 2;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"branch_id" => $user['branch_id'],
					"description" => $var12,
					"user_id" => $user_id
			
				));
			}
			if($var14){
				$ch_id = 3;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"branch_id" => $user['branch_id'],
					"description" => $var14,
					"user_id" => $user_id
			
				));
			}
			if($var16){
				$ch_id = 4;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"branch_id" => $user['branch_id'],
					"description" => $var16,
					"user_id" => $user_id
			
				));
			}
			if($var18){
				$ch_id = 5;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"branch_id" => $user['branch_id'],
					"description" => $var18,
					"user_id" => $user_id
			
				));
			}
			if($var20){
				$ch_id = 6;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"branch_id" => $user['branch_id'],
					"description" => $var20,
					"user_id" => $user_id
			
				));
			}
			if($var22){
				$ch_id = 7;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"branch_id" => $user['branch_id'],
					"description" => $var22,
					"user_id" => $user_id
			
				));
			}
			if($var23){
				$ch_id = 8;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"ph" => $ph,
					"cl" => $cl,
					"branch_id" => $user['branch_id'],
					"description" => $var23,
					"user_id" => $user_id
			
				));
			}
			if($var23_2){
				$ch_id = 8;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"ph" => $ph_2,
					"cl" => $cl_2,
					"branch_id" => $user['branch_id'],
					"description" => $var23_2,
					"user_id" => $user_id
			
				));
			}
			if($var11_1){
				$ch_id = 1;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"ph" => $ph_1,
					"cl" => $cl_1,
					"branch_id" => $user['branch_id'],
					"description" => $var11_1,
					"user_id" => $user_id
			
				));
			}
			
			$insert_fas->update();
			
			$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-success"><div class="danger">Data Berhasil Di Simpan</div></div>'));
			
			die($output);
			
		}else{
			
			$insert_checklist = $db->item_checklist()->insert(array(
				"item_id" => $id_item,
				"checked_at" => $time_now,
				"divisi_id" => '2',
				"branch_id" => $user['branch_id'],
				"user_id" => $user_id
			));
			
			$insert_checklist->update();
						
			if($var11){
				$ch_id = 1;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"ph" => $ph,
					"cl" => $cl,
					"branch_id" => $user['branch_id'],
					"description" => $var11,
					"user_id" => $user_id
			
				));
			}
			if($var12){
				$ch_id = 2;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"branch_id" => $user['branch_id'],
					"description" => $var12,
					"user_id" => $user_id
			
				));
			}
			if($var14){
				$ch_id = 3;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"branch_id" => $user['branch_id'],
					"description" => $var14,
					"user_id" => $user_id
			
				));
			}
			if($var16){
				$ch_id = 4;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"branch_id" => $user['branch_id'],
					"description" => $var16,
					"user_id" => $user_id
			
				));
			}
			if($var18){
				$ch_id = 5;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"branch_id" => $user['branch_id'],
					"description" => $var18,
					"user_id" => $user_id
			
				));
			}
			if($var20){
				$ch_id = 6;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"branch_id" => $user['branch_id'],
					"description" => $var20,
					"user_id" => $user_id
			
				));
			}
			if($var22){
				$ch_id = 7;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"branch_id" => $user['branch_id'],
					"description" => $var22,
					"user_id" => $user_id
			
				));
			}
			if($var23){
				$ch_id = 8;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"ph" => $ph,
					"cl" => $cl,
					"branch_id" => $user['branch_id'],
					"description" => $var23,
					"user_id" => $user_id
			
				));
			}
			if($var23_2){
				$ch_id = 8;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"ph" => $ph_2,
					"cl" => $cl_2,
					"branch_id" => $user['branch_id'],
					"description" => $var23_2,
					"user_id" => $user_id
			
				));
			}
			if($var11_1){
				$ch_id = 8;
				
				$insert_fas = $db->checklist_me_fas()->insert(array(
					"check_hour_id" => $ch_id,
					"item_id" => $id_item,
					"checked_at" => $time_now,
					"divisi_id" => '2',
					"ph" => $ph_1,
					"cl" => $cl_1,
					"branch_id" => $user['branch_id'],
					"description" => $var11_1,
					"user_id" => $user_id
			
				));
			}
			
			$insert_fas->update();
			
			$output = json_encode(array('type'=>'message', 'text' => '<div class="alert alert-success"><div class="danger">Data Berhasil Di Simpan</div></div>'));
			
			die($output);
		}
	}
}
?>