<?php
session_start();
include("config.php");

if (isset($_POST['loginbutton']))		//if the login button is pressed and the username and password are entered then the database if queried to see if the user has inputted valid login details and if so they are linked to a relavent page 
{
	if (!empty($_POST['username']) && !empty($_POST['password']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$sql_user = mysqli_real_escape_string ($connection, $username);  //sql injection protection
		$sql_pass = mysqli_real_escape_string ($connection, $password);
		$blowfishpassword =  crypt($sql_pass, '$2y$07$qitmu29hwr03b0q03qimc9');		//salting and hashing encryption
    
		$query = "SELECT username, password, rank,department FROM login WHERE username='$sql_user' AND password='$blowfishpassword'";	// selecting the details on the row that contains the same data as the inputted user and pass 
		$data = mysqli_query($connection, $query) or die(mysqli_error($connection)); 	
	
		if($row = mysqli_fetch_array($data))	//if there is data found then some of the retreived data is put into sessions and the user if linked to the admin page for admins or the account page for normal staff
		{
			$_SESSION['username'] = $sql_user;
			$_SESSION['rank'] = $row['rank'];
			$_SESSION['department'] = $row['department'];
			
			if($_SESSION['rank'] == "admin")
			{
				echo"<script>window.location.href = 'adminstaff.php'</script>";
			}
			else
			{
				echo"<script>window.location.href = 'account.php'</script>";
			}
		}
		else	//if their was no data found corresponding to the inputted user and pass then the session ends for security and a message is displayed before the user is linked back the the login page
		{
			session_destroy();
			echo '<script type="text/javascript">alert("Sorry Your Inputted Details Do Not Match Our Records Please Try Again.");window.location.href = "index.php";</script>';
		}
	}
	else if (empty($_POST['username']) || empty($_POST['password']))
	{
		echo '<script type="text/javascript">alert("Please Input Details In The Username And Password Fields.");window.location.href = "index.php";</script>';
	}
}
?>