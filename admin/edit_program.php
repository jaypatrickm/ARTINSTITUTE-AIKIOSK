<?php
session_start();
ob_start(); // need to buffer output - need this since adding logout via external file
//if session variable not set, redirect to login page
if (!isset($_SESSION['authenticated'])) {
	header('Location: index.php');
	exit;	
} else if (isset($_GET['prog_id'])) { 	
	//echo $_SESSION['user_author_id'];
	include("../includes/functions.php"); 
	$prog_id = $_GET['prog_id'];
	$_SESSION['prog_id'] = $prog_id;
	$area_name = $_SESSION['area_name'];
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
<link rel="stylesheet" href="../css/jquery.nailthumb.1.1.min.css" />
<script src="../js/jquery.js"></script>
<script src="../js/jquery.nailthumb.1.1.min.js"></script>
<style type="text/css" media="screen">
.square {
width: 150px;
height: 150px;
}
.horiz {
width: 100px;
height: 70px;
}
.vert {
width: 100px;
height: 130px;
}
</style>
<script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('.nailthumb-container').nailthumb();
        });
</script>
<title>Art Institute - Orange County - Admin</title>
</head>

<body>

<div id="container">	
		<?php 
			//set up SQL query to user_text_lookup
			$sql = "SELECT  * FROM program WHERE prog_id=" . $prog_id;
	
			//submit the SQL query to the db and get result
			$result = $conn->query($sql) or die(mysqli_error($conn));
			
			 while ($row = mysqli_fetch_assoc($result)) {
					$prog_name = $row['prog_name'];
					$_SESSION['prog_name'] = $prog_name;
				}  		
		?>
        
    	<div id="kiosk_nav">
        	<a href="dashboard.php"><p>Back</p></a>
            <?php include("../includes/logout.php"); ?>
        </div>
		<div id="header">
    		<h1>AI Kiosk Admin</h1>
        	<h2>You are in <?php echo $area_name; ?> for <?php echo $prog_name; ?></h2> 
        	<p>Here are the projects you can EDIT or DELETE.</p>	
              <?php //check if conf set, and printout if so, if not, do nothing - this prevents an "undeclared variable" error
				//confirmation message code unset after used so not displayed on other pages
		
				if (isset($_SESSION['conf_msg'])) {
					echo '<p>'. $_SESSION['conf_msg'] . '</p>';
					unset($_SESSION['conf_msg']); //unsetting the session variable
					
				}// echo '<p class="'. $class. '">'. $conf_msg . '</p>';
            ?>  
    	</div>
        	
        <?php
        //set up SQL query to user_text_lookup
		$sql3 = "SELECT * FROM `project` 
				LEFT JOIN image 
				ON project.image_id = image.image_id 
				LEFT JOIN video 
				ON project.video_id = video.video_id 
				WHERE prog_id =" . $prog_id;
	
		//submit the SQL query to the db and get result
		$result3 = $conn->query($sql3) or die(mysqli_error($conn));
		  
		?>
        
        <div class="edit_project_list">
        	<ul>
        <?php 
                    //loop through results to build the list in the table
                    while($row = mysqli_fetch_assoc($result3)) { ?>
              	
                	
                	<?php echo '<li><h1>' .$row['project_title'] . '</h1><br />' ; ?>
                	<div class="nailthumb-container square">
                    	
                        	<a href="edit.php?project_id=<?php echo $row['project_id']; ?>"><img src="../uploads/<?php echo $row['image_filename']; ?>" alt="<?php echo $row['image_alt']; ?>"></a></div>
              
                    
                    <div class="end">
                    <a href="edit.php?project_id=<?php echo $row['project_id']; ?>">EDIT</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                    <a href="delete.php?project_id=<?php echo $row['project_id']; ?>">DELETE</a>
       				</div>
                  
                
                <?php echo '</li>'; } //close the loop?>
            </ul>
		</div>
            
        </div><!-- end of dashboard -->

</div><!-- end of container -->
<?php dbClose($conn); ?>
</body>
</html>