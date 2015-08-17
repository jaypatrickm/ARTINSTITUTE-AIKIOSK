<?php
session_start();
	include("../includes/functions.php");
	$security_code = $_SESSION['security'];
	
	if($security_code != 'slyscript') {
  	 header("Location: register_check.php");
	}


	//process the script only if the form has been submitted
	if (array_key_exists('register', $_POST)) {
		//process registration info entered on form, assign to variable names for easier use
		//trim any whitespace for entries
		$user_name = trim($_POST['user_name']);
		$user_password = trim($_POST['user_password']);
		$conf_user_password = trim($_POST['conf_user_password']);
		$email = trim($_POST['email']);
		$conf_email = trim($_POST['conf_email']);
		$_SESSION['security'] = '';
		//include the registration processing file only if form has been submitted
		require_once("../includes/register_user.php");
			
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="../css/aistyleadmin.css" />
<script src="../js/jquery-1.8.0.min.js"></script>
<title>Art Institute - Orange County - Admin</title>
</head>

<body>

<div id="container">	
 
    	<div id="kiosk_nav">
        	<a href="index.php"><p>Back</p></a>
        </div>
		<div id="header">
    		<h1>AI Kiosk Admin</h1>
        	<h2>Welcome to the AI Kiosk Admin page!</h2>
        	<p>Register here for an account.</p>
    	
    	</div>
        
        
      <div id="admin_reg">
        <?php
			
			if (isset($success)){ //success variable was set
				echo "<p>$success</p>";
			} elseif (isset($errors) && !empty($errors)) { //errors array is set and is not empty
				echo '<h3>Some errors were detected:</h3>';
				echo '<ul>';
				//loop through errors array and display for user
				foreach ($errors as $item) {
					echo "<li>$item</li>";	
				}
				echo '</ul>';
			
			
				//include the form so users can re-enter their info
				?>
                
                <form id="register" name="register" method="post" action="">
                	<p>
                    	<label for="user_name">Username* <span class="form_sm">(at least 8 characters long, must include letters and numbers, and upper and lower case)</span></label>
                        <input type="text" name="user_name" id="user_name" />
                    </p>
                    <p>
                    	<label for="user_password">Password* <span class="form_sm">(at least 8 characters long, must include letters and numbers, and upper and lower case)</span></label>
                        <input type="password" name="user_password" id="user_password" />
                    </p>
                    <p>	
                    	<label for="conf_user_password">Confirm Password*</label>
                        <input type="password" name="conf_user_password" id="conf_user_password" />
                    </p>
                     <p>
                    	<label for="email">Email* </label>
                        <input type="email" name="email" id="email" />
                    </p>
                    <p>	
                    	<label for="conf_email">Confirm Email*</label>
                        <input type="email" name="conf_email" id="conf_email" />
                    </p>
                    <div id="submit">
                    	<input type="submit" name="register" id="register" value="Register" />
                    </div>
                    
                </form>
        	<?php
                    
			} else { //include the form since we are coming to page fresh
		
			?>
            	<form id="register" name="register" method="post" action="">
                	<p>
                    	<label for="user_name">Username* <span class="form_sm">(at least 6 characters long)</span></label>
                        <input type="text" name="user_name" id="user_name" />
                    </p>
                    <p>
                    	<label for="user_password">Password* <span class="form_sm">(at least 8 characters long, must include letters and numbers, and upper and lower case)</span></label>
                        <input type="password" name="user_password" id="user_password" />
                    </p>
                    <p>	
                    	<label for="conf_user_password">Confirm Password*</label>
                        <input type="password" name="conf_user_password" id="conf_user_password" />
                    </p>
                    <p>
                    	<label for="email">Email* </label>
                        <input type="email" name="email" id="email" />
                    </p>
                    <p>	
                    	<label for="conf_email">Confirm Email*</label>
                        <input type="email" name="conf_email" id="conf_email" />
                    </p>
                    <div id="submit">
                    	<input type="submit" name="register" id="register" value="Register" />
                    </div>
                    
                </form>
                
            <?php
			} //close the else with form
			?>
            </div><!-- end of admin_ref -->

</div><!-- end of container -->

</body>
</html>