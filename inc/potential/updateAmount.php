<?php
session_start();
//include db configuration file
include_once("../config.php");

if(isset($_POST["amount"]) && strlen($_POST["amount"])>1) 
{	
	$contentToSave = filter_var($_POST["amount"]); 
    $contentToid = filter_var($_POST["id"]); 
 	 
 if(mysqli_query($conn,"UPDATE potential SET amount = '$contentToSave' , last_activity = '$timestamp'  WHERE id= $contentToid"))
{
      
          echo "<i id='message_amount' class='text-success'><img src='images/img/small-done.gif' width='25px'>success</i>";    
   
}
else{
   echo "Try Again";
} 
} 
?>   

<script> 
        setTimeout(function() {
            $('#message_amount').fadeOut('slow');
        }, 1400);
</script>