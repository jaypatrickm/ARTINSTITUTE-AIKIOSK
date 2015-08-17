<?php
//session_start();
//ob_start();
	//validate the form!
	$errors = array();

	if (strlen($video_filename) == 0) {
		$errors[] = "Your file could not be entered";	
	}
	/*
	if (isset($_POST['image_url'])) {
		function isValidURL($url)
			{
			return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
			}
		if(!isValidURL($fldbanner_url))
			{
			$errors[] .= "* Please enter valid URL including http://<br>";
			}
	} 
	*/
	//echo 'validation!';
	//sending to database after validation is complete from upload. 


	if (/*($success == true) ||*/ (!$errors)) { //no errors found, text can be inserted to DB
		echo "yay no errors, let's insert text now! <br />"; //for troubleshooting only
		echo $video_filename . '<br />';
		echo $project_title . '<br />';
		$conn = dbConnect('admin'); //connect to the db, will need to write to DB so use admin user!
		
		
		$sql = 'INSERT into video (video_filename, video_alt)
				VALUES (?, ?)'; 
		
		$stmt = $conn->stmt_init();
		
		$stmt = $conn->prepare($sql);
		
		//bind parameters and insert into database
		$stmt->bind_param('ss', $video_filename, $project_title);
		
		$stmt->execute();
		
		//free result
		$stmt->free_result();
		
		//prepare sql for image id
		$sql = 'SELECT video_id FROM video ORDER BY video_id DESC LIMIT 1';
		//prepare stmt
		if ($stmt->prepare($sql)) {
			//execute statement
			$stmt->execute();
			//bind the result to $text_id
			$stmt->bind_result($get_video_id);
			//fetch value
			while ($stmt->fetch()) {
				echo "<p> video_id for the image entry just posted is " . $get_video_id . "</p>";
				$video_id = $get_video_id;	
			}
			
		} 
		
		//create sql to insert into user image lookup
		$sql2 = 'INSERT into project (project_title, project_author, project_description, prog_id, video_id)
				 VALUES (?, ?, ?, ?, ?)';
				 
		$stmt2 = $conn->stmt_init();
		
		$stmt2 = $conn->prepare($sql2);
		
		//bind parameters
		$stmt2->bind_param('sssii', $project_title, $project_author, $project_description, $prog_id, $video_id);
		
		//execute stmt
		$stmt2->execute();
		
		//free result
		$stmt2->free_result();
		
		//checking to make sure that the userName hasn't already been used, if not then they
		//are registered and can login. If already used, then have to choose another.
		//Remember, we set up the db so that userName had to be unique!
		
			if($stmt2->affected_rows == 1) {
				$success = "<p><strong>Entry submitted.</strong></p>"; 					
			} else {
				echo $stmt2->errno;
				$errors[] = "Sorry, there was a problem with the database. Try again later.";	
			}
	}

?>