<?php
	session_start();		//starting session which will hold session variables and will be used for ensuring the user is logged in etc
	include ("sessioncheck.php");
	include ("config.php");	// config page included which is necceary for connecting to the database as it includes important connection information
	
	if($_SESSION['rank'] != ("admin") )	//if your not the admin you cant access this page and instead get linked to the normal staffs changing stored details page
	{
		echo"<script>window.location.href = 'account.php'</script>";
	}
	
	$precardcol = $_SESSION['precardcol'];
	$precardid = $_SESSION['precardno'];
	$prestartdate = $_SESSION['prestartdate'];
	$preenddate = $_SESSION['preenddate'];
	$precardassignedby = $_SESSION['preassignedby'];	
	$precardreason = $_SESSION['prereason'];
	$precorrectiveactions = $_SESSION['precorrectiveactions'];
	$preid = $_SESSION['preid'];
?>

<!DOCTYPE html>


<html>
	<head>
		<title>Boston College Disciplinary Admin Card Amendment</title>
		<meta charset="UTF-8">
		<meta name="description" content="A page for the admins to amend pre existing card data.">
		<meta name="author" content="Harry Richards">
		<link rel ="stylesheet" type="text/css" href="stylesheet.css"/>

	</head>
	<body>
		<header>	
			<img class="logo" src="pictures/bostoncollegelogo.png" alt="The Boston College Logo"/>
			<h1 class="pagetitle">Admin Card Config Page</h1>
		</header>
		
		<nav>
		<?php include("navigation.php");?>	<!--included php script containing the navigation sections HTML code -->
		</nav>
		
		<section>
			<h1>Update & Delete Card/Form Data Below</h1><br><br>		
			<form name="cardchangeform" enctype="multipart/form-data" action ="studentcardscript.php" method="POST">
				<input class="textinput" name="cardno" type="text" placeholder="Card Number" required maxlength="6"
				<?php if(!empty($precardid)){echo"value='$precardid'";} ?>><br><br>
			
				<input class="buttons" name="prepopulatecard" type="submit" value="Populate Fields"><br><br>
				<input class="buttons" name="clearbuttoncard" type="submit" value="Clear Fields"><br><br>
			
				<input class="textinput" name="studentid" type="text" placeholder="Student ID"
				<?php if(!empty($preid)){echo"value='$preid'";} ?>><br><br>
		
				<select class ="detailsdropdown" name="cardcolour">
				<?php if(!empty($precardcol)){ echo "<option value='".$precardcol."'>'".$precardcol."'</option>";}
				else
				{?>
					<option value="default" disabled selected>Current Card Level</option>
				<?php;}?>
				<option value="green">Green Card</option>
				<option value="blue">Blue Form</option>
				<option value="white">White Card</option>
				<option value="yellow">Yellow Card</option>
				<option value="red">Red Card</option>
				</select><br><br>
			
				
				Card Started On Date:<br>
				<input class="textinput" type="date" name="cardstartdate" placeholder="YYYY-MM-DD" 
				<?php if(!empty($prestartdate)){echo"value='$prestartdate'";} ?>><br><br>
				Card Ends On Date:<br>
				<input class="textinput" type="date" name="cardenddate" placeholder="YYYY-MM-DD"
				<?php if(!empty($preenddate)){echo"value='$preenddate'";} ?>><br><br>
					
				<input class="textinput" type="text" name="cardassignedby" placeholder="Assigned By"
				<?php if(!empty($precardassignedby)){echo"value='$precardassignedby'";} ?>><br><br>

				<input class="textinput" type="text" name="cardreason" placeholder="Reason For Assignment"
				<?php if(!empty($precardreason)){echo"value='$precardreason'";} ?>><br><br>
					
				<input class="textinput" type="text" name="cardcorrectiveactions" placeholder="Corrective Actions Taken"
				<?php if(!empty($precorrectiveactions)){echo"value='$precorrectiveactions'";} ?>><br><br>
				
				<input class="buttons" name="updatecard" type="submit" value="Update Card/Form"><br><br>
				<input class="buttons" name="deletecard" type="submit" value="Delete Card/Form"><br><br>
			
			</form>
		</section>
	</body>

</html>