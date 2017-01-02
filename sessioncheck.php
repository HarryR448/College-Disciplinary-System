<?php 
	session_start();
	include ("config.php");
	
	if($_SESSION['username'] == NULL)	//if trying to directly link to a page without logging in it will redirect to login page
	{
		echo"<script>window.location.href = 'index.php'</script>";
	}
	
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) // if the last request was more than 1800 seconds or 30 minutes ago
	{
		session_unset();     //clears the current session
		session_destroy();   // destroy the session data in the storage
		echo"<script>window.location.href = 'index.php'</script>"; //sends you back to index upon text action
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // updates the last activity time stamp when you perform an activity on the web-app
	
	if (!isset($_SESSION['CREATED'])) 
	{
		$_SESSION['CREATED'] = time();
	} 
	else if (time() - $_SESSION['CREATED'] > 1800) 	//provide protection against session hijacking type attacks by resetting session ID 
	{
		session_regenerate_id(true);    //If after 30 minutes the session is still in use then this will change the session ID and invalidate the old session ID
		$_SESSION['CREATED'] = time();  // update creation of session time
	}
?>