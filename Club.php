<!doctype html>
<html>
	
<!--
Scott Wickline
Assignment4
Web Programming
Fall 2020
-->
	
<head>

<meta charset="utf-8">
<title>Informatics Club</title>
<link id="mystyle" rel="stylesheet" type="text/css" href="Assignment5CSSstylesheet.css">
<?php require_once("Assignment5_Club_Membership_Class.php"); ?>
</head>

<body>
<div id = "container">
	<hr id="normalhr">
	
		<div 	id="header">

			<h1>Informatics Student Club</h1>
	</div>
	<hr id="normalhr">
	
		<div 	id="leftnav">
			 <a href="Assignment5.php?request=AboutUs">About Us!</a><br>
			 <a href="Assignment5.php?request=Register">Register</a><br>
		 	 <a href="Assignment5.php?request=Members">Members</a><br>
			 <hr>
			 <a href="Assignment5.php?request=Home">Home</a><br>
		</div>
		
		<div 	id="content";>
			<?php
			
			$instance = new Club("localhost", "A340User","Pass123Word","info_club");
			
			
			if(empty($_GET['request']))
				$_GET['request'] = "Home";
			
			
			if($_GET['request'] == 'Home')
				$instance->DisplayHome();
			
			if($_GET['request'] == 'Members')
				$instance->DisplayMembers();
				
			
			if($_GET['request'] == 'Register')
				$instance->DisplayRegistrationForm();
			
			if($_GET['request'] == 'AboutUs')
				$instance->DisplayAbout();
			
			
			?>

		</div>
	
		<div	 id="footer";>

			<marquee><h2><b>© Copyright 2020 by Web Design and Development</b></h2></marquee>
	</div>
</div>

</body>
</html>
