<?php
session_start();
ob_start();  // need to buffer output - need this since adding logout via external file
//if session variable not set, redirect to login page
if (!isset($_SESSION['authenticated'])) {
	header('Location: index.php');
	exit;
}

?>
<?php include("../includes/functions.php"); 

		//remove backslashes
		nukeMagicQuotes();
		
		//create database connection 
		$conn = dbConnect('admin');
		
		//initialize flags
		$OK = false;
		$deleted = false;
		$deleted2 = false;
		$deleted3 = false;
		
		
		
		if (isset($_GET['project_id']) && !$_POST) {
			//prepare SQL query
			$sql = 'SELECT project_id, project_title, project_author, project_description, prog_id, image_id, video_id
					FROM project
					WHERE project_id = ?';
					
			//initialize statement
			$stmt = $conn->stmt_init();
			
			if ($stmt->prepare($sql)) {
				//bind the query parameters
				$stmt->bind_param('i', $_GET['project_id']);
				
				//bind the results to variables
				$stmt->bind_result($project_id, $project_title, $project_author, $project_description, $prog_id, $image_id, $video_id);
				
				//execute the query, and get the result
				$OK = $stmt->execute();
				$stmt->fetch();
			}
		} //end if stmt
		
	//if confirm deletion button has been clicked, delete the record
		if (array_key_exists('delete', $_POST)) {
			//prepare delete query
			$sql = 'DELETE FROM project
					WHERE project_id = ?';
					
			//echo $sql;
			
			//initialize statement
			$stmt = $conn->stmt_init();
			if ($stmt->prepare($sql)) {
				$stmt->bind_param('i', $_POST['project_id']);
				$deleted = $stmt->execute();
			}
			
			if (($_POST['image_id']) != NULL) {
				 
				$sql2 = 'DELETE FROM image
				WHERE image_id = ?';
						
				//echo $sql2;
				
				//initialize statement
				$stmt2 = $conn->stmt_init();
				if ($stmt2->prepare($sql2)) {
					$stmt2->bind_param('i', $_POST['image_id']);
					$deleted2 = $stmt2->execute();
				}
			}
			
			if (($_POST['video_id']) != NULL) {
				 
				$sql3 = 'DELETE FROM video
				WHERE video_id = ?';
						
				//echo $sql3;
				
				//initialize statement
				$stmt3 = $conn->stmt_init();
				if ($stmt3->prepare($sql3)) {
					$stmt3->bind_param('i', $_POST['video_id']);
					$deleted3 = $stmt3->execute();
				}
			}
						

		} // end array_key_exists
		
		
			//redirect page if deleted
		
		if ($deleted) {
			$conf_msg = "Your entry successfully deleted";
	  		$_SESSION['conf_msg'] = $conf_msg;
			header('Location: edit_program.php?prog_id=' . $_SESSION['prog_id']);  
			exit;
		} 
		
		//redirect page if cancel button clicked

		if (array_key_exists('cancel_delete', $_POST)) {
			$conf_msg = "Process cancelled";
	  		$_SESSION['conf_msg'] = $conf_msg;
			$class = "msg";
	  		$_SESSION['class'] = $class;
			header('Location: edit_program.php?prog_id=' . $_SESSION['prog_id']);  
			exit;
		} 
		


		if (!isset($_GET['project_id'])) {
			$conf_msg = "There was an error processing your request. Please try again later";
	  		$_SESSION['conf_msg'] = $conf_msg;
			$class = "error";
	  		$_SESSION['class'] = $class;
			header('Location: edit_program.php?prog_id=' . $_SESSION['prog_id']); 
			exit;
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
		<div id="kiosk_nav">
        	<a href="dashboard.php"><p>Back</p></a>
            <?php include("../includes/logout.php"); ?>
        </div>
		<div id="header">
    		<h1>AI Kiosk Admin</h1>
        	<h2>You are in <?php echo $_SESSION['area_name'];?> for <?php echo $_SESSION['prog_name']; ?></h2> 
        	<p>You are about to DELETE <?php echo $project_title ?>.</p>	
    	</div>	
	
		<div id="delete_project">
        

               <?php 
        	if($project_id == 0) { ?>
                <p>INVALID REQUEST: record does not exist.</p>
                <?php } else { ?>
                    
            
                <p>Are you sure you want to PERMANENTLY DELETE the record?  This action CANNOT be undone!</p> 
                
<p>
                    <h2><?php echo htmlentities($project_title); ?></h2>


                </div> </p>
                
                <?php } ?>
            
                <form id="delete" name="delete" method="post" action="">
                    <p>
                        <?php if ($project_id > 0 ) { ?>
                            <input type="submit" name="delete" value="Delete" />
                        <?php } ?>
                            <input type="submit" name="cancel_delete" value="Cancel" />
                        <?php if ($project_id > 0 ) { ?>
                            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />

			<input type="hidden" name="image_id" value="<?php echo $image_id; ?>" />
            <input type="hidden" name="video_id" value="<?php echo $video_id; ?>" />
			
                        <?php } ?>
                    </p>
               </form>     
            
                <?php
                    //close db
                    dbClose($conn);
                ?>

		</div>
		<!-- End delete project -->

	</div>
	<!-- End Container -->
</body>
<!-- End Body -->
</html> 