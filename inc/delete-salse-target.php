
<?php
require_once 'config.php';
if(isset($_POST["id"]))
{
 $query = "DELETE FROM manage_sales_target WHERE id = '".$_POST["id"]."'";
 if(mysqli_query($conn, $query))
 {
//   echo 'Data Deleted';
 }
}
?>