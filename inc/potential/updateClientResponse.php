<?php
session_start();
//include db configuration file
include_once("../config.php");

if(isset($_POST["status"]) && strlen($_POST["status"])>1) 
{	
	$contentToSave = filter_var($_POST["status"]); 
    $contentToid = filter_var($_POST["id"]);
            
 mysqli_query($conn,"INSERT INTO status_history(status_detail, status_id, status_date ) VALUES('$contentToSave', '$contentToid', '$timestamp')");
             
             
             
 if(mysqli_query($conn,"UPDATE potential SET status = '$contentToSave' , last_activity = '$timestamp' WHERE id= $contentToid")) 
  {
          echo "<i id='message_client' class='text-success'><img src='images/img/small-done.gif' width='25px'>success</i>";    
   
}
else{
   echo "Try Again";
} 
} 
?>   

<script> 
        setTimeout(function() {
            $('#message_client').fadeOut('slow');
        }, 1400);
</script>