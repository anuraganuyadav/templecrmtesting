<?php
require_once 'config.php';
session_start();  // Ensure session is started to check user role

// Check if the user is an admin (role_id == 2)
if ($_SESSION['user_role_id'] != 2) {
    echo 'Not Authorized to perform this action! Please contact Admin';
    exit();  // Stop the script if the user is not authorized
}

// Check if ID is provided
if (isset($_POST["id"])) {
    $id = mysqli_real_escape_string($conn, $_POST["id"]);

    // Prepare the DELETE query using a prepared statement
    $query = "DELETE FROM reminder WHERE id = ?";

    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind the id parameter to the prepared statement
        mysqli_stmt_bind_param($stmt, "i", $id);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo 'Data Deleted';  // Success message
        } else {
            echo 'Error deleting record: ' . mysqli_error($conn);  // Handle any errors
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        echo 'Error preparing statement: ' . mysqli_error($conn);  // Error preparing query
    }
} else {
    echo 'No ID provided.';  // Handle the case where no ID is passed
}
