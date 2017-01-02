<?php
	session_start();			
	include ("sessioncheck.php");
	include ("config.php");
	
	$user = $_SESSION['username'];		//session variables values stored in local variables for easier use in page
	$dep = $_SESSION['department'];
	$ran = $_SESSION['rank'];
	$datenow = date('Y-m-d');		//date variables set up for pre filling the start and end dates for assigning cards
	$datetwoweeks = date('Y-m-d' , strtotime("+14 days"));
?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="The staff member account page for adding cards/forms to students setails andd changing thier own password">
		<meta name="author" content="Harry Richards">
		<link rel ="stylesheet" type="text/css" href="stylesheet.css"/>
		<title>Staff Account Page</title>
		
	</head>
	<body>
		<header>		<!--Logo and page title  -->
			<img class="logo" src="pictures/bostoncollegelogo.png" alt="The Boston College Logo"/>
			<h1 class="pagetitle">Staff Account Page</h1>
		</header>
		
		<nav>
		<?php include("navigation.php");?>	<!--included php script containing the navigation sections HTML code -->
		</nav>
		
		<section>
			<h2>Welcome <?php echo $user?> Department: <?php echo $dep?> Rank: <?php echo $ran?> </h2><br>	<!-- outputting the details of the logged in account exluding password for verification -->
			<h3>Student Card/Form Assignment</h3>
			
			<form name="studentform" enctype="multipart/form-data" action ="studentcardscript.php" method="POST">	<!--Form for giving discipline to students requires Id input and selection of card which is limited by the staffs rank. And also requires start and end date aand reason and corrective actions inputs. -->
			
				<input class="textboxalt" type="text" name="id" placeholder="Id Number" maxlength="6" required>
				<input class="textboxalt" type="text" name="cardno" placeholder="Card Number" maxlength="6" required>
				
				<select class ="textboxalt" name="cardcolour" required>
				<option value="default" disabled selected>Assigned Card Level</option>
				<option value="green">Green Card</option>
				<option value="blue">Blue Form</option>
				<?php
				if($_SESSION['rank'] == "hoc" || $_SESSION['rank'] == "pam" || $_SESSION['rank'] == "tutor") // only if the user is ranked tutor + can they assign a white card
				{	?>
				<option value="white">White Card</option>
				<?php
				}
				else
				{?>
					<option value="white" disabled>White Card</option>
				<?php	}	?>
				
				<?php
				if($_SESSION['rank'] == "hoc" || $_SESSION['rank'] == "pam")
				{	?>
					<option value="yellow">Yellow Card</option>
				<?php
				}
				else
				{?>
					<option value="yellow" disabled>Yellow Card</option>
				<?php	}	?>
				
				<?php
				if($_SESSION['rank'] == "hoc")
				{	?>
					<option value="red" >Red Card</option>
				<?php
				}
				else
				{?>
					<option value="red" disabled>Red Card</option>
				<?php	}	?>
				</select>
			
				
				Card Starts On:
				<input class="textboxalt" type="date" name="cardstartdate" placeholder="YYYY-MM-DD" value="<?php echo $datenow?>"required>	<!--Todays date automaticaly filled in start date -->
				
				Card Ends On:
				<input class="textboxalt" type="date" name="cardenddate" placeholder="YYYY-MM-DD" value="<?php echo $datetwoweeks?>"required><br><br>	<!--Two weeks after Todays date automaticaly filled in end date -->
					
				<p id ="paragraph1">Reason For Assignment:</p>                                            
				<p id="paragraph2">Corrective Actions Taken:</p><br>
				<textarea class="largetextbox" name="cardreason" required></textarea>		<!--large text boxes for input of explanation of reason and actions taken-->
				<textarea class="largetextbox" name="cardcorrectiveactions" required></textarea><br><br>
				
				<input class="buttons" name ="assigncard" type="submit" value="Assign Card"><br><br>
				
				</form>
			
			<h3>Password Change</h3>
			<form class="registryform" name="changepassword" enctype="multipart/form-data" action ="changepassword.php" method="POST">		<!--Form for changing password -->
				<input class="textinput" type="text" name="oldpassword" placeholder="Old Password" value="" required><br><br>
				<input class="textinput" type="text" name="newpassword" placeholder="New Password" value="" required><br><br>
				<input class="buttons" name="passwordchange" type="submit" value="Change Password"><br><br>
			</form>
		</section>
		
		<footer>
		
		</footer>


	</body>

</html>