<?php
session_start();
//include db configuration file
include_once("../config.php");

if(isset($_POST["destination"]) && strlen($_POST["destination"])>1) 
{	
	$contentToSave = filter_var($_POST["destination"]); 
    $contentToid = filter_var($_POST["id"]); 
 	 
 if(mysqli_query($conn,"UPDATE potential SET destination = '$contentToSave' , last_activity = '$timestamp'  WHERE id= $contentToid"))
{
      
         echo "<i id='message_destination' class='text-success'><img src='images/img/small-done.gif' width='25px'>success</i>";    
   
}
else{
   echo "Try Again";
} 
} 
?>   

<script> 
        setTimeout(function() {
            $('#message_destination').fadeOut('slow');
        }, 1400);
</script>