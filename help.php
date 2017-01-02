<?php
	session_start();
	include ("sessioncheck.php");
	include ("config.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="A page which explains how to use this website">
		<meta name="author" content="Harry Richards">
		<link rel ="stylesheet" type="text/css" href="stylesheet.css"/>
		<title>Boston College Behavior System Help Page</title>
	</head>
	<body>
		<header>		<!--Logo and page title  -->
			<img class="logo" src="pictures/bostoncollegelogo.png" alt="The Boston College Logo"/>
			<h1 class="pagetitle">Helpful Information</h1>
		</header>
		
		<nav>
		<?php include("navigation.php");?>		<!--included php script containing the navigation sections HTML code -->
		</nav>
		
		<section>
			<h2>How To Use This System</h2><br><br>		<!--Helpful information on using the website -->
			<h3>The search Page</h3>
			<p>The main feature of this web-application is its search pages query system which allows any member of staff to use the two search fields ID and Card Colour to display students associated with a specific id or has a specific card assigned to them or both.</p> 
			<p>Then to query the data for viewing press search after filling out the field/s.</p>
			<p>The contents will then be displayed and will be about the student and which cards they have been on or a list of students that have been on that card or about that students records for that specific card.</p><br><br>
			
			<?php 
			if ($_SESSION['rank'] == "admin")	// helful information that only the admin needs to see
			{?>
			<h3>How To Use The Admin Staff Registry System</h3>
			<p>To register a new staff acoount you must enter the desired Username, Password, Department and Rank into the appropriate boxes on the adminstaff page and then press the register new account button.</p>
			<p>To update a staff account you must enter the current Username and then enter your desired rank and select the department and you can also change the password although it is not essential and will stay the same if you leave it blank. This process can be made easier by populating the fields allowing you to see what the settings are currently and make changes from there.</p>
			<p>To delete a staff account simply enter the username and then press Delete account.</p>
			<p>To populate the fields with data associated with an account on the database then first enter the username in the username box then press the populate fields button and all the data associated with that username will be placed in the relevant boxes on the page. To clear all the boxes of this prepoluated data simply press the clear fields button.</p><br><br>
			<h3>How To Use The Admin Student Registry System</h3>
			<p>To register a new student on the system on the adminstudent page you must enter the Id number, forename , surname and select the department then press the register new student button.</p>
			<p>To update a students details it is neccesary to enter the Id number to identify the account and then the desired forename , surname and department before pressing the update student details button.</p>
			<p>To delete a student off the system simply enter their ID number and then press the button delete student details.</p>
			<p>Student Details can also be prepopulated on this page by entering the id and then pressing prepopulate thus filing out all fields with the current data linked to that ID. To clear the data from the page simply press the clear fields button.</p><br><br>
			<h3>How To Use The Admin Update Card Details System</h3>
			<p>To update a card enter the card number into its field and then press pre-populate to fill out the rest of the details and confirm the card exists. Then change any details you wish to change and press the update card/form button.</p>
			<p>To delete a card from the system simply enter the card number into its form and then click delete the card/form button.</p>
			<?php
			}
			else	// information that staff members need but not admins
			{?>
			<h3>Assigning Cards To Students</h3>
			<p>Enter the Id account to assign the card the card number to uniquely identify this card and then select which card to assign followed by the start and end date, reason for assignment aswell as the corrective actions taken.</p>
			<p>When choosing the level of card to assign to a student you will be limited by your rank as to assign a white card you need to be at least a tutor for a yellow card you need to be at least a programme area manager and for red card you have to be a head of curriculum.</p><br><br>
			<h3>Changing Your Password</h3>
			<p>On the account page simply enter your old password in the indicated field and do the same for your new password and then click change password.</p><br><br>
			<?php
			}	?>
			<h3>Other Information</h3>
			<p>Its important to remember that whenever you leave the page idle for 30+ minutes then you will be automatically logged out and if you are still using the website after 30 minutes then you will be assigned a new session ID for security purposes.</p>
			<p>If you miss an entry when registering,deleting or updating the information of a member of staff or a student then you will get a message informing you to remember to fill out all the fields.</p>
			<p>Also if you try to update or delete a card/account/student details that does not exist then you ill get a message informing you of this.</p>
		</section>
		
		<footer>
		
		</footer>


	</body>

</html>