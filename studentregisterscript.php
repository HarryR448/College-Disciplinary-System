<?php
session_start();
include ("sessioncheck.php");
include("config.php");

	if(isset($_POST['addstudent']))	//as long as the button is pressed and the fields are not empty then an account can be registered by the admin with a new row of information inserted into the studentdetails table on the database
	{
		if(!empty($_POST['id']) && !empty($_POST['forename']) && !empty($_POST['surname']) && !empty($_POST['department']))
		{
			$id = $_POST['id'];
			$forename = $_POST['forename'];
			$surname = $_POST['surname'];
			$department = $_POST['department'];
			
			//As long as the account does not already exist a new row is inserted into the database with its fields being set equal to the variables values above 
			$check= mysqli_query($connection, "SELECT id FROM studentdetails WHERE id='$id' ") or die(mysqli_error($connection));
				
			if(mysqli_num_rows($check) == 0) // as long as there is no student which matches that id then the account is made
			{
				$data = mysqli_query($connection, "INSERT INTO studentdetails SET id='$id', forename='$forename', surname='$surname', department='$department'") or die(mysqli_error($connection)); 	
				echo '<script type="text/javascript">alert("Data Successfully Added To The Database");window.location.href = "adminstudent.php";</script>';
			}
			else if(mysqli_num_rows($check) != 0) // if there is a student matching that id then a message is displayed
			{
				echo '<script type="text/javascript">alert("A Student Is Already Assigned that ID");window.location.href = "adminstudent.php";</script>';
			}
		}
				else if(empty($_POST['id']) || empty($_POST['forename']) || empty($_POST['surname']) || empty($_POST['department']))	//if the button is pressed but the essential fields are not filled out then a message is displayed and then the usr is linked back to the page
		{
			echo '<script type="text/javascript">alert("Please Fill Out All The Inputs which consist of ID,Forename,Surname and Department To Add a Student To The Database.");window.location.href = "adminstudent.php";</script>';
		}
	}
		
		if (isset($_POST['updatestudentdetails'])) //When the updatestudentdetails button is pressed and the four fields listed below are filled out then as long as the account exists its details are updated with the values of the variables below which were inpuuted by the user
		{
			if(!empty($_POST['id']) && !empty($_POST['forename'])&& !empty($_POST['surname']) && !empty($_POST['department'])) // these four textboxes must contain data to perform the update
			{
				$id = $_POST['id'];
				$forename = $_POST['forename'];
				$surname = $_POST['surname'];
				$department = $_POST['department'];

				//the values within the fields are changed using the data in the variables above if the inputted student actually exists
				$check= mysqli_query($connection, "SELECT id FROM studentdetails WHERE id='$id' ") or die(mysqli_error($connection));
				
				if(mysqli_num_rows($check) != 0) // if there exists an id of that number then there is an update done
				{
					$data = mysqli_query($connection, "UPDATE studentdetails SET forename='$forename', surname='$surname', department='$department' WHERE id='$id' ") or die(mysqli_error($connection)); 	
					echo '<script type="text/javascript">alert("Data Successfully Updated");window.location.href = "adminstudent.php";</script>';
				}
				else if(mysqli_num_rows($check) == 0)	// if theres no id of that number a message is displayed
				{
					echo '<script type="text/javascript">alert("The Specified Student Does Not Exist");window.location.href = "adminstudent.php";</script>';
				}
		}
			else if(empty($_POST['id']) || empty($_POST['forename']) || empty($_POST['surname']) || empty($_POST['department'])) //if the textboxes ar not filled a message is displayed and then the page is reloaded
			{
				echo '<script type="text/javascript">alert("Please Fill Out All The Inputs which consist of ID,Forename,Surname and Department To Update A Students Details.");window.location.href = "adminstudent.php";</script>';
			}
		}
		
		if(isset($_POST['deletestudentdetails']))	//as long as the button is pressed and an id is entered and the student exists then the row which contains that id is deleted
		{
			if(!empty($_POST['id']))
			{
				$id = $_POST['id'];
				
				$check= mysqli_query($connection, "SELECT id FROM studentdetails WHERE id='$id' ") or die(mysqli_error($connection));
				
				if(mysqli_num_rows($check) != 0)
				{
					$data = mysqli_query($connection, "DELETE FROM studentdetails WHERE id='$id' ") or die(mysqli_error($connection));
					echo '<script type="text/javascript">alert("Data Successfully Deleted");window.location.href = "adminstudent.php";</script>';
				}
				else if(mysqli_num_rows($check) == 0)
				{
					echo '<script type="text/javascript">alert("The Specified Student Does Not Exist");window.location.href = "adminstudent.php";</script>';
				}
			}
		
			else if(empty($_POST['id']))
			{
				echo '<script type="text/javascript">alert("Please Fill Out The ID To Perform A Student Details Deletion.");window.location.href = "adminstudent.php";</script>';
			}
		}
		
	
		
	if(isset($_POST['prepopulate']))//if the prepopulate button is pressed and the user has entered an id then as long as the specified student details exists then the information is queried and put into session variables
	{
		if(!empty($_POST['id']))
		{
			$id = $_POST['id'];
			$check= mysqli_query($connection, "SELECT id FROM studentdetails WHERE id='$id' ") or die(mysqli_error($connection));
		
			if(mysqli_num_rows($check) != 0)
			{
				$data = mysqli_query($connection, "SELECT id, forename, surname ,department FROM studentdetails WHERE id='$id'") or die(mysqli_error($connection));
			}
			else if(mysqli_num_rows($check) == 0)
			{
				echo '<script type="text/javascript">alert("The Specified Student Does Not Exist");window.location.href = "adminstudent.php";</script>';
			}
		}
			
			
		if($row = mysqli_fetch_array($data))	//if there is data on the data variable which is fetched row by row and stored in the row variable then that data is then assigned to sessions
		{
			$_SESSION['preid'] = $id;
			$_SESSION['preforename'] = $row['forename'];
			$_SESSION['presurname'] = $row['surname'];
			$_SESSION['predepartment'] = $row['department'];
			echo"<script>window.location.href = 'adminstudent.php'</script>";
		}
	}

	if(isset($_POST['clearbutton']))	//refreshes the page and clears the various sessions of data so the prepolulated data no longer appears
	{
		$_SESSION['preid'] = "";
		$_SESSION['preforename'] ="";
		$_SESSION['presurname'] ="";
		$_SESSION['predepartment'] ="";
		echo"<script>window.location.href = 'adminstudent.php'</script>";
	}
?>
