<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit</title>
</head>

<body>

<?php
$expertID = $_POST["ExpertID"];
$expertPrefix = $_POST["ExpertPrefix"];
$expertFirstName = $_POST["ExpertFirstName"];
$expertMiddleName = $_POST["ExpertMiddleName"];
$expertLastName = $_POST["ExpertLastName"];
$expertSuffix = $_POST["ExpertSuffix"];
$expertDegree = $_POST["ExpertDegree"];
$expertTitle = $_POST["ExpertTitle"];
$expertProfileDesc = $_POST["ExpertProfileDesc"];
$expertAddressLine1 = $_POST["ExpertAddressLine1"];
$expertAddressLine2 = $_POST["ExpertAddressLine2"];
$expertAddressLine3 = $_POST["ExpertAddressLine3"];

require_once 'DatabaseConnection.php';

//Query to update Expert Bio data
$updateExpertDataQuery = 'UPDATE ExpertBioData SET Prefix=\''. $expertPrefix .'\', FirstName=\''. $expertFirstName .'\', MiddleName=\''. $expertMiddleName .'\', LastName=\''. $expertLastName .'\', Suffix=\''. $expertSuffix .'\', Degree=\''. $expertDegree .'\', Title=\''. $expertTitle .'\', ProfileDesc=\''. $expertProfileDesc .'\', AddressLine1=\''. $expertAddressLine1 .'\', AddressLine2=\''. $expertAddressLine2 .'\', AddressLine3=\''. $expertAddressLine3 .'\' WHERE ExpertID='.$expertID.';';

$expertData = sqlsrv_query( $connection, $updateExpertDataQuery);
if( !$expertData ) {
    die( print_r( sqlsrv_errors(), true));
}

//Query to update contact
$contactLoopCount = $_POST["ContactLoopCount"];
for($i=1; $i<$contactLoopCount; $i++)
{	
	$updateExpertContactQuery = 'UPDATE Contact SET ContactType=\''. $_POST['ExpertContactType'.$i] .'\', ContactDesc=\''. $_POST['ExpertContactDesc'.$i] .'\', ContactTimings=\''. $_POST['ExpertContactTimings'.$i] .'\' WHERE ContactID='.$_POST['ExpertContactID'.$i].' AND ExpertID='.$expertID.';';
	
	$contactData = sqlsrv_query( $connection, $updateExpertContactQuery);
	
	if( !$contactData ) {
    	die( print_r( sqlsrv_errors(), true));
	}
	sqlsrv_commit($connection);	
}

//Query to update all area of expertise
$aoeLoopCount = $_POST["AOELoopCount"];
for($j=1; $j<$aoeLoopCount; $j++)
{	
	$updateExpertAOEQuery = 'UPDATE Expert_AreaOfExpertise SET ExpertID='. $expertID . ', AreaOfExpertiseID='. $_POST['AOEID'.$j] .' WHERE Expert_AreaOfExpertiseID='.$_POST['ExpertAOEID'.$j].';';
	
	$aoeData = sqlsrv_query( $connection, $updateExpertAOEQuery);
	
	if( !$aoeData ) {
    	die( print_r( sqlsrv_errors(), true));
	}
	sqlsrv_commit($connection);	
	
}

sqlsrv_commit($connection);	
sqlsrv_close($connection);

header("Location: IndividualFullProfile.php?expert_id=" . $expertID);
?>

</body>

</html>