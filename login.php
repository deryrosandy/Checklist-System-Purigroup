<?php session_start(); ?>
<?php
session_destroy();
$_SESSION['username']  	= $value['username'];
		$_SESSION['firstname']	= $value['firstname'];
		$_SESSION['password']   = $value['password'];
		$_SESSION['id']	  		= $value['id'];
		$_SESSION['user_type']	= $value['user_type'];
		$_SESSION['branch_id']	= $value['branch_id'];
		$_SESSION['divisi_id']	= $value['divisi_id'];
?>

<?php if(!empty($_SESSION['username'])){
		
		header ("Location: dashboard.php");
		
	}else{
?>

<!doctype html>
<html class="no-js">
<head>
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Checklist System Purigroup</title>
        <meta name="description" content="Checklist System">
        <meta name="viewport" content="width=device-width">
        <link rel="shortcut icon" href="assets/img/puri.png">
        <link rel="stylesheet" href="dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="dist/css/veneto-admin.min.css">
        <link rel="stylesheet" href="demo/css/style.css">
        <link rel="stylesheet" href="dist/assets/font-awesome/css/font-awesome.css">

        <!--[if lt IE 9]>
        <script src="dist/assets/libs/html5shiv/html5shiv.min.js"></script>
        <script src="dist/assets/libs/respond/respond.min.js"></script>
        <![endif]-->

    </head>
    <body class="body-sign-in">
    <div class="container">
        <div class="panel panel-default form-container">
            <div class="panel-body" style="padding: 15px 50px 25px;">
                <form id="loginForm" role="form" action="action/check_login.php" method="POST">
                    <h3 class="text-center margin-xs-bottom">Login System</h3>
                    <h6 class="text-center margin-xs-bottom">&nbsp;</h6>

                    <div class="form-group text-center">
                        <label class="sr-only"" for="username">Username</label>
						<div class="row">
							<span class="hidden-xs col-sm-12 text-left">Username:</span>
                        </div>
						<input type="username" name="username" class="form-control input-lg required" title="Username Harus Di Isi" id="username" placeholder="">
                    </div>
                    <div class="form-group text-center">
                        <label class="sr-only required" for="password">Password</label>
                        <div class="row">
							<span class="hidden-xs col-sm-12 text-left">Password:</span>
						</div>
						<input type="password" name="password" class="form-control input-lg required" title="Password Harus Di Isi" id="password" placeholder="">
                    </div>
                    
					<input type="submit" value="Sign In" class="btn btn-primary btn-block btn-lg">
                
				</form>
            </div>
            <div class="panel-body text-center">
                <div class="margin-bottom">
                    <a class="text-muted text-underline" href="javascript:;">Forgot Password?</a>
                </div>
                <!--
				<div>
                    Don't have an account? <a class="text-primary-dark" href="pages-sign-up.html">Sign up here</a>
                </div>
				-->
            </div>
        </div>
    </div>
		<script src="dist/assets/libs/jquery/jquery.min.js"></script>
		<script src="dist/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$("#loginForm").validate();
			})
		</script>
	</body>
</html>

<?php } ?>
