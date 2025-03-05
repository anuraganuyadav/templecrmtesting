<?php
session_start();
//include db configuration file
include_once("config.php");

if(isset($_POST["name"]) && strlen($_POST["name"])>1) 
{	
	$contentToSave = filter_var($_POST["name"]); 
    $contentToid = filter_var($_POST["id"]); 
 	 
 if(mysqli_query($conn,"UPDATE itinerary SET name = '$contentToSave', lastActivity = '$timestamp' , status_now = '0' WHERE id= $contentToid"))
 {
?>
      
 <i id='<?php echo $contentToid; ?>message_Name' class='text-success'><img src='images/img/small-done.gif' width='25px'> success</i>   
   
<?php   
}
else{
   echo "Try Again";
} 
} 
?>   

<script> 
        setTimeout(function() {
            $('#<?php echo $contentToid; ?>message_Name').fadeOut('slow');
        }, 1400);
</script>