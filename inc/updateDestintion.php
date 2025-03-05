<?php
session_start();
//include db configuration file
include_once("config.php");

if(isset($_POST["destination"]) && strlen($_POST["destination"])>1) 
{	
	$contentToSave = filter_var($_POST["destination"]); 
    $contentToid = filter_var($_POST["id"]); 
 	 
 if(mysqli_query($conn,"UPDATE lead SET destination = '$contentToSave' , last_activity = '$timestamp' , status_now = '0' WHERE id= $contentToid"))
{
?>
      
 <i id='<?php echo $contentToid; ?>message_Dest' class='text-success'><img src='images/img/small-done.gif' width='25px'> success</i>   
   
<?php   
}
else{
   echo "Try Again";
} 
} 
?>   

<script> 
        setTimeout(function() {
            $('#<?php echo $contentToid; ?>message_Dest').fadeOut('slow');
        }, 1400);
</script>