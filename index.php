<?php
	session_start();		//starting session which will hold session variables and will be used for ensuring the user is logged in etc
	include ("config.php");	// config page included which is necceary for connecting to the database as it includes important connection information
?>

<!DOCTYPE html>


<html>
	<head>
		<title>Boston College Disciplinary Login</title>
		<meta charset="UTF-8">
		<meta name="description" content="A page for logging into the boston college disciplinary system.">
		<meta name="author" content="Harry Richards">
		<link rel ="stylesheet" type="text/css" href="stylesheet.css"/>

	</head>
	<body>
		<div id="loginheader">	<!--Logo and page title and the div is a replacement for the nav bar -->
			<img class="logo" src="pictures/bostoncollegelogo.png" alt="The Boston College Logo"/>
			<h1 class="pagetitle">User Login Page</h1>
		</div>
		<section>
			<h1> Please enter your username and password below</h1>		<!-- login form for logging in -->
			<form id="loginformmargin" name="loginform" enctype="multipart/form-data" action ="loginscript.php" method="POST">
			<input class="logintextinput" type="text" name="username" placeholder="Username" value="" required><br>
			<input class="logintextinput" type="password" name="password" placeholder="Password" value="" required><br>
			<input class="buttons" type="submit" name="loginbutton" value="Login"><br>
			</form>
		</section>
	</body>

</html>