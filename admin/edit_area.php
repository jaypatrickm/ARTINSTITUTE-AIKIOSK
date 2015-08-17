<?php
session_start();
ob_start(); // need to buffer output - need this since adding logout via external file
//if session variable not set, redirect to login page
if (!isset($_SESSION['authenticated'])) {
	header('Location: index.php');
	exit;	
} else if (isset($_GET['area_id'])) { 	
	//echo $_SESSION['user_author_id'];
	include("../includes/functions.php"); 
	$area_id = $_GET['area_id'];
	
		//create database connection - note this connection is made with the admin account, that has permissions to update,insert, and delete records
		$conn = dbConnect('query');
		/*
		//set up SQL query to user_text_lookup
		$sql = "SELECT  * FROM area, program WHERE program.area_id = area.area_id AND area.area_id=" . $area_id;
	
		//submit the SQL query to the db and get result
		$result = $conn->query($sql) or die(mysqli_error($conn));
		
        while ($row = mysqli_fetch_assoc($result)) {
                       echo '<option value="' . $row['prog_id'] . '">' . $row['prog_name'] . '</option>';
              }  		
*/
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
		<?php 
			//set up SQL query to user_text_lookup
			$sql2 = "SELECT  * FROM area WHERE area_id=" . $area_id;
	
			//submit the SQL query to the db and get result
			$result2 = $conn->query($sql2) or die(mysqli_error($conn));
			
			 while ($row = mysqli_fetch_assoc($result2)) {
					$area_name = $row['area_name'];
					$_SESSION['area_name'] = $area_name;
				}  		
		?>
        
    	<div id="kiosk_nav">
        	<a href="edit_project.php"><p>Back</p></a>
            <?php include("../includes/logout.php"); ?>
        </div>
		<div id="header">
    		<h1>AI Kiosk Admin</h1>
        	<h2>You have chosen to Edit a project in <?php echo $area_name ?></h2> 
        	<p>Please select the program<br />  for the project you want to edit.</p>	
    	</div>
        <?php
        //set up SQL query to user_text_lookup
		$sql3 = "SELECT  * FROM area, program WHERE program.area_id = area.area_id AND area.area_id=" . $area_id;
	
		//submit the SQL query to the db and get result
		$result3 = $conn->query($sql3) or die(mysqli_error($conn));
		
       
			  
		?>
      	<div id="edit_program_list">
       		<ul>
                <?php 
				 while ($row = mysqli_fetch_assoc($result3)) {
                       echo "<li><a href='edit_program.php?prog_id=" . $row['prog_id'] . "'><img src='../sources/" . $row['prog_imagefile'] . "' alt='" . $row['prog_name'] . "' /></a></li>" ;
              		}  	
				?>
        	</ul>
        </div><!-- end of dashboard -->

</div><!-- end of container -->
<?php dbClose($conn); ?>
</body>
</html>