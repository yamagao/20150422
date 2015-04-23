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
<script>
function filters()
{
   var strUser = document.getElementById("jumpMenu1").value;
/* if(a.selectedIndex!=0){
   var strUser = a.options[a.selectedIndex].value;
 } else{
	 a.selectedIndex=1;
	    var strUser = a.options[a.selectedIndex].value;
	 };

var strUser2 = document.getElementById('form1');*/

showUser1(strUser);
};
function showUser1(str1) {
  if (str1 =="") {
    document.getElementById("txtHint").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
	  dostuff();
    }
  }
  xmlhttp.open("GET","experts.php?q="+str1+"&r="+str2,true);
  xmlhttp.send();  
  
};
</script>
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
  <div class="row">
  <div class="dropdown medium-6 columns"><form name="form" id="form" method="post">
                      <select name="jumpMenu1" id = "jumpMenu1"  class="ui-dropdown-button" style="overflow:hidden;" onchange='filters()'>
                        <option value="ALL">SEARCH EXPERTS</option>
                        <option value="NAME">By Name</option>
                        <option value="EXPERTISE">By Expertise</option>
                      </select>
                    </form></div>
  </div>
  <hr />
<form id="search" action="testYQ.php" method="post" > 
 <select name="searchBy">
  <option value="expertise">Expertise</option>
  <option value="saab">Saab</option>
  <option value="mercedes">Mercedes</option>
  <option value="audi">Audi</option>
</select>
<input type="submit" value="Submit">
</form>
<hr/>
<div id="alphabet" >
        <form name="AlphabetMenuForm" id="form1" action="index.php" method="post">
        <?php	
		if(isset($_POST["searchBy"]))
		{
			$alphabetList = array_merge(array ('4-H'), range('A','Z'));
			
			 foreach ($alphabetList as $value) {
				echo '<a href="testYQ.php?expertise=' .$value. '">' .$value. '</a>' . ' ';
			 } 
			//echo "<p>".$_POST['jumpMenu1']."</p>";
		}
        ?>         
        <form> 
</div>
  <hr />
<div id="txtHint" >  
  <h4>Featured Faculty Experts</h4>
  <hr />
  
<?php
$expertise = $_GET["expertise"];
require_once 'DatabaseConnection.php';
$areaOfExpertise = sqlsrv_query( $connection, 'SELECT AreaOfExpertiseID, Name FROM AreaOfExpertise WHERE Name LIKE \'' . $expertise . '%\'');

while($row1 = sqlsrv_fetch_array($areaOfExpertise)) {
	$areaOfExpertiseID = $row1['AreaOfExpertiseID'];
	echo('<br>');
	echo('<p><b>'.$row1['Name'].'</b></p>');
	
	/*
	//Query with PhotoID
	
	$fetchExpertDataQuery = 'SELECT e.ExpertID AS ExpertID, e.Prefix AS ExpertPrefix, e.FirstName AS ExpertFirstName, e.MiddleName AS ExpertMiddleName, e.LastName AS ExpertLastName, e.Suffix AS ExpertSuffix, e.Title AS ExpertTitle, e.ProfileDesc AS ExpertProfileDesc, e.Address AS ExpertAddress, c.ContactType AS ExpertContactType, c.ContactDesc AS ExpertContactDesc, c.ContactTimings AS ExpertContactTimings, p.PhotoURL AS ExpertPhoto FROM ExpertBioData e, Expert_AreaOfExpertise ea, Contact c, Photo p WHERE ea.AreaOfExpertiseID='.$areaOfExpertiseID.' AND e.ExpertID=ea.ExpertID AND e.ExpertID=c.ExpertID AND e.ExpertID=p.ExpertID AND p.PhotoID=3';
	*/
	
$fetchExpertDataQuery = 'SELECT e.ExpertID AS ExpertID, e.Prefix AS ExpertPrefix, e.FirstName AS ExpertFirstName, e.MiddleName AS ExpertMiddleName, e.LastName AS ExpertLastName, e.Suffix AS ExpertSuffix, e.Degree AS ExpertDegree, e.Title AS ExpertTitle, e.ProfileDesc AS ExpertProfileDesc, e.AddressLine1 AS ExpertAddress1, e.AddressLine2 AS ExpertAddress2, e.AddressLine3 AS ExpertAddress3, c.ContactType AS ExpertContactType, c.ContactDesc AS ExpertContactDesc, c.ContactTimings AS ExpertContactTimings FROM ExpertBioData e, Expert_AreaOfExpertise ea, Contact c WHERE ea.AreaOfExpertiseID='.$areaOfExpertiseID.' AND e.ExpertID=ea.ExpertID AND e.ExpertID=c.ExpertID';
	
	$expertData = sqlsrv_query( $connection, $fetchExpertDataQuery);	
	$expertFullName = NULL;
	
	while($row2 = sqlsrv_fetch_array($expertData)) {
		
		$expertID = $row2['ExpertID'];
		$expertPrefix = $row2['ExpertPrefix'];		
		$expertFirstName = $row2['ExpertFirstName'];	
		$expertMiddleName = $row2['ExpertMiddleName'];
		$expertLastName = $row2['ExpertLastName'];
		$expertSuffix = $row2['ExpertSuffix'];		
		$expertTitle = $row2['ExpertTitle'];
		$expertAddress = $row2['ExpertAddress1'];
		//$expertPhoto = $row2['ExpertPhoto'];
		$expertContactType = $row2['ExpertContactType'];
		$expertContactDesc = $row2['ExpertContactDesc'];
		$expertContactTimings = $row2['ExpertContactTimings'];
		
		$newExpertFullName = $expertPrefix.' '.$expertFirstName.' '.$expertMiddleName.' '.$expertLastName.' '.$expertSuffix;
		
		if ($expertFullName != $newExpertFullName) {		
		  //echo ('<br><br> <a href="IndividualFullProfile.php?expert_id='.$expertID.'"> <img src="'.$expertPhoto.'"> </a> <br> <a href="IndividualFullProfile.php?expert_id='.$expertID.'">'.$newExpertFullName.'</a> <br>'.$expertTitle.'<br>'.$expertAddress);
  		  echo ('<br><br> <a href="IndividualFullProfile.php?expert_id='.$expertID.'"> <br> <a href="IndividualFullProfile.php?expert_id='.$expertID.'">'.$newExpertFullName.'</a> <br>'.$expertTitle.'<br>'.$expertAddress);
  		  $expertFullName = $newExpertFullName;
		}
				
		echo ('<br>'.$expertContactType.' : '.$expertContactDesc.' '.$expertContactTimings);
	}
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