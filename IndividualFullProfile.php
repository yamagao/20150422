<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>
<body>
<?php
$expertID = $_GET["expert_id"];
?>

<form action="EditIndividualFullProfile.php" method="POST">

<?php
require_once 'DatabaseConnection.php';

/*	
$fetchExpertDataQuery = 'SELECT distinct e.Prefix AS ExpertPrefix, e.FirstName AS ExpertFirstName, e.MiddleName AS ExpertMiddleName, e.LastName AS ExpertLastName, e.Suffix AS ExpertSuffix, e.Title AS ExpertTitle, e.ProfileDesc AS ExpertProfileDesc, e.Address AS ExpertAddress, c.ContactType AS ExpertContactType, c.ContactDesc AS ExpertContactDesc, c.ContactTimings AS ExpertContactTimings, p.PhotoURL AS ExpertPhoto FROM ExpertBioData e, Expert_AreaOfExpertise ea, Contact c, Photo p WHERE e.ExpertID='.$expertID.' AND e.ExpertID=ea.ExpertID AND e.ExpertID=c.ExpertID AND e.ExpertID=p.ExpertID AND p.PhotoID=1';

$fetchExpertDataQuery = 'SELECT distinct e.Prefix AS ExpertPrefix, e.FirstName AS ExpertFirstName, e.MiddleName AS ExpertMiddleName, e.LastName AS ExpertLastName, e.Suffix AS ExpertSuffix, e.Title AS ExpertTitle, e.ProfileDesc AS ExpertProfileDesc, e.AddressLine1 AS ExpertAddress1, e.AddressLine2 AS ExpertAddress2, e.AddressLine3 AS ExpertAddress3, c.ContactType AS ExpertContactType, c.ContactDesc AS ExpertContactDesc, c.ContactTimings AS ExpertContactTimings, aoe.Name AS ExpertAreaOFExpertise FROM ExpertBioData e, Expert_AreaOfExpertise ea, AreaOfExpertise aoe, Contact c WHERE e.ExpertID='.$expertID.' AND e.ExpertID=ea.ExpertID AND e.ExpertID=c.ExpertID AND ea.AreaOfExpertiseID=aoe.AreaOfExpertiseID';

*/


//Query to fetch Expert Bio data
$fetchExpertDataQuery = 'SELECT distinct Prefix AS ExpertPrefix, FirstName AS ExpertFirstName, MiddleName AS ExpertMiddleName, LastName AS ExpertLastName, Suffix AS ExpertSuffix, Degree AS ExpertDegree, Title AS ExpertTitle, ProfileDesc AS ExpertProfileDesc, AddressLine1 AS ExpertAddress1, AddressLine2 AS ExpertAddress2, AddressLine3 AS ExpertAddress3 FROM ExpertBioData WHERE ExpertID='.$expertID;

//Query to fetch contact
$fetchExpertContactQuery = 'SELECT distinct ContactType AS ExpertContactType, ContactDesc AS ExpertContactDesc, ContactTimings AS ExpertContactTimings FROM Contact WHERE ExpertID='.$expertID;

//Query to fetch all area of expertise
$fetchAreaOfExpertiseQuery = 'SELECT distinct aoe.Name AS AreaOfExpertise FROM AreaOfExpertise aoe, Expert_AreaOfExpertise ea WHERE ea.ExpertID='.$expertID.' AND ea.AreaOfExpertiseID=aoe.AreaOfExpertiseID';

$expertData = sqlsrv_query( $connection, $fetchExpertDataQuery);
$expertContact = sqlsrv_query( $connection, $fetchExpertContactQuery);
$areaOfExpertise = sqlsrv_query( $connection, $fetchAreaOfExpertiseQuery);

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
		
	$newExpertFullName = $expertPrefix.' '.$expertFirstName.' '.$expertMiddleName.' '.$expertLastName.' '.$expertSuffix.' '.$expertDegree;
		
//	  echo ('<br><br> <img src="'.$expertPhoto.'"> <br>'.$newExpertFullName.'<br>'.$expertTitle.'<br><br>'.$expertProfileDesc.'<br><br>'.$expertAddress);
	  echo ($newExpertFullName.'<br>'.$expertTitle.'<br><br>'.$expertProfileDesc.'<br><br>'.$expertAddressLine1.'<br><br>'.$expertAddressLine2.'<br><br>'.$expertAddressLine3);
}

while($row2 = sqlsrv_fetch_array($expertContact)) {
	$expertContactType = $row2['ExpertContactType'];
	$expertContactDesc = $row2['ExpertContactDesc'];
	$expertContactTimings = $row2['ExpertContactTimings'];	
	echo ('<br>'.$expertContactType.' : '.$expertContactDesc.' '.$expertContactTimings);
}
echo ('<br>');
echo ('<br>');
echo '<b>Area of Experties:</b>';


while($row4 = sqlsrv_fetch_array($areaOfExpertise)) {		
	$expertAreaOfExpertise = $row4['AreaOfExpertise'];
	echo ('<br>'.$expertAreaOfExpertise);
}



sqlsrv_close($connection);
?>

<input type="hidden" name="ExpertID" value=<?php echo $expertID;?> />
<input type="submit" name="editExpert" value="Edit"/> 
</body>
</html>