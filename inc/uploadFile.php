<?php
session_start();
$userID = $_SESSION['userID'];


//upload.php
require_once 'config.php';

if(!empty($_FILES))
{
	if(is_uploaded_file($_FILES['uploadFile']['tmp_name']))
	{
		sleep(1);
		$source_path = $_FILES['uploadFile']['tmp_name'];
		$fileName =rand(1000,1000000). $_FILES['uploadFile']['name'];
        
		$target_path = '../images/Attachment/' .$fileName ;
		$show = 'images/Attachment/' . $fileName;
        
        $result = mysqli_query($db,"UPDATE users SET  fileTemp ='$fileName' WHERE userID = '$userID'");	
        
		if(move_uploaded_file($source_path, $target_path))
		{
			echo '<input type="hidden" name="file" class="control-form" value="'.$show.'"><img src="images/img/pdf.png"> <span style="color:green;">Uploaded File </span>';
		}
	}
} 
?> 