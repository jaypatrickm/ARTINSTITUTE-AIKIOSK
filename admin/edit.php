<?php
session_start();
ob_start(); // need to buffer output - need this since adding logout via external file
//if session variable not set, redirect to login page
if (!isset($_SESSION['authenticated'])) {
	header('Location: index.php');
	exit;
} else if (isset($_GET['project_id']) && !$_POST) { 	
	//echo $_SESSION['user_author_id'];
	include("../includes/functions.php"); 
	

		//remove backslashes
		nukeMagicQuotes();
		//$project_id = $_GET['project_id'];
		
		//initialize flags
		$OK = false;
		$done = false;
		$done2 = false;
		$done3 = false;
		
		//create database connection - note this connection is made with the admin account, that has permissions to update,insert, and delete records
		$conn = dbConnect('admin');
		
		//BUILD THE FORM WITH DETAILS OF THE IMAGE ENTRY CHOSEN TO EDIT
		//get details of the selected record based on the entry sent on the URL query string if it exists, and makes sure that the form
		//has not been submitted (which we can tell because the _POST array is empty when a form has NOT been submitted yet)

			//prepare first SQL query, 
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
				//free the result to get ready for the next query
				$stmt->free_result();
			}
			
			// get details of the entry the text is associated with in the lookup table
			if ($image_id != NULL) {
				$image_query = "SELECT * FROM image WHERE image_id =". $image_id;
				$result = $conn->query($image_query);
			
			// loop through the result of the lookup table query to populate the array
			while ($row = $result->fetch_assoc()) {
			  $image_filename = $row['image_filename'];
			  $_SESSION['image_filename'] = $image_filename;
			}
			//now that we are finished with the results set, release the db resources to allow a new query.
            $result->free_result();
			}
			
			if ($video_id != NULL) {
				$video_query = "SELECT * FROM video WHERE video_id =". $video_id;
				$result2 = $conn->query($video_query);
			
			// loop through the result of the lookup table query to populate the array
			while ($row = $result2->fetch_assoc()) {
			  $video_filename = $row['video_filename'];
			  $_SESSION['video_filename'] = $video_filename;
			}
			
			//now that we are finished with the results set, release the db resources to allow a new query.
            $result2->free_result();
			}
			
		} else {
			echo "No image id on $_GET ";
		}//end of if isset() for $_GET
		
		
		//SEND UPDATED Image DETAILS TO DATABASE AFTER FORM HAS BEEN EDITED OUT BY USER
		if (array_key_exists('update', $_POST)) {
			  // initialize flag
  				$OK = true;
				$project_id = $_POST['project_id'];
				
				//for troubleshooting
				echo 'project id on post, inside update, is: ' . $project_id . '<br/>';
				
				/*//for troublshooting
				if (isset($_POST['text_date'])) {
					echo 'text_date set on post!';
				} else {
					echo 'text_date NOT FOUND ON POST!';
				}*/
				
			  
			  // if entry has been selected,
			  // loop through the selected entry to build values string for INSERT query
			  /*if (isset($_POST['text_date'])) { //taking out for troubleshooting
				//$text_id = 44; //for troubleshooting
				//$entry_id = 64; //for troublshooting
			  	$new_date = $_POST['text_date'];
			  }
			  
			  // join values as a comma-separated string
			  if (!empty($new_date)) {
				$noEntry = false;
			  } else {
				$noEntry = true;
			  }*/
			  
			  // if OK proceed with the update
			  if ($OK) {
				// begin by updating the text table
				//prepare update query , no entry_id information
						$sql = 'UPDATE project 
						SET project_title = ?, project_author = ?, project_description = ?
						WHERE project_id = ?';
				
				//initialize statement
				$stmt = $conn->stmt_init();
				if ($stmt->prepare($sql)) {
					$stmt->bind_param('sssi', $_POST['project_title'], $_POST['project_author'], $_POST['project_description'], $_POST['image_id']);
					$done = $stmt->execute();
				 }
    			
				// if entry date has been selected, insert the new values in the lookup table
				/*
			  
				if (!$noEntry) {
				  $updateEntry = "INSERT INTO user_entry_lookup (date)
								 VALUES $new_date";
				  $done3 = $conn->query($updateEntry);
				} */
				
			}//end of if (OK) 
			
	} //end if array key exists for $_POST
		
		//redirect page on success 
		if ($done) {

			header('Location: edit_program.php?' . $_SESSION['prog_id'] . 'msg=3');  //send us back to the confirmation page and send along message code
			exit;
		} 
		
		//redirect page if  $_GET['spot_id'] not defined

		if (!isset($_GET['image_id'])) {
			echo "<p>can't find a image id </p>";
			header('Location: dashboard.php?' . $_SESSION['prog_id'] . 'msg=5');  //send us back to the confirmation page and send along message code
			exit;
		} 
		
		

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="../css/aistyleadmin.css" />
<script src="../js/jquery-1.8.0.min.js"></script>
<title>Art Institute - Orange County - Admin</title>
<script language="javascript" type="text/javascript">
$(document).ready(function() {


});
</script>
</head>

<body>

<div id="container">
	<div id="add_body">
        <div id="kiosk_nav">
        	<a href="add_project.php"><p>Back</p></a>
            <?php include("../includes/logout.php"); ?>
        </div>
		<div id="header">
    		<h1>AI Kiosk Admin</h1>
        	<h2>You chose to EDIT <?php echo $project_title; ?></h2> 
             <?php
			
			if (isset($success)){ //success variable was set
				echo "<p>$success</p>";
			} elseif (isset($errors) && !empty($errors)) { //errors array is set and is not empty
				echo '<h3>Some errors were detected:</h3>';
				echo '<ul>';
				//loop through errors array and display for user
				foreach ($errors as $item) {
					echo "<li>$item</li>";	
				}
			}
				?>
        	<p>You can now edit the project information.</p>	
            
            
    	</div>
        <?php	
			
			if($project_id ==0) { 
			?><p> INVALID REQUEST: record does not exist.</p>
            <?php } else { ?>
    	<form id="project_entry" name="project_entry" method="post" action="" enctype="multipart/form-data">
			  <input type="hidden" name="required" value="title: Insert Title, author: Insert Author" />
            
            <div id="add_left">
            	<ul>
                    <li><?php if ($image_filename) { ?><label for="image_filename" class="image_file_text">Image Upload (max 10MB.)</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max; ?>" />
                    <input class="image_file_text" name="image_filename" type="file" size="45"/>
                    <img src='uploads/<?php echo $image_filename; ?>' />
                    <br />
                    <?php } ?>
                    <?php if($image_url != NULL) { ?>
                    </li>
               		<li>
                    <img src="sources/file_graphic.png" alt="file_size_graphic" /></li>
                    <li>
                
            <a href="add2.php?area_id=<?php echo $area_id ?>"/> Add a Video Instead </a></li>
           		</ul>
            </div>
            <div id="add_right">
            	<ul>
                <li>
            	<div id="add_title">
                    <input name="title" type="text" class="required" id="title" maxlength="34" title="Please enter a project title." autofocus="autofocus">
                    <label for="title" class="label">Project Title (max 34 chars.)</label>
                </div>
                </li>
                <li>
                <div id="add_author">
                    <input name="author" type="text" class="required" id="author" maxlength="34" title="Please enter a project author.">
                    <label for="author" class="label">Project Author (max 34 chars.)</label>
                </div>
                </li>
                <li>
                <div id="add_program">
                    <select name="program" id="program" class="required" title="Please choose a program.">
                    <?php 
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['prog_id'] . '">' . $row['prog_name'] . '</option>';
                    }  		
                    ?>
                    </select>
                    <label for="program" class="label">Program</label>
                </div>  
                </li>
                <li>      
                <div id="add_description">
                    <textarea id="description" name="description" rows="15" cols="50" maxlength="599"></textarea>
                    <label for="description">Description (max 599 chars.)</label>
                </div>
                </li>
                <li>
                <div id="add_submit">
                <input type="submit" src="sources/admin_landing.png" name="project_entry" value="Submit" class="submit" />
                </div>
                </li>
            </div>
		</form>
 
    </div>
</div>
</body>
</html>

