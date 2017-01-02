<?php
	session_start();
	include ("sessioncheck.php");
	include ("config.php");
	
	if($_SESSION['rank'] != ("admin"))	//if your not the admin you cant access this page and instead get linked to the normal staffs changing stored details page
	{
		echo"<script>window.location.href = 'account.php'</script>";
	}
	
	$prepopuser = $_SESSION['preusername'];	//session variables data stored in local variables for prepopulating fields later
	$prepopdep = $_SESSION['predepartment'];
	$prepoprank = $_SESSION['prerank'];	
?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="UTF-8"/>
		<meta name="author" content="Harry Richards">
		<meta name="description" content="An administrator Page for adding,amending and removing staff from the database">
        <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
		<title>Admin Staff Config Page</title>
	</head>
	<body>
		<header>		<!--Logo and page title  -->
			<img class="logo" src="pictures/bostoncollegelogo.png" alt="The Boston College Logo"/>
			<h1 class="pagetitle">Admin Staff Config Page</h1>
		</header>
		
		<nav>
			<?php include("navigation.php");?>   <!--included php script containing the navigation sections HTML code -->
		</nav>
		
		<section>
			<h2>Staff account Add/Delete/Modify</h2>
			
			<form class="registryform" name="registerform" enctype="multipart/form-data" action ="registerscript.php" method="POST">	<!--Form for creating staff accounts updating them and also deleting them -->
				<input class="textinput" type="text" name="username" placeholder="Username" required
				<?php if(!empty($prepopuser)){echo"value='$prepopuser'";} ?> /><br><br>				<!--if the prepoluation variable contains data and hence the button has been pressed to do so then fill out the textinput with the data stored in the variable -->
				<input class="textinput" type="text" name="password" placeholder="Password" value=""><br><br>
				
				<input class="buttons" name="prepopulate" type="submit" value="Populate Fields"><br><br>		<!--Pressing with content in username will fill all fields exept password -->
				<input class="buttons" name="clearbutton" type="submit" value="Clear Fields"><br><br>			<!-- pressing will clear pre-populated fields -->
				
				<select class ="detailsdropdown" name="department">			<!-- drop down for choosing department -->
				<?php if(!empty($prepopdep)){ echo "<option value='".$prepopdep."'>'".$prepopdep."'</option>";}			//if content in prepop variables then it will get included and displayed first in the dropdown otherwise it is the default not selectable option
				else
				{?>
				<option value="default" disabled selected>Department Selection</option>
				<?php;}?>
				<option value="computing">Computing</option>
				<option value="engineering">Engineering</option>
				<option value="art">Art</option>
				<option value="hospitality">Hospitality</option>
				<option value="hair&beauty">Hair and Beauty</option>
				<option value="sport">Sport</option>
				</select><br><br>
				
				<select class ="detailsdropdown" name="rank">
				<?php if(!empty($prepopdep)){ echo "<option value='".$prepoprank."'>'".$prepoprank."'</option>";}
				else
				{?>
				<option value="default" disabled selected>Rank Selection</option>
				<?php;}?>
				<option value="lecturer">Lecturer</option>
				<option value="tutor">Tutor</option>
				<option value="pam">Programme Area Manager</option>
				<option value="hoc">Head of Curriculum</option>
				</select><br><br>
				
				<input class="buttons" name="addaccount" type="submit" value="Register New Account"><br><br>		<!--buttons for adding updating and deleting staff accounts -->
				<input class="buttons" name ="updateaccount" type="submit" value="Update Account"><br><br>
				<input class="buttons" name ="deleteaccount" type="submit" value="Delete Account"><br><br>
				
			</form>
		</section>
		
		<footer>
		
		</footer>
		
	</body>
</html>