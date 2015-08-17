<?php
//run this script only if logout button has been clicked
if (array_key_exists('logout', $_POST)) {
	//empty the $_SESSION array
	$_SESSION = array();
	//invalidate the session cookie
	if (isset($_COOKIE[session_name()])) {
		setCookie(session_name(), '', time()-86400, '/');	
	}
	//end session and redirect
	session_destroy();
	header('Location: index.php');
	exit;
}
?>

<form id="logout_form" name="logout_form" method="post" action="">
<div id="logout_button"><input name="logout" type="submit" id="logout" value="Log Out" /></div>
</form>