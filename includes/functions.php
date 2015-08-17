<?php
################################################
#Author : Jay Manalansan
#Description : Functions used throughout AI Kiosk
#Version : 1.0 
#Date : 17 Aug 2012
#
# They took the hobbits to Isengard!
# 
################################################

//INDEX
#MySQL Connection Script
#MySQL Disconneciton Script
#Strip out backlashes for security

################################
#Function: MySQL connection script
################################

function dbConnect($type) {
	if ($type == 'query') {
		$user = 'ai_kiosk_query';
		$pwd = 'aicaoc';	
	} elseif ($type == 'admin') {
		$user = 'ai_kiosk_admin';
		$pwd = 'aicaoc';	
	} else {
		exit('Unrecognized connection type');	
	}
	//connection code goes here
	$conn = new mysqli('localhost', $user, $pwd, 'ai_kiosk') or die ('Cannot open database');
	//echo "database connected<br>";  //for troubleshooting
	return $conn;
}
/*to use this function, include this file, and
call the function like this for the obquery user:
	$conn = dbConnect('query');
	
OR call the function like this for the admin user: 
	$conn = dbConnect('admin');
	
To adapt this for other project, change the username, password, and database name in the above code. 

*/

################################
#Function: MySQL disconnection script
################################

//use this function to close a database connection
//$conn is what we used to create a connection earlier, when we called the function dbConnect()
function dbClose($conn) {
	mysqli_close($conn);	
}


################################
#Function: Strip Out Backlashes for security
#written by David Powers, and included in the codebase for "PHP Solutions: Dynamic Web Design Made Easy"
################################

function nukeMagicQuotes() {
	if (get_magic_quotes_gpc()) {
		function stripslashes_deep($value) {
			$value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
			return $value;	
		}
	$_POST = array_map('stripslashes_deep', $_POST);
	$_GET = array_map('stripslashes_deep', $_GET);
	$_COOKIE = array_map('stripslashes_deep', $_COOKIE);
	}
}
?>