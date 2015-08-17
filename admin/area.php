<?php
session_start();
ob_start(); // need to buffer output - need this since adding logout via external file
//if session variable not set, redirect to login page
if (!isset($_SESSION['authenticated'])) {
	header('Location: index.php');
	exit;	
} else {
	include("../includes/functions.php"); 
	$allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
	$allowedTags.='<li><ol><ul><span><div><br><ins><del>';  	
	echo $_SESSION['user_author_id'];
	
	
}	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="../css/aistyle.css" />
<script src="../js/jquery-1.8.0.min.js"></script>
<title>Art Institute - Orange County - Admin</title>
</head>

<body>

<div id="content">
	<div id="area_body">
	<h2> You have chosen to Add a new project!</h2>
    <p> Please select the area of study for the project</p>
    <ul>
    	<a href="add.php?area_id=1"><li>Design</li></a>
        <a href="add.php?area_id=2"><li>Media Arts</li></a>
        <a href="add.php?area_id=3"><li>Fashion</li></a>
        <a href="add.php?area_id=4"><li>Culinary</li></a>
    </ul>
    </div>
    
</div>
</body>
</html>