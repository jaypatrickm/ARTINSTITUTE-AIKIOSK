<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/aistyle.css" />
<script src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
//main slideshow											 
$('#media_link a').addClass('media_link_active');

}); // end ready()
</script>
<title>Art Institute - Orange County</title>
</head>

<body>
<div id="container">
	
	<?php include("includes/header.php");?>
    <div id="media_body"> 
		<div id="media_left">
    		<?php include("includes/nav.php");?>
    	</div>
    
    	<div id="media_right">
    		<ul>
        		<li><a href="program.php"><img src="sources/program_web.png" /></a></li>
            	<li><a href="program.php"><img src="sources/program_animation.png" /></a></li>
            	<li><a href="program.php"><img src="sources/program_photography.png" /></a></li>
            	<li><a href="program.php"><img src="sources/program_game.png" /></a></li>
                <li><a href="program.php"><img src="sources/program_audio.png" /></a></li>
        	</ul>
    	</div>
    </div>


</div>
</body>
</html>