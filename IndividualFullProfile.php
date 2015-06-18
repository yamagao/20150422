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
<?php
$expertID = $_GET["expert_id"];
?>


<h1>UF/IFAS Faculty Experts</h1>
<?php
require_once 'DatabaseConnection.php';

//$photoQuery = sqlsrv_query($connection, "SELECT PhotoURL FROM Photo WHERE ExpertID = " . $expertID);
$firstNameList = sqlsrv_query( $connection, "SELECT LastName, FirstName FROM ExpertBiodata WHERE ExpertID = " . $expertID);
if($row1 = sqlsrv_fetch_array($firstNameList)){
	//$filename = 'images/experts/large/' . $row1['FirstName'] . '-' . $row1['LastName'] . '.jpg';
	$filename = 'images/experts/large/' . $expertID . '.jpg';
	if(file_exists($filename)){
		echo '<img src="' . $filename . '" alt="'. $row1['FirstName'] . ' ' . $row1['LastName'] .'" title="'. $row1['FirstName'] . ' ' . $row1['LastName'] .'" height="367" width="550"><br>';
	}
	else{
		echo '<img src="images/experts/large/placeholder.jpg"><br>';
	}
	?>
	<form action="upload_photo.php" method="post" enctype="multipart/form-data">
	<span>Update Large Photo (550 X 367): </span><input type="file" onchange="this.form.submit()" name="pictures[]" multiple>
	<input type="hidden" name="dir" value="large/">
	<input type="hidden" name="expertID" value="<?php echo $expertID;?>">
	</form>
	<?php
	//$filename = 'images/experts/thumbnail/' . $row1['FirstName'] . '-' . $row1['LastName'] . '.jpg';
	$filename = 'images/experts/thumbnail/' . $expertID . '.jpg';
	if(file_exists($filename)){
		echo '<img src="' . $filename . '" alt="'. $row1['FirstName'] . ' ' . $row1['LastName'] .'" title="'. $row1['FirstName'] . ' ' . $row1['LastName'] .'" width="150" height="180"><br>';
	}
	else{
		echo '<img src="images/experts/thumbnail/placeholder.jpg"><br>';
	}
}
?>

<form action="upload_photo.php" method="post" enctype="multipart/form-data">
<span>Update Thumbnail(150 X 180): </span><input type="file" onchange="this.form.submit()" name="pictures[]" multiple>
<input type="hidden" name="dir" value="thumbnail/">
<input type="hidden" name="expertID" value="<?php echo $expertID;?>">
</form>

<?php
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
<form action="EditIndividualFullProfile.php" method="POST">
<input type="hidden" name="ExpertID" value=<?php echo $expertID;?> />
<input type="submit" name="editExpert" value="Edit"/>
</div>
<?php require_once 'searchBy.php'; ?>
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