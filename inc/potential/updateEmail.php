<?php
session_start();
//include db configuration file
include_once("../config.php");

if(isset($_POST["email"]) && strlen($_POST["email"])>1) 
{	
	$contentToSave = filter_var($_POST["email"]); 
    $contentToid = filter_var($_POST["id"]); 
 	 
 if(mysqli_query($conn,"UPDATE potential SET email = '$contentToSave' , last_activity = '$timestamp'  WHERE id= $contentToid"))
{
      
       echo "<i id='message_email' class='text-success'><img src='images/img/small-done.gif' width='40px'>success</i>";    
   
}
else{
   echo "Try Again";
} 
} 
?>   

<script> 
        setTimeout(function() {
            $('#message_email').fadeOut('slow');
        }, 1400);
</script>