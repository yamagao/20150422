<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Area of Expertise</title>        
<script language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
</head>

<body>
<form action="UpdateAreaOfExpertise.php" method="POST">
<?php
//$expertID = $_POST["ExpertID"];

require_once 'DatabaseConnection.php';

?>
<h2>Area of expertise</h2>

<h3>Add List</h3>
<p><input type="text"> <a href="#" id="addAreaOfExpertise">Add to Add List</a></p>

<h3>Delete List</h3>
<p><select id="expertise">
	<?php
		$fetchExpertiseQuery = 'SELECT AreaOfExpertiseID, Name FROM AreaOfExpertise';
		$Expertise = sqlsrv_query( $connection, $fetchExpertiseQuery);
		while($row5 = sqlsrv_fetch_array($Expertise)) {		
			$ExpertiseID = $row5['AreaOfExpertiseID'];
			$ExpertiseName = $row5['Name'];
			echo '<option value="' . $ExpertiseID . '">' . $ExpertiseName . '</option>';
		}
	?>
</select> <a href="#" id="deleteAreaOfExpertise">Add to Delete List</a></p>


<div id="AOE">		
		<?php
			$expertiseLoopCount = 0;
			$fetchAreaOfExpertiseQuery = 'SELECT distinct aoe.Name AS AreaOfExpertise, aoe.AreaOfExpertiseID  FROM AreaOfExpertise aoe, Expert_AreaOfExpertise ea WHERE ea.ExpertID='.$expertID.' AND ea.AreaOfExpertiseID=aoe.AreaOfExpertiseID';
			$areaOfExpertise = sqlsrv_query( $connection, $fetchAreaOfExpertiseQuery);
			while($row4 = sqlsrv_fetch_array($areaOfExpertise)) {
				$expertiseLoopCount++;				
				$expertAreaOfExpertise = $row4['AreaOfExpertise'];
				$expertAreaOfExpertiseID = $row4['AreaOfExpertiseID'];
				echo '<p><label for="pscnt" style="display: block; width:400px;"><input type="hidden" id="pscnt" size="20" name="Expertise' . $expertiseLoopCount . '" value="' . $expertAreaOfExpertiseID . '"/>' . $expertAreaOfExpertise . '</label> <a href="#" id="rem">Remove</a></p>';
			}
		?>
</div>

<script type="text/javascript" language="javascript">
	$(function() {
		var scntDiv = $('#AOE');
		var j = $('#AOE p').size() + 1;
		
		$('#deleteAreaOfExpertise').live('click', function() {
				$('<p><label for="pscnt" style="display: block; width:400px;"><input type="hidden" id="pscnt" size="20" name="Expertise' + j + '" value="' + $('#expertise').val() + '" readonly/>' + $('#expertise option:selected').text() + '</label> <a href="#" id="rem">Remove</a></p>').appendTo(scntDiv);
				j++;
				return false;
		});
		
		$('#rem').live('click', function() { 
				if( j > 1 ) {
						$(this).parents('p').remove();
						j--;
				}
				return false;
		});
	});	
</script>
<input type="hidden" name="ExpertiseLoopCount" value="<?php echo $expertiseLoopCount; ?>"/>

<input type="submit" id="updateExpert" value="Update"/> 


<?php
sqlsrv_close($connection);
?>
</form>
</body>

</html>