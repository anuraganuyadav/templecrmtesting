 
<?php
session_start();
//include db configuration file
include_once("config.php");

if(isset($_POST["note"]) && strlen($_POST["note"])>1) 
{	
	$contentToSave = filter_var($_POST["note"]); 
    $contentToid = filter_var($_POST["id"]); 
    
    
  mysqli_query($conn,"UPDATE itinerary SET lastactivity = '$timestamp' WHERE id= $contentToid"); 

 if(mysqli_query($conn,"INSERT INTO itinerarynotes (note, note_id, create_date) VALUES('$contentToSave', '$contentToid', '$timestamp')"))
 {
?> 
<tr>
    <td><?php echo $contentToSave;?></td>
     <td> <?php echo $timestamp; ?> </td>
        <td>
           
       </td> 
 </tr>   

<?php   
}
else{
   echo "Try Again";
}
}
?>


 
 
   