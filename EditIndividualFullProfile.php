<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit</title>


<style>
#addExpertContact
{
	display:none;
}

#addExpertContactLoop
{
	display:none;
}

#addExpertContact2
{
	display:none;
}

#addExpertContact3
{
	display:none;
}

#addExpertContact4
{
	display:none;
}

#addExpertContact5
{
	display:none;
}

#addExpertContact6
{
	display:none;
}

#addExpertContact7
{
	display:none;
}

#addExpertContact8
{
	display:none;
}

#addExpertContact9
{
	display:none;
}

#addExpertContact10
{
	display:none;
}
</style>
        
        
<script language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>

</head>

<body>
<form action="UpdateIndividualFullProfile.php" method="POST">
<?php
$expertID = $_POST["ExpertID"];

require_once 'DatabaseConnection.php';

//Query to fetch Expert Bio data
$fetchExpertDataQuery = "SELECT distinct Prefix AS ExpertPrefix, FirstName AS ExpertFirstName, MiddleName AS ExpertMiddleName, LastName AS ExpertLastName, Suffix AS ExpertSuffix, Degree AS ExpertDegree, Title AS ExpertTitle, ProfileDesc AS ExpertProfileDesc, AddressLine1 AS ExpertAddress1, AddressLine2 AS ExpertAddress2, AddressLine3 AS ExpertAddress3 FROM ExpertBioData WHERE ExpertID=" . $expertID;

//Query to fetch contact
$fetchExpertContactQuery = "SELECT distinct ContactID AS ExpertContactID, ContactType AS ExpertContactType, ContactDesc AS ExpertContactDesc, ContactTimings AS ExpertContactTimings FROM Contact WHERE ExpertID=" . $expertID;

//Query to fetch all area of expertise
//$fetchAreaOfExpertiseQuery = 'SELECT distinct ea.Expert_AreaOfExpertiseID AS ExpertAreaOfExpertiseID, aoe.AreaOfExpertiseID AS AreaOfExpertiseID, aoe.Name AS AreaOfExpertiseName FROM AreaOfExpertise aoe, Expert_AreaOfExpertise ea WHERE ea.ExpertID='.$expertID.' AND ea.AreaOfExpertiseID=aoe.AreaOfExpertiseID';
$fetchAreaOfExpertiseQuery = 'SELECT AreaOfExpertiseID AS AreaOfExpertiseID, Name AS AreaOfExpertiseName FROM AreaOfExpertise';

$expertData = sqlsrv_query( $connection, $fetchExpertDataQuery);
$expertContact = sqlsrv_query( $connection, $fetchExpertContactQuery);
$areaOfExpertise = sqlsrv_query( $connection, $fetchAreaOfExpertiseQuery);
	
$expertFullName = NULL;
$prevExpertAreaOfExpertise = NULL;
$prevContactType = NULL;

while($row = sqlsrv_fetch_array($expertData)) {
	$expertPrefix = $row['ExpertPrefix'];		
	$expertFirstName = $row['ExpertFirstName'];	
	$expertMiddleName = $row['ExpertMiddleName'];
	$expertLastName = $row['ExpertLastName'];
	$expertSuffix = $row['ExpertSuffix'];
	$expertDegree = $row['ExpertDegree'];		
	$expertTitle = $row['ExpertTitle'];
	$expertProfileDesc = $row['ExpertProfileDesc'];
	$expertAddressLine1 = $row['ExpertAddress1'];
	$expertAddressLine2 = $row['ExpertAddress2'];
	$expertAddressLine3 = $row['ExpertAddress3'];
?>

	 <input type="hidden" name="ExpertID" value=<?php echo $expertID;?> />

	 <p> Prefix: </p> <input type="text" name="ExpertPrefix" value="<?php echo htmlentities($expertPrefix); ?>"/> 
     &nbsp;
	 <p> First Name: </p> <input type="text" name="ExpertFirstName" value="<?php echo htmlentities($expertFirstName); ?>"/> 
     &nbsp;
	 <p> Middle Name: </p> <input type="text" name="ExpertMiddleName" value="<?php echo htmlentities($expertMiddleName); ?>"/> 
     &nbsp;
	 <p> Last Name: </p> <input type="text" name="ExpertLastName" value="<?php echo htmlentities($expertLastName); ?>"/> 
     &nbsp;
	 <p> Suffix: </p> <input type="text" name="ExpertSuffix" value="<?php echo htmlentities($expertSuffix); ?>"/> 
     &nbsp;
	 <p> Degree: </p> <input type="text" name="ExpertDegree" value="<?php echo htmlentities($expertDegree); ?>"/> 
     <br />                         
     <p> Title: </p> <input type="text" name="ExpertTitle" value="<?php echo htmlentities($expertTitle); ?>"/>
     <br />
     <p> Description: </p> <textarea rows="5" cols="100" name="ExpertProfileDesc"><?php echo htmlentities($expertProfileDesc); ?></textarea>
     <br />
	 <p> Address line 1: </p> <input type="text" name="ExpertAddressLine1" value="<?php echo htmlentities($expertAddressLine1); ?>"/>
     <br />
     <p> Address line 2: </p> <input type="text" name="ExpertAddressLine2" value="<?php echo htmlentities($expertAddressLine2); ?>"/>
     <br />
     <p> Address line 3: </p> <input type="text" name="ExpertAddressLine3" value="<?php echo htmlentities($expertAddressLine3); ?>"/>
     <br />
     <p> Contact details: </p>

	<p>Add Contact Options: <a href="#" id="addPhone">Phone</a> <a href="#" id="addEmail">Email</a> <a href="#" id="addLinkedIn">LinkedIn</a> <a href="#" id="addFacebook">Facebook</a> <a href="#" id="addTwitter">Twitter</a></p> <a href="#" id="addGooglePlus">Google+</a></p>

	<div id="p_scents">		
			<?php
				$contactLoopCount = 0;
				while($row2 = sqlsrv_fetch_array($expertContact)) {
					$expertContactID = $row2['ExpertContactID'];
					$expertContactType = $row2['ExpertContactType'];
					$expertContactDesc = $row2['ExpertContactDesc'];
					$expertContactTimings = $row2['ExpertContactTimings'];
					$contactLoopCount++;
					echo '<p><input type="text" id="p_scnt" size="20" name="ExpertContactType' . $contactLoopCount . '" value="' . $expertContactType . '" readonly/><input type="text" id="p_scnt" size="20" name="ExpertContactDesc' . $contactLoopCount . '" value="' . $expertContactDesc . '"/><a href="#" id="remScnt">Remove</a></p>';
				}
			?>
	</div>

	<script type="text/javascript" language="javascript">
		$(function() {
			var scntDiv = $('#p_scents');
			var i = $('#p_scents p').size() + 1;
			
			$('#addPhone').live('click', function() {
					<?php $contactLoopCount++; ?>
					$('<p><input type="text" id="p_scnt" size="20" name="ExpertContactType' + <?php echo $contactLoopCount; ?> + '" value="Phone" readonly/><input type="text" id="p_scnt" size="20" name="ExpertContactDesc' + <?php echo $contactLoopCount; ?> + '" value="" placeholder="XXX-XXX-XXXX" /><a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
					i++;
					return false;
			});
			
			$('#addEmail').live('click', function() {
					<?php $contactLoopCount++; ?>
					$('<p><input type="text" id="p_scnt" size="20" name="ExpertContactType' + <?php echo $contactLoopCount; ?> + '" value="Email" readonly/><input type="text" id="p_scnt" size="20" name="ExpertContactDesc' + <?php echo $contactLoopCount; ?> + '" value="" placeholder="name@example.com" /><a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
					i++;
					return false;
			});
			
			$('#addLinkedIn').live('click', function() {
					<?php $contactLoopCount++; ?>
					$('<p><input type="text" id="p_scnt" size="20" name="ExpertContactType' + <?php echo $contactLoopCount; ?> + '" value="LinkedIn" readonly/><input type="text" id="p_scnt" size="20" name="ExpertContactDesc' + <?php echo $contactLoopCount; ?> + '" value="" placeholder="http://" /><a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
					i++;
					return false;
			});
			
			$('#addFacebook').live('click', function() {
					<?php $contactLoopCount++; ?>
					$('<p><input type="text" id="p_scnt" size="20" name="ExpertContactType' + <?php echo $contactLoopCount; ?> + '" value="Facebook" readonly/><input type="text" id="p_scnt" size="20" name="ExpertContactDesc' + <?php echo $contactLoopCount; ?> + '" value="" placeholder="http://" /><a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
					i++;
					return false;
			});
			
			$('#addTwitter').live('click', function() {
					<?php $contactLoopCount++; ?>
					$('<p><input type="text" id="p_scnt" size="20" name="ExpertContactType' + <?php echo $contactLoopCount; ?> + '" value="Twitter" readonly/><input type="text" id="p_scnt" size="20" name="ExpertContactDesc' + <?php echo $contactLoopCount; ?> + '" value="" placeholder="http://" /><a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
					i++;
					return false;
			});
			
			$('#addGooglePlus').live('click', function() {
					<?php $contactLoopCount++; ?>
					$('<p><input type="text" id="p_scnt" size="20" name="ExpertContactType' + <?php echo $contactLoopCount; ?> + '" value="Google+" readonly/><input type="text" id="p_scnt" size="20" name="ExpertContactDesc' + <?php echo $contactLoopCount; ?> + '" value="" placeholder="http://" /><a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
					i++;
					return false;
			});
			
			$('#remScnt').live('click', function() { 
					if( i > 1 ) {
							$(this).parents('p').remove();
							i--;
					}
					return false;
			});
		});	
	</script>
<?php
}
?>

<input type="hidden" name="ContactLoopCount" value="<?php echo $contactLoopCount; ?>"/>
<br/>
<p> Area of expertise: 
<select id="expertise">
	<?php
		$fetchExpertiseQuery = 'SELECT AreaOfExpertiseID, Name FROM AreaOfExpertise ORDER BY Name';
		$Expertise = sqlsrv_query( $connection, $fetchExpertiseQuery);
		while($row5 = sqlsrv_fetch_array($Expertise)) {		
			$ExpertiseID = $row5['AreaOfExpertiseID'];
			$ExpertiseName = $row5['Name'];
			echo '<option value="' . $ExpertiseID . '">' . $ExpertiseName . '</option>';
		}
	?>
</select>
<a href="#" id="addExpertise"> Add</a> &nbsp; &nbsp; <a href="EditAreaOfExpertise.php"> Edit List</a></p>

<div id="AOE">		
		<?php
			$expertiseLoopCount = 0;
			$fetchAreaOfExpertiseQuery = 'SELECT distinct aoe.Name AS AreaOfExpertise, aoe.AreaOfExpertiseID  FROM AreaOfExpertise aoe, Expert_AreaOfExpertise ea WHERE ea.ExpertID='.$expertID.' AND ea.AreaOfExpertiseID=aoe.AreaOfExpertiseID';
			$areaOfExpertise = sqlsrv_query( $connection, $fetchAreaOfExpertiseQuery);
			while($row4 = sqlsrv_fetch_array($areaOfExpertise)) {
				$expertiseLoopCount++;				
				$expertAreaOfExpertise = $row4['AreaOfExpertise'];
				$expertAreaOfExpertiseID = $row4['AreaOfExpertiseID'];
				echo '<p><label for="pscnt" style="display: block; width:400px;"><input type="hidden" id="pscnt" size="20" name="Expertise' . $expertiseLoopCount . '" value="' . $expertAreaOfExpertiseID . '"/>' . $expertAreaOfExpertise . '</label> <a href="#" id="rem">Remove</a></p>';
			}
		?>
</div>

<script type="text/javascript" language="javascript">
	$(function() {
		var scntDiv = $('#AOE');
		var j = $('#AOE p').size() + 1;
		
		$('#addExpertise').live('click', function() {
				$('<p><label for="pscnt" style="display: block; width:400px;"><input type="hidden" id="pscnt" size="20" name="Expertise' + j + '" value="' + $('#expertise').val() + '" readonly/>' + $('#expertise option:selected').text() + '</label> <a href="#" id="rem">Remove</a></p>').appendTo(scntDiv);
				j++;
				return false;
		});
		
		$('#rem').live('click', function() { 
				if( j > 1 ) {
						$(this).parents('p').remove();
						j--;
				}
				return false;
		});
	});	
</script>
<input type="hidden" name="ExpertiseLoopCount" value="<?php echo $expertiseLoopCount; ?>"/>

<input type="submit" id="updateExpert" value="Update"/> 


<?php
sqlsrv_close($connection);
?>
</form>

<p><a href="IndividualFullProfile.php?expert_id=<?php echo $expertID;?>">Back to Profile Page</a></p>
</body>

</html>