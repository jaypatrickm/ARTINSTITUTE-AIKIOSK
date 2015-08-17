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
        	<a href="dashboard.php"><p>Back</p></a>
            <?php include("../includes/logout.php"); ?>
        </div>
		<div id="header">
    		<h1>AI Kiosk Admin</h1>
        	<h2>You have chosen to ADD a project.</h2> 
        	<p>Please select the area of study for your project:</p>	
    	</div>
      	<div id="add_area">
       		<ul>
                <li><a href="add.php?area_id=1"><img src="../sources/design_btn.png" alt="Design" /></a></li>
                <li><a href="add.php?area_id=2"><img src="../sources/media_btn.png" alt="Media" /></a></li>
                <li><a href="add.php?area_id=3"><img src="../sources/fashion_btn.png" alt="Fashion" /></a></li>
                <li><a href="add.php?area_id=4"><img src="../sources/culinary_btn.png" alt="Culinary" /></a></li>
        	</ul>
        </div><!-- end of dashboard -->

</div><!-- end of container -->

</body>
</html>