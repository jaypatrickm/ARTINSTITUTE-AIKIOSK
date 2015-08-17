<?php
	require_once("check_password.php");
	
	//validate the form!
	$user_name_min_chars = 6;
	$errors = array();
	
	if (strlen($user_name) == 0) {
		$errors[] = 'Please enter desired username.';	
	} 
	
	if (strlen($user_name) < $user_name_min_chars) {
		$errors[] = "Username must be at least $user_name_min_chars characters.";	
	}
	
	if (preg_match('/\s/', $user_name)) {
		$errors[] = 'Username should not contain spaces.';	
	}
	
	if (($email) != ($conf_email)) {
		$errors[] = 'Your emails do not match';	
	}
	
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
  
	} else {
 		$errors[] = 'Your email is invalid';
	}
	
	//create a new checkPwd object, and call various related functions.
	//this is based on David Powers' code from 2nd edition of PHP solutions.
	
	$check_password = new checkPassword($user_password, 8);
	$check_password->requireMixedCase();
	$check_password->requireNumbers(2);
	//$check_password->requireSymbols();
	$password_OK = $check_password->check();
	
	if (!$password_OK) {
		$errors = array_merge($errors, $check_password->getErrors());	
	}
	
	if ($user_password != $conf_user_password) {
		$errors[] = "Your passwords don't match.";	
	}
	
	if (!$errors) { //no errors found, registration can be inserted to DB
		echo "yay no errors, let's process that info now! <br />"; //for troubleshooting only
		
		$conn = dbConnect('admin'); //connect to the db, will need to write to DB so use admin user!
		
		//create a salt using the current timestamp
		$salt = time();
		
		//echo "salt is: $salt <br />"; //for troubleshooting
		
		//encrypt the password and salt
		
		$encrypt_password = sha1($user_password.$salt);
		echo "encrypted pwd is: $encrypt_password <br />"; //for troubleshooting
		
		//prepare the SQL statement to insert user info into database
		//because this info comes from a form, we will use a prepared statement to do this
		
		$sql = 'INSERT into user (user_name, salt, user_password, email)
				VALUES (?, ?, ?, ?)';
		
		$stmt = $conn->stmt_init();
		
		$stmt = $conn->prepare($sql);
		
		//bind parameters and insert into database
		$stmt->bind_param('ssss', $user_name, $salt, $encrypt_password, $email);
		
		$stmt->execute();
		
		//checking to make sure that the userName hasn't already been used, if not then they
		//are registered and can login. If already used, then have to choose another.
		//Remember, we set up the db so that userName had to be unique!
		
			if($stmt->affected_rows == 1) {
				$success = "<p><strong>$user_name has been registered! You may <a href=\"index.php\">login</a> now.</strong></p>"; 					
			} elseif ($stmt->errno == 1062) { //this is the error number assigned by mySQL when a field is
											  //marked as being uniqure, and when a new record is inserted
											  //that is the same as an existing record
				$errors[] = "$user_name is already in use. Sorry, you'll have to choose another.";						
			} else {
				echo $stmt->errno;
				$errors[] = "Sorry, there was a problem with the database. Try again later.";	
			}
	}

?>