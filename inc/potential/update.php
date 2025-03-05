<?php
require_once '../../inc/config.php';
if (isset($_POST["id"])) {

     if ($_POST["column_name"] == "status") {
          mysqli_query($conn, "INSERT INTO potential_status_history(status_detail, status_id, status_date ) VALUES('" . $_POST["value"] . "', '" . $_POST["id"] . "', '$timestamp')");
          // update last activity 
          mysqli_query($conn, "UPDATE potential SET last_activity = '$timestamp' , last_activity = '$timestamp'  WHERE id= ".$_POST["id"]."");
     }

     if ($_POST["column_name"] == "sales_person") {
          // update last activity 
          mysqli_query($conn, "UPDATE potential SET date = '$timestamp' WHERE id= ".$_POST["id"]."");
     }



     $value = mysqli_real_escape_string($conn, $_POST["value"]);
     $query = "UPDATE potential SET " . $_POST["column_name"] . "='" . $value . "' WHERE id = '" . $_POST["id"] . "'";
     if (mysqli_query($conn, $query)) {
          echo 'Updated Done';
     }
}
