<?php
session_start();
//include db configuration file
include_once("config.php");






if(isset($_POST["message"]) && strlen($_POST["message"])>0) 
{	
     $ran = rand(1000, 99999);
    
	$contentToSave = filter_var($_POST["message"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
	$SendPersonID = filter_var($_POST["SMSuserID"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
	$ReceivePersonID = filter_var($_POST["ReceivedID"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
	$SendSMS = filter_var($_POST["SendPerson"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
	$ReceivedSMS = filter_var($_POST["ReceivedPerson"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
  
}
 ?>	
<?php

mysqli_query($db, "UPDATE chat SET chatStatus = '0' WHERE SMSuserID ='$ReceivePersonID' and SendPerson ='$ReceivedSMS'  and  ReceivedPerson ='$SendSMS'");


	if(mysqli_query($conn,"INSERT INTO chat(message, SMSuserID, SendPerson, ReceivedPerson, chatStatus) VALUES('$contentToSave', '$SendPersonID', '$SendSMS', '$ReceivedSMS', '1')"))
	
    {

 ?>
 
 <span id="chatr<?php echo $ran ?>"> <img src="images/img/smile.gif"></span>
     
        
        
<?php
	}
?>

<script>
setTimeout(function(){
    $("#chatr<?php echo $ran ?>").fadeOut('slow');
},2000);
</script>
