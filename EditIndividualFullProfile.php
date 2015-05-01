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
        
        
<script language='javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js'></script>
       
<script type="text/javascript" language="javascript">
function addButton(id1, id2){
	document.getElementById(id1).style.display='none';
	document.getElementById(id2).style.display='block';
}

function removeButton(id){
	document.getElementById(id).style.display='none';
}
</script>

</head>

<body>
<form action="UpdateIndividualFullProfile.php" method="POST">
<?php
$expertID = $_POST["ExpertID"];
//$expertID = 284;

require_once 'DatabaseConnection.php';

/*	
$fetchExpertDataQuery = 'SELECT distinct e.Prefix AS ExpertPrefix, e.FirstName AS ExpertFirstName, e.MiddleName AS ExpertMiddleName, e.LastName AS ExpertLastName, e.Suffix AS ExpertSuffix, e.Title AS ExpertTitle, e.ProfileDesc AS ExpertProfileDesc, e.Address AS ExpertAddress, c.ContactType AS ExpertContactType, c.ContactDesc AS ExpertContactDesc, c.ContactTimings AS ExpertContactTimings, p.PhotoURL AS ExpertPhoto FROM ExpertBioData e, Expert_AreaOfExpertise ea, Contact c, Photo p WHERE e.ExpertID='.$expertID.' AND e.ExpertID=ea.ExpertID AND e.ExpertID=c.ExpertID AND e.ExpertID=p.ExpertID AND p.PhotoID=1';
*/
//CAST(Content AS TEXT) AS Content //ereg_replace("\n", '',

//Query to fetch Expert Bio data
$fetchExpertDataQuery = 'SELECT distinct Prefix AS ExpertPrefix, FirstName AS ExpertFirstName, MiddleName AS ExpertMiddleName, LastName AS ExpertLastName, Suffix AS ExpertSuffix, Degree AS ExpertDegree, Title AS ExpertTitle, ProfileDesc AS ExpertProfileDesc, AddressLine1 AS ExpertAddress1, AddressLine2 AS ExpertAddress2, AddressLine3 AS ExpertAddress3 FROM ExpertBioData WHERE ExpertID='.$expertID;

//Query to fetch contact
$fetchExpertContactQuery = 'SELECT distinct ContactID AS ExpertContactID, ContactType AS ExpertContactType, ContactDesc AS ExpertContactDesc, ContactTimings AS ExpertContactTimings FROM Contact WHERE ExpertID='.$expertID;

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
         //$expertPhoto = $row['ExpertPhoto'];
		
//	$newExpertFullName = $expertPrefix.' '.$expertFirstName.' '.$expertMiddleName.' '.$expertLastName.' '.$expertSuffix;
		
//	  echo ('<br><br> <img src="'.$expertPhoto.'"> <br>'.$newExpertFullName.'<br>'.$expertTitle.'<br><br>'.$expertProfileDesc.'<br><br>'.$expertAddress);
//	  echo ($newExpertFullName.'<br>'.$expertTitle.'<br><br>'.$expertProfileDesc.'<br><br>'.$expertAddressLine1.'<br><br>'.$expertAddressLine2.'<br><br>'.$expertAddressLine3);
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

	<p><a href="#" id="addScnt">Add Another Input Box</a></p>

	<div id="p_scents">
		<p>
			<?php
				while($row2 = sqlsrv_fetch_array($expertContact)) {
					$expertContactID = $row2['ExpertContactID'];
					$expertContactType = $row2['ExpertContactType'];
					$expertContactDesc = $row2['ExpertContactDesc'];
					$expertContactTimings = $row2['ExpertContactTimings'];
					
					echo '<label for="p_scnts"><input type="text" id="p_scnt" size="20" name="p_scnt" value="' . $expertContactType . '" placeholder="Content Type" /><input type="text" id="p_scnt" size="20" name="p_scnt" value="' . $expertContactDesc . '" placeholder="Detail" /></label><a href="#" id="remScnt">Remove</a></p>';
				}
			?>
		</p>
	</div>

	<script type="text/javascript" language="javascript">
		$(function() {
			var scntDiv = $('#p_scents');
			var i = $('#p_scents p').size() + 1;
			<?php echo "alert(i);";?>
			
			$('#addScnt').live('click', function() {
					$('<p><label for="p_scnts"><input type="text" id="p_scnt" size="20" name="p_scnt" value="" placeholder="Content Type" /><input type="text" id="p_scnt" size="20" name="p_scnt" value="" placeholder="Detail" /></label> <a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
					i++;
					return false;
			});
			
			$('#remScnt').live('click', function() { 
					if( i > 2 ) {
							$(this).parents('p').remove();
							i--;
					}
					return false;
			});
		});	
	</script>
<?php
}

$contactLoopCount = 1;
while($row2 = sqlsrv_fetch_array($expertContact)) {
	$expertContactID = $row2['ExpertContactID'];
	$expertContactType = $row2['ExpertContactType'];
	$expertContactDesc = $row2['ExpertContactDesc'];
	$expertContactTimings = $row2['ExpertContactTimings'];
	
	echo('<div id="expertContact'.$contactLoopCount.'">');
	echo ('<br />');	
	echo ('<input type="hidden" name="ExpertContactID'.$contactLoopCount.'" value= '.$expertContactID.' />');
	echo ('<input type="text" name="ExpertContactType'.$contactLoopCount.'" value= '.htmlentities($expertContactType).' />');
	echo ('&nbsp;&nbsp;&nbsp;&nbsp;');
	echo ('<input type="text" name="ExpertContactDesc'.$contactLoopCount.'" value= '.htmlentities($expertContactDesc).' />');
	echo ('<button name="RemoveContact'.$contactLoopCount.'" onclick="removeButton(\'expertContact'.$contactLoopCount.'\')"> - </button> </div>');
	
/*	echo ('<br />');
	echo ('<input type="text" name="ExpertContactTimings'.$contactLoopCount.'" value= '.htmlentities($expertContactTimings).' />');
	echo ('<br />');
	*/
	?>
  
    <?php
	$contactLoopCount = $contactLoopCount + 1;
}

echo ('<button id="AddContact1" onclick="addButton(\'AddContact1\', \'addExpertContact2\')"> + </button>');		
for($addContactLoopCount=2; $addContactLoopCount<10; $addContactLoopCount++) {
	echo('<div id="addExpertContact'.$addContactLoopCount.'">');
	echo ('<br />');
	echo ('<input type="hidden" name="ExpertContactID'.$addContactLoopCount.'"/>');
	echo ('<input type="text" name="ExpertContactType'.$addContactLoopCount.'"/>');
	echo ('&nbsp;&nbsp;&nbsp;&nbsp;');
	echo ('<input type="text" name="ExpertContactDesc'.$addContactLoopCount.'"/>');
	$x = $addContactLoopCount+1;
	echo ('<button id="AddContact'.$addContactLoopCount.'" onclick="addButton(\'AddContact'.$addContactLoopCount.'\', \'addExpertContact'.$x.'\')"> + </button> </div>');
}

?>



<input type="hidden" name="ContactLoopCount" value="<?php echo $contactLoopCount ?>"/>
<p> Area of expertise: </p> <br />

<!--
code was written by mohan dont know y


<input type='text' /><br/>
<select name="AOEName" style='display:none;'>


-->
<?php

//$aoeLoopCount = 1;
//while($row3 = sqlsrv_fetch_array($areaOfExpertise)) {
//
//	$expertAreaOfExpertiseID = $row3['ExpertAreaOfExpertiseID'];	
//	$areaOfExpertiseID = $row3['AreaOfExpertiseID'];			
//	$areaOfExpertiseName = $row3['AreaOfExpertiseName'];
//
////	echo ('<input type="hidden" name="AOEID'.$aoeLoopCount.'" value= '.$areaOfExpertiseID.' />');
////	echo ('<input type="hidden" name="ExpertAOEID'.$aoeLoopCount.'" value= '.$expertAreaOfExpertiseID.' />');
//	echo ('<option name="AOEName'.$aoeLoopCount.'" value= '.htmlentities($areaOfExpertise).'>'.htmlentities($areaOfExpertiseName).'</option>');
//
//	$aoeLoopCount = $aoeLoopCount + 1;		
//}




// code written by binesh, just for checking the functionality

$fetchAreaOfExpertiseQuery = 'SELECT distinct aoe.Name AS AreaOfExpertise FROM AreaOfExpertise aoe, Expert_AreaOfExpertise ea WHERE ea.ExpertID='.$expertID.' AND ea.AreaOfExpertiseID=aoe.AreaOfExpertiseID';

$areaOfExpertise = sqlsrv_query( $connection, $fetchAreaOfExpertiseQuery);

echo '<b>Area of Experties:</b>';


while($row4 = sqlsrv_fetch_array($areaOfExpertise)) {		
	$expertAreaOfExpertise = $row4['AreaOfExpertise'];
	echo ('<br>'.$expertAreaOfExpertise);
	echo ('<a onclick=>&nbsp; &nbsp; &nbsp; &nbsp; remove</a>');
}

// code by binesh ends.




?>
</select><br/>
    
<br>
<input type="hidden" name="AOELoopCount" value="<?php echo $aoeLoopCount ?>"/>
<br />

<input type="submit" id="updateExpert" value="Update"/> 


<?php
sqlsrv_close($connection);
?>
</form>
</body>

</html>