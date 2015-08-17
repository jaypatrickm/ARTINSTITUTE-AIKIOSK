<?php
session_start();
	//validate the form!
	$errors = array();
	
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
  
	} else {
 		$errors[] = 'Your email is invalid';
	}
	
	if (($email) != ($conf_email)) {
		$errors[] = 'Your emails do not match';	
	}
	
	if (!$errors) { //no errors found, we can use the email to find the user_name
		
		$conn = dbConnect('query'); //connect to the db, we are only looking so use query
		
		//get user's info from db
		$sql = 'SELECT user_name
			FROM user
			WHERE email = ?';
			
		//initialize and prepare statement
	
		$stmt = $conn->stmt_init();
		$stmt->prepare($sql);
		
		//bind the parameters
		$stmt->bind_param('s', $email);
		
		//bind the result, using a new var name for the stored username
		$stmt->bind_result($user_name);
		
		$stmt->execute();
		$stmt->fetch(); //this method gets the result after statement executed
		
		if (($user_name)!= '') {//stmt went through email found the username
		//add variable to the session
		//redirect to the admin page
		$_SESSION['user_name'] = $user_name;
		header("Location: $redirect");
		exit;
		} else {
			//no match, so need to send error message
			$errors[] = "Your email has not been found, please try a different email or register a new account.";	
		}
	}


?>