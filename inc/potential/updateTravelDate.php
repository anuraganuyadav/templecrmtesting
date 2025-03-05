<?php
session_start();
//include db configuration file
include_once("../config.php");

if(isset($_POST["travel_date"]) && strlen($_POST["travel_date"])>1) 
{	
	$contentToSave = filter_var($_POST["travel_date"]); 
    $contentToid = filter_var($_POST["id"]); 
 	 
 if(mysqli_query($conn,"UPDATE potential SET travel_date = '$contentToSave' , last_activity = '$timestamp'  WHERE id= $contentToid"))
{
      
         echo "<i id='message_traveldate' class='text-success'><img src='images/img/small-done.gif' width='25px'>success</i>";    
   
}
else{
   echo "Try Again";
} 
} 
?>   

<script> 
        setTimeout(function() {
            $('#message_traveldate').fadeOut('slow');
        }, 1400);
</script>