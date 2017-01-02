<?php
session_start();
include ("sessioncheck.php");
include ("config.php");
	
	if (isset($_POST['passwordchange']))		// if you press the passwordchange button on the account page you will have your password updated on the database
	{
		if(!empty($_POST['oldpassword']) && !empty($_POST['newpassword']))
		{
			$oldpassword = $_POST['oldpassword'];
            $newpassword = $_POST['newpassword'];
			$sql_oldpass = mysqli_real_escape_string ($connection, $oldpassword);		//sql injection protection
			$sql_newpass = mysqli_real_escape_string ($connection, $newpassword);
			$oldblowfishpassword =  crypt($sql_oldpass, '$2y$07$qitmu29hwr03b0q03qimc9');		//salting and hashing
			$newblowfishpassword =  crypt($sql_newpass, '$2y$07$qitmu29hwr03b0q03qimc9');
			$username = $_SESSION['username'];		//using the session username and old password the correct row is found on the databse and the password there is replaced with new password 
            $data = mysqli_query($connection, "UPDATE login SET password='$newblowfishpassword' WHERE username='$username' AND password='$oldblowfishpassword'") or die(mysqli_error($connection));	
			echo '<script type="text/javascript">alert("Password successfully updated");window.location.href = "account.php";</script>';		//validation and link back to page
		}
		else if(empty($_POST['oldpassword']) || empty($_POST['newpassword']) )		//if the button is pressed without either fields filled the user gets a message and linked back to the page
		{
			echo '<script type="text/javascript">alert("Please Fill Out The Old password and Desired New Password To Change Your Password.");window.location.href = "account.php";</script>';
		}
	}
?>