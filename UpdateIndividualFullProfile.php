<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit</title>
</head>

<body>

<?php
$expertID = $_POST["ExpertID"];
$expertPrefix = str_replace("'","''",$_POST["ExpertPrefix"]);
$expertFirstName = str_replace("'","''",$_POST["ExpertFirstName"]);
$expertMiddleName = str_replace("'","''",$_POST["ExpertMiddleName"]);
$expertLastName = str_replace("'","''",$_POST["ExpertLastName"]);
$expertSuffix = str_replace("'","''",$_POST["ExpertSuffix"]);
$expertDegree = str_replace("'","''",$_POST["ExpertDegree"]);
$expertTitle = str_replace("'","''",$_POST["ExpertTitle"]);
$expertProfileDesc = str_replace("'","''",$_POST["ExpertProfileDesc"]);
$expertAddressLine1 = str_replace("'","''",$_POST["ExpertAddressLine1"]);
$expertAddressLine2 = str_replace("'","''",$_POST["ExpertAddressLine2"]);
$expertAddressLine3 = str_replace("'","''",$_POST["ExpertAddressLine3"]);

require_once 'DatabaseConnection.php';

//Query to update Expert Bio data
$updateExpertDataQuery = 'UPDATE ExpertBioData SET Prefix=\''. $expertPrefix .'\', FirstName=\''. $expertFirstName .'\', MiddleName=\''. $expertMiddleName .'\', LastName=\''. $expertLastName .'\', Suffix=\''. $expertSuffix .'\', Degree=\''. $expertDegree .'\', Title=\''. $expertTitle .'\', ProfileDesc=\''. $expertProfileDesc .'\', AddressLine1=\''. $expertAddressLine1 .'\', AddressLine2=\''. $expertAddressLine2 .'\', AddressLine3=\''. $expertAddressLine3 .'\' WHERE ExpertID='.$expertID.';';

$expertData = sqlsrv_query( $connection, $updateExpertDataQuery);
if( !$expertData ) {
    die( print_r( sqlsrv_errors(), true));
}

//Query to delete contact
$updateExpertContactQuery = "DELETE FROM Contact WHERE ExpertID = '" . $expertID . "';";
$contactData = sqlsrv_query( $connection, $updateExpertContactQuery);
if( !$contactData ) {
	die( print_r( sqlsrv_errors(), true));
}

//Query to insert contact
$contactLoopCount = $_POST["ContactLoopCount"];
for($i = 1; $i <= $contactLoopCount; $i++)
{	
	if($_POST['ExpertContactType'.$i] == null){
		continue;
	}
	//$updateExpertContactQuery = 'UPDATE Contact SET ContactType=\''. $_POST['ExpertContactType'.$i] .'\', ContactDesc=\''. $_POST['ExpertContactDesc'.$i] .'\', ContactTimings=\''. $_POST['ExpertContactTimings'.$i] .'\' WHERE ExpertID='.$expertID.';';
	$updateExpertContactQuery = "INSERT INTO Contact (ExpertID, ContactType, ContactDesc) VALUES ('" . $expertID . "', '" . $_POST['ExpertContactType'.$i] ."', '" . $_POST['ExpertContactDesc' . $i] ."');";
	
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