<?php

	
	//validate the form!
	$errors = array();
	
	if (strlen($security) == 0) {
		$errors[] = 'Please enter the security code.';	
	} 

	if ($security != 'slyscript') {
		$errors[] = "That is not the correct security code.";	
	}
	

	if (!$errors) { //no errors found, registration can be inserted to DB
		echo "no errors bro.";
		$_SESSION['security'] = $security;
		header("Location: $redirect");

	} 
	

?>