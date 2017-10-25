<?php
if(!isset($_SESSION)){
    session_start();
	
	define ('PATH', realpath(dirname('../upload/')));
	
	//var_dump (PATH);
	
	include '../core/init.php';
	include '../core/helper/myHelper.php';
	
	$user = $db->users()
			->where("id", $_SESSION['id'])
			->fetch();
	
	$branch = strtolower($user->branch['name']);
	
	$time_now = date("Y-m-d");
	$id_item = $_POST['image_form_submit'];
	
	$timestamp = date("Ymd");
	
	$item = $db->item()
				->where("id", $id_item)->fetch();
	
	$branch_id = $user['branch_id'];
	
	$divisi = $item->divisi['name'];
	
	$bulan = getBulan(date("m"));
	$year_path = date("Y") . '/';
	
	if($_POST['image_form_submit']){
		
		$images_arr = array();
		
		foreach($_FILES['images']['name'] as $key=>$val){
			
				$image_name = $_FILES['images']['name'][$key];
				$file_basename = substr($image_name, 0, strripos($image_name, '.')); // get file extention
				$file_ext	= substr($image_name, strripos($image_name, '.')); // get file name
				$tmp_name 	= $_FILES['images']['tmp_name'][$key];
				$filesize 		= $_FILES['images']['size'][$key];
				$type 		= $_FILES['images']['type'][$key];
				$error 		= $_FILES['images']['error'][$key];
				$allowed_file_types = array('.jpg','.png','.gif','.jpeg');
				$extra_info = getimagesize($_FILES['images']['tmp_name'][$key]);
								
			if (in_array($file_ext,$allowed_file_types) && ($filesize < 2000000)){
				
				// Rename file
				$newfilename = $timestamp . $id_item . $file_ext;

				$images_arr[] = "data:" . $extra_info["mime"] . ";base64," . base64_encode(file_get_contents($_FILES['images']['tmp_name'][$key]));

				$targetDir = PATH . "/upload/" . $branch . "/" . strtolower($divisi) .'/';
				
				$newtargetyear = create_path_year($targetDir) . strtolower($year_path);
				
				$newtarget = create_path_bulan($newtargetyear) . strtolower($bulan);
				$new_path = create_path_bulan($newtarget) . "/";
				
				$dir_path = "upload/" . $branch . "/" . strtolower($divisi)	 . "/" . $year_path . strtolower($bulan) . "/";

				$targetFile = $dir_path . $newfilename;
				
				$insert_img = $db->item_image()->insert(array(
					"item_id" => $id_item,
					"image_source" => $targetFile,
					"branch_id" => $branch_id,
					"created" => date('Y-m-d H:i:s'),
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
		?>
		
		<div class="row">
			<div id="small-img" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 center">
				<div class="row">
				<?php 
				//Generate images view
					if(!empty($images_arr)){ $count=0;
						foreach($images_arr as $image_src){ $count++?>
						<div id="small-img" class="col-xs-12 col-sm-6 col-md-4 col-lg-3 center">
							<img src="<?php echo $image_src; ?>" class="img-responsive inline-block" alt="Responsive image"/>
						</div>
				<?php }
				}
				?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 upload-success">
				<div class="alert alert-success"><div class="danger">Berhasil</div></div>
			</div>
		</div>
	<?php /*
		var_dump($_POST['id']);
		
		$targetDir = "/upload/" . $branch . "/" . $divisi . "/";
			
		//var_dump($_FILES['file']);
		
		$fileName = $_FILES['file']['name'];
		
		$targetFile = $targetDir . $fileName;
		
		if(move_uploaded_file($_FILES['file']['tmp_name'], PATH . $targetFile)){
			var_dump ($targetFile);
		}
		*/
	}
}
?>