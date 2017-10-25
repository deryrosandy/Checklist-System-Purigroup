<?php

if(!isset($_SESSION)){
    session_start();

	define ('PATH', realpath(dirname('../upload/')));
	
	include '../core/init.php';
	include '../core/helper/myHelper.php';

	$name			= 	$_POST['name'];
	$description	=	$_POST['description'];
	$users_id 		= 	$_SESSION['id'];
	$divisi_id 		= 	$_SESSION['divisi_id'];
	$branch_id 		= 	$_SESSION['branch_id'];
	$time_now 		= 	date("Y-m-d H:i:s");
	
	$timestamp = date("Ymd");
	$year_path = date("Y") . '/';
	
	$branch = $db->branch()->where("id", $branch_id)->fetch();
	
	$insert_memo = $db->internal_memo()->insert(array(
											"name" => $name,
											"description" => $description,
											"user_id" => $users_id,
											"divisi_id" => $divisi_id,
											"created_at" => $time_now
										));
										
	$insert_id = $db->internal_memo()->insert_id();
	
	foreach($_FILES['image_file']['name'] as $key=>$val){
	
			$image_name = $_FILES['image_file']['name'][$key];
			$file_basename = substr($image_name, 0, strripos($image_name, '.')); // get file name
			$file_ext	= substr($image_name, strripos($image_name, '.')); // get file extention
			$tmp_name 	= $_FILES['image_file']['tmp_name'][$key];
			$filesize 		= $_FILES['image_file']['size'][$key];
			
			$type 		= $_FILES['image_file']['type'][$key];
			$error 		= $_FILES['image_file']['error'][$key];
			$allowed_file_types = array('.jpg','.png','.gif','.jpeg','.pdf');
			$extra_info = getimagesize($_FILES['image_file']['tmp_name'][$key]);
							
		if (in_array($file_ext,$allowed_file_types) && ($filesize < 2000000)){
			
			// Rename file
			$newfilename = strtolower($branch['name']) . '_' . $timestamp . $insert_id . $file_ext;
			
			$images_arr[] = "data:" . $extra_info["mime"] . ";base64," . base64_encode(file_get_contents($_FILES['image_file']['tmp_name'][$key]));

			$targetDir = PATH . "/upload/internal_memo/";
			$newtarget = create_path_year($targetDir) . strtolower($year_path);
			$new_path = create_path_year($newtarget) . "/";
			
			$dir_path = "upload/internal_memo/" . $year_path;

			$targetFile = $dir_path . $newfilename;

			$insert_img = $db->attachment_internal_memo()->insert(array(
				"internal_memo_id" => $insert_id,
				"file" => $targetFile,
			));
		
			$insert_img->update();
		
			move_uploaded_file($tmp_name, PATH . '/' . $targetFile);
		
		
		}elseif (empty($file_basename)){
			// file selection error
			echo "Please select an Image to upload.";
		}elseif($filesize > 1024){
			// file size error
			echo "The file you are trying to upload is too large.";
		}else{
			// file type error
			echo "Only these file typs are allowed for upload: " . implode(', ',$allowed_file_types);
			unlink($_FILES["file"]["tmp_name"]);
		}
	}
	
	header ('Location: ../dashboard.php');
	
	}
?>