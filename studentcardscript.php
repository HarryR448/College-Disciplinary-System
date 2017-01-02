<?php
session_start();
include ("sessioncheck.php");
include("config.php");

if (isset($_POST['updatecard'])) //When the updatecard button is pressed and the fields listed below are filled out then as long as the form exists its details are updated with the values of the variables below which were inputed by the user
	{
		if (!empty($_POST['cardno']) && !empty($_POST['cardcolour']) && !empty($_POST['studentid']) && !empty($_POST['cardstartdate']) && !empty($_POST['cardassignedby']) && !empty($_POST['cardreason']) && !empty($_POST['cardcorrectiveactions'])) // these four textboxes must contain data to perform the update
		{
			$cardno = $_POST['cardno'];
			$cardcolour = $_POST['cardcolour'];
			$startdate= $_POST['cardstartdate'];
			$enddate= $_POST['cardenddate'];
			$assignedby = $_POST['cardassignedby'];
			$reason = $_POST['cardreason'];
			$correctiveactions = $_POST['cardcorrectiveactions'];
			$id = $_POST['studentid'];
				
			
			$check = mysqli_query($connection, "SELECT cardno FROM cards WHERE cardno='$cardno' ") or die(mysqli_error($connection));
			$check2 = mysqli_query($connection, "SELECT id FROM studentdetails WHERE id='$id' ") or die(mysqli_error($connection));
				
			if(mysqli_num_rows($check) != 0 && mysqli_num_rows($check2) != 0) // if there exists a cardno and id of those numbers then there is an update done
			{
				$data = mysqli_query($connection, "UPDATE cards SET id='$id', cardcolour='$cardcolour', startdate='$startdate', enddate='$enddate', assignedby='$assignedby', reason='$reason', correctiveactions='$correctiveactions' WHERE cardno='$cardno'") or die(mysqli_error($connection)); 	
				echo '<script type="text/javascript">alert("Data Successfully Updated");window.location.href = "admincard.php";</script>';
			}
			else if(mysqli_num_rows($check2) == 0)	// if theres no id of that number a message is displayed
			{
				echo '<script type="text/javascript">alert("The Specified Student Does Not Exist");window.location.href = "admincard.php";</script>';
			}
			else if(mysqli_num_rows($check) == 0)	// if theres no carndno of that number a message is displayed
			{
				echo '<script type="text/javascript">alert("The Specified Card/Form Does Not Exist");window.location.href = "admincard.php";</script>';
			}
		}
		else if (empty($_POST['cardno']) || empty($_POST['cardcolour']) || empty($_POST['studentid']) || empty($_POST['startdate']) || empty($_POST['cardassignedby']) || empty($_POST['cardreason']) || empty($_POST['cardcorrectiveactions'])) //if the textboxes are not filled a message is displayed and then the page is reloaded
		{
			echo '<script type="text/javascript">alert("Please Fill Out The Inputs Which Consists of Cardno, ID, Card colour ,Startdate, Assigned By , Reason, Corrective Actions And Unless On Blue Form End Date To Update A Card/Form.");window.location.href = "admincard.php";</script>';
		}
	}
	
	if(isset($_POST['deletecard']))	//as long as the button is pressed and a carno is entered and the form/card exists then the record is deleted
	{
		if(!empty($_POST['cardno']))
		{
			$cardno = $_POST['cardno'];
				
			$check= mysqli_query($connection, "SELECT cardno FROM cards WHERE cardno='$cardno' ") or die(mysqli_error($connection));
				
			if(mysqli_num_rows($check) != 0)
			{
				$data = mysqli_query($connection, "DELETE FROM cards WHERE cardno='$cardno' ") or die(mysqli_error($connection));
				echo '<script type="text/javascript">alert("Data Successfully Deleted");window.location.href = "admincard.php";</script>';
			}
			else if(mysqli_num_rows($check) == 0)
			{
				echo '<script type="text/javascript">alert("The Specified Card/Form Does Not Exist");window.location.href = "admincard.php";</script>';
			}
		}
	}
		
	
	
	if(isset($_POST['prepopulatecard']))//if the prepopulate button is pressed and the user has entered an id then as long as the specified student details exists then the information is queried and put into session variables
	{
		if(!empty($_POST['cardno']))
		{
			$cardno = $_POST['cardno'];
				
			$cardcheck= mysqli_query($connection, "SELECT cardno FROM cards WHERE cardno='$cardno' ") or die(mysqli_error($connection));
		
			if(mysqli_num_rows($cardcheck) != 0 )
			{
				$data= mysqli_query($connection, "SELECT id, cardno, cardcolour, startdate, enddate, assignedby, reason, correctiveactions FROM cards WHERE cardno='$cardno'") or die(mysqli_error($connection));
			}
			else if(mysqli_num_rows($cardcheck) == 0)
			{
				echo '<script type="text/javascript">alert("The Specified Assigned Card Does Not Exist");window.location.href = "admincard.php";</script>';
			}
		}
		
		
		if($row = mysqli_fetch_array($data))	//if there is data on the data  variable which is fetched row by row and stored in the row variable then that data is then assigned to sessions
		{
			$_SESSION['preid'] = $row['id'];
			$_SESSION['precardno'] = $row['cardno'];
			$_SESSION['precardcol'] = $row['cardcolour'];
			$_SESSION['prestartdate'] = $row['startdate'];
			$_SESSION['preenddate'] = $row['enddate'];
			$_SESSION['preassignedby'] = $row['assignedby'];	
			$_SESSION['prereason'] = $row['reason'];
			$_SESSION['precorrectiveactions'] = $row['correctiveactions'];
				
			echo"<script>window.location.href = 'admincard.php'</script>";
		}
	}	
	if(isset($_POST['clearbuttoncard']))	//refreshes the page and clears the various sessions of data so the prepolulated data no longer appears
	{
		$_SESSION['precardcol'] = "";
		$_SESSION['precardno'] ="";
		$_SESSION['prestartdate'] ="";
		$_SESSION['preenddate'] ="";
		$_SESSION['preassignedby'] ="";	
		$_SESSION['prereason'] ="";
		$_SESSION['precorrectiveactions'] ="";
		$_SESSION['preid'] = "";
		
		echo"<script>window.location.href = 'admincard.php'</script>";
	}
	
	if (isset($_POST['assigncard']))	//allows staff to assign a card to existing students when the assigncard button is pressed as long as the student exists and the fields are filled out
	{
		if(!empty($_POST['id']) && $_POST['cardno'] && !empty($_POST['cardcolour']) && !empty($_POST['cardstartdate']) && !empty($_POST['cardreason']) && !empty($_POST['cardcorrectiveactions']))
		{
			$cardno = $_POST['cardno'];
			$id = $_POST['id'];
			$cardstartdate= $_POST['cardstartdate'];
			$assignedby = $_SESSION['username'];
			$reason = $_POST['cardreason'];
			$correctiveactions = $_POST['cardcorrectiveactions'];
			$cardcolour = $_POST['cardcolour'];
			
			
			if($_POST['cardcolour'] == "blue")
			{
				$cardenddate= "";
			}
			else
			{
				$cardenddate= $_POST['cardenddate'];
			}
			
			$check= mysqli_query($connection, "SELECT id FROM studentdetails WHERE id='$id' ") or die(mysqli_error($connection));
			$cardcheck= mysqli_query($connection, "SELECT cardno FROM cards WHERE cardno='$cardno' ") or die(mysqli_error($connection));
			
			if(mysqli_num_rows($check) != 0 && mysqli_num_rows($cardcheck) == 0)
			{
				$data = mysqli_query($connection, "INSERT INTO cards SET cardno='$cardno', id='$id', cardcolour='$cardcolour', startdate='$cardstartdate', enddate='$cardenddate', assignedby='$assignedby', reason='$reason', correctiveactions='$correctiveactions'") or die(mysqli_error($connection));
				echo '<script type="text/javascript">alert("Card/Form Successfully Assigned");window.location.href = "account.php";</script>';
			}
			else if(mysqli_num_rows($check) == 0)
			{
				echo '<script type="text/javascript">alert("The Specified Student Does Not Exist");window.location.href = "account.php";</script>';
			}
			else if(mysqli_num_rows($cardcheck) != 0)
			{
				echo '<script type="text/javascript">alert("The Specified Card Id Already Exists");window.location.href = "account.php";</script>';
			}
		}
		else if(empty($_POST['id']) || empty($_POST['cardno']) || empty($_POST['cardcolour']) || empty($_POST['cardstartdate']) || empty($_POST['cardreason']) ||  empty($_POST['cardcorrectiveactions']))
		{
			echo '<script type="text/javascript">alert("Please Fill Out The ID , Start Date, End Date For all but Blue Forms, Reason For Assignment And Corrective Actions To Assign A Card/Form To A Student.");window.location.href = "account.php";</script>';
		}
	}

?>