<?php
include("functions.php");
//script to authenticate users as they login

$conn = dbConnect('query'); //connect with the read-only user account, since not writing to db

//get user's info from db
$sql = 'SELECT salt, user_password
		FROM user
		WHERE user_name = ?';
		
//initialize and prepare statement

$stmt = $conn->stmt_init();
$stmt->prepare($sql);

//bind the parameters
$stmt->bind_param('s', $user_name);

//bind the result, using a new var name for the stored password
$stmt->bind_result($salt, $stored_password);

$stmt->execute();
$stmt->fetch(); //this method gets the result after statement executed

//echo "salt is: $salt <br/>"; //troubleshooting
//echo "stored password is $stored_password <br />"; //troubleshooting
//echo "user submitted password with salt is: " . sha1($user_password.$salt) . "<br />"; //troubleshooting - should match above

//now that we have the user's info, need to encrypt the password entered by the user by combining it
//with the stored salt, and pass them both to sha1(). This will enable us to compare the stored password
//(which has been encrypted with the salt) to the entered password (now that we've also encrypted that one
//with the salt as well). 

//if the two match, then we can create the session variables needed to allow access to the userDash. Redirect
//user to the userDash page

//encrypt submitted password with the salt and compare with stored password:
if (sha1($user_password.$salt) == $stored_password) {//passwords are the same
	//add variable to the session
	$_SESSION['authenticated'] = "AIOkay"; //you can set this to anything
	//redirect to the admin page
	$_SESSION['user_name'] = $user_name;
	header("Location: $redirect");
	exit;
} else {
	//no match, so need to send error message
	$error = "Invalid username or password. Please try again.";	
}

?>