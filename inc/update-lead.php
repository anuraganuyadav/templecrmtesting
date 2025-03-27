<?php
require_once '../inc/config.php';
session_start();
if (isset($_POST["id"])) {
    $val = $_POST["value"];
    $status_detail = $_POST["column_name"];
    $id = $_POST["id"];

    // Check if the logged-in user is an Admin (user_role_id 1 or 2)
    if ($_SESSION['user_role_id'] == 1 || $_SESSION['user_role_id'] == 2) {
        // If it's an Admin, append "by admin" to the status_detail and set the color to red
        $val .= "( Admin)"; // Append 'by admin' to the status detail
        // $color = "red"; // Set color to red for Admin updates
    }

    if ($status_detail == "last_response") {
        // Insert into lead_status_history to track the change
        mysqli_query($conn, "INSERT INTO lead_status_history(status_detail, status_id, status_date) 
                            VALUES('$val', '$id', '$timestamp')");

        // Update last activity 
        mysqli_query($conn, "UPDATE lead SET last_activity = '$timestamp' WHERE id = " . $_POST["id"]);
    }

    if ($_POST["column_name"] == "sales_person") {
        // Update last activity for potential table
        mysqli_query($conn, "UPDATE potential SET date = '$timestamp' WHERE id = " . $_POST["id"]);
    }

    // Escape the value to prevent SQL injection
    $value = mysqli_real_escape_string($conn, $val);

    // Update the lead record with the new value
    $query = "UPDATE lead SET " . $_POST["column_name"] . "='" . $value . "' WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        echo 'Data Updated';
    }
}
