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