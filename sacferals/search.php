<?php
	session_start();
	include('authenticate.php');
	$link = connectdb($host, $user, $pass, $db);

	if($_SESSION['authenticate234252432341'] != 'validuser09821')
	{
	authenticateUser();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>	
	<title>Record Search</title> 
	
	
	
	<style type="text/css">
    .fieldset-auto-width 
	{
        display: inline-block;
    }
	html 
	{
		font-family: verdana;
		font-size: 10pt;
		line-height: 25px;
	}
	table 
	{
		border-collapse: collapse;
		width: 1000px;
		overflow-x: scroll;
		display: block;
	}
	thead 
	{
		background-color: #EFEFEF;
	}
	thead, tbody 
	{
		display: block;
	}
	tbody 
	{
		overflow-y: scroll;
		overflow-x: hidden;
		height: 140px;
	}
	td, th 
	{
		min-width: 220px;
		height: 25px;
		border: dashed 1px lightblue;
	}
	table.big td th
	{
		width: 200px;
	}
	</style>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="searchScript.js">
	</script> 
	
</head>

<body>
<?php

	//if no ones logged in, print login screen
	if($_SESSION['authenticate234252432341'] != 'validuser09821')
	{ 
		
		print "<form method='post' action='search.php'>
		<div><fieldset class='fieldset-auto-width'>
		<legend>Login</legend>
		<label><input type='text' name='username'>User Name</label><br>
		<label><input type='password' name='pass'>Password</label><br>
		<label><input type='submit' name='login' value='Login'></label>
		</fieldset></div>
		</form>
		
		<h3>Level 1 access (admin): Guest1, 123</h3>
		<h3>Level 2 access (pleb): Guest2, abc</h3>";
	}
	//once you're logged in, show menu/options
	else 
	{
		$Ausername = $_SESSION['Ausername'];
		$level = $_SESSION['level'];
		
		if($level == 1)
		{
			print "<a href='logout.php' align='right'>Log out</a><br><br>";
			print "<b>Logged in as ".$Ausername."</b> <br><br>";
			
			//print "<div><fieldset class='fieldset-auto-width'>";
			print "- <a href='userprofile.php' align='right'>Back to Admin Hub</a><br><br>";
			//print "</fieldset></div>";
					
			$sort = $_GET['sort']; //'sort' is magic sorting variable
			if(!isset($sort))
			{
				$sort = "RecordNumber";
			}

			$query = "select * from ReportColonyForm order by $sort";
			$result = mysqli_query($link, $query);

			// print table (happens first before input)

				// first print row of links/headers that sort
				print "
				<br><b>Report A Feral Cat Colony</b><br><br>
				
				<table>
					<thead>
						<tr>
							<th><a href='search.php?sort=RecordNumber'>Record_Number</a></th>
							<th><a href='search.php?sort=DateAndTime'>Date_And_Time</a></th>
							<th><a href='search.php?sort=FullName'>Full_Name</a></th>
							<th colspan='2'><a href='search.php?sort=Email'>Email</a></th>
							<th><a href='search.php?sort=Phone1'>Phone_1</a></th>
							<th><a href='search.php?sort=Phone2'>Phone_2</a></th>
							<th><a href='search.php?sort=ColonyName'>Colony_Name</a></th>
							<th><a href='search.php?sort=ColonyAddress'>ColonyAddress</a></th>
							<th><a href='search.php?sort=City'>City</a></th>
							<th><a href='search.php?sort=County'>County</a></th>
							<th><a href='search.php?sort=ZipCode'>Zip_Code</a></th>
							<th><a href='search.php?sort=AnyoneAttempted'>Anyone_Attempted</a></th>
							<th><a href='search.php?sort=ApproximateCats'>Approximate_Cats</a></th>
							<th><a href='search.php?sort=ColonyCareGiver'>Colony_Caregiver</a></th>
							<th><a href='search.php?sort=EarTipped'>Ear_Tipped</a></th>
							<th><a href='search.php?sort=Pregnant'>Pregnant</a></th>
							<th><a href='search.php?sort=Injured'>Injured</a></th>
							<th><a href='search.php?sort=ColonySetting'>Colony_Setting</a></th>
							<th><a href='search.php?sort=Comments'>Comments</a></th>
							<th><a href='search.php?sort=VolunteerResponding'>Volunteer_Responding</a></th>
							<th><a href='search.php?sort=ResponseDate'>Response_Date</a></th>
							<th><a href='search.php?sort=CustNeedOutcome'>Customer_Needed_Outcome</a></th>
							<th><a href='search.php?sort=BeatTeamLeader'>Beat_Team_Leader</a></th>
							<th><a href='search.php?sort=Outcome'>Outcome</a></th>
							<th><a href='search.php?sort=CompletionDate'>Completion_Date</a></th>
						</tr>
					</thead>
					
					<tbody>";
					
					//while the next row (set by query) exists?
					while($row = mysqli_fetch_row($result))
					{
						list($RecordNumber, $DateAndTime, $FullName, $Email, $Phone1, $Phone2, $ColonyName, $ColonyAddress, 
						$City, $County, $ZipCode, $AnyoneAttempted, $ApproximateCats, $ColonyCareGiver, $EarTipped, $Pregnant, 
						$Injured, $ColonySetting, $Comments, $VolunteerResponding, $ResponseDate, $CustNeedOutcome, $BeatTeamLeader, 
						$Outcome, $CompletionDate) = $row; // variables are set to current row
																		// then printed in one table row
						print "
						<tr>
							<td>$RecordNumber</td>
							<td>$DateAndTime</td>
							<td>$FullName</td>
							<td colspan='2'>$Email</td>
							<td>$Phone1</td>
							<td>$Phone2</td>
							<td>$ColonyName</td>
							<td>$ColonyAddress</td>
							<td>$City</td>
							<td>$County</td>
							<td>$ZipCode</td>
							<td>$AnyoneAttempted</td>
							<td>$ApproximateCats</td>
							<td>$ColonyCareGiver</td>
							<td>$EarTipped</td>
							<td>$Pregnant</td>
							<td>$Injured</td>
							<td>$ColonySetting</td>
							<td>$Comments</td>
							<td>$VolunteerResponding</td>
							<td>$ResponseDate</td>
							<td>$CustNeedOutcome</td>
							<td>$BeatTeamLeader</td>
							<td>$Outcome</td>
							<td>$CompletionDate</td>
						</tr>
						";
					}
					print "
					</tbody>
				</table>";	
				
				
		}
		else if($level == 2)
		{
			print "you aren't supposed to be here.. STOP SNEAKING AROUND";
		}

		
	}
?>

</body>
</html>