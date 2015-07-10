<!DOCTYPE HTML>
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.6, maximum-scale=2.0, user-scalable=yes" />
    <title>News and Media Relations - IFAS Communications - University of Florida - Institute of Food and Agricultural Sciences</title>
    <!--#include file="include_meta.shtml" -->

    <link href="css/secondary.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!--Scripts-->
    <script type="text/javascript">document.documentElement.className += " js";</script>
    <!--#include file="include_scripts.shtml" -->
    <script src="js/jquery-1.9.1.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.tabs.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/vendor/modernizr.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript">

    $(document).ready(function(){
        $(".tabs").accessibleTabs({
            tabhead:'h2',
            cssClassAvailable:true,
            fx:"fadeIn"
        });
    });

    </script>

    <!--End Scripts-->
    <!--Analytics-->
    <!--#include file="include_analytics.shtml" -->
    <!--End Analytics-->
    </head>
    <!--=======================================Web page Layout=========================================-->

    <body>

<!--=====================================Main Content Area==========================================-->
<div class="container_12"> 
      <!--===================================Navigation, Logo and IFAS searchbox=============================-->
      
      <div id="logo-search" class="grid_12"><a id="ifas-logo"  title="Institute of Food and Agricultural Sciences, University of Florida" href="http://ifas.ufl.edu/">Institute of Food and Agricultural Sciences</a> 
    <!-- IFAS Communications text area-->
    <div class="grid_4 omega push_8" id="ICS">
           <?php include 'include_text.shtml'; ?> <!--#include file="include_text.shtml" --> 
        </div>
    
    <!--End IFAS Communications text area--> 
    
    <!--Top Navigation Area-->
    <div class="grid_12 alpha"> 
          <?php include 'include_top_nav_drop_down.shtml'; ?><!--#include file="include_top_nav_drop_down.shtml" --> 
        </div>
    <!--End Top Navigation Area--> 
    
  </div>
      <!--End Navigation, Logo and Search Box-->
      
      <div class="clear"></div>
      <!--=============================Main Content Area===========================================-->
      <div id="content" class="grid_12">
    <h1>UF/IFAS Faculty Experts</h1>
<div class="clear"></div>
    <!--Main Feature / Latest Case Study-->
    <div id="main-feature">
<?php
$expertID = $_GET["expert_id"];
require_once 'DatabaseConnection.php';
$write = true;
//$photoQuery = sqlsrv_query($connection, "SELECT PhotoURL FROM Photo WHERE ExpertID = " . $expertID);
$firstNameList = sqlsrv_query( $connection, "SELECT LastName, FirstName, Degree FROM ExpertBiodata WHERE ExpertID = " . $expertID);
if($row1 = sqlsrv_fetch_array($firstNameList)){
	//$filename = 'images/experts/large/' . $row1['FirstName'] . '-' . $row1['LastName'] . '.jpg';
	$filename = 'images/experts/large/' . $expertID . '.jpg';	
	if(file_exists($filename)){
		echo '<img src="' . $filename . '" alt="'. $row1['FirstName'] . ' ' . $row1['LastName'] .'" title="'. $row1['FirstName'] . ' ' . $row1['LastName'] .'" width="600px" height="367px">';
	}
	else{
		echo '<img src="images/experts/large/placeholder.jpg">';
	}
	if($write){
?>
<form action="upload_photo.php" method="post" enctype="multipart/form-data">
<input type="file" onchange="this.form.submit()" name="pictures[]" multiple><span>RES: 600X367, MAX: 350KB</span>
<input type="hidden" name="dir" value="large/">
<input type="hidden" name="expertID" value="<?php echo $expertID;?>">
</form>
<?php
	}
	echo '<h2>' . $row1['FirstName'] . ' ' . $row1['LastName'] . ', ' . $row1['Degree'] . '</h2><div class="faculty"><div class= "facultysmallpics">';
	if($write){
?>
<form action="upload_photo.php" method="post" enctype="multipart/form-data">
<input type="file" onchange="this.form.submit()" name="pictures[]" multiple><span>RES: 150X180, MAX: 50KB</span>
<input type="hidden" name="dir" value="thumbnail/">
<input type="hidden" name="expertID" value="<?php echo $expertID;?>">
</form>
<?php
	}
	//$filename = 'images/experts/thumbnail/' . $row1['FirstName'] . '-' . $row1['LastName'] . '.jpg';
	$filename = 'images/experts/thumbnail/' . $expertID . '.jpg';
	if(file_exists($filename)){
		echo '<img src="' . $filename . '" alt="'. $row1['FirstName'] . ' ' . $row1['LastName'] .'" title="'. $row1['FirstName'] . ' ' . $row1['LastName'] .'" class="alignnone size-thumbnail wp-image-7821" width="150" height="180"></div>';
	}
	else{
		echo '<img src="images/experts/thumbnail/placeholder.jpg"></div>';
	}
}
?>

<?php
//Query to fetch Expert Bio data
$fetchExpertDataQuery = 'SELECT distinct Prefix AS ExpertPrefix, FirstName AS ExpertFirstName, MiddleName AS ExpertMiddleName, LastName AS ExpertLastName, Suffix AS ExpertSuffix, Degree AS ExpertDegree, Title AS ExpertTitle, ProfileDesc AS ExpertProfileDesc, AddressLine1 AS ExpertAddress1, AddressLine2 AS ExpertAddress2, AddressLine3 AS ExpertAddress3 FROM ExpertBioData WHERE ExpertID='.$expertID;

//Query to fetch contact
$fetchExpertContactQuery = 'SELECT distinct ContactType AS ExpertContactType, ContactDesc AS ExpertContactDesc, ContactTimings AS ExpertContactTimings FROM Contact WHERE ExpertID='.$expertID;

//Query to fetch all area of expertise
$fetchAreaOfExpertiseQuery = 'SELECT distinct aoe.Name AS AreaOfExpertise FROM AreaOfExpertise aoe, Expert_AreaOfExpertise ea WHERE ea.ExpertID='.$expertID.' AND ea.AreaOfExpertiseID=aoe.AreaOfExpertiseID';

//Query to fetch social media
$fetchExpertSocialMediaQuery = 'SELECT distinct SocialMediaType, SocialMediaDesc FROM SocialMedia WHERE ExpertID='.$expertID;

$expertData = sqlsrv_query( $connection, $fetchExpertDataQuery);
$expertContact = sqlsrv_query( $connection, $fetchExpertContactQuery);
$areaOfExpertise = sqlsrv_query( $connection, $fetchAreaOfExpertiseQuery);
$expertSocialMedia = sqlsrv_query( $connection, $fetchExpertSocialMediaQuery);

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
	  echo '<h3>' . $expertTitle . '</h3><i class="fa fa-twitter-square fa-6"></i>';
	  echo $expertProfileDesc;
}
echo '<h4>Areas of Expertise</h4><ul>';
while($row4 = sqlsrv_fetch_array($areaOfExpertise)) {		
	$expertAreaOfExpertise = $row4['AreaOfExpertise'];
	echo "<li><a href='testYQ.php?expertise=" . $expertAreaOfExpertise . "'>" . $expertAreaOfExpertise . "</a></li>";
}
echo '</ul>';
echo '<h4>Contact</h4><ul>';
while($row2 = sqlsrv_fetch_array($expertContact)) {
	$expertContactType = $row2['ExpertContactType'];
	$expertContactDesc = $row2['ExpertContactDesc'];
	$expertContactTimings = $row2['ExpertContactTimings'];
	if($expertContactType == "Email")
		echo '<li>' . $expertContactType . ': <a href="mailto:' . $expertContactDesc . '">' . $expertContactDesc . '</a> ' . $expertContactTimings . '</li>';
	else
		echo '<li>' . $expertContactType . ': ' . $expertContactDesc . ' ' . $expertContactTimings . '</li>';
}
echo '<li>Address: ' . $expertAddressLine1;
if($expertAddressLine2 != null) echo '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $expertAddressLine2;
if($expertAddressLine3 != null) echo '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $expertAddressLine3;
echo '</li>';
echo ('</ul>');
echo '<h4>Follow</h4><ul>';
while($row5 = sqlsrv_fetch_array($expertSocialMedia)) {		
	$SocialMedia = $row5['SocialMediaDesc'];
	echo '<li><a href="'. $SocialMedia . '"><i class="fa fa-twitter-square fa-6"></i></a></li>';	
}
echo "</ul>";
sqlsrv_close($connection);
?>
<form action="EditIndividualFullProfile.php" method="POST">
<input type="hidden" name="ExpertID" value=<?php echo $expertID;?> />
<input type="submit" name="editExpert" value="Edit"/>
</div>
<!--new faculty div-->

<!--END individual faculty divs-->
          </div>
    <!--END Main Feature--> 
    <!--Services-->
    <div class="facultyside">
	<?php require_once 'searchBy.php'; ?>
    </div>
    <div class="facultyside">
          <h3>News  and Media Relations</h3>
          <p>UF/IFAS faculty members are available to provide expert opinion, comment, and analysis on a broad range of subjects.</p>
          <p><strong>For news and media inquiries contact or trouble locating an expert contact:</strong></p>
          <p><a href="mailto:mickiea@ufl.edu">Mickie Anderson</a><br/>
          <a href="news.shtml">News and Media Relations</a><br/> 
          (352) 273-3566</p>
</div>
    <div class="facultyside">
          <a href="http://ifas.ufl.edu/social-media.shtml"><img src="images/jointheconversation.jpg" width="272" height="129"></a>
</div>
	<div class="facultyside">
      <h3>Follow UF/IFAS News</h3>
          <p>
          <a href="https://www.facebook.com/UFIFASNews"><img src="http://ics.ifas.ufl.edu/images/sm/facebook.png" width="60" height="60" alt="Facebook" style= padding-right:20px;></a><a href="https://twitter.com/uffoodandagnews"><img src="http://ics.ifas.ufl.edu/images/sm/twitter.png" width="60" height="60" alt="Twitter"></a></p>
        </div>
    <!--End Services-->
    <div class="clear"></div>

  </div>
      <!--End Content Area-->
     <div class="clear"></div>
      <!--Footer-->
 <div id="footer"> 
    <?php include 'include_footer.shtml'; ?><!--#include file="include_footer.shtml" -->
   Last Modified: <!-- #BeginDate format:Am1 -->February 2, 2015<!-- #EndDate --> 
  </div>
<!--End Footer--> 

    </div>
<div id="footer-resources-background"> </div>
<div class="clear"></div>

<div id="footer-wrapper">
     
    </div>
 
<!--End Main Content Area--> 

<!--PrettyPhoto Script--> 
<!--#include file="include_prettyphoto.shtml" --> 
<!--End PrettyPhoto Script--> 
<!--End Web Page layout-->
</body>
</html>
