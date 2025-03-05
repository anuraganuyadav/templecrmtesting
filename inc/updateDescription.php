<?php
session_start();
//include db configuration file
include_once("config.php");

if(isset($_POST["description"]) && strlen($_POST["description"])>1) 
{	
	$contentToSave = filter_var($_POST["description"]); 
    $contentToid = filter_var($_POST["id"]); 
 	 
 if(mysqli_query($conn,"UPDATE itinerary SET description = '$contentToSave' , lastActivity = '$timestamp' , status_now = '0' WHERE id= $contentToid"))
{
      
        echo "<i id='message_descr' class='text-success'><img src='images/img/small-done.gif' width='25px'>success</i>";    
   
}
else{
   echo "Try Again";
} 
} 
?>   

<script> 
        setTimeout(function() {
            $('#message_descr').fadeOut('slow');
        }, 1400);
</script>