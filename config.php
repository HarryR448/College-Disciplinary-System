<?php
	//database configuration information

	$dbusername = "harryr_admin";
	$dbpassword = "Animalkingdo1.";
	$hostname = "localhost";
	$database = "harryr_database";

	$connection = mysqli_connect($hostname, $dbusername, $dbpassword, $database);
	
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>
