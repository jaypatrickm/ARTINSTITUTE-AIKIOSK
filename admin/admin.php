<?php
if (array_key_exists('login', $_POST)) {
	//start the session
	session_start();
	
	$user_name = trim($_POST['user_name']); //removes any whitespace
	//$password = sha1($username.trim($_POST['pwd'])); // removes any whitespace and passes	password to the salting function sha1() and uses the username as the salt
	
	//Store username
	$_SESSION['user_name'] = $user_name;
	
	$user_password = trim($_POST['user_password']);
	
	//page to redirect to once successful login made
############ 
#### NEED TO UPDATE - redirect should guide them to their specific dashboard page	
	$redirect = "dashboard.php"; 
	require_once("includes/authenticate.php");
	
} else {
	session_start();
	include("includes/functions.php");
	//process the script only if the form has been submitted

	$error = ''; //initialize $error var to empty string
}

	//call the setSectionName function and assign it to $sectionName for use throughout the page
	$sectionName = setSectionName();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../css/aistyle.css" />
<script src="../js/jquery-1.8.0.min.js"></script>
<title>Art Institute - Orange County - Admin</title>
</head>

<body>
<div id="container">
	<div id="admin_log">
		<p>Welcome to the Art Institute Kiosk.</p> 
        
        <h2>Please log in</h2>
        <?php
		if (isset($error)) {
			echo "<p>$error</p>";	
		}
		
		?>
        <form id="login" name="login" method="post" action="">
        	<p>
            	<label for="user_name">User Name:</label>
                <input type="text"  name="user_name" id="user_name" />
            </p>
            <p>
            	<label for="textfield">Password:</label>
                <input type="password" name="user_password" id="user_password" />
            </p>
            <p>
            	<input type="submit" name="login" id="login" value="Login" />
            </p>
        
        </form>
        
        <p>Don't have an account yet? <a href="register.php"> Register</a> for one!</p>
	</div>

</div>
</body>
</html>