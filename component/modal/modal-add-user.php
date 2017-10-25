<!DOCTYPE html>
<html>
	<head>
	  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
	  <title>Remote file for Bootstrap Modal</title>  
	</head>
	<body>
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			 <h4 class="modal-title">Add Manager Pengganti</h4>
		</div><!-- /modal-header -->
		<div class="modal-body">
			<form id="userAddForm" action="action/add_user_pengganti.php" name="form-tambah-pengguna" method="POST" class="form-horizontal form-bordered" role="form">
				<div class="panel panel-default">
					<div class="panel-body form_user_p">
						<div class="form-group">
							<label class="control-label col-sm-3">Username</label>

							<div class="controls col-sm-6">
								<input type="text" name="username" class="form-control required" title="username" placeholder="Insert Username">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-3">First Name</label>

							<div class="controls col-sm-6">
								<input type="text" name="first_name" class="form-control required"  title="first_name" placeholder="Insert First Name">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-3">Last Name</label>

							<div class="controls col-sm-6">
								<input type="text" name="last_name" class="form-control required"  title="last_name" placeholder="Insert Last Name">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-3">Email</label>

							<div class="controls col-sm-6">
								<input type="email" name="email" class="form-control" placeholder="Insert Email">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-3">Password</label>

							<div class="controls col-sm-6">
								<input type="password" id="password" name="password"  title="Password Lengkap Harus Di Isi" class="form-control required" placeholder="Insert Password">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-3">Password Again</label>

							<div class="controls col-sm-6">
								<input type="password" equalTo="#password" name="ulangi-password" class="form-control required"  title="Password Tidak Sama" placeholder="Insert Password Again">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-3">Phone Number</label>

							<div class="controls col-sm-6">
								<input type="text" name="phone_number" class="form-control" placeholder="Insert Phone Number">
							</div>
						</div>
					
						<div class="form-group modal-footer">
							<div class="controls col-sm-6 col-sm-offset-3">
								<button type="button" class="btn btn-default btn_closed" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-primary btn_submit">Submit</button>
							</div>
						</div>
						
						<div class="form-group status_area">
							
						</div>
						
					</div>				
				</div>
			</form>
		</div>
		<script type="text/javascript">
		$(document).ready(function(){
			$("#userAddForm").on("click", ".btn_submit", function(){ 
				
				var username		= $('input[name="username"]').val();
				var first_name		= $('input[name="first_name"]').val();
				var last_name		= $('input[name="last_name"]').val();
				var email			= $('input[name="email"]').val();
				var password		= $('input[name="password"]').val();
				var phone_number	= $('input[name="phone_number"]').val();
				
				var proceed = true;
				
				if(proceed){
					//get input field values data to be sent to server
					post_data = {
						username,first_name,last_name,email,password,phone_number									
					};
					
					//Ajax post data to server
					$.post('action/add_user_pengganti.php', post_data, function(response){ 
						//console.log('dor');
						if(response.type == 'error'){ 
							output = '<div class="error">'+response.text+'</div>';
							console.log ('error');
						}else{
							output = response.text;
						}
						$(".status_area").hide().html(output).slideDown();
					}, 'json');
				}
			});
		});
		/*
		$(document).ready(function(){
			$("#userAddForm").on("click", ".btn_closed", function(){
					$('#modalUser').modal('hide');
			});
		});
		*/
		</script>
	</body>
</html>