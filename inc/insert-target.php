<?php
require_once('config.php');
require_once 'session.php';
$user_name = $_SESSION['user_name'];

if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
  header('location:login.php?lmsg=true');
  exit;
}
//identyfied
if ($_SESSION['user_role_id'] != 1 && $_SESSION['user_role_id'] != 2) {
  header("Location:index.php");
}


if (isset($_POST["userID"])) {
  if (!empty($_POST["userID"])) {
    $target = $_POST['target'];
    $userID = $_POST['userID'];
    $Fdate = $_POST['Fdate'];
    $Ldate = $_POST['Ldate'];




    // check target 
    $targDay = mysqli_query($conn, "SELECT * FROM manage_sales_target WHERE userID ='$userID'");
    $targetDays = mysqli_fetch_array($targDay);
    $count = mysqli_num_rows($targDay);
    // target date calculate  
    if ($count > 0) {

      //get minimum days
      date_default_timezone_set('Asia/Kolkata');
      $times = date('Y/m/d');
      $today = strtotime($times);
      $start = strtotime($targetDays['Fdate']);
      $end = strtotime($targetDays['Ldate']);
      $dayDiff = abs($end - $today);
      $midays = $dayDiff / 86400;  // 86400 seconds in one day

      $first = strtotime($_POST['Fdate']);
      $last = strtotime($_POST['Ldate']);

      if ($today > $first) {

        echo "<span class='text-danger font-weight-bold'> Past date Not allow In Start Date  </span>";
      } else if ($end < $last) {
        echo "<span class='text-danger font-weight-bold'>The target of this user is not yet finished, it has $midays days left.  </span>";
      } else if ($today < $first) {

        // get user name 
        $u = mysqli_query($conn, "SELECT * FROM users WHERE userID ='$userID'");
        $getu = mysqli_fetch_array($u);
        $name = $getu['user_name'];

        $query = "INSERT INTO manage_sales_target (userID,name,Fdate,Ldate,target) VALUES('$userID','$name','$Fdate','$Ldate','$target')";

        if (mysqli_query($conn, $query)) {
          echo "<span class='text-success'>Apply Successfully</span>";
        } else {
          echo "<span class='text-danger'>Something went wrong</span>";
        }
      }
    } else {
      // get user name 
      $u = mysqli_query($conn, "SELECT * FROM users WHERE userID ='$userID'");
      $getu = mysqli_fetch_array($u);
      $name = $getu['user_name'];

      $query = "INSERT INTO manage_sales_target (userID,name,Fdate,Ldate,target) VALUES('$userID','$name','$Fdate','$Ldate','$target')";

      if (mysqli_query($conn, $query)) {
        echo "<span class='text-success'>Apply Successfully</span>";
      } else {
        echo "<span class='text-danger'>Something went wrong</span>";
      }
    }
  }
}
