<?php 
	session_start(); // starts session on script

	session_unset(); // ends current session so its no longer running

	session_destroy(); //deletes session data from server
	
	echo"<script>window.location.href = 'index.php'</script>"; // links back to login page
?>