<?php
require_once '../inc/config.php';
if (isset($_POST["id"])) {
    $val =  $_POST["value"];
    $status_detail =  $_POST["column_name"];
    $id =  $_POST["id"];

    if ($status_detail == "last_response") {
        mysqli_query($conn, "INSERT INTO lead_status_history(status_detail, status_id, status_date ) VALUES('$val', '$id', '$timestamp')");

        // update last activity 
        mysqli_query($conn, "UPDATE lead SET last_activity = '$timestamp' , last_activity = '$timestamp'  WHERE id= " . $_POST["id"] . "");
    }

    if ($_POST["column_name"] == "sales_person") {
        // update last activity 
        mysqli_query($conn, "UPDATE potential SET date = '$timestamp' WHERE id= " . $_POST["id"] . "");
    }


    $value = mysqli_real_escape_string($conn, $val);
    $query = "UPDATE lead SET " . $_POST["column_name"] . "='" . $value . "' WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        echo 'Data Updated';
    }
}
