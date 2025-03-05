<?php
session_start();
//include db configuration file
include_once("config.php");

if(isset($_POST["last_response"]) && strlen($_POST["last_response"])>1) 
{	
	$contentToSave = filter_var($_POST["last_response"]); 
    $contentToid = filter_var($_POST["id"]); 
	
    
  mysqli_query($conn,"INSERT INTO lead_status_history(status_detail, status_id, status_date ) VALUES('$contentToSave', '$contentToid', '$timestamp')");   
    
    
 if(mysqli_query($conn,"UPDATE lead SET last_response = '$contentToSave' , last_activity = '$timestamp' , status_now = '0'  WHERE id= $contentToid")) 
  {
        echo "<i id='message_clnt' class='text-success'><img src='images/img/small-done.gif' width='25px'>success</i>";    
   
}
else{
   echo "Try Again";
} 
} 
?>   

<script> 
        setTimeout(function() {
            $('#message_clnt').fadeOut('slow');
        }, 1400);
</script>