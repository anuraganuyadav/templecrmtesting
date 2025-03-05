<?php
require_once '../inc/config.php';
if (isset($_POST["user_name"])) {
    $user_name =  $_POST["user_name"];
    $data =  $_POST["data"];

    if ($data == 'lead') {
        //   delete response 
        $del = "UPDATE lead SET last_response = '' WHERE sales_person = '$user_name'";
        if (mysqli_query($conn, $del)) {

            $q = mysqli_query($db, "SELECT * FROM lead WHERE sales_person='$user_name'");
            while ($row = mysqli_fetch_array($q)) {
                // delete lead_notes notes 
                $query =  mysqli_query($db, "DELETE FROM lead_notes WHERE note_id = '" . $row["id"] . "'");
                // lead_status_history
                $query =  mysqli_query($db, "DELETE FROM lead_status_history WHERE status_id = '" . $row["id"] . "'");
                // reminder
                $query =  mysqli_query($db, "DELETE FROM reminder WHERE reminderID = '" . $row["id"] . "'");
            }
            echo '<span class="badge badge-success">Leda Data has been cleared of ' . $user_name . '</span>';
        }
    }

   elseif ($data == 'potential') {
        //   delete potential 
        $del = "UPDATE potential SET last_response = '' ,  status = ''  WHERE sales_person = '$user_name'";
        if (mysqli_query($conn, $del)) {

            $q = mysqli_query($db, "SELECT * FROM lead WHERE sales_person='$user_name'");
            while ($row = mysqli_fetch_array($q)) {
                // delete potential notes 
                $query =  mysqli_query($db, "DELETE FROM potential_notes WHERE note_id = '" . $row["id"] . "'");  
                // potential_status_history
                $query =  mysqli_query($db, "DELETE FROM potential_status_history WHERE status_id = '" . $row["id"] . "'");
                // reminder
                $query =  mysqli_query($db, "DELETE FROM reminder WHERE reminderID = '" . $row["id"] . "'");
            }
            echo '<span class="badge badge-success">Potential Data has been cleared of ' . $user_name . '</span>';
        }
    }
}
