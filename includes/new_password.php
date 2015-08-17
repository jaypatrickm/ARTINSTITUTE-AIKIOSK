<?php
	require_once("check_password.php");
	$user_name = $_SESSION['user_name'];
	
	//validate the form!
	$errors = array();
	
	//create a new checkPwd object, and call various related functions.
	//this is based on David Powers' code from 2nd edition of PHP solutions.
	
	$check_password = new checkPassword($new_password, 8);
	$check_password->requireMixedCase();
	$check_password->requireNumbers(2);
	//$check_password->requireSymbols();
	$password_OK = $check_password->check();
	
	if (!$password_OK) {
		$errors = array_merge($errors, $check_password->getErrors());	
	}
	
	if ($new_password != $conf_new_password) {
		$errors[] = "Your passwords don't match.";	
	}
	
	if (!$errors) { //no errors found, registration can be inserted to DB
		echo "yay no errors, let's process that info now! <br />"; //for troubleshooting only
		
		$conn = dbConnect('admin'); //connect to the db, will need to write to DB so use admin user!
		
		//create a salt using the current timestamp
		$salt = time();
		
		//echo "salt is: $salt <br />"; //for troubleshooting
		
		//encrypt the password and salt
		
		$encrypt_password = sha1($new_password.$salt);
		echo "encrypted pwd is: $encrypt_password <br />"; //for troubleshooting
		echo "this is salt" . $salt . "<br/>";
		echo "this is encrypt_password" . $encrypt_password . "<br/>";
		echo "this is username" . $user_name . "<br/>";
		//prepare the SQL statement to insert user info into database
		//because this info comes from a form, we will use a prepared statement to do this
		
		$sql = " UPDATE user 
				SET salt = ?, user_password = ?
				WHERE user_name ='". $user_name ."'";
				
		//initialize statement
 		$stmt = $conn->stmt_init();
		
		$stmt = $conn->prepare($sql);
		
		//bind parameters and insert into database
		$stmt->bind_param('is', $salt, $encrypt_password);
		
		$stmt->execute();
		
			if($stmt->affected_rows == 1) {
				$success = "<p><strong>Your password has been updated! You may <a href=\"index.php\">login</a> now.</strong></p>"; 					
			} else {
				echo $stmt->errno;
				$errors[] = "Sorry, there was a problem with the database. Try again later.";	
			}
	}

?>