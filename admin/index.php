<?php
if (array_key_exists('login', $_POST)) {
	//start the session
	session_start();
	
	$user_name = trim($_POST['user_name']); //removes any whitespace
	//$password = sha1($username.trim($_POST['pwd'])); // removes any whitespace and passes	password to the salting function sha1() and uses the username as the salt
	
	$user_password = trim($_POST['user_password']);
	
	//page to redirect to once successful login made
############ 
#### NEED TO UPDATE - redirect should guide them to their specific dashboard page	
	$redirect = "dashboard.php"; 
	require_once("../includes/authenticate.php");
	
} else {
	session_start();
	include("../includes/functions.php");
	//process the script only if the form has been submitted

	$error = ''; //initialize $error var to empty string
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../css/aistyleadmin.css" />
<script src="../js/jquery-1.8.0.min.js"></script>
<title>Art Institute - Orange County - Admin</title>
</head>

<body>
<div id="container">
		<div id="kiosk_front">
        	<a href="../index.php"><img src="../sources/house.png" /></a><p>To front of kiosk</p>
        </div>
		<div id="header">
    		<h1>AI Kiosk Admin</h1>
        	<h2>Welcome to the AI Kiosk Admin page!</h2>
        	<p>Here you can add, edit, or delete, projects shown throughout the kiosk. If you do not have access to these pages please contact Scot Trodick.</p>
        	<p>Please log in Below</p>
    	
    	</div>
		<div id="admin_log">
        	<?php
			if (isset($error)) {
				echo "<p>$error</p>";	
			}
		
			?>
        	<form id="login" name="login" method="post" action="">
        		<div>
            		<label for="user_name">Username</label>
                	<input type="text"  name="user_name" id="user_name" autofocus />
            	</div>
            
            	<div>
            		<label for="textfield">Password</label>
                	<input type="password" name="user_password" id="user_password" />
            	</div><a href="forgot_password.php" class="forgot">Forgot your password?</a>
            
            	<div id="submit">
                	<input type="submit" src="sources/admin_landing.png" name="login" id="login" value="login">
            	</div>
        
        	</form>
		</div>


</div>
</body>
</html>