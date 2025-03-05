<?php
session_start();
//include db configuration file
include_once("../config.php");

if(isset($_POST["no_person"]) && strlen($_POST["no_person"])>1) 
{	
	$contentToSave = filter_var($_POST["no_person"]); 
    $contentToid = filter_var($_POST["id"]); 
 	 
 if(mysqli_query($conn,"UPDATE potential SET no_person = '$contentToSave' , last_activity = '$timestamp'  WHERE id= $contentToid"))
{
      
    echo "<i id='message_person' class='text-success'><img src='images/img/small-done.gif' width='25px'>success</i>";    
   
}
else{
   echo "Try Again";
} 
} 
?>   

<script> 
        setTimeout(function() {
            $('#message_person').fadeOut('slow');
        }, 1400);
</script>