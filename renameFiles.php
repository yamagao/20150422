<?php
require_once 'DatabaseConnection.php';

$firstNameList = sqlsrv_query( $connection, 'SELECT ExpertID, LastName, FirstName FROM ExpertBiodata');

while($row1 = sqlsrv_fetch_array($firstNameList)) {
	$expertID = $row1['ExpertID'];
	//rename("images/experts/thumbnail/" . $expertID . ".jpg","images/experts/thumbnail/" . $row1['FirstName'] . '-' . $row1['LastName'] . ".jpg");
	rename("images/experts/thumbnail/" . $row1['FirstName'] . '-' . $row1['LastName'] . ".jpg","images/experts/thumbnail/" . $expertID . ".jpg");

}
sqlsrv_close($connection);
?> 