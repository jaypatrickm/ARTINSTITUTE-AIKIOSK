<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/aistyle.css" />
<script src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
//main slideshow											 
$('#culinary_link a').addClass('culinary_link_active');

}); // end ready()
</script>
<title>Art Institute - Orange County</title>
</head>

<body>
<div id="container">
	
	<?php include("includes/header.php");?>
    <div id="culinary_body"> 
		<div id="culinary_left">
    		<?php include("includes/nav.php");?>
    	</div>
    
    	<div id="culinary_right">
    		<ul>
        		<li><a href="program.php"><img src="sources/program_culinaryarts.png" /></a></li>
            	<li><a href="program.php"><img src="sources/program_baking.png" /></a></li>
                <li><a href="program.php"><img src="sources/program_culinaryman.png" /></a></li>
        	</ul>
    	</div>
    </div>


</div>
</body>
</html>