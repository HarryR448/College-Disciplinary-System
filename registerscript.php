<?php
session_start();
include ("sessioncheck.php");
include("config.php");

		if(isset($_POST['addaccount']))		// when the addaccount button is pressed and all fields listed below are filed out then as long as the username hasnt been registered previously then a new account will be registered
		{
			if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['department']) && !empty($_POST['rank']))
			{
				$username = $_POST['username'];	//inputted details stored in variables
				$password = $_POST['password'];
				$department = $_POST['department'];
				$rank = $_POST['rank'];
				$blowfishpassword =  crypt($password, '$2y$07$qitmu29hwr03b0q03qimc9');	//password salted and hashed
				$check= mysqli_query($connection, "SELECT username FROM login WHERE username='$username' ") or die(mysqli_error($connection));		//for validating that the account doesnt exist
				
				if(mysqli_num_rows($check) == 0)	//if in the previous sql select statement no identical rows are found then the query for inserting a new row into the table is run thus adding a new account
				{
					$data = mysqli_query($connection, "INSERT INTO login SET username='$username', password='$blowfishpassword', department='$department', rank ='$rank' ") or die(mysqli_error($connection)); 	
					echo '<script type="text/javascript">alert("Data successfully inserted");window.location.href = "adminstaff.php";</script>';
				}
				else if(mysqli_num_rows($check) != 0) //if in the previous sql select statement a username of that name is found to already exist and hence their is more than zero rows then a message is displayed
				{
					echo '<script type="text/javascript">alert("The Account Already Exists");window.location.href = "adminstaff.php";</script>';
				}
			}
			else if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['department']) || empty($_POST['rank']))	// if the user misses an input then a message is displayed
			{
				echo '<script type="text/javascript">alert("Please Fill Out The Username, Password, Department and Rank To Create An Account.");window.location.href = "adminstaff.php";</script>';
			}
		}
		
		if(isset($_POST['updateaccount']))	// when the updateaccount button is pressed and the username department and rank are filled out then the contents will be updated according to what has been filled out
		{
			if(!empty($_POST['username']) && !empty($_POST['department']) && !empty($_POST['rank']))
			{
				$password = $_POST['password'];
				$username = $_POST['username'];
				$department = $_POST['department'];
				$rank = $_POST['rank'];
				$blowfishpassword =  crypt($password, '$2y$07$qitmu29hwr03b0q03qimc9');	// salting and hashing the new password
				
				$check= mysqli_query($connection, "SELECT username FROM login WHERE username='$username' ") or die(mysqli_error($connection)); // for validating the account exists
				
				if(mysqli_num_rows($check) != 0) // if there is an account and hence more than zero rows then if there is no iputted passsword then just rank and department are updated but if a password is inputted then that is updated aswell
				{
					if($password == NULL)
					{
						$data = mysqli_query($connection, "UPDATE login SET department='$department', rank='$rank' WHERE username='$username' ") or die(mysqli_error($connection));	
						echo '<script type="text/javascript">alert("Data successfully updated");window.location.href = "adminstaff.php";</script>';
					}
					else
					{
						$data = mysqli_query($connection, "UPDATE login SET password='$blowfishpassword', department='$department', rank='$rank' WHERE username='$username' ") or die(mysqli_error($connection));	
						echo '<script type="text/javascript">alert("Data successfully updated");window.location.href = "adminstaff.php";</script>';
					}
				}
				else if(mysqli_num_rows($check) == 0) // but if there is no rows and hence no account then a messages is displayed and the user is linked back to the page
				{
					echo '<script type="text/javascript">alert("The Specified Account Does Not Exist");window.location.href = "adminstaff.php";</script>';
				}
			}
		
			else if(empty($_POST['username']) || empty($_POST['department']) || empty($_POST['rank'])) // if the user failed to fill out one of the three rquired fields then a messsage is displayed
			{
				echo '<script type="text/javascript">alert("Please Fill Out The Username, Optionally:Password, Department and Rank To Perform Updates To An Account.");window.location.href = "adminstaff.php";</script>';
			}
		}
		
		if(isset($_POST['deleteaccount']))	// if the delete account button is pressed and the user has filled out the username box then as long as the account exists it gets deleted
		{
			if(!empty($_POST['username']))
			{
				$username = $_POST['username'];
				$check= mysqli_query($connection, "SELECT username FROM login WHERE username='$username' ") or die(mysqli_error($connection));
				
				if(mysqli_num_rows($check) != 0)
				{
					$data = mysqli_query($connection, "DELETE FROM login WHERE username='$username'") or die(mysqli_error($connection)); 	
					echo '<script type="text/javascript">alert("Data successfully deleted");window.location.href = "adminstaff.php";</script>';
				}
				else if(mysqli_num_rows($check) == 0)
				{
					echo '<script type="text/javascript">alert("The Specified Account Does Not Exist");window.location.href = "adminstaff.php";</script>';
				}
			}
		
			else if(empty($_POST['username']))
			{
				echo '<script type="text/javascript">alert("Please Fill Out The Username To Perform An Account Deletion.");window.location.href = "adminstaff.php";</script>';
			}
		}
		
	if(isset($_POST['prepopulate'])) //if the prepopulate button is pressed and the user has entered a username then as long as the specified account exists then the accounts information is queried and put into session variables
	{
		if(!empty($_POST['username']))
		{
			$username = $_POST['username'];
			$check= mysqli_query($connection, "SELECT username FROM login WHERE username='$username' ") or die(mysqli_error($connection));
				
			if(mysqli_num_rows($check) != 0)
			{
			$data = mysqli_query($connection, "SELECT department, rank FROM login WHERE username='$username'") or die(mysqli_error($connection));
			}
			else if(mysqli_num_rows($check) == 0)
			{
				echo '<script type="text/javascript">alert("The Specified Account Does Not Exist");window.location.href = "adminstaff.php";</script>';
			}
			
			if($row = mysqli_fetch_array($data))
			{
				$_SESSION['preusername'] = $username;
				$_SESSION['predepartment'] = $row['department'];
				$_SESSION['prerank'] = $row['rank'];
				echo"<script>window.location.href = 'adminstaff.php'</script>";
			}
		}
	}

	
	if(isset($_POST['clearbutton'])) // if the clear button is pressed then the session variables and hence the filled fields are cleared
	{
		$_SESSION['preusername'] ="";
		$_SESSION['predepartment'] ="";
		$_SESSION['prerank'] ="";
		echo"<script>window.location.href = 'adminstaff.php'</script>";
	}

?>	