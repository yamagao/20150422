<?php

//----upload images to temp folder "images/temp/"
$allowedExts = array("jpg","JPG");
$exceedFlag = 0;
foreach ($_FILES["pictures"]["type"] as $key => $type){
	$exceedFlag = 1;
	//get the extension
	$temp = explode(".", $_FILES["pictures"]["name"][$key]);
	$extension = end($temp);
	if($_POST["dir"] == "thumbnail/"){
		$fileSize = 50;
	}
	if($_POST["dir"] == "large/"){
		$fileSize = 350;
	}
	//check file type and extension
	if ((($type == "image/gif")
	|| ($type == "image/jpeg")
	|| ($type == "image/jpg")
	|| ($type == "image/pjpeg")
	|| ($type == "image/x-png")
	|| ($type == "image/png"))
	&& in_array($extension, $allowedExts) && $_FILES["pictures"]["size"][$key] / 1024 < $fileSize) {
		if ($_FILES["pictures"]["error"][$key] > 0) {
			echo "Return Code: " . $_FILES["pictures"]["error"][$key] . "<br><br>";
		} else {		
			if (file_exists("images/experts/" . $_POST["dir"] . $_POST["expertID"] . "." . $extension)) {
				echo "<strong style='font-size:1rem;'>".$_FILES["pictures"]["name"][$key] . 
				"</strong>: <br>Already exists, successfully updated". "<br>";
			} else {
				echo "<strong style='font-size:1rem;'>".$_FILES["pictures"]["name"][$key] . 
				"</strong>: <br>Successfully uploaded". "<br>";				
			}
			move_uploaded_file($_FILES["pictures"]["tmp_name"][$key],"images/experts/" . $_POST["dir"] . $_POST["expertID"] . "." . $extension);
			//echo "Stored in: " . "upload/" . $_FILES["pictures"]["name"][$key] . "<br><br>";
			echo "Type: " . $type . "<br>";
			echo "Size: " . round($_FILES["pictures"]["size"][$key] / 1024 / 1024 , 2) . " MB<br><br>";
			//echo "Temp file: " . $_FILES["pictures"]["tmp_name"][$key] . "<br>";
		}
	} else {
		echo 
		 
		
		"<h1>Failed to upload <span><br>". 
		$_FILES["pictures"]["name"][$key] .":&nbsp;Invalid file or it exceeds the maximum upload file size</span></h1> <br><br>";
	}
}

if($exceedFlag == 0){
	echo "<h1> Failed to upload <br><span>The uploaded files exceed the maximum upload file size</span> </h1> <br><br>";
}

echo '<a href="IndividualFullProfile.php?expert_id=' . $_POST["expertID"] . '">Go back</a>';
?>