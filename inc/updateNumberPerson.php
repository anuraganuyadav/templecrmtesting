<?php
session_start();
//include db configuration file
include_once("config.php");

if(isset($_POST["id"]) && strlen($_POST["id"])>1) 
{	
	$contentToSave = filter_var($_POST["no_person"]); 
    $contentToid = filter_var($_POST["id"]); 
 	 
 if(mysqli_query($conn,"UPDATE itinerary SET no_person = '$contentToSave' , status_now='0' WHERE id= $contentToid"))
{
      
        echo "<i id='message_num' class='text-success'><img src='images/img/small-done.gif' width='25px'>success</i>";    
   
}
else{
   echo "Try Again";
} 
} 
?>   

<script> 
        setTimeout(function() {
            $('#message_num').fadeOut('slow');
        }, 1400);
</script>