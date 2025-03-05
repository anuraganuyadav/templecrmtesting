<?php
require_once 'config.php'; 
if(isset($_POST["id"]))
{
 $value = mysqli_real_escape_string($conn, $_POST["value"]);
 $query = "UPDATE lead SET ".$_POST["column_name"]."='".$value."' , date = '$timestamp'   WHERE id = '".$_POST["id"]."'";
 if(mysqli_query($conn, $query))
 {
  echo 'Data Updated';
 }
}
?>