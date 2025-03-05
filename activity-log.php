<?php
error_reporting(0);
ini_set('display_errors', 0);

require_once 'inc/session.php';

if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
  header('location:login.php?lmsg=true');
  exit;
}
//identyfied
if ($_SESSION['user_role_id'] != 1 && $_SESSION['user_role_id'] != 2) {

  header("Location:index.php");
}


//for deleted
include "inc/config.php";
if (isset($_GET['delete_id'])) {


  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM lead WHERE id =:uid');
  $stmt_delete->bindParam(':uid', $_GET['delete_id']);
  $stmt_delete->execute();

  //		header("Location:menu_management.php");
}


//page veryfied by user status
$getUser = mysqli_query($conn, "SELECT status from users where userID = " . $_SESSION['userID'] . "");
$getStatus = mysqli_fetch_array($getUser);
if ($getStatus['status'] == 0) {
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title>Activity Log</title>
    <?php include_once("layouts/header.php"); ?>
    <!-- Datatable CSS -->
    <link href='asset/DataTables/datatables.min.css' rel='stylesheet' type='text/css'>
    <!-- Datatable JS -->
    <script src="asset/DataTables/datatables.min.js"></script>

    <!-- Date-time picker css -->
    <link rel="stylesheet" type="text/css" href="asset/date-range/dist/duDatepicker.min.css">
    <link rel="stylesheet" type="text/css" href="asset/date-range/dist/duDatepicker-theme.css">
  </head>

  <body id="page-top">
    <?php include_once("layouts/sidebar.php"); ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <?php include_once("layouts/nav.php"); ?>
      <!-- Begin Page Content -->
      <!-- Begin Page Content -->
      <div class="container-fluid p-0">
        <!-- call back  -->
        <button onclick="callBack()" class="back-btn"> Back </button>
        <br>  <br>
 
        <!-- Table -->
        <table id='fetchTable' class='display dataTable mt-4'>
          <thead>
            <tr>
              <th>Name</th> 
              <th>Login Time</th> 
            </tr>
          </thead>
        </table>
      </div>

      <!-- Script -->
      <script>
        $(document).ready(function() {
          var dataTable = $('#fetchTable').DataTable({
            'processing': true,
            'serverSide': true,
            "responsive": true,  
            "scrollY": 350,
            "order": [],
            "pagingType": "full_numbers",
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url': 'load-data/activity-log-ajax.php',
              'data': function(data) {
                // Read values 
              }
            },
          }); 
            dataTable.draw();
          
        });
      </script>

      <script type="text/javascript" src="asset/date-range/dist/duDatepicker.min.js"></script>
    </div>

    <?php
    include_once("layouts/footer.php");
  } else {
    echo "<h4>You can't acccess this page </h4>";
  }
    ?>>