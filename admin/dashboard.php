<?php
session_start();
ob_start(); // need to buffer output - need this since adding logout via external file
//if session variable not set, redirect to login page
if (!isset($_SESSION['authenticated'])) {
	header('Location: index.php');
	exit;	
} else {
	include("../includes/functions.php");
	
	//store user_name 
	$user_name = $_SESSION['user_name'] ;

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
            <?php include("../includes/logout.php"); ?>
        </div>
		<div id="header">
    		<h1>AI Kiosk Admin</h1>
        	<h2>You are logged in as, <?php echo $user_name;?>. </h2> 
        	<p>What would you like to do?</p>	
    	</div>
      	<div id="dashboard">
       		<ul>
            	<li><a href="add_project.php"><img src="sources/button_add.png" /></a></li>
                <li><a href="edit_project.php"><img src="sources/button_edit.png" /></a></li>
            </ul>
        </div><!-- end of dashboard -->

</div><!-- end of container -->

</body>
</html>