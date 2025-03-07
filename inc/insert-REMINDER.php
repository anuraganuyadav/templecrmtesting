<?php
require_once 'config.php';

if (isset($_POST["name"])) {
    // Sanitize input data
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $note = mysqli_real_escape_string($conn, $_POST["note"]);
    $date = mysqli_real_escape_string($conn, $_POST["date"]);
    $time = mysqli_real_escape_string($conn, $_POST["time"]);
    $DataID = mysqli_real_escape_string($conn, $_POST["DataID"]);
    $sales_person = mysqli_real_escape_string($conn, $_POST["sales"]);
    $page = mysqli_real_escape_string($conn, $_POST["page"]);

    // Check if 'remark' exists and sanitize it, if not set it to NULL
    $remark = isset($_POST["remark"]) ? mysqli_real_escape_string($conn, $_POST["remark"]) : null;

    // Get current timestamp
    $timestamp = date('Y-m-d H:i:s');

    // Query to get all reminders based on 'name' (ordered by reminderID DESC)
    $check_reminder_query = "SELECT * FROM reminder WHERE name = '$name' ORDER BY reminderID DESC";
    $check_reminder_result = mysqli_query($conn, $check_reminder_query);

    if ($check_reminder_result) {
        $reminders = mysqli_fetch_all($check_reminder_result, MYSQLI_ASSOC);

        // If there are previous reminders, we need to check the most recent one
        if (count($reminders) > 0) {
            // Loop through all reminders to check if any previous reminder has no remark
            foreach ($reminders as $previous_reminder) {
                if (empty($previous_reminder['remark'])) {
                    // If any previous reminder doesn't have a remark, we block the new reminder
                    if (empty($remark)) {
                        echo 'Please fill in the remark of the previous reminder before adding a new one.';
                        exit;
                    }
                    break; // Exit the loop once we find the first reminder without a remark
                }
            }
        }
        // If no previous reminder exists (first reminder), we don’t need to check for a remark
    } else {
        echo 'Error fetching previous reminders: ' . mysqli_error($conn);
        exit;
    }

    // Insert the new reminder into the database
    $query = "INSERT INTO reminder (reminderID, name, note, date, time, sales_person, page, created_date, reminder_date, remark) 
              VALUES ('$DataID', '$name', '$note', '$date', '$time:00', '$sales_person', '$page', '$timestamp', '$date $time:00', '$remark')";

    if (mysqli_query($conn, $query)) {
        echo 'Reminder set successfully';
    } else {
        echo 'Error setting reminder: ' . mysqli_error($conn);
    }
}
