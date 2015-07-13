<form name="form" class="form-expert-background" id="form" style= "padding: 20px 0px 20px 10px;"> 
 <select id="searchBy">
  <option value="null">SEARCH EXPERTS BY</option>
  <option value="expertise">Expertise</option>
  <option value="lastName">Last Name</option>
  <option value="firstName">First Name</option>
</select>
</form>

<div id="alphabet"></div>

<script>
//document.getElementById("alphabet").innerHTML = "<p>test</p>";
$("#searchBy").change(function(){	
  	if($("#searchBy").val() === "null"){
		document.getElementById("alphabet").innerHTML = "";
		return;
	}
	var alphabet = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
	//var valText = {expertise:"Expertise", lastName:"Last Name", firstName:"First Name"};
	if($("#searchBy").val() === "expertise"){
		alphabet = ["4-H"].concat(alphabet);
	}
	var htmlValue = "<p class='expert-sort'>";
	for(i = 0; i < alphabet.length - 1; i++){
		htmlValue += "<a href='testYQ.php?" + $("#searchBy").val() + "=" + alphabet[i] + "'>" + alphabet[i] + "</a>&nbsp| ";
	}
	htmlValue += "<a href='testYQ.php?" + $("#searchBy").val() + "=" + alphabet[i] + "'>" + alphabet[i] + "</a></p>";
	document.getElementById("alphabet").innerHTML = htmlValue;
	//document.getElementById("result").getElementsByTagName("h4")[0].innerHTML = valText[$("#searchBy").val()] + " - ";
});
</script>


  <h2><?php if($_GET["expertise"] != ""){echo "Expertise - " . $_GET["expertise"];} 
  if($_GET["firstName"] != ""){echo "First Name - " . $_GET["firstName"];}
  if($_GET["lastName"] != ""){echo "Last Name - " . $_GET["lastName"];}?></h2>
  
<?php
require_once 'DatabaseConnection.php';

if($_GET["expertise"] != ""){
	$expertise = $_GET["expertise"];
	//$lastName = $_GET["lastName"];
	//$firstName = $_GET["firstName"];
	$areaOfExpertise = sqlsrv_query( $connection, 'SELECT AreaOfExpertiseID, Name FROM AreaOfExpertise WHERE Name LIKE \'' . $expertise . '%\' ORDER BY Name');
	$resultFlag = false;
	while($row1 = sqlsrv_fetch_array($areaOfExpertise)) {
		if (!$resultFlag)
			$resultFlag = true;
		$areaOfExpertiseID = $row1['AreaOfExpertiseID'];
		echo '<h2 style="clear:both;">&nbsp;&nbsp;'.$row1['Name'].'</h2>';

		$fetchExpertDataQuery ="SELECT ea.ExpertID, LastName, FirstName, Title, AddressLine1, AddressLine2 FROM Expert_AreaOfExpertise ea, ExpertBiodata b WHERE ea.ExpertID = b.ExpertID AND ea.AreaOfExpertiseID = " . $areaOfExpertiseID . " ORDER BY FirstName";
		
		$expertData = sqlsrv_query( $connection, $fetchExpertDataQuery);	
		
		while($row2 = sqlsrv_fetch_array($expertData)) {
			$expertID = $row2['ExpertID'];
			echo '<div class="faculty">';
			
			//$photoQuery = sqlsrv_query($connection, "SELECT PhotoURL FROM Photo WHERE ExpertID = " . $expertID);
			//$filename = 'images/experts/thumbnail/' . $row2['FirstName'] . '-' . $row2['LastName'] . '.jpg';
			$filename = 'images/experts/thumbnail/' . $expertID . '.jpg';
			if(file_exists($filename)){
				echo '<a href="IndividualFullProfile.php?expert_id='.$expertID.'"><img src="' . $filename . '" alt="'. $row2['FirstName'] . ' ' . $row2['LastName'] .'" title="'. $row2['FirstName'] . ' ' . $row2['LastName'] .'" height="180" width="150"></a>';
			}
			else{
				echo '<img src="images/experts/thumbnail/placeholder.jpg" height="180" width="150">';
			}
			
			echo '<h3><a href="IndividualFullProfile.php?expert_id='.$expertID.'">' . $row2['FirstName'] . ' ' . $row2['LastName'] . '</a></h3><p><strong>';
			if($row2['Title'] != "")
				echo $row2['Title'] . "</strong><br>";
			echo $row2['AddressLine1'] . "<br>";
			echo $row2['AddressLine2'] . "<br>";
			$contactQuery = sqlsrv_query( $connection, "SELECT ContactType, ContactDesc FROM ExpertBioData b, Contact c WHERE b.ExpertID = c.ExpertID AND b.expertID = " . $expertID);
			while($row3 = sqlsrv_fetch_array($contactQuery)){
				echo $row3['ContactType'] . " : " . $row3['ContactDesc'] . "<br>";
			}
			echo "</p></div>";
		}
	}
	if(!$resultFlag)
		echo "<br>No result under this category currently.";
}

if($_GET["lastName"] != ""){
	$lastName = $_GET["lastName"];
	$lastNameList = sqlsrv_query( $connection, 'SELECT ExpertID, LastName, FirstName, Title, AddressLine1, AddressLine2 FROM ExpertBiodata WHERE LastName LIKE \'' . $lastName . '%\' ORDER BY LastName');
	$resultFlag = false;	
	while($row1 = sqlsrv_fetch_array($lastNameList)) {
		if (!$resultFlag)
			$resultFlag = true;
		$expertID = $row1['ExpertID'];
		echo '<div class="faculty">';
		
		//$photoQuery = sqlsrv_query($connection, "SELECT PhotoURL FROM Photo WHERE ExpertID = " . $expertID);
		//$filename = 'images/experts/thumbnail/' . $row1['FirstName'] . '-' . $row1['LastName'] . '.jpg';
		$filename = 'images/experts/thumbnail/' . $expertID . '.jpg';
		if(file_exists($filename)){
			echo '<a href="IndividualFullProfile.php?expert_id='.$expertID.'"><img src="' . $filename . '" alt="'. $row1['FirstName'] . ' ' . $row1['LastName'] .'" title="'. $row1['FirstName'] . ' ' . $row1['LastName'] .'" height="180" width="150"></a><br>';
		}
		else{
			echo '<img src="images/experts/thumbnail/placeholder.jpg" height="180" width="150"><br>';
		}
		
		echo '<h3><a href="IndividualFullProfile.php?expert_id='.$expertID.'">'.$row1['LastName'].', ' . $row1['FirstName'] . '</a></h3>';
		if($row1['Title'] != "")
			echo "<p><strong>" . $row1['Title'];
/*		echo "<br>" . $row1['AddressLine1'];
		echo "<br>" . $row1['AddressLine2'];
		
		$contactQuery = sqlsrv_query($connection, "SELECT ContactType, ContactDesc FROM ExpertBioData b, Contact c WHERE b.ExpertID = c.ExpertID AND b.expertID = " . $expertID);
		while($row2 = sqlsrv_fetch_array($contactQuery)){
			echo "<br>" . $row2['ContactType'] . " : " . $row2['ContactDesc'];
		}
*/		echo "</strong></p>";		
		$expertiseQuery = sqlsrv_query($connection, "SELECT Name FROM Expert_AreaOfExpertise ea, AreaOfExpertise a WHERE ea.AreaOfExpertiseID = a.AreaOfExpertiseID AND ea.ExpertID = " . $expertID);
		echo "<ul>";
//		if($rowFirst = sqlsrv_fetch_array($expertiseQuery))
//			echo "<a href='testYQ.php?expertise=" . $rowFirst['Name'] . "'>[".$rowFirst['Name'] . "]</a>";
		while($row3 = sqlsrv_fetch_array($expertiseQuery)){
			echo "<li><a href='testYQ.php?expertise=" . $row3['Name'] . "'>".$row3['Name'] . "</a></li>";
		}
		
		echo "</ul></div>";
	}	
	if(!$resultFlag)
		echo "<p>No result under this category currently.</p>";
}

if($_GET["firstName"] != ""){
	$firstName = $_GET["firstName"];
	$firstNameList = sqlsrv_query( $connection, 'SELECT ExpertID, LastName, FirstName, Title, AddressLine1, AddressLine2 FROM ExpertBiodata WHERE FirstName LIKE \'' . $firstName . '%\' ORDER BY FirstName');
	$resultFlag = false;
	while($row1 = sqlsrv_fetch_array($firstNameList)) {
		if (!$resultFlag)
			$resultFlag = true;
		$expertID = $row1['ExpertID'];
		echo '<div class="faculty">';
		
		//$photoQuery = sqlsrv_query($connection, "SELECT PhotoURL FROM Photo WHERE ExpertID = " . $expertID);
		//$filename = 'images/experts/thumbnail/' . $row1['FirstName'] . '-' . $row1['LastName'] . '.jpg';
		$filename = 'images/experts/thumbnail/' . $expertID . '.jpg';
		if(file_exists($filename)){
			echo '<a href="IndividualFullProfile.php?expert_id='.$expertID.'"><img src="' . $filename . '" alt="'. $row1['FirstName'] . ' ' . $row1['LastName'] .'" title="'. $row1['FirstName'] . ' ' . $row1['LastName'] .'" height="180" width="150"></a>';
		}
		else{
			echo '<img src="images/experts/thumbnail/placeholder.jpg" height="180" width="150">';
		}
		
		echo '<h3><a href="IndividualFullProfile.php?expert_id='.$expertID.'">' . $row1['FirstName'] . ' ' . $row1['LastName'] . '</a></h3>';
		if($row1['Title'] != "")
			echo "<p><strong>" . $row1['Title'];
/*		echo "<br>" . $row1['AddressLine1'];
		echo "<br>" . $row1['AddressLine2'];
		
		$contactQuery = sqlsrv_query($connection, "SELECT ContactType, ContactDesc FROM ExpertBioData b, Contact c WHERE b.ExpertID = c.ExpertID AND b.expertID = " . $expertID);
		while($row2 = sqlsrv_fetch_array($contactQuery)){
			echo "<br>" . $row2['ContactType'] . " : " . $row2['ContactDesc'];
		}
*/		echo "</strong></p>";
		$expertiseQuery = sqlsrv_query($connection, "SELECT Name FROM Expert_AreaOfExpertise ea, AreaOfExpertise a WHERE ea.AreaOfExpertiseID = a.AreaOfExpertiseID AND ea.ExpertID = " . $expertID);
		echo "<ul>";
//		if($rowFirst = sqlsrv_fetch_array($expertiseQuery))
//			echo "<a href='testYQ.php?expertise=" . $rowFirst['Name'] . "'>[".$rowFirst['Name'] . "]</a>";
		while($row3 = sqlsrv_fetch_array($expertiseQuery)){
			echo "<li><a href='testYQ.php?expertise=" . $row3['Name'] . "'>".$row3['Name'] . "</a></li>";
		}
		
		echo "</ul></div>";
	}
	if(!$resultFlag)
		echo '<p>No result under this category currently.</p>';
}
sqlsrv_close($connection);
?>