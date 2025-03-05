<?php
session_start();
//include db configuration file
include_once("config.php");

if(isset($_POST["LeadSource"]) && strlen($_POST["LeadSource"])>1) 
{	
	$contentToSave = filter_var($_POST["LeadSource"]); 
    $contentToid = filter_var($_POST["id"]); 
 	 
 if(mysqli_query($conn,"UPDATE lead SET LeadSource = '$contentToSave' WHERE id= $contentToid"))
{
      
       echo "<i id='message_source' class='text-success'><img src='images/img/small-done.gif' width='25px'>success</i>";    
   
}
else{
   echo "Try Again";
} 
} 
?>   

<script> 
        setTimeout(function() {
            $('#message_source').fadeOut('slow');
        }, 1400);
</script>