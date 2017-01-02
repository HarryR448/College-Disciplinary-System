<?php
session_start();
include ("sessioncheck.php");
include ("config.php");
?>
	<ul class="menu"> <!--The list below is assigned to the class menu for styling in css-->
	<li><a href="search.php"><span>Search</span></a></li>  		<!--HTML navigation links in a list for navigating the webpage -->
	 
	<?php if($_SESSION['rank'] == "admin") //if logged in as an admin a dropdown menu is displayed which contains admin pages but staff gets the account page 
	{
	echo '<li class="admindropdown">
		  <a href="#" class="admindropbutton">Admin</a>
			<div class="admindropdowncontents">
				<a href="adminstaff.php">Admin Staff</a>
				<a href="adminstudent.php">Admin Student</a>
				<a href="admincard.php">Admin Card</a>
			</div>
			</li>';
	}
	else{echo '<li><a href="account.php"><span>Account</span></a></li>';}
	?>
	
	<li><a href="help.php"><span>Help</span></a></li>
	<li><a href="logout.php"><span>Logout</span></a></li> 
	
</ul>
