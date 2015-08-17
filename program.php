<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/aistyle.css" />
<link href="greybox/greybox2.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>
<script type="text/javascript" src="greybox/jquery.greybox2.js"></script>
<script type="text/javascript">
$(document).ready(function() {
											 
$('#media_link a').addClass('media_link_active');

var max_size = 250;

		$(".thumb").each(function(i) {
		
		  if ($(this).height() > $(this).width()) {
		
			var h = max_size;
		
			var w = Math.ceil($(this).width() / $(this).height() * max_size);
		
		  } else {
		
			var w = max_size;
		
			var h = Math.ceil($(this).height() / $(this).width() * max_size);
		
		  }
		
		  $(this).css({ height: h, width: w });
		
		});
/*
$('#gallery a').lightBox({
	txtImage: 'Project',
	overlayOpacity: .5,
	overlayBgColor: '#000',
	imageLoading: 'images/lightbox/loading.png',
	imageBtnClose: 'images/lightbox/close.png',
	imageBtnPrev: 'images/lightbox/previous.png',
	imageBtnNext: 'images/lightbox/next.png'
	
});*/

//beginning of form box for opening in a new window
		var gbOptions = {
				gbWidth: 1520,
				gbHeight: 904	
			};
		$('#gallery a').greybox(gbOptions);
		
}); // end ready()
</script>
<title>Art Institute - Orange County</title>
</head>

<body>
<div id="container">
	
	<?php include("includes/header.php");?>
    <div id="program_body"> 
		<div id="program_left">
    		<?php include("includes/nav.php");?>
            <p>Web Design & Interactive Media</p>
    	</div>
    
    	<div id="program_right">
    		<div id="gallery">
        	
            	<ul>
  					<li><a href="project.php"><img class="thumb" src="sources/project/project1.jpg" width="285" height="260" alt="project1"></a></li>
  					<li><a href="project.php"><img class="thumb" src="sources/project/project2.jpg" width="285" height="260" alt="project2"></a></li>
  					<li><a href="project.php"><img class="thumb" src="sources/project/project3.jpg" width="285" height="260" alt="project3"></a></li>
  					<li><a href="project.php"><img class="thumb" src="sources/project/project4.jpg" width="285" height="260" alt="project4"></a></li>
  					<li><a href="project.php"><img class="thumb" src="sources/project/project5.jpg" width="285" height="260" alt="project5"></a></li>
  					<li><a href="project.php"><img class="thumb" src="sources/project/project6.jpg" width="285" height="260" alt="project6"></a></li>
            		<!--<li><a href="project.php"><img class="thumb" src="sources/project/project7.jpg" width="285" height="260" alt="project7"></a></li>
            		<li><a href="project.php"><img class="thumb" src="sources/project/project8.jpg" width="285" height="260" alt="project8"></a></li>-->
                </ul>
  			</div>
            
            <div id="gallery_pagination">
            	<a href="program.php"><img class="prev_btn" src="sources/prev_gray.png" /></a>
                <a href="program2.php"><img class="next_btn"src="sources/next_gray.png" /></a>
                
            </div>
    	</div>
    </div>


</div>
</body>
</html>