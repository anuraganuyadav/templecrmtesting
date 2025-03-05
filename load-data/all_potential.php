<?php
//include db configuration file
include_once("../inc/config.php");

if (isset($_POST["InsertValue"]) && strlen($_POST["InsertValue"]) > 0) {
   $contentToSave = filter_var($_POST["InsertValue"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

   $rr = mysqli_query($conn, "INSERT INTO potential_status (status) VALUES('$contentToSave')");

}
   $sql = "SELECT * FROM potential_status ORDER BY position_order ";
   $status = $conn->query($sql);
   while ($st = $status->fetch_assoc()) {
?>


      <tr id="<?php echo $st['id'] ?>"> 
         <td><?php echo $st['status'] ?></td>
         <td><a href="?delete_id=<?php echo $st['id'];?>" title="click for delete" onclick="return confirm('sure to delete ?')" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a></td>
      </tr> 
<?php
   }
?>