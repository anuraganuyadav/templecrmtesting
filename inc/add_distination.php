<?php
//include db configuration file
include_once("config.php");

if(isset($_POST["InsertValue"]) && strlen($_POST["InsertValue"])>0) 
{	
	$contentToSave = filter_var($_POST["InsertValue"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
	
	if(mysqli_query($conn,"INSERT INTO destinations(destinations_list) VALUES('$contentToSave')"))
	
   {
?> <div class="input-group margin-top-5"> 
    <span class="res-list"><?php echo $contentToSave;?></span>
           <div class="input-group-prepend">
          <a href="?delete_id=<?php echo $row['id'];?>" title="click for delete" onclick="return confirm('sure to delete ?')" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a>
       </div>
      </div>  
<?php
}

}
?>