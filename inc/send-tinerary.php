<?php
session_start();
//include db configuration file
include_once("config.php");

if(isset($_POST["sales_person"]) && strlen($_POST["sales_person"])>1) 
{	
	$contentToSave = filter_var($_POST["sales_person"]); 
    $contentToid = filter_var($_POST["id"]); 
 	 
 if(mysqli_query($conn,"UPDATE lead SET sales_person = '$contentToSave' , status_now = '1'  WHERE id= $contentToid"))
 {
?>
      
 <i id='<?php echo $contentToid; ?>message_itnr' class='text-success'><img src='images/img/small-done.gif' width='25px'> success</i>   
   
<?php   
}
else{
   echo "Try Again";
} 
} 
?>   

<script> 
        setTimeout(function() {
            $('#<?php echo $contentToid; ?>message_itnr').fadeOut('slow');
        }, 1400);
</script>