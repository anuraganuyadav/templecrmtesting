<?php
// require_once '../../inc/config.php';
// if (isset($_POST["id"])) {

//      if ($_POST["column_name"] == "status") {
//           mysqli_query($conn, "INSERT INTO potential_status_history(status_detail, status_id, status_date ) VALUES('" . $_POST["value"] . "', '" . $_POST["id"] . "', '$timestamp')");
//           // update last activity 
//           mysqli_query($conn, "UPDATE potential SET last_activity = '$timestamp' , last_activity = '$timestamp'  WHERE id= ".$_POST["id"]."");
//      }

//      if ($_POST["column_name"] == "sales_person") {
//           // update last activity 
//           mysqli_query($conn, "UPDATE potential SET date = '$timestamp' WHERE id= ".$_POST["id"]."");
//      }



//      $value = mysqli_real_escape_string($conn, $_POST["value"]);
//      $query = "UPDATE potential SET " . $_POST["column_name"] . "='" . $value . "' WHERE id = '" . $_POST["id"] . "'";
//      if (mysqli_query($conn, $query)) {
//           echo 'Updated Done';
//      }
// }



// Include your database configuration
require_once '../../inc/config.php';

// Start the session if not already started
session_start();

// Ensure timestamp is set
$timestamp = date('Y-m-d H:i:s');

// Initialize a variable to track the status of the update
$response_message = "Update successful!";

// Check if 'id' is set in POST request
if (isset($_POST["id"])) {
     $id = mysqli_real_escape_string($conn, $_POST["id"]);

     // Handle 'status' column update
     if ($_POST["column_name"] == "status") {
          $status_value = mysqli_real_escape_string($conn, $_POST["value"]);

          // Check if the user is an admin
          if ($_SESSION['user_role_id'] == 1 || $_SESSION['user_role_id'] == 2) {
               // Append 'by admin' with a space between status_detail and '(Admin)'
               $status_value .= " (  Admin)";
          }

          // Insert the status change into the history table
          $query = "INSERT INTO potential_status_history (status_detail, status_id, status_date) 
                  VALUES ('$status_value', '$id', '$timestamp')";

          if (!mysqli_query($conn, $query)) {
               $response_message = "Error inserting status history: " . mysqli_error($conn);
          } else {
               // Update last activity timestamp for the potential record
               $updateQuery = "UPDATE potential SET last_activity = '$timestamp' WHERE id= $id";
               if (!mysqli_query($conn, $updateQuery)) {
                    $response_message = "Error updating last activity: " . mysqli_error($conn);
               }
          }
     }

     // Handle 'sales_person' column update
     if ($_POST["column_name"] == "sales_person") {
          $updateQuery = "UPDATE potential SET date = '$timestamp' WHERE id= $id";
          if (!mysqli_query($conn, $updateQuery)) {
               $response_message = "Error updating salesperson: " . mysqli_error($conn);
          }
     }

     // Sanitize the input value for updating any other fields
     $value = mysqli_real_escape_string($conn, $_POST["value"]);

     // Update the column specified by the POST data
     $query = "UPDATE potential SET " . $_POST["column_name"] . "='" . $value . "' WHERE id = $id";
     if (!mysqli_query($conn, $query)) {
          $response_message = "Error updating potential: " . mysqli_error($conn);
     }
}

// Output the response message (only one message at the end)
echo $response_message;
