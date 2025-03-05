
<?php
require_once 'config.php';
if(isset($_POST["id"]))
{
 $query = "DELETE FROM reminder WHERE id = '".$_POST["id"]."'";
 if(mysqli_query($conn, $query))
 {
  echo 'Data Deleted';
 }
}
?>