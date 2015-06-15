<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit</title>
</head>

<body>

<?php

require_once 'DatabaseConnection.php';

//Query to insert AreaOfExpertise
for($i = 1; $i <= 10; $i++)
{	
	if($_POST['addExpertise'.$i] == null){
		continue;
	}
	
	$insertAOE = "IF NOT EXISTS (SELECT * FROM AreaOfExpertise WHERE Name = '" . str_replace("'","''",$_POST['addExpertise'.$i]) . "') INSERT INTO AreaOfExpertise (Name) VALUES ('" . str_replace("'","''",$_POST['addExpertise'.$i]) ."');";
	
	$aoeData = sqlsrv_query( $connection, $insertAOE);
	
	if( !$aoeData ) {
    	die( print_r( sqlsrv_errors(), true));
	}
	sqlsrv_commit($connection);	
}

//Query to delete AreaOfExpertis
for($i = 1; $i <= 10; $i++)
{	
	if($_POST['deleteExpertise'.$i] == null){
		continue;
	}
	$deleteAOE = "DELETE FROM AreaOfExpertise WHERE AreaOfExpertiseID = '" . str_replace("'","''",$_POST['deleteExpertise'.$i]) . "';";
	
	$expertiseData = sqlsrv_query( $connection, $deleteAOE);
	
	if( !$expertiseData ) {
    	die( print_r( sqlsrv_errors(), true));
	}
	sqlsrv_commit($connection);	
	
	$deleteAOE = "DELETE FROM Expert_AreaOfExpertise WHERE AreaOfExpertiseID = '" . str_replace("'","''",$_POST['deleteExpertise'.$i]) . "';";
	
	$expertiseData = sqlsrv_query( $connection, $deleteAOE);
	
	if( !$expertiseData ) {
    	die( print_r( sqlsrv_errors(), true));
	}
	sqlsrv_commit($connection);	
}

sqlsrv_close($connection);

header("Location: EditAreaOfExpertise.php");
?>

</body>

</html>