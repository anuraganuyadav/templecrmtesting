<?php
session_start();
//include db configuration file
include_once("../config.php");

if(isset($_POST["mo_number"]) && strlen($_POST["mo_number"])>1) 
{	
	$contentToSave = filter_var($_POST["mo_number"]); 
    $contentToid = filter_var($_POST["id"]); 
 	 
 if(mysqli_query($conn,"UPDATE potential SET mo_number = '$contentToSave' , last_activity = '$timestamp'  WHERE id= $contentToid"))
{
      
     echo "<i id='message_phone' class='text-success'><img src='images/img/small-done.gif' width='25px'>success</i>";    
   
}
else{
   echo "Try Again";
} 
} 
?>   

<script> 
        setTimeout(function() {
            $('#message_phone').fadeOut('slow');
        }, 1400);
</script>