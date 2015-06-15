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
<p><input type="text" id="expertise2add"> <a href="#" id="addAreaOfExpertise">Add to Add List</a></p>
<div id="AAOE">		
</div>
<script type="text/javascript" language="javascript">
	$(function() {
		var scntDivAdd = $('#AAOE');
		var i = $('#AAOE p').size() + 1;
		
		$('#addAreaOfExpertise').live('click', function() {
				$('<p><label for="pscnt" style="display: block; width:400px;"><input type="hidden" id="pscnt" size="20" name="addExpertise' + i + '" value="' + $('#expertise2add').val() + '" readonly/>' + $('#expertise2add').val() + '</label> <a href="#" id="remA">Remove</a></p>').appendTo(scntDivAdd);
				i++;
				return false;
		});
		
		$('#remA').live('click', function() { 
				if( i > 1 ) {
						$(this).parents('p').remove();
						i--;
				}
				return false;
		});
	});	
</script>

<h3>Delete List</h3>
<p><select id="expertise2delete">
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


<div id="DAOE">		
</div>

<script type="text/javascript" language="javascript">
	$(function() {
		var scntDivDelete = $('#DAOE');
		var j = $('#DAOE p').size() + 1;
		
		$('#deleteAreaOfExpertise').live('click', function() {
				$('<p><label for="pscnt" style="display: block; width:400px;"><input type="hidden" id="pscnt" size="20" name="deleteExpertise' + j + '" value="' + $('#expertise2delete').val() + '" readonly/>' + $('#expertise2delete option:selected').text() + '</label> <a href="#" id="remD">Remove</a></p>').appendTo(scntDivDelete);
				j++;
				return false;
		});
		
		$('#remD').live('click', function() { 
				if( j > 1 ) {
						$(this).parents('p').remove();
						j--;
				}
				return false;
		});
	});	
</script>

<h2>Experts</h2>

<h3>Add List</h3>
<p><input type="text" id="experts2add"> <a href="#" id="addExperts">Add to Add List</a></p>
<div id="AE">		
</div>
<script type="text/javascript" language="javascript">
	$(function() {
		var scntDivAdd = $('#AE');
		var i = $('#AE p').size() + 1;
		
		$('#addExperts').live('click', function() {
				$('<p><label for="pscnt" style="display: block; width:400px;"><input type="hidden" id="pscnt" size="20" name="addExpert' + i + '" value="' + $('#experts2add').val() + '" readonly/>' + $('#experts2add').val() + '</label> <a href="#" id="remAdd">Remove</a></p>').appendTo(scntDivAdd);
				i++;
				return false;
		});
		
		$('#remAdd').live('click', function() { 
				if( i > 1 ) {
						$(this).parents('p').remove();
						i--;
				}
				return false;
		});
	});	
</script>

<h3>Delete List</h3>
<p><select id="experts2delete">
	<?php
		$fetchExpertsQuery = 'SELECT ExpertID, FirstName, LastName FROM ExpertBiodata';
		$Experts = sqlsrv_query( $connection, $fetchExpertsQuery);
		while($row6 = sqlsrv_fetch_array($Experts)) {		
			$ExpertID = $row6['ExpertID'];
			$ExpertName = $row6['FirstName'] . $row6['LastName'];
			echo '<option value="' . $ExpertID . '">' . $ExpertName . '</option>';
		}
	?>
</select> <a href="#" id="deleteExperts">Add to Delete List</a></p>


<div id="DE">		
</div>

<script type="text/javascript" language="javascript">
	$(function() {
		var scntDivDelete = $('#DE');
		var j = $('#DE p').size() + 1;
		
		$('#deleteExperts').live('click', function() {
				$('<p><label for="pscnt" style="display: block; width:400px;"><input type="hidden" id="pscnt" size="20" name="deleteExpert' + j + '" value="' + $('#experts2delete').val() + '" readonly/>' + $('#experts2delete option:selected').text() + '</label> <a href="#" id="remDelete">Remove</a></p>').appendTo(scntDivDelete);
				j++;
				return false;
		});
		
		$('#remDelete').live('click', function() { 
				if( j > 1 ) {
						$(this).parents('p').remove();
						j--;
				}
				return false;
		});
	});	
</script>

<input type="submit" id="updateExpert" value="Update"/> 


<?php
sqlsrv_close($connection);
?>
</form>
<p><a href="testYQ.php">Back to Search</a></p>
</body>

</html>