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
		
		//set up SQL query to user_text_lookup
		$sql = "SELECT  * FROM area, program WHERE program.area_id = area.area_id AND area.area_id=" . $area_id;
	
		//submit the SQL query to the db and get result
		$result = $conn->query($sql) or die(mysqli_error($conn));
		
}



//process the script only if the form has been submitted
//set max upload size
$max = 10485760;
//$max = 104857600; //in bytes
	if (isset($_POST['project_entry'])) {
		//define the path to the upload folder
		//$destination = 'C:/upload_test/';// WIN
		//$destination = '/Users/jae/upload_test/'; //MAC
		$destination = 'C:/wamp/www/aikiosk/uploads/';
		require_once('../classes/Ps2/Upload.php');
		try {
			$upload = new Ps2_Upload($destination);
			$upload->setMaxSize($max);
			$upload->move();
			$result = $upload->getMessages();	
			$upload->getFileName();
			//process text form, assign to variable names for easier use
			$image_filename = $upload->getFileName();
			//$image_url = $_POST['image_url'];
			//$image_desc = $_POST['image_desc'];
			//echo "does this work";
			//echo $field['name'];
			//echo "we grabbed this from Upload: " . $upload->getFileName() . "<br/>";
			
			//echo "Check this!<br />";
			//echo $image_filename . "<br />";
		
			//include the text validation form
		} catch (Exception $e) {
			echo $e->getMessage();	
		}
		//move_uploaded_file($_FILES['image']['tmp_name'], $destination . $_FILES['image']['name']);
		//echo "preparing to send this to db: " . $image_filename;
		//process text form, assign to variable names for easier use
		//$image_filename = $_POST['image_filename'];
		$prog_id = $_POST['program'];
		if (strlen($_POST['title']) != 0) {
			$project_title = $_POST['title'];
			$_SESSION['project_title'] = $project_title;
		}
		if (strlen($_POST['author']) != 0) {
			$project_author = $_POST['author'];
			$_SESSION['project_author'] = $project_author;
		}
		if (strlen($_POST['description']) != 0) {
			$project_description = $_POST['description'];
			$_SESSION['project_description'] = $project_description;
		}
		
		//echo "does this work";
		//echo $field['name'];
		//echo $_FILES['image']['name'];
		//echo $image_url . "<br />";
		//echo $image_filename . "<br />";
		//echo $image_desc . "<br />"; 
		//include the text validation form
		require_once("../includes/validation.php");	

		$area_id = $_GET['area_id'];

		//set up SQL query to user_text_lookup
		$sql = "SELECT  * FROM area, program WHERE program.area_id = area.area_id AND area.area_id=" . $area_id;
	
		//submit the SQL query to the db and get result
		$result = $conn->query($sql) or die(mysqli_error($conn));
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
    	<?php 
			//set up SQL query to user_text_lookup
			$sql2 = "SELECT  * FROM area WHERE area_id=" . $area_id;
	
			//submit the SQL query to the db and get result
			$result2 = $conn->query($sql2) or die(mysqli_error($conn));
			
			 while ($row = mysqli_fetch_assoc($result2)) {
					$area_name = $row['area_name'];
				}  		
		?>
        <div id="kiosk_nav">
        	<a href="add_project.php"><p>Back</p></a>
            <?php include("../includes/logout.php"); ?>
        </div>
		<div id="header">
    		<h1>AI Kiosk Admin</h1>
        	<h2>You have chosen to ADD into <?php echo $area_name; ?></h2> 
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
        	<p>Please fill out your project information</p>	
            
            
    	</div>
        
    	<?php	
	
	
		if (isset($result)) {
			/*echo '<ul>';
			foreach ($result as $message) {
			echo "<li>$message</li>";
			if ($result == true) {
				//echo "now uploading image";	
				}
			}
			echo '</ul>';*/
		
		 
		/*	if (isset($success)){ //success variable was set
				echo "<p>$success</p>";	
			} elseif (isset($errors)  && !empty($errors)) { //errors array is set and is not empty
				echo '<h3>Some errors were detected:</h3>';
				echo '<ul>';
				//loop through errors array and display for user
				foreach ($errors as $item) {
					echo "<li>$item</li>";
				}
				echo '</ul>';
		*/
				//include the form so users can re-enter their info
		?>
        
        
    	<form id="project_entry" name="project_entry" method="post" action="" enctype="multipart/form-data">
			  <input type="hidden" name="required" value="title: Insert Title, author: Insert Author" />
            
            <div id="add_left">
            	<ul>
                    <li><label for="image_filename" class="image_file_text">Image Upload (max 10MB.)</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max; ?>" />
                    <input class="image_file_text" name="image_filename" type="file" size="45"/></li>
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
    	<?php
                
			} else { //include the form since we are coming to page fresh
				
		?>
    	<form id="project_entry" name="project_entry" method="post" action="" enctype="multipart/form-data">
			  <input type="hidden" name="required" value="title: Insert Title, author: Insert Author" />
            
            <div id="add_left">
            	<ul>
                    <li><label for="image_filename" class="image_file_text">Image Upload (max 10MB.)</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max; ?>" />
                    <input class="image_file_text" name="image_filename" type="file" size="45"/></li>
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
        <?php
			} //close the else with form
		?>
    </div>
</div>
</body>
</html>