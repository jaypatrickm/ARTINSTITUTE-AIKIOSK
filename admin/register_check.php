<?php
session_start();

	include("../includes/functions.php");
	
	//process the script only if the form has been submitted

	if (array_key_exists('security', $_POST)) {
		//process registration info entered on form, assign to variable names for easier use
		//trim any whitespace for entries
		$security = trim($_POST['security_code']);
		$redirect = "register.php"; 
		//include the registration processing file only if form has been submitted
		require_once("../includes/register_security.php");
			
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
        	<h2>Do you have permission to register an account?</h2>
        	<p>Enter Security Code.</p>
    	
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
                
                <form id="security" name="security" method="post" action="">
                	<p>
                    	<label for="security_code">Security Code* <span class="form_sm">(this should be given to you by the webmaster)</span></label>
                        <input type="text" name="security_code" id="security_code" />
                    </p>
                    <div id="submit">
                    	<input type="submit" name="security" id="security" value="security" />
                    </div>
                    
                </form>
        	<?php
                    
			} else { //include the form since we are coming to page fresh
		
			?>
            	<form id="security" name="security" method="post" action="">
                	<p>
                    	<label for="security">Security Code* <span class="form_sm">(this should be given to you by the webmaster)</span></label>
                        <input type="text" name="security_code" id="security_code" />
                    </p>
                    <div id="submit">
                    	<input type="submit" name="security" id="security" value="security" />
                    </div>
                    
                </form>
                
            <?php
			} //close the else with form
			?>
            </div><!-- end of admin_ref -->

</div><!-- end of container -->

</body>
</html>