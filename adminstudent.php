<?php
	session_start();
	include ("sessioncheck.php");
	include ("config.php");
	
	if($_SESSION['rank'] != ("admin") )	//if your not the admin you cant access this page and instead get linked to the normal staffs changing stored details page
	{
		echo"<script>window.location.href = 'account.php'</script>";
	}
	
	$preid = $_SESSION['preid'];					// lots of prepopulate local variables using contents from session variables
	$preforename = $_SESSION['preforename'];
	$presurname = $_SESSION['presurname'];
	$predep = $_SESSION['predepartment'];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="An administrator Page for adding,amending and removing students from the database">
		<meta name="author" content="Harry Richards">
		<link rel ="stylesheet" type="text/css" href="stylesheet.css"/>
		<title>Admin Student Config Page</title>
	</head>
	<body>
		<header>		<!--Logo and page title  -->
			<img class="logo" src="pictures/bostoncollegelogo.png" alt="The Boston College Logo"/>
			<h1 class="pagetitle">Admin Student Config Page</h1>
		</header>
		
		<nav>
		<?php include("navigation.php");?>		<!--included php script containing the navigation sections HTML code -->
		</nav>
		
		<section>
			<h2>Student Data Add/Delete/Modify</h2><br><br>			<!--Similar to staff page a form for adding students details to the database -->
			<form name="studentform" enctype="multipart/form-data" action ="studentregisterscript.php" method="POST">		<!--Inputs for student details -->
				<input class="textinput" type="text" name="id" placeholder="Id Number" maxlength="6" required		
				<?php if(!empty($preid)){echo"value='$preid'";} ?>><br><br>								<!--prepolulate fields if there is content in the variables -->
				<input class="buttons" name="prepopulate" type="submit" value="Populate Fields"><br><br>
				<input class="buttons" name="clearbutton" type="submit" value="Clear Fields"><br><br>
				<input class="textinput" type="text" name="forename"placeholder="First Name" 
				<?php if(!empty($preforename)){echo"value='$preforename'";} ?>><br><br>
				<input class="textinput" type="text" name="surname" placeholder="Last Name" 
				<?php if(!empty($presurname)){echo"value='$presurname'";} ?>><br><br>
				
				<select class ="detailsdropdown" name="department">
				<?php if(!empty($predep)){ 
					echo "<option value='".$predep."'>'".$predep."'</option>";}
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
				
				<input class="buttons" name="addstudent" type="submit" value="Register New Student"><br><br>		<!--buttons for registering the students updating thier details and deleting them from the database -->
				<input class="buttons" name ="updatestudentdetails" type="submit" value="Update Student Details"><br><br>
				<input class="buttons" name ="deletestudentdetails" type="submit" value="Delete Student Details"><br><br>
			</form>
		</section>
		
		<footer>
		
		</footer>


	</body>

</html>