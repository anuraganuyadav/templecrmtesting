<?php
session_start();
//include db configuration file
include_once("config.php");

if(isset($_POST["name"]) && strlen($_POST["name"])>1) 
{	
	$contentToSave = filter_var($_POST["name"]); 
    $contentToid = filter_var($_POST["id"]); 
 	 
 if(mysqli_query($conn,"UPDATE lead SET name = '$contentToSave' WHERE id= $contentToid"))
{
      
       echo "<i id='message_lead' class='text-success'><img src='images/img/small-done.gif' width='25px'>success</i>";    
   
}
else{
   echo "Try Again";
} 
} 
?>   

<script> 
        setTimeout(function() {
            $('#message_lead').fadeOut('slow');
        }, 1400);
</script>