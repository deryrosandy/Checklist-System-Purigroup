<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('../location:login.php');
	
	}else{
		include '../core/init.php';
		include '../core/helper/myHelper.php';
		
		if(isset($_POST['id']) && isset($_POST['comments'])){
			
			$comments 	=	$_POST['comments'];
			$id 		=	$_POST['id'];
			$id_user 	= $_SESSION['id'];
			$time_now 	=  date('Y-m-d H:i:s');
			$insert_comments = $db->comments()->insert(array(
				"item_checklist_id" => $id,
				"users_id" => $id_user,
				"created" => $time_now,
				"description" => $comments
			));
			
			$insert_comments->update();
			
			$comments = $db->comments()
							->where("item_checklist_id", $id)
							->order("created DESC")
							->fetch();
			?>
				<div class="col-lg-12">
					<span class="mail-date pull-right">
						<?php echo tgl_indo_short($comments["created"]); ?>
					</span>
					<h4 class="text-primary"><?php echo $comments->users['first_name']; ?>  :</h4>
					<blockquote>
						<p><?php echo $comments['description']; ?></p>
					</blockquote>
				</div>
			<?php
		}
	}
?>