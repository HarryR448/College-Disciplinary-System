<?php
	session_start();
	include ("sessioncheck.php");
	include ("config.php");
	
	if (isset($_POST['startquery'])) // if the startquery button on this page is pressed then as long as one of the fields listed below are filled out then that will be searched for in the database and the currentcard data related to that search will be displayed
	{
		if(!empty($_POST['idsearch']) || !empty($_POST['assignedcardsearch']))
		{
			$id=$_POST['idsearch']; 
			$assignedcard=$_POST['assignedcardsearch'];
			
			if (!empty($id) && empty($assignedcard))	 // if only the id is inputted then the id is used to get the info on that student and any cards he has been on
			{
				$sql_id = mysqli_real_escape_string ($connection, $id);	//sql injection protection
				$data = mysqli_query($connection, "SELECT cards. id, cardno, cardcolour, startdate, enddate, assignedby, reason, correctiveactions, studentdetails. id, forename, surname, department FROM studentdetails INNER JOIN cards ON studentdetails.id = cards.id  WHERE studentdetails.id='$sql_id'") or die(mysqli_error($connection));
				
			}
			
			else if (empty($id) && !empty($assignedcard))	// if only the assignedcard field is filled out then the id which is the primary key used to search for relevant info in the studentdetails table is retrieved from the cards table 
			{
				$sql_assignedcard = mysqli_real_escape_string ($connection, $assignedcard);	
				$data = mysqli_query($connection, "SELECT cards. id, cardno, cardcolour, startdate, enddate, assignedby, reason, correctiveactions, studentdetails. id, forename, surname, department FROM studentdetails INNER JOIN cards ON studentdetails.id = cards.id  WHERE cardcolour ='$sql_assignedcard'") or die(mysqli_error($connection));
			}
			
			else if (!empty($id) && !empty($assignedcard))
			{
				$sql_assignedcard = mysqli_real_escape_string ($connection, $assignedcard);	
				$sql_id = mysqli_real_escape_string ($connection, $id);
				$data = mysqli_query($connection, "SELECT cards. id, cardno, cardcolour, startdate, enddate, assignedby, reason, correctiveactions, studentdetails. id, forename, surname, department FROM studentdetails INNER JOIN cards ON studentdetails.id = cards.id  WHERE studentdetails.id='$sql_id' AND cards.cardcolour='$sql_assignedcard'") or die(mysqli_error($connection));
			}
			
			$rows=mysqli_num_rows($data);	//counts the number of rows in the data and puts that in the rows variable
			
			if($rows==0)	//if there is no data corresponding to the search a message is shown
			{
				echo '<script type="text/javascript">alert("No Data Found");window.location.href = "search.php";</script>';
			}
	
			else if ($rows != 0)	//as long as there is avaliable rows the contents of the data variable will be ordered into an array consisting of a string for each row with the sqli_fetch_assoc command and stored in the results variable
			{
				$results=mysqli_fetch_assoc($data);
			}
		}
		else if (empty($_POST['idsearch']) && empty($_POST['assignedcardsearch']))
		{
			echo '<script type="text/javascript">alert("Please input in one of the boxes.");window.location.href = "search.php";</script>';
		}
	}	
	
?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="Query for students who have been assigned disciplinary cards">
		<meta name="author" content="Harry Richards">
		<link rel ="stylesheet" type="text/css" href="stylesheet.css"/>
		<title>Boston College Disciplinary Search</title>
	</head>
	<body>
		<header>		<!--Logo and page title  -->
			<img class="logo" src="pictures/bostoncollegelogo.png" alt="The Boston College Logo"/>
			<h1 class="pagetitle">Disciplinary Search</h1>
		</header>
		
		<nav>
		<?php include("navigation.php");?>		<!--included php script containing the navigation sections HTML code -->
		</nav>
		
		<section>
			<h2>Enter/Select Appropriate Details Below To Find Students With Disciplinary Records</h2><br>
			
			<form name="searchform" enctype="multipart/form-data" action ="search.php" method="POST">	<!--Form for filling out a search criteria  -->
				<input class="textinput" type="text" name="idsearch" value="" maxlength="6" placeholder="ID">
				
				<select class ="detailsdropdown" name="assignedcardsearch">
					<option value="default" disabled selected>Card Level</option>
					<option value="green">Green Card</option>
					<option value="blue">Blue Form</option>
					<option value="white">White Card</option>
					<option value="yellow">Yellow Card</option>
					<option value="red">Red Card</option>
				</select>
				
				<input class="buttons" name="startquery" type="submit" value="Search">
			</form><br>
			
			<?php
			if(isset($_POST['startquery']))	//if the button has been pressed then the table is created with the headers displayed and the contents will only be displayed as long as there is some to display and it will then be echoed out until there is none left stored in results
			{?>
				<table class="searchtable">
						<tr>
							<th>ID</th>
							<th>Card No</th>
							<th>Forename </th>
							<th>Surname </th>
							<th>Department</th>
							<th>Card Colour</th> 
							<th>Start Date</th>
							<th>End Date</th> 
							<th>Assigned By</th>
							<th>Reason Given</th>
							<th>Corrective Actions Taken</th>
						</tr>
					<?php
						if($rows != 0)
						{
						do
						{ ?>
							<tr>
								<td><?php echo $results['id'];?></td>
								<td><?php echo $results['cardno'] ?></td>
								<td><?php echo $results['forename'];?></td>
								<td><?php echo $results['surname'];?></td>
								<td><?php echo $results['department'];?></td>
								<td><?php echo $results['cardcolour'];?></td>
								<td><?php echo $results['startdate'];?></td>
								<td><?php echo $results['enddate'];?></td>
								<td><?php echo $results['assignedby'];?></td>
								<td><?php echo $results['reason'];?></td>
								<td><?php echo $results['correctiveactions'];?></td>
							</tr>
					
				<?php 	}while ($results=mysqli_fetch_assoc($data));
					
					}
			}
					?>
			</table>
		</section>
		
		<footer>
		
		</footer>


	</body>

</html>