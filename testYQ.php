<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>IFAS EXPERTS Database</title>
<!--Metadata-->
<?php include 'include_meta.shtml'; ?>
<!--End Metadata-->
<!--Styles-->
<link rel="stylesheet" href="css/foundation.css" />
<link rel="stylesheet" href="css/override-main.css" />
<link rel="stylesheet" href="css/single-menu-tabs.css" />
<link rel='stylesheet' id='font-awesome-css'  href='css/font-awesome-4.2.0/css/font-awesome.min.css' type='text/css' media='all' />
<!--Styles-->
<!--Scripts-->
<script src="js/vendor/modernizr.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="jquery-1.10.2.min.js"></script>
 <!--End Scripts-->
 <!--Analytics-->
<?php include 'include_analytics.shtml'; ?>
<!--End Analytics-->
</head>
<body>
<!--=================================Top Banner Area====================-->
<!--UF/IFAS logo and site title-->
<div class="row">
  <div id="site-ID">
    <div id="logo" class="medium-3 columns"><img src="css/images/UF-IFAS-logo.png" width="148" height="48" alt="Logo placeholder"></div>
    <div id="site-title"  class="medium-9 columns">
      <h1><a href="test.php">IFAS Communications</a></h1>
    </div>
  </div>
</div>
<!--END UF/IFAS logo and site title--> 
<!--==============================Top Navigation========================================-->
<!--Top navigation dropdown-->
<div class="row">
     <?php include 'include_top_nav_drop_down.shtml'; ?> 
</div>
<!--END top navigation--> 
<!--Social media icons-->
<div class="row">
 <?php include 'include_social_media.shtml'; ?> 
 </div>
 <!--End Social Media icons-->
<!--============================Main Content===============-->
<!--============================Feature Boxes Area========================-->
<div class="row">
<div id="content" class="medium-12 columns">
<!--Left column -->
  <div id="content-left" class="medium-12 columns">
  <h1>UF/IFAS Faculty Experts</h1>

<form> 
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
	var htmlValue = "";
	for(i = 0; i < alphabet.length; i++){
		htmlValue += "<a href='testYQ.php?" + $("#searchBy").val() + "=" + alphabet[i] + "'>" + alphabet[i] + "</a>  &nbsp";
	}
	htmlValue += "<hr/>";
	document.getElementById("alphabet").innerHTML = htmlValue;
	//document.getElementById("result").getElementsByTagName("h4")[0].innerHTML = valText[$("#searchBy").val()] + " - ";
});
</script>

<div id="result">  
  <h3><?php if($_GET["expertise"] != ""){echo "Expertise - " . $_GET["expertise"];} 
  if($_GET["firstName"] != ""){echo "First Name - " . $_GET["firstName"];}
  if($_GET["lastName"] != ""){echo "Last Name - " . $_GET["lastName"];}?></h3>
  
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
		echo '<br>';
		echo '<b>'.$row1['Name'].'</b>';

		$fetchExpertDataQuery ="SELECT ea.ExpertID, LastName, FirstName, Title, AddressLine1, AddressLine2 FROM Expert_AreaOfExpertise ea, ExpertBiodata b WHERE ea.ExpertID = b.ExpertID AND ea.AreaOfExpertiseID = " . $areaOfExpertiseID . " ORDER BY FirstName";
		
		$expertData = sqlsrv_query( $connection, $fetchExpertDataQuery);	
		
		while($row2 = sqlsrv_fetch_array($expertData)) {
			$expertID = $row2['ExpertID'];
			echo '<br><br>';
			
			//$photoQuery = sqlsrv_query($connection, "SELECT PhotoURL FROM Photo WHERE ExpertID = " . $expertID);
			$filename = 'images/experts/thumbnail/' . $row2['FirstName'] . '-' . $row2['LastName'] . '.jpg';
			if(file_exists($filename)){
				echo '<a href="IndividualFullProfile.php?expert_id='.$expertID.'"><img src="' . $filename . '" alt="'. $row2['FirstName'] . ' ' . $row2['LastName'] .'" title="'. $row2['FirstName'] . ' ' . $row2['LastName'] .'" height="180" width="150"></a><br>';
			}
			else{
				echo '<img src="images/experts/thumbnail/placeholder.jpg" height="180" width="150"><br>';
			}
			
			echo '<b><a href="IndividualFullProfile.php?expert_id='.$expertID.'">' . $row2['FirstName'] . ' ' . $row2['LastName'] . '</a></b>';
			if($row2['Title'] != "")
				echo "<br>" . $row2['Title'];
			echo "<br>" . $row2['AddressLine1'];
			echo "<br>" . $row2['AddressLine2'];
			$contactQuery = sqlsrv_query( $connection, "SELECT ContactType, ContactDesc FROM ExpertBioData b, Contact c WHERE b.ExpertID = c.ExpertID AND b.expertID = " . $expertID);
			while($row3 = sqlsrv_fetch_array($contactQuery)){
				echo "<br>" . $row3['ContactType'] . " : " . $row3['ContactDesc'];
			}
		}
		echo '<br><br><br>';
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
		echo '<br><br>';
		
		//$photoQuery = sqlsrv_query($connection, "SELECT PhotoURL FROM Photo WHERE ExpertID = " . $expertID);
		$filename = 'images/experts/thumbnail/' . $row1['FirstName'] . '-' . $row1['LastName'] . '.jpg';
		if(file_exists($filename)){
			echo '<a href="IndividualFullProfile.php?expert_id='.$expertID.'"><img src="' . $filename . '" alt="'. $row1['FirstName'] . ' ' . $row1['LastName'] .'" title="'. $row1['FirstName'] . ' ' . $row1['LastName'] .'" height="180" width="150"></a><br>';
		}
		else{
			echo '<img src="images/experts/thumbnail/placeholder.jpg" height="180" width="150"><br>';
		}
		
		echo '<b><a href="IndividualFullProfile.php?expert_id='.$expertID.'">'.$row1['LastName'].', ' . $row1['FirstName'] . '</a></b>';
		if($row1['Title'] != "")
			echo "<br>" . $row1['Title'];
		echo "<br>" . $row1['AddressLine1'];
		echo "<br>" . $row1['AddressLine2'];
		
		$contactQuery = sqlsrv_query($connection, "SELECT ContactType, ContactDesc FROM ExpertBioData b, Contact c WHERE b.ExpertID = c.ExpertID AND b.expertID = " . $expertID);
		while($row2 = sqlsrv_fetch_array($contactQuery)){
			echo "<br>" . $row2['ContactType'] . " : " . $row2['ContactDesc'];
		}
		
		$expertiseQuery = sqlsrv_query($connection, "SELECT Name FROM Expert_AreaOfExpertise ea, AreaOfExpertise a WHERE ea.AreaOfExpertiseID = a.AreaOfExpertiseID AND ea.ExpertID = " . $expertID);
		echo "<br>Expertise: ";
//		if($rowFirst = sqlsrv_fetch_array($expertiseQuery))
//			echo "<a href='testYQ.php?expertise=" . $rowFirst['Name'] . "'>[".$rowFirst['Name'] . "]</a>";
		while($row3 = sqlsrv_fetch_array($expertiseQuery)){
			echo "<a href='testYQ.php?expertise=" . $row3['Name'] . "'>[".$row3['Name'] . "]</a>";
		}
		
		echo "<br>";
	}	
	if(!$resultFlag)
		echo "<br>No result under this category currently.";
}

if($_GET["firstName"] != ""){
	$firstName = $_GET["firstName"];
	$firstNameList = sqlsrv_query( $connection, 'SELECT ExpertID, LastName, FirstName, Title, AddressLine1, AddressLine2 FROM ExpertBiodata WHERE FirstName LIKE \'' . $firstName . '%\' ORDER BY FirstName');
	$resultFlag = false;
	while($row1 = sqlsrv_fetch_array($firstNameList)) {
		if (!$resultFlag)
			$resultFlag = true;
		$expertID = $row1['ExpertID'];
		echo '<br><br>';
		
		//$photoQuery = sqlsrv_query($connection, "SELECT PhotoURL FROM Photo WHERE ExpertID = " . $expertID);
		$filename = 'images/experts/thumbnail/' . $row1['FirstName'] . '-' . $row1['LastName'] . '.jpg';
		if(file_exists($filename)){
			echo '<a href="IndividualFullProfile.php?expert_id='.$expertID.'"><img src="' . $filename . '" alt="'. $row1['FirstName'] . ' ' . $row1['LastName'] .'" title="'. $row1['FirstName'] . ' ' . $row1['LastName'] .'" height="180" width="150"></a><br>';
		}
		else{
			echo '<img src="images/experts/thumbnail/placeholder.jpg" height="180" width="150"><br>';
		}
		
		echo '<b><a href="IndividualFullProfile.php?expert_id='.$expertID.'">' . $row1['FirstName'] . ' ' . $row1['LastName'] . '</a></b>';
		if($row1['Title'] != "")
			echo "<br>" . $row1['Title'];
		echo "<br>" . $row1['AddressLine1'];
		echo "<br>" . $row1['AddressLine2'];
		
		$contactQuery = sqlsrv_query($connection, "SELECT ContactType, ContactDesc FROM ExpertBioData b, Contact c WHERE b.ExpertID = c.ExpertID AND b.expertID = " . $expertID);
		while($row2 = sqlsrv_fetch_array($contactQuery)){
			echo "<br>" . $row2['ContactType'] . " : " . $row2['ContactDesc'];
		}
		
		$expertiseQuery = sqlsrv_query($connection, "SELECT Name FROM Expert_AreaOfExpertise ea, AreaOfExpertise a WHERE ea.AreaOfExpertiseID = a.AreaOfExpertiseID AND ea.ExpertID = " . $expertID);
		echo "<br>Expertise: ";
//		if($rowFirst = sqlsrv_fetch_array($expertiseQuery))
//			echo "<a href='testYQ.php?expertise=" . $rowFirst['Name'] . "'>[".$rowFirst['Name'] . "]</a>";
		while($row3 = sqlsrv_fetch_array($expertiseQuery)){
			echo "<a href='testYQ.php?expertise=" . $row3['Name'] . "'>[".$row3['Name'] . "]</a>";
		}
		
		echo "<br>";
	}
	if(!$resultFlag)
		echo "<br>No result under this category currently.";
}
sqlsrv_close($connection);
?>
</div>  
  </div>
    </div>
      </div>
<!--========================================Footer  and Footer Resources Area========================-->

<!--Footer Resources-->
<div id="footer-resources-wrapper" class="contain-to-grid">
<div  class="row">
   <?php include 'include_footer_resources.shtml'; ?> 
</div></div>
<!--END Footer Resources-->
<!--Footer-->

<div id="footer" class="contain-to-grid">
<div class="row">
  <?php include 'include_footer.shtml'; ?>
  </div>
  
</div>
<!--END Footer-->

<!--Foundation Scripts-->
<!-- <script src="js/vendor/jquery.js"></script> -->
<script src="js/foundation.min.js"></script>
 
<script>
      $(document).foundation();
    </script>
    <!--END Foundation Scripts-->
</body>
</html>