<?php
require_once 'config.php';
if(isset($_POST["name"]))
{
 $name = mysqli_real_escape_string($conn, $_POST["name"]);
 $note = mysqli_real_escape_string($conn, $_POST["note"]);
 $date = mysqli_real_escape_string($conn, $_POST["date"]);
 $time = mysqli_real_escape_string($conn, $_POST["time"]);
 $DataID = mysqli_real_escape_string($conn, $_POST["DataID"]);
 $sales_person = mysqli_real_escape_string($conn, $_POST["sales"]);
 $page = mysqli_real_escape_string($conn, $_POST["page"]);
// $destination = mysqli_real_escape_string($conn, $_POST["destination"]);
// $no_person = mysqli_real_escape_string($conn, $_POST["no_person"]);
// $LeadSource = mysqli_real_escape_string($conn, $_POST["LeadSource"]);
// $date = mysqli_real_escape_string($conn, $_POST["date"]);
// $sales_person = mysqli_real_escape_string($conn, $_POST["sales_person"]); 
    
    
 $query = "INSERT INTO reminder (reminderID, name, note, date, time, sales_person,page, created_date, reminder_date) VALUES('$DataID', '$name', '$note', '$date', '$time:00', '$sales_person', '$page', '$timestamp', '$date $time:00')";
 if(mysqli_query($conn, $query))
 {
  echo 'Reminder set successfully';
 }
}
?>

<!--   if(name != '' && note != '' && time != '' && destination != ''&& no_person != ''&& LeadSource != ''&& date != ''&& sales_person != '')-->